<?php
include("menu_js.php");
//$parkList=explode(",",@$_SESSION['budget']['accessPark']);// set in budget.php from db divper.emplist
echo "<table>";
echo "<tr>";
//print_r($parkList);
//if($parkList[0]!="")
//	{
//	$multipark_access='y';
	//if($report==2){exit;}
//	include("../../../include/connectBUDGET.inc");// database connection parameters
	foreach($parkList as $k=>$v){
	$sql="SELECT new_center as 'center',parkCode from center where parkCode='$v' and (new_center like '1680%') ";
	//echo "<br />line 118:sql=$sql<br />";
	$result = mysqli_query($connection, $sql) or die ("Couldn't execute query 1. $sql");
	$row=mysqli_fetch_array($result);
	$daCode[$v]=$v;$daCenter[$v]=$row['center'];
	}
	
	
	$file0="/budget/menu1314.php";
	$file=$file0."?passParkcode=";
	if(@$passParkcode==""){$passParkcode=$_SESSION['budget']['select'];
	}
	else{
		$parkcode=$passParkcode;
		$_SESSION['budget']['centerSess_new']=$daCenter[$passParkcode]; //$forum='blank';
		$_SESSION['budget']['select']=$daCode[$passParkcode];
		$query10="SELECT center.old_center
		          from center where parkcode='$parkcode' and fund='1280' ";

//echo "query10=$query10";

$result10=mysqli_query($connection, $query10) or die ("Couldn't execute query 10. $query10");

$row10=mysqli_fetch_array($result10);

extract($row10);
		$_SESSION['budget']['centerSess']=$old_center;
		//echo "<pre>";print_r($_SESSION);echo "</pre>";//exit;
		
		}
		
		echo "<th><form><select name=\"center\" onChange=\"MM_jumpMenu('parent',this,0)\"><option selected>Select Center</option>";
	foreach($daCode as $k=>$v){
	$con1=$file.$daCode[$v];
		if($daCode[$v]==$_SESSION['budget']['select']){$s="selected";}else{$s="value";}
			echo "<option $s='$con1'>$daCode[$v]-$daCenter[$v]\n";
		   }
	   echo "</select></th></form></tr>"; //echo "<pre>";print_r($_SESSION);echo "<pre>";//exit;
	  // }// end in_array
	 
echo "</table>";	

$concession_location=$_SESSION['budget']['select'];
$concession_center=$_SESSION['budget']['centerSess'];
$concession_center_new=$_SESSION['budget']['centerSess_new'];

//}// end $parkList
 
?>