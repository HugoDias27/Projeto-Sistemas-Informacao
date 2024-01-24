<?php

/** @var yii\web\View $this */

$this->title = 'Categoria';

?>
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