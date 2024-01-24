<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var backend\models\EstabelecimentoSearch $estabelecimento */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="estabelecimento-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($estabelecimento, 'id') ?>

    <?= $form->field($estabelecimento, 'nome') ?>

    <?= $form->field($estabelecimento, 'morada') ?>

    <?= $form->field($estabelecimento, 'telefone') ?>

    <?= $form->field($estabelecimento, 'email') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
