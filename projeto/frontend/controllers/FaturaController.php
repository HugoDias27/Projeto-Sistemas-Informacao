<?php

namespace frontend\controllers;

use common\models\CarrinhoCompra;
use common\models\Fatura;
use common\models\FaturaSearch;
use common\models\LinhaCarrinho;
use common\models\LinhaFatura;
use common\models\Produto;
use common\models\ReceitaMedica;
use common\models\Servico;
use common\models\User;
use Mpdf\Mpdf;
use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
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
            ]
        );
    }

    /**
     * Lists all Fatura models.
     *
     * @return string
     */
    public function actionIndex($id)
    {
        $searchModel = new FaturaSearch();

        $dataProvider = $searchModel->search($this->request->queryParams);
        $dataProvider->query->andWhere(['cliente_id' => $id]);

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

        $cliente = User::find()->where(['id' => $fatura->cliente_id])->one();
        $perfilCliente = $cliente->profiles;

        $linhasFatura = LinhaFatura::find()->where(['fatura_id' => $id])->all();

        $carrinho = CarrinhoCompra::find()->where(['fatura_id' => $id])->one();

        $servicosids = ArrayHelper::getColumn($linhasFatura, 'servico_id');
        $servicos = Servico::find()->where(['id' => $servicosids])->all();

        $receitasids = ArrayHelper::getColumn($linhasFatura, 'receita_medica_id');
        $receitas = ReceitaMedica::find()->where(['id' => $receitasids])->all();

        if ($carrinho !== null) {
            $carrinhoId = $carrinho->id;
            $linhasCarrinho = LinhaCarrinho::find()->where(['carrinho_compra_id' => $carrinhoId])->all();

            $produtos = [];
            foreach ($linhasCarrinho as $linhaCarrinho) {
                $produto = Produto::find()->where(['id' => $linhaCarrinho->produto_id])->one();
                if ($produto) {
                    $produtos[] = $produto;
                }
            }

            return $this->render('view', [
                'fatura' => $fatura,
                'cliente' => $cliente,
                'perfilCliente' => $perfilCliente,
                'linhasFatura' => $linhasFatura,
                'servicos' => $servicos,
                'receitas' => $receitas,
                'linhasCarrinho' => $linhasCarrinho,
                'produtos' => $produtos,
            ]);
        }
        else
        {
            return $this->render('view', [
                'fatura' => $fatura,
                'cliente' => $cliente,
                'perfilCliente' => $perfilCliente,
                'linhasFatura' => $linhasFatura,
                'servicos' => $servicos,
                'receitas' => $receitas,
            ]);
        }
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

    public function actionImprimir($id) // Ação para gerar o PDF da fatura
    {
        $fatura = $this->findModel($id);

        $cliente = User::find()->where(['id' => $fatura->cliente_id])->one();
        $perfilCliente = $cliente->profiles;

        $linhasFatura = LinhaFatura::find()->where(['fatura_id' => $id])->all();

        $carrinho = CarrinhoCompra::find()->where(['fatura_id' => $id])->one();

        $servicosids = ArrayHelper::getColumn($linhasFatura, 'servico_id');
        $servicos = Servico::find()->where(['id' => $servicosids])->all();

        $receitasids = ArrayHelper::getColumn($linhasFatura, 'receita_medica_id');
        $receitas = ReceitaMedica::find()->where(['id' => $receitasids])->all();

        if ($carrinho !== null) {
            $carrinhoId = $carrinho->id;
            $linhasCarrinho = LinhaCarrinho::find()->where(['carrinho_compra_id' => $carrinhoId])->all();

            $produtos = [];
            foreach ($linhasCarrinho as $linhaCarrinho) {
                $produto = Produto::find()->where(['id' => $linhaCarrinho->produto_id])->one();
                if ($produto) {
                    $produtos[] = $produto;
                }
            }

            $content = $this->renderPartial('impressao', [
                'fatura' => $fatura,
                'cliente' => $cliente,
                'perfilCliente' => $perfilCliente,
                'linhasFatura' => $linhasFatura,
                'servicos' => $servicos,
                'receitas' => $receitas,
                'linhasCarrinho' => $linhasCarrinho,
                'produtos' => $produtos
            ]);

        }
        else
        {
            $content = $this->renderPartial('impressao', [
                'fatura' => $fatura,
                'cliente' => $cliente,
                'perfilCliente' => $perfilCliente,
                'linhasFatura' => $linhasFatura,
                'servicos' => $servicos,
                'receitas' => $receitas
            ]);
        }
        $content = "<link rel='stylesheet' href='" . Yii::$app->request->baseUrl . "/estilos.css'> <div class='table-container'>" . $content . "</div>";
        $mpdf = new Mpdf();
        $mpdf->WriteHTML($content);
        $mpdf->Output('Fatura ' . $id . '.pdf', 'D');

    }
}
