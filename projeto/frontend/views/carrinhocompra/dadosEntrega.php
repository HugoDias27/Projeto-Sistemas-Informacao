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
        <input type="text">
        <br>
        <br>

    </div>
    <div class="produto-form">
        <form >
        <?= Html::button('Cartão', ['class' => 'btn btn-primary', 'onclick' => 'mostrarCartao()']) ?>
        <?= Html::button('Multibanco', ['class' => 'btn btn-primary', 'onclick' => 'mostrarMultibanco()']) ?>

        <br>
        <br>
        <div id="dadosCartao" style="display: none;">
            <label for="pais">Nº cartão:</label>
            <input type="text"><br>
            <label for="pais">Data Validade:</label>
            <input type="text"><br>
            <label for="pais">CVV:</label>
            <input type="text"><br>
        </div>

        <br>
        <div id="dadosMultibanco" style="display: none;">
            <label for="pais">Entidade: 1234</label>
            <br>
            <label for="pais">Referencia: 123456789</label>
            <br>
            <label for="pais">Preço: <?= $valortotal ?></label>
            <br>
        </div>
    </div>

    <script>
        function mostrarCartao() {
            document.getElementById("dadosCartao").style.display = "block";
            document.getElementById("dadosMultibanco").style.display = "none";
        }

        function mostrarMultibanco() {
            document.getElementById("dadosCartao").style.display = "none";
            document.getElementById("dadosMultibanco").style.display = "block";
        }
    </script>
        <div class="carrinho-compra-index">
            <br>
            <?= Html::a('Concluir Compra', Url::to(Yii::$app->homeUrl), ['class' => 'btn btn-success']); ?>
        </div>
</div>