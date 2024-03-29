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
        if (\Yii::$app->user->can('createCategorias')) {
            $categoriasExistentes = Categoria::find()->select('descricao')->column();
            $categoriasDisponiveis = [
                'saude_oral' => 'Saúde Oral',
                'bens_beleza' => 'Bens de Beleza',
                'higiene' => 'Higiene'
            ];

            $categoriasNaoExistentes = array_diff_key($categoriasDisponiveis, array_flip($categoriasExistentes));

            if (empty($categoriasNaoExistentes)) {
                return $this->redirect('index');
            }

            $categoria = new Categoria();

            if ($this->request->isPost) {
                if ($categoria->load($this->request->post())) {
                    $categoriaExiste = Categoria::findOne(['descricao' => $categoria->descricao]);

                    if ($categoriaExiste) {
                        return $this->redirect('index');
                    }

                    if ($categoria->save()) {
                        return $this->redirect('index');
                    }
                }
            } else {
                $categoria->loadDefaultValues();
            }

            return $this->render('create', [
                'categoria' => $categoria,
                'categorias' => $categoriasNaoExistentes,
            ]);
        } else {
            throw new NotFoundHttpException('Não tem permissões para aceder a esta página');
        }
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
