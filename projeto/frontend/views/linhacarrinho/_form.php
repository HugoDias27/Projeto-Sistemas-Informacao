<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\LinhaCarrinho $linhaCarrinho */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="linha-carrinho-form">


    <?php $form = ActiveForm::begin(['action' => ['linhacarrinho/create', 'id' => $produto->id], 'method' => 'post']); ?>

    <?php if ($quantidadeDisponivel): ?>
        <?= $form->field($linhaCarrinho, 'quantidade')->dropDownList(
            range(0, $quantidadeDisponivel),
            [
                'prompt' => 'Selecione a quantidade', // Adiciona uma opção de prompt
                'class' => 'form-control custom-class', // Adiciona uma classe CSS personalizada
            ]
        ) ?>
        <div class="form-group">
            <br>
            <?= Html::submitButton('Guardar', ['class' => 'btn btn-primary']) ?>
        </div>
    <?php else: ?>
        <div align="center">
            <br>
            <h3 style="color: #f54242;">SEM STOCK!</h3>
        </div>
    <?php endif; ?>

    <?php ActiveForm::end(); ?>

</div>

