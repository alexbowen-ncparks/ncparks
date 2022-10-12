<?php
//echo "<pre>"; print_r($_REQUEST); print_r($_FILES); echo "</pre>"; // exit;
ini_set('display_errors',1);
$title="DPR IT Inventory";
include("../inc/_base_top_dpr.php");
$database="fixed_assets";

if(empty($connection))
	{
	$database="fixed_assets";
	include("../../include/iConnect.inc");// database connection parameters
	
	$db = mysqli_select_db($connection,$database)
	   or die ("Couldn't select database");
	}

if(!empty($_REQUEST['action']))
	{
	if($_REQUEST['action']=="move")
		{
		$sql ="INSERT INTO new_it_inventory (`receive`, `receive_date`, `equipment`, `brand`, `model`, `serial_num`, `fas_num`, `po_num`, `park_code`, `pick_up_by`, `pick_up_date`)
		SELECT * FROM warehouse where 1";
	$result=mysqli_query($connection,$sql) or (mysqli_query($connection,$sql) and die(mysqli_error($connection) . " - $sql"));
	
	$sql ="SELECT * FROM new_it_inventory where 1";
	$result=mysqli_query($connection,$sql) or (mysqli_query($connection,$sql) and die(mysqli_error($connection) . " - $sql"));
	$num=mysqli_num_rows($result);
	echo "Listed below are the $num records uploaded to the New IT Inventory table.";
	
	echo " Check the records to make sure the upload is correct.";
	echo "<h2><font color='green'>Contact Carl and Bin to let them know these items are ready for delivery.</font></h2>";
	echo " Click <a href='/fixed_assets/import_text.php?action=warehouse'>here</a> if you have additional items to upload.";
		}
	}
	else
	{
	$sql ="SELECT * FROM warehouse where 1";
	$result=mysqli_query($connection,$sql) or (mysqli_query($connection,$sql) and die(mysqli_error($connection) . " - $sql"));
	$num=mysqli_num_rows($result);
	echo "Listed below are the $num records uploaded to the warehouse table.";
	
	echo " Check the records to make sure the upload is correct.";
	echo "<h2><font color='red'>If it is NOT correct, contact Tom Howard.</font></h2>";
	
	echo "<h2><font color='green'>If it is correct, move the items to the <a href='move_it_items.php?action=move'>New IT Inventory table</a> for assignment to the parks by Carl and Bin.</font></h2>";
	}
		
while($row=mysqli_fetch_assoc($result))
	{$ARRAY[]=$row;}
	$c=count($ARRAY);
echo "<table border='1'>";
foreach($ARRAY AS $index=>$array)
	{
	if($index==0)
		{
		echo "<tr>";
		foreach($ARRAY[0] AS $fld=>$value)
			{
			echo "<th>$fld</th>";
			}
		echo "</tr>";
		}
	echo "<tr>";
	foreach($array as $fld=>$value)
		{
		echo "<td>$value</td>";
		}
	echo "</tr>";
	}
echo "</table>";
?>