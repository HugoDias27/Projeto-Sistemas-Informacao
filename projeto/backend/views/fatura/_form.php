<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\Fatura $fatura */
/** @var common\models\Profile $cliente */
/** @var backend\models\Estabelecimento $estabelecimento */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="fatura-form">

    <?php $form = ActiveForm::begin(['id' => 'teste']); ?>

    <?= $form->field($fatura, 'cliente_id')->dropDownList($cliente, ['prompt' => 'Selecione o cliente']) ?>

    <?= $form->field($fatura, 'estabelecimento_id')->dropDownList($estabelecimento, ['prompt' => 'Selecione a loja']) ?>


    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
