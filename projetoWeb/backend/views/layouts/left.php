<?php

/** @var \yii\web\View $this */
/** @var string $directoryAsset */

use yii\helpers\Html;

?>

<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <?= Html::a(
        '<div class="d-flex align-items-center">
            <img class="brand-image img-circle elevation-3 me-2" 
                 src="/frontend/web/img/logo.png" 
                 alt="APP" 
                 style="width: 50px; height: 50px;">
            <span class="brand-text font-weight-light">' . Yii::$app->name . '</span>
        </div>',
        Yii::$app->homeUrl,
        ['class' => 'brand-link']
    ) ?>

    <div class="sidebar">
        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <?= dmstr\adminlte\widgets\Menu::widget([
                'options' => ['class' => 'nav nav-pills nav-sidebar flex-column', 'data-widget' => 'treeview'],
                'items' => [
                    ['label' => 'Menu BackOffice', 'header' => true],

                    ['label' => 'Dashboard', 'icon' => 'fa fa-home', 'url' => ['/site/index']],

                    [
                        'label' => 'Login',
                        'icon' => 'fa fa-sign-in-alt',
                        'url' => ['site/login'],
                        'visible' => Yii::$app->user->isGuest,
                    ],

                    [
                        'label' => 'Administration Tools',
                        'icon' => 'fa fa-cogs',
                        'url' => '#',
                        'items' => [
                            ['label' => 'Gii', 'icon' => 'far fa-file-code', 'url' => ['/gii']],
                            ['label' => 'Debug', 'icon' => 'fa fa-tachometer-alt', 'url' => ['/debug']],
                            ['label' => 'Email', 'icon' => 'fa fa-envelope', 'url' => ['/site/developing']],
                            ['label' => 'Calendar', 'icon' => 'fa fa-calendar', 'url' => ['/site/developing']],
                        ],
                    ],

                    [
                        'label' => 'Database Relatório',
                        'icon' => 'fa fa-database',
                        'url' => '#',
                        'items' => [
                            [
                                'label' => 'Relatório de Produtos',
                                'icon' => 'far fa-dot-circle',
                                'url' => ['relatorio/relatorio-produtos'],
                                'visible' => Yii::$app->user->can('createUsers'),
                            ],
                            [
                                'label' => 'Relatório Produtos/Categoria',
                                'icon' => 'far fa-dot-circle',
                                'url' => ['relatorio/relatorio-por-produtor'],
                            ],
                            [
                                'label' => 'Relatório Quantidade/Categoria',
                                'icon' => 'far fa-dot-circle',
                                'url' => ['relatorio/relatorio-por-produtor'],
                            ],
                            [
                                'label' => 'Relatório de Clientes',
                                'icon' => 'far fa-dot-circle',
                                'url' => ['relatorio/relatorio-clientes'],
                                'visible' => Yii::$app->user->can('createUsers'),
                            ],
                        ],
                    ],

                    ['label' => 'Gestão de Utilizadores', 'icon' => 'far fa-user', 'url' => ['/user/index'], 'visible' => Yii::$app->user->can('createUsers')],
                    ['label' => 'Gestão dos Produtos', 'icon' => 'far fa-box', 'url' => ['/product/index']],
                    ['label' => 'Gestão das Promoções', 'icon' => 'far fa-percentage', 'url' => ['/promotions/index']],

                    [
                        'label' => 'Gestão de Vinícola',
                        'icon' => 'fa fa-wine-glass',
                        'url' => Yii::$app->user->identity->producerDetails ?
                            ['producers/update', 'producer_id' => Yii::$app->user->identity->producerDetails->id] : '#',
                        'items' => [
                            [
                                'label' => 'Minha Vinícola',
                                'icon' => 'far fa-building',
                                'url' => Yii::$app->user->identity->producerDetails ?
                                    ['producers/update', 'producer_id' => Yii::$app->user->identity->producerDetails->id] : '#',
                                'visible' => Yii::$app->user->identity->role === 'producer',
                            ],
                        ],
                    ],
                ],
            ]) ?>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
</aside>
