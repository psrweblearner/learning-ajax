
<?php
require_once("db/db.php");
if(isset($_GET['member_code'])){
	$member_code = $_GET['member_code'];
	$sqlquery = "SELECT * from member_reg WHERE 
member_code = '$member_code'";	
$result = mysqli_query($conn,$sqlquery);
$member_row = mysqli_fetch_assoc($result);

}
?>



<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>MK Group</title>
<!-- Bootstrap Core CSS -->
<link href="../css/bootstrap.css" rel='stylesheet' type='text/css' />
<link href="../datatables/bootstrapValidator.css" rel="stylesheet" type="text/css"/>
<link href="../datatables/dataTables.bootstrap.css" rel="stylesheet" type="text/css" />
<link href="../toastr/css/toastr.min.css" rel="stylesheet" type="text/css" />
<!-- Custom CSS -->
<link href="../css/style.css" rel='stylesheet' type='text/css' />

<link href="../css/font-awesome.css" rel="stylesheet"> 

 <link href='../css/SidebarNav.min.css' media='all' rel='stylesheet' type='text/css'/>
<link href="../css/custom.css" rel="stylesheet">
</head>

<body>
<div class="main-content">
	
		 <section class="content-header">
                    <h1>
                       	Member Personal Details
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li class="active">Member Personal Details</li>
                    </ol>
                </section>
                
                 <section class="container">
					<div class="nav-tabs-custom">
                                <!-- Tabs within a box -->
                                <ul class="nav nav-tabs">
                                 <li class="active"><a href="#personalDtl" data-toggle="tab">Personal Details</a></li>
                                    <li><a href="#loanTk" data-toggle="tab">Loan Taken By Member</a></li>
                                    <li><a href="#monthFactivity" data-toggle="tab"> Monthly Financial Activity</a></li>
                                  <li><a href="#YearINT" data-toggle="tab">Account Details</a></li>
								</ul>	
								<div class="tab-content no-padding">
								<!--Prefix Tab-->
                                <div class="tab-pane in active" id="personalDtl" style="position: relative; height:1000px;">
									<div class="row">
										<div class="col-md-12">
			                                <div class="box-header" style="padding-bottom: 3px">
			                                </div>
			                                <div class="box-body" style="margin:0px 10px 0px 10px; width:98%">
			                                	<div class="col-lg-8 col-lg-offset-2">
			                                		<table class="table table-bordered dataTable table-responsive" id="member_details">
			                                			<tr>
			                                				<th colspan="2" style="text-align: center"><?=$member_row['name'];?></th>
			                                			</tr>
			                                			<tr>
			                                			<td>Member Code</td>
			                                				<td><?=$member_row['member_code'];?></td>
			                                			</tr>
			                                			<tr>
			                                			<td>Mobile No.</td>
			                                				<td><?=$member_row['mobile'];?></td>
			                                			</tr>
			                                			<tr>
			                                			<td>Email ID</td>
			                                				<td><?=$member_row['email'];?></td>
			                                			</tr>
			                                			<tr>
			                                			<td>Address</td>
			                                				<td><?=$member_row['member_address'];?></td>
			                                			</tr>
			                                			<tr>
			                                			<td>Joining Date</td>
			                                				<td><?=$member_row['regDate'];?></td>
			                                			</tr>
			                                			<tr>
			                                			<td>Registration Fees</td>
			                                				<td><?=$member_row['regFee'];?></td>
			                                			</tr>
			                                		</table>
												
			                                	</div>
											</div><!-- end box body-->
										</div><!--end col-md-12-->
									</div><!--end row-->
								</div><!--end tab pane-->
								
								<!--Suffix Tab-->
                                <div class="tab-pane" id="loanTk" style="position: relative; height:1000px;">
									
			                                <div class="box-header" style="padding-bottom: 3px">
			                                </div><!-- /.box-header -->
			                                <div class="box-body" style="margin:0px 10px 0px 10px; width:98%">
			                                	<div style="padding: 10px">
												<table class="table table-bordered dataTable table-responsive" id="loandata_member" style="font-size: 90%; text-align: center;">
												<thead>
													<th>#</th>
													<th>Months</th>
													<th>Taken Loan</th>
												    <th>Return Loan</th>
												    <th>Return Loan interest</th>
													<th>Loan Intrest Total</th>
													<th>Left Loan</th>
												</thead>
												<tbody>
												<?php 
						 $query = "SELECT * from member_data WHERE member_code ='$member_code'";	
												$result = mysqli_query($conn,$query);
													$i= 1;
													$total_return =0;
													$left_loan = 0;
												while ($row = mysqli_fetch_array($result)){
													$loan= $row['loantk'];
													$r_loan= $row['return_loan'];
													$r_loan_int= $row['return_loanInt'];
													$total_return=$r_loan+$r_loan_int;
													$left_loan-=$r_loan-$loan;
													
													?>
												<tr>
													<td><?=$i++;?></td>
													<td><?=$row['date'];?></td>
													<td><?=$row['loantk'];?></td>
													<td><?=$row['return_loan'];?></td>
													<td><?=$row['return_loanInt'];?></td>
													<td><?=$total_return;?></td>
													<td><?=$left_loan;?></td>
													
												</tr>
												<?php } ?>
												</tbody>
												</table>
												
											</div><!-- end box body-->
										
									</div><!--end row-->
								</div><!--end tab pane-->
								
								<!--level Tab-->
                                <div class="tab-pane" id="monthFactivity" style="position: relative; height:1000px;">
									<div class="row">
										<div class="col-md-12">
			                                <div class="box-header" style="padding-bottom: 3px">
			                                </div><!-- /.box-header -->
			                                <div class="box-body" style="margin:0px 10px 0px 10px; width:98%">
			                                		<table class="table table-bordered dataTable table-responsive" id="loandata_member" style="font-size: 90%; text-align: center;">
												<thead>
													<th>#</th>
													<th>Months</th>
													<th>Reg. Fees</th>
													<th>Monthly Share</th>
												    <th>Maintenace Charge</th>
<!--												    <th>Yearly Intrest</th>-->
													<th>Total Balance</th>
												</thead>
												<tbody>
												<?php 
						 $query = "SELECT * from member_data WHERE member_code ='$member_code'";	
												$result = mysqli_query($conn,$query);
													$i= 1;
													$total_balance = '';
													
												while ($row = mysqli_fetch_array($result)){
													$total_balance += $row['rFee'] + $row['monthlyDt'] + $row['mcharge'];
													
													?>
												<tr>
													<td><?=$i++;?></td>
													<td><?=$row['date'];?></td>
													<td><?=$row['rFee'];?></td>
													<td><?=$row['monthlyDt'];?></td>
													<td><?=$row['mcharge'];?></td>
													<td><?=$total_balance;?></td>
													
												</tr>
												<?php } ?>
												</tbody>
												</table>
											</div><!-- end box body-->
										</div><!--end col-md-12-->
									</div><!--end row-->
								</div><!--end tab pane-->
								
								<!--Qualification Tab-->
                                <div class="tab-pane" id="YearINT" style="position: relative; height:1000px;">
									<div class="row">
										<div class="col-md-12">
			                                <div class="box-header" style="padding-bottom: 3px">
			                                </div><!-- /.box-header -->
			                                <div class="box-body" style="margin:0px 10px 0px 10px; width:98%">
			                                			<table class="table table-bordered dataTable table-responsive" id="loandata_member" style="font-size: 90%; text-align: center;">
												<thead>
													<th>#</th>
													<th>Months</th>
													<th>Reg. Fees</th>
													<th>Monthly Share</th>
<!--											   <th>Yearly Intrest</th>-->
													<th>Total Balance</th>
												</thead>
												<tbody>
												<?php 
						 $query = "SELECT * from member_data WHERE member_code ='$member_code'";	
												$result = mysqli_query($conn,$query);
													$i= 1;
													$total_balance = '';
													
												while ($row = mysqli_fetch_array($result)){
													$total_balance += $row['rFee'] + $row['monthlyDt'];
													
													?>
												<tr>
													<td><?=$i++;?></td>
													<td><?=$row['date'];?></td>
													<td><?=$row['rFee'];?></td>
													<td><?=$row['monthlyDt'];?></td>
													
													<td><?=$total_balance;?></td>
													
												</tr>
												<?php } ?>
												</tbody>
												</table>
											</div><!-- end box body-->
										</div><!--end col-md-12-->
									</div><!--end row-->
								</div><!--end tab pane-->
								
								
								</div><!--end tab content-->
							</div><!--end tab-->
						
				</section>
               

				
			</div>

<script src="../datatables/jquery-3.3.1.js"> </script>
<script src="../datatables/jquery.dataTables.js" type="text/javascript"></script>
<script src="../datatables/dataTables.bootstrap.js" type="text/javascript"></script>
<script src="../js/custom.js"></script>  
<script src="../js/classie.js"></script>
<script src="../js/bootstrap.js"> </script>
</body>
</html>
