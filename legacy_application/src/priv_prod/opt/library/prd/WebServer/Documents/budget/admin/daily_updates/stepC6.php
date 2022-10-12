<?php

session_start();
if(!$_SESSION["budget"]["tempID"]){echo "access denied";exit;
//header("location: https://legacypriv36.dev.dpr.ncparks.gov/login_form.php?db=budget");
}
$active_file=$_SERVER['SCRIPT_NAME'];

$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempid=$_SESSION['budget']['tempID'];
$beacnum=$_SESSION['budget']['beacon_num'];
$concession_location=$_SESSION['budget']['select'];
$concession_center=$_SESSION['budget']['centerSess'];
//if($concession_center== '12802953'){$concession_center='12802751' ;}
//echo "concession_center=$concession_center";exit;
//echo "concession_location=$concession_location";exit;
//echo "concession_location=$concession_location";
//echo "concession_center=$concession_center";
extract($_REQUEST);
$todays_date=date("Y-m-d");
//echo $concession_location;
/*
if($level=='5' and $tempID !='Dodd3454')
{
//echo "<pre>";print_r($_SERVER);"</pre>";//exit;
echo "<pre>";print_r($_SESSION);"</pre>";//exit;
//echo "<pre>";print_r($_REQUEST);"</pre>";exit;
}
*/
//echo "<pre>";print_r($_SESSION);"</pre>";//exit;

$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
include("../../../../include/activity.php");// database connection parameters
//include("../budget/~f_year.php");
include("../../../budget/~f_year.php");


$query25="update project_steps_detail set status='complete' where project_category='fms'
         and project_name='daily_updates' and step_group='C' and step_num='6'  ";
mysqli_query($connection, $query25) or die ("Couldn't execute query 25.  $query25");


$query26="update project_steps set status='complete' where project_category='fms'
         and project_name='daily_updates' and step_group='C'   ";
mysqli_query($connection, $query26) or die ("Couldn't execute query 26.  $query26");






//header("location: step_group.php?project_category=fms&project_name=daily_updates&step_group=C ");

//header("location: /budget/infotrack/scrolling_headline.php");
header("location: /budget/headlines_view.php");





//header("location: scoreG9_1516.php");



?>



