<?php
$database="inspect";
include("../../include/iConnect.inc"); // database connection parameters
mysqli_select_db($connection,$database);

// ********** Set Variables *********
extract($_REQUEST);
	$this_table=$add_ems;
// 	$fld=$trim."_ems";
	$fld="title";
	
	
if($submit=="Add")
	{
	$sql="INSERT INTO $this_table set record_type='$add_ems', `$fld`='$field'";
// 	 echo "$sql";exit;
	 $result = @mysqli_query($connection,$sql);
	header("Location: home.php"); exit;
	}

?>