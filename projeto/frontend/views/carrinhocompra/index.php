<?php

use common\models\CarrinhoCompra;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var common\models\CarrinhoCompraSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Carrinho Compras';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="carrinho-compra-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Carrinho Compra', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'dta_venda',
            'quantidade',
            'valortotal',
            'ivatotal',
            //'cliente_id',
            //'fatura_id',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, CarrinhoCompra $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 }
            ],
        ],
    ]); ?>


</div>
