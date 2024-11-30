<?php header("Content-Type: text/css; charset=UTF-8"); ?>
<link rel="stylesheet" href="/frontend/web/css/style.css"/>

<?php
use yii\helpers\Html;

?>

<div class="card">
    <?= Html::encode($model->name) ?>
    <p>
        <small> <?= Html::encode($model->price)?> </small>
    </p>
    <p>
        <small> <?= Html::encode($model->categories->name) ?> </small>
    </p>
    <p>

    </p>


    <p>
        <?= Html::a('Ver', ['product/index', 'id' => $model->product_id], ['class' => 'btnChapter']) ?>
        <?= Html::a('Editar', ['product/update', 'id' => $model->product_id], ['class' => 'teste']) ?>
        <?= Html::a('Deletar', ['product/delete', 'id' => $model->product_id],[
            'class' => 'btnDelete',
            //Com isso, ao clicar em "Deletar", o Yii vai automaticamente enviar uma requisição POST para a ação delete do controlador, conforme esperado pelo VerbFilter.
            //O data-confirm também exibe uma mensagem de confirmação ao usuário antes de prosseguir.
            'data' => [
                'method' => 'post', // Força o método POST
                'confirm' => 'Tem certeza de que deseja excluir este livro?', // Adiciona uma confirmação antes de excluir
            ], ['class' => 'btnDelete'],
        ]) ?>
    </p>
</div>