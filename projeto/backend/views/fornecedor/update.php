<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var backend\models\Fornecedor $fornecedor */

$this->title = 'Atualizar Fornecedor: ' . $fornecedor->nome;
$this->params['breadcrumbs'][] = ['label' => 'Fornecedors', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $fornecedor->id, 'url' => ['view', 'id' => $fornecedor->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="fornecedor-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'fornecedor' => $fornecedor,
    ]) ?>

</div>
