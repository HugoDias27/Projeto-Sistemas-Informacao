<?php

namespace backend\modules\api\controllers;

use backend\modules\api\components\CustomAuth;
use Yii;
use common\models\Estabelecimento;
use common\models\Fatura;
use yii\rest\ActiveController;

class EstabelecimentoController extends ActiveController
{
    public $modelClass = 'common\models\Estabelecimento';

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

    public function actionEstabelecimentocommaisvendas()
    {
        $estabelecimentoComMaisVendas = Fatura::find()
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
