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
	TestAjax();
	
});

function TestAjax(){

	var id="1";
	var pw="2";
	$.ajax({
		url: "AjaxHtml/Recever.php",
		type: "POST",
		data: JSON.stringify({ id: id, pw: pw }),
		contentType: "application/json; charset=utf-8",
		success: function(data){
		console.log(data);
			
			//$("#result").html(data);
		},
		error: function(xhr, status, error){
		console.log(status,error);
			$("#result").html("An error occurred: " + error);
		}
	});
	
}

</script>

</body>
</html>