<?php

namespace backend\modules\api\controllers;

use backend\modules\api\components\CustomAuth;
use Yii;
use yii\rest\ActiveController;

class EstabelecimentoController extends ActiveController
{
    //Variável do Modelo
    public $modelClass = 'common\models\Estabelecimento';
    public $faturaModelClass = 'common\models\Fatura';

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

    //Método da API custom onde mostra os estabelecimentos com mais vendas
    public function actionEstabelecimentocommaisvendas()
    {
        $faturaModel = new $this->faturaModelClass;

        $estabelecimentoComMaisVendas = $faturaModel::find()
            ->select(['estabelecimentos.nome as nomeEstabelecimento', 'COUNT(faturas.id) as totalVendas'])
            ->innerJoin('estabelecimentos', 'faturas.estabelecimento_id = estabelecimentos.id')
            ->groupBy(['estabelecimentos.nome'])
            ->orderBy(['totalVendas' => SORT_DESC])
            ->limit(1)
            ->asArray()
            ->one();

        if ($estabelecimentoComMaisVendas) {
            $estabelecimentoNome = $estabelecimentoComMaisVendas['nomeEstabelecimento'];

            return $estabelecimentoNome;
        }

        throw new \yii\web\NotFoundHttpException('Nenhum estabelecimento encontrado.');
    }
}
