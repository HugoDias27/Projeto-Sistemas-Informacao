<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\CarrinhoCompra $model */

$this->title = 'Update Carrinho Compra: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Carrinho Compras', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="carrinho-compra-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
