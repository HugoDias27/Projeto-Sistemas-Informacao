<?php

namespace backend\modules\api\controllers;

use Yii;
use yii\rest\ActiveController;
use yii\web\ForbiddenHttpException;

class LoginController extends ActiveController
{
    public $modelClass = 'common\models\User';

    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionLogin()
    {
        $userModel = new $this->modelClass;
        $request = Yii::$app->request;
        $username = $request->getBodyParam('username');
        $password = $request->getBodyParam('password');

       if (empty($username) || empty($password)) {
            throw new ForbiddenHttpException('Nome de usuário ou senha ausente na solicitação');
       }

        $user = $userModel::find()->where(['username' => $username])->one();
        $id = $user->id;

        if (!$user || !$user->validatePassword($password)) {
            throw new ForbiddenHttpException('Nome de usuário ou senha incorretos');
        }

        $auth_key = $user->getAuthKey();

        if (!$auth_key) {
            throw new \yii\web\ServerErrorHttpException('Erro ao recuperar a chave de autenticação');
        }

        return ['id' => $id, 'auth_key' => $auth_key];
    }
}