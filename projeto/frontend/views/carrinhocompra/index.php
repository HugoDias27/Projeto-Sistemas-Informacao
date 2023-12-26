<?php

use common\models\CarrinhoCompra;
use common\models\LinhaCarrinho;
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

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            [
                'attribute' => 'quantidade',
                'format' => 'raw',
                'value' => function ($model) {
                    return Html::beginForm(['linhacarrinho/update', 'id' => $model->id], 'post')
                        . Html::input('number', 'quantidade', $model->quantidade, ['class' => 'form-control', 'style' => 'width: 80px;'])
                        . Html::submitButton('Atualizar', ['class' => 'btn btn-sm btn-primary'])
                        . Html::endForm();
                },
            ],
            'precounit',
            'valoriva',
            'valorcomiva',
            'subtotal',
            [
                'attribute' => 'produto_id',
                'label' => 'Produto',
                'value' => function ($model) {
                    return $model->produto->nome;
                },
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{delete}',
                'buttons' => [
                    'delete' => function ($url, $model, $key) {
                        return Html::a('<i class="fas fa-trash"></i>', ['linhacarrinho/delete', 'id' => $model->id], [
                            'class' => 'btn btn-danger',
                            'data' => [
                                'confirm' => 'Tem certeza que deseja apagar este artigo?',
                                'method' => 'post',
                            ],
                        ]);
                    },
                ],
            ],
        ],
    ]); ?>

</div>
<div class="carrinho-compra-index">

    <?= Html::beginForm(['carrinhocompra/concluir'], 'post') ?>
    <?= Html::submitButton('Concluir Carrinho', ['class' => 'btn btn-success']) ?>
    <?= Html::endForm() ?>

</div>
