<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var backend\models\Despesa $despesa */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="despesa-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($despesa, 'preco')->textInput() ?>

    <?= $form->field($despesa, 'dta_despesa')->input('date') ?>

    <?= $form->field($despesa, 'descricao')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
