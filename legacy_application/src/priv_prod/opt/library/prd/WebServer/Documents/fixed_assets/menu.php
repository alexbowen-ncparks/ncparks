<?php
session_start();

//echo "<pre>"; print_r($_REQUEST); echo "</pre>"; // exit;
//echo "<pre>"; print_r($_SESSION); echo "</pre>"; // exit;

$database="fixed_assets";
include("../../include/iConnect.inc");// database connection parameters
mysqli_select_db($connection, $database)
       or die ("Couldn't select database $database");
       
$level=$_SESSION['fixed_assets']['level'];
if($level<1){exit;}

if($level==2 || $_SESSION['fixed_assets']['accessPark']!="")
	{
		if($level==1)
			{$parkList=explode(",",$_SESSION['fixed_assets']['accessPark']);}
		if($level==2)
			{
			include("../../include/get_parkcodes_i.php");
			$distCode=$_SESSION['fixed_assets']['select'];
			$parkList=${"array".$distCode};
			}
	
if(count($_SESSION['fixed_assets']['multi_center'])<1)
		{
		mysqli_select_db($connection,"budget");
			foreach($parkList as $k=>$v)
				{
					$sql="select center from center where parkCode='$v'";
					$result = mysqli_query($connection,$sql) or die ("Couldn't execute query 0. $sql");
					$row=mysqli_fetch_array($result);
					$_SESSION['fixed_assets']['multi_center'][$v]=$row['center'];
				}
		}
	if(in_array($_REQUEST['location'],$parkList))
		{		$_SESSION['fixed_assets']['center']=$_SESSION['fixed_assets']['multi_center'][$_REQUEST['location']];
		}
	
	}
//echo "<pre>"; print_r($_SESSION); echo "</pre>"; // exit;

mysqli_select_db($connection,$database);
echo "<html><head>";

include("../css/TDnull.php");

echo "<title>NC DPR Fixed Assest Tracking System</title><body>";

$sql="select distinct ncas_number from fixed_assets where 1 order by ncas_number";
$result = mysqli_query($connection,$sql) or die ("Couldn't execute query 1. $sql");
while ($row=mysqli_fetch_array($result))
	{
		$FA_ncas_array[]=$row['ncas_number'];
	}

$sql="select distinct location as park_code from fixed_assets where 1 order by location";
$result = mysqli_query($connection,$sql) or die ("Couldn't execute query 1. $sql");
while ($row=mysqli_fetch_array($result))
	{
		$park_array[]=$row['park_code'];
	}


mysqli_select_db($connection,"budget");
$sql="select ncasNum,park_acct_desc from coa where valid_1280='y' and left(ncasNum,2)='53' and left(ncasNum,3)<'535'order by ncasNum";
$result = mysqli_query($connection,$sql) or die ("Couldn't execute query 1. $sql");
while ($row=mysqli_fetch_array($result))
	{
		if(in_array($row['ncasNum'],$FA_ncas_array))
			{
				$FA_desc_array[$row['ncasNum']]=$row['park_acct_desc'];
			}
	}

//echo "<pre>$sql"; print_r($FA_ncas_array); echo "</pre>"; // exit;

	$FA_desc_array_flipped=array_flip($FA_desc_array);
	
	if(!is_numeric(@$_REQUEST['ncas_number']))
		{			$_REQUEST['ncas_number']=@$FA_desc_array_flipped[$_REQUEST['ncas_number']];
		}
//echo "<body>";
echo "<form action='find.php' method='POST'>";
echo "<div align='center'><table border='1' cellpadding='5'>";
echo "<tr><td colspan='6' align='center'>NC DPR Fixed Asset Inventory</td></tr>";

$test_unit=@$_REQUEST['location'];
echo "<tr><td align='center'>Unit Code<br /><select name='location'><option></option>";
	foreach($park_array as $k=>$v)
		{
		if($level<3){
		if(!array_key_exists($v,$_SESSION['fixed_assets']['multi_center']))
			{continue;}
			}
			if($v==$test_unit){$s="selected";}else{$s="value";}
			echo "<option $s='$v'>$v</option>";
		}
echo "</select></td>";
echo "<td align='center'>Equipment Groups<br /><select name='ncas_number'><option></option>";
$test_ncas=@$FA_desc_array[$_REQUEST['ncas_number']];
asort($FA_desc_array);
	foreach($FA_desc_array as $k=>$v)
		{		
		if($v==$test_ncas){$s="selected";}else{$s="value";}
			echo "<option $s='$k'>$v</option>";
		}
echo "</select></td>";

echo "<td align='center'>FAS Num<br /><input type='text' name='asset_number' value=\"$asset_number\"><option></option></td>";

$ad=@$_REQUEST['asset_description'];
echo "<td align='center'>Asset Description<br /><input type='text' name='asset_description' value=\"$ad\"><option></option></td>";
$nn2=@$_REQUEST['ncas_number_2'];
echo "<td align='center'>NCAS Number<br /><input type='text' name='ncas_number_2' value=\"$nn2\"><option></option></td>";
$sn=@$_REQUEST['serial_number'];
echo "<td align='center'>Serial Number/VIN<br /><input type='text' name='serial_number' value=\"$sn\"><option></option></td>";
echo "<td><input type='submit' name='submit' value='Submit'></td>";
echo "</tr></table></div>";
echo "</form>";
?>