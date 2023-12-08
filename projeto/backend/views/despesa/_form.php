<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var backend\models\Despesa $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="despesa-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'preco')->textInput() ?>

    <?= $form->field($model, 'dta_despesa')->input('date') ?>

    <?= $form->field($model, 'descricao')->textInput(['maxlength' => true]) ?>

    <?=$form->field($model, 'estabelecimento_id')->dropDownList($estabelecimentoItems, ['prompt' => 'Selecione...']); ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
