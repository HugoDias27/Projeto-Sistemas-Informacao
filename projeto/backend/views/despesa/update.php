<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var backend\models\Despesa $despesa */

$this->title = 'Update Despesa: ' . $despesa->descricao;
$this->params['breadcrumbs'][] = ['label' => 'Despesas', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $despesa->id, 'url' => ['view', 'id' => $despesa->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="despesa-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_formedit', [
        'despesa' => $despesa,
    ]) ?>

</div>
