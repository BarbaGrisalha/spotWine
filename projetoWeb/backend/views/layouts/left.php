<?php

/** @var \yii\web\View $this */
/** @var string $directoryAsset */
?>

<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <?= \yii\helpers\Html::a('<img class="brand-image img-circle elevation-3" src="' . ($directoryAsset . '/img/AdminLTELogo.png') . '" alt="APP"><span class="brand-text font-weight-light">' . Yii::$app->name . '</span>', Yii::$app->homeUrl, ['class' => 'brand-link']) ?>
    <div class="sidebar">
        <nav class="mt-2">
            <?= dmstr\adminlte\widgets\Menu::widget(
                [
                    'options' => ['class' => 'nav nav-pills nav-sidebar flex-column',
                        'data-widget' => 'treeview'],
                    'items' => [
                        ['label' => 'Menu BackOffice',
                            'header' => true],//ok. Alterado
                        ['label' => 'Dashboard',
                            'iconType' => 'fa',
                            'icon' => 'home',
                            'url' => ['/site/index']],
                             ['label' => 'Login',
                                 'url' => ['site/login'],
                                 'visible' => Yii::$app->user->isGuest],
                              [
                            'label' => 'Administration Tools',
                                  'icon' => 'share',
                                  'url' => '#',
                            'items' => [
                                ['label' => 'Gii',
                                    'iconType' => 'far',
                                    'icon' => 'file-code',
                                    'url' => ['/gii'],
                                    ],
                                ['label' => 'Debug',
                                    'icon' => 'tachometer-alt',
                                    'url' => ['/debug'],
                                    ],
                                ['label' => 'Email',
                                    'iconType' => 'fa',
                                    'icon'=> 'envelope',
                                    'url' =>['/site/developing']],
                                ['label' => 'Calendar',
                                    'iconType'=> 'fa',
                                    'icon' => 'calendar',
                                    'url'=>['/site/developing']],
                        ],
                    ],
                        [  'label' => 'Database Relatorio',
                            //'iconType' => 'far',
                            'icon' => 'share',
                            'url' => '#',
                            'items' => [
                                ['label' => 'Relatório de Produtos',
                                    'iconType' => 'far',
                                    'icon' => 'dot-circle',
                                    'url' => ['relatorio/relatorio-produtos'],
                                    'visible' => Yii::$app->user->can('createUsers'),
                                    ],
                                ['label' => 'Relatório Produtos/Categoria ',//com erro ainda.
                                    'iconType' => 'far',
                                    'icon' => 'dot-circle',
                                    'url' => ['relatorio/relatorio-por-produtor'],
                                   // 'url' => ['relatorio/relatorio-por-produtor','producerId'=>Yii::$app->user->identity->id],

                                ],
                                ['label' => 'Relatório Quantidade/Categoria ',//com erro ainda.
                                    'iconType' => 'far',
                                    'icon' => 'dot-circle',
                                    'url' => ['relatorio/relatorio-por-produtor'],
                                    // 'url' => ['relatorio/relatorio-por-produtor','producerId'=>Yii::$app->user->identity->id],

                                ],
                                ['label' => 'Relatório de Clienes',
                                    'iconType' => 'far',
                                    'icon' => 'dot-circle',
                                    'url' => ['relatorio/relatorio-clientes'],
                                    'visible' => Yii::$app->user->can('createUsers'),// Somente visível para a role admin
                                    ],
                            ],
                        ],
                        [   'label' => 'Gestão Utilizadores',
                            'icon' => 'share',
                            'url' => '#',
                            'items'=>[
                                ['label' => 'Gestão de Utilizadores',
                                    'iconType' => 'far',
                                    'icon' => 'dot-circle',
                                    'url' =>['/user/index'],
                                    'visible' => Yii::$app->user->can('createUsers'),// Somente visível para a role admin
                                ],
                                ['label' => 'Gestão dos Produtos',
                                    'iconType' => 'far',
                                    'icon' => 'dot-circle',
                                    'url' =>['/product/index'],
                                ],
                                ['label' => 'Gestão das promoções',
                                    'iconType' => 'far',
                                    'icon' => 'dot-circle',
                                    'url' =>['/promotions/index'],
                                ],

                            ],
                        ],
                        [
                            'label' => 'Gestão de Vinícola',
                            'icon' => 'wine-glass',
                            'url' => Yii::$app->user->identity->producers ?
                                ['producers/update', 'producer_id' => Yii::$app->user->identity->producers->id] : '#',
                            'items' => [
                                [
                                    'label' => 'Minha Vinícola',
                                    'iconType' => 'far',
                                    'icon' => 'building',
                                    'url' => Yii::$app->user->identity->producers ?
                                        ['producers/update', 'producer_id' => Yii::$app->user->identity->producers->id] : '#',
                                    'visible' => Yii::$app->user->identity->role === 'producer',
                                ],
                            ],
                        ],
                ],
               ]);   ?>
        </nav>
    </div>
</aside>
