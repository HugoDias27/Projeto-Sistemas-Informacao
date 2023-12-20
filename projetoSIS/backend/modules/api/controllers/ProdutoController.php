<?php

namespace backend\modules\api\controllers;

use backend\modules\api\components\CustomAuth;
use Yii;
use yii\rest\ActiveController;

/**
 * Default controller for the `api` module
 */
class ProdutoController extends ActiveController
{
    public $modelClass = 'common\models\Produto';
    public $modelCategoriaClass = 'common\models\Categoria';
    public $modelFornecedorProdutoClass = 'common\models\FornecedorProduto';
    public $modelIvaClass = 'common\models\Iva';


    public function behaviors()
    {
        Yii::$app->params['id'] = 0;
        Yii::$app->params['auth_key'] = 0;
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

    public function actionMedicamentos()
    {
        $produtoModel = new $this->modelClass;
        $produtos = $produtoModel::find()->select([
            'produtos.id',
            'produtos.nome',
            'produtos.prescricao_medica',
            'produtos.preco',
            'produtos.quantidade',
            'categorias.descricao AS categoria',
            'ivas.percentagem AS iva'
        ])
            ->join('LEFT JOIN', 'categorias', 'categorias.id = produtos.categoria_id')
            ->join('LEFT JOIN', 'ivas', 'ivas.id = produtos.iva_id')
            ->asArray()
            ->all();

        $Produtos = [];
        foreach ($produtos as $produto) {
            $prescricaoMedica = $produto['prescricao_medica'] == 1 ? 'Sim' : 'Não';

            $Produtos[] = [
                'id' => $produto['id'],
                'nome' => $produto['nome'],
                'prescricao_medica' => $prescricaoMedica,
                'preco' => $produto['preco'],
                'quantidade' => $produto['quantidade'],
                'categoria' => $produto['categoria'],
                'iva' => $produto['iva'],
            ];
        }

        return $Produtos;
    }


    public function actionImagens()
    {
        $produtoModel = new $this->modelClass;
        $produtosImagens = $produtoModel::find()->with('imagens')->all();

        if ($produtosImagens !== null) {
            $produtosImagensArray = [];
            foreach ($produtosImagens as $produto) {
                $produtoArray = $produto->attributes;
                $produtoArray['imagens'] = [];
                foreach ($produto->imagens as $imagem) {
                    $produtoArray['imagens'][] = $imagem->attributes;
                }
                $produtosImagensArray[] = $produtoArray;
            }
            return $produtosImagensArray;
        }
    }

    public function actionProdutoporcategoria($nomecategoria)
    {
        $produtoModel = new $this->modelClass;
        $categoriaModel = new $this->modelCategoriaClass;

        $categoriaMedicamentos = $categoriaModel::findOne(['descricao' => $nomecategoria]);

        if ($categoriaMedicamentos) {
            $produtosporCategoria = $produtoModel::find()->where(['categoria_id' => $categoriaMedicamentos->id])->all();

            return $produtosporCategoria;
        }

        throw new \yii\web\NotFoundHttpException('Categoria não encontrada.');
    }

    public function actionFornecedorproduto($nomeproduto)
    {
        $fornecedorProdutoModel = new $this->modelFornecedorProdutoClass;
        $produtoModel = new $this->modelClass;

        $produto = $produtoModel::findOne(['nome' => $nomeproduto]);

        if ($produto) {
            $fornecedorProduto = $fornecedorProdutoModel::find()->where(['produto_id' => $produto->id])->with('fornecedor')->all();

            foreach ($fornecedorProduto as $fornecedor) {
                $fornecedores = $fornecedor->fornecedor;
            }

            return $fornecedores;
        }

        throw new \yii\web\NotFoundHttpException('Produto(s) não encontrado.');
    }

    public function actionProdutoreceita($valor)
    {
        $produtoModel = new $this->modelClass;

        if ($valor == 'nao' || $valor == 'não' || $valor == 'Nao' || $valor == 'Não' || $valor == 'NAO' || $valor == 'NÃO') {
            $produtosReceita = $produtoModel::find()->where(['prescricao_medica' => 0])->all();

        } else if ($valor == 'sim' || $valor == 'Sim' || $valor == 'SIM') {
            $produtosReceita = $produtoModel::find()->where(['prescricao_medica' => 1])->all();
        }

        if($produtosReceita) {

            return $produtosReceita;
        }

        throw new \yii\web\NotFoundHttpException('Produto(s) não encontrado.');
    }
}
