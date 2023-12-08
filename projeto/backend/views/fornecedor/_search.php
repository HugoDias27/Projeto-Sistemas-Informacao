<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var backend\models\FornecedorSearch $fornecedor */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="fornecedor-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($fornecedor, 'id') ?>

    <?= $form->field($fornecedor, 'nome') ?>

    <?= $form->field($fornecedor, 'telefone') ?>

    <?= $form->field($fornecedor, 'email') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
