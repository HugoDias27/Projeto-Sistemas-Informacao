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
<script src="<?= Yii::$app->request->baseUrl ?>/js/estilo.js" defer></script>
<link href="<?= Yii::$app->request->baseUrl ?>/css/estilo.css" rel="stylesheet">

<div class="carrinho-compra-index">
    <h1 align="center"><?= Html::encode($this->title) ?></h1>
    <hr>

    <?php $form = ActiveForm::begin(['id' => 'dados-entrega-form']); ?>

    <div class="produto-form">
        <label for="nome">Nome:</label>
        <?= Html::input('text', 'nome') ?>
        <br>
        <label for="morada">Morada:</label>
        <?= Html::input('text', 'morada') ?>
        <br>
        <label for="codigo_postal">Código Postal:</label>
        <?= Html::input('text', 'codigo_postal') ?>
        <br>
        <label for="pais">País:</label>
        <?= Html::input('text', 'pais') ?>
    </div>
    <br>
    <div class="produto-form">
        <?= Html::button('Cartão', ['class' => 'btn btn-primary btn-cartao']) ?>
        <?= Html::button('Multibanco', ['class' => 'btn btn-primary btn-multibanco']) ?>
        <br>

        <div id="dadosCartao" style="display: none;">
            <?= Html::input('number', 'numero_cartao') ?>
            <?= Html::input('date', 'data_validade') ?>
            <?= Html::input('number', 'cvv') ?>
        </div>

        <br>
        <div id="dadosMultibanco" style="display: none;">
            <label for="pais">Entidade: 1234</label><br>
            <label for="pais">Referência: 123456789</label><br>
            <label for="pais">Preço: <?= $valortotal ?></label>
            <br>
            <br>
        </div>
        <?= Html::a('Concluir Compra', '../site/index', ['class' => 'btn btn-success']); ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>


