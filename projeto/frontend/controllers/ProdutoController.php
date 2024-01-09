<?php

namespace frontend\controllers;

use common\models\Categoria;
use common\models\Imagem;
use common\models\Produto;
use common\models\ProdutoSearch;
use Yii;
use yii\data\Pagination;
use yii\filters\AccessControl;
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
    // Método que permite definir o que o utilizador tem permissão para fazer
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
                'access' => [
                    'class' => AccessControl::className(),
                    'rules' => [
                        [
                            'actions' => ['detalhes', 'categoriamedicamentossemreceita', 'categoriamedicamentoscomreceita', 'categoriasaudeoral',
                                'categoriabensbeleza', 'categoriahigiene', 'categoriaservicos'],
                            'allow' => true,
                            'roles' => ['cliente'],
                        ],
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
    // Método que vai para a página de detalhes do produto escolhido
    public function actionDetalhes($id)
    {
        $produtoDetalhes = Produto::findOne($id);

        if ($produtoDetalhes) {
            $imagemArray = [];

            if (($produtoDetalhes->prescricao_medica) === 1) {
                $receitaMedica = "Sim";
            } else {
                $receitaMedica = "Não";
            }

            $precoFinal = ($produtoDetalhes->preco) + (($produtoDetalhes->preco) * ($produtoDetalhes->iva->percentagem / 100));

            $imagens = Imagem::find()->where(['produto_id' => $id])->all();
            foreach ($imagens as $imagem) {
                $imagem->filename = Yii::getAlias('@web') . '/uploads/' . $imagem->filename;
                $imagemArray[] = $imagem->filename;
            }

            return $this->render('detalhes', [
                'produtoDetalhes' => $produtoDetalhes,
                'receitaMedica' => $receitaMedica,
                'precoFinal' => $precoFinal,
                'imagemArray' => $imagemArray,
            ]);
        }
        throw new NotFoundHttpException('Ocorreu um erro ao tentar aceder a esta página.');
    }


    // Método que vai para a página onde mostra todos os produtos sem receita médica
    public function actionCategoriamedicamentossemreceita()
    {
        $categoriaMedicamentos = Produto::find()->where(['prescricao_medica' => 0]);

        if ($categoriaMedicamentos) {
            $paginacao = new Pagination(['defaultPageSize' => 20, 'totalCount' => $categoriaMedicamentos->count()]);

            $produtos = $categoriaMedicamentos->offset($paginacao->offset)->limit($paginacao->limit)->all();

            $imagens = [];
            foreach ($produtos as $produto) {
                $primeiraImagem = $produto->getImagens()->orderBy(['id' => SORT_ASC])->one();
                if ($primeiraImagem) {
                    $imagens[$produto->id] = $primeiraImagem;
                }
            }
            return $this->render('medicamentos', ['produtos' => $produtos, 'paginacao' => $paginacao, 'imagens' => $imagens]);
        }
        throw new NotFoundHttpException('Ocorreu um erro ao tentar aceder a esta página.');
    }


    // Método que vai para a página onde mostra todos os produtos com receita médica
    public function actionCategoriamedicamentoscomreceita()
    {
        $categoriaMedicamentos = Produto::find()->where(['prescricao_medica' => 1]);

        if ($categoriaMedicamentos) {
            $paginacao = new Pagination(['defaultPageSize' => 20, 'totalCount' => $categoriaMedicamentos->count()]);

            $produtos = $categoriaMedicamentos->offset($paginacao->offset)->limit($paginacao->limit)->all();

            $imagens = [];
            foreach ($produtos as $produto) {
                $primeiraImagem = $produto->getImagens()->orderBy(['id' => SORT_ASC])->one();
                if ($primeiraImagem) {
                    $imagens[$produto->id] = $primeiraImagem;
                }
            }
            return $this->render('medicamentos', ['produtos' => $produtos, 'paginacao' => $paginacao, 'imagens' => $imagens]);
        }
        throw new NotFoundHttpException('Ocorreu um erro ao tentar aceder a esta página.');
    }

    // Método que vai para a página onde mostra todos os produtos com receita médica
    public function actionCategoriasaudeoral()
    {
        $categoria = Categoria::find()->where(['descricao' => 'saude_oral'])->one();

        if ($categoria != null) {
            $categoriaMedicamentos = Categoria::findOne(['descricao' => 'saude_oral']);

            $queryProdutos = Produto::find()
                ->where(['categoria_id' => $categoriaMedicamentos->id]);

            $paginacao = new Pagination(['defaultPageSize' => 20, 'totalCount' => $queryProdutos->count()]);

            $produtos = $queryProdutos->offset($paginacao->offset)->limit($paginacao->limit)->all();

            $imagens = [];
            foreach ($produtos as $produto) {
                $primeiraImagem = $produto->getImagens()->orderBy(['id' => SORT_ASC])->one();
                if ($primeiraImagem) {
                    $imagens[$produto->id] = $primeiraImagem;
                }
            }

            return $this->render('medicamentos', ['produtos' => $produtos, 'paginacao' => $paginacao, 'imagens' => $imagens]);
        }
        throw new NotFoundHttpException('Ocorreu um erro ao tentar aceder a esta página.');
    }

    // Método que vai para a página onde mostra todos os produtos da categoria de bens de beleza
    public function actionCategoriabensbeleza()
    {
        $categoria = Categoria::find()->where(['descricao' => 'bens_beleza'])->one();

        if ($categoria != null) {
            $categoriaMedicamentos = Categoria::findOne(['descricao' => 'bens_beleza']);

            $queryProdutos = Produto::find()->where(['categoria_id' => $categoriaMedicamentos->id]);

            $paginacao = new Pagination(['defaultPageSize' => 20, 'totalCount' => $queryProdutos->count()]);

            $produtos = $queryProdutos->offset($paginacao->offset)->limit($paginacao->limit)->all();

            $imagens = [];
            foreach ($produtos as $produto) {
                $primeiraImagem = $produto->getImagens()->orderBy(['id' => SORT_ASC])->one();
                if ($primeiraImagem) {
                    $imagens[$produto->id] = $primeiraImagem;
                }
            }
            return $this->render('medicamentos', ['produtos' => $produtos, 'paginacao' => $paginacao, 'imagens' => $imagens]);
        }
        throw new NotFoundHttpException('Ocorreu um erro ao tentar aceder a esta página.');
    }

    // Método que vai para a página onde mostra todos os produtos da categoria de higiene
    public function actionCategoriahigiene()
    {
        $categoria = Categoria::find()->where(['descricao' => 'higiene'])->one();
        if ($categoria != null) {

            $categoriaMedicamentos = Categoria::findOne(['descricao' => 'Higiene']);

            $queryProdutos = Produto::find()
                ->where(['categoria_id' => $categoriaMedicamentos->id]);

            $paginacao = new Pagination(['defaultPageSize' => 20, 'totalCount' => $queryProdutos->count()]);

            $produtos = $queryProdutos->offset($paginacao->offset)->limit($paginacao->limit)->all();

            $imagens = [];
            foreach ($produtos as $produto) {
                $primeiraImagem = $produto->getImagens()->orderBy(['id' => SORT_ASC])->one();
                if ($primeiraImagem) {
                    $imagens[$produto->id] = $primeiraImagem;
                }
            }
            return $this->render('medicamentos', ['produtos' => $produtos, 'paginacao' => $paginacao, 'imagens' => $imagens]);
        }
        throw new NotFoundHttpException('Ocorreu um erro ao tentar aceder a esta página.');
    }
}