<?php

namespace backend\controllers;

use common\models\Iva;
use common\models\IvaSearch;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * IvaController implements the CRUD actions for Iva model.
 */
class IvaController extends Controller
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
                            'actions' => ['index', 'view', 'create'],
                            'allow' => true,
                            'roles' => ['admin', 'funcionario'],
                        ],
                        [
                            'actions' => ['delete', 'update'],
                            'allow' => true,
                            'roles' => ['admin'],
                        ],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all Iva models.
     *
     * @return string
     */
    // Método que vai para o index dos ivas
    public function actionIndex()
    {
        $searchModel = new IvaSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Iva model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    // Método que vai para a view de um iva
    public function actionView($id)
    {
        if (\Yii::$app->user->can('viewIvas')) {
            return $this->render('view', ['iva' => $this->findModel($id)]);
        }
        throw new NotFoundHttpException('Não tem permissões para aceder a esta página');
    }

    /**
     * Creates a new Iva model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    // Método que permite criar um novo iva
    public function actionCreate()
    {
        $iva = new Iva();

        if (\Yii::$app->user->can('createIvas')) {
            if ($this->request->isPost) {
                if ($iva->load($this->request->post()) && $iva->save()) {
                    return $this->redirect(['view', 'id' => $iva->id]);
                }
            } else {
                $iva->loadDefaultValues();
            }

            return $this->render('create', [
                'iva' => $iva,
            ]);
        }
        throw new NotFoundHttpException('Não tem permissões para aceder a esta página');
    }

    /**
     * Updates an existing Iva model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    // Método que permite atualizar um iva
    public function actionUpdate($id)
    {
        $iva = $this->findModel($id);

        if (\Yii::$app->user->can('updateIvas')) {
            if ($this->request->isPost && $iva->load($this->request->post()) && $iva->save()) {
                return $this->redirect(['view', 'id' => $iva->id]);
            }

            return $this->render('update', ['iva' => $iva]);
        }
        throw new NotFoundHttpException('Não tem permissões para aceder a esta página');
    }

    /**
     * Deletes an existing Iva model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    // Método que permite apagar um iva
    public function actionDelete($id)
    {
        if (\Yii::$app->user->can('deleteIvas')) {
            $this->findModel($id)->delete();

            return $this->redirect(['index']);
        }
        throw new NotFoundHttpException('Não tem permissões para aceder a esta página');
    }

    /**
     * Finds the Iva model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Iva the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    // Método que permite encontrar o iva selecionado
    protected function findModel($id)
    {
        if (($iva = Iva::findOne(['id' => $id])) !== null) {
            return $iva;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
