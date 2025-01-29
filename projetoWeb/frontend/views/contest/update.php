<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\Contests $model */

$this->title = 'Update Contests: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Contests', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="contests-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
