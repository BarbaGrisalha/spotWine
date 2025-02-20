<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\User $user */
/** @var common\models\ConsumerDetails $consumerDetails */

$this->title = 'Perfil de ' . Html::encode($user->username);
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="user-profile">
    <h1><?= Html::encode($this->title) ?></h1>

    <table class="table table-striped">
        <tr>
            <th>Nome:</th>
            <td><?= Html::encode($user->username) ?></td>
        </tr>
        <tr>
            <th>Email:</th>
            <td><?= Html::encode($user->email) ?></td>
        </tr>
        <tr>
            <th>Data de Criação:</th>
            <td><?= Yii::$app->formatter->asDate($user->created_at, 'long') ?></td>
        </tr>
        <?php if ($consumerDetails): ?>
            <tr>
                <th>Telefone:</th>
                <td><?= Html::encode($consumerDetails->phone_number) ?></td>
            </tr>
        <!--
            <tr>
                <th>Endereço:</th>
               <td>--><?php //= Html::encode($consumerDetails->address) ?><!--</td>-->
            </tr>


        <?php endif; ?>
    </table>

    <p>
        <?= Html::a('Editar Perfil', ['accounts/edit-profile', 'id' => $user->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Alterar Senha', ['accounts/change-password'], ['class' => 'btn btn-warning']) ?>
    </p>
</div>
