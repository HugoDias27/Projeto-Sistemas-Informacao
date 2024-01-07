<?php

namespace backend\modules\api\controllers;

use backend\modules\api\components\CustomAuth;
use common\models\User;
use Yii;
use yii\rest\ActiveController;
use yii\web\ForbiddenHttpException;

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


    public function checkAccess($action, $model = null, $params = [])
    {
        if (Yii::$app->params['id'] == 1 || Yii::$app->params['id'] == 2) {
            if ($action === "create") {
                throw new \yii\web\ForbiddenHttpException('Proibido');
            }
        }
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
