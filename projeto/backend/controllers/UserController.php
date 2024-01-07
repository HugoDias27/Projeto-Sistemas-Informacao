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
     * Lists all User models.
     *
     * @return string
     */
    // Método que vai para o index onde mostra todos os utilizadores
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

                $dataProvider->query->innerJoin('auth_assignment', 'auth_assignment.user_id = user.id')->andWhere(['auth_assignment.item_name' => $clienteRole->name]);
            }
        }

        return $this->render('index', ['searchModel' => $searchModel, 'dataProvider' => $dataProvider]);
    }

    /**
     * Displays a single User model.
     * @param int $id
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    // Método que vai para a view de um utilizador
    public function actionView($id)
    {
        if (\Yii::$app->user->can('viewUser')) {

            return $this->render('view', ['model' => $this->findModel($id)]);
        }
        throw new NotFoundHttpException('Não tem permissões para aceder a esta página');

    }

    /**
     * Creates a new User model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    // Método que permite criar um novo utilizador
    public function actionCreate()
    {
        $model = new User();

        if (\Yii::$app->user->can('createUser')) {

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
                            return $this->redirect('index');
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
        throw new NotFoundHttpException('Não tem permissões para aceder a esta página');
    }

    /**
     * Updates an existing User model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    // Método que permite atualizar um utilizador
    public function actionUpdate($id)
    {
        $modelProfile = $this->findModelProfile($id);

        if (\Yii::$app->user->can('updateUser')) {

            if ($modelProfile !== null) {
                return $this->redirect(['profile/update', 'id' => $id]);
            } else {
                return $this->redirect(['profile/create', 'id' => $id]);
            }
        }
        throw new NotFoundHttpException('Não tem permissões para aceder a esta página');
    }


    /**
     * Deletes an existing User model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    // Método que permite apagar um utilizador
    public function actionDelete($id)
    {
        $user = $this->findModel($id);

        if (\Yii::$app->user->can('deleteUser')) {
            $profile = Profile::findOne(['user_id' => $user->id]);

            if ($profile !== null) {
                $profile->delete();
            }
            $user->delete();
            return $this->redirect(['index']);
        }
        throw new NotFoundHttpException('Não tem permissões para aceder a esta página');
    }


    /**
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    // Método que permite encontrar o utilizador selecionado
    protected function findModel($id)
    {
        if (($model = User::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    // Método que permite encontrar o perfil do utilizador selecionado
    protected function findModelProfile($id)
    {
        if (($model = Profile::findOne(['user_id' => $id])) !== null) {
            return $model;
        }

        //throw new NotFoundHttpException('The requested page does not exist.');
    }
}
