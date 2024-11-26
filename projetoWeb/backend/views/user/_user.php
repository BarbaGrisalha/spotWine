<?php header("Content-Type: text/css; charset=UTF-8"); ?>
<link rel="stylesheet" href="/frontend/web/css/style.css"/>

<?php
use yii\helpers\Html;
?>

<div class="body-content">
    <?= Html::encode($model->name) ?>
    <p>
        <small> <?= Html::encode($model->isbn)?> </small>
    </p>
    <p>
        <small> <?= Html::encode($model->genre->name) ?> </small>
    </p>

    <p>
        <?= Html::a('Chapters', ['chapter/index', 'id' => $model->id], ['class' => 'btnChapter']) ?>
        <?= Html::a('Editar', ['book/update', 'id' => $model->id], ['class' => 'teste']) ?>
        <?= Html::a('Deletar', ['book/delete', 'id' => $model->id],[
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