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
		  공사중...
		  </section>
		</div>
		
		 <div class="row">
          <!-- Left col -->
          <section class="col-lg-5 connectedSortable">
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
	var data=CorrinfoReq();
	console.log(data);
	
	
});

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

</script>

</body>
</html>