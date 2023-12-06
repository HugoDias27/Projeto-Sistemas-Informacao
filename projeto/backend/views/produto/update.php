<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\Produto $produto */

$this->title = 'Atualizar Produto: ' . $produto->nome;
$this->params['breadcrumbs'][] = ['label' => 'Produtos', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $produto->id, 'url' => ['view', 'id' => $produto->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="produto-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_formedit', [
        'produto' => $produto, 'ivaItems' => $ivaItems, 'categoriaItems'=> $categoriaItems,
    ]) ?>

</div>
