<?php

namespace backend\modules\api\controllers;

use backend\modules\api\components\CustomAuth;
use Yii;
use yii\rest\ActiveController;

class ReceitamedicaController extends ActiveController
{
    public $modelClass = 'common\models\ReceitaMedica';
    public $modelProdutoClass = 'common\models\Produto';

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

    public function actionMinhareceita($clienteid)
    {
        $receitaModel = new $this->modelClass;
        $receitas = $receitaModel::find()->where(['user_id' => $clienteid])->all();

        $dataAtual = date('Y-m-d');

        foreach ($receitas as $receita) {
            if ($receita->data_validade <= $dataAtual) {
                $receita->valido = 'Não';
            } else {
                $receita->valido = 'Sim';
            }

            $produtoModel = new $this->modelProdutoClass;
            $produto = $produtoModel::findOne($receita->posologia);

            if ($produto) {
                $receita->posologia = $produto->nome;
            } else {
                $receita->posologia = 'Nome do produto não encontrado';
            }
        }

        if ($receitas) {
            return $receitas;
        } else {
            throw new \yii\web\NotFoundHttpException('Dados não encontrados.');
        }
    }


    public function actionReceitasvalidas()
    {
        $receitaModel = new $this->modelClass;
        $data = date('Y-m-d');
        $receitas = $receitaModel::find()->where(['data_validade' => $data])->all();

        if ($receitas) {
            return $receitas;
        } else {
            throw new \yii\web\NotFoundHttpException('Dados não encontrados.');
        }
    }
}
