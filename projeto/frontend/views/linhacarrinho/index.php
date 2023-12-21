<?php

use common\models\LinhaCarrinho;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var common\models\LinhaCarrinhoSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Adicionar Produto ao Carrinho';
$this->params['breadcrumbs'][] = ['label' => 'Linha Carrinhos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="linha-carrinho-index">

    <h1 align="center"><?= Html::encode($this->title) ?></h1>
    <hr>

    <?= $this->render('_form', [
        'linhaCarrinho' => $linhaCarrinho, 'quantidadeDisponivel' => $quantidadeDisponivel, 'produto' => $produto
    ]) ?>


</div>
