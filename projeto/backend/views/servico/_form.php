<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var \common\models\Servico $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="servico-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'nome')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'duracao')->input('time') ?>

    <?= $form->field($model, 'preco')->textInput() ?>

    <?=$form->field($model, 'iva_id')->dropDownList($ivaItems, ['prompt' => 'Selecione...']); ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
