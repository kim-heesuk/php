<?php
session_set_cookie_params(3600 *24); // 24 hour
session_start(); // 세션 시작
include "./head.php";
include "./sidebar.php";
$visit_date = date('Y-m-d');
if (count($_SESSION)==0){
$_SESSION['first_visit']=0;
}
?>

<!-----------======================
<!-- Content Wrapper. Contains page content -->

<div class="content-wrapper">
 <div class="modal fade" id="modal-primary">
        <div class="modal-dialog">
          <div class="modal-content bg-primary">
            <div class="modal-header">
              <!-- <h4 class="modal-title">공지사항</h4> !-->
			  <h4 class="modal-title text-center">공지사항</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
			<p> cloudtype의 프리티어 등급으로 관리 중 <font color='red'> (매일1회 중지됨)</font></p>
			<p> 고정URL : <font color='red'> https://sites.google.com/view/etftrader </font> </p>
			<p> 운영목적 : 국내 상장된 ETF 분석을 통해 누구나 안정적인 투자를</p>
			<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;이어가길 바라는 마음에서 싸이트을 운영합니다.</p>
			<p> 문의사항 : 상단 <font color='red'>질문</font>를 누르고 문의하세요 </p>
            </div>
			
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
	

	
        <!-- Main row -->
        <div class="row">
          <!-- Left col -->
          <section class="col-lg-7 connectedSortable">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">분배금(배당금) 지급현황</h3>
              </div>
              <div class="card-body">
                <table id="divtable" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>종목명</th>
                    <th>년도</th>
                    <th>분배금</th>
                    <th>시가대비</th>
                    <th>건수</th>
                  </tr>
                  </thead>
				  <tbody>
				  </tbody>
				  
                </table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
		  </section>
		  
		  <!-------------------------!>
		   <section class="col-lg-5 connectedSortable">
            <div class="card card-primary card-outline">
              <div class="card-header">
                <h3 class="card-title">
                  <i class="far fa-chart-bar"></i>
                 년도별 분배금 지급현황
                </h3>

                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                  <button type="button" class="btn btn-tool" data-card-widget="remove">
                    <i class="fas fa-times"></i>
                  </button>
                </div>
              </div>
              <div class="card-body">
			  <div id="chartContainer">
					<canvas id="myChart" style="height: 300px;"></canvas>
				</div>
	
                <!-- <div id="bar-chart" style="height: 300px;"></div> !-->
				 <!-- <canvas id="myChart" style="height: 300px;"></canvas> !-->
              </div>
              <!-- /.card-body-->
            </div>
            <!-- /.card -->
			<div class="row">
			<div class="card">
			  <div class="card-body">
                <table id="divtabledetail" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>지급일</th>
                    <th>분배금</th>
                    <th>시가대비</th>
                    <th>구분</th>
                    <th>기준가</th>
                  </tr>
                  </thead>
				  <tbody>
				  </tbody>
				  
                </table>
              </div>
			  
			  
			  
			  
			  </div>
			
			</div>
		  </section>
		  
		</div>
		
		</div>
		</section>
</div>
				
<?php
include "./footer.php";
?>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>

$(document).ready(function(e){
var is_first_visit = <?php echo json_encode($_SESSION); ?>;
if (is_first_visit['first_visit']==0){
$('#modal-primary').modal('show');
<?php $_SESSION['first_visit']=1; ?>
}
let myChart; // 전역 변수로 차트 객체를 저장
$('[data-widget="pushmenu"]').PushMenu('collapse');
	 var result=DivinfoReq();
	 appendDataToTable(result['line']);
     var divtable=$('#divtable').DataTable({
      "responsive": true, 
	  "lengthChange": false, 
	  "autoWidth": false,
	  "info": true,
      "buttons": ["excel"],
    });
	
$('#divtable tbody').on('click', 'tr', function () {
	var data = divtable.row(this).data();
	  var title=data[0];
	  var Htitle=JSHTMLescape(data[0]);
	  if ('graph' in result){
	  labels=Object.keys(result['graph'][Htitle]);
	  }
	  const barData=[];
	  const lineData=[];
	  const barTitle="분배금";
	  const lineTitle="분배율";
	  
	  
	  
	  if ('graph' in result){
	  for (const key in result['graph'][Htitle]) {
		barData.push(result['graph'][Htitle][key]['div']);
		lineData.push(result['graph'][Htitle][key]['rate']);
	  }
	  // 차트그리기 
	  bar_line_draw(barData, lineData, labels, barTitle, lineTitle);
	  }
	
	
		var divdetail=DivinfoDetail(Htitle);
		appendDataToTableDetail(divdetail);
		
		if ($.fn.DataTable.isDataTable('#divtabledetail')) {
			divtabledetail.clear();
			var divtabledetail=$('#divtabledetail').DataTable({
			  "responsive": true, 
			  "lengthChange": false, 
			  "autoWidth": false,
			  "info": true,
			  "searching": false,
			  //"buttons": ["excel"],
			});
		
		} else {
			$('#divtabledetail').DataTable({
			});
		}
		
	});
	

});
  
 
  
//});


	
function JSHTMLescape(str) {
	if (!str) return '';
	return str
		.replace('&amp;',"&")
		.replace( '&lt;',"<")
		.replace('&gt;',">")
		.replace('&quot;','"')
		.replace('&#039;',"'");
}

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


function DivinfoReq(){
	var result;
	$.ajax({
		url: "AjaxHtml/Receiver.php",
		type: "POST",
		data: JSON.stringify({ "request": "divinfo"}),
		contentType: "application/json; charset=utf-8",
		async: false, // 동기식 호출
		success: function(redata){
			result=redata;
			console.log(result);
			
		},
		error: function(xhr, status, error){
		console.log(status,error);
			$("#result").html("An error occurred: " + error);
		},
		complete : function(xhr, status) {
		
		},
	});
return result;	
}


function DivinfoDetail(title){
	var result;
	$.ajax({
		url: "AjaxHtml/Receiver.php",
		type: "POST",
		data: JSON.stringify({ "request": "divinfodetail", "name": title}),
		contentType: "application/json; charset=utf-8",
		async: false, // 동기식 호출
		success: function(redata){
			result=redata;
			console.log(result);
			
		},
		error: function(xhr, status, error){
		console.log(status,error);
			$("#result").html("An error occurred: " + error);
		},
		complete : function(xhr, status) {
		
		},
	});
return result;	
}

function appendDataToTable(data) {
	console.log("Received data:", data);
	var divtable = $('#divtable tbody');
	data.forEach(function(row) {
		var newRow = '<tr>' +
			'<td>' + row[0] + '</td>' +
			'<td>' + row[1] + '</td>' +
			'<td>' + row[2].toLocaleString() + '</td>' +
			'<td>' + row[3] + '</td>' +
			'<td>' + row[4] + '</td>' +
			'</tr>';
		divtable.append(newRow);
	});
}


function appendDataToTableDetail(data) {
	console.log("Received data:", data);
	var divtable = $('#divtabledetail tbody');
	divtable.empty();
	data.forEach(function(row) {
		var newRow = '<tr>' +
			'<td>' + row[0].toLocaleString() + '</td>' +
			'<td>' + row[1] + '</td>' +
			'<td>' + row[2] +'</td>' +
			'<td>' + row[3] + '</td>' +
			'<td>' + row[4].toLocaleString() + '</td>' +
			'</tr>';
		divtable.append(newRow);
	});
}
		

</script>
<?

?>
</body>
</html>