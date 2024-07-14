<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chart.js Line Graphs</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.1/chart.min.css">
</head>
<body>
    <section class="col-lg-7 connectedSortable">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">비교보기</h3>
            </div>
            <div class="card-body">
                <canvas id="lineChart"></canvas>
            </div>
        </div>
    </section>
    <table id="corrtable" class="display" style="width:100%">
        <thead>
            <tr>
                <th>Name</th>
                <th>Position</th>
                <th>Office</th>
                <th>Age</th>
                <th>Start date</th>
                <th>Salary</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Tiger Nixon</td>
                <td>System Architect</td>
                <td>Edinburgh</td>
                <td>61</td>
                <td>2011/04/25</td>
                <td>$320,800</td>
            </tr>
            <!-- 추가 행들 -->
        </tbody>
    </table>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.1.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.1.1/js/buttons.html5.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="chart-config.js"></script> <!-- 아래 JS 코드를 여기서 불러올 수 있습니다 -->
</body>
</html>



<script>
let chart;

function DrawTwoLine(data1, data2) {
    const ctx = document.getElementById('lineChart').getContext('2d');
    const createDataset = (data, label, color1, color2) => {
        const dataSegment1 = data.slice(0, 75);
        const dataSegment2 = data.slice(75);
        if (label == "분석일") {
            return [
                {
                    label: `${label} (0-74) 현재까지`,
                    data: dataSegment1.concat(Array(15).fill(null)),
                    borderColor: color1,
                    backgroundColor: color1,
                    fill: false,
                },
                {
                    label: `${label} 분석후`,
                    data: Array(75).fill(null).concat(dataSegment2),
                    borderColor: color2,
                    backgroundColor: color2,
                    fill: false,
                }
            ];
        } else {
            return [
                {
                    label: `${label} (0-74)`,
                    data: dataSegment1.concat(Array(15).fill(null)),
                    borderColor: color1,
                    backgroundColor: color1,
                    fill: false,
                },
                {
                    label: `${label} (75-90)`,
                    data: Array(75).fill(null).concat(dataSegment2),
                    borderColor: color2,
                    backgroundColor: color2,
                    fill: false,
                }
            ];
        }
    };

    const datasets = [
        ...createDataset(data1, '유사일', 'rgba(75, 192, 192, 1)', 'rgba(255, 99, 132, 1)'),
        ...createDataset(data2, '분석일', 'rgba(54, 162, 235, 1)', 'rgba(255, 206, 86, 1)')
    ];

    const config = {
        type: 'line',
        data: {
            labels: Array.from({length: 90}, (_, i) => i),
            datasets: datasets,
        },
        options: {
            responsive: true,
            scales: {
                x: {
                    display: true,
                    title: {
                        display: true,
                    },
                },
                y: {
                    display: true,
                    title: {
                        display: true,
                        text: '가격',
                    },
                },
            },
        },
    };

    if (chart) {
        chart.destroy();
    }

    chart = new Chart(ctx, config);
}

$(document).ready(function() {
    var table = $('#corrtable').DataTable({
        dom: 'Bfrtip',
        buttons: ['excel'],
        "columnDefs": [
            {
                "targets": [3], // 숨길 열의 인덱스 (0부터 시작)
                "visible": false
            }
        ]
    });

    $('#corrtable tbody').on('click', 'tr', function() {
        var rowData = table.row(this).data();
        var textData = [];

        $(this).find('td').each(function(index) {
            // 숨김 열도 포함하여 데이터 가져오기
            textData.push(rowData[index]);
        });

        // 예제 데이터로 그래프 업데이트 (실제 데이터로 교체해야 함)
        const data1 = Array.from({length: 90}, () => Math.floor(Math.random() * 100));
        const data2 = Array.from({length: 90}, () => Math.floor(Math.random() * 100));

        DrawTwoLine(data1, data2);
    });

    // 초기 그래프 그리기
    const initialData1 = Array.from({length: 90}, () => Math.floor(Math.random() * 100));
    const initialData2 = Array.from({length: 80}, () => Math.floor(Math.random() * 100));
    DrawTwoLine(initialData1, initialData2);
});

</script>