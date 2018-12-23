<?php 
require("../db/db.php");
$record_per_page =10;
$page = '';
$output="";
 if(isset($_POST["page"])){
	   $page = $_POST["page"]; 
 }
 else {
$page = 1;
}
$start_from = ($page - 1)*$record_per_page; 
	$select_query = "select * from monthly_entry where status ='ACTIVE' ORDER BY id DESC LIMIT $start_from, $record_per_page";
$result = mysqli_query($conn, $select_query);
		$output .='<table class="table table-bordered">
					<tr>
					<th width="5%">S No.</th>
					<th width="20%">Full Name</th>
					<th width="20%">Reg. NO.</th>
					<th width="10%">Rs.100</th>
					<th width="10%">Rs.20</th>
					<th width="10%">Loan</th>
					<th width="15%">Interest Deposit</th>
					<th width="10%">Total</th>
					</tr>';
	$i="1";
$total='';
	while ($row = mysqli_fetch_array($result)){
			$total= $row['MonthDeposit']+$row['maintenaceCharge']+$row['LoanDt']+$row['loan_intrest'];
	$output .= '
		<tr>
		<td>' .$i++ .'</td>
		<td>' .$row['name'] .'</td>
		<td>' .$row['member_code'] .'</td>
		<td>' .$row['MonthDeposit'] .'</td>
		<td>' .$row['maintenaceCharge'] .'</td>
		<td>' .$row['LoanDt'] .'</td>
		<td>' .$row['loan_intrest'] .'</td>
		<td>' .$total .'</td>
		</tr>
		';
			
		}
		$output .= '</table><div align="center" id="pagination">';

 $page_query = "SELECT * FROM monthly_entry where status = 'ACTIVE' ORDER BY id DESC";  
 $page_result = mysqli_query($conn, $page_query);  
 $total_records = mysqli_num_rows($page_result);  
 $total_pages = ceil($total_records/$record_per_page);  
 for($i=1; $i<=$total_pages; $i++)  
 {  
      $output .= "<span class='pagination_link' style=' cursor:pointer; padding:6px; border:1px solid #ccc;' id='".$i."'>".$i."</span>";  
 }  
 $output .= '</div>'; 

echo $output;
?>