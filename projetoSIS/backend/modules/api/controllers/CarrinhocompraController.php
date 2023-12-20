<?php

namespace backend\modules\api\controllers;

use backend\modules\api\components\CustomAuth;
use Yii;
use yii\rest\ActiveController;

class CarrinhocompraController extends ActiveController
{

    public $modelClass = 'common\models\CarrinhoCompra';

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


    public function actionCarrinhocompra($id)
    {
        $carrinhoModel = new $this->modelClass;
        $carrinho = $carrinhoModel::find()->where(['cliente_id' => $id])->orderBy(['dta_venda' => SORT_DESC])->one();

        if($carrinho)
        {
            return $carrinho;
        }
        else
        {
            throw new \yii\web\NotFoundHttpException('Dados não encontrados.');
        }
    }

    public function actionCarrinhos($id)
    {
        $carrinhoModel = new $this->modelClass;
        $carrinho = $carrinhoModel::find()->where(['cliente_id' => $id])->all();

        if($carrinho)
        {
            return $carrinho;
        }
        else
        {
            throw new \yii\web\NotFoundHttpException('Dados não encontrados.');
        }
    }

}