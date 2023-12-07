<?php

/** @var \yii\web\View $this */

/** @var string $content */

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
        <link href="https://fonts.googleapis.com/css2?family=Roboto+Condensed:wght@400;700&family=Roboto:wght@400;700&display=swap" rel="stylesheet">

        <!-- Icon Font Stylesheet -->
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.0/css/all.min.css" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

        <!-- Libraries Stylesheet -->

        <link href="<?= Yii::$app->request->baseUrl ?>/logo.ico" rel="icon">
        <link href="<?= Yii::$app->request->baseUrl ?>/lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
        <link href="<?= Yii::$app->request->baseUrl ?>/lib/tempusdominus/css/tempusdominus-bootstrap-4.min.css" rel="stylesheet">
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
            ['label' => 'Home', 'url' => ['/site/index']],
            ['label' => 'About', 'url' => ['/site/about']],
            ['label' => 'Contact', 'url' => ['/site/contact']],
            [
                'label' => 'Produtos',
                'items' => [
                    ['label' => 'Medicamentos', 'url' => ['site/blog']],
                    ['label' => 'Saúde Oral', 'url' => ['site/blog-detail']],
                    ['label' => 'Bens de beleza', 'url' => ['site/team']],
                    ['label' => 'Higiene', 'url' => ['site/testimonial']],
                    ['label' => 'Serviços', 'url' => ['site/appointment']],
                    ['label' => 'Encontrar farmácia', 'url' => ['site/search']],
                ],
            ],
        ];

        if (!Yii::$app->user->isGuest) {
            $menuItems[] = [
                'label' => '<i class="fa fa-user"></i>',
                'items' => [
                    ['label' => 'Definições do perfil', 'url' => ['profile/view', 'id' => Yii::$app->user->identity->getId()]],
                    ['label' => 'Editar perfil', 'url' => ['/profile/update', 'id' => Yii::$app->user->identity->getId()]],
                    ['label' => 'Receita médica', 'url' => ['site/search', 'id' => Yii::$app->user->identity->getId()]],
                ],
                'encode' => false,
            ];
        }


        if (Yii::$app->user->isGuest) {
            $menuItems[] = ['label' => 'Signup', 'url' => ['signup']];
        }

        if (!Yii::$app->user->isGuest) {
            $menuItems[3]['items'][] = ['label' => 'Estatísticas', 'url' => ['site/statistics']];
            $menuItems[] = ['label' => '<i class="fas fa-cart-arrow-down"></i>', 'encode' => false, 'url' => ['carrinho/view', 'id' => Yii::$app->user->identity->getId()]];
        }

        echo Nav::widget([
            'options' => ['class' => 'navbar-nav ms-auto py-0'],
            'items' => $menuItems,
        ]);
        if (Yii::$app->user->isGuest) {
            echo Html::a('Login', ['login'], ['class' => 'nav-item nav-link active']);
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
                        Get In Touch</h4>
                    <p class="mb-4">No dolore ipsum accusam no lorem. Invidunt sed clita kasd clita et et dolor sed
                        dolor</p>
                    <p class="mb-2"><i class="fa fa-map-marker-alt text-primary me-3"></i>123 Street, New York, USA</p>
                    <p class="mb-2"><i class="fa fa-envelope text-primary me-3"></i>info@example.com</p>
                    <p class="mb-0"><i class="fa fa-phone-alt text-primary me-3"></i>+012 345 67890</p>
                </div>
                <div class="col-lg-3 col-md-6">
                    <h4 class="d-inline-block text-primary text-uppercase border-bottom border-5 border-secondary mb-4">
                        Quick Links</h4>
                    <div class="d-flex flex-column justify-content-start">
                        <a class="text-light mb-2" href="#"><i class="fa fa-angle-right me-2"></i>Home</a>
                        <a class="text-light mb-2" href="#"><i class="fa fa-angle-right me-2"></i>About Us</a>
                        <a class="text-light mb-2" href="#"><i class="fa fa-angle-right me-2"></i>Our Services</a>
                        <a class="text-light mb-2" href="#"><i class="fa fa-angle-right me-2"></i>Meet The Team</a>
                        <a class="text-light mb-2" href="#"><i class="fa fa-angle-right me-2"></i>Latest Blog</a>
                        <a class="text-light" href="#"><i class="fa fa-angle-right me-2"></i>Contact Us</a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <h4 class="d-inline-block text-primary text-uppercase border-bottom border-5 border-secondary mb-4">
                        Popular Links</h4>
                    <div class="d-flex flex-column justify-content-start">
                        <a class="text-light mb-2" href="#"><i class="fa fa-angle-right me-2"></i>Home</a>
                        <a class="text-light mb-2" href="#"><i class="fa fa-angle-right me-2"></i>About Us</a>
                        <a class="text-light mb-2" href="#"><i class="fa fa-angle-right me-2"></i>Our Services</a>
                        <a class="text-light mb-2" href="#"><i class="fa fa-angle-right me-2"></i>Meet The Team</a>
                        <a class="text-light mb-2" href="#"><i class="fa fa-angle-right me-2"></i>Latest Blog</a>
                        <a class="text-light" href="#"><i class="fa fa-angle-right me-2"></i>Contact Us</a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <h4 class="d-inline-block text-primary text-uppercase border-bottom border-5 border-secondary mb-4">
                        Newsletter</h4>
                    <form action="">
                        <div class="input-group">
                            <input type="text" class="form-control p-3 border-0" placeholder="Your Email Address">
                            <button class="btn btn-primary">Sign Up</button>
                        </div>
                    </form>
                    <h6 class="text-primary text-uppercase mt-4 mb-3">Follow Us</h6>
                    <div class="d-flex">
                        <a class="btn btn-lg btn-primary btn-lg-square rounded-circle me-2" href="#"><i
                                    class="fab fa-twitter"></i></a>
                        <a class="btn btn-lg btn-primary btn-lg-square rounded-circle me-2" href="#"><i
                                    class="fab fa-facebook-f"></i></a>
                        <a class="btn btn-lg btn-primary btn-lg-square rounded-circle me-2" href="#"><i
                                    class="fab fa-linkedin-in"></i></a>
                        <a class="btn btn-lg btn-primary btn-lg-square rounded-circle" href="#"><i
                                    class="fab fa-instagram"></i></a>
                    </div>
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


