<?php


session_start();
if(!$_SESSION["budget"]["tempID"]){echo "access denied";exit;
//header("location: /login_form.php?db=budget");
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

$database="fuel";
include("/opt/library/prd/WebServer/include/connectROOT.inc"); // connection parameters
mysql_select_db($database, $connection); // database
//include("../../../include/activity.php");// database connection parameters
//include("../budget/~f_year.php");

//include("../../budget/~f_year.php");

//$database2="fuel";
//mysql_connect($host,$username,$password);
//@mysql_select_db($database2) or die( "Unable to select database");
//echo "Budget Database";

/*
$query1="create database $db_backup";
$result1 = mysql_query($query1) or die ("Couldn't execute query 1.  $query1");
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


$query_tagN="SELECT license_plate as 'tag'
FROM mfm
where 1
and active='yes'
ORDER BY tag";





//echo "query_tagN=$query_tagN";


$result_tagN = mysql_query($query_tagN) or die ("Couldn't execute query_tagN. $query_tagN");
while ($row_tagN=mysql_fetch_array($result_tagN))
	{
	$tagArray[]=$row_tagN['tag'];
	}

array_push($tagArray,'pk4396');	
array_push($tagArray,'pj8274');	
array_push($tagArray,'pp1015');	

//sort($tagArray);

//echo "<pre>"; print_r($tagArray); echo "</pre>";//exit;	
	
//echo "<table align='center'><form action=\"current_year_budget_div1.php\">";

 // unset $tagArray[];

?>