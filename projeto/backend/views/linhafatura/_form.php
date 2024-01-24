<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\LinhaFatura $linhafatura */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="linha-fatura-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($linhafatura, 'quantidade')->textInput(['type' => 'number']) ?>

    <?= $form->field($linhafatura, 'servico_id')->dropDownList($servicosItems, ['prompt' => 'Selecione o servico']) ?>

    <div class="form-group">
        <?= Html::submitButton('Adicionar servico', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
