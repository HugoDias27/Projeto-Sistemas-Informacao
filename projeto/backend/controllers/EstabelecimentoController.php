<?php

namespace backend\controllers;

use backend\models\Estabelecimento;
use backend\models\EstabelecimentoSearch;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * EstabelecimentoController implements the CRUD actions for Estabelecimento model.
 */
class EstabelecimentoController extends Controller
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
                            'actions' => ['index', 'view', 'create', 'update', 'delete'],
                            'allow' => true,
                            'roles' => ['admin'],
                        ],
                        [
                            'actions' => ['index'],
                            'allow' => true,
                            'roles' => ['funcionario'],
                        ],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all Estabelecimento models.
     *
     * @return string
     */
    // Método que vai para o index dos estabelecimentos
    public function actionIndex()
    {
        $searchModel = new EstabelecimentoSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Estabelecimento model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    // Método que vai para a view de um estabelecimento
    public function actionView($id)
    {
        if (\Yii::$app->user->can('viewEstabelecimento')) {
            return $this->render('view', ['estabelecimento' => $this->findModel($id)]);
        }
        throw new NotFoundHttpException('Não tem permissões para aceder a esta página');
    }

    /**
     * Creates a new Estabelecimento model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    // Método que permite criar um novo estabelecimento
    public function actionCreate()
    {
        $estabelecimento = new Estabelecimento();

        if (\Yii::$app->user->can('createEstabelecimento')) {
            if ($this->request->isPost) {
                if ($estabelecimento->load($this->request->post()) && $estabelecimento->save()) {
                    return $this->redirect(['view', 'id' => $estabelecimento->id]);
                }
            } else {
                $estabelecimento->loadDefaultValues();
            }

            return $this->render('create', ['estabelecimento' => $estabelecimento]);
        }
        throw new NotFoundHttpException('Não tem permissões para aceder a esta página');
    }

    /**
     * Updates an existing Estabelecimento model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    // Método que permite atualizar um estabelecimento
    public function actionUpdate($id)
    {
        $estabelecimento = $this->findModel($id);

        if (\Yii::$app->user->can('updateEstabelecimento')) {
            if ($this->request->isPost && $estabelecimento->load($this->request->post()) && $estabelecimento->save()) {
                return $this->redirect(['view', 'id' => $estabelecimento->id]);
            }

            return $this->render('update', [
                'estabelecimento' => $estabelecimento,
            ]);
        }
        throw new NotFoundHttpException('Não tem permissões para aceder a esta página');
    }

    /**
     * Deletes an existing Estabelecimento model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    // Método que permite apagar um estabelecimento
    public function actionDelete($id)
    {
        if (\Yii::$app->user->can('deleteEstabelecimento')) {
            $this->findModel($id)->delete();

            return $this->redirect(['index']);
        }
        throw new NotFoundHttpException('Não tem permissões para aceder a esta página');
    }

    /**
     * Finds the Estabelecimento model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Estabelecimento the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    // Método que permite encontrar o estabelecimento selecionado
    protected function findModel($id)
    {
        if (($estabelecimento = Estabelecimento::findOne(['id' => $id])) !== null) {
            return $estabelecimento;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
