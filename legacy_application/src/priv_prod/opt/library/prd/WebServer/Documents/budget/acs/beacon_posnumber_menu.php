<?php


session_start();
if(!$_SESSION["budget"]["tempID"]){echo "access denied";exit;
//header("location: https://legacypriv36.dev.dpr.ncparks.gov/login_form.php?db=budget");
}

/*
$active_file=$_SERVER['SCRIPT_NAME'];

$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempID=$_SESSION['budget']['tempID'];
$beacnum=$_SESSION['budget']['beacon_num'];
$concession_location=$_SESSION['budget']['select'];
$concession_center=$_SESSION['budget']['centerSess'];



extract($_REQUEST);
*/

$database="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
//include("../../../include/activity.php");// database connection parameters
//include("../budget/~f_year.php");

//include("../../budget/~f_year.php");



$query_positionN="
SELECT concat(beacon_num,'*',postitle) as 'position_name'
 FROM divper.position WHERE park='chro' 
 and postitle_reg not like '%super%' 
";





echo "query_positionN=$query_positionN";


$result_positionN = mysqli_query($connection, $query_positionN) or die ("Couldn't execute query_positionN. $query_positionN");
while ($row_positionN=mysqli_fetch_array($result_positionN))
	{
	$positionArray[]=$row_positionN['position_name'];
	}

//array_push($tagArray,'pk4396');	

//sort($tagArray);

echo "<pre>"; print_r($positionArray); echo "</pre>"; //exit;	
	
//echo "<table align='center'><form action=\"current_year_budget_div1.php\">";

 // unset $tagArray[];

