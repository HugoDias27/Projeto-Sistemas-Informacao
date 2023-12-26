<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\CarrinhoCompraSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="carrinho-compra-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'dta_venda') ?>

    <?= $form->field($model, 'quantidade') ?>

    <?= $form->field($model, 'valortotal') ?>

    <?= $form->field($model, 'ivatotal') ?>

    <?php // echo $form->field($model, 'cliente_id') ?>

    <?php // echo $form->field($model, 'fatura_id') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
