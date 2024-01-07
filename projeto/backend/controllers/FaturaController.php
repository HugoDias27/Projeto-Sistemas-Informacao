<?php

namespace backend\controllers;

use backend\models\Estabelecimento;
use common\models\CarrinhoCompra;
use common\models\Fatura;
use common\models\FaturaSearch;
use common\models\LinhaCarrinho;
use common\models\LinhaFatura;
use common\models\Produto;
use common\models\Profile;
use common\models\ReceitaMedica;
use common\models\Servico;
use common\models\User;
use Mpdf\Mpdf;
use Yii;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * FaturaController implements the CRUD actions for Fatura model.
 */
class FaturaController extends Controller
{
    /**
     * @inheritDoc
     */
    // Método que permite definir o que o utilizador tem permissão para fazer
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
                'access' => [
                    'class' => AccessControl::className(),
                    'rules' => [
                        [
                            'actions' => ['index', 'create', 'update', 'delete', 'imprimir', 'view'],
                            'allow' => true,
                            'roles' => ['admin', 'funcionario'],
                        ],
                    ],
                ]
            ]
        );
    }

    /**
     * Lists all Fatura models.
     *
     * @return string
     */
    // Método que vai para o index das faturas
    public function actionIndex()
    {
        $searchModel = new FaturaSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        $dataProvider->query->joinWith('user');


        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,

        ]);
    }


    /**
     * Displays a single Fatura model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    // Método que vai para a view de uma fatura
    public function actionView($id)
    {
        if (\Yii::$app->user->can('viewFatura')) {
            $fatura = $this->findModel($id);

            $estabelecimento = Estabelecimento::find()->where(['id' => $fatura->estabelecimento_id])->one();

            $cliente = User::find()->where(['id' => $fatura->cliente_id])->one();
            $perfilCliente = $cliente->profiles;

            $linhasFatura = LinhaFatura::find()->where(['fatura_id' => $id])->all();

            $carrinho = CarrinhoCompra::find()->where(['fatura_id' => $id])->one();

            $servicosIds = ArrayHelper::getColumn($linhasFatura, 'servico_id');
            $servicos = Servico::find()->where(['id' => $servicosIds])->all();

            $receitasIds = ArrayHelper::getColumn($linhasFatura, 'receita_medica_id');
            $receitas = ReceitaMedica::find()->where(['id' => $receitasIds])->all();

            if ($carrinho !== null) {
                $carrinhoId = $carrinho->id;
                $linhasCarrinho = LinhaCarrinho::find()->where(['carrinho_compra_id' => $carrinhoId])->all();

                $produtos = [];
                foreach ($linhasCarrinho as $linhaCarrinho) {
                    $produto = Produto::find()->where(['id' => $linhaCarrinho->produto_id])->one();
                    if ($produto) {
                        $produtos[] = $produto;
                    }
                }

                return $this->render('view', [
                    'fatura' => $fatura,
                    'estabelecimento' => $estabelecimento,
                    'cliente' => $cliente,
                    'perfilCliente' => $perfilCliente,
                    'linhasFatura' => $linhasFatura,
                    'servicos' => $servicos,
                    'receitas' => $receitas,
                    'linhasCarrinho' => $linhasCarrinho,
                    'produtos' => $produtos,
                ]);
            } else {
                return $this->render('view', [
                    'fatura' => $fatura,
                    'estabelecimento' => $estabelecimento,
                    'cliente' => $cliente,
                    'perfilCliente' => $perfilCliente,
                    'linhasFatura' => $linhasFatura,
                    'servicos' => $servicos,
                    'receitas' => $receitas,
                ]);
            }
        }
        throw new NotFoundHttpException('Não tem permissões para aceder a esta página');
    }

    /**
     * Creates a new Fatura model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    // Método que permite criar uma nova fatura
    public function actionCreate()
    {
        if (\Yii::$app->user->can('createCategorias')) {

            $fatura = new Fatura();
            $estabelecimentos = Estabelecimento::find()->all();
            $estabelecimentosItems = ArrayHelper::map($estabelecimentos, 'id', 'nome');


            $authManager = Yii::$app->authManager;
            $clienteRole = $authManager->getRole('cliente');
            $clientes = User::find()
                ->innerJoin('auth_assignment', 'auth_assignment.user_id = user.id')
                ->andWhere(['auth_assignment.item_name' => $clienteRole->name])
                ->all();
            $clientesItems = ArrayHelper::map($clientes, 'id', 'username');

            if ($this->request->isPost) {
                $perfilEmissor = Profile::findOne(['user_id' => Yii::$app->user->id]);
                if (!$perfilEmissor) {
                    Yii::$app->session->setFlash('error', 'O utilizador não tem o perfil criado.');
                    return $this->redirect('index');
                }

                $fatura->dta_emissao = date('Y-m-d');
                $fatura->emissor_id = Yii::$app->user->id;
                $fatura->valortotal = 0;
                $fatura->ivatotal = 0;

                if ($fatura->load($this->request->post()) && $fatura->save()) {
                    $estabelecimento = $fatura->estabelecimento_id;
                    $cliente = $fatura->cliente_id;
                    return $this->redirect(['linhafatura/create', 'id_fatura' => $fatura->id, 'estabelecimento_id' => $estabelecimento, 'cliente' => $cliente]);
                }
            } else {
                $fatura->loadDefaultValues();
            }

            return $this->render('create', [
                'fatura' => $fatura,
                'estabelecimento' => $estabelecimentosItems,
                'cliente' => $clientesItems,
            ]);
        }
        throw new NotFoundHttpException('Não tem permissões para aceder a esta página');
    }

    // Método que permite editar uma fatura
    public function actionUpdate($id)
    {
        $fatura = Fatura::find()->where(['id' => $id])->one();

        $linhafatura = LinhaFatura::find()->where(['fatura_id' => $id])->one();
        $receitaMedicaid = $linhafatura->receita_medica_id;

        $receitaMedica = ReceitaMedica::find()->where(['id' => $receitaMedicaid])->one();

        if($receitaMedica) {
            $receitaMedica->valido = 0;
            $receitaMedica->save();
        }

        $fatura->save();
        return $this->redirect(['index']);
    }

    /**
     * Deletes an existing Fatura model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    // Método que permite apagar uma fatura
    public function actionDelete($id)
    {
        if (\Yii::$app->user->can('deleteFatura')) {
            $linhasFatura = LinhaFatura::find()->where(['fatura_id' => $id])->all();
            foreach ($linhasFatura as $linhaFatura) {
                $linhaFatura->delete();
            }
            $this->findModel($id)->delete();

            return $this->redirect(['index']);
        }
        throw new NotFoundHttpException('Não tem permissões para aceder a esta página');
    }

    //Método que permite imprimir uma fatura
    public function actionImprimir($id)
    {
        $fatura = $this->findModel($id);

        $estabelecimento = Estabelecimento::find()->where(['id' => $fatura->estabelecimento_id])->one();

        $cliente = User::find()->where(['id' => $fatura->cliente_id])->one();
        $perfilCliente = $cliente->profiles;

        $linhasFatura = LinhaFatura::find()->where(['fatura_id' => $id])->all();

        $carrinho = CarrinhoCompra::find()->where(['fatura_id' => $id])->one();

        $servicosIds = ArrayHelper::getColumn($linhasFatura, 'servico_id');
        $servicos = Servico::find()->where(['id' => $servicosIds])->all();

        $receitasIds = ArrayHelper::getColumn($linhasFatura, 'receita_medica_id');
        $receitas = ReceitaMedica::find()->where(['id' => $receitasIds])->all();

        if ($carrinho !== null) {
            $carrinhoId = $carrinho->id;
            $linhasCarrinho = LinhaCarrinho::find()->where(['carrinho_compra_id' => $carrinhoId])->all();

            $produtos = [];
            foreach ($linhasCarrinho as $linhaCarrinho) {
                $produto = Produto::find()->where(['id' => $linhaCarrinho->produto_id])->one();
                if ($produto) {
                    $produtos[] = $produto;
                }
            }

            $content = $this->renderPartial('impressao', [
                'fatura' => $fatura,
                'cliente' => $cliente,
                'estabelecimento' => $estabelecimento,
                'perfilCliente' => $perfilCliente,
                'linhasFatura' => $linhasFatura,
                'servicos' => $servicos,
                'receitas' => $receitas,
                'linhasCarrinho' => $linhasCarrinho,
                'produtos' => $produtos,
            ]);
        } else {
            $content = $this->renderPartial('impressao', [
                'fatura' => $fatura,
                'cliente' => $cliente,
                'estabelecimento' => $estabelecimento,
                'perfilCliente' => $perfilCliente,
                'linhasFatura' => $linhasFatura,
                'servicos' => $servicos,
                'receitas' => $receitas,
            ]);
        }

        $content = "<link rel='stylesheet' href='" . Yii::$app->request->baseUrl . "/estilos.css'> <div class='table-container'>" . $content . "</div>";
        $mpdf = new Mpdf();
        $mpdf->WriteHTML($content);
        $mpdf->Output('Fatura ' . $id . '.pdf', 'D');
    }

    /**
     * Finds the Fatura model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Fatura the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    // Método que permite encontrar a fatura selecionada
    protected function findModel($id)
    {
        if (($model = Fatura::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
