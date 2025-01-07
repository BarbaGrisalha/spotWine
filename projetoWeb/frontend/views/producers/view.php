<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\widgets\ListView;

/** @var yii\web\View $this */
/** @var common\models\ProducerDetails $model */

$this->title = $model->winery_name . ', ' . $model->region;
$this->params['breadcrumbs'][] = ['label' => 'Producers', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="producers-view">

    <h1 class="text-center mb-4">
        <?= Html::encode($this->title) ?>
    </h1>

    <div class="text-center mb-4">
        <?= Html::img('@web/img/produtor.png', [
            'class' => 'img-fluid rounded-circle', // Classe Bootstrap para imagem circular
            'alt' => 'Imagem do produtor',
            'style' => 'max-width: 150px;', // Redimensiona a imagem
        ]) ?>
    </div>

    <div class="text-center mb-4">
        <p><?= Html::encode($model->notes) ?></p>
    </div>

    <div class="card mb-4">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0 text-white">Detalhes do Produtor</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <p><strong>Região:</strong> <?= Html::encode($model->region) ?></p>
                    <p><strong>Cidade:</strong> <?= Html::encode($model->city) ?></p>
<!--                    <p><strong>País:</strong> --><?php //= Html::encode($model->country) ?><!--</p>-->
                </div>
                <div class="col-md-6">
                    <p><strong>Telefone:</strong> <?= Html::encode($model->phone) ?></p>
                    <p><strong>Celular:</strong> <?= Html::encode($model->mobile) ?></p>
                    <p><strong>Email:</strong> <?= Html::encode($model->user->email ?? 'N/A') ?></p>
                </div>
            </div>
            <hr>
            <div class="row">
                <div class="col-md-12">
                    <p><strong>Endereço:</strong> <?= Html::encode($model->address) ?>, <?= Html::encode($model->number) ?> <?= Html::encode($model->complement) ?></p>
                    <p><strong>CEP:</strong> <?= Html::encode($model->postal_code) ?></p>
                </div>
            </div>
        </div>
    </div>

    <h2 class="text-center mb-4">Vinhos</h2>

    <?= ListView::widget([
        'dataProvider' => $dataProvider,
        'itemView' => '@app/views/product/_product', // Arquivo de template para exibir cada produto
        'viewParams' => [
            'cartItemModel' => $cartItemModel, // Passa o modelo do carrinho para cada item
        ],
        'layout' => "<div class='row'>{items}</div>\n{pager}", // Estrutura dos produtos
        'itemOptions' => ['class' => 'col-lg-3 col-md-4 col-sm-6 mb-4'], // Classes dos cartões
    ]); ?>

</div>
