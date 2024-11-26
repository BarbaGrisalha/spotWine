<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\User */
/* @var $details common\models\UserDetail */

$this->title = $model->username;
$this->params['breadcrumbs'][] = ['label' => 'Usuários', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'username',
            'email',
        ],
    ]) ?>

    <h3>Detalhes do Usuário</h3>
    <?php if ($details): ?>
        <?= DetailView::widget([
            'model' => $details,
            'attributes' => [
                'first_name',
                'last_name',
                'phone',
            ],
        ]) ?>
    <?php else: ?>
        <p>Sem detalhes adicionais.</p>
    <?php endif; ?>
</div>
