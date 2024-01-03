<?php

namespace frontend\controllers;

use common\models\CarrinhoCompra;
use common\models\CarrinhoCompraSearch;
use common\models\Fatura;
use common\models\LinhaCarrinho;
use common\models\Produto;
use common\models\User;
use Yii;
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
            ]
        );
    }

    /**
     * Lists all CarrinhoCompra models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $userId = Yii::$app->user->id;

        $carrinho = CarrinhoCompra::find()->where(['cliente_id' => $userId, 'fatura_id' => null])
            ->orderBy(['id' => SORT_DESC]) // Ordenando pelo ID de forma descendente
            ->one();

        if ($carrinho !== null) {
            $linhasCarrinho = LinhaCarrinho::find()
                ->where(['carrinho_compra_id' => $carrinho->id]);

            $dataProvider = new \yii\data\ActiveDataProvider([
                'query' => $linhasCarrinho,
            ]);

            return $this->render('index', [
                'dataProvider' => $dataProvider,
            ]);
        }

        // Caso não exista carrinho válido
        throw new NotFoundHttpException('De momento, não tem nenhum carrinho de compras.');
    }

    public function actionDadosentrega()
    {
        return $this->redirect(Yii::$app->getHomeUrl());
    }


    /**
     * Displays a single CarrinhoCompra model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new CarrinhoCompra model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate($produtoid)
    {
        if (!Yii::$app->user->isGuest) {
            $userId = Yii::$app->user->id;
            $carrinhoCompras = new CarrinhoCompra();
            $produto = Produto::findOne($produtoid);

            if ($produto !== null) {
                $prescricao_medica = $produto->prescricao_medica;

                if ($prescricao_medica == 0) {
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

                        if ($carrinhoCompras->save()) {
                            return $this->redirect(['linhacarrinho/create', 'produtoid' => $produtoid]);
                        }
                    } else {
                        return $this->redirect(['linhacarrinho/create', 'produtoid' => $produtoid]);
                    }
                } else {
                    return $this->redirect(['receitamedica/verificar', 'produtoid' => $produto->id]);
                }
            } else {
                return $this->redirect(Yii::$app->getHomeUrl());
            }
        } else {
            return $this->redirect(['/site/login']);
        }
        return $this->redirect(Yii::$app->getHomeUrl());
    }

    public function actionCreatecomreceita($produtoid)
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

                    if ($carrinhoCompras->save()) {
                        return $this->redirect(['linhacarrinho/create', 'produtoid' => $produtoid]);
                    }
                } else {
                    return $this->redirect(['linhacarrinho/create', 'produtoid' => $produtoid]);
                }
            } else {
                return $this->redirect(Yii::$app->getHomeUrl());
            }
        } else {
            return $this->redirect(['/site/login']);
        }
        return $this->redirect(Yii::$app->getHomeUrl());
    }

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
                    //return $this->redirect(Yii::$app->getHomeUrl());
                    //return $this->redirect(['/carrinhocompra/dadosEntrega']);
                    return $this->render('dadosEntrega');
                }
            }
        }
    }


    /**
     * Updates an existing CarrinhoCompra model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing CarrinhoCompra model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public
    function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the CarrinhoCompra model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return CarrinhoCompra the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected
    function findModel($id)
    {
        if (($model = CarrinhoCompra::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
