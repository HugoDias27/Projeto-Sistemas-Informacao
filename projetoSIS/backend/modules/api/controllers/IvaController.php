<?php

namespace backend\modules\api\controllers;

use backend\modules\api\components\CustomAuth;
use Yii;
use yii\rest\ActiveController;

class IvaController extends ActiveController
{
    public $modelClass = 'common\models\Iva';

    //Método que chama o método de autenticação da API
    public function behaviors()
    {
        Yii::$app->params['id'] = 0;
        Yii::$app->params['auth_key'] = 0;
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => CustomAuth::className(),
        ];
        return $behaviors;
    }

    //Método de autorização de o utilizador pode ou não aceder a uma determinada ação
    public function checkAccess($action, $model = null, $params = [])
    {
        if (Yii::$app->params['id'] == 1 || Yii::$app->params['id'] == 2) {
            if ($action === "create" || $action === "update" || $action === "delete" || $action === "index") {
                throw new \yii\web\ForbiddenHttpException('Proibido');
            }
        }
    }

    //Método que retorna o index
    public function actionIndex()
    {
        return $this->render('index');
    }

    //Método onde mostra os produtos com o iva ativo
    public function actionIvasativos()
    {
        $ivaModel = new $this->modelClass;
        $Ivasativos = $ivaModel::find()->where(['vigor' => 1])->all();

        if ($Ivasativos) {
            return $Ivasativos;
        }

        throw new \yii\web\NotFoundHttpException('Iva(s) não encontrado.');
    }

}