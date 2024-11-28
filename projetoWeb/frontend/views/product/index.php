<?php
/** @var yii\web\View $this */

use yii\grid\GridView;
use yii\helpers\Html;

$this->title = 'Lista de Produtos';

$this->params['breadcrumbs'][] = $this->title;

/** @var yii\web\View $this */
/** @var \common\models\UserSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */
?>

<?=
html::tag('h1', Html::encode($this->title)) ,
    GridView::widget([
       'dataProvider' => $dataProvider,
       'filterModel' => $searchModel,
       'columns' => [
           'product_id',
           'name',
           'price:currency',
           [
               'attribute' => 'producer_id',
               'value' => function ($model) {
                   return $model->producers->winery_name ?? 'N/A'; //producers está como o nome da relação e não igual a tabela
               },
           ],
           [
               'attribute' => 'category_id',
               'value' => function ($model) {
                   return $model->categories->name ?? 'N/A'; //producers está como o nome da relação e não igual a tabela
               },
           ],

           [
               'class' => 'yii\grid\ActionColumn',
               'template' => '{view}', // Apenas exibir detalhes
           ],
       ]
    ])

?>


