<?php

use yii\data\ActiveDataProvider;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\grid\GridView;
use yii\widgets\LinkPager;

/** @var yii\web\View $this */
/** @var common\models\ProductSearch $model */
/** @var common\models\User $produtor */
/** @var yii\widgets\ActiveForm $form */

$this->title = 'Gestão de Produtos13';// canto superior direito
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="product-management">
    <h1><?= Html::encode($this->title = 'Gestão de Produtos12') ?></h1>

    <?php
    // Buscando se corrente ID está logado corretamente
    $currentUserId = Yii::$app->user->isGuest ? null : Yii::$app->user->id;


    // Configurando o DataProvider com paginação e filtro pelo usuário autenticado
    $query = \common\models\Product::find();//linha 28

    // Apply filter for signed-in user
    if ($currentUserId !== null) {
<<<<<<< Updated upstream
        $query->joinWith('producers') // Ensure the relationship is loaded
        ->andWhere(['producer_details.user_id' => $currentUserId]);
=======
        $query->joinWith('producers') // alterei de producers para producerDetails
        ->andWhere(['producer_details.id' => $currentUserId])//mudei de user_id para id deu me erro.
        ->all();
        //dd($currentUserId);
>>>>>>> Stashed changes
    }
    $dataProvider = new ActiveDataProvider([
        'query' => $query,
        'pagination' => [
            'pageSize' => 5, // Altere aqui para o número máximo de itens por página
        ],
    ]);

    //verifica se não há produtos para o produtor
    if($dataProvider->getTotalCount() == 0 ) {
        //exibe uma mensagem se não houver produtos
        Yii::$app->session->setFlash('info','Não foram encontrados produtos para o produtor logado');
    }
     ?>
    <!-- Exibe a mensagem, se existir-->
    <?php
        if(Yii::$app->session->hasFlash('info')): ?>
            <div class="alert alert-info">
                <?= Yii::$app->session->getFlash('info')?>
            </div>

    <?php endif; ?>


    <?php
    // Busca todos os produtores com a relação para 'user' carregada
    $producers = \common\models\ProducerDetails::find()
        ->joinWith('user') // Carrega dados da tabela 'user'
        ->all();
    // Transforma os dados dos produtores em um array de chave-valor para o dropDownList
    $producerItems = \yii\helpers\ArrayHelper::map(
        $producers,
        'id', // ID do produtor como chave
        function ($model) {
            // Combinação do nome do usuário e do nome da vinícola como valor
            return $model->user->username . ' - ' . ($model->winery_name ?? 'Sem Vinícola');
        }
    );
    ?>
</div>