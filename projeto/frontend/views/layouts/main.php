<?php

/** @var \yii\web\View $this */

/** @var string $content */

use common\models\Categoria;
use common\widgets\Alert;
use frontend\assets\AppAsset;
use http\Url;
use yii\bootstrap5\Breadcrumbs;
use yii\bootstrap5\Html;
use yii\bootstrap5\Nav;
use yii\bootstrap5\NavBar;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
    <!DOCTYPE html>
    <html lang="<?= Yii::$app->language ?>" class="h-100">
    <head>

        <meta charset="<?= Yii::$app->charset ?>">
        <meta content="width=device-width, initial-scale=1.0" name="viewport">
        <meta content="Free HTML Templates" name="keywords">
        <meta content="Free HTML Templates" name="description">
        <?php $this->registerCsrfMetaTags() ?>
        <title><?= Html::encode($this->title) ?></title>
        <?php $this->head() ?>


        <!-- Google Web Fonts -->
        <link rel="preconnect" href="https://fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css2?family=Roboto+Condensed:wght@400;700&family=Roboto:wght@400;700&display=swap"
              rel="stylesheet">

        <!-- Icon Font Stylesheet -->
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.0/css/all.min.css" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

        <!-- Libraries Stylesheet -->

        <link href="<?= Yii::$app->request->baseUrl ?>/logo.ico" rel="icon">
        <link href="<?= Yii::$app->request->baseUrl ?>/lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
        <link href="<?= Yii::$app->request->baseUrl ?>/lib/tempusdominus/css/tempusdominus-bootstrap-4.min.css"
              rel="stylesheet">
        <link href="<?= Yii::$app->request->baseUrl ?>/css/bootstrap.min.css" rel="stylesheet">
        <link href="<?= Yii::$app->request->baseUrl ?>/css/style.css" rel="stylesheet">

    </head>

    <body class="d-flex flex-column h-100">
    <?php $this->beginBody() ?>


    <header>
        <?php
        NavBar::begin([
            'brandLabel' => Html::img(Yii::$app->request->baseUrl . '/img/logo.png', ['alt' => Yii::$app->name]),
            'brandUrl' => Yii::$app->homeUrl,
        ]);

        $menuItems = [
            ['label' => 'Página Inicial', 'url' => ['../web']],
            ['label' => 'Sobre', 'url' => ['/site/about']],
            ['label' => 'Contactos', 'url' => ['/site/contact']],
            [
                'label' => 'Produtos',
                'items' => [
                    ['label' => 'Medicamentos Sem Receita', 'url' => ['produto/categoriamedicamentossemreceita']],
                    ['label' => 'Medicamentos Com Receita', 'url' => ['produto/categoriamedicamentoscomreceita']],
                    ['label' => 'Saúde Oral', 'url' => ['produto/categoriasaudeoral']],
                    ['label' => 'Bens de beleza', 'url' => ['produto/categoriabensbeleza']],
                    ['label' => 'Higiene', 'url' => ['produto/categoriahigiene']],
                    ['label' => 'Serviços', 'url' => ['servico/index']],
                    ['label' => 'Encontrar farmácia', 'url' => ['site/search']]
                ],
            ],
        ];

        if (!Yii::$app->user->isGuest) {
            $menuItems[] = [
                'label' => '<i class="fa fa-user"></i>',
                'items' => [
                    ['label' => 'Definições do perfil', 'url' => ['profile/view', 'id' => Yii::$app->user->identity->getId()]],
                    ['label' => 'Editar perfil', 'url' => ['profile/update', 'id' => Yii::$app->user->identity->getId()]],
                    ['label' => 'Receita médica', 'url' => ['receitamedica/index', 'id' => Yii::$app->user->identity->getId()]],
                    ['label' => 'Faturas', 'url' => ['fatura/index', 'id' => Yii::$app->user->identity->getId()]],
                ],
                'encode' => false,
            ];
        }


        if (Yii::$app->user->isGuest) {
            $menuItems[] = ['label' => 'Signup', 'url' => ['signup']];
        }

        if (!Yii::$app->user->isGuest) {
            $menuItems[] = ['label' => 'Carrinho', 'encode' => false, 'url' => ['/carrinhocompra']];
        }

        echo Nav::widget([
            'options' => ['class' => 'navbar-nav ms-auto py-0'],
            'items' => $menuItems,
        ]);
        if (Yii::$app->user->isGuest) {
            echo Html::a('Login', ['site/login'], ['class' => 'nav-item nav-link active']);
        } else {
            echo Html::beginForm(['/site/logout'], 'post')
                . Html::submitButton('Logout (' . Yii::$app->user->identity->username . ')', ['class' => 'nav-item nav-link active'])
                . Html::endForm();
        }
        NavBar::end();
        ?>
    </header>

    <main role="main" class="flex-shrink-0">
        <div class="container">
            <?= Breadcrumbs::widget([
                'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
            ]) ?>
            <?= Alert::widget() ?>
            <?= $content ?>
        </div>
    </main>

    <!-- Footer Start -->
    <div class="container-fluid bg-dark text-light mt-5 py-5">
        <div class="container py-5">
            <div class="row g-5">
                <div class="col-lg-3 col-md-6">
                    <h4 class="d-inline-block text-primary text-uppercase border-bottom border-5 border-secondary mb-4">
                        Localização</h4>
                    <p class="mb-2"><i class="fa fa-map-marker-alt text-primary me-3"></i>Leiria, PORTUGAL</p>
                </div>
                <div class="col-lg-3 col-md-6">
                    <h4 class="d-inline-block text-primary text-uppercase border-bottom border-5 border-secondary mb-4">
                        Acessos Rápidos</h4>
                    <div class="d-flex flex-column justify-content-start">
                        <a class="text-light mb-2" href=<?= Yii::$app->urlManager->createUrl(['site/contact']) ?>>
                            <i class="fa fa-angle-right me-2"></i>Contactos</a>
                        <a class="text-light mb-2" href=<?= Yii::$app->urlManager->createUrl(['#']) ?>><i
                                    class="fa fa-angle-right me-2"></i>Localizar Farmácia
                            Próxima</a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <h4 class="d-inline-block text-primary text-uppercase border-bottom border-5 border-secondary mb-4">
                        Métodos de Pagamento</h4>
                    <div align="center">
                        <i class="fab fa-cc-visa fa-3x mr-2" style="color: #0033ff;"></i>
                        <i class="fab fa-cc-mastercard fa-3x" style="color: #ff5a00;"></i>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <h4 class="d-inline-block text-primary text-uppercase border-bottom border-5 border-secondary mb-4">
                        Acesso Reservado</h4>
                    <p><a class="text-light mb-2"
                          href=<?= Yii::$app->urlManager->createUrl(['../../backend/web/site']) ?>>
                            <i class="fa fa-angle-right me-2"></i>Backend</a></p>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid bg-dark text-light border-top border-secondary py-4">
        <div class="container">
            <div class="row g-5">
                <div class="col-md-6 text-center text-md-start">
                    <p class="mb-md-0">&copy; <a class="text-primary" href="#">Carolo Farmacêutica</a>. All Rights
                        Reserved.
                    </p>
                </div>
            </div>
        </div>
    </div>
    <!-- Footer End -->


    <?php $this->endBody() ?>
    </body>
    </html>
<?php $this->endPage();


