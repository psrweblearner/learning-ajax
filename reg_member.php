
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
                
			<p align="right"><input type="button" class="btn btn-success" value="Add Member" data-toggle="modal" data-target="#myModal"></p><br>
			<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Add New Member In Group</h4>
        <p id="error"></p>
      </div>
      <div class="modal-body">
      <form method="post" id="new_member_add">
      	 Full Name
        <input type="text" name="fullname" id="fullname" class="form-control" placeholder="Enter Your Full Name...">
        Mobile No
        <input type="text" id="mobile" name="mobile" class="form-control" placeholder="Enter Your 10 Digit Mobile No..." maxlength="10">
         Email Id
        <input type="email" id="email" name="email" class="form-control">
        Registration Fees
        <input type="text" id="regFee" name="regFee" class="form-control" placeholder="Enter Registration Fess...">
        Member Address
         <textarea class="form-control" id="address"></textarea>
         <br>
          <button type="submit" class="btn btn-warning" id="addmember">ADD</button>
      </form>
      </div>
      <div class="modal-footer">
     
        <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>
<div class="col-lg-12">
		<table class="table table-bordered dataTable table-responsive" id="data_member" style="font-size: 90%; text-align: center;">
		<thead>
			<th>#</th>
			<th>Full Name</th>
			<th>Member Id</th>
		    <th>Mobile No</th>
		    <th>Reg. Fee</th>
			<th>Action</th>
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
	newMember();


});
//	SELECT REGISTER MEMBER DATA HERE
	//=====================================================================//
		function newMember(){
			 var data_member = $('#data_member').dataTable({
			"sAjaxSource": "ajax/data_get_member.php?oper=SELECT_MEMBER_DETAILS",
			"bPaginate": true,
	        "bLengthChange": true,
	        "bFilter": true,
	        "bSort": true,
	        "bInfo": true,
	        "bAutoWidth": false,
		
    
//	        "sDom":"<'row' <'col-xs-3 institutegroupbutton'><'col-xs-3'i><'col-xs-3'l><'col-xs-3'f>r>t<'row'<<'row'>><'col-xs-6 institutegroupbutton2'><'col-xs-6'p>>",
			"aoColumns": [
			{"sName": "sl_no","sWidth": "2%"},
            {"sName": "name","sWidth": "15%"},
            {"sName": "member_code","sWidth": "15%"},
			{"sName": "mobile" ,"sWidth": "12%"},
			{"sName": "regFee" ,"sWidth": "12%"},
			{"sName": "default","sWidth": "10%", "sDefaultContent": "<button class='btn btn-warning btn-sm tooltips' onclick='showUserDtl(event)' title='View'><i class='fa fa-eye'></i></button> <button class='btn btn-danger btn-sm tooltips' onclick='deletedata(event)' title='Delete'><i class='fa fa-trash'></i></button>"},

			]
			
	})
		}


	
	//	 REGISTER NEW MEMBER  HERE
	//=================================================================================
	
	$('#addmember').on('click', function(event){
	event.preventDefault();
	fullname = $('#fullname').val();
	mobile = $('#mobile').val();
	email = $('#email').val();
	regFee = $('#regFee').val();
	address = $('#address').val();
	
if(fullname ===''){
	$("#error").html("Name Field is Required");
	}
	else if(mobile ===''){
		$("#error").html("mobile No. is Required");
	}
	else if(email ===''){
		$("#error").html("Registration Fee is Required");
	}
	else if(regFee ===''){
		$("#error").html("Registration Fee is Required");
	}
	else if(address ===''){
		$("#error").html("Registration Fee is Required");
	}
	else {
	$.ajax({
		url:"ajax/data_get_member.php",
			method:"POST",
			async: false,
			data:{oper:"ADDNEWMEMBER",fullname:fullname,mobile:mobile,email:email,regFee:regFee,address:address},
			success:function(data){
			$("#myModal").modal("show");
			var modal = $("#myModal");
			modal.find('form')[0].reset();
				
			}
		});

	}
});

	
function deletedata(event){
		var result = confirm('Are you sure you want to delete the Subject ?');
		if(result){
			var oTable = $('#data_member').dataTable();
		var row;
		if(event.target.tagName == "BUTTON")
			row = event.target.parentNode.parentNode;
		else if(event.target.tagName == "I")
			row = event.target.parentNode.parentNode.parentNode;			
		var member_code = oTable.fnGetData( row )[2];//GETTING DATA FOR HIDDEN COLUMN(PEOPLEID)
		
		$.post( "ajax/data_get_member.php?oper=DELETEDATA&member_code="+member_code)
		 	.done(function(data) {
			oTable.api().ajax.reload();
		 	})
			.fail(function(data) {

			});
		}
			}
		
function showUserDtl(event)
{
	var row;
	if(event.target.tagName == "BUTTON" || event.target.tagName == "A")
		row = event.target.parentNode.parentNode;
	else if(event.target.tagName == "I")
		row = event.target.parentNode.parentNode.parentNode;
	var oTable = $('#data_member').dataTable();			
	var member_code = oTable.fnGetData( row )[2];//GETTING DATA FOR HIDDEN COLUMN(PEOPLEID)
	window.open("includes/memberDetails.php?member_code="+member_code,"wintutor","status=0, menubar=0, scrollbars=1, toolbars=0, width="+screen.width+", height="+screen.height).focus();
}
</script>