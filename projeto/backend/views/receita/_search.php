<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\ReceitaMedicaSearch $receita */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="receita-medica-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($receita, 'id') ?>

    <?= $form->field($receita, 'nome') ?>

    <?= $form->field($receita, 'codigo') ?>

    <?= $form->field($receita, 'local_prescricao') ?>

    <?= $form->field($receita, 'medico_prescricao') ?>

    <?php // echo $form->field($model, 'dosagem') ?>

    <?php // echo $form->field($model, 'data_validade') ?>

    <?php // echo $form->field($model, 'telefone') ?>

    <?php // echo $form->field($model, 'valido') ?>

    <?php // echo $form->field($model, 'posologia') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
