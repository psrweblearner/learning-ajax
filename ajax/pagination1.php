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
	$select_query = "select * from loanCredit where status ='ACTIVE' ORDER BY id DESC LIMIT $start_from, $record_per_page";
$result = mysqli_query($conn, $select_query);
		$output .='<table class="table table-bordered">
					<tr>
					<th width="5%">#</th>
					<th width="20%">Full Name</th>
					<th width="20%">Reg. NO.</th>
					<th width="10%">Loan Cr</th>
					<th width="10%">Date</th>
					</tr>';
	$i="1";

	while ($row = mysqli_fetch_array($result)){
	$output .= '
		<tr>
		<td>' .$i++ .'</td>
		<td>' .$row['name'] .'</td>
		<td>' .$row['member_code'] .'</td>
		<td>' .$row['loanAmount'] .'</td>
		<td>' .$row['date'] .'</td>
		</tr>
		';
			
		}
		$output .= '</table><div align="center" id="pagination">';

 $page_query = "SELECT * FROM loanCredit where status = 'ACTIVE' ORDER BY id DESC";  
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