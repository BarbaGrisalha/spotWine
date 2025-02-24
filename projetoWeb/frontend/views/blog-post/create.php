<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\BlogPosts $model */

$this->title = 'Create Blog Posts';
$this->params['breadcrumbs'][] = ['label' => 'Blog Posts', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="blog-posts-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,

    ]) ?>

</div>
