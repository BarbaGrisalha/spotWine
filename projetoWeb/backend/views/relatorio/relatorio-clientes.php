<?php
/** @var yii\web\View $this */
/** @var array $clientes */

use yii\helpers\Html;
use backend\models\Products;
use yii\widgets\LinkPager;
use yii\helpers\Url;


$this->title = "Relatório de Clientes";
?>
<style>
    .relatorio-clientes {
        text-align: center; /* Centraliza o conteúdo */
    }

    .relatorio-clientes ul {
        list-style-type: none; /* Remove os marcadores da lista */
        padding: 0; /* Remove o padding da lista */
    }

    .relatorio-clientes li {
        text-align: left; /* Alinha o texto à esquerda dentro de cada item */
        margin-bottom: 10px; /* Adiciona um espaço entre os itens */
        padding-left: 20px; /* Dá um pequeno espaço à esquerda dos itens */
        border-bottom: 1px solid #ddd; /* Adiciona uma linha separando cada item */
        padding-bottom: 10px; /* Adiciona um padding no fundo */
    }

    .relatorio-clientes h1 {
        margin-bottom: 20px; /* Espaçamento entre o título e a lista */
    }

    .btn {
        margin-top: 20px;
    }

</style>
<div class="relatorio-clientes">
    <h1>Relatório de Clientes</h1>
    <ul>
        <?php foreach ($clientes as $cliente): ?>
            <li>
                Nome: <?=Html::encode($cliente->username) ?><br>//alterei o nome para username em vez de name
                Email: <?=Html::encode($cliente->email) ?><br>

            </li>
        <?php endforeach; ?>
    </ul>
    <!-- aqui exibir a paginação-->
    <?=  LinkPager::widget([
            'pagination'=>$pagination,
    ]); ?>
    <p><a href="<?=Url::to(['site/index'])?>" class="btn btn-primary">Voltar </a></p>
</div>
