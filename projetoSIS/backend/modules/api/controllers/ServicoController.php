<?php

namespace backend\modules\api\controllers;

use backend\modules\api\components\CustomAuth;
use Yii;
use yii\rest\ActiveController;

class ServicoController extends ActiveController
{
    //Variáveis dos modelos
    public $modelClass = 'common\models\Servico';
    public $estabelecimentoModelClass = 'common\models\Estabelecimento';
    public $ivaModelClass = 'common\models\Iva';

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

    //Método onde mostra os serviços de um estabelecimento
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
