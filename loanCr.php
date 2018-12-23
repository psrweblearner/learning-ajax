<?php 
require("db/db.php");
$query = "select * from member_reg";
$result = mysqli_query($conn, $query);
?>
<!DOCTYPE HTML>
<html>
<head>
<title>Weblearner</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />


<!-- Bootstrap Core CSS -->
<link href="css/bootstrap.css" rel='stylesheet' type='text/css' />
<link href="datatables/bootstrapValidator.css" rel="stylesheet" type="text/css"/>
<link href="datatables/dataTables.bootstrap.css" rel="stylesheet" type="text/css" />
<link href="toastr/css/toastr.min.css" rel="stylesheet" type="text/css" />
<!-- Custom CSS -->
<link href="css/style.css" rel='stylesheet' type='text/css' />

<link href="css/font-awesome.css" rel="stylesheet"> 

 <link href='css/SidebarNav.min.css' media='all' rel='stylesheet' type='text/css'/>
<link href="css/custom.css" rel="stylesheet">



<!--//Metis Menu -->

</head> 
<body class="cbp-spmenu-push">
	<div class="main-content">
	<div>
		<?php include("includes/main-menu.php");?>
	</div>
		<!-- main content start-->
		<div id="page-wrapper">
		 <section class="content-header">
                    <h1>
                       	Register New Member
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li class="active">Register New Member</li>
                    </ol>
                </section>
                
			<p align="right"><input type="button" class="btn btn-warning" id="resetData" value="RESET DATA">  <input type="button" class="btn btn-success" value="INSERT DATA" data-toggle="modal" data-target="#dataModal"></p><br>
	
	
<!-- Modal -->
<div id="dataModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Insert Data </h4>
        <p id="error"></p>
      </div>
      <div class="modal-body">
      <form method="post" id="data_insert">
      		Select Member Name
	<select class="form-control" id="fullname">
			<option selected> Select Member Name</option>
<?php 
		while ($row =mysqli_fetch_array($result)){
			?>
			<option value = <?php echo $row['member_code'];?>> <?php echo $row['name'];?></option>
			<?php
		}
		?>
		</select>
      
      Loan Credit
        <input type="text" id="LoanCr" name="LoanDt" class="form-control" placeholder="Enter "><br>
        
          <button type="button" class="btn btn-warning" id="insertData">INSERT DATA</button>
      </form>
      </div>
      <div class="modal-footer">
     
        <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>
	
<div class="col-lg-12">
		<div class="table-responsive" id="pagination_data">
			
			</div>
	</div>
	</div>
				
			</div>
		
<script src="datatables/jquery-3.3.1.js"> </script>
<script src="datatables/jquery.dataTables.js" type="text/javascript"></script>
<script src="datatables/dataTables.bootstrap.js" type="text/javascript"></script>
<script src="js/custom.js"></script>  
<script src="js/classie.js"></script>
<script src="js/bootstrap.js"> </script>
 
</body>
</html>
<script>
$(document).ready(function(){
load_data_entry();

});
	//	 REGISTER NEW MEMBER  HERE
	//=================================================================================
	
	$("#insertData").click(function(){
	fullname = $("#fullname").val();
	LoanCr = $("#LoanCr").val();
	
	$.ajax({
		url:"ajax/data_get_member.php",
			method:"POST",
			async: false,
			data:{oper:"LOANCR",fullname:fullname,LoanCr:LoanCr},
			success:function(data){
			$("#dataModal").modal("hide");
				var modal = $("#dataModal");
				modal.find('form')[0].reset();
			load_data_entry();
				
			}
		});
	});

//	SELECT REGISTER MEMBER DATA HERE
	//=====================================================================//
		function load_data_entry(page)
	{
		$.ajax({
   url:"ajax/pagination1.php",
   method:"POST",
		data:{page:page},	
	success:function(page)
   {
    $('#pagination_data').html(page);
	 
   }
  });
		
	}
	
$(document).on('click', '.pagination_link', function(){  
            var page = $(this).attr("id");  
           load_data_entry(page);
	 }); 
	

	$("#resetData").click(function(event){
	action = confirm("Are you sure you want to reset all data?'");
	if(action == true){
		var status = "INACTIVE";
		if(status =="INACTIVE"){
		$.ajax({
			url:"ajax/data_get_member.php",
			method: "POST",
			async: false,
			data: {oper:"RESETLOANDATA",status:status},
			success:function(data){
		load_data_entry();
}
		});
		}
}
	});
	
	
</script>