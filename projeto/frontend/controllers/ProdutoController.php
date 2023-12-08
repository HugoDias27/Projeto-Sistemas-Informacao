<?php

namespace frontend\controllers;

use common\models\Categoria;
use common\models\Produto;
use common\models\ProdutoSearch;
use yii\data\Pagination;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ProdutoController implements the CRUD actions for Produto model.
 */
class ProdutoController extends Controller
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
     * Lists all Produto models.
     *
     * @return string
     */
    public function actionIndex($id)
    {
        //Obter os detalhes do produto pelo ID
        $produtoDetalhes = Produto::findOne($id);

        if ($produtoDetalhes) {
            //caso necessite de receita médica
            if (($produtoDetalhes->prescricao_medica) === 1) {
                $receitaMedica = "Sim";
            } else {
                $receitaMedica = "Não";
            }
            //calcular o preço do produto com o iva atribuído
            $precoFinal = ($produtoDetalhes->preco) + (($produtoDetalhes->preco) * ($produtoDetalhes->iva->percentagem / 100));

            //Apresenta na página de detalhes os dados pretendidos para o utilizador, consoante os campos selecionados no index
            return $this->render('index', ['produtoDetalhes' => $produtoDetalhes, 'receitaMedica' => $receitaMedica, 'precoFinal' => $precoFinal]);
        } else {
            //Caso apresente erro, apresentar mensagem de erro
            throw new \yii\web\NotFoundHttpException('Produto não encontrado.');
        }
    }

    public function actionCategoriamedicamentossemreceita()
    {
        // Busca a categoria 'Medicamentos'
        $categoriaMedicamentos = Produto::find()->where(['prescricao_medica' => 0]);

        if ($categoriaMedicamentos) {

            $paginacao = new Pagination([
                'defaultPageSize' => 20,
                'totalCount' => $categoriaMedicamentos->count(),
            ]);

            $produtos = $categoriaMedicamentos->offset($paginacao->offset)
                ->limit($paginacao->limit)
                ->all();

            return $this->render('medicamentos', [
                'produtos' => $produtos, // Corrigido para usar a variável de produtos encontrados
                'paginacao' => $paginacao
            ]);
        }
    }

    public function actionCategoriamedicamentoscomreceita()
    {
        // Busca a categoria 'Medicamentos'
        $categoriaMedicamentos = Produto::find()->where(['prescricao_medica' => 1]);

        if ($categoriaMedicamentos) {

            $paginacao = new Pagination([
                'defaultPageSize' => 20,
                'totalCount' => $categoriaMedicamentos->count(),
            ]);

            $produtos = $categoriaMedicamentos->offset($paginacao->offset)
                ->limit($paginacao->limit)
                ->all();

            return $this->render('medicamentos', [
                'produtos' => $produtos, // Corrigido para usar a variável de produtos encontrados
                'paginacao' => $paginacao
            ]);
        }
    }

    public function actionCategoriasaudeoral()
    {
        // Busca a categoria 'Medicamentos'
        $categoriaMedicamentos = Categoria::findOne(['descricao' => 'saudeOral']);

        if ($categoriaMedicamentos) {
            //
            $queryProdutos = Produto::find()
                ->where(['categoria_id' => $categoriaMedicamentos->id]);

            $paginacao = new Pagination([
                'defaultPageSize' => 20,
                'totalCount' => $queryProdutos->count(),
            ]);

            $produtos = $queryProdutos->offset($paginacao->offset)
                ->limit($paginacao->limit)
                ->all();

            return $this->render('medicamentos', [
                'produtos' => $produtos, // Corrigido para usar a variável de produtos encontrados
                'paginacao' => $paginacao
            ]);
        }
    }

    public function actionCategoriabensbeleza()
    {
        // Busca a categoria 'Medicamentos'
        $categoriaMedicamentos = Categoria::findOne(['descricao' => 'bensBeleza']);

        if ($categoriaMedicamentos) {
            //
            $queryProdutos = Produto::find()
                ->where(['categoria_id' => $categoriaMedicamentos->id]);

            $paginacao = new Pagination([
                'defaultPageSize' => 20,
                'totalCount' => $queryProdutos->count(),
            ]);

            $produtos = $queryProdutos->offset($paginacao->offset)
                ->limit($paginacao->limit)
                ->all();

            return $this->render('medicamentos', [
                'produtos' => $produtos, // Corrigido para usar a variável de produtos encontrados
                'paginacao' => $paginacao
            ]);
        }
    }

    public function actionCategoriahigiene()
    {
        // Busca a categoria 'Medicamentos'
        $categoriaMedicamentos = Categoria::findOne(['descricao' => 'higiene']);

        if ($categoriaMedicamentos) {
            //
            $queryProdutos = Produto::find()
                ->where(['categoria_id' => $categoriaMedicamentos->id]);

            $paginacao = new Pagination([
                'defaultPageSize' => 20,
                'totalCount' => $queryProdutos->count(),
            ]);

            $produtos = $queryProdutos->offset($paginacao->offset)
                ->limit($paginacao->limit)
                ->all();

            return $this->render('medicamentos', [
                'produtos' => $produtos, // Corrigido para usar a variável de produtos encontrados
                'paginacao' => $paginacao
            ]);
        }
    }

    public function actionCategoriaservicos()
    {
        // Busca a categoria 'Medicamentos'
        $categoriaMedicamentos = Categoria::findOne(['descricao' => 'servicos']);

        if ($categoriaMedicamentos) {
            //
            $queryProdutos = Produto::find()
                ->where(['categoria_id' => $categoriaMedicamentos->id]);

            $paginacao = new Pagination([
                'defaultPageSize' => 20,
                'totalCount' => $queryProdutos->count(),
            ]);

            $produtos = $queryProdutos->offset($paginacao->offset)
                ->limit($paginacao->limit)
                ->all();

            return $this->render('medicamentos', [
                'produtos' => $produtos, // Corrigido para usar a variável de produtos encontrados
                'paginacao' => $paginacao
            ]);
        }
    }
}