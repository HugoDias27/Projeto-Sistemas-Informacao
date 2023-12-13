<?php

use common\models\LinhaCarrinho;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var common\models\LinhaCarrinhoSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Linha Carrinhos';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="linha-carrinho-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Linha Carrinho', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'quantidade',
            'precounit',
            'valoriva',
            'valorcomiva',
            //'subtotal',
            //'carrinho_compra_id',
            //'produto_id',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, LinhaCarrinho $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 }
            ],
        ],
    ]); ?>


</div>
