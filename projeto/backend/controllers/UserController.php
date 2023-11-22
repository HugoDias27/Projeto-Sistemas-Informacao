<?php

namespace backend\controllers;

use common\models\Profile;
use common\models\ProfileSearch;
use common\models\User;
use common\models\UserSearch;
use frontend\models\SignupForm;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * UserController implements the CRUD actions for User model.
 */
class UserController extends Controller
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
     * Lists all User models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new UserSearch();
        $user_id = Yii::$app->user->identity->getId();
        $userRoles = Yii::$app->authManager->getRolesByUser($user_id);

        $dataProvider = $searchModel->search($this->request->queryParams);

        foreach ($userRoles as $role) {
            if ($role->name === 'admin') {
                return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
                ]);
            } else if ($role->name === 'funcionario') {
                $authManager = Yii::$app->authManager;
                $clienteRole = $authManager->getRole('cliente');

                $dataProvider->query->innerJoin('auth_assignment', 'auth_assignment.user_id = user.id')
                    ->andWhere(['auth_assignment.item_name' => $clienteRole->name]);
            }
        }

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single User model.
     * @param int $id
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', ['model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new User model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new User();
        $modelProfile = new Profile();
        $modelSignup = new SignupForm();
        $user_id = Yii::$app->user->identity->getId();
        $userRoles = Yii::$app->authManager->getRolesByUser($user_id);

        foreach ($userRoles as $role) {
            if ($role->name === 'admin') {
                $roleList = ['cliente' => 'Cliente', 'funcionario' => 'Funcionário', 'admin' => 'Admin'];
            } else if ($role->name === 'funcionario') {
                $roleList = ['cliente' => 'Cliente'];
            }
        }

        if ($this->request->isPost) {
            $post = $this->request->post();

            if ($modelSignup->load($post) && $modelSignup->validate()) {
                $model->username = $post['SignupForm']['username'];
                $model->email = $post['SignupForm']['email'];
                $model->setPassword($post['SignupForm']['password']);
                $model->generateAuthKey();
                $model->status = 10;
                $model->save(false);
                if ($model->save()) {
                    $userId = $model->id;
                    $role = $post['User']['role'];

                    $auth = \Yii::$app->authManager;
                    $funcionarioRole = $auth->getRole($role);
                    $auth->assign($funcionarioRole, $userId);

                    $modelProfile->n_utente = $post['Profile']['n_utente'];
                    $modelProfile->nif = $post['Profile']['nif'];
                    $modelProfile->morada = $post['Profile']['morada'];
                    $modelProfile->telefone = $post['Profile']['telefone'];
                    $modelProfile->user_id = $userId;

                    if ($modelProfile->save()) {
                        return $this->redirect(['view', 'id' => $model->id]);
                    }
                }
            } else {
                $model->loadDefaultValues();
            }
        }

        return $this->render('create', [
            'model' => $model,
            'modelProfile' => $modelProfile,
            'modelSignup' => $modelSignup,
            'roleList' => $roleList,
        ]);
    }

    /**
     * Updates an existing User model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $modelProfile = $this->findModelProfile($id);

        if ($modelProfile !== null) {
            $post = $this->request->post();

            if ($this->request->isPost && $modelProfile->load($post) && $modelProfile->save()) {
                // Atualiza e salva os dados do modelo
                $modelProfile->morada = $post['Profile']['morada'];
                $modelProfile->telefone = $post['Profile']['telefone'];
                $modelProfile->save();

                return $this->redirect(['view', 'id' => $modelProfile->user_id]);
            }

            return $this->render('update', ['modelProfile' => $modelProfile,]);
        } else {
            return $this->redirect(['createuser', 'id' => $id]); // Substitua 'create' com a rota correta
        }
    }

    public function actionCreateuser($id)
    {

        $modelProfile = Profile::findOne(['user_id' => $id]);

        if ($modelProfile !== null) {
            // Se um perfil já existe para este usuário, redirecionar para a página inicial (index)
            return $this->redirect(['index']); // Substitua 'index' pelo nome da sua ação de página inicial
        }

        $modelProfile = new Profile();
        $modelProfile->user_id = $id;

        if ($this->request->isPost) {
            if ($modelProfile->load($this->request->post()) && $modelProfile->save()) {
                return $this->redirect(['view', 'id' => $modelProfile->user_id]);
            }
        } else {
            $modelProfile->loadDefaultValues();
        }

        return $this->render('createuser', [
            'modelProfile' => $modelProfile,
        ]);
    }


    /**
     * Deletes an existing User model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $user = $this->findModel($id);
        $profile = Profile::findOne(['user_id' => $user->id]);

        if ($profile !== null) {
            $profile->delete();
        }
        $user->delete();
        return $this->redirect(['index']);
    }


    /**
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = User::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    protected function findModelProfile($id)
    {
        if (($model = Profile::findOne(['user_id' => $id])) !== null) {
            return $model;
        }

        //throw new NotFoundHttpException('The requested page does not exist.');
    }
}
