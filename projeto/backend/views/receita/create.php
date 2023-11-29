<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\ReceitaMedica $model */

$this->title = 'Create Receita Medica';
$this->params['breadcrumbs'][] = ['label' => 'Receita Medicas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="receita-medica-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
