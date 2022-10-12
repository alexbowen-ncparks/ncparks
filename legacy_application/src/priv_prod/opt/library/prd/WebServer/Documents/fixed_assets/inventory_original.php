<?php
session_start();

//echo "<pre>"; print_r($_REQUEST); echo "</pre>"; // exit;
//echo "<pre>"; print_r($_SESSION); echo "</pre>"; // exit;

$database="fixed_assets";
include("../../include/connectROOT.inc");// database connection parameters
$db = mysql_select_db($database,$connection)
       or die ("Couldn't select database $database");
       
$level=$_SESSION['fixed_assets']['level'];
if($level<1){exit;}

if($level==2 || $_SESSION['fixed_assets']['accessPark']!="")
	{
		if($level==1){$parkList=explode(",",$_SESSION['fixed_assets']['accessPark']);}
		if($level==2)
			{
			include("../../include/get_parkcodes.inc");
			$distCode=$_SESSION['fixed_assets']['select'];
			$parkList=${"array".$distCode};
			}
	
if(count($_SESSION['fixed_assets']['multi_center'])<1)
		{
		mysql_select_db("budget",$connection);
			foreach($parkList as $k=>$v)
				{
					$sql="select center from center where parkCode='$v'";
					$result = mysql_query($sql) or die ("Couldn't execute query 0. $sql");
					$row=mysql_fetch_array($result);
					$_SESSION['fixed_assets']['multi_center'][$v]=$row['center'];
				}
		}
	if(in_array($_REQUEST['location'],$parkList))
		{		$_SESSION['fixed_assets']['center']=$_SESSION['fixed_assets']['multi_center'][$_REQUEST['location']];
		}
	
	}
//echo "<pre>"; print_r($_SESSION); echo "</pre>"; // exit;

mysql_select_db($database,$connection);
echo "<html><head>";

include("../css/TDnull.php");

echo "<title>NC DPR Fixed Asset Tracking System</title><body>";

$sql="select distinct location as park_code from inventory_2012 where 1 order by location";
$result = mysql_query($sql) or die ("Couldn't execute query 1. $sql");
while ($row=mysql_fetch_array($result))
	{
		$park_array[]=$row['park_code'];
	}


echo "<form action='find_inventory.php' method='POST'>";
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
echo "<td><input type='submit' name='submit' value='Submit'></td>";
echo "</tr></table></div>";
echo "</form>";
?>