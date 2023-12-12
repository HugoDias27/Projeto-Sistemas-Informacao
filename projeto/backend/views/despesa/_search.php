<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var backend\models\DespesaSearch $despesa */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="despesa-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($despesa, 'id') ?>

    <?= $form->field($despesa, 'preco') ?>

    <?= $form->field($despesa, 'dta_despesa') ?>

    <?= $form->field($despesa, 'descricao') ?>

    <?= $form->field($despesa, 'estabelecimento_id') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
