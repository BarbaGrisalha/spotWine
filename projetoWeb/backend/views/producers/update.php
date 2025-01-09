<?php

use common\models\Producers;
use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var Producers $model */

$this->title = 'Atualização Produtor: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Producers', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'producer_id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="producers-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
