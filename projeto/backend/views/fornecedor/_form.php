<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var backend\models\Fornecedor $fornecedor */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="fornecedor-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($fornecedor, 'nome')->textInput(['maxlength' => true]) ?>

    <?= $form->field($fornecedor, 'telefone')->textInput() ?>

    <?= $form->field($fornecedor, 'email')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
