<?php

namespace frontend\controllers;

use common\models\Profile;
use common\models\ProfileSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * ProfileController implements the CRUD actions for Profile model.
 */
class ProfileController extends Controller
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
                            'roles' => ['cliente'],
                        ],
                    ],
                ],
            ]
        );
    }


    /**
     * Displays a single Profile model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    // Método que vai para a view de um perfil
    public function actionView($id)
    {
        $model = $this->findModel($id);

        if ($model != null) {
            return $this->render('view', ['model' => $model]);
        } else {
            return $this->redirect(['create', 'id' => $id]);
        }
    }

    /**
     * Creates a new Profile model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    // Método que permite criar um novo perfil
    public function actionCreate($id)
    {
        $model = new Profile();
        $model->user_id = $id;

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->user_id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', ['model' => $model]);
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
        $model = $this->findModel($id);

        if ($model != null) {
            if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->user_id]);
            }
        } else {
            return $this->redirect(['create', 'id' => $id]);
        }
        if ($model->n_utente == null) {
            $mostra_n_utente = 1;
        } else {
            $mostra_n_utente = 0;
        }
        if ($model->nif == null) {
            $mostra_nif = 1;
        } else {
            $mostra_nif = 0;
        }

        return $this->render('update', ['model' => $model, 'mostra_n_utente' => $mostra_n_utente, 'mostra_nif' => $mostra_nif]);

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
        if (($model = Profile::findOne(['user_id' => $id])) !== null) {
            return $model;
        }
    }
}
