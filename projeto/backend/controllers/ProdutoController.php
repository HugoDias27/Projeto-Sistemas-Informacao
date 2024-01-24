<?php

namespace backend\controllers;

use common\models\Categoria;
use common\models\Imagem;
use common\models\Iva;
use common\models\Produto;
use common\models\ProdutoSearch;
use Yii;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use backend\models\Fornecedor;
use backend\models\FornecedorProduto;


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
                            'actions' => ['index', 'view', 'create', 'update'],
                            'allow' => true,
                            'roles' => ['admin', 'funcionario'],
                        ],
                        [
                            'actions' => ['delete'],
                            'allow' => true,
                            'roles' => ['admin'],
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
    // Método que vai para o index dos produtos
    public function actionIndex()
    {
        $searchModel = new ProdutoSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        $dataProvider->query->with('fornecedoresProdutos');
        $dataProvider->query->with('fornecedores');

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Produto model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    // Método que vai para a view de um produto
    public function actionView($id)
    {
        if (\Yii::$app->user->can('viewMedicamento')) {
            $imagemArray = [];

            $fornecedorProduto = FornecedorProduto::find()->where(['produto_id' => $id])->with('fornecedor')->all();

            $imagens = Imagem::find()->where(['produto_id' => $id])->all();
            $imagemArray = [];

            if (!empty($imagens)) {
                foreach ($imagens as $imagem) {
                    $imagemPath = Yii::getAlias('@web') . '/uploads/' . $imagem->filename;
                    $imagemArray[] = [
                        'id' => $imagem->id,
                        'filename' => $imagemPath,
                    ];
                }
            }

            return $this->render('view', [
                'produto' => $this->findModel($id),
                'imagemArray' => $imagemArray,
                'fornecedorProduto' => $fornecedorProduto,
            ]);
        }
        throw new NotFoundHttpException('Não tem permissões para aceder a esta página');
    }


    /**
     * Creates a new Produto model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    // Método que permite criar um novo produto
    public function actionCreate()
    {
        $produto = new Produto();

        if (\Yii::$app->user->can('createMedicamento')) {
            $fornecedorProduto = new FornecedorProduto();
            $fornecedoresList = Fornecedor::find()->all();
            $fornecedores = ArrayHelper::map($fornecedoresList, 'id', 'nome');

            $ivaList = Iva::find()->where(['vigor' => 1])->all();
            $ivaItems = ArrayHelper::map($ivaList, 'id', 'percentagem');

            $categoriaList = Categoria::find()->all();
            $categoriaItems = ArrayHelper::map($categoriaList, 'id', 'descricao');

            $post = $this->request->post();

            if ($this->request->isPost) {
                $produto->load($this->request->post());
                if ($produto->save()) {
                    $fornecedorProduto->produto_id = $produto->id;
                    $fornecedorProduto->data_importacao = $post['FornecedorProduto']['data_importacao'];
                    $fornecedorProduto->fornecedor_id = $post['FornecedorProduto']['fornecedor_id'];
                    $fornecedorProduto->hora_importacao = $post['FornecedorProduto']['hora_importacao'];
                    $fornecedorProduto->quantidade = $post['Produto']['quantidade'];
                    if ($fornecedorProduto->save()) {
                        return $this->redirect(['index']);
                    }
                }
            }

            return $this->render('create', [
                'produto' => $produto,
                'ivaItems' => $ivaItems,
                'categoriaItems' => $categoriaItems,
                'fornecedorProduto' => $fornecedorProduto,
                'fornecedores' => $fornecedores
            ]);
        }
        throw new NotFoundHttpException('Não tem permissões para aceder a esta página');
    }


    /**
     * Updates an existing Produto model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    // Método que permite atualizar um produto
    public function actionUpdate($id)
    {
        $produto = $this->findModel($id);

        if (\Yii::$app->user->can('updateMedicamento')) {
            $ivaList = Iva::find()->where(['vigor' => 1])->all();
            $ivaItems = ArrayHelper::map($ivaList, 'id', 'percentagem');

            $categoriaList = Categoria::find()->all();
            $categoriaItems = ArrayHelper::map($categoriaList, 'id', 'descricao');
            if ($this->request->isPost && $produto->load($this->request->post()) && $produto->save()) {
                return $this->redirect(['view', 'id' => $produto->id]);
            }

            return $this->render('update', [
                'produto' => $produto,
                'ivaItems' => $ivaItems,
                'categoriaItems' => $categoriaItems,
            ]);
        }
        throw new NotFoundHttpException('Não tem permissões para aceder a esta página');
    }

    /**
     * Deletes an existing Produto model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    // Método que permite apagar um produto
    public function actionDelete($id)
    {
        if (\Yii::$app->user->can('deleteMedicamento')) {
            $imagens = Imagem::find()->where(['produto_id' => $id])->all();
            foreach ($imagens as $imagem) {
                $imagem->delete();
            }
            $FornecedorProduto = FornecedorProduto::find()->where(['produto_id' => $id])->one();
            $FornecedorProduto->delete();
            $this->findModel($id)->delete();

            return $this->redirect(['index']);
        }
        throw new NotFoundHttpException('Não tem permissões para aceder a esta página');
    }

    /**
     * Finds the Produto model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Produto the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    // Método que permite encontrar o produto selecionado
    protected function findModel($id)
    {
        if (($produto = Produto::findOne(['id' => $id])) !== null) {
            return $produto;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
