<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var backend\models\Estabelecimento $estabelecimento */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="estabelecimento-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($estabelecimento, 'nome')->textInput(['maxlength' => true]) ?>

    <?= $form->field($estabelecimento, 'morada')->textInput(['maxlength' => true]) ?>

    <?= $form->field($estabelecimento, 'telefone')->textInput() ?>

    <?= $form->field($estabelecimento, 'email')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
