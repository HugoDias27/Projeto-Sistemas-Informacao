<?php

/** @var yii\web\View $this */

use yii\helpers\Html;

$this->title = 'Produto';
?>

<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>

<div class="container-fluid py-5">
    <div class="container">
        <h1 align="center"><?= $produtoDetalhes->nome ?></h1>
        <hr>
    </div>
    <div class="row g-5">
        <div class="col-lg-4 col-md-6">
            <div class="service-item bg-light rounded d-flex flex-column align-items-center justify-content-center text-center">
                <div id="imagemCarousel" class="carousel slide" data-interval="false">
                    <div class="carousel-inner">
                        <?php foreach ($imagemArray as $index => $imagemUrl): ?>
                            <div class="carousel-item <?= $index === 0 ? 'active' : '' ?>">
                                <?= Html::img($imagemUrl, ['width' => '250px', 'height' => '250px']); ?>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <a class="carousel-control-prev" href="#imagemCarousel" role="button" data-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="sr-only">Anterior</span>
                    </a>
                    <a class="carousel-control-next" href="#imagemCarousel" role="button" data-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="sr-only">Próximo</span>
                    </a>
                </div>
            </div>

            <?php foreach ($imagemArray as $imagem): ?>
                <?= Html::img($imagem, ['width' => '100px']); ?>
            <?php endforeach; ?>

        </div>

        <div class="col-lg-4 col-md-6">
            <div class="service-item bg-light rounded d-flex flex-column align-items-center justify-content-center text-center">
                <h5>Informações Técnicas</h5>
                <hr>
                <p>
                    Categoria: <?= isset($produtoDetalhes->categoria->descricao) ? $produtoDetalhes->categoria->descricao : 'Não tem categoria associada' ?></p>
                <p>Iva: <?= $produtoDetalhes->iva->percentagem ?>%</p>
                <p>Medicamento sujeito a receita médica: <b><?= $receitaMedica ?></b></p>
            </div>
        </div>

        <div class="col-lg-4 col-md-6">
            <div class="service-item bg-light rounded d-flex flex-column align-items-center justify-content-center text-center">
                <p>Referência: <?= $produtoDetalhes->id ?></p>
                <p>Unidades Disponíveis: <?= $produtoDetalhes->quantidade ?></p>
                <p>Preço: <?= $precoFinal = number_format($precoFinal, 2, '.', ''); ?>€</p>
                <i class="fas fa-shopping-cart" style="color: #ff0000;"></i>
            </div>
        </div>
    </div>

</div>