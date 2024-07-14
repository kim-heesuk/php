<?php
include "./head.php";
include "./sidebar.php";
?>



  <!-- /.navbar -->

<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/buttons/2.0.1/js/buttons.flash.min.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/buttons/2.0.1/js/buttons.html5.min.js"></script>

  
  <!-----------======================
    <!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">


    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
		<div class="row">
		  <section class="col-lg-5 connectedSortable">
			<div class="card">
              <div class="card-header">
                <h3 id="card_title" class="card-title">상관도 분석</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
				<table id="corrtable" class="display" style="width:100%">
				  <thead>
                  <tr>
                    <th>종목명</th>
					<th>유사일</th>
					<th>상관도</th>
                  </tr>
                  </thead>
				  <tbody>
				 
				  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
            </div>
		  </section>
		  
		  
		   <section class="col-lg-7 connectedSortable">
			<div class="card">
              <div class="card-header">
                <h3 class="card-title">비교보기</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <canvas id="lineChart"></canvas>
			  </div>
              <!-- /.card-body -->
            </div>
		  </section>
		  
         
         
		</div>
		
		
		
		
		
		
		</div>
		</section>

</div>
<!-- Content Wrapper. Contains page content -->
  
<?php
include "./footer.php";
?>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<!-- <script src="chart-config.js"></script> !--><!-- 아래 JS 코드를 여기서 불러올 수 있습니다 -->

<script>
let chart;
let tempdata={}
$(document).ready(function(e){ 
$('[data-widget="pushmenu"]').PushMenu('collapse');


var textData = [];
	var data=CorrinfoReq();
	appendDataToTable(data);	
	var table=$('#corrtable').DataTable({
				dom: 'Bfrtip',
				buttons: ['excel'],
			});
	
	$('#corrtable tbody').on('click', 'tr', function() {
	var rowData = table.row(this).data();
	 $(this).find('td').each(function(index) {
        });
	 
	 var rcode=tempdata[rowData[0]];
	 var oldstartday=data[rcode][3];
	 var curstartday=data[rcode][1];
	 
	console.log("aaaaaa===",rcode,oldstartday,curstartday);
	var oldclose=CorrClose(rcode,oldstartday);
	var curclose=CorrClose(rcode,oldstartday);
	console.log("old");
	console.log(oldclose);
	console.log("curclose");
	console.log(curclose);
	//console.log(closevalue);
	
	const data1 = Array.from({length: 80}, () => Math.floor(Math.random() * 10));
	const data2 = Array.from({length: 70}, () => Math.floor(Math.random() * 10));
	DrawTwoLine(data1,data2);
	
	 });
	
});

function CorrClose(code,startday){
	var result;
	$.ajax({
		url: "AjaxHtml/Receiver.php",
		type: "POST",
		data: JSON.stringify({ "request": "corrclose","code":code,"startday":startday}),
		contentType: "application/json; charset=utf-8",
		async: false, // 동기식 호출
		success: function(redata){
			result=redata;
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


function CorrinfoReq(){
	var result;
	$.ajax({
		url: "AjaxHtml/Receiver.php",
		type: "POST",
		data: JSON.stringify({ "request": "corrcare"}),
		contentType: "application/json; charset=utf-8",
		async: false, // 동기식 호출
		success: function(redata){
			result=redata;
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
	var num=0;
	var corrtable = $('#corrtable tbody');
		Object.values(data).forEach(value => {
			var newRow = '<tr>' +
			'<td>' + value[5] + '</td>';
			newRow +='<td>' + value[3] + '</td>';
			newRow +='<td>' + value[4] + '</td>';
			newRow +='</tr>';
			corrtable.append(newRow);
			if (num==0){
			$('#card_title').text("상관도 분석(75거래일): [" +value[1]+" ~ "+value[2]+"]");
			}
			num++;
			tempdata[value[5]]=value[0];
			
		});
}


function DrawTwoLine(data1,data2) {
	//document.addEventListener('DOMContentLoaded', function() {
    const ctx = document.getElementById('lineChart').getContext('2d');
    const createDataset = (data, label, color1, color2) => {
        const dataSegment1 = data.slice(0, 75);
        const dataSegment2 = data.slice(75);
		if (label=="분석일"){
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
		}else{
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
                       // text: 'Index',
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

	if(chart){
	chart.destroy();
	}
    chart =new Chart(ctx, config);
//});
}
</script>

</body>
</html>