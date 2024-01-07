<?php

namespace backend\controllers;

use common\models\UploadForm;
use common\models\Imagem;
use common\models\ImagemSearch;
use common\models\Produto;
use Yii;
use yii\filters\AccessControl;
use yii\helpers\Html;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;


/**
 * ImagemController implements the CRUD actions for Imagem model.
 */
class ImagemController extends Controller
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
     * Lists all Imagem models.
     *
     * @return string
     */
    // Método que vai para o index das imagens
    public function actionIndex()
    {
        $searchModel = new ImagemSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }


    /**
     * Creates a new Imagem model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    // Método que permite adicionar uma nova imagem ao produto
    public function actionCreate($produto_id)
    {
        if (\Yii::$app->user->can('createMedicamento')) {
            $imagem = new Imagem();
            $uploadForm = new UploadForm();

            if (Yii::$app->request->isPost) {
                $uploadForm->imageFiles = UploadedFile::getInstances($imagem, 'imageFiles');
                $uploadForm->produto_id = $produto_id;

                if ($uploadForm->upload()) {
                    return $this->redirect(['produto/view', 'id' => $produto_id]);
                }
            }

            return $this->render('create', ['imagem' => $imagem]);
        }
        throw new NotFoundHttpException('Não tem permissões para aceder a esta página');
    }

    /**
     * Deletes an existing Imagem model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    // Método que permite apagar uma imagem
    public function actionDelete($id)
    {
        if (\Yii::$app->user->can('deleteMedicamento')) {
            $this->findModel($id)->delete();

            return $this->redirect(['produto/index']);
        }
        throw new NotFoundHttpException('Não tem permissões para aceder a esta página');
    }

    /**
     * Finds the Imagem model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Imagem the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    // Método que permite encontrar a imagem selecionada
    protected function findModel($id)
    {
        if (($imagem = Imagem::findOne(['id' => $id])) !== null) {
            return $imagem;
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
