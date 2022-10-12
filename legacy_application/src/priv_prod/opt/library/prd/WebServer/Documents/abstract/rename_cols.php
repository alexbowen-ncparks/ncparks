<?php
//echo "<pre>"; print_r($_REQUEST); echo "</pre>"; // exit;
//echo "<pre>"; print_r($_SERVER); echo "</pre>";  exit;
extract($_REQUEST);

include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection,$database); // database 
       
$sql="SHOW columns from $new_table";
$result = @mysqli_query($connection,$sql) or die(mysqli_error($connection));
while($row=mysqli_fetch_array($result))
	{
	$fld_array[]=$row['Field'];
	}

$sql="SELECT * from $new_table where 1 limit 1";
$result = @mysqli_query($connection,$sql) or die(mysqli_error($connection));
$row=mysqli_fetch_row($result);


foreach($row as $k=>$v)
	{
	if($v==""){continue;}
	$v=strtolower(str_replace(" ","_",$v));
	$v=strtolower(str_replace("-","_",$v));
	$sql="ALTER TABLE `$new_table` CHANGE `$fld_array[$k]` `$v` TEXT";
		$sql.=" NOT NULL;";
	$result = @mysqli_query($connection,$sql) or die(mysqli_error($connection));
	}
if($result)
	{
	echo "Field names for $new_table have been changed to first row of table.";
	echo "<br /><a href='/abstract/abstract.php?database=$database'>New table</a><br />";
	}
?>
