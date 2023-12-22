<?php

namespace backend\modules\api\controllers;

use backend\modules\api\components\CustomAuth;
use common\models\CarrinhoCompra;
use common\models\LinhaCarrinho;
use common\models\Produto;
use Yii;
use yii\rest\ActiveController;

class LinhacarrinhoController extends ActiveController
{
    public $modelClass = 'common\models\LinhaCarrinho';
    public $modelClassProduto = 'common\models\Produto';
    public $modelClassCarrinho = 'common\models\CarrinhoCompra';


    public function behaviors()
    {
        Yii::$app->params['id'] = 0;
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => CustomAuth::className(),
        ];
        return $behaviors;
    }

    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionCreatecarrinho($produtoid, $userid, $quantidade)
    {
        $carrinhoCompraModel = new $this->modelClassCarrinho;
        $linhaCarrinhoModel = new $this->modelClass;
        $produtoModel = new $this->modelClassProduto;

        $ultimoCarrinho = $carrinhoCompraModel::find()
            ->where(['cliente_id' => $userid, 'fatura_id' => null])
            ->orderBy(['dta_venda' => SORT_DESC])
            ->one();

        $produto = $produtoModel::findOne($produtoid);

        $linhaCarrinhoModel = $linhaCarrinhoModel::find()
            ->where(['carrinho_compra_id' => $ultimoCarrinho->id, 'produto_id' => $produtoid])
            ->one();

        if ($produto->quantidade == 0 || $produto->quantidade < 0 || $produto->quantidade < $quantidade) {
            throw new \yii\web\NotFoundHttpException('Produto sem stock.');
        }

        if ($linhaCarrinhoModel) {
            $quantidadeBd = $linhaCarrinhoModel->quantidade;

            $quantidadeFinal = $quantidade + $quantidadeBd;
            $linhaCarrinhoModel->quantidade = $quantidadeFinal;
            $linhaCarrinhoModel->precounit = $produto->preco;

            $linhaCarrinhoModel->valoriva = $produto->preco * ($produto->iva->percentagem / 100);
            $linhaCarrinhoModel->valorcomiva = $linhaCarrinhoModel->valoriva + $linhaCarrinhoModel->precounit;
            $linhaCarrinhoModel->subtotal = $linhaCarrinhoModel->valorcomiva * $quantidade;

            $produto->quantidade = $produto->quantidade - $quantidade;
        } else {
            $linhaCarrinhoModel = new $this->modelClass;
            $linhaCarrinhoModel->quantidade = $quantidade;
            $linhaCarrinhoModel->precounit = $produto->preco;

            $linhaCarrinhoModel->valoriva = $produto->preco * ($produto->iva->percentagem / 100);
            $linhaCarrinhoModel->valorcomiva = $linhaCarrinhoModel->valoriva + $linhaCarrinhoModel->precounit;
            $linhaCarrinhoModel->subtotal = $linhaCarrinhoModel->valorcomiva * $quantidade;

            $linhaCarrinhoModel->carrinho_compra_id = $ultimoCarrinho->id;
            $linhaCarrinhoModel->produto_id = $produtoid;
            $produto->quantidade = $produto->quantidade - $quantidade;
        }

        if ($linhaCarrinhoModel->save() && $produto->save()) {
            return ['resposta' => true];
        }
        else {
            return ['resposta' => false];
        }
    }

}