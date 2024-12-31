<?php
/** @var yii\web\View $this */
/** @var array $produtos */

use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use yii\helpers\Html;
use common\models\Producers;
use common\models\Product;
use yii\widgets\LinkPager;

$this->title = "Relatório de Produtos linha 12";
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

    <div>
        <?php
        //dd( ArrayHelper::map(Producers::find()->asArray()->all(), 'producer_id','winery_name'));
        $form = ActiveForm::begin(['method'=> 'get', 'action' => ['relatorio/index']]); ?>
            <?= Html::label('Selecione o Produtor', 'producer_id')?>


            <?= Html::dropDownList('producer_id',null,
                ArrayHelper::map(Producers::find()->asArray()->all(), 'producer_id','winery_name'),
                ['prompt'=> 'Select a Producer','class' => 'form-control'],

        )?>
        <br>
        <?= Html::submitButton('Filtrar',['class'=> 'btn btn-primary'])?>
        <?php ActiveForm::end(); ?>
    </div>
    <ul>
        <?php
        foreach ($produtos as $produto): ?>

            <li>
                Produtor: <?=Html::encode($produto->producers ? $produto->producers->winery_name: 'Produtor não encontrado') ?><br>
                Nome: <?=Html::encode($produto->name) ?><br>
                Categoria: <?=Html::encode($produto->categories ? $produto->categories->name : 'Categoria não encontrada') ?> <br>
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
