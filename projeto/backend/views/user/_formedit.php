<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\User $model */
/** @var yii\widgets\ActiveForm $form */

?>

<div class="profile-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($modelProfile, 'morada')->textInput(['maxlength' => true]) ?>

    <?= $form->field($modelProfile, 'telefone')->textInput() ?>

    <?php
    if ($mostra_n_utente == 1)
        echo $form->field($modelProfile, 'n_utente')->textInput();
    ?>

    <?php
    if ($mostra_nif == 1)
        echo $form->field($modelProfile, 'nif')->textInput();
    ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
