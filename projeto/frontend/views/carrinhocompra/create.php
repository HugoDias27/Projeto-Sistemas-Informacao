<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\CarrinhoCompra $model */

$this->title = 'Create Carrinho Compra';
$this->params['breadcrumbs'][] = ['label' => 'Carrinho Compras', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="carrinho-compra-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
