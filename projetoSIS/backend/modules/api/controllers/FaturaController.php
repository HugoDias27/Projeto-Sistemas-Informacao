<?php

namespace backend\modules\api\controllers;

use backend\modules\api\components\CustomAuth;
use common\models\Fatura;
use Yii;
use yii\rest\ActiveController;

class FaturaController extends ActiveController
{
    public $modelClass = 'common\models\Fatura';
    public $modelClassCarrinho = 'common\models\CarrinhoCompra';
    public $modelClassLinhaCarrinho = 'common\models\LinhaCarrinho';

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

    public function actionFaturasporcliente($id)
    {
        $faturaModel = new $this->modelClass;
        $faturas = $faturaModel::find()->where(['cliente_id' => $id])->all();

        if ($faturas) {
            return $faturas;
        } else {
            throw new \yii\web\NotFoundHttpException('Fatura(s) não encontrado.');
        }
    }

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