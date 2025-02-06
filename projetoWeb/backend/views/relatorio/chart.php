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

        <h4> Estoque por categoria:</h4>
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

// Definindo as cores para as categorias específicas
$cores = [
    'Vinho Tinto' => '#8b0000',
    'Vinho Branco' => '#f3e5ab',
    'Vinho Rose' => '#ffc0cb',
];

// Gerar o array de cores para as categorias
$backgroundColors = [];
foreach ($categorias as $categoria) {
    $nomeCategoria = $categoria['category_name'];
    $backgroundColors[] = $cores[$nomeCategoria] ?? 'rgba(75, 192, 192, 0.2)'; // Cor padrão se não for encontrada
}
$backgroundColorsJson = json_encode($backgroundColors);

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
                backgroundColor: $backgroundColorsJson,
                borderColor: $backgroundColorsJson,
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
