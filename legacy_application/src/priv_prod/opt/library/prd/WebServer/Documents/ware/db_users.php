<?php
session_start();
$level=$_SESSION['ware']['level'];

if($level<4){exit;}

//echo "<pre>"; print_r($_REQUEST); echo "</pre>";  //exit;
//echo "<pre>"; print_r($_SESSION); echo "</pre>"; // exit;
date_default_timezone_set('America/New_York');

include("../../include/iConnect.inc");// database connection parameters

if(!empty($_POST))
	{
//  	echo "<pre>"; print_r($_POST); echo "</pre>";  exit;
	mysqli_select_db($connection, "divper") or die ("Couldn't select database $database");
	foreach($_POST['level'] as $tempID=>$value)
		{
		$sql="UPDATE emplist set ware='$value' where tempID='$tempID'"; //echo "$sql"; exit;
		$result = mysqli_query($connection,$sql) or die ("Couldn't execute query 1. $sql ".mysqli_error($connection));
		}
		
	mysqli_select_db($connection, "ware") or die ("Couldn't select database $database");
		$sql="truncate table cart_access"; //echo "$sql"; exit;
		$result = mysqli_query($connection,$sql) or die ("Couldn't execute query 1. $sql ".mysqli_error($connection));
	foreach($_POST['cart'] as $tempID=>$value)
		{
		if($value<1){continue;}
		$sql="INSERT INTO cart_access set cart='$value', tempID='$tempID'"; //echo "$sql"; exit;
		$result = mysqli_query($connection,$sql) or die ("Couldn't execute query 1. $sql ".mysqli_error($connection));
		}
		$sql="INSERT INTO cart_access set cart='1', tempID='Howard6319'"; //echo "$sql"; exit;
		$result = mysqli_query($connection,$sql) or die ("Couldn't execute query 1. $sql ".mysqli_error($connection));
	}


if(!empty($_REQUEST['rep']))
	{
	$filename="warehouse_inventory_".date("Y-m-d").".xls";
	header('Content-Type: application/vnd.ms-excel');
	header("Content-Disposition: attachment; filename=$filename");
	}
	else
	{
	$database="ware";
	$title="Warehouse Inventory";
	include("../_base_top.php");
	
	echo "<title>NC DPR Warehouse Inventory</title><body>";
	}

$order_by="order by t1.ware desc, t4.cart desc, t1.currPark, t2.Lname";
extract($_GET);
if(@$sort=="Lname")
	{
	$order_by="order by t2.Lname";
	}
if(@$sort=="park")
	{
	$order_by="order by t1.currPark";
	}
mysqli_select_db($connection, "divper") or die ("Couldn't select database $database");       
$sql="select t1.currPark as park, t1.tempID, if(t2.Nname!='',t2.Nname,t2.Fname) as Fname, t2.Lname, t3.posTitle, t1.ware as access, t4.cart, t2.email
from emplist as t1 
left join empinfo as t2 on t1.tempID=t2.tempID
left join position as t3 on t1.beacon_num=t3.beacon_num
left join ware.cart_access as t4 on t1.tempID=t4.tempID
where 1 and t1.tempID !='Howard6319'
$order_by";
// echo "$sql";
$num_cart="";
$result = mysqli_query($connection,$sql) or die ("Couldn't execute query 1. $sql ".mysqli_error($connection));
while ($row=mysqli_fetch_assoc($result))
	{
	$name_array[]=$row;
	if($row['cart']>0){$num_cart++;}
	if(!empty($row['email']))
		{
		$email_array[$row['tempID']]=$row['email'];
		}
	}
// echo "<pre>"; print_r($email_array); echo "</pre>"; // exit;
$email_list=implode(";",$email_array);
$email_link="<a href='mailto:$email_list?subject=Warehouse'>email</a> cart users";
$skip=array("tempID");
$c=count($name_array);
echo "<form method='POST' action='db_users.php'>";
echo "<table><tr><td>$c Users</td><td colspan='5'> - $num_cart with cart access. $email_link</td></tr>";
foreach($name_array AS $index=>$array)
	{
	if($index==0)
		{
		echo "<tr>";
		foreach($name_array[0] AS $fld=>$value)
			{
			if(in_array($fld,$skip)){continue;}
			if($fld=="Lname"){$fld="<a href='db_users.php?sort=Lname'>$fld</a>";}
			if($fld=="park"){$fld="<a href='db_users.php?sort=park'>$fld</a>";}
			echo "<th>$fld</th>";
			}
		echo "</tr>";
		}
	if($array['cart']>0)
		{echo "<tr bgcolor='#FFFFAD'>";}
		else
		{echo "<tr>";}
	
	foreach($array as $fld=>$value)
		{
		if(in_array($fld,$skip)){continue;}
		if($fld=="cart"){continue;}
		if($fld=="access")
			{
			$cart=$array['cart'];
			$ti=$array['tempID'];
			if($value>1){$cart=1;}
			$value="<input type='text' name='level[$ti]' value=\"$value\" size='1'>";
			$value.="</td><td><input type='text' name='cart[$ti]' value=\"$cart\" size='1'>";
			}
		echo "<td>$value</td>";
		}
	echo "</tr>";
	}
echo "<tr><td colspan='6' align='center'>
<input type='submit' name='submit' value=\"Update\">
</td></tr>";
echo "</table>";
echo "</form>";
echo "</body></html>";
?>