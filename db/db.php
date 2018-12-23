<?php 
$conn = new mysqli('localhost', 'root', '', 'group_project');

if($conn->connect_error){
	die('ERROR: Unable to connect: '. $conn->connect_error);
}
//echo 'Connected to the database.<br>';

?>