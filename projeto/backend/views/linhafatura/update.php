<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\LinhaFatura $linhafatura */

$this->title = 'Update Linha Fatura: ' . $linhafatura->id;
$this->params['breadcrumbs'][] = ['label' => 'Linha Faturas', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $linhafatura->id, 'url' => ['view', 'id' => $linhafatura->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="linha-fatura-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'linhafatura' => $linhafatura,
    ]) ?>

</div>
