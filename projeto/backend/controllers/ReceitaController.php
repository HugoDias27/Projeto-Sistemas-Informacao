<?php

namespace backend\controllers;

use common\models\Profile;
use common\models\ReceitaMedica;
use common\models\ReceitaMedicaSearch;
use common\models\User;
use Yii;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ReceitaController implements the CRUD actions for ReceitaMedica model.
 */
class ReceitaController extends Controller
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
     * Lists all ReceitaMedica models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new ReceitaMedicaSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        // Adiciona o JOIN e a seleção do nome do usuário no $dataProvider
        $dataProvider->query->joinWith('user'); // Supondo que 'user' é o nome do relacionamento na classe ReceitaMedica
        $dataProvider->query->select([
            'receitas_medica.*', // Todos os campos de receita_medica
            'user.username AS nome_usuario', // Nome de usuário da tabela user
        ]);

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
            'receita' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new ReceitaMedica model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $receita = new ReceitaMedica();
        $authManager = Yii::$app->authManager;
        $clienteRole = $authManager->getRole('cliente');

        $clientes = User::find()
            ->innerJoin('auth_assignment', 'auth_assignment.user_id = user.id')
            ->andWhere(['auth_assignment.item_name' => $clienteRole->name])
            ->select(['id', 'username'])
            ->asArray()
            ->all();

        $clientesItems = ArrayHelper::map($clientes, 'id', 'username');

        if ($this->request->isPost) {
            if ($receita->load($this->request->post()) && $receita->save()) {
                return $this->redirect(['view', 'id' => $receita->id]);
            }
        } else {
            $receita->loadDefaultValues();
        }

        return $this->render('create', [
            'receita' => $receita,
            'clientes' => $clientesItems,
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
        $receita = $this->findModel($id);

        if ($this->request->isPost && $receita->load($this->request->post()) && $receita->save()) {
            return $this->redirect(['view', 'id' => $receita->id]);
        }

        return $this->render('update', [
            'receita' => $receita,
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
        if (($receita = ReceitaMedica::findOne(['id' => $id])) !== null) {
            return $receita;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
