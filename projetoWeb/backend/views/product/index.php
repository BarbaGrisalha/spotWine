<?php

use common\models\Product;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var common\models\ProductSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */
/** @var backend\models\User $produtor */

$this->title = '111';

$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Inclusão de Produtos', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php echo $this->render(
            '_search',
            ['dataProvider' => $dataProvider],
            ['searchModel'=> $searchModel],
    ); ?>



   