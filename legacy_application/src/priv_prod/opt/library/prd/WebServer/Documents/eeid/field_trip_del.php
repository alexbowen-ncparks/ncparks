<?php
ini_set('display_errors',1);
extract($_REQUEST);
//echo "<pre>"; print_r($_SERVER); echo "</pre>";  exit;

	include_once("_base_top.php");// includes session_start();

$level=@$_SESSION['eeid']['level'];
//if($level<1){echo "You do not have access to this database. Contact Tom Howard for more info. tom.howard@embarqmail.com"; exit;}


$db="eeid";
include("../../include/connect_i_ROOT.inc"); // database connection parameters
$db = mysqli_select_db($connection,$database)       or die ("Couldn't select database");
	
$sql="SELECT t1.*
FROM `field_trip` as t1
where 1 and id='$del'";  //echo "$sql";
$result = mysqli_query($connection,$sql);
while($row=mysqli_fetch_assoc($result))
		{
		$sql="DELETE from `field_trip` where 1 and id='$del'";  //echo "$sql";
		$result1 = mysqli_query($connection,$sql);
		IF($result1==TRUE){echo "Record deleted.";}
		}
mysqli_close($connection);
?>