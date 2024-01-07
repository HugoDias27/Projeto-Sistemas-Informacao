<?php

namespace backend\modules\api\controllers;

use backend\modules\api\components\CustomAuth;
use common\models\LinhaCarrinho;
use common\models\Produto;
use Yii;
use yii\rest\ActiveController;

class LinhacarrinhoController extends ActiveController
{
    public $modelClass = 'common\models\LinhaCarrinho';
    public $modelClassProduto = 'common\models\Produto';
    public $modelClassCarrinho = 'common\models\CarrinhoCompra';
    public $modelClassFatura = 'common\models\Fatura';
    public $modelImagemClass = 'common\models\Imagem';


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

    public function actionCarrinhoproduto($userid, $produtoid, $quantidadeProduto)
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

        if ($produto->quantidade == 0 || $produto->quantidade < 0 || $produto->quantidade < $quantidadeProduto) {
            throw new \yii\web\NotFoundHttpException('Produto sem stock.');
        }

        if ($linhaCarrinhoModel) {
            $quantidadeBd = $linhaCarrinhoModel->quantidade;

            $quantidadeFinal = $quantidadeProduto + $quantidadeBd;
            $linhaCarrinhoModel->quantidade = $quantidadeFinal;
            $linhaCarrinhoModel->precounit = $produto->preco;

            $linhaCarrinhoModel->valoriva = number_format($produto->preco * ($produto->iva->percentagem / 100), 2, '.');
            $linhaCarrinhoModel->valorcomiva = number_format($linhaCarrinhoModel->valoriva + $linhaCarrinhoModel->precounit, 2, '.');
            $linhaCarrinhoModel->subtotal = $linhaCarrinhoModel->valorcomiva * $quantidadeProduto;

            $produto->quantidade = $produto->quantidade - $quantidadeProduto;
        } else {
            $linhaCarrinhoModel = new $this->modelClass;
            $linhaCarrinhoModel->quantidade = $quantidadeProduto;
            $linhaCarrinhoModel->precounit = $produto->preco;

            $linhaCarrinhoModel->valoriva = number_format($produto->preco * ($produto->iva->percentagem / 100), 2, '.');
            $linhaCarrinhoModel->valorcomiva = number_format($linhaCarrinhoModel->valoriva + $linhaCarrinhoModel->precounit, 2, '.');
            $linhaCarrinhoModel->subtotal = $linhaCarrinhoModel->valorcomiva * $quantidadeProduto;

            $linhaCarrinhoModel->carrinho_compra_id = $ultimoCarrinho->id;
            $linhaCarrinhoModel->produto_id = $produtoid;
            $produto->quantidade = $produto->quantidade - $quantidadeProduto;
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
                ->with('produto') // Carrega os dados do produto associado a cada linha do carrinho
                ->orderBy(['id' => SORT_ASC])
                ->all();

            $resultArray = [];
            foreach ($linhasCarrinho as $linha) {
                $produtoNome = $linha->produto->nome;

                $imagemModel = new $this->modelImagemClass;
                $imagens = $imagemModel::find()->where(['produto_id' => $linha->produto_id])->all();

                if ($imagens) {
                    $imagensArray = 'http://10.0.2.2/projeto/backend/web/uploads/' . $imagens[0]->filename;
                } else {
                    $imagensArray = null;
                }

                $linhaCarrinhoArray = $linha->toArray();
                $linhaCarrinhoArray['produto_id'] = $produtoNome;
                $linhaCarrinhoArray['id'] = $linha->id;
                $linhaCarrinhoArray['imagens'] = $imagensArray;

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

    //Atualizar a quantidade do produto no carrinho de compras - API
    public function actionQuantidadeprodutocarrinho($idlinha, $quantidade)
    {
        $linhaCarrinhoModel = new $this->modelClass;

        $linhaCarrinho = $linhaCarrinhoModel::findOne(['id' => $idlinha]);
        $produto = $linhaCarrinho->produto;
        $quantidadeBd = $linhaCarrinho->quantidade;

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

                return ['success' => true, 'message' => 'Quantidade atualizada com sucesso'];
            }
        }

        return ['success' => false, 'message' => 'Quantidade não atualizada'];
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
                return ['quantidade' => $produtoQuantidade->quantidade, 'quantidadelinha' => $linhaCarrinho->quantidade, 'preco' => $linhaCarrinho->subtotal];
            } else {
                return ['resposta' => false];
            }
        }
    }

    public function actionProdutomaismvendido($dataInicio, $dataFim)
    {
        $produtoMaisVendido = LinhaCarrinho::find()
            ->select(['linhas_carrinho.produto_id', 'SUM(linhas_carrinho.quantidade) as totalVendas'])
            ->innerJoin('carrinho_compras', 'carrinho_compras.id = linhas_carrinho.carrinho_compra_id')
            ->andWhere(['between', 'carrinho_compras.dta_venda', $dataInicio, $dataFim])
            ->groupBy(['linhas_carrinho.produto_id'])
            ->orderBy(['totalVendas' => SORT_DESC])
            ->limit(1)
            ->one();


        if ($produtoMaisVendido) {
            $produtoId = $produtoMaisVendido['produto_id'];

            $produto = Produto::findOne($produtoId);

            if ($produto) {
                $produtoNome = $produto->nome;

                return $produtoNome;
            }
        }

        throw new \yii\web\NotFoundHttpException('Nenhum produto encontrado para o intervalo de tempo especificado.');
    }

    public function actionLinhascarrinho($faturaid)
    {
        $linhaCarrinhoModel = new $this->modelClass;
        $CarrinhoCompraModel = new $this->modelClassCarrinho;

        $carrinho = $CarrinhoCompraModel::find()
            ->where(['fatura_id' => $faturaid])
            ->one();

        if ($carrinho !== null) {
            $linhasCarrinho = $linhaCarrinhoModel::find()
                ->where(['carrinho_compra_id' => $carrinho->id])
                ->with('produto')
                ->all();

            $resultArray = [];
            foreach ($linhasCarrinho as $linha) {
                $linhaCarrinhoArray = $linha->toArray();

                $produto = $linha->produto;
                $produtoArray = $produto->toArray();

                $item = [
                    'id' => $linhaCarrinhoArray['id'],
                    'quantidade' => $linhaCarrinhoArray['quantidade'],
                    'precounit' => $linhaCarrinhoArray['precounit'],
                    'valoriva' => $linhaCarrinhoArray['valoriva'],
                    'valorcomiva' => $linhaCarrinhoArray['valorcomiva'],
                    'subtotal' => $linhaCarrinhoArray['subtotal'],
                    'carrinho_compra_id' => $linhaCarrinhoArray['carrinho_compra_id'],
                    'produto_id' => $produtoArray['nome'],
                ];

                $imagemModel = new $this->modelImagemClass;
                $primeiraImagem = $imagemModel::find()->where(['produto_id' => $produto->id])->one();

                if ($primeiraImagem !== null) {
                    $primeiraImagemUrl = 'http://10.0.2.2/projeto/backend/web/uploads/' . $primeiraImagem->filename;
                    $item['imagens'] = $primeiraImagemUrl;
                } else {
                    $item['imagens'] = null;
                }

                $resultArray[] = $item;
            }

            return $resultArray;
        }

        throw new \yii\web\NotFoundHttpException('Carrinho não encontrado para esta fatura.');
    }

    public function actionSubtotalultimocarrinho($userid)
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
                ->orderBy(['id' => SORT_ASC])
                ->all();

            $subtotalTotal = 0;

            foreach ($linhasCarrinho as $linha) {
                $subtotalLinha = $linha->quantidade * $linha->valorcomiva;

                $subtotalTotal += $subtotalLinha;
            }

            return ['subtotal' => $subtotalTotal];
        }

        throw new \yii\web\NotFoundHttpException('Sem carrinhos.');
    }


}