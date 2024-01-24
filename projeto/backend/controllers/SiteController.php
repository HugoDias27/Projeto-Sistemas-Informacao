<?php

namespace backend\controllers;

use backend\models\Despesa;
use backend\models\Estabelecimento;
use common\models\Fatura;
use common\models\LinhaCarrinho;
use common\models\LoginForm;
use common\models\ReceitaMedica;
use Yii;
use yii\db\Query;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    // Método que permite definir o que o utilizador tem permissão para fazer
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'actions' => ['login', 'error'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    [
                        'actions' => ['index'],
                        'allow' => true,
                        'roles' => ['admin', 'funcionario'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => \yii\web\ErrorAction::class,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    // Método que vai para o index da página principal
    public function actionIndex()
    {
        $totalGastos = Despesa::find()->sum('preco');

        $primeiroDiaMesAtual = date('Y-m-01');
        $ultimoDiaMesAtual = date('Y-m-t');

        $faturas = Fatura::find()
            ->where(['between', 'dta_emissao', $primeiroDiaMesAtual, $ultimoDiaMesAtual])
            ->all();
        $n_compras = count($faturas);

        $totalGanho = Fatura::find()
            ->where(['between', 'dta_emissao', $primeiroDiaMesAtual, $ultimoDiaMesAtual])
            ->sum('valortotal');
        $totalGanhoArredondado = round($totalGanho, 2);

        $nomeEstabelecimentoComMaisVendas = Fatura::find()
            ->select(['estabelecimentos.nome'])
            ->innerJoin('estabelecimentos', 'faturas.estabelecimento_id = estabelecimentos.id')
            ->where(['between', 'dta_emissao', $primeiroDiaMesAtual, $ultimoDiaMesAtual])
            ->groupBy(['estabelecimentos.nome'])
            ->limit(1)
            ->scalar();


        $produtoVendido = LinhaCarrinho::find()
            ->select(['produtos.nome'])
            ->joinWith('produto')
            ->groupBy('linhas_carrinho.produto_id')
            ->orderBy(['SUM(linhas_carrinho.quantidade)' => SORT_DESC])
            ->limit(1)
            ->asArray()
            ->one();

        $produtoMaisVendido = $produtoVendido['nome'];

        if (!Yii::$app->user->isGuest) {
            $receitasMedicas = ReceitaMedica::find()->all();

            foreach ($receitasMedicas as $receitaMedica) {
                if (!empty($receitaMedica->data_validade) && strtotime($receitaMedica->data_validade) < strtotime(date('Y-m-d'))) {
                    $receitaMedica->valido = 0;
                    $receitaMedica->save();
                }
            }
        }

        return $this->render('index', [
            'totalGastos' => $totalGastos,
            'n_compras' => $n_compras,
            'totalGanho' => $totalGanhoArredondado,
            'estabelecimentoMaisVendas' => $nomeEstabelecimentoComMaisVendas,
            'produtoMaisVendido' => $produtoMaisVendido,
        ]);
    }
    /**
     * Login action.
     *
     * @return string|Response
     */
    // Método que faz o login
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $this->layout = 'blank';

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            $user_id = Yii::$app->user->identity->getId();
            $userRoles = Yii::$app->authManager->getRolesByUser($user_id);

            foreach ($userRoles as $role) {
                if ($role->name === 'admin' || $role->name === 'funcionario') {
                    return $this->goBack();
                } else {
                    Yii::$app->user->logout();
                    return $this->redirect('/projeto/frontend/web');
                }
            }
        }

        $model->password = '';

        return $this->render('login', ['model' => $model]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    // Método que faz o logout
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }
}
