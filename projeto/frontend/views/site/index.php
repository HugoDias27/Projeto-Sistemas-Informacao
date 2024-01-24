<?php

/** @var yii\web\View $this */

$this->title = 'Carolo Farmacêutica';

?>
<div class="container-fluid bg-primary py-5 mb-5 hero-header">
    <div class="container py-5">
        <div class="row justify-content-start">
            <div class="col-lg-8 text-center text-lg-start">
                <h5 class="d-inline-block text-primary text-uppercase border-bottom border-5"
                    style="border-color: rgba(256, 256, 256, .3) !important;">Bem-Vindo à Carolo Farmacêutica!</h5>
                <h1 class="display-1 text-white mb-md-4">A sua farmácia online</h1>
                <br><br><br><br><br><br><br><br>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid py-5">
    <div class="container">
        <div class="text-center mx-auto mb-5" style="max-width: 500px;">
            <h5 class="d-inline-block text-primary text-uppercase border-bottom border-5">Produtos</h5>
        </div>

        <?php
        //Mostar a mensagem
        foreach (Yii::$app->session->getAllFlashes() as $key => $message) {
            echo '<div class="alert alert-' . $key . '">' . $message . '</div>';
        }
        ?>

        <div class="row g-5">
            <?php if (!empty($produtos)): ?>
                <?php foreach ($produtos as $produto): ?>
                    <div class="col-lg-4 col-md-6">
                        <div class="service-item bg-light rounded d-flex flex-column align-items-center justify-content-center text-center">
                            <div class="mb-3">
                                <?php if (isset($imagens[$produto->id])): ?>
                                    <img src="<?= Yii::getAlias('@web') . '/uploads/' . $imagens[$produto->id]->filename ?>"
                                         class="img-fluid" style="max-width: 200px; max-height: 200px;">
                                <?php endif; ?>
                                <h4 class="mb-3"><a href="<?= Yii::$app->urlManager->createAbsoluteUrl(['produto/detalhes', 'id' => $produto->id])?>"><?= $produto->nome; ?></a></h4>
                                <a class="btn btn-lg btn-primary rounded-pill"
                                   href="<?= Yii::$app->urlManager->createAbsoluteUrl(['produto/detalhes', 'id' => $produto->id]) ?>">
                                    <i class="bi bi-arrow-right"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
                <div class="col-lg-12">
                    <?= \yii\widgets\LinkPager::widget(['pagination' => $paginacao]); ?>
                </div>
            <?php else: ?>
                <div class="col-lg-12">
                    <b><p>Não dispomos de produtos disponíveis neste momento para apresentar!</p></b>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- Blog Start -->
<div class="container-fluid py-5">
    <div class="container">
        <div class="text-center mx-auto mb-5" style="max-width: 500px;">
            <h5 class="d-inline-block text-primary text-uppercase border-bottom border-5">Conheça a acessibilidade da
                utilização do nosso Sistema</h5>
        </div>
        <div class="row g-5">
            <div class="col-xl-4 col-lg-6">
                <div class="bg-light rounded overflow-hidden">
                    <div class="p-4" align="center">
                        <b><p class="m-0">Uma farmácia perto de si!</p></b>
                        <br><br>
                        <i class="fas fa-map-marker-alt"></i>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-lg-6">
                <div class="bg-light rounded overflow-hidden">
                    <div class="p-4" align="center">
                        <b><p class="m-0">Usufrua dos descontos nos seus produtos online!</p></b>
                        <br>
                        <i class="fas fa-percent"></i>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-lg-6">
                <div class="bg-light rounded overflow-hidden">
                    <div class="p-4" align="center">
                        <b><p class="m-0">Poupe tempo ao deslocar-se a uma loja física!</p></b>
                        <br>
                        <i class="fas fa-walking"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Blog End -->