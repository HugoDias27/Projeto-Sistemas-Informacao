<?php

namespace backend\modules\api\controllers;

use backend\modules\api\components\CustomAuth;
use Yii;
use yii\rest\ActiveController;

class UserController extends ActiveController
{

    public $modelClass = 'common\models\User';

    public function behaviors()
    {
        Yii::$app->params['id'] = 0;
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => CustomAuth::className(),
        ];
        return $behaviors;
    }

    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionClientes()
    {
        $clienteModel = new $this->modelClass;
        $clientes = $clienteModel::find()
            ->select(['user.id', 'user.username', 'user.email', 'profiles.n_utente', 'profiles.nif', 'profiles.morada', 'profiles.telefone'])
            ->leftJoin('auth_assignment', 'user.id = auth_assignment.user_id')
            ->leftJoin('auth_item', 'auth_assignment.item_name = auth_item.name')
            ->leftJoin('profiles', 'user.id = profiles.user_id')
            ->where(['auth_item.name' => 'cliente'])
            ->asArray()
            ->all();

        if ($clientes) {
            return $clientes;
        } else {
            throw new \yii\web\NotFoundHttpException('Cliente(s) não encontrado.');

        }
    }

    public function actionFuncionarios()
    {
        $clienteModel = new $this->modelClass;
        $clientes = $clienteModel::find()
            ->select(['user.id', 'user.username', 'user.email', 'profiles.n_utente', 'profiles.nif', 'profiles.morada', 'profiles.telefone'])
            ->leftJoin('auth_assignment', 'user.id = auth_assignment.user_id')
            ->leftJoin('auth_item', 'auth_assignment.item_name = auth_item.name')
            ->leftJoin('profiles', 'user.id = profiles.user_id')
            ->where(['auth_item.name' => 'funcionario'])
            ->asArray()
            ->all();

        if ($clientes) {
            return $clientes;
        } else {
            throw new \yii\web\NotFoundHttpException('Funcionario(s) não encontrado.');
        }
    }

}