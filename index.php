<?php
include "./head.php";
include "./sidebar.php";
?>



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
              <!-- /.card-header -->
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
                <!-- <div id="bar-chart" style="height: 300px;"></div> !-->
				<canvas id="myChart" style="height: 300px;"></canvas>
              </div>
              <!-- /.card-body-->
            </div>
            <!-- /.card -->
			
		  </section>
		  
		</div>
		
		 <div class="row">
          <!-- Left col -->
          <section class="col-lg-5 connectedSortable">
		  sdfsf
		  
		  
		  </section>
		</div>
		
		
		
		
		</div>
		</section>

</div>
<!-- Content Wrapper. Contains page content -->
  
<?php
include "./footer.php";
?>

<script>
$(document).ready(function(e){ 
	 var result=DivinfoReq();
	 appendDataToTable(result['line']);
     var divtable=$('#divtable').DataTable({
      "responsive": true, 
	  "lengthChange": false, 
	  "autoWidth": false,
	  "info": true,
      "buttons": ["excel"],
    });
	//.buttons().container().appendTo('#divtable_wrapper .col-md-6:eq(0)');
	
	const ctx = document.getElementById('myChart');
	
	 $('#divtable tbody').on('click', 'tr', function () {
	var data = divtable.row(this).data();
	  console.log(data[0],result['graph'][data[0]]);
	  title=data[0];
	  label=Object.keys(result['graph'][data[0]]);
	  const datas=[];
	  for (const key in result['graph'][data[0]]) {
		datas.push(result['graph'][data[0]][key]['div']);
	  }
	  bar_draw(ctx,datas,label,title);
	});
	
	
  


  
  
	
	//bar_draw();
  
});


function bar_draw(ctx,datas,label,title){
 new Chart(ctx, {
    type: 'bar',
    data: {
      labels: label,
      datasets: [{
        label: title,
        data: datas,
        borderWidth: 1
      }]
    },
    options: {
      scales: {
        y: {
          beginAtZero: true
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
		

</script>

</body>
</html>