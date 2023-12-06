<?php

namespace backend\controllers;

use backend\models\Despesa;
use backend\models\DespesaSearch;
use backend\models\Estabelecimento;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * DespesaController implements the CRUD actions for Despesa model.
 */
class DespesaController extends Controller
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
     * Lists all Despesa models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new DespesaSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        foreach ($dataProvider->models as $model) {
            $model->estabelecimento_id = $model->estabelecimento->nome;
        }

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Despesa model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'despesa' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Despesa model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $despesa = new Despesa();
        $estabelecimentoList = Estabelecimento::find()->all();
        $estabelecimentoItems = ArrayHelper::map($estabelecimentoList, 'id', 'nome');

        if ($this->request->isPost) {
            if ($despesa->load($this->request->post()) && $despesa->save()) {
                return $this->redirect(['view', 'id' => $despesa->id]);
            }
        } else {
            $despesa->loadDefaultValues();
        }

        return $this->render('create', [
            'despesa' => $despesa, 'estabelecimentoItems' => $estabelecimentoItems,
        ]);
    }

    /**
     * Updates an existing Despesa model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $despesa = $this->findModel($id);

        if ($this->request->isPost && $despesa->load($this->request->post()) && $despesa->save()) {
            return $this->redirect(['view', 'id' => $despesa->id]);
        }

        return $this->render('update', [
            'despesa' => $despesa,
        ]);
    }

    /**
     * Deletes an existing Despesa model.
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
     * Finds the Despesa model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Despesa the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($despesa = Despesa::findOne(['id' => $id])) !== null) {
            return $despesa;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
