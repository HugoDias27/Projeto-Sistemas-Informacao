<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\LinhaCarrinho $model */

$this->title = 'Update Linha Carrinho: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Linha Carrinhos', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="linha-carrinho-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
