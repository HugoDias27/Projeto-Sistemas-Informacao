<?php

namespace backend\modules\api\controllers;

use backend\modules\api\components\CustomAuth;
use Yii;
use yii\rest\ActiveController;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;

class ReceitamedicaController extends ActiveController
{
    //Variáveis dos Modelos
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


    //Método onde mostra as receitas do cliente que está logo
    public function actionMinhareceita($clienteid)
    {
        if (Yii::$app->params['id'] != 1 || Yii::$app->params['id'] != 2) {

            $receitaModel = new $this->modelClass;
            $receitas = $receitaModel::find()->where(['user_id' => $clienteid])->all();

            $dataAtual = date('Y-m-d');

            foreach ($receitas as $receita) {
                if ($receita->data_validade <= $dataAtual || $receita->valido == 0) {
                    $receita->valido = 'Não';
                    $receita->save($receita->valido = 0);
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
                return [];
            }
        } else {
            throw new \yii\web\ForbiddenHttpException('Proibido');
        }
    }


    //Método onde mostra as receitas que estão válidas
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
