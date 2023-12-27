<?php

use common\models\CarrinhoCompra;
use common\models\LinhaCarrinho;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\CarrinhoCompraSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Dados de Entrega';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="carrinho-compra-index">

    <h1 align="center"><?= Html::encode($this->title) ?></h1>
    <hr>

    <div class="produto-form">

        <label for="nome">Nome:</label>
        <input type="text"> <br>

        <label for="morada">Morada:</label>
        <input type="text"> <br>

        <label for="pais">Código-Postal:</label>
        <input type="text"> <br>

        <label for="pais">País:</label>
        <input type="text"><br>

    </div>

    <div class="carrinho-compra-index">

        <br>
        <?= Html::beginForm(['/carrinhocompra/dadosentrega']) ?>
        <?= Html::submitButton('Finalizar Compra', ['class' => 'btn btn-success']) ?>
        <?= Html::endForm() ?>

    </div>

</div>
