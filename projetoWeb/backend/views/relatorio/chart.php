<?php
/** @var yii\web\View $this */
/** @var backend\models\Users $produtor */
/** @var array $categorias */

use yii\helpers\Html;

//$this->title = "Relatório de Produtos por Produtor - {$produtor->username}";
$this->registerJsFile('https://cdn.jsdelivr.net/npm/chart.js',
    ['depends' => [\yii\web\JqueryAsset::class]]);

?>
    <div class="relatorio-produtor">
        <h1><?= Html::encode($this->title)?></h1>
        <p><strong> Produtor:</strong> <?= Html::encode($produtor->username) ?></p>

        <!-- Tabela de dados -->
        <table class="table table-bordered">
            <thead>
            <tr>
                <th>Categoria</th>
                <th>Total de Produtos</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($categorias as $categoria): ?>
                <tr>
                    <td><?= Html::encode($categoria['category_name']) ?></td>
                    <td><?= Html::encode($categoria['total_stock']) ?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>

        <!-- Gráfico de Pizza -->
        <div style="width:300px; height:300px; margin:auto;">
            <canvas id="chartPizza"></canvas>
        </div>

    </div>

<?php
// Preparando os dados para o gráfico
$labels = json_encode(array_column($categorias, 'category_name'));
$data = json_encode(array_column($categorias, 'total_stock'));

// Script para gerar o gráfico de pizza
$js = <<<JS
    const ctx = document.getElementById('chartPizza').getContext('2d');
    const chartPizza = new Chart(ctx, {
        type: 'pie',
        data: {
            labels: $labels,
            datasets: [{
                label: 'Produtos por Categoria',
                data: $data,
                backgroundColor: [
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(255, 206, 86, 0.2)',
                    'rgba(75, 192, 192, 0.2)',
                    'rgba(153, 102, 255, 0.2)',
                    'rgba(255, 159, 64, 0.2)'
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)',
                    'rgba(255, 159, 64, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'top',
                },
                tooltip: {
                    enabled: true
                }
            }
        }
    });
JS;
$this->registerJs($js);
?>