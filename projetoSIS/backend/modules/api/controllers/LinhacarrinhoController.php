<?php

namespace backend\modules\api\controllers;

use backend\modules\api\components\CustomAuth;
use Yii;
use yii\rest\ActiveController;


class LinhacarrinhoController extends ActiveController
{
    //Variáveis dos Modelos
    public $modelClass = 'common\models\LinhaCarrinho';
    public $modelClassProduto = 'common\models\Produto';
    public $modelClassCarrinho = 'common\models\CarrinhoCompra';
    public $modelImagemClass = 'common\models\Imagem';
    public $modelClassLinhaFatura = 'common\models\LinhaFatura';


    //Método que chama o método de autenticação da API
    public function behaviors()
    {
        Yii::$app->params['id'] = 0;
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => CustomAuth::className(),
        ];
        return $behaviors;
    }

    //Método de autorização de o utilizador pode ou não aceder a uma determinada ação
    public function checkAccess($action, $model = null, $params = [])
    {
        if (Yii::$app->params['id'] == 1 || Yii::$app->params['id'] == 2) {
            if ($action === "create" || $action === "update" || $action === "delete" || $action === "index") {
                throw new \yii\web\ForbiddenHttpException('Proibido');
            }
        }
    }

    //Método que retorna o index
    public function actionIndex()
    {
        return $this->render('index');
    }

    //Método que cria o carrinho de compras e adiciona o produto à linha do carrinho - API
    public function actionCreatecarrinho($produtoid, $userid, $quantidade)
    {
        if (Yii::$app->params['id'] != 1 || Yii::$app->params['id'] != 2) {
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

                $linhaCarrinhoModel->valoriva = round($produto->preco * ($produto->iva->percentagem / 100), 2);
                $linhaCarrinhoModel->valorcomiva = round($linhaCarrinhoModel->valoriva + $linhaCarrinhoModel->precounit, 2);
                $linhaCarrinhoModel->subtotal = round($linhaCarrinhoModel->valorcomiva * $quantidade, 2);

                $produto->quantidade = $produto->quantidade - $quantidade;
            } else {
                $linhaCarrinhoModel = new $this->modelClass;
                $linhaCarrinhoModel->quantidade = $quantidade;
                $linhaCarrinhoModel->precounit = $produto->preco;

                $linhaCarrinhoModel->valoriva = round($produto->preco * ($produto->iva->percentagem / 100), 2);
                $linhaCarrinhoModel->valorcomiva = round($linhaCarrinhoModel->valoriva + $linhaCarrinhoModel->precounit, 2);
                $linhaCarrinhoModel->subtotal = round($linhaCarrinhoModel->valorcomiva * $quantidade, 2);

                $linhaCarrinhoModel->carrinho_compra_id = $ultimoCarrinho->id;
                $linhaCarrinhoModel->produto_id = $produtoid;
                $produto->quantidade = $produto->quantidade - $quantidade;
            }

            if ($linhaCarrinhoModel->save() && $produto->save()) {
                return ['resposta' => true];
            } else {
                return ['resposta' => false];
            }
        } else {
            throw new \yii\web\ForbiddenHttpException('Proibido');
        }
    }

    //Método que cria o carrinho de compras e adiciona o produto à linha do carrinho - CURL
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

    //Método que retorna o último carrinho de compras que ainda não foi finalizada a compra
    public function actionUltimocarrinho($userid)
    {
        if (Yii::$app->params['id'] != 1 || Yii::$app->params['id'] != 2) {
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
        } else {
            throw new \yii\web\ForbiddenHttpException('Proibido');
        }
    }


    //Método que atualiza a quantidade do produto na linha do carrinho de compras
    public function actionUpdatequantidade($idlinha)
    {
        if (Yii::$app->params['id'] != 1 || Yii::$app->params['id'] != 2) {
            $linhaCarrinhoModel = new $this->modelClass;

            $linhaCarrinho = $linhaCarrinhoModel::findOne(['id' => $idlinha]);
            $produto = $linhaCarrinho->produto;
            $quantidadeBd = $linhaCarrinho->quantidade;

            $request = Yii::$app->request;
            $quantidade = $request->getBodyParam('quantidade');

            $quantidadeDisponivel = $produto->quantidade + $quantidadeBd;
            if ($quantidade > $quantidadeDisponivel) {
                throw new \yii\web\NotFoundHttpException('Erro ao atualizar a linha do carrinho: quantidade indisponível.');
            } else if ($quantidade > 0) {
                $quantidadeFinal = $quantidade - $quantidadeBd;
                $linhaCarrinho->quantidade = $quantidade;
                $linhaCarrinho->precounit = $produto->preco;

                $linhaCarrinho->valoriva = round($produto->preco * ($produto->iva->percentagem / 100), 2);
                $linhaCarrinho->valorcomiva = round($linhaCarrinho->valoriva + $linhaCarrinho->precounit, 2);
                $linhaCarrinho->subtotal = round($linhaCarrinho->valorcomiva * $quantidade, 2);
                $produto->quantidade = $produto->quantidade - $quantidadeFinal;

                if ($linhaCarrinho->save() && $produto->save()) {
                    $linhaCarrinhoArray = $linhaCarrinho->attributes;
                    $linhaCarrinhoArray['produto_id'] = $produto->nome;

                    return ['linhaCarrinho' => $linhaCarrinhoArray];
                }
            }
            else {
                $quantidade = 1;
                $quantidadeFinal = $quantidade - $quantidadeBd;
                $linhaCarrinho->quantidade = $quantidade;
                $linhaCarrinho->precounit = $produto->preco;

                $linhaCarrinho->valoriva = round($produto->preco * ($produto->iva->percentagem / 100), 2);
                $linhaCarrinho->valorcomiva = round($linhaCarrinho->valoriva + $linhaCarrinho->precounit, 2);
                $linhaCarrinho->subtotal = round($linhaCarrinho->valorcomiva * $quantidade, 2);
                $produto->quantidade = $produto->quantidade - $quantidadeFinal;

                if ($linhaCarrinho->save() && $produto->save()) {
                    $linhaCarrinhoArray = $linhaCarrinho->attributes;
                    $linhaCarrinhoArray['produto_id'] = $produto->nome;

                    return ['linhaCarrinho' => $linhaCarrinhoArray];
                }
            }
        } else {
            throw new \yii\web\ForbiddenHttpException('Proibido');
        }
        throw new \yii\web\ForbiddenHttpException('Proibido');
    }


    //Método que atualiza a quantidade do produto na linha do carrinho de compras - CURL
    public function actionQuantidadeprodutocarrinho($idlinha, $quantidade)
    {
        if (Yii::$app->params['id'] != 1 || Yii::$app->params['id'] != 2) {
            $linhaCarrinhoModel = new $this->modelClass;

            $linhaCarrinho = $linhaCarrinhoModel::findOne(['id' => $idlinha]);
            $produto = $linhaCarrinho->produto;
            $quantidadeBd = $linhaCarrinho->quantidade;

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
                    $linhaCarrinhoArray = $linhaCarrinho->attributes;
                    $linhaCarrinhoArray['produto_id'] = $produto->nome;

                    return ['success' => true, 'message' => 'Quantidade atualizada com sucesso'];
                }
            }
            return ['success' => false, 'message' => 'Quantidade não atualizada'];
        } else {
            throw new \yii\web\ForbiddenHttpException('Proibido');
        }
    }


    //Método que elimina a linha do carrinho de compras
    public function actionRemoverlinhacarrinho($idlinha)
    {
        if (Yii::$app->params['id'] != 1 || Yii::$app->params['id'] != 2) {
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
                    return ['resposta' => true];
                } else {
                    return ['resposta' => false];
                }
            } else {
                return ['resposta' => false];
            }
        } else {
            throw new \yii\web\ForbiddenHttpException('Proibido');
        }
    }

    //Método que vai buscar a quantidade do produto, a quantidade que está na linha do carrinho e o subtotal total da linha
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

    //Método que retorna o produto mais vendido entre duas datas
    public function actionProdutomaismvendido($dataInicio, $dataFim)
    {
        $linhaCarrinhoModel = new $this->modelClass;
        $produtoModel = new $this->modelClassProduto;

        $produtoMaisVendido = $linhaCarrinhoModel::find()
            ->select(['linhas_carrinho.produto_id', 'SUM(linhas_carrinho.quantidade) as totalVendas'])
            ->innerJoin('carrinho_compras', 'carrinho_compras.id = linhas_carrinho.carrinho_compra_id')
            ->andWhere(['between', 'carrinho_compras.dta_venda', $dataInicio, $dataFim])
            ->groupBy(['linhas_carrinho.produto_id'])
            ->orderBy(['totalVendas' => SORT_DESC])
            ->limit(1)
            ->one();


        if ($produtoMaisVendido) {
            $produtoId = $produtoMaisVendido['produto_id'];

            $produto = $produtoModel::findOne($produtoId);

            if ($produto) {
                $produtoNome = $produto->nome;

                return $produtoNome;
            }
        }

        throw new \yii\web\NotFoundHttpException('Nenhum produto encontrado para o intervalo de tempo especificado.');
    }

    //Método que vai buscar as linhas do carrinho ou as linhas das faturas da respetiva fatura
    public function actionLinhascarrinho($faturaid)
    {
        $linhaCarrinhoModel = new $this->modelClass;
        $CarrinhoCompraModel = new $this->modelClassCarrinho;
        $linhaFaturaModel = new $this->modelClassLinhaFatura;


        $carrinho = $CarrinhoCompraModel::find()
            ->where(['fatura_id' => $faturaid])
            ->one();

        if ($carrinho !== null) {
            $resultArray = [];

            $linhasCarrinho = $linhaCarrinhoModel::find()
                ->where(['carrinho_compra_id' => $carrinho->id])
                ->with('produto')
                ->all();

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
        } else {
            $linhasFatura = $linhaFaturaModel::find()
                ->where(['fatura_id' => $faturaid])
                ->with('receitaMedica')
                ->with('servico')
                ->all();

            foreach ($linhasFatura as $linha) {
                $linhaFaturaArray = $linha->toArray();

                $servicoDescricao = '';
                if ($linha->servico != null) {
                    $servicoDescricao = $linha->servico->nome;
                }

                $receitaCodigo = '';
                if ($linha->receitaMedica != null) {
                    $receitaCodigo = $linha->receitaMedica->codigo;
                }

                if ($linha->receitaMedica !== null) {

                    $item = [
                        'id' => $linhaFaturaArray['id'],
                        'quantidade' => $linhaFaturaArray['quantidade'],
                        'precounit' => $linhaFaturaArray['precounit'],
                        'valoriva' => $linhaFaturaArray['valoriva'],
                        'valorcomiva' => $linhaFaturaArray['valorcomiva'],
                        'subtotal' => $linhaFaturaArray['subtotal'],
                        'carrinho_compra_id' => $linhaFaturaArray['receita_medica_id'],
                        'produto_id' => $receitaCodigo,
                        'imagens' => null,
                    ];
                } else {
                    $item = [
                        'id' => $linhaFaturaArray['id'],
                        'quantidade' => $linhaFaturaArray['quantidade'],
                        'precounit' => $linhaFaturaArray['precounit'],
                        'valoriva' => $linhaFaturaArray['valoriva'],
                        'valorcomiva' => $linhaFaturaArray['valorcomiva'],
                        'subtotal' => $linhaFaturaArray['subtotal'],
                        'carrinho_compra_id' => 0,
                        'produto_id' => $servicoDescricao,
                        'imagens' => null,
                    ];
                }
                $resultArray[] = $item;
            }
        }
        return $resultArray;
    }

    //Método que retorna o subtotal total do carrinho de compras
    public function actionSubtotalultimocarrinho($userid)
    {
        if (Yii::$app->params['id'] != 1 || Yii::$app->params['id'] != 2) {
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
        } else {
            throw new \yii\web\ForbiddenHttpException('Proibido');
        }
    }
}