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

    <h1 align="center"><?= Html::encode($this->title) ?></h1>
    <hr>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [

            'id' => 'Linha',
            'quantidade' => 'Quantidade',
            'precounit' => 'Preço Unid',
            'valoriva' => 'Iva',
            'valorcomiva' => 'Valor Iva',
            'subtotal',
            //'carrinho_compra_id',
            'produto_id' => 'Referência',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, LinhaCarrinho $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                }
            ],
        ],
    ]); ?>


</div>
