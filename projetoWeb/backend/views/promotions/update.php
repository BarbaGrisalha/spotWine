<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\Promotions $model */

$this->title = 'Update Promotions: ' . $model->promotion_id;
$this->params['breadcrumbs'][] = ['label' => 'Promotions', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->promotion_id, 'url' => ['view', 'promotion_id' => $model->promotion_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="promotions-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'availableProducts' => $availableProducts,
    ]) ?>

</div>
