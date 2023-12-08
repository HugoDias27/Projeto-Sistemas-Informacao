<?php

/** @var yii\web\View $this */

$this->title = 'Categoria';

?>
<div class="container-fluid py-5">
    <div class="container">
        <div class="text-center mx-auto mb-5" style="max-width: 500px;">
            <h5 class="d-inline-block text-primary text-uppercase border-bottom border-5">Produtos</h5>
        </div>
        <div class="row g-5">
            <?php foreach ($produtos as $produto): ?>
                <div class="col-lg-4 col-md-6">
                    <div class="service-item bg-light rounded d-flex flex-column align-items-center justify-content-center text-center">
                        <div class="service-icon mb-4">
                            <i class="fa fa-2x fa-user-md text-white"></i>
                        </div>
                        <h4 class="mb-3"><?= $produto->nome; ?></h4>
                        <a class="btn btn-lg btn-primary rounded-pill"
                           href="<?= '../produto/index?id=' . $produto->id ?>">
                            <i class="bi bi-arrow-right"></i>
                        </a>
                    </div>
                </div>
            <?php endforeach; ?>
            <div class="col-lg-12">
                <?= \yii\widgets\LinkPager::widget(['pagination' => $paginacao]); ?>
            </div>
        </div>
    </div>
</div>