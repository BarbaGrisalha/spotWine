<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\User $model */
/** @var common\models\UserDetails $userDetails */

$this->title = 'Create Users';
$this->params['breadcrumbs'][] = ['label' => 'User', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="users-create">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php $user = Yii::$app->user->identity; ?>//adicionei na mão.
    <?= $this->render('_form', [
        'model' => $model,
        'userDetails' => $userDetails,
    ]) ?>

</div>
