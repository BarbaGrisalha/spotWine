<?php

use common\models\ProducerDetails;
use common\models\Producers;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\ListView;

/** @var yii\web\View $this */
/** @var frontend\models\ProducerSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Produtores';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="producers-index">

    <h1><?= Html::encode($this->title) ?></h1>


    <?= ListView::widget([
        'dataProvider' => $dataProvider,
        'itemView' => '_producers', // Arquivo de template para exibir cada produto
        'layout' => "<div class='row'>{items}</div>\n{pager}", // Estrutura dos produtos
        'itemOptions' => ['class' => 'col-lg-3 col-md-4 col-sm-6 mb-4'], // Classes dos cartões
    ]); ?>

</div>
