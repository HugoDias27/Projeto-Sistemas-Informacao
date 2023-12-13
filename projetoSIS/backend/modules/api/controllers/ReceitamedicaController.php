<?php

namespace backend\modules\api\controllers;

use yii\rest\ActiveController;

class ReceitamedicaController extends ActiveController
{
    public $modelClass = 'common\models\ReceitaMedica';

    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionMinhareceita($cliente_id)
    {
        $receitaModel = new $this->modelClass;
        $receitas = $receitaModel::find()->where(['user_id' => $cliente_id])->all();
        return $receitas;
    }

    public function actionReceitasvalidas()
    {
        $receitaModel = new $this->modelClass;
        $data = date('Y-m-d');
        $receitas = $receitaModel::find()->where(['data_validade' => $data])->all();
        return $receitas;
    }
}
