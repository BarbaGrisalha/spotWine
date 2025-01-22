<?php
/** @var yii\web\View $this */

/** @var yii\web\View $this */
/** @var \common\models\User $searchModel */// \common\models\UserSearch $searchModel
/** @var yii\data\ActiveDataProvider $dataProvider */



$this->title = 'Dashboard';
?>
<div class="site-index">
    <div class="text-center bg-transparent">
        <?= $this->render('@backend/views/relatorio/chart', [
            'id' => $produtor->user_id,
            'produtor' => $produtor,
            'categorias' => $categorias,
        ]) ?>
    </div>


