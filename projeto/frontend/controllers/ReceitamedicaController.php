<?php

namespace frontend\controllers;

use common\models\ReceitaMedica;
use common\models\ReceitaMedicaSearch;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ReceitaMedicaController implements the CRUD actions for ReceitaMedica model.
 */
class ReceitamedicaController extends Controller
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
            ]
        );
    }

    /**
     * Lists all ReceitaMedica models.
     *
     * @return string
     */
    public function actionIndex($id)
    {
        $searchModel = new ReceitaMedicaSearch();

        $dataProvider = $searchModel->search($this->request->queryParams);
        $dataProvider->query->andWhere(['user_id' => $id]);
        $dataProvider->query->with('posologiaProduto');

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }


    /**
     * Displays a single ReceitaMedica model.
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
     * Creates a new ReceitaMedica model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionVerificar($produtoid)
    {
        $receitaMedica = new ReceitaMedica();
        if ($this->request->isPost) {
            $request = Yii::$app->request;
            $codigo = $request->post('ReceitaMedica')['codigo'];

            $receitaMedica = ReceitaMedica::find()
                ->where(['codigo' => $codigo])
                ->andWhere(['LIKE', 'posologia', $produtoid])
                ->one();

            if ($receitaMedica !== null) {
                return $this->redirect(['carrinhocompra/createcomreceita', 'id' => $produtoid]);
            } else {
                $receitaMedica = new ReceitaMedica();

                Yii::$app->session->setFlash('error', 'A receita médica não corresponde ao produto fornecido.');
                return $this->render('verificar', [
                    'receitaMedica' => $receitaMedica,
                ]);
            }
        }
        return $this->render('verificar', [
            'receitaMedica' => $receitaMedica,
        ]);
    }


    /**
     * Updates an existing ReceitaMedica model.
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
     * Deletes an existing ReceitaMedica model.
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
     * Finds the ReceitaMedica model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return ReceitaMedica the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ReceitaMedica::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
