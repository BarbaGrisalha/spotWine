<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\Product $model */

$this->title = 'Create Product1';
$this->params['breadcrumbs'][] = ['label' => 'Products', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-create">
   <?php $user = Yii::$app->user->identity; ?>
    <?= $this->render('_form', [
        'model' => $model,
        'user' => $user,
    ]) ?>

</div>
