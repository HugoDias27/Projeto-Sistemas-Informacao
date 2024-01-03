<?php

namespace backend\modules\api\controllers;

use backend\modules\api\components\CustomAuth;
use common\models\Fornecedor;
use common\models\Imagem;
use common\models\Iva;
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
    public $modelImagemClass = 'common\models\Imagem';
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


    public function actionImagens()
    {
        $produtoModel = new $this->modelClass;
        $produtos = $produtoModel::find()->all(); // Supondo que 'Produto' seja o nome do seu modelo de produtos

        $produtosImagensArray = [];

        foreach ($produtos as $produto) {
            $produtoArray = $produto->attributes;
            $id = $produto['id']; // Suponho que 'id' seja a chave primária do produto

            $imagemModel = new $this->modelImagemClass;
            $imagens = $imagemModel::find()->where(['produto_id' => $id])->all();
            $produtoArray['imagens'] = [];

            foreach ($imagens as $imagem) {
                $imagemUrl = 'http://localhost/projeto/backend/web/uploads/' . $imagem->filename; // Substitua 'seusite.com' pelo seu domínio
                $imagemArray = [
                    'url' => $imagemUrl,
                    'descricao' => $imagem->filename // Adicione outras informações da imagem, se necessário
                ];
                $produtoArray['imagens'][] = $imagemArray;
            }

            $produtosImagensArray[] = $produtoArray;
        }

        return $produtosImagensArray;
    }

    public function actionAdicionarimagem($produto)
    {
        $imagem = new Imagem();
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


    public function actionApagarimagem($imagem, $produto)
    {
        $imagemModel = $this->modelClass;

        $imagemId = $imagemModel::find()->andWhere(['id' => $imagem, 'produto_id' => $produto])->one();

        if ($imagemId) {
            if ($imagemId->delete()) {
                return ['success' => true, 'message' => 'Imagem apagada com sucesso'];
            }
            return ['success' => false, 'message' => 'Não foi possível apagar a imagem'];
        }

        return ['success' => false, 'message' => 'Imagem não encontrada para o produto especificado'];
    }


    public function actionProdutoporcategoria($nomecategoria)
    {
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

    public function actionFornecedorcommaisvendas()
    {
        $fornecedoresComMaisProdutosVendidos = Fornecedor::find()
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

    public
    function actionDadosfornecedor($nomeFornecedor)
    {
        $fornecedor = Fornecedor::find()->where(['nome' => $nomeFornecedor])->one();

        if ($fornecedor) {
            return $fornecedor;
        }

        throw new \yii\web\NotFoundHttpException('Fornecedor não encontrado.');
    }

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

    public
    function actionIvasativos()
    {
        $Ivasativos = Iva::find()->where(['vigor' => 1])->all();

        if ($Ivasativos) {
            return $Ivasativos;
        }

        throw new \yii\web\NotFoundHttpException('Iva(s) não encontrado.');
    }
}
