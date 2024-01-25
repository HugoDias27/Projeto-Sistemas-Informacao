<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\Profile $perfil */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="profile-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($perfil, 'n_utente')->textInput() ?>

    <?= $form->field($perfil, 'nif')->textInput() ?>

    <?= $form->field($perfil, 'morada')->textInput(['maxlength' => true]) ?>

    <?= $form->field($perfil, 'telefone')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
