<?php
include "./head.php";
include "./sidebar.php";
?>

  
  <!-----------======================
    <!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">


    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
		 <div class="row">
          <!-- Left col -->
        <!--  <section class="col-lg-5 connectedSortable">
		  </section> !-->
		</div>
		
        <!-- Main row -->
        <div class="row">
          <!-- Left col -->
          <section class="col-lg-12 connectedSortable">
			<div class="card">
              <div class="card-header">
                <h3 class="card-title">변동성현황</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <!-- <table id="risktable" class="table table-bordered table-striped"> !-->
				<table id="risktable" class="display" style="width:100%">
				  <thead>
                  <tr>
					
                    <th rowspan=2>종 목 명</th>
					<th colspan=2>승  률</th>
                    <th colspan=2>평균</br>수익율</th>
					<th colspan=2>&nbsp;  년 중&nbsp;  </br>최대손익</th>
					<th colspan=2>&nbsp;  월 중&nbsp;  </br>최대손익</th>
					<th colspan=2>년초년말</br>최대손익</th>
					<th colspan=2>월초월말</br>최대손익</th>
					<th colspan=2>년연속</br>손익횟수</th>
					<th colspan=2>월연속</br>손익횟수</th>
					<!-- <th colspan=2>년누적</br>손익횟수</th>
					<th colspan=2>월누적</br>손익횟수</th> !-->
                  </tr>
				  
				  <tr>
				  <th>년 </th>
				  <th>월</th>
				  <th>년 </th>
				  <th>월</th>
				  <th><font color='gray'>익</font></th>
				  <th><font color='gray'>손</font></th>
                  <th>익</th>
                  <th>손</th>
				  <th><font color='gray'>익</font></th>
				  <th><font color='gray'>손</font></th>
                  <th>익</th>
                  <th>손</th>
				  <th><font color='gray'>익</font></th>
                  <th><font color='gray'>손</font></th>
				  <th>익</th>
				  <th>손</th>
				  
				  <!--
				  <th><font color='gray'>익</font></th>
                  <th><font color='gray'>손</font></th>
				  
				  <th>익</th>
                  <th>손</th> !-->
				  
				  
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

    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/buttons/2.0.1/js/buttons.flash.min.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/buttons/2.0.1/js/buttons.html5.min.js"></script>

<script>
$(document).ready(function(e){ 
$('[data-widget="pushmenu"]').PushMenu('collapse');
	var result=RiskinfoReq();
	appendDataToTable(result)
	
	
	
	 var table =$('#risktable').DataTable({
            dom: 'Bfrtip',
            buttons: ['excel']
        });
	



	
	$('#risktable tbody').on('click', 'tr', function() {
	var rowData = table.row(this).data();
	var textData = [];

	$(this).find('td').each(function() {
		textData.push($(this).text());
	});
	
	
	var jsonData = JSON.stringify(textData);

	var popup = window.open('spider.php', '_blank', 'width=850,height=400');
	popup.onload = function() {
		popup.postMessage(jsonData, '*');
	};
	 });



});


function RiskinfoReq(){
	var result;
	$.ajax({
		url: "AjaxHtml/Receiver.php",
		type: "POST",
		data: JSON.stringify({ "request": "riskinfo"}),
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
	var risktable = $('#risktable tbody');
	data.forEach(function(row) {
		if (typeof row[11]==="object"){
			row[11]=0;
		}
		if (typeof row[12]==="object"){
			row[12]=0;
		}
		if (typeof row[13]==="object"){
			row[13]=0;
		}
		if (typeof row[14]==="object"){
			row[14]=0;
		}
		if (typeof row[15]==="object"){
			row[15]=0;
		}
		if (typeof row[16]==="object"){
			row[16]=0;
		}
		
		var newRow = '<tr>' +
			'<td>' + row[0] + '</td>' ;
			for (var i=1; i < 3; i++){
				if (row[i]==null){
					newRow +='<td> </td>';
					}
				else if (row[i] < 51){
				newRow +='<td> <font color="blue">'+row[i]+'</td>';
				}else{
				newRow +='<td> <font color="red">'+row[i]+'</td>';
				}
			
			}
			for (var i=3; i < 11; i++){
			 if (row[i] < 0){
			 newRow +='<td> <font color="blue">'+row[i]+'</td>';
			 }else{
			 newRow +='<td> <font color="red">'+row[i]+'</td>';
			 }
			}
			for (var i=11; i < 17; i++){
			newRow +='<td>'+row[i]+'</td>';
			}
			
			newRow +='</tr>';
		risktable.append(newRow);
	});
}
</script>

</body>
</html>