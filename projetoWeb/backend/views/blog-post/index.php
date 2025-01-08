<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ListView;

/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */
/** @var common\models\BlogPostsSearch $searchModel */

$this->title = 'Posts do Blog';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="blog-post-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Criar Post', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <div class="row">
        <?= ListView::widget([
            'dataProvider' => $dataProvider,
            'itemView' => function ($model) {
                return $this->render('_post', ['model' => $model]);
            },
            'layout' => "<div class='row'>{items}</div>\n{pager}", // Configuração de layout
            'itemOptions' => ['class' => 'col-lg-4 col-md-6 mb-4'], // Classes de estilo para os cards
        ]) ?>
    </div>
</div>
