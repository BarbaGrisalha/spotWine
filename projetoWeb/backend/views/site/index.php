<?php
/** @var yii\web\View $this */
/** @var array $clientes */

use yii\helpers\Html;
use yii\grid\GridView;
use yii\data\ActiveDataProvider;
use common\models\User;

$this->title = 'SpotWine_Backend';
?>
<div class="site-index">
    <div class="text-center bg-transparent">
        <h1 class="display-4">Backend, Atenção!</h1>
        <p class="lead">You have successfully accessed the backend in your Yii-powered application.</p>
        <h1>Relatórios</h1>
    </div>
        <div class="body-content">
            <?php 
            // Criando o ActiveDataProvider para o GridView
            $dataProvider = new ActiveDataProvider([
                'query' => User::find(),
            ]);

            // Renderizando o GridView
            echo GridView::widget([
                'dataProvider' => $dataProvider,
                'columns' => [
                    'id',
                    'username',
                    'email',
                    [
                        'attribute' => 'Role',
                        'value' => function($model) {
                            $assignment = Yii::$app->authManager->getAssignments($model->id);
                            return $assignment ? array_keys($assignment)[0] : 'Sem Role';
                        },
                    ],
                ],
            ]); 
            ?>
        </div>
  

        <!-- Botão para gerar o Relatório de Clientes -->
        <p><a class="btn btn-lg btn-success" href="#" id="gerarRelatorioClientes">Relatório de Clientes</a></p>
        <br>
        <!-- Relatório de Clientes (inicialmente oculto) -->
        <div id="relatorioClientes" class="report-container" style="display: none;">
            <button id="fecharRelatorio" class="btn btn-danger" style="float: right;">Fechar Relatório</button>
            <h3>Relatório de Clientes</h3>
            <ul>
                <?php foreach ($clientes as $cliente): ?>
                    <li>
                        Nome: <?= Html::encode($cliente->name) ?><br>
                        Email: <?= Html::encode($cliente->email) ?>
                    </li>
                <?php endforeach; ?>

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