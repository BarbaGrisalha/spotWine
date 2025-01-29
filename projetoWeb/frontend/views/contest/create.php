<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\Contests $model */

$this->title = 'Create Contests';
$this->params['breadcrumbs'][] = ['label' => 'Contests', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="contests-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
