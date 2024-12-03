<div class="product-search mb-4">
    <?php use yii\helpers\Html;
    use yii\widgets\ActiveForm;
    use yii\widgets\ListView;

    $form = ActiveForm::begin([
    'method' => 'get',
    'action' => ['product/index'], // Garante que a pesquisa aconteça na página correta
]); ?>

    <!-- Campo de pesquisa por nome -->
    <div class="d-flex align-items-center mb-3">
        <?= $form->field($searchModel, 'name', [
            'options' => ['class' => 'flex-grow-1'],
        ])->textInput([
            'placeholder' => 'Pesquisar por nome do produto...',
            'class' => 'form-control',
        ])->label(false) ?>
    </div>

    <!-- Botão principal para abrir o dropdown -->
    <div class="dropdown mb-3">
        <button class="btn btn-primary" type="button" id="dropdownFilterButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="fas fa-filter text-white">Filtrar</i>
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

    <?php ActiveForm::end(); ?>
</div>

<!-- Lista de Produtos -->
<?= ListView::widget([
    'dataProvider' => $dataProvider,
    'itemView' => '_product', // Arquivo de template para exibir cada produto
    'layout' => "<div class='row'>{items}</div>\n{pager}", // Estrutura dos produtos
    'itemOptions' => ['class' => 'col-lg-3 col-md-4 col-sm-6 mb-4'], // Classes dos cartões
]); ?>
