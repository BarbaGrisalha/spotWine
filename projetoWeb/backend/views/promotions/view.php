<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var common\models\Promotions $model */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Promotions', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="promotions-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'promotion_id' => $model->promotion_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'promotion_id' => $model->promotion_id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'promotion_id',
            'start_date',
            'end_date',
            'discount_type',
            'discount_value',
            'condition_type',
            'condition_value',
        ],
    ]) ?>

</div>
