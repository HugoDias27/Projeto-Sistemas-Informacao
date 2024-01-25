<?php

namespace backend\controllers;

use backend\models\Estabelecimento;
use backend\models\ServicoEstabelecimento;
use common\models\Fatura;
use common\models\Iva;
use common\models\LinhaFatura;
use common\models\LinhaFaturaSearch;
use common\models\Produto;
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
 * LinhaController implements the CRUD actions for LinhaFatura model.
 */
class LinhafaturaController extends Controller
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
                            'actions' => ['index', 'view', 'create', 'update', 'deletereceita', 'delete'],
                            'allow' => true,
                            'roles' => ['admin', 'funcionario'],
                        ],
                    ],
                ]
            ]
        );
    }

    /**
     * Lists all LinhaFatura models.
     *
     * @return string
     */
    // Método que vai para o index das linhas das respetivas faturas
    public function actionIndex($id, $fatura_id, $estabelecimento, $cliente)
    {
        $searchModel = new LinhaFaturaSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);
        $dataProvider->query->andWhere(['fatura_id' => $fatura_id]);

        $clientefind = User::find()->with('profiles')->where(['id' => $cliente])->one();
        $perfilCliente = $clientefind->profiles;

        $estabelecimentofind = Estabelecimento::find()->where(['id' => $estabelecimento])->one();

        $totallinhas = LinhaFatura::find()
            ->joinWith('servico')
            ->joinWith('receitaMedica')
            ->where(['fatura_id' => $fatura_id])
            ->all();

        $fatura = Fatura::find()->where(['id' => $fatura_id])->one();

        if ($totallinhas == null) {
            $fatura->valortotal = 0;
            $fatura->ivatotal = 0;
        }

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'fatura_id' => $fatura_id,
            'estabelecimento' => $estabelecimentofind,
            'cliente' => $clientefind,
            'perfilCliente' => $perfilCliente,
            'totallinhas' => $totallinhas,
            'fatura' => $fatura,
        ]);
    }



    /**
     * Displays a single LinhaFatura model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    // Método que vai para a view de uma linha da fatura
    public function actionView($id)
    {
        return $this->render('view', ['model' => $this->findModel($id)]);
    }

    /**
     * Creates a new LinhaFatura model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    // Método que permite criar uma nova linha da fatura
    public function actionCreate($id_fatura, $estabelecimento_id)
    {
        $linhafatura = new LinhaFatura();
        $receitas = ReceitaMedica::find()->where(['valido' => 1])->all();

        $receitasItems = ArrayHelper::map($receitas, 'id', 'codigo');

        $servicosestabelecimento = ServicoEstabelecimento::find()->where(['estabelecimento_id' => $estabelecimento_id])->all();
        $servicosids = ArrayHelper::getColumn($servicosestabelecimento, 'servico_id');

        $servicos = Servico::find()->where(['id' => $servicosids])->all();
        $servicosItems = ArrayHelper::map($servicos, 'id', 'nome');

        $fatura = Fatura::find()->where(['id' => $id_fatura])->one();

        $linhasFaturaExistente = LinhaFatura::find()->where(['fatura_id' => $id_fatura])->all();

        $fatura->valortotal = 0;
        $fatura->ivatotal = 0;


        $cliente_id = $fatura->cliente_id;

        foreach ($servicos as $item) {
            $servicoIva = $item->iva_id;
            $servicoPreco = $item->preco;
            $iva = Iva::find()->where(['id' => $servicoIva])->one();
            $percentservico = $iva->percentagem;
        }

        foreach ($receitas as $item) {
            $receitaProduto = $item->posologia;
            $produto = Produto::find()->where(['id' => $receitaProduto])->one();
            $receitaIva = $produto->iva_id;
            $receitaPreco = $produto->preco;
            $iva = Iva::find()->where(['id' => $receitaIva])->one();
            $percentreceita = $iva->percentagem;
            $quantidadereceita = $item->dosagem;
        }

        if ($this->request->isPost && $linhafatura->load(Yii::$app->request->post())) {
            if (!empty($linhafatura->servico_id)) {
                $linhafatura->precounit = $servicoPreco;
                $linhafatura->valoriva = number_format($servicoPreco * ($percentservico / 100), 2, '.');
                $linhafatura->valorcomiva = $servicoPreco + $linhafatura->valoriva;
                $linhafatura->dta_venda = date('Y-m-d');
            } else if (!empty($linhafatura->receita_medica_id)) {
                $linhafatura->precounit = $receitaPreco;
                $linhafatura->valoriva = number_format($receitaPreco * ($percentreceita / 100), 2, '.');
                $linhafatura->valorcomiva = $receitaPreco + $linhafatura->valoriva;
                $linhafatura->dta_venda = date('Y-m-d');
                $linhafatura->quantidade = $quantidadereceita;
                $receitaMedicamento = ReceitaMedica::find()->where(['id' => $linhafatura->receita_medica_id])->one();
                $produtoreceita = Produto::find()->where(['id' => $receitaMedicamento->posologia])->one();
                $produtoreceita->quantidade -= $linhafatura->quantidade;
                $produtoreceita->save();
                $receitaMedicamento->valido = 0;
                $receitaMedicamento->save();
            }
            // Calcula os totais com base nas linhas de fatura existentes
            foreach ($linhasFaturaExistente as $linha) {
                $fatura->valortotal += $linha->subtotal;
                $fatura->ivatotal += $linha->valoriva * $linha->quantidade;
            }
            // Calcula o subtotal da nova linha antes de salvar
            $linhafatura->subtotal = number_format($linhafatura->quantidade * $linhafatura->valorcomiva, 2, '.');
            $linhafatura->fatura_id = $id_fatura;

            if ($linhafatura->validate() && $linhafatura->save()) {
                // Atualiza os totais da fatura apenas com o subtotal da nova linha
                $fatura->valortotal += $linhafatura->subtotal;
                $fatura->ivatotal += $linhafatura->valoriva * $linhafatura->quantidade;
                $fatura->save();

                return $this->redirect(['index', 'id' => $linhafatura->id, 'fatura_id' => $linhafatura->fatura_id, 'estabelecimento' => $estabelecimento_id, 'cliente' => $cliente_id]);
            }
        }

        return $this->render('create', ['linhafatura' => $linhafatura, 'receitasItems' => $receitasItems, 'servicosItems' => $servicosItems]);
    }

    /**
     * Updates an existing LinhaFatura model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    // Método que permite atualizar uma linha da fatura
    public function actionUpdate($id)
    {
        $linhafatura = LinhaFatura::findOne($id);
        $fatura = Fatura::findOne($linhafatura->fatura_id);
        $cliente = $fatura->cliente_id;
        $estabelecimento = $fatura->estabelecimento_id;
        $quantidade = $linhafatura->quantidade;

        $linhafatura->quantidade = $this->request->post('quantidade');
        $quantidadenova = $linhafatura->quantidade - $quantidade;

        $linhafatura->subtotal = number_format($linhafatura->valorcomiva * $linhafatura->quantidade, 2, '.');

        $fatura->valortotal += $linhafatura->valorcomiva * $quantidadenova;
        $fatura->ivatotal += $linhafatura->valoriva * $quantidadenova;

        $linhafatura->save();
        $fatura->save();

        return $this->redirect(['index',
            'id' => $linhafatura->id,
            'fatura_id' => $linhafatura->fatura_id,
            'estabelecimento' => $estabelecimento,
            'cliente' => $cliente,
        ]);
    }

    /**
     * Deletes an existing LinhaFatura model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    // Método que permite apagar uma linha da fatura com serviço
    public function actionDelete($id, $fatura_id, $estabelecimento, $cliente, $servico_id)
    {
        $linhafatura = LinhaFatura::find()->where(['id' => $id])->one();

        if ($linhafatura) {
            $this->findModel($id)->delete();

            $fatura = Fatura::find()->where(['id' => $fatura_id])->one();

            if ($fatura) {
                $fatura->valortotal -= $linhafatura->subtotal;

                if ($fatura->ivatotal < 0) {
                    $fatura->ivatotal = 0;
                } else {
                    $fatura->ivatotal -= $linhafatura->valoriva * $linhafatura->quantidade;
                }

                $fatura->save();
            }
        }

        return $this->redirect([
            'index',
            'id' => $id,
            'fatura_id' => $fatura_id,
            'estabelecimento' => $estabelecimento,
            'cliente' => $cliente,
            'servico_id' => $servico_id,
        ]);
    }

    // Método que permite apagar uma linha da fatura com receita médica
    public function actionDeletereceita($id, $fatura_id, $estabelecimento, $cliente)
    {
        $fatura = Fatura::find()->where(['id' => $fatura_id])->one();
        $linhafatura = LinhaFatura::find()->where(['id' => $id])->one();

        if ($fatura && $linhafatura) {
            $receitaMedicaid = $linhafatura->receita_medica_id;
            $quantidade = $linhafatura->quantidade;
            $fatura->valortotal -= $linhafatura->subtotal;

            $receita = ReceitaMedica::findOne($receitaMedicaid);
            $posologia = $receita->posologia;

            $produto = Produto::find()->where(['id' => $posologia])->one();

            if ($fatura->ivatotal < 0) {
                $fatura->ivatotal = 0;
            } else {
                $fatura->ivatotal -= $linhafatura->valoriva * $linhafatura->quantidade;
            }

            $fatura->save();

            $receita->valido = 1;
            $receita->save();

            if ($produto) {
                $this->findModel($id)->delete();
                $produto->quantidade += $quantidade;
                $produto->save();
            }
        }

        return $this->redirect([
            'index',
            'id' => $id,
            'fatura_id' => $fatura_id,
            'estabelecimento' => $estabelecimento,
            'cliente' => $cliente
        ]);
    }


    /**
     * Finds the LinhaFatura model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return LinhaFatura the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    // Método que permite encontrar a linha da fatura selecionada
    protected function findModel($id)
    {
        if (($model = LinhaFatura::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
