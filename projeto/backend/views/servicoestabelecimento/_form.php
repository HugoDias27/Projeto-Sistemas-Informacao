<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var \backend\models\ServicoEstabelecimento $servicoEstabelecimento */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="servico-estabelecimento-form">

    <?php $form = ActiveForm::begin(); ?>

    <?=$form->field($servicoEstabelecimento, 'estabelecimento_id')->dropDownList($estabelecimentos, ['prompt' => 'Selecione...']); ?>

    <?=$form->field($servicoEstabelecimento, 'servico_id')->dropDownList($servicos, ['prompt' => 'Selecione...']); ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
