<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\User $model */
/** @var common\models\ProducerDetails $producerDetails */

$this->title = 'Create Users';
$this->params['breadcrumbs'][] = ['label' => 'User', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="users-create">


    <?php $user = Yii::$app->user->identity; ?>
    <?= $this->render('_form', [
        'model' => $model,
        'userDetails' => $producerDetails,
    ]) ?>

</div>
