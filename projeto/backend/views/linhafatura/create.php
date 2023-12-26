<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\LinhaFatura $linhafatura */

$this->title = 'Create Linha Fatura';
$this->params['breadcrumbs'][] = ['label' => 'Linha Faturas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="linha-fatura-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <!-- First Form -->
    <div class="first-form">
        <?= $this->render('_form', [
            'linhafatura' => $linhafatura,
            'servicosItems' => $servicosItems,
        ]) ?>
    </div>

    <!-- Second Form -->
    <div class="second-form">
        <?= $this->render('_formreceita', [
            'linhafatura' => $linhafatura,
            'receitasItems' => $receitasItems,
        ]) ?>
    </div>

</div>
