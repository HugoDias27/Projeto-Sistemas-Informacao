<?php

namespace backend\modules\api\controllers;

use backend\modules\api\components\CustomAuth;
use Yii;
use yii\data\ActiveDataProvider;
use yii\rest\ActiveController;

/**
 * Default controller for the `api` module
 */
class ProdutoController extends ActiveController
{
    public $modelClass = 'common\models\Produto';
    public $modelCategoria = 'common\models\Categoria';
    public $modelFornecedorProduto = 'common\models\FornecedorProduto';

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
        $categoriaModel = new $this->modelCategoria;

        if ($nomecategoria == 'medicamento_com_receita') {
            $queryProdutos = $produtoModel::find()->where(['prescricao_medica' => 1]);
            $produtosporCategoria = $queryProdutos->all();
            return $produtosporCategoria;

        } else if ($nomecategoria == 'medicamento_sem_receita') {
            $queryProdutos = $produtoModel::find()->where(['prescricao_medica' => 0]);
            $produtosporCategoria = $queryProdutos->all();
            return $produtosporCategoria;
        } else {
            $categoriaMedicamentos = $categoriaModel::findOne(['descricao' => $nomecategoria]);

            if ($categoriaMedicamentos) {
                $queryProdutos = $produtoModel::find()->where(['categoria_id' => $categoriaMedicamentos->id]);

                $produtosporCategoria = $queryProdutos->all();
                return $produtosporCategoria;
            }
        }
        throw new \yii\web\NotFoundHttpException('Categoria não encontrada.');
    }

    public function actionFornecedorproduto($nomeproduto)
    {
        $fornecedorProdutoModel = new $this->modelFornecedorProduto;
        $produtoModel = new $this->modelClass;

        $produto = $produtoModel::findOne(['nome' => $nomeproduto]);

        if ($produto) {
            $fornecedorProduto = $fornecedorProdutoModel::find()->where(['produto_id' => $produto->id])->with('fornecedor')->all();

            foreach ($fornecedorProduto as $fornecedor) {
                $fornecedores = $fornecedor->fornecedor;
            }

            return $fornecedores;
        }

        throw new \yii\web\NotFoundHttpException('Produto não encontrado.');
    }
}
