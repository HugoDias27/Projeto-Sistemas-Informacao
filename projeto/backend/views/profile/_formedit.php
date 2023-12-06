<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\Profile $perfil */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="profile-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($perfil, 'morada')->textInput(['maxlength' => true]) ?>

    <?= $form->field($perfil, 'telefone')->textInput() ?>

    <?php
    if ($mostra_n_utente == 1)
        echo $form->field($perfil, 'n_utente')->textInput();
    ?>

    <?php
    if ($mostra_nif == 1)
        echo $form->field($perfil, 'nif')->textInput();
    ?>

    <br>
    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
