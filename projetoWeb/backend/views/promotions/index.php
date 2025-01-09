<?php

use common\models\Promotions;
use yii\grid\ActionColumn;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\bootstrap4\Breadcrumbs;
use yii\helpers\Url;

/** @var yii\web\View $this */
/** @var backend\models\PromotionSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Gestão de Promoções';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="promotions-index container mt-4">

    <div class="row mb-3">
        <div class="col-12 text-right">
            <?= Html::a('Criar Promoção', ['create'], ['class' => 'btn btn-success']) ?>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'tableOptions' => ['class' => 'table table-striped table-bordered'],
                'columns' => [
                    [
                        'attribute' => 'promotion_id',
                        'label' => 'ID',
                        'contentOptions' => ['style' => 'width: 50px; text-align: center;'],
                    ],
                    'name',
                    [
                        'attribute' => 'start_date',
                        'label' => 'Início',
                        'format' => ['date', 'php:d/m/Y'],
                    ],
                    [
                        'attribute' => 'end_date',
                        'label' => 'Fim',
                        'format' => ['date', 'php:d/m/Y'],
                    ],
                    [
                        'attribute' => 'discount_type',
                        'label' => 'Tipo Desconto',
                        'value' => function ($model) {
                            return $model->discount_type === 'percent' ? 'Percentual' : 'Valor Fixo';
                        },
                        'contentOptions' => ['class' => 'text-center'],
                    ],
                    [
                        'attribute' => 'discount_value',
                        'label' => 'Desconto',
                        'value' => function ($model) {
                            return $model->discount_type === 'percent'
                                ? $model->discount_value . '%'
                                : '€ ' . number_format($model->discount_value, 2);
                        },
                        'contentOptions' => ['class' => 'text-center'],
                    ],
                    [
                        'attribute' => 'condition_type',
                        'label' => 'Condição',
                        'value' => function ($model) {
                            return $model->condition_type === 'min_purchase'
                                ? 'Compra Mínima'
                                : ($model->condition_type === 'quantity' ? 'Quantidade Mínima' : 'Nenhuma');
                        },
                        'contentOptions' => ['class' => 'text-center'],
                    ],
                    [
                        'attribute' => 'condition_value',
                        'label' => 'Valor Condição',
                        'value' => function ($model) {
                            return $model->condition_value ? '€ ' . number_format($model->condition_value, 2) : 'N/A';
                        },
                        'contentOptions' => ['class' => 'text-center'],
                    ],
                    [
                        'class' => ActionColumn::className(),
                        'urlCreator' => function ($action, Promotions $model, $key, $index, $column) {
                            return Url::toRoute([$action, 'promotion_id' => $model->promotion_id]);
                        },
                    ],
                ],
            ]); ?>
        </div>
    </div>
</div>
