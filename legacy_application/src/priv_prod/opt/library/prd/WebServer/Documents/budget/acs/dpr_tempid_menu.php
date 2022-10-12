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



$query_tempidN="
SELECT concat(emplist.tempid,'*',emplist.beacon_num) as 'tempid_name'
 FROM divper.emplist
 left join divper.position on divper.emplist.beacon_num=position.beacon_num
 WHERE emplist.currpark='$concession_location' 
 and position.postitle_reg not like '%superin%'
 order by emplist.tempid
 ";





//echo "query_tempidN=$query_tempidN";


$result_tempidN = mysqli_query($connection, $query_tempidN) or die ("Couldn't execute query_tempidN. $query_tempidN");
while ($row_tempidN=mysqli_fetch_array($result_tempidN))
	{
	$tempidArray[]=$row_tempidN['tempid_name'];
	}

//array_push($tagArray,'pk4396');	

//sort($tagArray);

//echo "<pre>"; print_r($tempidArray); echo "</pre>"; //exit;	
	
//echo "<table align='center'><form action=\"current_year_budget_div1.php\">";

 // unset $tagArray[];

