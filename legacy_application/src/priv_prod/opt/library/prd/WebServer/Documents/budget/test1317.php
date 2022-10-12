<?php
session_start();

$active_file=$_SERVER['SCRIPT_NAME'];
$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempID=$_SESSION['budget']['tempID'];
$beacnum=$_SESSION['budget']['beacon_num'];
$user_activity_location=$_SESSION['budget']['select'];
$centerS=$_SESSION['budget']['centerSess'];

extract($_REQUEST);

//echo "<pre>";print_r($_SERVER);"</pre>";//exit;
echo "<pre>";print_r($_SESSION);"</pre>";//exit;
echo "<pre>";print_r($_REQUEST);"</pre>";//exit;


$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database

include("../../include/activity.php");

//include("../budget/~f_year.php");


include("~f_year.php");
$parkList=explode(",",@$_SESSION['budget']['accessPark']);// set in budget.php from db divper.emplist
print_r($parkList);

/*
if($parkList[0]!="")
	{
	//if($report==2){exit;}
//	include("../../../include/connectBUDGET.inc");// database connection parameters
	foreach($parkList as $k=>$v){
	$sql="SELECT center,parkCode from center where parkCode='$v' and center like '1280%'";
	$result = mysqli_query($connection, $sql) or die ("Couldn't execute query 1. $sql");
	$row=mysqli_fetch_array($result);
	$daCode[$v]=$v;$daCenter[$v]=$row[center];
	}
	
	
	$file0="/budget/menu.php";
	$file=$file0."?passParkcode=";
	if($passParkcode==""){$passParkcode=$_SESSION['budget']['select'];
	}
	else{
		$parkcode=$passParkcode;
		$_SESSION['budget']['centerSess']=$daCenter[$passParkcode];
		$_SESSION['budget']['select']=$daCode[$passParkcode];
		}
		
		echo "<td><form><select name=\"center\" onChange=\"MM_jumpMenu('parent',this,0)\"><option selected>Select Center</option>";
	foreach($daCode as $k=>$v){
	$con1=$file.$daCode[$v];
		if($daCode[$v]==$_SESSION['budget'][select]){$s="selected";}else{$s="value";}
			echo "<option $s='$con1'>$daCode[$v]-$daCenter[$v]\n";
		   }
	   echo "</select></td></form></tr>"; //echo "<pre>";print_r($_SESSION);echo "<pre>";//exit;
	  // }// end in_array
	 }// end $parkList
	 
*/ 
	 
?>	 