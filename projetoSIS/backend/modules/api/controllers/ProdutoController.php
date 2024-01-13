<?php

namespace backend\modules\api\controllers;

use backend\modules\api\components\CustomAuth;
use Yii;
use yii\rest\ActiveController;
use yii\web\ForbiddenHttpException;

/**
 * Default controller for the `api` module
 */
class ProdutoController extends ActiveController
{
    //Variáveis dos Modelos
    public $modelClass = 'common\models\Produto';
    public $modelCategoriaClass = 'common\models\Categoria';
    public $modelFornecedorProdutoClass = 'common\models\FornecedorProduto';
    public $modelImagemClass = 'common\models\Imagem';
    public $modelIvaClass = 'common\models\Iva';
    public $modelFornecedorClass = 'common\models\Fornecedor';

    //Método que chama o método de autenticação da API
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

    //Método onde mostrar todos os dados dos produtos
    public function actionMedicamentos()
    {
        $userid = Yii::$app->params['id'];
        if ($userid == 1 || $userid == 2) {
            throw new \yii\web\ForbiddenHttpException('Proibido');
        } else {

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
                if ($produto['prescricao_medica'] == 0) {
                    $prescricaoMedica = $produto['prescricao_medica'] == 1 ? 'Sim' : 'Não';

                    $id = $produto['id'];

                    $primeiraImagem = null;

                    $imagemModel = new $this->modelImagemClass;
                    $imagens = $imagemModel::find()->where(['produto_id' => $id])->all();

                    if ($imagens) {
                        $primeiraImagemUrl = 'http://10.0.2.2/projeto/backend/web/uploads/' . $imagens[0]->filename;

                        $primeiraImagem = $primeiraImagemUrl;
                    }

                    $Produtos[] = [
                        'id' => $produto['id'],
                        'nome' => $produto['nome'],
                        'prescricao_medica' => $prescricaoMedica,
                        'preco' => $produto['preco'],
                        'quantidade' => $produto['quantidade'],
                        'categoria' => $produto['categoria'],
                        'iva' => $produto['iva'],
                        'imagens' => $primeiraImagem
                    ];
                }
            }
            return $Produtos;
        }
    }


    //Método onde mostra imagens dos produtos
    public function actionImagens()
    {
        $produtoModel = new $this->modelClass;
        $produtos = $produtoModel::find()->all();

        $produtosImagensArray = [];

        foreach ($produtos as $produto) {
            $produtoArray = $produto->attributes;
            $id = $produto['id'];

            $imagemModel = new $this->modelImagemClass;
            $imagens = $imagemModel::find()->where(['produto_id' => $id])->all();
            $produtoArray['imagens'] = [];

            foreach ($imagens as $imagem) {
                $imagemUrl = 'http://localhost/projeto/backend/web/uploads/' . $imagem->filename;
                $imagemArray = [
                    'url' => $imagemUrl,
                    'descricao' => $imagem->filename
                ];
                $produtoArray['imagens'][] = $imagemArray;
            }

            $produtosImagensArray[] = $produtoArray;
        }

        return $produtosImagensArray;
    }

    //Método para adicionar imagens ao produto - CURL
    public function actionAdicionarimagem($produto)
    {
        $imagemModel = $this->modelImagemClass;
        $imagem = new $imagemModel();
        $uploadForm = new UploadForm();

        if (Yii::$app->request->isPost) {
            $uploadForm->imageFiles = UploadedFile::getInstances($imagem, 'imageFiles');
            $uploadForm->produto_id = $produto;

            if ($uploadForm->upload()) {
                return ['success' => true, 'message' => 'Imagem adicionada com sucesso'];
            }
        }

        return ['success' => false, 'message' => 'Não foi possivel adicionar a imagem ao produto'];
    }

    //Método para editar a imagem ao produto - CURL
    public function actionEditarimagem($id, $produto)
    {
        $imagemModel = $this->modelClass;

        $imagem = $imagemModel::findOne(['id' => $id, 'produto_id' => $produto]);

        if ($imagem) {
            $uploadForm = new UploadForm();

            if (Yii::$app->request->isPost) {
                $uploadForm->imageFiles = UploadedFile::getInstances($imagem, 'imageFiles');

                if ($uploadForm->upload()) {
                    return ['success' => true, 'message' => 'Imagem editada com sucesso'];
                }
            }

            return ['success' => false, 'message' => 'Não foi possível editar a imagem'];
        }

        return ['success' => false, 'message' => 'Imagem não encontrada'];
    }


    //Método para apagar a imagem do produto - CURL
    public function actionApagarimagem($imagem, $produto)
    {
        $imagemModel = $this->modelImagemClass;

        $imagemId = $imagemModel::find()->Where(['id' => $imagem, 'produto_id' => $produto])->one();

        if ($imagemId) {
            if ($imagemId->delete()) {
                return ['success' => true, 'message' => 'Imagem apagada com sucesso'];
            }
            return ['success' => false, 'message' => 'Não foi possível apagar a imagem'];
        }

        return ['success' => false, 'message' => 'Imagem não encontrada para o produto especificado'];
    }


    //Método onde mostra os produtos por categoria
    public function actionProdutoporcategoria($nomecategoria)
    {
        if (Yii::$app->params['id'] != 1 || Yii::$app->params['id'] != 2) {
            $produtoModel = new $this->modelClass;
            $categoriaModel = new $this->modelCategoriaClass;
            $imagemModel = new $this->modelImagemClass;
            $ivaModel = new $this->modelIvaClass;

            $categoriaMedicamentos = $categoriaModel::findOne(['descricao' => $nomecategoria]);

            if ($categoriaMedicamentos) {
                $produtosporCategoria = $produtoModel::find()->where(['categoria_id' => $categoriaMedicamentos->id])->asArray()->all();

                $Produtos = [];
                foreach ($produtosporCategoria as $produto) {
                    if ($produto['prescricao_medica'] == 0) {
                        $prescricaoMedica = $produto['prescricao_medica'] == 1 ? 'Sim' : 'Não';

                        $id = $produto['id'];

                        $primeiraImagem = null;

                        $imagens = $imagemModel::find()->where(['produto_id' => $id])->all();

                        if ($imagens) {
                            $primeiraImagemUrl = 'http://10.0.2.2/projeto/backend/web/uploads/' . $imagens[0]['filename'];
                            $primeiraImagem = $primeiraImagemUrl;
                        }

                        $categoria = $categoriaModel::findOne($produto['categoria_id']);
                        $categoriaNome = $categoria ? $categoria->descricao : '';

                        $iva = $ivaModel::findOne($produto['iva_id']);
                        $ivaPercentagem = $iva ? $iva->percentagem : '';

                        $Produtos[] = [
                            'id' => $produto['id'],
                            'nome' => $produto['nome'],
                            'prescricao_medica' => $prescricaoMedica,
                            'preco' => $produto['preco'],
                            'quantidade' => $produto['quantidade'],
                            'categoria' => $categoriaNome,
                            'iva' => $ivaPercentagem,
                            'imagens' => $primeiraImagem
                        ];
                    }
                }
                return $Produtos;
            } else {
                throw new \yii\web\ForbiddenHttpException('Proibido');
            }
        }

        throw new \yii\web\NotFoundHttpException('Categoria não encontrada.');
    }


    //Método onde mostra o nome do fornecedor pelo o nome do produto
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

    //Método onde mostra o fornecedor com mais vendas
    public function actionFornecedorcommaisvendas()
    {
        $fornecedorModel = new $this->modelFornecedorClass;

        $fornecedoresComMaisProdutosVendidos = $fornecedorModel::find()
            ->select([
                'fornecedores.id',
                'fornecedores.nome',
                'COUNT(linhas_carrinho.produto_id) AS total_produtos_vendidos'
            ])
            ->innerJoin('linhas_carrinho', 'fornecedores.id = linhas_carrinho.produto_id')
            ->groupBy(['fornecedores.id', 'fornecedores.nome'])
            ->orderBy(['total_produtos_vendidos' => SORT_DESC])
            ->asArray()
            ->all();


        if ($fornecedoresComMaisProdutosVendidos) {
            $fornecedoresNomes = array_column($fornecedoresComMaisProdutosVendidos, 'nome');

            return $fornecedoresNomes;
        }

        throw new \yii\web\NotFoundHttpException('Nenhum fornecedor encontrado.');
    }

    //Método onde mostra os dados do fornecedor pelo nome do fornecedor
    public function actionDadosfornecedor($nomeFornecedor)
    {
        $fornecedorModel = new $this->modelFornecedorClass;

        $fornecedor = $fornecedorModel::find()->where(['nome' => $nomeFornecedor])->one();

        if ($fornecedor) {
            return $fornecedor;
        }

        throw new \yii\web\NotFoundHttpException('Fornecedor não encontrado.');
    }

    //Método onde mostra os produtos que precisam de receita médica ou não
    public function actionProdutoreceita($valor)
    {
        $produtoModel = new $this->modelClass;

        if ($valor == 'nao' || $valor == 'não' || $valor == 'Nao' || $valor == 'Não' || $valor == 'NAO' || $valor == 'NÃO') {
            $produtosReceita = $produtoModel::find()->where(['prescricao_medica' => 0])->all();

        } else if ($valor == 'sim' || $valor == 'Sim' || $valor == 'SIM') {
            $produtosReceita = $produtoModel::find()->where(['prescricao_medica' => 1])->all();
        }

        if ($produtosReceita) {

            return $produtosReceita;
        }

        throw new \yii\web\NotFoundHttpException('Produto(s) não encontrado.');
    }
}
