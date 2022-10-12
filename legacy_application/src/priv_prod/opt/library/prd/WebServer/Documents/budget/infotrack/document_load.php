<?php

//echo "<pre>";print_r($_REQUEST);echo "</pre>";//exit;
session_start();

if(!$_SESSION["budget"]["tempID"]){echo "access denied";exit;}

$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempid=$_SESSION['budget']['tempID'];
extract($_REQUEST);
//echo "<pre>";print_r($_REQUEST);echo "</pre>"; exit;
//echo "<pre>";print_r($_SESSION);echo "</pre>";exit;
//$project_category='ITS';
//$project_name='wex_bill';
//$step_group='B';


$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
include("../../../include/activity.php");// database connection parameters
echo "<html>";
echo "<head>";

echo "</head>";

echo "<body>";

echo "<form enctype='multipart/form-data' method='post' action='document_load_update.php'>";


echo "<table align='center' border=1>";
 


echo "<tr><th><font color='brown'>Document Name</font></th><td><input type='text' name='report_name' autocomplete='off' value='$report_name'></td></tr>";            
echo "<tr>";
echo "<th><font color='brown'>Document Locate</font></th><td><input type='file' id='document' name='document'><input type='hidden' name='content_mode' value='$content_mode' /><input type='hidden' name='MAX_FILE_SIZE' value='2000000'><br /></td>";
echo "</tr>";

          
if($eid == '')
{         
echo "<tr><th colspan='2'><input type=submit name=submit value=Add></th></tr>";     
}
if($eid != '')
{         
echo "<tr><th colspan='2'><input type=submit name=submit value=Update></th></tr>";     
}


echo "</table>";


echo "<input type='hidden' name='park' value='$park'>";
echo "<input type='hidden' name='center' value='$center'>";
echo "<input type='hidden' name='company' value='$company'>";
echo "<input type='hidden' name='ncas_account' value='$ncas_account'>";
echo "<input type='hidden' name='scid' value='$scid'>";
echo "<input type='hidden' name='eid' value='$eid'>";

echo "</form>";



echo "</body></html>";

?>

























