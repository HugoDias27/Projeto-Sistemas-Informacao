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
    // Método que permite definir o que o utilizador tem permissão para fazer
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
    // Método que vai para o index dos serviços que os estabelecimentos realizam
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
    // Método que vai para a view de um serviço que o estabelecimento realiza
    public function actionView($estabelecimento_id, $servico_id)
    {
        if (\Yii::$app->user->can('viewServico')) {
            $servicoEstabelecimento = $this->findModel($estabelecimento_id, $servico_id);
            $nomeServico = $servicoEstabelecimento->servico->nome;
            $nomeEstabelecimento = $servicoEstabelecimento->estabelecimento->nome;

            return $this->render('view', [
                'servicoEstabelecimento' => $servicoEstabelecimento, 'nomeServico' => $nomeServico, 'nomeEstabelecimento' => $nomeEstabelecimento,
            ]);
        }
        throw new NotFoundHttpException('Não tem permissões para aceder a esta página');
    }

    /**
     * Creates a new ServicoEstabelecimento model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    // Método que permite associar um serviço a um estabelecimento
    public function actionCreate()
    {
        $servicoEstabelecimento = new ServicoEstabelecimento();

        if (\Yii::$app->user->can('createServico')) {
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
        throw new NotFoundHttpException('Não tem permissões para aceder a esta página');
    }

    /**
     * Deletes an existing ServicoEstabelecimento model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $estabelecimento_id Estabelecimento ID
     * @param int $servico_id Servico ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    // Método que permite apagar o serviço que o estabelecimento realiza
    public function actionDelete($estabelecimento_id, $servico_id)
    {
        if (\Yii::$app->user->can('deleteServico')) {
            $this->findModel($estabelecimento_id, $servico_id)->delete();

            return $this->redirect(['index']);
        }
        throw new NotFoundHttpException('Não tem permissões para aceder a esta página');
    }

    /**
     * Finds the ServicoEstabelecimento model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $estabelecimento_id Estabelecimento ID
     * @param int $servico_id Servico ID
     * @return ServicoEstabelecimento the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    // Método que permite encontrar a o serviço do estabelecimento selecionado
    protected function findModel($estabelecimento_id, $servico_id)
    {
        if (($model = ServicoEstabelecimento::findOne(['estabelecimento_id' => $estabelecimento_id, 'servico_id' => $servico_id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
