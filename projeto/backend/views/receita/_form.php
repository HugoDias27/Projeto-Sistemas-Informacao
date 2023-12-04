<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\ReceitaMedica $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="receita-medica-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'nome')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'codigo')->textInput() ?>

    <?= $form->field($model, 'local_prescricao')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'medico_prescricao')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'dosagem')->textInput() ?>

    <?= $form->field($model, 'data_validade')->textInput() ?>

    <?= $form->field($model, 'telefone')->textInput() ?>

    <?= $form->field($model, 'valido')->textInput() ?>

    <?= $form->field($model, 'posologia')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
