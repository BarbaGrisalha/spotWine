<?php
/** @var yii\web\View $this */
/** @var array $produtos */

use yii\helpers\Url;
use yii\helpers\Html;
use backend\models\Products;
use yii\widgets\LinkPager;


$this->title = "Relatório de Produtos";
?>
<style>
    .relatorio-produtos {
        text-align: center; /* Centraliza o conteúdo */
    }

    .relatorio-produtos ul {
        list-style-type: none; /* Remove os marcadores da lista */
        padding: 0; /* Remove o padding da lista */
    }

    .relatorio-produtos li {
        text-align: left; /* Alinha o texto à esquerda dentro de cada item */
        margin-bottom: 10px; /* Adiciona um espaço entre os itens */
        padding-left: 20px; /* Dá um pequeno espaço à esquerda dos itens */
        border-bottom: 1px solid #ddd; /* Adiciona uma linha separando cada item */
        padding-bottom: 10px; /* Adiciona um padding no fundo */
    }

    .relatorio-produtos h1 {
        margin-bottom: 20px; /* Espaçamento entre o título e a lista */
    }

    .btn {
        margin-top: 20px;
    }

</style>
<div class="relatorio-produtos">
    <h1>Relatório de Produtos</h1>
    <ul>
        <?php foreach ($produtos as $produto): ?>
            <li>
                Produtor: <?=Html::encode($produto->producer ? $produto->producer->winery_name: 'Produtor não encontrado') ?><br>
                Nome: <?=Html::encode($produto->name) ?><br>
                Categoria: <?=Html::encode($produto->category ? $produto->category->name : 'Categoria não encontrada') ?> <br>
                Preço: <?=Html::encode($produto->price) ?>
            </li>
        <?php endforeach; ?>
    </ul>
    <!-- aqui exibir a paginação-->
    <?=  LinkPager::widget([
            'pagination'=>$pagination,
    ]); ?>
    <p><a href="<?=Url::to(['site/index'])?>" class="btn btn-primary">Voltar </a></p>
</div>
