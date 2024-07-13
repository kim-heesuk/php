<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chart.js Example</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <div id="chartContainer">
        <canvas id="myChart" style="height: 300px;"></canvas>
    </div>
    <script>
        let myChart; // 전역 변수로 차트 객체를 저장
bar_line_draw(
          [12, 19, 3, 5, 2, 3], // bar data
          [2, 3, 20, 5, 1, 4], // line data
          ['Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange'], // labels
          'Bar Dataset', // bar title
          'Line Dataset' // line title
        );
        function bar_line_draw(barData, lineData, labels, barTitle, lineTitle) {
          const chartContainer = document.getElementById('chartContainer');
          const oldCanvas = document.getElementById('myChart');

          // 기존 canvas 요소를 삭제
          if (oldCanvas) {
            chartContainer.removeChild(oldCanvas);
          }

          // 새로운 canvas 요소를 생성하고 추가
          const newCanvas = document.createElement('canvas');
          newCanvas.id = 'myChart';
          newCanvas.style.height = '300px';
          chartContainer.appendChild(newCanvas);

          const ctx = newCanvas.getContext('2d');

          // 새로운 혼합 차트를 생성
          myChart = new Chart(ctx, {
            type: 'bar',
            data: {
              labels: labels,
              datasets: [
                {
                  type: 'bar',
                  label: barTitle,
                  data: barData,
                  yAxisID: 'y',
                  backgroundColor: 'rgba(75, 192, 192, 0.2)',
                  borderColor: 'rgba(75, 192, 192, 1)',
                  borderWidth: 1
                },
                {
                  type: 'line',
                  label: lineTitle,
                  data: lineData,
                  yAxisID: 'y1',
                  backgroundColor: 'rgba(153, 102, 255, 0.2)',
                  borderColor: 'rgba(153, 102, 255, 1)',
                  borderWidth: 1,
                  fill: false
                }
              ]
            },
            options: {
              scales: {
                y: {
                  type: 'linear',
                  display: true,
                  position: 'left',
                  beginAtZero: true
                },
                y1: {
                  type: 'linear',
                  display: true,
                  position: 'right',
                  beginAtZero: true,
                  grid: {
                    drawOnChartArea: false // 오른쪽 y축의 그리드 라인을 그리지 않음
                  }
                }
              }
            }
          });
        }

        // 초기 차트를 그림
        

        
    </script>
</body>
</html>
