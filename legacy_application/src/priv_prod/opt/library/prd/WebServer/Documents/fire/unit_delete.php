<?php
$database="fire";
// include("../../include/connectROOT.inc"); // database connection parameters
// mysql_select_db($database,$connection);

include("../../include/iConnect.inc");
include("../../include/get_parkcodes_reg.php");
mysqli_select_db($connection,'fire');

date_default_timezone_set('America/New_York');

extract($_REQUEST);

//print_r($_FILES); 
//echo "<pre>"; print_r($_REQUEST); print_r($_FILES); echo "</pre>"; //exit;
//exit;

if (!empty($unit_id))
	{
	$sql = "SELECT * FROM prescriptions where unit_id='$unit_id'";
	$result = @mysqli_query($connection,$sql) or die(" $sql Error 1#". mysqli_errno($connection) . ": " . mysqli_error($connection));
	while($row=mysqli_fetch_assoc($result))
	{
	extract($row);
	if(!empty($unit_prescription))
		{
		unlink($unit_prescription);
		}
	}
		$sql = "DELETE FROM prescriptions where unit_id='$unit_id'";
//		echo "$sql"; exit;
		$result = @mysqli_query($connection,$sql) or die(" $sql Error 1#". mysqli_errno($connection) . ": " . mysqli_error($connection));
	
	$sql = "SELECT * FROM maps where unit_id='$unit_id'";
	$result = @mysqli_query($connection,$sql) or die(" $sql Error 1#". mysqli_errno($connection) . ": " . mysqli_error($connection));
	while($row=mysqli_fetch_assoc($result))
	{
	extract($row);
	if(!empty($unit_map))
		{
		unlink($unit_map);
		}
	}
		$sql = "DELETE FROM maps where unit_id='$unit_id'";
//		echo "$sql"; exit;
		$result = @mysqli_query($connection,$sql) or die(" $sql Error 1#". mysqli_errno($connection) . ": " . mysqli_error($connection));
		
	$sql = "DELETE from units where unit_id='$unit_id'"; //echo "$sql";exit;
		$result = @mysqli_query($connection,$sql) or die(" $sql Error 1#". mysqli_errno($connection) . ": " . mysqli_error($connection));
	$sql = "DELETE from burn_history where unit_id='$unit_id'"; 
		$result = @mysqli_query($connection,$sql) or die(" $sql Error 1#". mysqli_errno($connection) . ": " . mysqli_error($connection));
	}
header("Location: units.php");

?>