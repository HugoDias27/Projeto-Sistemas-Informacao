<?php

namespace backend\controllers;

use backend\models\Estabelecimento;
use common\models\Fatura;
use common\models\FaturaSearch;
use common\models\Profile;
use common\models\User;
use Yii;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * FaturaController implements the CRUD actions for fatura model.
 */
class FaturaController extends Controller
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
                            'actions' => ['view','index', 'create', 'delete'],
                            'allow' => true,
                            'roles' => ['funcionario', 'admin'],
                        ],
                        [
                            'actions' => ['view'],
                            'allow' => true,
                            'roles' => ['cliente'],
                        ]
                    ],
                ],

            ]
        );
    }

    /**
     * Lists all fatura models.
     *
     * @return string
     */
    public function actionIndex()
    {

        $searchModel = new FaturaSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        $estabelecimentos = Estabelecimento::find()->all();
        $estabelecimentosItems = ArrayHelper::map($estabelecimentos, 'id', 'nome');


        $authManager = Yii::$app->authManager;
        $clienteRole = $authManager->getRole('cliente');
        $clientes = User::find()
            ->innerJoin('auth_assignment', 'auth_assignment.user_id = user.id')
            ->andWhere(['auth_assignment.item_name' => $clienteRole->name])
            ->all();
        $clientesItems = ArrayHelper::map($clientes, 'id', 'username');

        $estabelecimento = Yii::$app->request->post('estabelecimento_id');
        $cliente = Yii::$app->request->post('cliente_id');

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'estabelecimentos' => $estabelecimentosItems,
            'clientes' => $clientesItems,
            'estabelecimento' => $estabelecimento,
            'cliente' => $cliente,


        ]);
    }

    /**
     * Displays a single fatura model.
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
     * Creates a new fatura model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate($estabelecimento_id, $cliente_id)
    {
        $model = new Fatura();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                $model->estabelecimento_id = $estabelecimento_id;
                $model->cliente_id = $cliente_id;
                if ($model->save()) {
                    return $this->redirect(['linha/createprimeira', 'estabelecimento_id' => $estabelecimento_id, 'cliente_id' => $cliente_id]);
                } else {
                    Yii::error('Error saving Fatura model: ' . print_r($model->errors, true));
                }
            } else {
                Yii::error('Error loading Fatura model: ' . print_r($model->errors, true));
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }



    /**
     * Updates an existing fatura model.
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
     * Deletes an existing fatura model.
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
     * Finds the fatura model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Fatura the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Fatura::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
