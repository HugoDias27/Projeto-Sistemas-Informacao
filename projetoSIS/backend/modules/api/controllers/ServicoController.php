<?php

namespace backend\modules\api\controllers;

use backend\modules\api\components\CustomAuth;
use Yii;
use yii\rest\ActiveController;

class ServicoController extends ActiveController
{
    public $modelClass = 'common\models\Servico';
    public $estabelecimentoModelClass = 'common\models\Estabelecimento';
    public $ivaModelClass = 'common\models\Iva';

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

    public function actionServicosporestabelecimento($nomeEstabelecimento)
    {
        $estabelecimentoModel = new $this->estabelecimentoModelClass;
        $estabelecimento = $estabelecimentoModel::findOne(['nome' => $nomeEstabelecimento]);

        $servicoModel = new $this->modelClass;
        $ivaModel = new $this->ivaModelClass;

        if ($estabelecimento) {
            $idEstabelecimento = $estabelecimento->id;

            $servicos = $servicoModel::find()
                ->innerJoin('servicos_estabelecimentos', 'servicos_estabelecimentos.servico_id = servicos.id')
                ->where(['servicos_estabelecimentos.estabelecimento_id' => $idEstabelecimento])
                ->all();

            if ($servicos) {
                foreach ($servicos as $servico) {
                    $ivaRelacionado = $ivaModel::findOne($servico->iva_id);

                    if ($ivaRelacionado) {
                        $precoComIva = $servico->preco * (1 + ($ivaRelacionado->percentagem / 100));
                        $servico->preco = $precoComIva;
                    }
                }

                $result = ['nome_estabelecimento' => $nomeEstabelecimento, 'servicos' => $servicos,];

                return $result;
            } else {
                throw new \yii\web\NotFoundHttpException('Nenhum serviço encontrado neste estabelecimento.');
            }
        } else {
            throw new \yii\web\NotFoundHttpException('Estabelecimento não encontrado.');
        }
    }
}
