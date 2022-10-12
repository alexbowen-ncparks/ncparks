<?php

session_start();

if(!$_SESSION["budget"]["tempID"]){echo "access denied";exit;
//header("location: https://legacypriv36.dev.dpr.ncparks.gov/login_form.php?db=budget");
}

//echo "<pre>";print_r($_REQUEST);"</pre>";//exit;

$active_file=$_SERVER['SCRIPT_NAME'];
$active_file_request=$_SERVER['REQUEST_URI'];

$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempID=$_SESSION['budget']['tempID'];
$beacnum=$_SESSION['budget']['beacon_num'];
$infotrack_location=$_SESSION['budget']['select'];
$infotrack_center=$_SESSION['budget']['centerSess'];
$pcode=$_SESSION['budget']['select'];

$tempID2=substr($tempID,0,-2);
if($tempID2=='Kno'){$tempID2='Knott';}
//echo "tempID2=$tempID2";

//echo "beacnum=$beacnum";

//echo "<pre>";print_r($_SERVER);"</pre>";

//echo "active_file=$active_file<br />";
//echo "active_file_request=$active_file_request<br />";


extract($_REQUEST);


//echo "<pre>";print_r($_SERVER);"</pre>";//exit;
//if($level=='5' and $tempID !='Dodd3454')
//echo "pcode=$pcode";
//echo "<pre>";print_r($_SESSION);"</pre>";//exit;
//echo "<pre>";print_r($_REQUEST);"</pre>";//exit;



$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters

mysqli_select_db($connection, $database); // database 

//include("../../../../include/activity.php");// database connection parameters

include("../../../include/activity.php");// database connection parameters

include ("test_style.php");
include ("test_style.css");
echo "<br />";
//include ("report_header3.php");

echo "<br />";



if($note_group=='web')
{
//echo "hello line 66<br />";
include("project1_menu_web.php");
}




echo "</body></html>";
 

?>
