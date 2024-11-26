<?php
/** @var yii\web\View $this */

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\data\ActiveDataProvider;
use common\models\User;
use common\models\UserDetails;

/** @var yii\web\View $this */
/** @var common\models\UserSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'SpotWine_Backend';
?>
<div class="site-index">
    <div class="text-center bg-transparent">
        <h1 class="display-4">Gestão de Utilizadores</h1>
    </div>
    <div class="body-content">
        <p>
            <?= Html::a('Create User', ['user/create'], ['class' => 'btn btn-success']) ?>
        </p>

        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                'id',
                'username',
                'email',

                // Colunas de `user_details`
                [
                    'attribute' => 'userDetails.nif',

                    'value' => 'userDetails.nif', // Use o caminho direto da relação
                ],

                [
                    'attribute' => 'phone_number',
                    'value' => function ($model) {
                        return $model->userDetails->phone_number ?? 'N/A';
                    },
                    'filter' => Html::activeInput('text', $searchModel, 'phone_number', ['class' => 'form-control']),
                ],

                ['class' => ActionColumn::class],
            ],
        ]); ?>
    </div>


    <!-- Botão para gerar o Relatório de Clientes -->
    <p><a class="btn btn-lg btn-success" href="#" id="gerarRelatorioClientes">Relatório de Clientes</a></p>
    <br>
    <!-- Relatório de Clientes (inicialmente oculto) -->
    <div id="relatorioClientes" class="report-container" style="display: none;">
        <button id="fecharRelatorio" class="btn btn-danger" style="float: right;">Fechar Relatório</button>
        <h3>Relatório de Clientes</h3>
        <ul>
            <?#php foreach ($clientes as $cliente): ?>
            <li>
                Nome: <?#= Html::encode($cliente->name) ?><br>
                Email: <?#= Html::encode($cliente->email) ?>
            </li>
            <?#php endforeach; ?>

            <!--
            <script>
                // Em uma tag <script> ou arquivo JS externo
                document.getElementById('gerarRelatorioClientes').addEventListener('click', function(event) {
                    event.preventDefault(); // Impede a ação padrão do link
                    document.getElementById('relatorioClientes').style.display = 'block'; // Exibe a div do relatório
                });

                document.getElementById('fecharRelatorio').addEventListener('click', function(event) {
                    document.getElementById('relatorioClientes').style.display = 'none'; // Oculta a div do relatório
                });
            </script>
            -->
        </ul>
    </div>



    <!-- Botões para outros relatórios (futuramente) -->
    <p><a class="btn btn-lg btn-success" href="<?= \yii\helpers\Url::to(['relatorio/relatorio-produtos']) ?>">Relatório de Produtos</a></p>
</div>

</div>