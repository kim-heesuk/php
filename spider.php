<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Spider Graph</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>

  <style>
        .chart-container {
            width: 30%; /* 각 차트의 너비를 조정할 수 있습니다. */
            height: 400px;
            display: inline-block; /* 가로로 정렬하기 위한 display 속성 */
            margin: 10px; /* 각 차트 사이의 간격을 조정할 수 있습니다. */
            vertical-align: top; /* 상단 정렬 */
        }
        canvas {
            width: 100% !important;
            height: 100% !important;
        }
    </style>
	<div id="title">  </div>
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
	
	
        window.addEventListener('message', function(event) {
			const titleElement = document.getElementById("title");
            var data = JSON.parse(event.data);
			var name=data[0];
			var yearavg=data[3];
			var monavg=data[4];
			titleElement.textContent = name +"연평균수익율("+yearavg+") 월평균수익율("+monavg+")";
			var yearwinratio=data[1]
			var yearlossratio=data[1]-100;
			var monwinratio=data[2]
			var monlossratio=data[2]-100;
			var data1=[yearwinratio,monwinratio,yearlossratio,monlossratio];
			var data1maxValue = Math.max(data1) +1;
			var data1minValue = Math.min(data1) -1;
			var data1label=['년평균승률','월평균승률','년평균실패율','월평균실패율'];
			
			var yeargainratio=data[5];
			var yearloseratio=data[6];
			var mongainratio=data[7];
			var monloseratio=data[8];
			var data2=[yeargainratio,mongainratio,yearloseratio,monloseratio];
			var data2maxValue = Math.max(data2) +1;
			var data2minValue = Math.min(data2) -1;
			var data2label=['년최대수익율','월최대수익율','년최대손실율','월최대손실율'];
			
			var yearstartendgainratio=data[9];
			var yearstartendloseratio=data[10];
			var monstartendgainratio=data[11];
			var monstartendloseratio=data[12];
			
			var data3=[yeargainratio,mongainratio,yearloseratio,monloseratio];
			var data3maxValue = Math.max(data3) +1;
			var data3minValue = Math.min(data3) -1;
			var data3label=['1년최대수익율','1개월최대수익율','1년최대손실율','1개월최대손실율'];
			
			
			const sdata1 = {
    labels: data1label,
    datasets: [{
        label: ' 승패율',
        data: data1,
        fill: true,
        backgroundColor: 'rgba(54, 162, 235, 0.2)',
        borderColor: 'rgb(54, 162, 235)',
        pointBackgroundColor: 'rgb(54, 162, 235)',
        pointBorderColor: '#fff',
        pointHoverBackgroundColor: '#fff',
        pointHoverBorderColor: 'rgb(54, 162, 235)'
    }]
};

const sdata2 = {
    labels: data2label,
    datasets: [{
        label: '최대 수익손실',
        data: data2,
        fill: true,
        backgroundColor: 'rgba(255, 99, 132, 0.2)',
        borderColor: 'rgb(255, 99, 132)',
        pointBackgroundColor: 'rgb(255, 99, 132)',
        pointBorderColor: '#fff',
        pointHoverBackgroundColor: '#fff',
        pointHoverBorderColor: 'rgb(255, 99, 132)'
    }]
};

const sdata3 = {
    labels: data3label,
    datasets: [{
        label: '년초대비년말, 월초대비월말 수익율',
        data: data3,
        fill: true,
        backgroundColor: 'rgba(153, 102, 255, 0.2)', // 보라색 계열
        borderColor: 'rgb(153, 102, 255)',
        pointBackgroundColor: 'rgb(153, 102, 255)',
        pointBorderColor: '#fff',
        pointHoverBackgroundColor: '#fff',
        pointHoverBorderColor: 'rgb(153, 102, 255)'
    }]
};
			
			
			const config1 = {
            type: 'radar',
            data: sdata1,
            options: {
                scales: {
                    r: {
                        angleLines: {
                            display: true
                        },
                        suggestedMin: data1minValue,
                        suggestedMax: data1maxValue
                    }
                }
            }
		};
		
			
			const config2 = {
            type: 'radar',
            data: sdata2,
            options: {
                scales: {
                    r: {
                        angleLines: {
                            display: true
                        },
                        suggestedMin: data2minValue,
                        suggestedMax: data2maxValue
                    }
                }
            }
        };
		
		
		const config3 = {
            type: 'radar',
            data: sdata3,
            options: {
                scales: {
                    r: {
                        angleLines: {
                            display: true
                        },
                        suggestedMin: data3minValue,
                        suggestedMax: data3maxValue
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
		
		   
		   
		   
		   
		   
        });
    </script>
</body>
</html>
