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
//echo "<pre>";print_r($_REQUEST);"</pre>"; //exit;


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


/*
$query1="SELECT * from concessions_vendor_fees WHERE  id='$id' ";
$result1=mysqli_query($connection,$query1) or die ("Couldn't execute query 1. $query1");
$row1=mysqli_fetch_array($result1);
extract($row1);
*/



/*
$query2="SELECT * from projects_customformat WHERE 1 and user_id='$myusername' ";
$result2=mysqli_query($connection,$query2) or die ("Couldn't execute query 2. $query2");
$row2=mysqli_fetch_array($result2);
extract($row2);
$body_bg=$body_bgcolor;
*/


//echo "record_count=$num";//exit;

// frees the connection to MySQL

 //////mysql_close();





//echo 'project';

//echo $project_category; 

//exit;

echo "<html>";
echo "<head>";
echo "<title>Record_delete</title>";
//include ("test_style.php");
//include ("test_style.php");
echo "</head>";



//$query3="delete from service_contracts where id='$id' ";
//$query3="update service_contracts set active='d' where id='$id' ";
$query3="update `budget_service_contracts`.`contracts` set `active`='d' where `id`='$id' ";
mysqli_query($connection,$query3) or die ("couldn't execute query 3. $query3");

echo "<font color=red><b>Record ID-$id for park-$park vendor-$vendor has been successfully deleted</b></font>";
echo "</br> </br>";
echo "<a href='service_contracts2.php?park=$park&active=$active'>Return Home </a>";



?>

