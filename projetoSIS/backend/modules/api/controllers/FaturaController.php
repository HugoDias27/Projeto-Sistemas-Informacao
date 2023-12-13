<?php

namespace backend\modules\api\controllers;

use backend\modules\api\components\CustomAuth;
use Yii;
use yii\rest\ActiveController;

class FaturaController extends ActiveController
{
    public $modelClass = 'common\models\Fatura';

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

    public function actionFaturasporcliente($id)
    {
        $faturaModel = new $this->modelClass;
        $faturas = $faturaModel::find()->where(['cliente_id' => $id])->all();

        if($faturas) {
            return $faturas;
        }
        else
        {
            throw new \yii\web\NotFoundHttpException('Fatura(s) não encontrado.');
        }
    }
}