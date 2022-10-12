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

$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
include("../../../include/activity.php");// database connection parameters
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





$query1="SELECT *

from concessions_vendor_fees

WHERE  id='$id'

";

$result1=mysqli_query($connection, $query1) or die ("Couldn't execute query 1. $query1");



$row1=mysqli_fetch_array($result1);



extract($row1);



$query10="SELECT *

from projects_customformat

WHERE 1 and user_id='$myusername'

";



$result10=mysqli_query($connection, $query10) or die ("Couldn't execute query 10. $query10");



$row10=mysqli_fetch_array($result10);



extract($row10);



$body_bg=$body_bgcolor;



//echo "record_count=$num";//exit;

// frees the connection to MySQL

 //////mysql_close();





//echo 'project';

//echo $project_category; 

//exit;

echo "<html>";

echo "<head>

<title>Record_delete_verify</title>";



//include ("test_style.php");

include ("test_style.php");



echo "</head>";





echo "<font color='red' size='3'><b>CAUTION! Are you sure you want to PERMANENTLY Delete Record ID-$id for $vendor_name-$fee_amount</b></font>";

echo "<br /><br />";







echo "<form method=post action=vendor_fees_drilldown1.php?vendor_name=$vendor_name&f_year=$f_year&park=$park>";

//echo "<input type='hidden' name='project_note_id' value='$project_note_id'>";

//echo "<input type='hidden' name='project_category' value='$project_category'>";

//echo "<input type='hidden' name='project_name' value='$project_name'>";

	   

echo "<input type='submit' name='submit' value='NO-Return Home'>";



echo "</form>";



echo "<form method=post action=delete_record_concessions_vendor_fees.php>";

echo "<input type='hidden' name='id' value='$id' >";



	   

echo "<input type='submit' name='submit' value='YES-DELETE Record ID'>";

echo "</form>";

//echo "<br />";





echo "</html>";

?>