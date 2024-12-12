<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\ListView;

$this->params['breadcrumbs'][] = ['label' => 'Products', 'url' => ['index']];

$form = ActiveForm::begin([
    'method' => 'get',
    'action' => ['product/index'], // Garante que a pesquisa aconteça na página correta
]); ?>

<div class="container mb-3">
    <div class="row justify-content-center">
        <!-- Campo de pesquisa e filtro no mesmo nível -->
        <div class="col-md-8 d-flex align-items-center">
            <!-- Campo de pesquisa -->
            <div class="flex-grow-1">
                <?= $form->field($searchModel, 'name', [
                    'options' => ['class' => 'mb-0'],
                ])->textInput([
                    'placeholder' => 'Pesquisar por nome do produto...',
                    'class' => 'form-control',
                ])->label(false) ?>
            </div>

            <!-- Botão principal para abrir o dropdown -->
            <div class="dropdown ml-3">
                <button class="btn btn-primary" type="button" id="dropdownFilterButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-filter text-white"> Filtrar</i>
                </button>

                <!-- Conteúdo do dropdown -->
                <div class="dropdown-menu p-4" aria-labelledby="dropdownFilterButton">
                    <!-- Botão "X" para fechar -->
                    <button type="button" class="close-dropdown btn btn-sm btn-danger text-black-50" id="closeDropdownButton" aria-label="Close">
                        &times;
                    </button>
                    <h1 class="text-center">Filtro</h1>
                    <div class="dropdown-divider"></div>
                    <!-- Categorias estilizadas -->
                    <h6 class="dropdown-header">Categorias</h6>
                    <div class="category-list">
                        <?php foreach ($categoriesList as $key => $category): ?>
                            <div class="form-check mb-2">
                                <?= Html::radio('ProductFrontSearch[category_id]', $key == $searchModel->category_id, [
                                    'value' => $key,
                                    'class' => 'form-check-input',
                                    'id' => 'category-' . $key,
                                ]) ?>
                                <?= Html::label($category, 'category-' . $key, ['class' => 'form-check-label']) ?>
                            </div>
                        <?php endforeach; ?>
                    </div>


                    <div class="dropdown-divider"></div>
                    <!--TODO MUDAR PARA PEGAR OS PREÇOS EM PROMOÇÃO TAMBÉM -->
                    <!-- Campo de Preço Mínimo -->
                    <?= $form->field($searchModel, 'price_min')->textInput([
                        'placeholder' => 'Preço mínimo',
                        'class' => 'form-control mb-3',
                    ])->label('<i class="fas fa-dollar-sign"></i> Preço Mínimo') ?>

                    <!-- Campo de Preço Máximo -->
                    <?= $form->field($searchModel, 'price_max')->textInput([
                        'placeholder' => 'Preço máximo',
                        'class' => 'form-control mb-3',
                    ])->label('<i class="fas fa-dollar-sign"></i> Preço Máximo') ?>

                    <div class="form-check mb-2">
                        <?= Html::radio('ProductFrontSearch[filter]', $searchModel->filter === 'mais_vendidos', [
                            'value' => 'mais_vendidos',
                            'class' => 'form-check-input',
                            'id' => 'filter-mais-vendidos',
                        ]) ?>
                        <?= Html::label('Mais Vendidos', 'filter-mais-vendidos', ['class' => 'form-check-label']) ?>
                    </div>

                    <div class="form-check mb-2">
                        <?= Html::radio('ProductFrontSearch[filter]', $searchModel->filter === 'promocoes', [
                            'value' => 'promocoes',
                            'class' => 'form-check-input',
                            'id' => 'filter-promocoes',
                        ]) ?>
                        <?= Html::label('Promoções', 'filter-promocoes', ['class' => 'form-check-label']) ?>
                    </div>

                    <!-- Botões de Aplicar Filtros e Resetar -->
                    <div class="d-flex justify-content-between">
                        <?= Html::submitButton(
                            Html::tag('span', '<i class="fas fa-check mr-2"></i> Aplicar Filtros', ['class' => 'text-white']),
                            ['class' => 'btn btn-success']
                        ) ?>
                        <?= Html::a(
                            Html::tag('span', '<i class="fas fa-times mr-2"></i> Resetar Filtros', ['class' => 'text-white']),
                            ['product/index'], // Remove os parâmetros GET
                            ['class' => 'btn btn-danger']
                        ) ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php ActiveForm::end(); ?>

<!-- Lista de Produtos -->
<?= ListView::widget([
    'dataProvider' => $dataProvider,
    'itemView' => '_product', // Arquivo de template para exibir cada produto
    'layout' => "<div class='row'>{items}</div>\n{pager}", // Estrutura dos produtos
    'itemOptions' => ['class' => 'col-lg-3 col-md-4 col-sm-6 mb-4'], // Classes dos cartões
]); ?>
