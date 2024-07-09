<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DataTables Export Example</title>
    <!-- DataTables CSS -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.css">
    <!-- Buttons extension CSS -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/2.0.1/css/buttons.dataTables.min.css">
</head>
<body>
<button id="exportExcelBtn"> 내보내기</button>
    <table id="example" class="display" style="width:100%">
        <thead>
            <tr>
                <th rowspan="2">종목명</th>
                <th colspan="2">평균수익</th>
                <th colspan="2">년중최대<br>손익</th>
                <th colspan="2">월중최대<br>손익</th>
                <th colspan="2">년초년말<br>최대손익</th>
                <th colspan="2">월초월말<br>최대손익</th>
                <th colspan="2">년연속<br>손익</th>
                <th colspan="2">월연속<br>손익</th>
                <th colspan="2">년누적<br>횟수</th>
                <th colspan="2">월누적<br>횟수</th>
            </tr>
            <tr>
                <th>년</th>
                <th>월</th>
                <th>익</th>
                <th>손</th>
                <th>익</th>
                <th>손</th>
                <th>익</th>
                <th>실</th>
                <th>익</th>
                <th>실</th>
                <th>익</th>
                <th>손</th>
                <th>익</th>
                <th>손</th>
                <th>익</th>
                <th>손</th>
                <th>익</th>
                <th>손</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>종목1</td>
                <td>10%</td>
                <td>5%</td>
                <td>15%</td>
                <td>8%</td>
                <td>12%</td>
                <td>6%</td>
                <td>20%</td>
                <td>10%</td>
                <td>18%</td>
                <td>9%</td>
                <td>22%</td>
                <td>11%</td>
                <td>25%</td>
                <td>13%</td>
                <td>30%</td>
                <td>15%</td>
                <td>35%</td>
                <td>17%</td>
            </tr>
            <!-- 추가 데이터 행들... -->
        </tbody>
    </table>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- DataTables JS -->
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.js"></script>
    <!-- Buttons extension JS -->
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/buttons/2.0.1/js/dataTables.buttons.min.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/buttons/2.0.1/js/buttons.flash.min.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/buttons/2.0.1/js/buttons.html5.min.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/buttons/2.0.1/js/buttons.print.min.js"></script>

    <script>
    $(document).ready(function() {
    // DataTables 초기화
    var table = $('#example').DataTable({
        // DataTables 설정 여기에 추가
    });

    // Excel Export 버튼 클릭 시 이벤트 핸들러
    $('#exportExcelBtn').on('click', function() {
        // DataTables의 데이터 가져오기
        var data = table.data().toArray();

        // 테이블의 헤더 가져오기
        var headerRow1 = $('#example thead tr:eq(0)').children().map(function() {
            return $(this).text().trim();
        }).get();

        var headerRow2 = $('#example thead tr:eq(1)').children().map(function() {
            return $(this).text().trim();
        }).get();

        // Excel용 데이터 배열 생성
        var excelData = [];
        excelData.push(headerRow1.concat(headerRow2)); // 헤더를 한 줄로 합치기

        // 데이터 행 추가
        data.forEach(function(row) {
            excelData.push(row);
        });

        // Excel 파일로 내보내기
        exportToExcel(excelData);
    });

    // Excel 파일로 내보내는 함수
    function exportToExcel(dataArray) {
        var csvContent = "data:text/csv;charset=utf-8,";

        // 데이터 배열을 CSV 포맷으로 변환
        dataArray.forEach(function(rowArray) {
            var row = rowArray.join(",");
            csvContent += row + "\r\n";
        });

        // CSV 데이터를 Blob으로 변환
        var blob = new Blob([csvContent], { type: 'text/csv;charset=utf-8;' });

        // 다운로드 링크 생성 및 클릭
        var link = document.createElement("a");
        if (link.download !== undefined) { // 브라우저가 download 속성을 지원할 경우
            var url = URL.createObjectURL(blob);
            link.setAttribute("href", url);
            link.setAttribute("download", "export.csv");
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
        } else {
            // download 속성을 지원하지 않는 경우, 직접 파일을 열어야 합니다.
            window.open('data:text/csv;charset=utf-8,' + escape(csvContent));
        }
    }
});
    </script>
</body>
</html>
