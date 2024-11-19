<?php

use yii\helpers\Html;
use yii\web\JsExpression;

$this->title = 'Relatório de Pizza';
$this->params['breadcrumbs'][] =$this->title;
?>
<h1><?=Html::encode($this->title)?> </h1>

<!-- Canvas para o gráfico -->
<canvas id="myPieChart" width="400" height="400"></canvas>

<script>
    //Dados para o gráfico
    var labels = <?= json_encode($labels) ?>;
    var data = <?= json_encode($data) ?>;

    var ctx = document.getElementById('myPieChart').getContext('2d');
    var myPieChart = new Chart(ctx, {
        type: 'pie', //tipo do gráfico
        data: {
            labels: labels, //rotulos das categorias
            datasets: [{
                label: 'Quantidade de Vinho por Categoria',
                data: data, //Dados de estoque por categoria
                backgroundColor: [
                    '#FF6384',
                    '#36A2EB',
                    '#FFCE56',
                    '#4BC0C0',
                    '#FF5733'
                ],
                hoverOffset:4
            }]
        },
        options;{
            responsive: true,
                plugins:{
                    legend: {
                        position: 'top',
                    },
            tooltip:{
                callbacks:{
                    label: function(tooltipItem) {
                        return tooltipItem.label + ': '+tooltipItem.raw;
                    }
                }
            }
        }
    }
    })
</script>
