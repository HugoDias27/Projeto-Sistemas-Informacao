<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\LinhaCarrinhoSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="linha-carrinho-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'quantidade') ?>

    <?= $form->field($model, 'precounit') ?>

    <?= $form->field($model, 'valoriva') ?>

    <?= $form->field($model, 'valorcomiva') ?>

    <?php // echo $form->field($model, 'subtotal') ?>

    <?php // echo $form->field($model, 'carrinho_compra_id') ?>

    <?php // echo $form->field($model, 'produto_id') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
