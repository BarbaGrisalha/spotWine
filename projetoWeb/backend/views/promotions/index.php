<?php

use common\models\Promotions;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var backend\models\PromotionSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Promotions';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="promotions-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Promotions', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            'promotion_id',
            'name',
            'start_date',
            'end_date',
            'discount_type',
            'discount_value',
            'condition_type',
            'condition_value',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, Promotions $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'promotion_id' => $model->promotion_id]);
                 }
            ],
        ],
    ]); ?>


</div>
