<?php

namespace frontend\controllers;

use common\models\Imagem;
use common\models\Produto;
use common\models\ReceitaMedica;
use common\models\ReceitaMedicaSearch;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ReceitaMedicaController implements the CRUD actions for ReceitaMedica model.
 */
class ReceitamedicaController extends Controller
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
                            'actions' => ['index', 'view', 'verificar'],
                            'allow' => true,
                            'roles' => ['cliente'],
                        ],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all ReceitaMedica models.
     *
     * @return string
     */
    // Método que vai para o index das receitas médicas
    public function actionIndex($id)
    {
        $searchModel = new ReceitaMedicaSearch();

        $dataProvider = $searchModel->search($this->request->queryParams);
        $dataProvider->query->andWhere(['user_id' => $id]);
        $dataProvider->query->with('posologiaProduto');

        return $this->render('index', ['searchModel' => $searchModel, 'dataProvider' => $dataProvider]);
    }


    /**
     * Displays a single ReceitaMedica model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    // Método que vai para a view de uma receita médica
    public function actionView($id)
    {
        return $this->render('view', ['model' => $this->findModel($id)]);
    }

    /**
     * Creates a new ReceitaMedica model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    // Método onde verifica se o utilizador tem a receita médica para o produto que quer comprar
    public function actionVerificar($produtoid)
    {
        $receitaMedica = new ReceitaMedica();
        if ($this->request->isPost) {
            $request = Yii::$app->request;
            $codigo = $request->post('ReceitaMedica')['codigo'];
            $userId = Yii::$app->user->id;

            $receitaMedica = ReceitaMedica::find()
                ->where(['codigo' => $codigo])
                ->andWhere(['LIKE', 'posologia', $produtoid])
                ->andWhere(['user_id' => $userId])
                ->one();

            if ($receitaMedica != null) {
                return $this->redirect(['carrinhocompra/createcomreceita', 'produtoid' => $produtoid, 'receitamedicaid' => $receitaMedica->id]);
            } else {
                Yii::$app->session->setFlash('error', 'A receita médica não corresponde ao produto fornecido ou não está associado ao utilizador logado.');

                $produtoDetalhes = Produto::findOne($produtoid);

                if (($produtoDetalhes->prescricao_medica) === 1) {
                    $receitaMedica = "Sim";
                } else {
                    $receitaMedica = "Não";
                }

                $precoFinal = ($produtoDetalhes->preco) + (($produtoDetalhes->preco) * ($produtoDetalhes->iva->percentagem / 100));

                $imagemArray = [];

                $imagens = Imagem::find()->where(['produto_id' => $produtoid])->all();
                foreach ($imagens as $imagem) {
                    $imagem->filename = Yii::getAlias('@web') . '/uploads/' . $imagem->filename;
                    $imagemArray[] = $imagem->filename;
                }
                return $this->render('/produto/detalhes', [
                    'produtoDetalhes' => $produtoDetalhes,
                    'imagemArray' => $imagemArray,
                    'receitaMedica' => $receitaMedica,
                    'precoFinal' => $precoFinal,
                ]);
            }
        }

        return $this->render('verificar', [
            'receitaMedica' => $receitaMedica,
        ]);
    }

    /**
     * Finds the ReceitaMedica model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return ReceitaMedica the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    // Método que permite encontrar a receita médica selecionada
    protected function findModel($id)
    {
        if (($model = ReceitaMedica::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
