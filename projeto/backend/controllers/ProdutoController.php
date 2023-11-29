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
    public function actionIndex()
    {
        $searchModel = new ProdutoSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        foreach ($dataProvider->models as $model) {
            $model->iva_id = $model->iva->percentagem . '%' ;
            $model->categoria_id = $model->categoria->descricao;
        }


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
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Produto model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Produto();
        $modelImg = new Imagem();

        $ivaList = Iva::find()->where(['vigor' => 1])->all();
        $ivaItems = ArrayHelper::map($ivaList, 'id', 'percentagem');

        $categoriaList = Categoria::find()->all();
        $categoriaItems = ArrayHelper::map($categoriaList, 'id', 'descricao');

        if ($this->request->isPost) {
            $model->load($this->request->post());
            if ($model->save()) {
                Yii::$app->session->set('produtoId', $model->id); // Guarda o ID do produto na sessão
                $modelImg->imagem = UploadedFile::getInstances($modelImg, 'imagem'); // Use o campo 'imagem' aqui
                if ($modelImg->upload($model->id)) {
                    return $this->redirect(['view', 'id' => $model->id]);
                }
            }
        }

        return $this->render('create', [
            'model' => $model,
            'ivaItems' => $ivaItems,
            'categoriaItems' => $categoriaItems,
            'modelImg' => $modelImg,
        ]);
    }



    public function actionUpload()
    {
        $modelImg = new Imagem();
        $produtoId = Yii::$app->session->get('produtoId'); // Obtém o ID do produto da sessão

        if (Yii::$app->request->isPost) {
            $modelImg->imagem = UploadedFile::getInstances($modelImg, 'imagem'); // Use o campo 'imagem' aqui
            if ($modelImg->upload($produtoId)) {
                // As imagens foram carregadas com sucesso
                // Faça o que for necessário aqui após o carregamento das imagens
                return $this->redirect(['view', 'id' => $produtoId]); // Redireciona para a página de visualização do produto
            }
        }

        return $this->render('upload', ['modelImg' => $modelImg]);
    }




    /**
     * Updates an existing Produto model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Produto model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Produto model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Produto the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Produto::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
