<?php 
require("../db/db.php");
$oper = $_REQUEST['oper'];
 if($oper == "SELECT_MEMBER_DETAILS")

{
$query = "select name, member_code, mobile, regFee from member_reg ORDER BY ID DESC";
$result = mysqli_query($conn, $query ) or die( 'MySQL Error: ' . mysqli_errno($conn) );
$output = array("aaData" => array());
	$sl_no = 1;
	while( $row = mysqli_fetch_assoc( $result ) )

	{
		$row1 = array();
		$row1[0] = $sl_no;
		$row1['sl_no'] = $sl_no;
		$row1[1] = $row['name'];
		$row1['name'] = ucwords($row['name']);
		$row1[2] = $row['member_code'];
		$row1['member_code'] = $row['member_code'];
		$row1[3] = $row['mobile'];
		$row1['mobile'] = $row['mobile'];
		$row1[4] = $row['regFee'];
		$row1['regFee'] = $row['regFee'];
		$output['aaData'][] = $row1;
		$sl_no ++;
	}

mysqli_close($conn);
	
echo json_encode( $output );
	
}
else if($oper === 'ADDNEWMEMBER'){
	date_default_timezone_set("Asia/Calcutta");
	$regDate = date('d-m-Y H:i:s');
	$today = date('d-m-y');
	$member_id = 'MK'.date("dmyHis");
	$fullname = mysqli_real_escape_string($conn,$_POST["fullname"]);
	$mobile = mysqli_real_escape_string($conn,$_POST["mobile"]);
	$email = mysqli_real_escape_string($conn,$_POST["email"]);
	$reg_fee = mysqli_real_escape_string($conn,$_POST["regFee"]);
	$address = mysqli_real_escape_string($conn,$_POST["address"]);
	$output='';
	 $quary = "INSERT INTO `member_reg`(`name`, `member_code`, `mobile`, `email`, `regFee`, `regDate`, `member_address`, `status`) VALUES ('$fullname','$member_id','$mobile','$email','$reg_fee','$today','$address','ACTIVE')";
	if(mysqli_query($conn, $quary)){
		$quary = "INSERT INTO `member_data`(`name`, `member_code`, `date`, `rFee`) VALUES ('$fullname','$member_id','$regDate','$reg_fee')";
	if(mysqli_query($conn, $quary)){
		 $output .= '<label class="text-success">Data Inserted</label>';
	}
	}
echo $output;
}
else if($oper === 'MONTHDATA'){
	$output="";
	date_default_timezone_set("Asia/Calcutta");
	$date = date("d-m-Y");
 $member_code = mysqli_real_escape_string($conn,$_POST["mname"]);
 $MonthDeposit = mysqli_real_escape_string($conn,$_POST["MonthDeposit"]);
 $MainCharge = mysqli_real_escape_string($conn,$_POST["MainCharge"]);
	$LoanDt = mysqli_real_escape_string($conn,$_POST["LoanDt"]);
	 $InterestDt = mysqli_real_escape_string($conn,$_POST["InterestDt"]);
	$select_query = "select * from member_reg where member_code = '$member_code'";
		$result = mysqli_query($conn, $select_query);
	while ($row = mysqli_fetch_array($result)){
		$mname = $row['name'];
		
	$quary = "insert into monthly_entry(name,member_code,MonthDeposit,maintenaceCharge,LoanDt,loan_intrest,status,date)values('$mname','$member_code','$MonthDeposit','$MainCharge','$LoanDt','$InterestDt','ACTIVE','$date')";
	if(mysqli_query($conn, $quary)){
		$quary = "insert into member_data(name,member_code,date,return_loan,return_loanInt,MonthlyDt,mcharge)values('$mname','$member_code','$date','$LoanDt','$InterestDt','$MonthDeposit','$MainCharge')";
	if(mysqli_query($conn, $quary)){
//		$output .= '<label class="text-success">Data Inserted</label>';
		 $query = "UPDATE `member_reg` SET `status`='INACTIVE' WHERE member_code = '$member_code'";
		
	if(mysqli_query($conn,$query)){
$output .= "Insert Data";
	}
	}
	}
echo $output;
	
}
	
	}
else if($oper === 'TOTALDATA'){
	$totaldata = array();
$select_query = "select * from monthly_entry where status = 'ACTIVE'";
$result = mysqli_query($conn, $select_query);
$totalamount='';
$MonthDeposit='';
$MainCharge='';
$LoanDt='';
$InterestDt='';
	date_default_timezone_set("Asia/Calcutta");
	$date = date("d-m-Y");
$i = '1';
while ($row = mysqli_fetch_assoc($result)){
	$total = $row['MonthDeposit']+$row['maintenaceCharge']+$row['LoanDt']+$row['loan_intrest'];
	$MonthDeposit += $row['MonthDeposit'];
	$MainCharge += $row['maintenaceCharge'];
	$LoanDt += $row['LoanDt'];
	$InterestDt += $row['loan_intrest'];
	$totalamount += $total;
	$totaldata[] = array(
	'id' => $i++,
	'MonthDeposit' => $MonthDeposit,
	'maintenaceCharge' => $MainCharge,
	'LoanDt' => $LoanDt,
	'loan_intrest' => $InterestDt,
	'totalamount' => $totalamount,
	);
	
	
	}

echo json_encode($totaldata);
}
else if($oper === 'RESETDATA'){
	date_default_timezone_set("Asia/Calcutta");
	$date = date("d-m-Y");
	 $status = $_REQUEST['status'];
	$query = "UPDATE `monthly_entry` SET `status`='$status', `end_date`='$date' WHERE status = 'ACTIVE'";
	if(mysqli_query($conn,$query)){
$query = "UPDATE `member_reg` SET `status`='ACTIVE' WHERE status = 'INACTIVE'";
		if(mysqli_query($conn,$query)){
echo "reset Data";
	}
	}
}

else if($oper === 'SELECT_NAME'){
	$output='';
	$query = "select * from member_reg where status = 'ACTIVE'";
	$result = mysqli_query($conn,$query);
	while ($row= mysqli_fetch_assoc($result)){
		$name = $row['name'];
		$member_code = $row['member_code'];
		$output .='<option value ='.$member_code.'>'.$name.'</option>';
		
	}
	echo $output;
}
 else if ($oper === 'SELECT_FULL_RECORD'){
	$query = "SELECT  `name`, `member_code`, `MonthDeposit`, `maintenaceCharge`, `LoanDt`, `loan_intrest`, `date` FROM `monthly_entry` WHERE status = 'INACTIVE' ORDER BY date DESC";
$result = mysqli_query($conn, $query ) or die( 'MySQL Error: ' . mysqli_errno($conn) );
$output = array("aaData" => array());
	$sl_no = 1;
	while( $row = mysqli_fetch_assoc( $result ) )

	{
		
		$total = $row['MonthDeposit']+$row['maintenaceCharge']+$row['LoanDt']+$row['loan_intrest'];
		$row1 = array();
		$row1[0] = $sl_no;
		$row1['sl_no'] = $sl_no;
		$row1[1] = $row['name'];
		$row1['name'] = ucwords($row['name']);
		$row1[2] = $row['member_code'];
		$row1['member_code'] = $row['member_code'];
		$row1[3] = $row['MonthDeposit'];
		$row1['MonthDeposit'] = $row['MonthDeposit'];
		$row1[4] = $row['maintenaceCharge'];
		$row1['maintenaceCharge'] = $row['maintenaceCharge'];
		$row1[5] = $row['LoanDt'];
		$row1['LoanDt'] = $row['LoanDt'];
		$row1[6] = $row['loan_intrest'];
		$row1['loan_intrest'] = $row['loan_intrest'];
		$row1[7] = $row['date'];
		$row1['date'] = $row['date'];
		$row1[8] = $total;
		$row1['total'] = $total;
		$output['aaData'][] = $row1;
		$sl_no ++;
		
		
		
	}

mysqli_close($conn);
	
echo json_encode( $output ); 
 }
else if($oper ==='LOANCR'){
	$output="";
	date_default_timezone_set("Asia/Calcutta");
	$date = date("d-m-Y");
 $member_code = mysqli_real_escape_string($conn,$_POST["fullname"]);
$LoanCr = mysqli_real_escape_string($conn,$_POST["LoanCr"]);
	$select_query = "select * from member_reg where member_code = '$member_code'";
		$result = mysqli_query($conn, $select_query);
	while ($row = mysqli_fetch_array($result)){
		$fullname = $row['name'];
		
	$quary = "insert into loanCredit(name,member_code,	loanAmount,status,date)values('$fullname','$member_code','$LoanCr','ACTIVE','$date')";
	if(mysqli_query($conn, $quary)){
		$quary = "insert into member_data(name,member_code,date,loantk)values('$fullname','$member_code','$date','$LoanCr')";
	if(mysqli_query($conn, $quary)){
	$output .= '<label class="text-success">Data Inserted</label>';
	}
	}
echo $output;
	
}
	
}
else if($oper === 'RESETLOANDATA'){
	date_default_timezone_set("Asia/Calcutta");
	$date = date("d-m-Y");
	 $status = $_REQUEST['status'];
	$query = "UPDATE `loanCredit` SET `status`='$status', `end_date`='$date' WHERE status = 'ACTIVE'";
	if(mysqli_query($conn,$query)){

echo "reset Data";
	}
	
}
else if($oper === 'SELECT_LOAN_RECORD'){
	$query = "SELECT  `name`, `member_code`, `LoanAmount`,`date` FROM `loanCredit` WHERE status = 'INACTIVE' ORDER BY date DESC";
$result = mysqli_query($conn, $query ) or die( 'MySQL Error: ' . mysqli_errno($conn) );
$output = array("aaData" => array());
	$sl_no = 1;
	while( $row = mysqli_fetch_assoc( $result ) )

	{
		
		$row1 = array();
		$row1[0] = $sl_no;
		$row1['sl_no'] = $sl_no;
		$row1[1] = $row['name'];
		$row1['name'] = ucwords($row['name']);
		$row1[2] = $row['member_code'];
		$row1['member_code'] = $row['member_code'];
		$row1[3] = $row['LoanAmount'];
		$row1['LoanAmount'] = $row['LoanAmount'];
		$row1[4] = $row['date'];
		$row1['date'] = $row['date'];
		
		$output['aaData'][] = $row1;
		$sl_no ++;
	}

mysqli_close($conn);
	
echo json_encode( $output );
}

else if($oper ==='DELETEDATA'){
	 $member_code = $_REQUEST['member_code'];
	$query="DELETE FROM `member_reg` WHERE member_code='$member_code'";
	if(mysqli_query($conn,$query)){
	
echo "data deleted";	
	}
	
}
?>