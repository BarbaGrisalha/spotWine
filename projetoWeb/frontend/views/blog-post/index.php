<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ListView;

/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */
/** @var common\models\BlogPostSearch $searchModel */

$this->title = 'Posts do Blog';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="blog-post-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="d-flex justify-content-between align-items-center">
        <p>
            <?= Html::a('Criar Post', ['create'], ['class' => 'btn btn-success']) ?>
        </p>

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


    </div>


    <div class="row">
        <?= ListView::widget([
            'dataProvider' => $dataProvider,
            'itemView' => function ($model) {
                return $this->render('_post', ['model' => $model]);
            },
            'layout' => "<div class='row'>{items}</div>\n{pager}", // Configuração de layout
            'itemOptions' => ['class' => 'col-lg-6 col- md-6 mb-4'], // Classes de estilo para os cards
        ]) ?>
    </div>
</div>
