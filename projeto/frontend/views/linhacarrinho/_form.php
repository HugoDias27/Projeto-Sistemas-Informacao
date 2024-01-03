<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\LinhaCarrinho $linhaCarrinho */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="linha-carrinho-form">


    <?php $form = ActiveForm::begin(['action' => ['linhacarrinho/create', 'produtoid' => $produto->id], 'method' => 'post']); ?>

    <?php if ($quantidadeDisponivel): ?>
        <?= $form->field($linhaCarrinho, 'quantidade')->dropDownList(
            array_combine(range(1, $quantidadeDisponivel), range(1, $quantidadeDisponivel)), // Modificado para começar em 1
            [
                'prompt' => 'Selecione a quantidade',
                'class' => 'form-control custom-class',
                'required' => true,
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

