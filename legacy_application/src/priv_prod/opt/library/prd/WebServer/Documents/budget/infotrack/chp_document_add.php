<?php
//echo "<pre>";print_r($_REQUEST);echo "</pre>";//exit;
session_start();
//echo "<pre>";print_r($_SESSION);echo "</pre>";//exit;
$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempid=$_SESSION['budget']['tempID'];
//echo $tempid;
extract($_REQUEST);

//$report_date="2011-01-21";
//$admin_num="foma";
//$report_date=str_replace("-","",$report_date);
//echo "<pre>";print_r($_REQUEST);"</pre>";exit;

$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
include("../../../include/activity.php");// database connection parameters
//include("../budget/~f_year.php");
include("../../budget/~f_year.php");
//echo "submit1=$submit1";echo "submit2=$submit2";exit;
echo "<html>";
echo "<head>
<style>
body { background-color: #FFF8DC; }
table { background-color: #FFF8DC; font-color: blue; font-size: 15;}
TH{font-family: Arial; font-size: 15pt;}
TD{font-family: Arial; font-size: 15pt;}
input{style=font-family: Arial; font-size:14.0pt}
</style>

</head>";

echo "<h1><font color='green'>ADD Document</font></h1>";
echo "<table><tr><td>Step1</td><td>";
echo "<form enctype='multipart/form-data' method='post' action='chp_document_add2.php'>";
echo "<input type='hidden' name='MAX_FILE_SIZE' value='20000000'>";
echo "<input type='file' id='document' name='document'>";
echo "<input type='hidden' name='chp_id' value='$chp_id'>";
echo "<input type='hidden' name='source_id' value='$chpd_id'>";
echo "</td></tr>";
echo "<tr><td>Step2</td><td>";
echo "<input type='submit' value='add_document' name='submit'>";
echo "</td></tr>";
echo "</form>";
echo "</body>";



?>

























