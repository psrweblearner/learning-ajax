
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
            
	
<div class="col-lg-12">
		<table class="table table-bordered dataTable table-responsive" id="data_member" style="font-size: 90%; text-align: center;">
		<thead>
			<th>#</th>
			<th>Full Name</th>
			<th>M.Code</th>
		    <th>100</th>
		    <th>20</th>
		    <th>Loan</th>
			<th>Loan Int.</th>
			<th>Date</th>
			<th>Total</th>
		</thead>
		<tbody>
		</tbody>
		</table>
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
	MemberRecord();


});
//	SELECT REGISTER MEMBER DATA HERE
	//=====================================================================//
		function MemberRecord(){
			 var data_member = $('#data_member').dataTable({
			"sAjaxSource": "ajax/data_get_member.php?oper=SELECT_FULL_RECORD",
			"bPaginate": true,
	        "bLengthChange": true,
	        "bFilter": true,
	        "bSort": true,
	        "bInfo": true,
	        "bAutoWidth": false,
	        "sDom":"<'row' <'col-xs-3 institutegroupbutton'><'col-xs-3'i><'col-xs-3'l><'col-xs-3'f>r>t<'row'<<'row'>><'col-xs-6 institutegroupbutton2'><'col-xs-6'p>>",
			"aoColumns": [
			{"sName": "sl_no","sWidth": "2%"},
            {"sName": "name","sWidth": "12%"},
            {"sName": "member_code","sWidth": "12%"},
			{"sName": "MonthDeposit" ,"sWidth": "12%"},
			{"sName": "maintenaceCharge" ,"sWidth": "12%"},
			{"sName": "LoanDt" ,"sWidth": "12%"},
			{"sName": "loan_intrest" ,"sWidth": "12%"},
			{"sName": "date" ,"sWidth": "12%"},
			{"sName": "total" ,"sWidth": "12%"},
			]   
			
	})
		}


	
	
</script>