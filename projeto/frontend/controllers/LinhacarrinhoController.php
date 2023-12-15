<?php

namespace frontend\controllers;

use common\models\CarrinhoCompra;
use common\models\LinhaCarrinho;
use common\models\LinhaCarrinhoSearch;
use common\models\Produto;
use common\models\User;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * LinhacarrinhoController implements the CRUD actions for LinhaCarrinho model.
 */
class LinhacarrinhoController extends Controller
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
     * Lists all LinhaCarrinho models.
     *
     * @return string
     */
    public function actionIndex($id)
    {
        $model = new LinhaCarrinhoSearch();
        $dataProvider = $model->search($this->request->queryParams);

        $quantidadeDisponivel = $this->actionQuantidade($id);

        return $this->render('index', [
            'model' => $model,
            'dataProvider' => $dataProvider,
            'quantidadeDisponivel' => $quantidadeDisponivel
        ]);
    }

    public function actionQuantidade($id)
    {
        $produto = Produto::findOne($id);


        $quantidadeDisponivel = $produto->quantidade;

        if ($quantidadeDisponivel > 0) {
            return ($quantidadeDisponivel);
        } else {
            return 0;
        }

    }

    /**
     * Displays a single LinhaCarrinho model.
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
     * Creates a new LinhaCarrinho model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate($id, $quantidade)
    {
        $LinhaCarrinho = new LinhaCarrinho();

        $userId = Yii::$app->user->id;

        $ultimoCarrinho = CarrinhoCompra::find()
            ->where(['cliente_id' => $userId])
            ->orderBy([SORT_DESC])
            ->one();

        if ($ultimoCarrinho->fatura_id === null) {

            if ($this->request->isPost) {
                $LinhaCarrinho->load($this->request->post());
                if ($LinhaCarrinho->save()) {
                    $LinhaCarrinho->quantidade = $quantidade;
                    $LinhaCarrinho->precounit = $id->preco;
                    $LinhaCarrinho->valoriva = $id->iva->percentagem;
                    $LinhaCarrinho->valorcomiva = ($id->preco) + (($id->preco) * ($id->iva->percentagem / 100)) * $quantidade;
                    $LinhaCarrinho->subtotal = ($id->preco) + (($id->preco) * ($id->iva->percentagem / 100)) * $quantidade;
                    $LinhaCarrinho->carrinho_compra_id = $ultimoCarrinho->id;
                    $LinhaCarrinho->produto_id = $id;
                    if ($LinhaCarrinho->save()) {
                        return $this->redirect(['carrinhocompra']);
                    }

                }
            }
        } else {
            $NovoCarrinhoCompras = new CarrinhoCompra();

            $NovoCarrinhoCompras->quantidade = $quantidade;
            $NovoCarrinhoCompras->valortotal = $id->preco;
            $NovoCarrinhoCompras->ivatotal = $id->categoria->percentagem;
            $NovoCarrinhoCompras->cliente_id = User::findOne(Yii::$app->user->id);

            // Salvar o carrinho de compras
            if ($NovoCarrinhoCompras->save()) {
                //procurar o novo carrinho
                $Carrinho = CarrinhoCompra::find()
                    ->where(['cliente_id' => $userId])
                    ->orderBy([SORT_DESC])
                    ->one();

                $LinhaCarrinho->produto_id = $id;

                if ($this->request->isPost) {
                    $LinhaCarrinho->load($this->request->post());
                    if ($LinhaCarrinho->save()) {
                        $LinhaCarrinho->quantidade = $quantidade;
                        $LinhaCarrinho->precounit = $id->preco;
                        $LinhaCarrinho->valoriva = $id->iva->percentagem;
                        $LinhaCarrinho->valorcomiva = ($id->preco) + (($id->preco) * ($id->iva->percentagem / 100)) * $quantidade;
                        $LinhaCarrinho->subtotal = ($id->preco) + (($id->preco) * ($id->iva->percentagem / 100)) * $quantidade;
                        $LinhaCarrinho->carrinho_compra_id = $Carrinho->id;
                        $LinhaCarrinho->produto_id = $id;
                        if ($LinhaCarrinho->save()) {
                            return $this->redirect(['carrinhocompra']);
                        }

                    }
                }
            }
        }

        //return $this->render('create', ['model' => $model]);//, ['model' => $LinhaCarrinho]);
    }

    /**
     * Updates an existing LinhaCarrinho model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public
    function actionUpdate($id)
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
     * Deletes an existing LinhaCarrinho model.
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
     * Finds the LinhaCarrinho model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return LinhaCarrinho the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected
    function findModel($id)
    {
        if (($model = LinhaCarrinho::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
