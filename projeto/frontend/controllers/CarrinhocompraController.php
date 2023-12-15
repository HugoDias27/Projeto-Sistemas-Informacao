<?php

namespace frontend\controllers;

use common\models\CarrinhoCompra;
use common\models\CarrinhoCompraSearch;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * CarrinhocompraController implements the CRUD actions for CarrinhoCompra model.
 */
class CarrinhocompraController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all CarrinhoCompra models.
     *
     * @return string
     */
    public function actionIndex()
    {
        /*$searchModel = new CarrinhoCompraSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);*/

        $userId = Yii::$app->user->id;

        $carrinho = CarrinhoCompra::find()
            ->where([
                'cliente_id' => $userId,
                'fatura_id' => null, // Carrinho sem compra efetuada com sucesso
            ])
            ->orderBy([SORT_DESC])
            ->one();

        if ($carrinho !== null) {
            // Obter as linhas de carrinho associadas ao carrinho
            $linhasCarrinho = LinhaCarrinho::find()
                ->where(['carrinho_compra_id' => $carrinho->id])
                ->all();

            return $this->render('carrinhocompra', [
                'carrinho' => $carrinho,
                'linhasCarrinho' => $linhasCarrinho,
            ]);
        }

        // Caso não exista carrinho válido
        throw new NotFoundHttpException('Não foi encontrado um carrinho de compras válido para o usuário logado.');
    }

    /**
     * Displays a single CarrinhoCompra model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new CarrinhoCompra model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new CarrinhoCompra();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing CarrinhoCompra model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing CarrinhoCompra model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the CarrinhoCompra model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return CarrinhoCompra the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = CarrinhoCompra::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
