<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\LinhaCarrinho $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="linha-carrinho-form">


    <?php $form = ActiveForm::begin(); ?>

    <?php if (!empty($quantidadeDisponivel)): ?>
        <?= $form->field($model, 'quantidade')->dropDownList(range(1, $quantidadeDisponivel), ['prompt' => 'Selecione a quantidade...']) ?>

        <div class="form-group">
            <br>
            <?= Html::a('Guardar', ['create'], ['class' => 'btn btn-success']) ?>
        </div>
    <?php else: ?>
        <div align="center">
            <br>
            <h3 style="color: #f54242;">SEM STOCK!</h3>
        </div>
    <?php endif; ?>

    <?php ActiveForm::end(); ?>


</div>

