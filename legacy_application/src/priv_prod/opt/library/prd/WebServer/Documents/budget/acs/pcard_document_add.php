<?php
//echo "<pre>";print_r($_REQUEST);echo "</pre>";//exit;
session_start();
//echo "<pre>";print_r($_SESSION);echo "</pre>";exit;
$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempid=$_SESSION['budget']['tempID'];
$tempid_pcard=$tempid;
//echo $tempid;
extract($_REQUEST);

//$report_date="2011-01-21";
//$admin_num="foma";
//$report_date=str_replace("-","",$report_date);
//echo "<pre>";print_r($_REQUEST);"</pre>"; exit;

$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
include("../../../include/activity.php");// database connection parameters
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


echo "<h1>ADD Document</h1>";
echo "<form enctype='multipart/form-data' method='post' action='pcard_document_add2.php'>";
echo "<input type='hidden' name='MAX_FILE_SIZE' value='20000000'>";
echo "<input type='file' id='document' name='document'>";
echo "<input type='hidden' name='id' value='$id'>";
echo "<input type='hidden' name='report_date' value='$report_date'>";
echo "<input type='hidden' name='admin_num' value='$admin_num'>";
echo "<input type='hidden' name='load_one' value='$load_one'>";
echo "<input type='hidden' name='xtnd_start' value='$xtnd_start'>";
echo "<input type='hidden' name='xtnd_end' value='$xtnd_end'>";
echo "<input type='hidden' name='travel' value='$travel'>";
echo "<input type='hidden' name='budget_office' value='$budget_office'>";

echo "<br /> <br />";
echo "<input type='submit' value='add_document' name='submit'>";
echo "</form>";
echo "</body>";



?>