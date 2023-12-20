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

    <?= $this->render('_form', [
        'linhafatura' => $linhafatura, 'receitasItems' => $receitasItems, 'servicosItems' => $servicosItems,
    ]) ?>

</div>
