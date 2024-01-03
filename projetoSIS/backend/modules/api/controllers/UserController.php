<?php

namespace backend\modules\api\controllers;

use backend\modules\api\components\CustomAuth;
use Yii;
use yii\rest\ActiveController;

class UserController extends ActiveController
{

    public $modelClass = 'common\models\User';
    public $modelFaturaClass = 'common\models\Fatura';
    public $modelLinhaFaturaClass = 'common\models\LinhaFatura';
    public $modelLinhaCarrinhoClass = 'common\models\LinhaCarrinho';
    public $modelCarrinhoClass = 'common\models\CarrinhoCompra';
    public $modelProdutoClass = 'common\models\Produto';
    public $modelServicoClass = 'common\models\Servico';

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => CustomAuth::className(),
        ];

        // Desabilitar o autenticador para a ação de criar usuários
        if (Yii::$app->controller->action->id === 'criarusers') {
            unset($behaviors['authenticator']);
        }

        return $behaviors;
    }

    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionCriarusers()
    {
        $userModel = new $this->modelClass;
        $request = Yii::$app->request;

        $username = $request->getBodyParam('username');
        $password = $request->getBodyParam('password');
        $email = $request->getBodyParam('email');


        $userModel->username = $username;
        $userModel->setPassword($password);
        $userModel->generateAuthKey();
        $userModel->email = $email;
        $userModel->status = 10;


        if ($userModel->save()) {
            return ['resposta' => true];
        } else {
            return ['resposta' => false];
        }
    }


    public function actionClientes()
    {
        $clienteModel = new $this->modelClass;
        $clientes = $clienteModel::find()
            ->select(['user.id', 'user.username', 'user.email', 'profiles.n_utente', 'profiles.nif', 'profiles.morada', 'profiles.telefone'])
            ->leftJoin('auth_assignment', 'user.id = auth_assignment.user_id')
            ->leftJoin('auth_item', 'auth_assignment.item_name = auth_item.name')
            ->leftJoin('profiles', 'user.id = profiles.user_id')
            ->where(['auth_item.name' => 'cliente'])
            ->asArray()
            ->all();

        if ($clientes) {
            return $clientes;
        } else {
            throw new \yii\web\NotFoundHttpException('Cliente(s) não encontrado.');

        }
    }

    public function actionFuncionarios()
    {
        $clienteModel = new $this->modelClass;
        $clientes = $clienteModel::find()
            ->select(['user.id', 'user.username', 'user.email', 'profiles.n_utente', 'profiles.nif', 'profiles.morada', 'profiles.telefone'])
            ->leftJoin('auth_assignment', 'user.id = auth_assignment.user_id')
            ->leftJoin('auth_item', 'auth_assignment.item_name = auth_item.name')
            ->leftJoin('profiles', 'user.id = profiles.user_id')
            ->where(['auth_item.name' => 'funcionario'])
            ->asArray()
            ->all();

        if ($clientes) {
            return $clientes;
        } else {
            throw new \yii\web\NotFoundHttpException('Funcionario(s) não encontrado.');
        }
    }

    public function actionEstatisticas($id)
    {
        $userModel = new $this->modelClass;
        $perfilCliente = $userModel::findOne($id);

        $faturaModel = new $this->modelFaturaClass;
        $linhaFaturaModel = new $this->modelLinhaFaturaClass;
        $servicoModel = new $this->modelServicoClass;
        $carrinhoModel = new $this->modelCarrinhoClass;
        $linhaCarrinhoModel = new $this->modelLinhaCarrinhoClass;
        $produtoModel = new $this->modelProdutoClass;

        if ($perfilCliente) {
            $faturasCliente = $faturaModel::find()->where(['cliente_id' => $id])->all();

            $totalPrecoFaturas = 0;
            $produtosCliente = [];
            $servicosCliente = [];

            foreach ($faturasCliente as $fatura) {
                $totalPrecoFaturas += $fatura->valortotal;

                $carrinho = $carrinhoModel::findOne(['fatura_id' => $fatura->id]);

                if ($carrinho) {
                    $linhasCarrinho = $linhaCarrinhoModel::find()->where(['carrinho_compra_id' => $carrinho->id])->all();

                    foreach ($linhasCarrinho as $linhaCarrinho) {
                        $produto = $produtoModel::findOne($linhaCarrinho->produto_id);

                        if ($produto) {
                            $produtosCliente[] = ['nome' => $produto->nome, 'preco unitário' => $produto->preco];
                        }
                    }
                }

                $linhasFatura = $linhaFaturaModel::find()->where(['fatura_id' => $fatura->id])->all();

                foreach ($linhasFatura as $linhaFatura) {
                    $servico = $servicoModel::findOne(['id' => $linhaFatura->servico_id]);

                    if ($servico) {
                        $servicosCliente[] = ['nome' => $servico->nome, 'preco' => $servico->preco];
                    }
                }
            }

            return ['produtos' => $produtosCliente, 'totalPrecoFaturas' => $totalPrecoFaturas, 'servicos' => $servicosCliente];
        }

        throw new \yii\web\NotFoundHttpException('Dados não encontrado.');
    }

    public function actionContarcompras($id)
    {
        $faturaModel = new $this->modelFaturaClass;

        $numeroFaturas = $faturaModel::find()->where(['cliente_id' => $id])->count();

        if($numeroFaturas) {

            return $numeroFaturas;
        }
        throw new \yii\web\NotFoundHttpException('Não foram realizadas compras.');
    }
}