<?php

use app\models\Producers;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\ProducersSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Producers';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="producers-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Producers', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'producer_id',
            'user_id',
            'winery_name',
            'location',
            'document_id',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, Producers $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'producer_id' => $model->producer_id]);
                 }
            ],
        ],
    ]); ?>


</div>
