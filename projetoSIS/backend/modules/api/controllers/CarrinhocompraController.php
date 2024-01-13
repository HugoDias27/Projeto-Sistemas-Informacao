<?php

namespace backend\modules\api\controllers;

use backend\modules\api\components\CustomAuth;
use common\models\Produto;
use DateTime;
use Yii;
use yii\rest\ActiveController;

class CarrinhocompraController extends ActiveController
{

    //Variáveis dos Modelos
    public $modelClass = 'common\models\CarrinhoCompra';
    public $modelClassUser = 'common\models\User';
    public $modelClassLinhaCarrinho = 'common\models\LinhaCarrinho';
    public $modelClassProduto = 'common\models\Produto';

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

    //Método que cria o carrinho de compras - API
    public function actionCarrinhocompra($userid)
    {
        if (Yii::$app->params['id'] != 1 || Yii::$app->params['id'] != 2) {


            $userModel = new $this->modelClassUser;
            $user = $userModel::findOne(['id' => $userid]);
            $authKey = $user->getAuthKey();

            $request = Yii::$app->request;
            $produtoid = $request->getBodyParam('produto');
            $quantidade = $request->getBodyParam('quantidade');

            $carrinhoModel = new $this->modelClass;
            $ultimoCarrinho = $carrinhoModel::find()->where(['cliente_id' => $userid, 'fatura_id' => null])->orderBy(['dta_venda' => SORT_DESC])->one();

            if ($ultimoCarrinho === null) {
                $carrinhoModel->dta_venda = date('Y-m-d');
                $carrinhoModel->quantidade = 0;
                $carrinhoModel->valortotal = 0;
                $carrinhoModel->ivatotal = 0;
                $carrinhoModel->cliente_id = $userid;

                if ($carrinhoModel->save()) {
                    return $this->redirect(['linhacarrinho/createcarrinho', 'produtoid' => $produtoid, 'quantidade' => $quantidade, 'userid' => $userid, 'auth_key' => $authKey]);

                } else {
                    throw new \yii\web\NotFoundHttpException('Carrinho não criado.');
                }
            } else {
                return $this->redirect(['linhacarrinho/createcarrinho', 'produtoid' => $produtoid, 'quantidade' => $quantidade, 'userid' => $userid, 'auth_key' => $authKey]);
            }
        } else {
            throw new \yii\web\ForbiddenHttpException('Proibido');
        }
    }

    //Método o carrinho carrinho de compras - CURL
    public function actionCarrinhocompras($userid, $produto, $quantidade)
    {
        $userModel = new $this->modelClassUser;
        $user = $userModel::findOne(['id' => $userid]);
        $auth_key = $user->getAuthKey();

        $produtoid = $produto;
        $quantidadeProduto = $quantidade;

        $carrinhoModel = new $this->modelClass;
        $ultimoCarrinho = $carrinhoModel::find()->where(['cliente_id' => $userid, 'fatura_id' => null])->orderBy(['dta_venda' => SORT_DESC])->one();

        if ($ultimoCarrinho === null) {
            $carrinhoModel->dta_venda = date('Y-m-d');
            $carrinhoModel->quantidade = 0;
            $carrinhoModel->valortotal = 0;
            $carrinhoModel->ivatotal = 0;
            $carrinhoModel->cliente_id = $userid;

            if ($carrinhoModel->save()) {
                return $this->redirect(['linhacarrinho/carrinhoproduto', 'userid' => $userid, 'produtoid' => $produtoid, 'quantidadeProduto' => $quantidadeProduto, 'auth_key' => $auth_key]);

            } else {
                throw new \yii\web\ServerErrorHttpException('Carrinho não criado.');
            }
        } else {
            return $this->redirect(['linhacarrinho/carrinhoproduto', 'userid' => $userid, 'produtoid' => $produtoid, 'quantidadeProduto' => $quantidadeProduto, 'auth_key' => $auth_key]);
        }
    }

    //Método que retorna as compras do último mês de um utilizador
    public function actionUtilizadorescompraultimomes($userid)
    {
        $carrinhoModel = new $this->modelClass;
        $linhaCarrinhoModel = new $this->modelClassLinhaCarrinho;
        $produtoModel = new $this->modelClassProduto;

        $ultimoMes = (new DateTime('last month'))->format('Y-m-d');

        $compras = $carrinhoModel::find()
            ->select(['id', 'cliente_id', 'SUM(valortotal) AS total_gasto'])
            ->where(['cliente_id' => $userid])
            ->andWhere(['>', 'dta_venda', $ultimoMes])
            ->groupBy('cliente_id')
            ->asArray()
            ->all();

        $produtosComprados = [];

        foreach ($compras as $compra) {
            $linhasCarrinho = $linhaCarrinhoModel::find()
                ->where(['carrinho_compra_id' => $compra['id']])
                ->all();

            $nomesProdutos = [];

            foreach ($linhasCarrinho as $linhaCarrinho) {
                $produto = $produtoModel::findOne($linhaCarrinho->produto_id);
                if ($produto !== null) {
                    $nomesProdutos[] = $produto->nome;
                }
            }

            $produtosComprados[] = [
                'produtos_nome' => implode(', ', $nomesProdutos),
                'total_gasto' => $compra['total_gasto'],
            ];
        }
        return ['compras_ultimo_mes' => $produtosComprados];
    }
}