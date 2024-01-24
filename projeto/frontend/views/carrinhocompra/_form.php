<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\CarrinhoCompra $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="carrinho-compra-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'dta_venda')->textInput() ?>

    <?= $form->field($model, 'quantidade')->textInput() ?>

    <?= $form->field($model, 'valortotal')->textInput() ?>

    <?= $form->field($model, 'ivatotal')->textInput() ?>

    <?= $form->field($model, 'cliente_id')->textInput() ?>

    <?= $form->field($model, 'fatura_id')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
