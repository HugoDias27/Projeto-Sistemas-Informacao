<?php

/** @var yii\web\View $this */

$this->title = 'Produto';
?>
<div class="container-fluid py-5">
    <div class="container">
        <h1 align="center"><?= $produtoDetalhes->nome ?></h1>
        <hr>
    </div>
    <div class="row g-5">
        <div class="col-lg-4 col-md-6">
            <div class="service-item bg-light rounded d-flex flex-column align-items-center justify-content-center text-center">
                <p>Mostrar imagem!</p>
            </div>
        </div>

        <div class="col-lg-4 col-md-6">
            <div class="service-item bg-light rounded d-flex flex-column align-items-center justify-content-center text-center">
                <h5>Informações Técnicas</h5>
                <hr>
                <p>Categoria: <?= $produtoDetalhes->categoria->descricao ?></p>
                <p>Iva: <?= $produtoDetalhes->iva->percentagem ?>%</p>
                <p>Medicamento sujeito a receita médica: <b><?= $receitaMedica ?></b></p>
            </div>
        </div>

        <div class="col-lg-4 col-md-6">
            <div class="service-item bg-light rounded d-flex flex-column align-items-center justify-content-center text-center">
                <p>Referência: <?= $produtoDetalhes->id ?></p>
                <p>Unidades Disponíveis: <?= $produtoDetalhes->quantidade ?></p>
                <p>Preço: <?= $precoFinal ?>€</p>
                <i class="fas fa-shopping-cart" style="color: #ff0000;"></i>
            </div>
        </div>
    </div>

</div>