<?php
$database="inspect";
include("../../include/iConnect.inc"); // database connection parameters
mysqli_select_db($connection,$database);

// ********** Set Variables *********
extract($_REQUEST);
	$this_table=$add;
	$trim=rtrim($add,"ly");
	$fld=$trim."_inspect";
	
	
if($submit=="Add")
	{
	$sql="INSERT INTO $this_table set $fld='$field'";// echo "$sql";exit;
	 $result = @mysqli_query($connection,$sql);
	header("Location: overview.php"); exit;
	}

?>