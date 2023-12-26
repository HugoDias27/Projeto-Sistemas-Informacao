<?php

namespace backend\controllers;

use backend\models\Estabelecimento;
use common\models\Fatura;
use common\models\FaturaSearch;
use common\models\LinhaFatura;
use common\models\Produto;
use common\models\Profile;
use common\models\ReceitaMedica;
use common\models\Servico;
use common\models\User;
use Yii;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * FaturaController implements the CRUD actions for Fatura model.
 */
class FaturaController extends Controller
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
                            'actions' => ['view'],
                            'allow' => true,
                            'roles' => ['admin', 'funcionario', 'cliente'],
                        ],
                        [
                            'actions' => ['index', 'create', 'update', 'delete'],
                            'allow' => true,
                            'roles' => ['admin', 'funcionario'],
                        ],
                    ],
                ]
            ]
        );
    }

    /**
     * Lists all Fatura models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new FaturaSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        $dataProvider->query->joinWith('user');


        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,

        ]);
    }


    /**
     * Displays a single Fatura model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $fatura = $this->findModel($id);

        $estabelecimento = Estabelecimento::find()->where(['id' => $fatura->estabelecimento_id])->one();

        $cliente = User::find()->where(['id' => $fatura->cliente_id])->one();
        $perfilCliente = $cliente->profiles;

        $linhasFatura = LinhaFatura::find()->where(['fatura_id' => $id])->all();


        $servicosids = ArrayHelper::getColumn($linhasFatura, 'servico_id');
        $servicos = Servico::find()
            ->where(['id' => $servicosids])
            ->all();

        $receitasids = ArrayHelper::getColumn($linhasFatura, 'receita_medica_id');
        $receitas = ReceitaMedica::find()
            ->where(['id' => $receitasids])
            ->all();


        return $this->render('view', [
            'fatura' => $fatura,
            'estabelecimento' => $estabelecimento,
            'cliente' => $cliente,
            'perfilCliente' => $perfilCliente,
            'linhasFatura' => $linhasFatura,
            'servicos' => $servicos,
            'receitas' => $receitas,
        ]);
    }

    /**
     * Creates a new Fatura model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $fatura = new Fatura();
        $estabelecimentos = Estabelecimento::find()->all();
        $estabelecimentosItems = ArrayHelper::map($estabelecimentos, 'id', 'nome');


        $authManager = Yii::$app->authManager;
        $clienteRole = $authManager->getRole('cliente');
        $clientes = User::find()
            ->innerJoin('auth_assignment', 'auth_assignment.user_id = user.id')
            ->andWhere(['auth_assignment.item_name' => $clienteRole->name])
            ->all();
        $clientesItems = ArrayHelper::map($clientes, 'id', 'username');

        if ($this->request->isPost) {
            $perfilEmissor = Profile::findOne(['user_id' => Yii::$app->user->id]);
            if (!$perfilEmissor) {
                Yii::$app->session->setFlash('error', 'O utilizador não tem o perfil criado.');
                return $this->redirect('index');
            }

            $fatura->dta_emissao = date('Y-m-d');
            $fatura->emissor_id = Yii::$app->user->id;
            $fatura->valortotal = 0;
            $fatura->ivatotal = 0;

            if ($fatura->load($this->request->post()) && $fatura->save()) {
                $estabelecimento = $fatura->estabelecimento_id;
                $cliente = $fatura->cliente_id;
                return $this->redirect(['linhafatura/create', 'id_fatura' => $fatura->id, 'estabelecimento_id' => $estabelecimento, 'cliente' => $cliente]);
            }
        } else {
            $fatura->loadDefaultValues();
        }

        return $this->render('create', [
            'fatura' => $fatura,
            'estabelecimento' => $estabelecimentosItems,
            'cliente' => $clientesItems,
        ]);
    }

    /**
     * Updates an existing Fatura model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $fatura = Fatura::find()->where(['id' => $id])->one();

        $linhafatura = LinhaFatura::find()->where(['fatura_id' => $id])->one();
        $receitaMedicaid = $linhafatura->receita_medica_id;

        $receitaMedica = ReceitaMedica::find()->where(['id' => $receitaMedicaid])->one();

        $receitaMedica->valido = 0;

        $fatura->save();
        $receitaMedica->save();
        return $this->redirect(['index']);
    }

    /**
     * Deletes an existing Fatura model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $linhasFatura = LinhaFatura::find()->where(['fatura_id' => $id])->all();
        foreach ($linhasFatura as $linhaFatura) {
            $linhaFatura->delete();
        }
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Fatura model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Fatura the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Fatura::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
