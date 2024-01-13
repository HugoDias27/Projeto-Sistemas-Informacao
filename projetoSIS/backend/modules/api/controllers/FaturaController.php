<?php

namespace backend\modules\api\controllers;

use backend\modules\api\components\CustomAuth;
use common\models\Fatura;
use Yii;
use yii\rest\ActiveController;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;

class FaturaController extends ActiveController
{
    //Variáveis dos Modelos
    public $modelClass = 'common\models\Fatura';
    public $modelClassCarrinho = 'common\models\CarrinhoCompra';
    public $modelClassLinhaCarrinho = 'common\models\LinhaCarrinho';

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

    //Método onde mostra as faturas do cliente logado
    public function actionFaturasporcliente($id)
    {
        if (Yii::$app->params['id'] != 1 || Yii::$app->params['id'] != 2) {
            $faturaModel = new $this->modelClass;
            $faturas = $faturaModel::find()
                ->select(['id', 'dta_emissao', 'valortotal', 'ivatotal'])
                ->where(['cliente_id' => $id])
                ->all();

            if ($faturas) {
                return $faturas;
            } else {
                throw new \yii\web\NotFoundHttpException('Fatura(s) não encontrada(s).');
            }
        }
        else{
            throw new \yii\web\ForbiddenHttpException('Proibido');
        }
    }

   //Método onde cria a fatura quando o utilizador logado finaliza a compra
    public function actionCarrinhofatura($userid)
    {
        $carrinhoModel = new $this->modelClassCarrinho;

        $ultimoCarrinho = $carrinhoModel::find()
            ->where(['cliente_id' => $userid, 'fatura_id' => null])
            ->orderBy(['dta_venda' => SORT_DESC])
            ->one();

        $linhaCarrinhoModel = new $this->modelClassLinhaCarrinho;
        if ($ultimoCarrinho !== null) {
            $linhasCarrinho = $linhaCarrinhoModel::find()
                ->where(['carrinho_compra_id' => $ultimoCarrinho->id])
                ->all();

            $quantidadeTotal = 0;
            $valorTotal = 0;
            $ivaTotal = 0;

            foreach ($linhasCarrinho as $linha) {
                $quantidadeTotal += $linha->quantidade;
                $valorTotal += $linha->subtotal;
                $ivaTotal += $linha->valoriva;
            }

            $ultimoCarrinho->dta_venda = date('Y-m-d');
            $ultimoCarrinho->quantidade = $quantidadeTotal;
            $ultimoCarrinho->valortotal = $valorTotal;
            $ultimoCarrinho->ivatotal = $ivaTotal;

            $fatura = new Fatura();
            $fatura->valortotal = $valorTotal;
            $fatura->ivatotal = $ivaTotal;
            $fatura->dta_emissao = date('Y-m-d');
            $fatura->cliente_id = $ultimoCarrinho->cliente_id;

            if ($fatura->save()) {
                $ultimoCarrinho->fatura_id = $fatura->id;
                if ($ultimoCarrinho->save()) {
                    return ['resposta' => true];
                }
            }
        }

        throw new \yii\web\NotFoundHttpException('Erro no carrinho.');
    }
}