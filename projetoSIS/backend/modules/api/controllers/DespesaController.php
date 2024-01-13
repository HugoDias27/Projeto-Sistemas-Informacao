<?php

namespace backend\modules\api\controllers;

use backend\modules\api\components\CustomAuth;
use common\models\User;
use Yii;
use yii\rest\ActiveController;
use yii\web\ForbiddenHttpException;

class DespesaController extends ActiveController
{
    //Variável do Modelo
    public $modelClass = 'common\models\Despesa';


    //Método que chama o método de autenticação da API
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

    //Método da API custom onde mostra as despesas entre dois preços(min e max)
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

    //Método da API custom onde mostra as despesas entre duas datas(inicial e final)
    public function actionDespesasentredatas()
    {
        $dataInicial = Yii::$app->request->get('datainicial');
        $dataFinal = Yii::$app->request->get('datafinal');

        $despesaModel = new $this->modelClass;
        $despesas = $despesaModel::find()->where(['between', 'dta_despesa', $dataInicial, $dataFinal])->all();

        if ($despesas) {
            return $despesas;
        } else {
            throw new \yii\web\NotFoundHttpException('Despesa(s) não encontrada.');
        }
    }
}
