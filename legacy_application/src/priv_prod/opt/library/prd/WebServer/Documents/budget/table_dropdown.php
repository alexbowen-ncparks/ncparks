<?php

session_start();

if(!$_SESSION["budget"]["tempID"]){echo "access denied";exit;
}


include("../../include/authBUDGET.inc"); // used to authenticate users
$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
//include("menu.php");
include("../../include/activity.php");
include("menus3_js.php");

//print_r($_SERVER);exit;
//$k=urldecode($_SERVER[QUERY_STRING]);
$level=$_SESSION[budget][level];
extract($_REQUEST);
unset($menuArray1);unset($menuArray2);

$sql="select * from table_menu order by table_name";
	$result = mysqli_query($connection, $sql) or die ("Couldn't execute query 1. $sql c=$connection d=$db $database");
	while ($row=mysqli_fetch_array($result))
		{
		$menuArray1[]=$row['menu_name'];
		$menuArray2[]=$row['table_name'];
		}
	
	echo "<td align='center'><a href='/abstract/abstract.php' target='_blank'>xcel2sql</a>
	<form><select name=\"dbTable\" onChange=\"MM_jumpMenu('parent',this,0)\"><option selected>Select Table</option>";
	for ($n=0;$n<count($menuArray2);$n++)
		{
		if(@$dbTable==$menuArray2[$n]){$s="selected";}else{$s="value";}
		$con=urlencode($menuArray2[$n]);
				echo "<option $s='/budget/portal.php?dbTable=$con'>$menuArray1[$n]\n";
			   }
	   echo "</select></form></td>";
	   
?>
	   