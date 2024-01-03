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
    public function actionIndex($produtoid)
    {
        $linhaCarrinho = new LinhaCarrinhoSearch();
        $dataProvider = $linhaCarrinho->search($this->request->queryParams);

        $quantidadeDisponivel = $this->actionQuantidade($produtoid);
        $produto = Produto::findOne($produtoid);

        return $this->render('index', [
            'linhaCarrinho' => $linhaCarrinho,
            'dataProvider' => $dataProvider,
            'produto' => $produto,
            'quantidadeDisponivel' => $quantidadeDisponivel
        ]);

    }

    public function actionQuantidade($produtoid)
    {
        $produto = Produto::findOne($produtoid);


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
    public function actionCreate($produtoid)
    {
        $LinhaCarrinho = new LinhaCarrinho();
        $userId = Yii::$app->user->id;

        $ultimoCarrinho = CarrinhoCompra::find()
            ->where(['cliente_id' => $userId, 'fatura_id' => null])
            ->orderBy(['dta_venda' => SORT_DESC])
            ->one();

        $produto = Produto::findOne($produtoid);

        $post = $this->request->post();
        $quantidade = 1;



            $verificaProdutoLinha = LinhaCarrinho::find()
                ->where(['carrinho_compra_id' => $ultimoCarrinho->id, 'produto_id' => $produtoid])
                ->one();

            if ($verificaProdutoLinha) {
                $quantidadeBd = $verificaProdutoLinha->quantidade; // Usar $verificaProdutoLinha aqui

                $quantidadeFinal = $quantidade + $quantidadeBd;
                $verificaProdutoLinha->quantidade = $quantidadeFinal;
                $verificaProdutoLinha->precounit = $produto->preco;

                $verificaProdutoLinha->valoriva = number_format($produto->preco * ($produto->iva->percentagem / 100), 2, '.');
                $verificaProdutoLinha->valorcomiva = number_format($verificaProdutoLinha->valoriva + $verificaProdutoLinha->precounit, 2, '.');
                $verificaProdutoLinha->subtotal = $verificaProdutoLinha->valorcomiva * $quantidade;

                $produto->quantidade = $produto->quantidade - $quantidade;

                if ($verificaProdutoLinha->save() && $produto->save()) {
                    return $this->redirect('..\carrinhocompra/index');
                }


            } else {
                $LinhaCarrinho->quantidade = $quantidade;
                $LinhaCarrinho->precounit = $produto->preco;

                $LinhaCarrinho->valoriva = number_format($produto->preco * ($produto->iva->percentagem / 100), 2, '.');
                $LinhaCarrinho->valorcomiva = number_format($LinhaCarrinho->valoriva + $LinhaCarrinho->precounit, 2, '.');
                $LinhaCarrinho->subtotal = $LinhaCarrinho->valorcomiva * $quantidade;

                $LinhaCarrinho->carrinho_compra_id = $ultimoCarrinho->id;
                $LinhaCarrinho->produto_id = $produtoid;
                $produto->quantidade = $produto->quantidade - $quantidade;

                if ($LinhaCarrinho->save() && $produto->save()) {
                    return $this->redirect('..\carrinhocompra/index');
                }
            }
        }



    /**
     * Updates an existing LinhaCarrinho model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $LinhaCarrinho = $this->findModel($id);
        $produto = $LinhaCarrinho->produto;
        $quantidadeBd = $LinhaCarrinho->quantidade;

        if ($this->request->isPost) {
            $post = $this->request->post();
            $quantidade = $post['quantidade'];

            // Verifica se a nova quantidade é menor ou igual à quantidade total já gasta
            if ($quantidade > $quantidadeBd) {
                // Verifica se há estoque disponível para a quantidade adicional desejada
                $quantidadeDisponivel = $produto->quantidade - ($quantidade - $quantidadeBd);
                if ($quantidadeDisponivel < 0) {
                    Yii::$app->session->setFlash('error', 'Não dispomos de artigos em quantidade suficiente para satisfazer o seu pedido.');
                    return $this->redirect(['carrinhocompra/index']);
                }
            }

            $LinhaCarrinho->quantidade = $quantidade;
            $LinhaCarrinho->precounit = $produto->preco;

            $LinhaCarrinho->valoriva = number_format($produto->preco * ($produto->iva->percentagem / 100), 2, '.');
            $LinhaCarrinho->valorcomiva = number_format($LinhaCarrinho->valoriva + $LinhaCarrinho->precounit, 2, '.');
            $LinhaCarrinho->subtotal = $LinhaCarrinho->valorcomiva * $quantidade;

            $quantidadeAlterada = $quantidade - $quantidadeBd;
            $produto->quantidade = $produto->quantidade - $quantidadeAlterada;

            if ($LinhaCarrinho->save() && $produto->save()) {
                return $this->redirect(['carrinhocompra/index']);
            }
        }
    }

    /**
     * Deletes an existing LinhaCarrinho model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $linhaCarrinho = $this->findModel($id);

        $quantidadeLinhaCarrinho = $linhaCarrinho->quantidade;
        $produto = $linhaCarrinho->produto;

        if ($linhaCarrinho->delete()) {
            if ($produto) {
                $produto->quantidade += $quantidadeLinhaCarrinho;
                $produto->save();
            }

            return $this->redirect(['carrinhocompra/index']);
        }
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
