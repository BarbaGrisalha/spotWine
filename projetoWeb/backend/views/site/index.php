<?php
/** @var yii\web\View $this */
/** @var array $clientes */

use yii\helpers\Html;

$this->title = 'SpotWine_Backend';
?>
<div class="site-index">
    <div class="jumbotron text-center bg-transparent">
        <h1 class="display-4">Backend, Atenção!</h1>

        <p class="lead">You have successfully accessed the backend in your Yii-powered application.</p>
        <h1>Relatórios</h1>
        <ul>
            <?php foreach ($clientes as $cliente): ?>
                <li>
                   Nome: <?= Html::encode("{$cliente->name}") ?> email: <?= Html::encode($cliente->email) ?>
                </li>
            <?php endforeach; ?>
        </ul>
        <p><a class="btn btn-lg btn-success" href="https://www.yiiframework.com">Relatório de Clientes</a></p>
        <br>
        <p><a class="btn btn-lg btn-success" href="https://www.yiiframework.com">Relatório de Produtores</a></p>
        <br>
        <p><a class="btn btn-lg btn-success" href="https://www.yiiframework.com">Relatório de Produtos</a></p>
    </div>
</div>