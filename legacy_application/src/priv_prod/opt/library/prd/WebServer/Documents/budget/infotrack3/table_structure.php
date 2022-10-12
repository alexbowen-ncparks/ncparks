<?php

session_start();
if(!$_SESSION["budget"]["tempID"]){echo "access denied";exit;
//header("location: https://legacypriv36.dev.dpr.ncparks.gov/login_form.php?db=budget");
}

$active_file=$_SERVER['SCRIPT_NAME'];

$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempID=$_SESSION['budget']['tempID'];
$beacnum=$_SESSION['budget']['beacon_num'];
$concession_location=$_SESSION['budget']['select'];
$concession_center=$_SESSION['budget']['centerSess'];

extract($_REQUEST);
if($level==1){$parkcode=$concession_location;}

//echo "<pre>";print_r($_SERVER);"</pre>";//exit;
//echo "<pre>";print_r($_SESSION);"</pre>";//exit;
//echo "<pre>";print_r($_REQUEST);"</pre>"; exit;

$database="budget";
$db="budget";
//$table="pcard_holders_dncr2";

include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database



include("style1.html");

$query_structure="show create table $table";
echo "<br />query_structure=$query_structure<br />"; exit;	
$result_structure = mysqli_query($connection, $query_structure) or die ("Couldn't execute query_structure.  $query_structure");		
$row_structure=mysqli_fetch_array($result_structure);

extract($row_structure);	
echo "<table><tr><td>TABLE Structure: $table</td></tr></table>";
echo "<table><tr><td>$Table</td><td>$Create Table</td></tr></table>";
		

?>
