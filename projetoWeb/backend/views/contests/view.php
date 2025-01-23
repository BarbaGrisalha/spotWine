<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var common\models\Contests $model */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Contests', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="d-flex align-items-start">

    <img src="<?= Yii::getAlias('@web') . $model->image_url ?>" alt="Contest image" class="w-25">


    <div class="d-flex flex-column w-100 align-items-center">

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            [
                'attribute' => 'category_id',
                'value' => function($model) {
                    return $model->categories->name ?? 'n/a';
                },
            ],
            'name',
            'description:ntext',
            'registration_start_date',
            'registration_end_date',
            'contest_start_date',
            'contest_end_date',
            'status',
        ],
    ]) ?>
        <p>
            <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
            <?= Html::a('Delete', ['delete', 'id' => $model->id], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => 'Are you sure you want to delete this item?',
                    'method' => 'post',
                ],
            ]) ?>
        </p>
    </div>

</div>
