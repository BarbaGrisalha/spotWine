<?php
/** @var yii\web\View $this */
/** @var backend\models\Users $produtor */
/** @var array $categorias */

use yii\helpers\Html;

?>
<div class="relatorio-produtor">
    <h1><?= Html::encode($this->title)?></h1>
    <p><strong> Produtor11:</strong><?=Html::encode($produtor->username) ?></p>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Categoria</th>
                <th>Total de Produtos</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($categorias as $categoria):?>
                <tr>
                    <td><?= Html::encode($categoria['category_name']) ?></td>
                    <td><?= Html::encode($categoria['total_stock']) ?></td>
                </tr>
            <?php endforeach;?>
        </tbody>
    </table>
</div>

