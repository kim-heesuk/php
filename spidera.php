<?php
print_r($_POST);

$data1 = [2.51, 1.26, -2.45, 0.19];
$labels1 = ["년중최대손익", "월중최대손익", "년중최대손실", "월중최대손실"];

$data2 = [100, 33.33, 0, -66.67];
$labels2 = ["년승률", "월승률", "년손실율", "월손실율"];

$data3 = [20.74, 12.25, -40.81, -18.38];
$labels3 = ["년수익", "월수익", "년손실", "월손실"];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>스파이더 그래프</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        .chart-container {
            width: 30%;
            height: 400px;
            display: inline-block;
            margin: 1%;
        }
        canvas {
            width: 100% !important;
            height: 100% !important;
        }
    </style>
</head>
<body>
    <div class="chart-container">
        <canvas id="spiderChart1"></canvas>
    </div>
    <div class="chart-container">
        <canvas id="spiderChart2"></canvas>
    </div>
    <div class="chart-container">
        <canvas id="spiderChart3"></canvas>
    </div>
    <script>
        const data1 = {
            labels: <?php echo json_encode($labels1); ?>,
            datasets: [{
                label: 'Financial Metrics 1',
                data: <?php echo json_encode($data1); ?>,
                fill: true,
                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                borderColor: 'rgb(54, 162, 235)',
                pointBackgroundColor: 'rgb(54, 162, 235)',
                pointBorderColor: '#fff',
                pointHoverBackgroundColor: '#fff',
                pointHoverBorderColor: 'rgb(54, 162, 235)'
            }]
        };

        const data2 = {
            labels: <?php echo json_encode($labels2); ?>,
            datasets: [{
                label: 'Financial Metrics 2',
                data: <?php echo json_encode($data2); ?>,
                fill: true,
                backgroundColor: 'rgba(255, 99, 132, 0.2)',
                borderColor: 'rgb(255, 99, 132)',
                pointBackgroundColor: 'rgb(255, 99, 132)',
                pointBorderColor: '#fff',
                pointHoverBackgroundColor: '#fff',
                pointHoverBorderColor: 'rgb(255, 99, 132)'
            }]
        };

        const data3 = {
            labels: <?php echo json_encode($labels3); ?>,
            datasets: [{
                label: 'Financial Metrics 3',
                data: <?php echo json_encode($data3); ?>,
                fill: true,
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                borderColor: 'rgb(75, 192, 192)',
                pointBackgroundColor: 'rgb(75, 192, 192)',
                pointBorderColor: '#fff',
                pointHoverBackgroundColor: '#fff',
                pointHoverBorderColor: 'rgb(75, 192, 192)'
            }]
        };

        const config1 = {
            type: 'radar',
            data: data1,
            options: {
                scales: {
                    r: {
                        angleLines: {
                            display: true
                        },
                        suggestedMin: -50,
                        suggestedMax: 50
                    }
                }
            }
        };

        const config2 = {
            type: 'radar',
            data: data2,
            options: {
                scales: {
                    r: {
                        angleLines: {
                            display: true
                        },
                        suggestedMin: -100,
                        suggestedMax: 100
                    }
                }
            }
        };

        const config3 = {
            type: 'radar',
            data: data3,
            options: {
                scales: {
                    r: {
                        angleLines: {
                            display: true
                        },
                        suggestedMin: -50,
                        suggestedMax: 50
                    }
                }
            }
        };

        const spiderChart1 = new Chart(
            document.getElementById('spiderChart1'),
            config1
        );

        const spiderChart2 = new Chart(
            document.getElementById('spiderChart2'),
            config2
        );

        const spiderChart3 = new Chart(
            document.getElementById('spiderChart3'),
            config3
        );
    </script>
</body>
</html>
