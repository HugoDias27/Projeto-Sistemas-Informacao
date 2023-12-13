<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\LinhaCarrinho $model */

$this->title = 'Create Linha Carrinho';
$this->params['breadcrumbs'][] = ['label' => 'Linha Carrinhos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="linha-carrinho-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
