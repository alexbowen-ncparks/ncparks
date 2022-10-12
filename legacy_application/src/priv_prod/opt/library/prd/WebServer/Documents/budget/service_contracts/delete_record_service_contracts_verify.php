<?php

session_start();

$active_file=$_SERVER['SCRIPT_NAME'];

$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempid=$_SESSION['budget']['tempID'];
$beacnum=$_SESSION['budget']['beacon_num'];
$concession_location=$_SESSION['budget']['select'];
$concession_center=$_SESSION['budget']['centerSess'];
extract($_REQUEST);
//echo "tempid=$tempid";
/*
if($level=='5' and $tempID !='Dodd3454')
{
//echo "<pre>";print_r($_SERVER);"</pre>";//exit;
echo "<pre>";print_r($_SESSION);"</pre>";//exit;
//echo "<pre>";print_r($_REQUEST);"</pre>";exit;
}
*/
echo "<pre>";print_r($_REQUEST);"</pre>";  //exit;

$database="budget";
$db="budget";
//include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
//mysqli_select_db($connection, $database); // database
mysqli_select_db($connection,$database); // database
//include("../../../include/activity.php");// database connection parameters
include("../../../include/activity_new.php");// database connection parameters
//include("../budget/~f_year.php");
include("../../budget/~f_year.php");

//if($beacnum !="60032793" and $beacnum != '60033162'){echo "<font color='red' size='5'>Message:"; print_r($_SESSION['budget']['tempID']);echo " does not have access to this report</font>";exit;}
/*
if($level=='5' and $tempID !='Dodd3454')
{

echo "beacon_number:$beacnum";
echo "<br />";
echo "concession_location:$concession_location";
echo "<br />";
echo "concession_center:$concession_center";
echo "<br />";
}
*/

$query1="SELECT * from `budget_service_contracts`.`contracts` WHERE  `id`='$id' ";
$result1=mysqli_query($connection,$query1) or die ("Couldn't execute query 1. $query1");
echo "<br />query1=$query1<br /><br />";
$row1=mysqli_fetch_array($result1);
extract($row1);

//$query10="SELECT * from projects_customformat WHERE 1 and user_id='$myusername' ";
//$result10=mysqli_query($connection,$query10) or die ("Couldn't execute query 10. $query10");
//$row10=mysqli_fetch_array($result10);
//extract($row10);
//$body_bg=$body_bgcolor;



//echo "record_count=$num";//exit;

// frees the connection to MySQL

 //////mysql_close();





//echo 'project';

//echo $project_category; 

//exit;

echo "<html>";
echo "<head>";
echo "<title>Record_delete_verify</title>";
//include ("test_style.php");
//include ("test_style.php");
echo "</head>";

echo "<font color='red' size='5'><b>CAUTION! Are you sure you want to PERMANENTLY Delete Record ID-$id for Park-$park Vendor-$vendor</b></font>";
echo "<br /><br />";


echo "<form method=post action=service_contracts2.php>";
echo "<input type='hidden' name='park' value='$park'>";
echo "<input type='hidden' name='active' value='$active'>";
echo "<input type='submit' name='submit' value='NO-Return Home'>";
echo "</form>";

echo "<form method=post action=delete_record_service_contracts.php>";
echo "<input type='hidden' name='id' value='$id' >";
echo "<input type='hidden' name='park' value='$park' >";
//echo "<input type='hidden' name='parkS' value='$park' >";
echo "<input type='hidden' name='vendor' value='$vendor' >";
echo "<input type='hidden' name='active' value='$active' >";
echo "<input type='submit' name='submit' value='YES-DELETE Record ID'>";
echo "</form>";

//echo "<br />";





echo "</html>";

?>