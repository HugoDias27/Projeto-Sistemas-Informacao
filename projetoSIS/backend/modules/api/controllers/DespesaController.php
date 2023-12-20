<?php

namespace backend\modules\api\controllers;

use backend\modules\api\components\CustomAuth;
use Yii;
use yii\rest\ActiveController;

class DespesaController extends ActiveController
{
    public $modelClass = 'common\models\Despesa';

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

    public function actionDespesasentreprecos($precoMin, $precoMax)
    {
        $despesaModel = new $this->modelClass;
        $despesas = $despesaModel::find()->where(['between', 'preco', $precoMin, $precoMax])->all();

        if ($despesas) {
            return $despesas;
        } else {
            throw new \yii\web\NotFoundHttpException('Despesa(s) não encontrada.');
        }
    }


}
