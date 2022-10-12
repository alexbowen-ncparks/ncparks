<?php
//if($level=="5" and $tempid !="Dodd3454"){echo "<pre>";print_r($_REQUEST);echo "</pre>";}//exit;
session_start();

if(!$_SESSION["conference"]["tempID"]){echo "access denied";exit;
//header("location: https://auth.dpr.ncparks.gov/login_form.php?db=budget");
}
$level=$_SESSION['conference']['level'];
//$posTitle=$_SESSION['budget']['position'];
$tempid=$_SESSION['conference']['tempID'];
$beacnum=$_SESSION['conference']['beacon_num'];
$team=$_SESSION['conference']['select'];
//$playstation_center=$_SESSION['budget']['centerSess'];
//$pcode=$_SESSION['budget']['select'];

extract($_REQUEST);
$menu='SSPD1';

$database="conference";
$db="conference";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection,$database); // database



echo "<html>";
echo "<head>";
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
$( \"#datepicker2\" ).datepicker({dateFormat: 'yy-mm-dd'});
$( \"#datepicker3\" ).datepicker({dateFormat: 'yy-mm-dd'});
$( \"#datepicker4\" ).datepicker({dateFormat: 'yy-mm-dd'});
$( \"#datepicker5\" ).datepicker({dateFormat: 'yy-mm-dd'});
$( \"#datepicker6\" ).datepicker({dateFormat: 'yy-mm-dd'});
$( \"#datepicker7\" ).datepicker({dateFormat: 'yy-mm-dd'});
});
</script>";
echo "</head>";


//include("1418.html");
//echo "<style>";
//echo "input[type='text'] {width: 200px;}";

//echo "</style>";

//echo "<br />";

include("sspd_header1.php"); // connection parameters
//include("sspd_style1.php"); // connection parameters
//include("menu1415_v1_style_new.php"); // connection parameters
echo "<br />";
//include("service_contracts_menu.php");
include("sspd_menu.php");
include("sspd_menu2.php");
echo "<br />";


echo "</html>";
?>