<?php

namespace backend\controllers;

use common\models\Fatura;
use common\models\LinhaFatura;
use common\models\LinhaFaturaSearch;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * LinhaController implements the CRUD actions for LinhaFatura model.
 */
class LinhaController extends Controller
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
                            'actions' => ['index', 'view', 'create','createprimeira'],
                            'allow' => true,
                            'roles' => ['funcionario'],
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
     * Lists all LinhaFatura models.
     *
     * @return string
     */
    public function actionIndex($id)
    {
        $searchModel = new LinhaFaturaSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);
        $modelfatura = LinhaFatura::getFatura($id);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'modelfatura' => $modelfatura,
        ]);
    }

    /**
     * Displays a single LinhaFatura model.
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
     * Creates a new LinhaFatura model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate($id, $estabelecimento_id, $cliente_id)
    {
        $model = new LinhaFatura();

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                $model->fatura_id = $id;
                $model->estabelecimento_id = $estabelecimento_id;
                $model->cliente_id = $cliente_id;
                if ($model->save()) {
                    return $this->redirect(['index', 'id' => $id]);
                }
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model, 'estabelecimento_id' => $estabelecimento_id, 'cliente_id' => $cliente_id,
        ]);
    }




    public function actionCreateprimeira($estabelecimento_id, $cliente_id)
    {
        $modelFatura = new Fatura();
        $model = new LinhaFatura();

        if ($this->request->isPost) {
            // Load and save Fatura model
            if ($modelFatura->load($this->request->post())) {
                $modelFatura->estabelecimento_id = $estabelecimento_id;
                $modelFatura->cliente_id = $cliente_id;

                if ($modelFatura->save()) {
                    // Load and save LinhaFatura model
                    $model->fatura->id = $modelFatura->id;

                    if ($model->load($this->request->post()) && $model->save()) {
                        return $this->redirect(['fatura/index', 'id' => $modelFatura->id, 'estabelecimento_id' => $estabelecimento_id, 'cliente_id' => $cliente_id]);
                    } else {
                        // Handle LinhaFatura save error
                        Yii::error('Error saving LinhaFatura model: ' . print_r($model->errors, true));
                    }
                } else {
                    // Handle Fatura save error
                    Yii::error('Error saving Fatura model: ' . print_r($modelFatura->errors, true));
                }
            }
        } else {
            // Load default values if not a POST request
            $modelFatura->loadDefaultValues();
            $model->loadDefaultValues();
        }

        return $this->render('createprimeira', [
            'model' => $model, 'modelFatura' => $modelFatura, 'estabelecimento_id' => $estabelecimento_id, 'cliente_id' => $cliente_id,
        ]);
    }



    /**
     * Updates an existing LinhaFatura model.
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
     * Deletes an existing LinhaFatura model.
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
     * Finds the LinhaFatura model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return LinhaFatura the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = LinhaFatura::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
