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

//$database2="fuel";
//////mysql_connect($host,$username,$password);
//@mysql_select_db($database2) or die( "Unable to select database");
//echo "Budget Database";

/*
$query1="create database $db_backup";
$result1 = mysqli_query($connection, $query1) or die ("Couldn't execute query 1.  $query1");
*/

//

/*
$query_tagN="SELECT vehicle.license as 'tag'
FROM vehicle
where 1
and center_code='$concession_location'
ORDER BY tag";
*/

/*
$query_tagN="SELECT vehicle.license as 'tag'
FROM vehicle
where 1
and center_code='lawa'
ORDER BY tag";
*/

if($concession_location=='ADM'){$concession_location='ADMI';}

/*
$query_centerN="
SELECT DISTINCT center_name AS  'center_name'
FROM crs_centers
WHERE 1 
AND active =  'y'
ORDER BY center_description
";
*/


$query_centerN="
SELECT center,center_name AS  'center_name'
FROM crs_centers
WHERE 1 
AND active =  'y'
ORDER BY center
";



//echo "query_centerN=$query_centerN<br /><br />";


//echo "query_tagN=$query_tagN";


$result_centerN = mysqli_query($connection, $query_centerN) or die ("Couldn't execute query_centerN. $query_centerN");
while ($row_centerN=mysqli_fetch_array($result_centerN))
	{
	$centerArray[]=$row_centerN['center_name'];
	}

//array_push($tagArray,'pk4396');	

//sort($tagArray);

//echo "<pre>"; print_r($tagArray); echo "</pre>";//exit;	
	
//echo "<table align='center'><form action=\"current_year_budget_div1.php\">";

 // unset $tagArray[];

