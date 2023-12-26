<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\ReceitaMedica $receitaMedica */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="receita-medica-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($receitaMedica, 'codigo')->textInput() ?>


    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
