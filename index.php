<?php
include "./head.php";
include "./sidebar.php";
$visit_date = date('Y-m-d');
$cookie_name = "visited";
$cookie_value = "yes";
$cookie_expiration = time() + (3600); // 하루 동안 쿠키 유지
// 쿠키가 설정되지 않은 경우 처음 방문자로 간주
if (!isset($_COOKIE[$cookie_name])) {
    setcookie($cookie_name, $cookie_value, $cookie_expiration, "/"); // 쿠키 설정
    $is_first_visit = true;
} else {
    $is_first_visit = false;
}
echo $is_first_visit ."</br>";

?>

<style>
.modal {
display: none; /* Hidden by default */
position: fixed; /* Stay in place */
z-index: 1; /* Sit on top */
left: 0;
top: 0;
width: 100%; /* Full width */
height: 100%; /* Full height */
overflow: auto; /* Enable scroll if needed */
background-color: rgba(0,0,0,0.4); /* Black with opacity */
}

/* Modal Content */
.modal-content {
    background-color: #fefefe;
    margin: 15% auto; /* 15% from the top and centered */
    padding: 20px;
    border: 1px solid #888;
    width: 60%; /* Could be more or less, depending on screen size */
    position: relative; /* Make position relative for absolute positioning of close button */
}

/* Close Button */
.close {
    position: absolute;
    top: 10px;
    right: 15px;
    color: #aaa;
    font-size: 28px;
    font-weight: bold;
    cursor: pointer;
}

.close:hover,
.close:focus {
    color: black;
    text-decoration: none;
}
    </style>

  <!-- /.navbar -->


  
  <!-----------======================
    <!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">


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
<div id="myModal" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <p> 본 주소는 cloudtype 의 프리티어 등급으로 관리 중으로 매일1회 중지 됩니다 </p>
		<p> https://sites.google.com/view/etftrader 주소를 통해서 입장을 권고하며,</p>
		<p> 운영목적 : 국내 상장된 ETF 분석을 통해 누구나 안정적인 투자를 이어가길 바라는 마음에서 싸이트을 운영합니다.</p>
		<p> 문의 : Contact를 누르고 문의하세요 </p>
    </div>
</div>
<!-- Content Wrapper. Contains page content -->
  
<?php
include "./footer.php";
?>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>

$(document).ready(function(e){ 
let myChart; // 전역 변수로 차트 객체를 저장
$('[data-widget="pushmenu"]').PushMenu('toggle');
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
	
	
  

/*
var modal = document.getElementById("myModal");
var span = document.getElementsByClassName("close")[0];
// Show the modal
modal.style.display = "block";
  */
	
	
  
  document.addEventListener("DOMContentLoaded", function() {
    <?php if ($is_first_visit): ?>
    var modal = document.getElementById("myModal");
    var span = document.getElementsByClassName("close")[0];

    // Show the modal
    modal.style.display = "block";

    // Close the modal when the user clicks on <span> (x)
    span.onclick = function() {
        modal.style.display = "none";
    }

    // Close the modal when the user clicks anywhere outside of the modal
    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }
    <?php endif; ?>
});
  
  
  
});

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

</body>
</html>