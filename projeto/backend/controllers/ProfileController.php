<?php

namespace backend\controllers;

use common\models\Profile;
use common\models\ProfileSearch;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ProfileController implements the CRUD actions for Profile model.
 */
class ProfileController extends Controller
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
     * Lists all Profile models.
     *
     * @return string
     */
    // Método que vai para o index das categorias
    public function actionIndex()
    {
        $searchModel = new ProfileSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Creates a new Profile model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    // Método que permite criar um novo perfil
    public function actionCreate($id)
    {
        if (\Yii::$app->user->can('createUser')) {
            $perfil = Profile::findOne(['user_id' => $id]);

            if ($perfil !== null) {
                return $this->redirect(['user/index']);
            }

            $perfil = new Profile();
            $perfil->user_id = $id;

            if ($this->request->isPost) {
                if ($perfil->load($this->request->post()) && $perfil->save()) {
                    return $this->redirect(['view', 'id' => $perfil->user_id]);
                }
            } else {
                $perfil->loadDefaultValues();
            }

            return $this->render('create', ['perfil' => $perfil]);
        }
        throw new NotFoundHttpException('Não tem permissões para aceder a esta página');
    }

    /**
     * Updates an existing Profile model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    // Método que permite atualizar o perfil
    public function actionUpdate($id)
    {
        $perfil = $this->findModel($id);

        if (\Yii::$app->user->can('updateUser')) {
            if ($perfil !== null) {
                $post = $this->request->post();

                if ($this->request->isPost && $perfil->load($post) && $perfil->save()) {
                    $perfil->save();

                    return $this->redirect('index');
                }
                if ($perfil->n_utente == null) {
                    $mostra_n_utente = 1;
                } else {
                    $mostra_n_utente = 0;
                }
                if ($perfil->nif == null) {
                    $mostra_nif = 1;
                } else {
                    $mostra_nif = 0;
                }
            } else {
                return $this->redirect(['create', 'id' => $id]);
            }
            return $this->render('update', ['perfil' => $perfil, 'mostra_n_utente' => $mostra_n_utente, 'mostra_nif' => $mostra_nif]);
        }
        throw new NotFoundHttpException('Não tem permissões para aceder a esta página');
    }

    /**
     * Deletes an existing Profile model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    // Método que permite apagar o perfil
    public function actionDelete($id)
    {
        if (\Yii::$app->user->can('deleteUser')) {
            $this->findModel($id)->delete();

            return $this->redirect(['index']);
        }
        throw new NotFoundHttpException('Não tem permissões para aceder a esta página');
    }

    /**
     * Finds the Profile model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Profile the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    // Método que permite encontrar o perfil selecionado
    protected function findModel($id)
    {
        if (($perfil = Profile::findOne(['user_id' => $id])) !== null) {
            return $perfil;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
