<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\Contests $model */

$this->title = 'Criar Concurso';
$this->params['breadcrumbs'][] = ['label' => 'Contests', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="contests-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
