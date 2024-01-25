<?php

namespace frontend\controllers;

use common\models\CarrinhoCompra;
use common\models\CarrinhoCompraSearch;
use common\models\Fatura;
use common\models\LinhaCarrinho;
use common\models\Produto;
use common\models\Profile;
use common\models\ReceitaMedica;
use common\models\User;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * CarrinhocompraController implements the CRUD actions for CarrinhoCompra model.
 */
class CarrinhocompraController extends Controller
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
                            'actions' => ['index', 'view', 'create', 'createcomreceita', 'update', 'delete', 'dados-entrega', 'concluir'],
                            'allow' => true,
                            'roles' => ['cliente'],
                        ],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all CarrinhoCompra models.
     *
     * @return string
     */
    // Método que vai para o index do carrinho de compras
    public function actionIndex()
    {
        $userId = Yii::$app->user->id;

        $carrinho = CarrinhoCompra::find()
            ->where(['cliente_id' => $userId, 'fatura_id' => null])
            ->orderBy(['id' => SORT_DESC])
            ->one();

        if ($carrinho !== null) {
            $linhasCarrinho = LinhaCarrinho::find()
                ->where(['carrinho_compra_id' => $carrinho->id]);

            $linhasCarrinho2 = LinhaCarrinho::find()
                ->where(['carrinho_compra_id' => $carrinho->id])->all();

            $dataProvider = new \yii\data\ActiveDataProvider([
                'query' => $linhasCarrinho,
            ]);

            $produtosComReceita = [];
            $produtoCodigo = [];

            foreach ($linhasCarrinho2 as $linha) {
                $produtoId = $linha->produto_id;
                $produto = Produto::findOne($produtoId);

                if ($produto !== null) {
                    $receitaMedica = ReceitaMedica::find()
                        ->where(['posologia' => $produtoId])
                        ->one();

                    if ($receitaMedica !== null) {
                        $produtosComReceita[] = $produto->nome;
                    }
                }
            }

            return $this->render('index', [
                'dataProvider' => $dataProvider,
                'produtosComReceita' => $produtosComReceita,
            ]);
        }

        throw new NotFoundHttpException('De momento, não tem nenhum carrinho de compras.');
    }


    // Método que vai para a página de dados de entrega
    public function actionDadosEntrega($valortotal)
    {
        return $this->render('dadosEntrega', ['valortotal' => $valortotal]);
    }


    /**
     * Creates a new CarrinhoCompra model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    // Método que permite criar o carrinho de compras
    public function actionCreate($produtoid)
    {
        $perfil = Profile::find()->where(['user_id' => Yii::$app->user->id])->one();

        if (!Yii::$app->user->isGuest) {
            if ($perfil == null) {
                Yii::$app->session->setFlash('error', 'Não tem perfil criado! Por favor, crie um perfil para poder comprar.');
                return $this->redirect(['profile/create', 'id' => Yii::$app->user->id]);
            } else {
                $userId = Yii::$app->user->id;
                $carrinhoCompras = new CarrinhoCompra();
                $produto = Produto::findOne($produtoid);

                if ($produto->quantidade != 0) {
                    $prescricao_medica = $produto->prescricao_medica;

                    if ($prescricao_medica == 0) {
                        $ultimoCarrinho = CarrinhoCompra::find()
                            ->where(['cliente_id' => $userId, 'fatura_id' => null])
                            ->orderBy(['dta_venda' => SORT_DESC])
                            ->one();

                        if ($ultimoCarrinho === null) { // Se não existir nenhum carrinho de compras
                            $carrinhoCompras->dta_venda = date('Y-m-d');
                            $carrinhoCompras->quantidade = 0;
                            $carrinhoCompras->valortotal = 0;
                            $carrinhoCompras->ivatotal = 0;
                            $carrinhoCompras->cliente_id = $userId;

                            if ($carrinhoCompras->save()) { // criar o carrinho de compras
                                return $this->redirect(['linhacarrinho/create', 'produtoid' => $produtoid]);
                            }
                        } else { // Se já existir um carrinho de compras adicionar o produto a esse carrinho
                            return $this->redirect(['linhacarrinho/create', 'produtoid' => $produtoid]);
                        }
                    } else { // Se o produto for com receita médica
                        return $this->redirect(['receitamedica/verificar', 'produtoid' => $produto->id]);
                    }
                } else { // Se o produto não existir
                    return $this->redirect(Yii::$app->getHomeUrl());
                }
            }
        } else { // Se o utilizador não estiver logado
            return $this->redirect(['/site/login']);
        }

        return $this->redirect(Yii::$app->getHomeUrl()); // caso não seja nenhuma das opções anteriores
    }


    // Método que permite criar o carrinho de compras com produtos com receita médica
    public function actionCreatecomreceita($produtoid, $receitamedicaid)
    {
        if (!Yii::$app->user->isGuest) {
            $userId = Yii::$app->user->id;
            $carrinhoCompras = new CarrinhoCompra();
            $produto = Produto::findOne($produtoid);

            if ($produto !== null) {
                $ultimoCarrinho = CarrinhoCompra::find()
                    ->where(['cliente_id' => $userId, 'fatura_id' => null])
                    ->orderBy(['dta_venda' => SORT_DESC])
                    ->one();

                if ($ultimoCarrinho === null) {
                    $carrinhoCompras->dta_venda = date('Y-m-d');
                    $carrinhoCompras->quantidade = 0;
                    $carrinhoCompras->valortotal = 0;
                    $carrinhoCompras->ivatotal = 0;
                    $carrinhoCompras->cliente_id = $userId;

                    if ($carrinhoCompras->save()) { // criar o carrinho de compras
                        return $this->redirect(['linhacarrinho/createreceita', 'produtoid' => $produtoid, 'receitamedicaid' => $receitamedicaid]);
                    }
                } else { // Se já existir um carrinho de compras adicionar o produto a esse carrinho
                    return $this->redirect(['linhacarrinho/createreceita', 'produtoid' => $produtoid, 'receitamedicaid' => $receitamedicaid]);
                }
            } else { // Se o produto não existir
                return $this->redirect(Yii::$app->getHomeUrl());
            }
        } else { // Se o utilizador não estiver logado
            return $this->redirect(['/site/login']);
        }
        return $this->redirect(Yii::$app->getHomeUrl()); // caso não seja nenhuma das opções anteriores
    }

    // Método que permite concluir a compra(gerar a fatura)
    public function actionConcluir()
    {
        $userid = Yii::$app->user->id;

        $ultimoCarrinho = CarrinhoCompra::find()
            ->where(['cliente_id' => $userid, 'fatura_id' => null])
            ->orderBy(['dta_venda' => SORT_DESC])
            ->one();

        if ($ultimoCarrinho !== null) {
            $linhasCarrinho = LinhaCarrinho::find()
                ->where(['carrinho_compra_id' => $ultimoCarrinho->id])
                ->all();

            $quantidadeTotal = 0;
            $valorTotal = 0;
            $ivaTotal = 0;

            foreach ($linhasCarrinho as $linha) {
                $quantidadeTotal += $linha->quantidade;
                $valorTotal += $linha->subtotal;
                $ivaTotal += $linha->valoriva;
            }

            $ultimoCarrinho->dta_venda = date('Y-m-d');
            $ultimoCarrinho->quantidade = $quantidadeTotal;
            $ultimoCarrinho->valortotal = $valorTotal;
            $ultimoCarrinho->ivatotal = $ivaTotal;

            $fatura = new Fatura();
            $fatura->valortotal = $valorTotal;
            $fatura->ivatotal = $ivaTotal;
            $fatura->dta_emissao = date('Y-m-d');
            $fatura->cliente_id = $ultimoCarrinho->cliente_id;
            $ultimoCarrinho->fatura_id = $fatura->id;

            if ($fatura->save()) {
                $ultimoCarrinho->fatura_id = $fatura->id;
                if ($ultimoCarrinho->save()) {
                    return $this->redirect(['dados-entrega', 'valortotal' => $valorTotal]);
                }
            }
        }
    }

    /**
     * Finds the CarrinhoCompra model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return CarrinhoCompra the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    // Método que permite encontrar o carrinho de compras selecionada
    protected function findModel($id)
    {
        if (($model = CarrinhoCompra::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}