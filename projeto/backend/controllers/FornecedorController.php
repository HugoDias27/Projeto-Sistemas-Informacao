<?php

namespace backend\controllers;

use backend\models\Fornecedor;
use backend\models\FornecedorSearch;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * FornecedorController implements the CRUD actions for Fornecedor model.
 */
class FornecedorController extends Controller
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
     * Lists all Fornecedor models.
     *
     * @return string
     */
    // Método que vai para o index dos fornecedores
    public function actionIndex()
    {
        $searchModel = new FornecedorSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Fornecedor model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    // Método que vai para a view de um fornecedor
    public function actionView($id)
    {
        if (\Yii::$app->user->can('viewFornecedor')) {
            return $this->render('view', ['fornecedor' => $this->findModel($id),]);
        }
        throw new NotFoundHttpException('Não tem permissões para aceder a esta página');

    }

    /**
     * Creates a new Fornecedor model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    // Método que permite criar um novo fornecedor
    public function actionCreate()
    {
        $fornecedor = new Fornecedor();

        if (\Yii::$app->user->can('createFornecedor')) {
            if ($this->request->isPost) {
                if ($fornecedor->load($this->request->post()) && $fornecedor->save()) {
                    return $this->redirect(['view', 'id' => $fornecedor->id]);
                }
            } else {
                $fornecedor->loadDefaultValues();
            }

            return $this->render('create', [
                'fornecedor' => $fornecedor,
            ]);
        }
        throw new NotFoundHttpException('Não tem permissões para aceder a esta página');
    }

    /**
     * Updates an existing Fornecedor model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    // Método que permite atualizar um fornecedor
    public function actionUpdate($id)
    {
        $fornecedor = $this->findModel($id);

        if (\Yii::$app->user->can('updateFornecedor')) {
            if ($this->request->isPost && $fornecedor->load($this->request->post()) && $fornecedor->save()) {
                return $this->redirect(['view', 'id' => $fornecedor->id]);
            }

            return $this->render('update', [
                'fornecedor' => $fornecedor,
            ]);
        }
        throw new NotFoundHttpException('Não tem permissões para aceder a esta página');
    }

    /**
     * Deletes an existing Fornecedor model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    // Método que permite apagar um fornecedor
    public function actionDelete($id)
    {
        if (\Yii::$app->user->can('deleteFornecedor')) {
            $this->findModel($id)->delete();

            return $this->redirect(['index']);
        }
        throw new NotFoundHttpException('Não tem permissões para aceder a esta página');
    }

    /**
     * Finds the Fornecedor model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Fornecedor the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    // Método que permite encontrar o fornecedor selecionado
    protected function findModel($id)
    {
        if (($fornecedor = Fornecedor::findOne(['id' => $id])) !== null) {
            return $fornecedor;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
