<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ListView;

/* @var $this yii\web\View */
/* @var $favorites common\models\Favorites[] */

$this->title = 'Meus Favoritos';
$this->params['breadcrumbs'][] = $this->title;
?>
<?= ListView::widget([
    'dataProvider' => $dataProvider,
    'itemView' => '/product/_product', // Arquivo de template para exibir cada produto
    'viewParams' => [
        'cartItemModel' => $cartItemModel, // Passa o modelo do carrinho para cada item
    ],
    'layout' => "<div class='row'>{items}</div>\n{pager}", // Estrutura dos produtos
    'itemOptions' => ['class' => 'col-lg-3 col-md-4 col-sm-6 mb-4'], // Classes dos cartões

]); ?>


