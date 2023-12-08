<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\Produto $produto */

$this->title = 'Criar Produto';
$this->params['breadcrumbs'][] = ['label' => 'Produtos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="produto-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'produto' => $produto,'ivaItems' => $ivaItems, 'categoriaItems'=> $categoriaItems, 'fornecedorProduto' => $fornecedorProduto, 'fornecedores' => $fornecedores
    ]) ?>

</div>
