<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\Promotions $model */
/** @var common\models\Product $product */

$this->title = 'Create Promotions';
$this->params['breadcrumbs'][] = ['label' => 'Promotions', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\backend\assets\AppAsset::register($this);
?>
<div class="promotions-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'availableProducts' => $availableProducts,
    ]) ?>

</div>
