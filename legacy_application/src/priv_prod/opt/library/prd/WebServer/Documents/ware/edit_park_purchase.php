<?php
$database="ware";
include("../../include/auth.inc");
include("../../include/iConnect.inc");// database connection parameters
mysqli_select_db($connection, $database)
   or die ("Couldn't select database $database");
	
if(!is_numeric($id)){exit;}

if(!empty($_POST))
	{
//	echo "<pre>"; print_r($_POST); echo "</pre>";  exit;
	extract($_POST);
	$sql="UPDATE park_order SET quantity='$quantity' 
	where id='$id'"; 
	$result = mysqli_query($connection,$sql) or die ("Couldn't execute query 1. $sql ".mysqli_error($connection));
	header("Location:order_placed.php?park_code=$park_code");
	exit;
	}
	
if(empty($rep))
	{
	$title="Warehouse Order";
	include("../_base_top.php");
	}

$ck_park=explode(",",$_SESSION['ware']['accessPark']);
$ck_park[]=$_SESSION['ware']['select'];

$id=$_GET['id'];
$sql="SELECT t1.*, t2. product_title
from park_order as t1
left join base_inventory as t2 on t1.product_number=t2.product_number
where t1.id='$id'"; 
$result = mysqli_query($connection,$sql) or die ("Couldn't execute query 1. $sql ".mysqli_error($connection));
$ARRAY[0]=mysqli_fetch_assoc($result);
$pt=$ARRAY[0]['product_title'];
$pc=$ARRAY[0]['park_code'];
$d=$ARRAY[0]['ordered_date'];

if(!in_array($pc,$ck_park) and $level<3){exit;}

$skip=array("id","ordered","comments","processed_date");
echo "<form method='POST' action='edit_park_purchase.php'><table><tr><td colspan='2'>Edit <b>$pt</b> for the $pc order of $d</td></tr>";
foreach($ARRAY AS $index=>$array)
	{
	if($index==0)
		{
		echo "<tr>";
		foreach($ARRAY[0] AS $fld=>$value)
			{
			if(in_array($fld, $skip)){continue;}
			if($fld=="quantity")
				{
				$value="<input type='text' name='$fld' value=\"$value\" size='4'>";
				$value.="<input type='submit' name='submit' value=\"Change\">";
				}
			echo "<tr><td>$fld</td><td>$value</td></tr>";
			}
		echo "</tr>";
		}
	}
echo "<tr><td>
<input type='hidden' name='park_code' value=\"$pc\">
<input type='hidden' name='id' value=\"$id\"></td></tr>";
echo "</table></form>";

?>