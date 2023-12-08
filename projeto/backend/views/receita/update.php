<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\ReceitaMedica $receita */

$this->title = 'Atualizar Receita Médica: ' . $receita->id;
$this->params['breadcrumbs'][] = ['label' => 'Receita Médica', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $receita->id, 'url' => ['view', 'id' => $receita->id]];
$this->params['breadcrumbs'][] = 'Atualizar';
?>
<div class="receita-medica-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'receita' => $receita,
    ]) ?>

</div>
