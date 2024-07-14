<?php
include "./head.php";
include "./sidebar.php";
?>

<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/buttons/2.0.1/js/buttons.flash.min.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/buttons/2.0.1/js/buttons.html5.min.js"></script>

	
<div class="content-wrapper">
    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        
        <!-- Main row -->
        <div class="row">
	      <section class="col-lg-12 connectedSortable">
			<div class="card">
              <div class="card-header">
                <h3 id="hotdata" class="card-title">주가등락율</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <!-- <table id="risktable" class="table table-bordered table-striped"> !-->
				<table id="trendtable" class="display" style="width:100%">
				  <thead>
                  <tr>
                    <th rowspan=2>종 목 명</th>
					<th colspan=11>등락율 (%)</th>
                  </tr>
				  
				  <tr>
				  <th>주간</th>
				  <th>1달</th>
				  <th>분기 </th>
				  <th>반기</th>
                  <th>년초</th>
                  <th>1년</th>
				  <th>2년</th>
				  <th>3년</th>
				  <th>4년</th>
				  <th>5년</th>				  
				  <th>년평</th>
				  <th>상장</th>
				  
				  </tr>
                  </thead>
				  <tbody>
				 
				  </tbody>
				  
                </table>
              </div>
              <!-- /.card-body -->
            </div>
		  </section>
		</div>
		
		
		
		
		        <div class="row">
	      <section class="col-lg-12 connectedSortable">
			<div class="card">
              <div class="card-header">
                <h3 class="card-title">주가흐름</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <!-- <table id="risktable" class="table table-bordered table-striped"> !-->
				<table id="trendtable2" class="display" style="width:100%">
				  <thead>
                  <tr>
                    <th rowspan=2>종 목 명</th>
					<th colspan=11>종가흐름</th>
                    <!-- <th colspan=12>종가현황</th> !-->
                  </tr>
				  
				  <tr>
				  <th>종가</th>
				  <th>1달</th>
				  
				  <th>분기 </th>
				  <th>반기</th>
                  <th>년초</th>
                  
				  <th>1년</th>
				  <th>2년</th>
				  <th>3년</th>
				  
				  <th>4년</th>
				  <th>5년</th>				  
				  
				  </tr>
                  </thead>
				  <tbody>
				 
				  </tbody>
				  
                </table>
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

<script>
$(document).ready(function(e){ 
$('[data-widget="pushmenu"]').PushMenu('collapse');

var hotword=HotWordReq();
if (hotword.length==1){
	hotwordlist=hotword[0]['hotword'];
	$('#hotdata').text('주가등락율  😊HotWord['+hotwordlist+']');
}

var data=TrendinfoReq();
appendDataToTable(data);
appendDataToTable2(data);

	$('#trendtable').DataTable({
				dom: 'Bfrtip',
				buttons: ['excel']
			});
		
	
	$('#trendtable2').DataTable({
			dom: 'Bfrtip',
			buttons: ['excel']
	});

	
});



//////////////////////////////////////
function TrendinfoReq(){
	var result;
	$.ajax({
		url: "AjaxHtml/Receiver.php",
		type: "POST",
		data: JSON.stringify({ "request": "trendinfo"}),
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
function HotWordReq(){
	var result;
	$.ajax({
		url: "AjaxHtml/Receiver.php",
		type: "POST",
		data: JSON.stringify({ "request": "hotword"}),
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
	//console.log("Received data:", data);
	var trendtable = $('#trendtable tbody');
	data.forEach(function(row) {
		var newRow = '<tr>' +
			'<td>' + row[0] + '</td>' ;
			for (var i=1; i < 13; i++){
				if (row[i]==null){
					newRow +='<td> </td>';
					}
				else if (row[i] < 0){
				newRow +='<td> <font color="blue">'+row[i]+'</td>';
				}else{
					
					
				newRow +='<td> <font color="red">'+row[i].toLocaleString() +'</td>';
				}
			
				}
			
			newRow +='</tr>';
		trendtable.append(newRow);
	});
}


function appendDataToTable2(data) {
	//console.log("Received data:", data);
	var trendtable2 = $('#trendtable2 tbody');
	data.forEach(function(row) {
		var newRow2 = '<tr>' +
			'<td>' + row[0] + '</td>' ;
			for (var i=13; i < 22; i++){
				if (row[i]==null){
					newRow2 +='<td></td>';
					}
					
					else if (row[i+1]!=null && row[i+1] > row[i]){
					newRow2 +='<td> <font color="blue">'+row[i].toLocaleString() +'</td>';
					}
					else if (row[i+1]==null){
					newRow2 +='<td>'+row[i].toLocaleString() +'</td>';
					}
					
					else{
						newRow2 +='<td> <font color="red">'+row[i].toLocaleString() +'</td>';
					}
			
				}
			if(row[22]==null){
			newRow2 +='<td></td>';
			}else{				
			newRow2 +='<td>'+row[22].toLocaleString() +'</td>';
			}
			newRow2 +='</tr>';
			//console.log(newRow2);
			
		trendtable2.append(newRow2);
	});
}

</script>

</body>
</html>