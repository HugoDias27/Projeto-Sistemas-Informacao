<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\Servico $model */

$this->title = 'Create Servico';
$this->params['breadcrumbs'][] = ['label' => 'Servicos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="servico-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
