<?php

namespace backend\modules\api\controllers;

use backend\modules\api\components\CustomAuth;
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
        } else {
            return ['resposta' => false];
        }
    }


    public function actionUltimocarrinho($userid)
    {
        $linhaCarrinhoModel = new $this->modelClass;
        $CarrinhoCompraModel = new $this->modelClassCarrinho;

        $ultimoCarrinho = $CarrinhoCompraModel::find()
            ->where(['cliente_id' => $userid])
            ->andWhere(['fatura_id' => null])
            ->orderBy(['dta_venda' => SORT_DESC])
            ->one();

        if ($ultimoCarrinho !== null) {
            $linhasCarrinho = $linhaCarrinhoModel::find()
                ->where(['carrinho_compra_id' => $ultimoCarrinho->id])
                ->with('produto')
                ->all();

            $resultArray = [];
            foreach ($linhasCarrinho as $linha) {
                $produtoNome = $linha->produto->nome;

                $linhaCarrinhoArray = $linha->toArray();
                $linhaCarrinhoArray['produto_id'] = $produtoNome;
                $linhaCarrinhoArray['id'] = $linha->id;

                $resultArray[] = $linhaCarrinhoArray;
            }

            return $resultArray;
        }

        throw new \yii\web\NotFoundHttpException('Sem carrinhos.');
    }


    public function actionUpdatequantidade($idlinha)
    {
        $linhaCarrinhoModel = new $this->modelClass;

        $linhaCarrinho = $linhaCarrinhoModel::findOne(['id' => $idlinha]);
        $produto = $linhaCarrinho->produto;
        $quantidadeBd = $linhaCarrinho->quantidade;

        $request = Yii::$app->request;
        $quantidade = $request->getBodyParam('quantidade');

        // Verificar se a quantidade é menor ou igual à quantidade disponível
        $quantidadeDisponivel = $produto->quantidade + $quantidadeBd;
        if ($quantidade > $quantidadeDisponivel) {
            throw new \yii\web\NotFoundHttpException('Erro ao atualizar a linha do carrinho: quantidade indisponível.');
        } else {
            $quantidadeFinal = $quantidade - $quantidadeBd;
            $linhaCarrinho->quantidade = $quantidade;
            $linhaCarrinho->precounit = $produto->preco;

            $linhaCarrinho->valoriva = round($produto->preco * ($produto->iva->percentagem / 100), 2);
            $linhaCarrinho->valorcomiva = round($linhaCarrinho->valoriva + $linhaCarrinho->precounit, 2);
            $linhaCarrinho->subtotal = round($linhaCarrinho->valorcomiva * $quantidade, 2);
            $produto->quantidade = $produto->quantidade - $quantidadeFinal;

            if ($linhaCarrinho->save() && $produto->save()) {
                // Convertendo o modelo para um array e substituindo 'produto_id' pelo nome do produto
                $linhaCarrinhoArray = $linhaCarrinho->attributes;
                $linhaCarrinhoArray['produto_id'] = $produto->nome; // Supondo que o nome do produto seja armazenado em 'nome'

                return ['linhaCarrinho' => $linhaCarrinhoArray];
            }
        }
    }


    public function actionRemoverlinhacarrinho($idlinha)
    {
        $linhaCarrinhoModel = new $this->modelClass;
        $linhaCarrinho = $linhaCarrinhoModel::findOne(['id' => $idlinha]);

        if ($linhaCarrinho !== null) {
            $produto_id = $linhaCarrinho->produto_id;

            $produto = new $this->modelClassProduto;
            $produtoModel = $produto::findOne(['id' => $produto_id]);

            if ($produtoModel !== null) {
                $novaQuantidade = $produtoModel->quantidade + $linhaCarrinho->quantidade;
                $produtoModel->quantidade = $novaQuantidade;
                $produtoModel->save();

                $linhaCarrinho->delete();
                return ['success' => true, 'message' => 'Linha do carrinho removida com sucesso'];
            } else {
                return ['success' => false, 'message' => 'Produto não encontrado'];
            }
        } else {
            return ['success' => false, 'message' => 'Linha do carrinho não encontrada'];
        }
    }

    public function actionQuantidadeproduto($idlinha)
    {
        $linhaCarrinhoModel = new $this->modelClass;
        $linhaCarrinho = $linhaCarrinhoModel::findOne(['id' => $idlinha]);

        if ($linhaCarrinho !== null) {
            $produto_id = $linhaCarrinho->produto_id;

            $produto = new $this->modelClassProduto;
            $produtoQuantidade = $produto::findOne(['id' => $produto_id]);

            if ($produtoQuantidade !== null) {
                return ['quantidade' => $produtoQuantidade->quantidade, 'quantidadelinha' => $linhaCarrinho->quantidade];
            } else {
                return ['resposta' => false];
            }
        }
    }
}