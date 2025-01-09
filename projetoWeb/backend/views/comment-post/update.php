<?php


use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\Comments $model */

$this->params['breadcrumbs'][] = 'Update';
$this->title = 'Meu Comentário'
?>
<div class="blog-posts-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
