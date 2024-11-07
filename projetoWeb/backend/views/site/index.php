<?php
/** @var yii\web\View $this */
/** @var array $clientes */

use yii\helpers\Html;

$this->title = 'SpotWine_Backend';
?>
<div class="site-index">
    <div class="jumbotron text-center bg-transparent">
        <h1 class="display-4">Backend, Atenção!</h1>
        <p class="lead">You have successfully accessed the backend in your Yii-powered application.</p>
        <h1>Relatórios</h1>

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
            </ul>
        </div>

        <div class="site-relatorio-produtores">
            <div class="reportcontainer" style="display: none;" id="relatorioProdutores">
                <button id="fecharRelatorioProdutores" class="btn btn-danger" style="float: right;">Fechar Relatório</button>
                <h3>Relatório de Produtores</h3>

                <ul>
                    <?php foreach ($produtores as $produtor): ?>
                        <li>
                            Nome da Vinícola: <?= Html::encode($produtor->winery_name) ?><br>
                            Localização: <?= Html::encode($produtor->location) ?><br>
                            ID do Documento: <?= Html::encode($produtor->document_id) ?><br>
                            ID do Produtor: <?= Html::encode($produtor->producer_id) ?><br>
                            ID do Usuário: <?= Html::encode($produtor->user_id) ?><br>
                        </li>
                    <?php endforeach; ?>
                    <script>
                        function mostrarRelatorioProdutores() {
                            // Exibe o relatório de produtores
                            document.getElementById('relatorioProdutores').style.display = 'block';
                        }

                        document.getElementById('fecharRelatorioProdutores').addEventListener('click', function() {
                            // Fecha o relatório de produtores
                            document.getElementById('relatorioProdutores').style.display = 'none';
                        });
                    </script>

                </ul>
            </div>

            <p><a class="btn btn-lg btn-success" href="javascript:void(0);" onclick="mostrarRelatorioProdutores()">Gerar Relatório de Produtores</a></p>
        </div>

        <!-- Botões para outros relatórios (futuramente) -->
        <p><a class="btn btn-lg btn-success" href="#">Relatório de Produtos</a></p>
    </div>
</div>