<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\LinhaCarrinho $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="linha-carrinho-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'quantidade')->textInput() ?>

    <?= $form->field($model, 'precounit')->textInput() ?>

    <?= $form->field($model, 'valoriva')->textInput() ?>

    <?= $form->field($model, 'valorcomiva')->textInput() ?>

    <?= $form->field($model, 'subtotal')->textInput() ?>

    <?= $form->field($model, 'carrinho_compra_id')->textInput() ?>

    <?= $form->field($model, 'produto_id')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
