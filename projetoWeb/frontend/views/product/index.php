<?php

use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\ListView;

$this->title = 'Lista de Produtos';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-search mb-4">
    <?php $form = ActiveForm::begin([
        'method' => 'get', // Envia os dados por GET
    ]); ?>

    <?= $form->field($searchModel, 'name')->textInput(['placeholder' => 'Pesquisar por nome do produto'])->label(false) ?>

    <?= Html::submitButton('Pesquisar', ['class' => 'btn btn-primary']) ?>

    <?php ActiveForm::end(); ?>
</div>
<?=ListView::widget([
    'dataProvider' => $dataProvider,
    'itemView' => '_product', // Cada produto será renderizado usando o arquivo _product.php
    'layout' => "<div class='row'>{items}</div>\n{pager}", // Renderiza os itens dentro de um grid
    'itemOptions' => ['class' => 'col-lg-3 col-md-4 col-sm-6 mb-4'], // Define as classes para cada item
]); ?>




<!--
//html::tag('h1', Html::encode($this->title)) ,
//    GridView::widget([
//       'dataProvider' => $dataProvider,
//       'filterModel' => $searchModel,
//       'columns' => [
//           'product_id',
//           'name',
//           'price:currency',
//           [
//               'attribute' => 'producer_id',
//               'value' => function ($model) {
//                   return $model->producers->winery_name ?? 'N/A'; //producers está como o nome da relação e não igual a tabela
//               },
//           ],
//           [
//               'attribute' => 'category_id',
//               'value' => function ($model) {
//                   return $model->categories->name ?? 'N/A'; //producers está como o nome da relação e não igual a tabela
//               },
//           ],
//
//           [
//               'class' => 'yii\grid\ActionColumn',
//               'template' => '{view}', // Apenas exibir detalhes
//           ],
//       ]
//    ])

-->


