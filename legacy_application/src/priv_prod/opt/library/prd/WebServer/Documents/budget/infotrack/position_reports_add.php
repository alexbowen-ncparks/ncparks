<?php

session_start();

if(!$_SESSION["budget"]["tempID"]){echo "access denied";exit;
//header("location: https://legacypriv36.dev.dpr.ncparks.gov/login_form.php?db=budget");
}

//$file = "articles_menu.php";
//$lines = count(file($file));


//$table="infotrack_projects";
//echo "<pre>";print_r($_REQUEST);"</pre>"; exit;
/*
$active_file=$_SERVER['SCRIPT_NAME'];
$active_file_request=$_SERVER['REQUEST_URI'];

$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempID=$_SESSION['budget']['tempID'];
*/
$beacnum=$_SESSION['budget']['beacon_num'];
/*
$infotrack_location=$_SESSION['budget']['select'];
$infotrack_center=$_SESSION['budget']['centerSess'];
$pcode=$_SESSION['budget']['select'];

$tempID2=substr($tempID,0,-2);
*/
extract($_REQUEST);
$beacnum=$_SESSION['budget']['beacon_num'];
$center_code=$_SESSION['budget']['select'];
if($center_code=='ADM'){$center_code='ADMI' ;}


//echo "<pre>";print_r($_SERVER);"</pre>";//exit;
//if($level=='5' and $tempID !='Dodd3454')
//echo "pcode=$pcode";
//echo "<pre>";print_r($_SESSION);"</pre>";//exit;
//echo "<pre>";print_r($_REQUEST);"</pre>";exit;

$tempID=$_SESSION['budget']['tempID'];
//echo "tempID=$tempID<br />"; exit;

//include("../../../include/connectBUDGET.inc");// database connection parameters
//include("../../../include/activity.php");// database connection parameters
//include("../budget/~f_year.php");
//include("../../budget/~f_year.php");

$today=date("Ymd");

$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database 
//echo "add=$add<br />";
//echo "beacnum=$beacnum<br />";
//echo "report_id=$report_id<br />";
//exit;

if($add=='y')
{

//if($beacnum=='60032793'){

$query6="update position_report_users
         set downloaded='y',download_date='$today',tempid='$tempID',center_code='$center_code'
		 where report_id='$report_id'
		 and beacnum='$beacnum' ";
//echo "query6=$query6";exit;
$result6 = mysqli_query($connection, $query6) or die ("Couldn't execute query 6.  $query6");

//}


;}

header("location: position_reports.php?DL=y&report_ck_id=$report_id");
















?>
