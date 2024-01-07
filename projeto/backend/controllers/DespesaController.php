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
     * Lists all Despesa models.
     *
     * @return string
     */
    // Método que vai para o index das despesas
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
    // Método que vai para a view de uma despesa
    public function actionView($id)
    {
        if (\Yii::$app->user->can('viewDespesa')) {
            return $this->render('view', ['despesa' => $this->findModel($id)]);
        }
        throw new NotFoundHttpException('Não tem permissões para aceder a esta página');
    }

    /**
     * Creates a new Despesa model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    // Método que permite criar uma nova despesa
    public function actionCreate()
    {
        $despesa = new Despesa();
        $estabelecimentoList = Estabelecimento::find()->all();
        $estabelecimentoItems = ArrayHelper::map($estabelecimentoList, 'id', 'nome');

        if (\Yii::$app->user->can('createDespesa')) {
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
        throw new NotFoundHttpException('Não tem permissões para aceder a esta página');
    }

    /**
     * Updates an existing Despesa model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    // Método que permite atualizar uma despesa
    public function actionUpdate($id)
    {
        $despesa = $this->findModel($id);

        if (\Yii::$app->user->can('updateDespesa')) {
            if ($this->request->isPost && $despesa->load($this->request->post()) && $despesa->save()) {
                return $this->redirect(['view', 'id' => $despesa->id]);
            }

            return $this->render('update', ['despesa' => $despesa]);
        }
        throw new NotFoundHttpException('Não tem permissões para aceder a esta página');
    }

    /**
     * Deletes an existing Despesa model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    // Método que permite apagar uma despesa
    public function actionDelete($id)
    {
        if (\Yii::$app->user->can('deleteCategorias')) {
            $this->findModel($id)->delete();

            return $this->redirect(['index']);
        }
        throw new NotFoundHttpException('Não tem permissões para aceder a esta página');
    }

    /**
     * Finds the Despesa model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Despesa the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    // Método que permite encontrar a despesa selecionada
    protected function findModel($id)
    {
        if (($despesa = Despesa::findOne(['id' => $id])) !== null) {
            return $despesa;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
