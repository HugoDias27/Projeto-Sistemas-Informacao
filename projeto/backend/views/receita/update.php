<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\ReceitaMedica $model */

$this->title = 'Update Receita Medica: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Receita Medicas', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="receita-medica-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
