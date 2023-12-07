<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;


/** @var yii\web\View $this */
/** @var common\models\Produto $produto */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="produto-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($produto, 'nome')->textInput(['maxlength' => true]) ?>

    <?= $form->field($produto, 'prescricao_medica')->dropDownList([1 => 'Sim', 0=> 'Não']) ?>

    <?= $form->field($produto, 'preco')->textInput() ?>

    <?= $form->field($produto, 'quantidade')->textInput() ?>

    <?=$form->field($produto, 'categoria_id')->dropDownList($categoriaItems, ['prompt' => 'Selecione...']) ?>

    <?=$form->field($produto, 'iva_id')->dropDownList($ivaItems, ['prompt' => 'Selecione...']); ?>


    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
