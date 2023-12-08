<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var backend\models\Despesa $model */

$this->title = 'Create Despesa';
$this->params['breadcrumbs'][] = ['label' => 'Despesas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="despesa-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model, 'estabelecimentoItems' => $estabelecimentoItems,
    ]) ?>

</div>
