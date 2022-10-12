<?php

session_start();
if(!$_SESSION["budget"]["tempID"]){echo "access denied";exit;
//header("location: /login_form.php?db=budget");
}
$active_file=$_SERVER['SCRIPT_NAME'];

$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempid=$_SESSION['budget']['tempID'];
$beacnum=$_SESSION['budget']['beacon_num'];
$concession_location=$_SESSION['budget']['select'];
$concession_center=$_SESSION['budget']['centerSess'];
//Enable North District OA Cara Hadfield to approved cash receipt journals for N. District
//$beacnum 60033148=cara hadfield position

//if($concession_center== '12802953'){$concession_center='12802751' ;}
//echo "concession_center=$concession_center";exit;
//echo "concession_location=$concession_location";exit;
//echo "concession_location=$concession_location";
//echo "concession_center=$concession_center";
extract($_REQUEST);

//echo $concession_location;


//echo "<pre>";print_r($_SERVER);"</pre>";//exit;
//echo "<pre>";print_r($_SESSION);"</pre>"; //exit;
//echo "<pre>";print_r($_REQUEST);"</pre>";//exit;

//echo "<pre>";print_r($_SESSION);"</pre>";//exit;

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
$table="bank_deposits_menu";

$query10="SELECT body_bgcolor,table_bgcolor,table_bgcolor2
from concessions_customformat
WHERE 1 
";

$result10=mysqli_query($connection, $query10) or die ("Couldn't execute query 10. $query10");

$row10=mysqli_fetch_array($result10);

extract($row10);

$body_bg=$body_bgcolor;
$table_bg=$table_bgcolor;
$table_bg2=$table_bgcolor2;

$query11="SELECT filegroup
from concessions_filegroup
WHERE 1 and filename='$active_file'
";

$result11=mysqli_query($connection, $query11) or die ("Couldn't execute query 11. $query11");

$row11=mysqli_fetch_array($result11);

extract($row11);
//echo "<br />";
//echo $filegroup;


echo "<html>";
echo "<head>
<title>MoneyTracker</title>";

//include ("test_style.php");
//include ("test_style_deposit_form.php");
echo "<link rel=\"stylesheet\" href=\"/js/jquery_1.10.3/jquery-ui.css\" />
<script src=\"/js/jquery_1.10.3/jquery-1.9.1.js\"></script>
<script src=\"/js/jquery_1.10.3/jquery-ui.js\"></script>
<link rel=\"stylesheet\" href=\"/resources/demos/style.css\" />";
//echo "<link rel=\"stylesheet\" href=\"test_style_1657.css\" />";
echo "<link rel='stylesheet' type='text/css' href='1533d.css' />";

echo "
<script>
$(function() {
$( \"#datepicker\" ).datepicker({dateFormat: 'yy-mm-dd'});
});
</script>";
echo "</head>";

include("../../../budget/menu1314.php");
include("1418.html");


echo "<form enctype='multipart/form-data' method='post' autocomplete='off' action=''>";



echo "<table border=1>";
       //echo "<form name='form1' method='post' action='duplicate_notes_insert.php'>";
	   //echo "<tr><th><font color='blue'>Field</font></th><th>Value</th></tr>";
	   echo "<tr>";
	 
	   
	   echo "<th>bank deposit date<br /><input name='bank_deposit_date' type='text' id='datepicker' size='15'></th>";	   
	   //echo "<th>deposit amount<br /><input name='bank_deposit_ type='text'</th>";	   
	   echo "<th>Deposit Slip<input type='file' id='document' name='document'><input type='hidden' name='content_mode' value='$content_mode' /><input type='hidden' name='MAX_FILE_SIZE' value='2000000'><br /><font color='blue'>Amount must equal $bank_deposit_total</font></th>";	   
	   //echo "<th>Cashier<br /> <font color='blue'>$cashier</font></th>";
	   //echo "<th>Manager<br /> <font color='blue'>$manager</font></th>";
	   echo "</tr>";
	  
	   	   echo "</table>";
		   
echo "</form>";		   





echo "</body>";
echo "</html>";



?>