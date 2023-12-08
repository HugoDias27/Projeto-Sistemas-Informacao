<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="<?= Yii::$app->homeUrl ?>" class="brand-link">
        <span class="brand-text font-weight-light"><?= $this->title = 'Carolo Farmacêutica'; ?></span>
    </a>


    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="info">
                <a class="d-block">Bem vindo, <?= Yii::$app->user->identity->username ?></a>
            </div>
        </div>

        <!-- SidebarSearch Form -->
        <!-- href be escaped -->
        <!-- <div class="form-inline">
            <div class="input-group" data-widget="sidebar-search">
                <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
                <div class="input-group-append">
                    <button class="btn btn-sidebar">
                        <i class="fas fa-search fa-fw"></i>
                    </button>
                </div>
            </div>
        </div> -->

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <?php
            use yii\bootstrap5\Html;
            echo \hail812\adminlte\widgets\Menu::widget([
                'items' => [
                    ['label' => 'Yii2 PROVIDED', 'header' => true],
                    ['label' => 'Login', 'url' => ['site/login'], 'icon' => 'sign-in-alt', 'visible' => Yii::$app->user->isGuest],
                    ['label' => 'Gii',  'icon' => 'file-code', 'url' => ['/gii'], 'target' => '_blank'],
                    ['label' => 'Debug', 'icon' => 'bug', 'url' => ['/debug'], 'target' => '_blank'],
                    ['label' => 'Registo de utilizadores',  'icon' => 'fa fa-user-plus', 'url' => ['user/index']],
                    ['label' => 'O meu perfil', 'url' => ['profile/create', 'id' => Yii::$app->user->id], 'icon' => 'fa fa-user-plus',],
                    [
                        'label' => 'Gestão de dados',
                        'icon' => 'nav-icon fas fa-edit',
                        'items' => [
                            ['label' => 'Gerir medicamentos', 'url' => ['produto/index'], 'icon' => 'fa-solid fa-pills'],
                            ['label' => 'Gerir categorias', 'url' => ['categoria/index'], 'icon' => 'fa-solid fa-pills'],
                            ['label' => 'Gerir vendas', 'url' => ['venda/index'], 'icon' => 'fa-solid fa-money-bill'],
                            ['label' => 'Gerir serviços', 'url' => ['servico/index'], 'icon' => 'fas fa-mail-bulk'],
                            ['label' => 'Gerir fornecedor', 'url' => ['fornecedor/index'], 'icon' => 'fas fa-truck', 'style' =>'color: #ffffff'],
                            ['label' => 'Gerir receitas médicas', 'url' => ['receita/index'],'icon' => 'fas fa-prescription-bottle-alt', 'style' =>'color: #ffffff'],
                            ['label' => 'Gerir estabelecimentos', 'url' => ['estabelecimento/index'], 'icon' => 'fas fa-building', 'style' =>'color: #ffffff'],
                            ['label' => 'Gerir despesas', 'url' => ['despesa/index'], 'icon' => 'fas fa-money-check-alt', 'style' =>'color: #ffffff'],
                            ['label' => 'Gerir faturas', 'icon' => 'fas fa-file-invoice', 'style' =>'color: #ffffff'],
                            ['label' => 'Gerir ivas', 'url' => ['iva/index'], 'icon' => 'fas fa-euro-sign', 'style' =>'color: #ffffff'],
                        ]
                    ],
                ],
            ]);
            ?>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>