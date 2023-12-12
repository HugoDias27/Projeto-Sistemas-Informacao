<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\ProdutoSearch $produto */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="produto-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($produto, 'id') ?>

    <?= $form->field($produto, 'nome') ?>

    <?= $form->field($produto, 'prescricao_medica') ?>

    <?= $form->field($produto, 'preco') ?>

    <?= $form->field($produto, 'quantidade') ?>

    <?php // echo $form->field($model, 'categoria_id') ?>

    <?php // echo $form->field($model, 'iva_id') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
