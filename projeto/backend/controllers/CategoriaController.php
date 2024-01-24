<?php

namespace backend\controllers;

use common\models\Categoria;
use common\models\CategoriaSearch;
use PhpParser\Node\Expr\Throw_;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * CategoriaController implements the CRUD actions for Categoria model.
 */
class CategoriaController extends Controller
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
     * Lists all Categoria models.
     *
     * @return string
     */
    // Método que vai para o index das categorias
    public function actionIndex()
    {
        $searchModel = new CategoriaSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Categoria model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    // Método que vai para a view de uma categoria
    public function actionView($id)
    {
        if (\Yii::$app->user->can('viewCategorias')) {
            return $this->render('view', ['categoria' => $this->findModel($id)]);
        }
        throw new NotFoundHttpException('Não tem permissões para aceder a esta página');
    }

    /**
     * Creates a new Categoria model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    // Método que permite criar uma nova categoria
    public function actionCreate()
    {
        $Lista = ['saude_oral' => 'Saúde Oral', 'bens_beleza' => 'Bens de Beleza', 'higiene' => 'Higiene'];

        if (\Yii::$app->user->can('createCategorias')) {
            $categoria = new Categoria();

            if ($this->request->isPost) {
                if ($categoria->load($this->request->post())) {
                    $CategoriaExiste = Categoria::findOne(['descricao' => $categoria->descricao]);

                    if ($CategoriaExiste) {
                        return $this->redirect('index');
                    }

                    if ($categoria->save()) {
                        return $this->redirect('index');
                    }
                }
            } else {
                $categoria->loadDefaultValues();
            }

            return $this->render('create', ['categoria' => $categoria, 'categorias' => $Lista,]);
        } else {
            throw new NotFoundHttpException('Não tem permissões para aceder a esta página');
        }
    }


    /**
     * Updates an existing Categoria model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    // Método que permite atualizar uma categoria
    public function actionUpdate($id)
    {
        $categoria = $this->findModel($id);

        $categoriasExistentes = Categoria::find()->all();

        if (count($categoriasExistentes) >= count(['saude_oral', 'bens_beleza', 'higiene'])) {
            throw new ForbiddenHttpException('Não é possível editar a categorias, todas as categorias já existem.');
        }

        if ($categoria->descricao == 'saude_oral') {
            $Lista = ['bens_beleza' => 'Bens de Beleza', 'higiene' => 'Higiene'];
        }
        if ($categoria->descricao == 'bens_beleza') {
            $Lista = ['saude_oral' => 'Saúde Oral', 'higiene' => 'Higiene'];
        }
        if ($categoria->descricao == 'higiene') {
            $Lista = ['saude_oral' => 'Saúde Oral', 'bens_beleza' => 'Bens de Beleza'];
        }


        if (\Yii::$app->user->can('updateCategorias')) {
            if ($this->request->isPost && $categoria->load($this->request->post()) && $categoria->save()) {
                return $this->redirect(['view', 'id' => $categoria->id]);
            }
            return $this->render('update', ['categoria' => $categoria, 'categorias' => $Lista]);
        }
        throw new NotFoundHttpException('Não tem permissões para aceder a esta página');
    }

    /**
     * Deletes an existing Categoria model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    // Método que permite apagar uma categoria
    public function actionDelete($id)
    {
        if (\Yii::$app->user->can('deleteCategorias')) {
            $this->findModel($id)->delete();

            return $this->redirect(['index']);
        }
        throw new NotFoundHttpException('Não tem permissões para aceder a esta página');
    }


    /**
     * Finds the Categoria model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Categoria the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    // Método que permite encontrar a categoria selecionada
    protected function findModel($id)
    {
        if (($categoria = Categoria::findOne(['id' => $id])) !== null) {
            return $categoria;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
