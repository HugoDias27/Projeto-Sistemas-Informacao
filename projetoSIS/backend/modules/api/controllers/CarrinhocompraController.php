<?php

namespace backend\modules\api\controllers;

use backend\modules\api\components\CustomAuth;
use Yii;
use yii\helpers\Url;
use yii\rest\ActiveController;

class CarrinhocompraController extends ActiveController
{

    public $modelClass = 'common\models\CarrinhoCompra';
    public $modelClassUser = 'common\models\User';


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


    public function actionCarrinhocompra($userid)
    {
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
    }
}