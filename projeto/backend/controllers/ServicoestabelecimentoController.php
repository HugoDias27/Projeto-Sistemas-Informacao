<?php

namespace backend\controllers;

use backend\models\Estabelecimento;
use backend\models\ServicoEstabelecimento;
use backend\models\ServicoEstabelecimentoSearch;
use common\models\Servico;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * ServicoestabelecimentoController implements the CRUD actions for ServicoEstabelecimento model.
 */
class ServicoestabelecimentoController extends Controller
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
                'access' => [
                    'class' => AccessControl::className(),
                    'rules' => [
                        [
                            'actions' => ['index', 'view', 'create', 'update'],
                            'allow' => true,
                            'roles' => ['admin', 'funcionario'],
                        ],
                        [
                            'actions' => ['delete'],
                            'allow' => true,
                            'roles' => ['admin'],
                        ],
                    ]
                ]
            ]
        );
    }

    /**
     * Lists all ServicoEstabelecimento models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new ServicoEstabelecimentoSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single ServicoEstabelecimento model.
     * @param int $estabelecimento_id Estabelecimento ID
     * @param int $servico_id Servico ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($estabelecimento_id, $servico_id)
    {
        $servicoEstabelecimento = $this->findModel($estabelecimento_id, $servico_id);
        $nomeServico = $servicoEstabelecimento->servico->nome;
        $nomeEstabelecimento = $servicoEstabelecimento->estabelecimento->nome;

        return $this->render('view', [
            'servicoEstabelecimento' => $servicoEstabelecimento, 'nomeServico' => $nomeServico, 'nomeEstabelecimento' => $nomeEstabelecimento,
        ]);
    }

    /**
     * Creates a new ServicoEstabelecimento model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $servicoEstabelecimento = new ServicoEstabelecimento();
        $servicoList = Servico::find()->all();
        $servicoItems = ArrayHelper::map($servicoList, 'id', 'nome');
        $estabelecimentoList = Estabelecimento::find()->all();
        $estabelecimentoItems = ArrayHelper::map($estabelecimentoList, 'id', 'nome');

        if ($this->request->isPost) {
            if ($servicoEstabelecimento->load($this->request->post()) && $servicoEstabelecimento->save()) {
                return $this->redirect(['view', 'estabelecimento_id' => $servicoEstabelecimento->estabelecimento_id, 'servico_id' => $servicoEstabelecimento->servico_id]);
            }
        } else {
            $servicoEstabelecimento->loadDefaultValues();
        }

        return $this->render('create', [
            'servicoEstabelecimento' => $servicoEstabelecimento,
            'servicos' => $servicoItems,
            'estabelecimentos' => $estabelecimentoItems,
        ]);
    }

    /**
     * Updates an existing ServicoEstabelecimento model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $estabelecimento_id Estabelecimento ID
     * @param int $servico_id Servico ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($estabelecimento_id, $servico_id)
    {
        $servicoEstabelecimento = $this->findModel($estabelecimento_id, $servico_id);
        $servicoList = Servico::find()->all();
        $servicoItems = ArrayHelper::map($servicoList, 'id', 'nome');
        $estabelecimentoList = Estabelecimento::find()->all();
        $estabelecimentoItems = ArrayHelper::map($estabelecimentoList, 'id', 'nome');

        if ($this->request->isPost && $servicoEstabelecimento->load($this->request->post()) && $servicoEstabelecimento->save()) {
            return $this->redirect(['view', 'estabelecimento_id' => $servicoEstabelecimento->estabelecimento_id, 'servico_id' => $servicoEstabelecimento->servico_id]);
        }

        return $this->render('update', [
            'servicoEstabelecimento' => $servicoEstabelecimento,
            'servicos' => $servicoItems,
            'estabelecimentos' => $estabelecimentoItems,
        ]);
    }

    /**
     * Deletes an existing ServicoEstabelecimento model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $estabelecimento_id Estabelecimento ID
     * @param int $servico_id Servico ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($estabelecimento_id, $servico_id)
    {
        $this->findModel($estabelecimento_id, $servico_id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the ServicoEstabelecimento model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $estabelecimento_id Estabelecimento ID
     * @param int $servico_id Servico ID
     * @return ServicoEstabelecimento the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($estabelecimento_id, $servico_id)
    {
        if (($model = ServicoEstabelecimento::findOne(['estabelecimento_id' => $estabelecimento_id, 'servico_id' => $servico_id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
