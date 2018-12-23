<?php 
require("db/db.php");
$query = "select * from member_reg where status = 'ACTIVE'";
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
			<div class="col-lg-12 table-responsive" id="header">
		<table class="table table-bordered">
				<tr>
					<th width="20%">Total Members</th>
					<th width="15%">Monthly Deposit</th>
					<th width="15%">Maintenace Charge</th>
					<th width="15%">Loan Deposit</th>
					<th width="15%">Interest Deposit</th>
					<th width="20%">Total</th>
					</tr>
					<tr>
					<td width="20%"> <span id="membercount">  </span></th>
					<td width="10%">+ <span id="mdpst">  </span></th>
					<td width="10%">+<span id="mcharge"> </span></th>
					<td width="20%">+<span id="ldpst">  </span></th>
					<td width="20%">+<span id="intdpst"> </span></th>
					<td width="20%">+<span id="totalamount">  </span></th>
					</tr>
				</table>
	
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
	<select class="form-control" id="mname">
			<option selected> Select Member Name</option>

		</select>
      
        Monthly Deposit
       <input type="text" id="MonthDeposit" name="MonthDeposit" class="form-control" placeholder="Enter here">
        Maintenace Charge
       <input type="text" id="MainCharge" name="MainCharge" class="form-control" placeholder="Enter ">
        Loan Deposit
        <input type="text" id="LoanDt" name="LoanDt" class="form-control" placeholder="Enter ">
        Intrest Deposit
         <input type="text" id="InterestDt" name="InterestDt" class="form-control" placeholder="Enter "><br>
          <button type="button" class="btn btn-warning" id="insertData">INSERT DATA</button>
      </form>
      </div>
      <div class="modal-footer">
     
        <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
      </div>
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
load_total_data();
select_name();
});
	//	 REGISTER NEW MEMBER  HERE
	//=================================================================================
	
	$("#insertData").click(function(){
	mname = $("#mname").val();
	MonthDeposit = $("#MonthDeposit").val();
	MainCharge = $("#MainCharge").val();
	LoanDt = $("#LoanDt").val();
	InterestDt = $("#InterestDt").val();
	
	$.ajax({
		url:"ajax/data_get_member.php",
			method:"POST",
			async: false,
			data:{oper:"MONTHDATA",mname:mname,MonthDeposit:MonthDeposit,MainCharge:MainCharge,LoanDt:LoanDt,InterestDt:InterestDt},
			success:function(data){
			$("#dataModal").modal("show");
				var modal = $("#dataModal");
				modal.find('form')[0].reset();
			load_data_entry();
				load_total_data();
				select_name();
			}
		});
	});

//	SELECT REGISTER MEMBER DATA HERE
	//=====================================================================//
		function load_data_entry(page)
	{
		$.ajax({
   url:"ajax/pagination.php",
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
	
function load_total_data()
{
	var id ='';
	var MonthDeposit ='';
	var MainCharge ='';
	var LoanDt ='';
	var InterestDt ='';
	var totalamount ='';
		$.ajax({
   url:"ajax/data_get_member.php?oper=TOTALDATA",
   method:"POST",
   dataType: 'json',
		data:{},	
	success:function(jsondata)
   {
	   
    $.each(jsondata, function(i, item){
		id = jsondata[i].id;
		MonthDeposit = jsondata[i].MonthDeposit;
		MainCharge = jsondata[i].maintenaceCharge;
	LoanDt = jsondata[i].LoanDt;
	InterestDt = jsondata[i].loan_intrest;
	totalamount = jsondata[i].totalamount;
		
	});
	 $("#membercount").html(id);
	   $("#mdpst").html(MonthDeposit);
	   $("#mcharge").html(MainCharge);
	   $("#ldpst").html(LoanDt);
	   $("#intdpst").html(InterestDt);
   $("#totalamount").html(totalamount);
	 
   }
  });
		
	}

	$("#resetData").click(function(event){
	action = confirm("Are you sure you want to reset all data?'");
	if(action == true){
		var status = "INACTIVE";
		if(status =="INACTIVE"){
		$.ajax({
			url:"ajax/data_get_member.php",
			method: "POST",
			async: false,
			data: {oper:"RESETDATA",status:status},
			success:function(data)
{
		load_data_entry();
	load_total_data();
	select_name();		}
			   });
		}
	
	
}
	});
	
	
	function select_name(){
		$.ajax({
   url:"ajax/data_get_member.php",
   method:"POST",
   async: false,
			data:{oper:"SELECT_NAME"},
	success:function(data){
		$("#mname").html(data);
			}
	});
	}
</script>