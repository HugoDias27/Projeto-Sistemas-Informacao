<?php

namespace backend\controllers;

use common\models\Iva;
use common\models\Servico;
use common\models\ServicoSearch;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * ServicoController implements the CRUD actions for Servico model.
 */
class ServicoController extends Controller
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
     * Lists all Servico models.
     *
     * @return string
     */
    // Método que vai para o index dos serviços
    public function actionIndex()
    {
        $searchModel = new ServicoSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        foreach ($dataProvider->models as $model) {
            $model->iva_id = $model->iva->percentagem . '%';
        }

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Servico model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    // Método que vai para a view de um serviço
    public function actionView($id)
    {
        $model = $this->findModel($id);
        if (\Yii::$app->user->can('viewServico')) {
            $ivaModel = $model->iva;

            $ivaPercentagem = $ivaModel->percentagem . '%';

            return $this->render('view', [
                'model' => $model,
                'ivaPercentagem' => $ivaPercentagem,
            ]);
        }
        throw new NotFoundHttpException('Não tem permissões para aceder a esta página');
    }

    /**
     * Creates a new Servico model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    // Método que permite criar um novo serviço
    public function actionCreate()
    {
        $model = new Servico();

        if (\Yii::$app->user->can('createServico')) {
            $ivaList = Iva::find()->where(['vigor' => 1])->all();
            $ivaItems = ArrayHelper::map($ivaList, 'id', 'percentagem');

            if ($this->request->isPost) {
                if ($model->load($this->request->post()) && $model->save()) {
                    return $this->redirect(['view', 'id' => $model->id]);
                }
            } else {
                $model->loadDefaultValues();
            }

            return $this->render('create', [
                'model' => $model, 'ivaItems' => $ivaItems,
            ]);
        }
        throw new NotFoundHttpException('Não tem permissões para aceder a esta página');
    }

    /**
     * Updates an existing Servico model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    // Método que permite atualizar um serviço
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if (\Yii::$app->user->can('updateServico')) {
            $ivaList = Iva::find()->where(['vigor' => 1])->all();
            $ivaItems = ArrayHelper::map($ivaList, 'id', 'percentagem');

            if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }

            return $this->render('update', [
                'model' => $model, 'ivaItems' => $ivaItems,
            ]);
        }
        throw new NotFoundHttpException('Não tem permissões para aceder a esta página');
    }

    /**
     * Deletes an existing Servico model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    // Método que permite apagar um serviço
    public function actionDelete($id)
    {
        if (\Yii::$app->user->can('deleteServico')) {
            $this->findModel($id)->delete();

            return $this->redirect(['index']);
        }
        throw new NotFoundHttpException('Não tem permissões para aceder a esta página');
    }

    /**
     * Finds the Servico model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Servico the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    // Método que permite encontrar o serviço selecionado
    protected function findModel($id)
    {
        if (($model = Servico::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
