<?php

use common\models\BlogPosts;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\ListView;

/** @var yii\web\View $this */
/** @var common\models\BlogPostSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Blog Posts';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="blog-posts-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Blog Posts', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <div class="filter-buttons">
        <p>
            <?= Html::a('Mostrar Todos', ['index', 'showAll' => 1], [
                'class' => $showAll ? 'btn btn-primary' : 'btn btn-secondary',
            ]) ?>
            <?= Html::a('Mostrar Meus Posts', ['index', 'showAll' => 0], [
                'class' => !$showAll ? 'btn btn-primary' : 'btn btn-secondary',
            ]) ?>
        </p>
    </div>

    <?= ListView::widget([
        'dataProvider' => $dataProvider,
        'itemView' => '_post', // Arquivo de template para exibir cada produto
//        'viewParams' => [
//            'cartItemModel' => $cartItemModel, // Passa o modelo do carrinho para cada item
//        ],
        'layout' => "<div class='row'>{items}</div>\n{pager}", // Estrutura dos produtos
        'itemOptions' => ['class' => 'col-lg-3 col-md-4 col-sm-6 mb-4'], // Classes dos cartões

    ]); ?>


</div>
