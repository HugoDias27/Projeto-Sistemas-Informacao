<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\ReceitaMedica $receita */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="receita-medica-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($receita, 'user_id')->dropDownList($clientes, ['prompt' => 'Selecione...']) ?>

    <?= $form->field($receita, 'codigo')->textInput() ?>

    <?= $form->field($receita, 'local_prescricao')->textInput(['maxlength' => true]) ?>

    <?= $form->field($receita, 'medico_prescricao')->textInput(['maxlength' => true]) ?>

    <?= $form->field($receita, 'dosagem')->textInput() ?>

    <?= $form->field($receita, 'data_validade')->input('date') ?>

    <?= $form->field($receita, 'telefone')->textInput() ?>

    <?= $form->field($receita, 'valido')->dropDownList([1 => 'Sim', 0=> 'Não']) ?>

    <?= $form->field($receita, 'posologia')->dropDownList($produtos, ['prompt' => 'Selecione...']) ?>

    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
