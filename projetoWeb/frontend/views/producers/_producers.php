<?php

use yii\helpers\Html;

?>

<div class=" bg-light mb-4 d-flex flex-column align-items-stretch text-center">
    <div class="product-img position-relative overflow-hidden">
        <?= Html::img('@web/img/produtor.png', [
            'class' => 'img-fluid w-100',
            'alt' => 'Imagem do local de produção',
        ]) ?>
    </div>
        <p><?=$model->location?></p>
        <h5><?= $model->winery_name?></h5>
    <?= Html::a('<i class="fa fa-info mr-2"></i> Saber Mais',  'producers/view', ['class' => 'btn btn-primary w-50']) ?>

</div>