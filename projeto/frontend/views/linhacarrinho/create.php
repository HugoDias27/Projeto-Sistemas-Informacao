<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\LinhaCarrinho $model */

$this->title = 'Adicionar Produto ao Carrinho';
$this->params['breadcrumbs'][] = ['label' => 'Linha Carrinhos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="linha-carrinho-create">

    <h1 align="center"><?= Html::encode($this->title) ?></h1>
    <hr>

    <?= $this->render('_form', [
        'model' => $model, 'produto' => $produto
    ]) ?>

</div>
