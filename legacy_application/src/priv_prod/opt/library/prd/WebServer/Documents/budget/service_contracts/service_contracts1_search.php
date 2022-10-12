<?php
//if($level=="5" and $tempid !="Dodd3454"){echo "<pre>";print_r($_REQUEST);echo "</pre>";}//exit;
session_start();

if(!$_SESSION["budget"]["tempID"]){echo "access denied";exit;
//header("location: https://10.35.152.9/login_form.php?db=budget");
}

//echo "<pre>";print_r($_SESSION);echo "</pre>";exit;
//echo "<pre>";print_r($_REQUEST);echo "</pre>"; //exit;
$level=$_SESSION['budget']['level'];
$tempID=$_SESSION['budget']['tempID'];
$posTitle=$_SESSION['budget']['position'];
$beacon_num=$_SESSION['budget']['beacon_num'];
$pcode=$_SESSION['budget']['select'];
$centerSess=$_SESSION['budget']['centerSess'];
//echo $tempid;
extract($_REQUEST);
//$menu='SC1';
//echo "<pre>";print_r($_REQUEST);echo "</pre>"; //exit;
$database="budget";
$db="budget";
//include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
//mysqli_select_db($connection, $database); // database
mysqli_select_db($connection,$database); // database
include("../../../include/activity_new.php");// database connection parameters
include("../../budget/~f_year.php");


echo "<html>";
include("head1.php");
include ("../../budget/menu1415_v1_new.php");
echo "<br />";
$menu_sc='search';
//echo "<br />Line 82: menu_sc=$menu_sc<br />";
include("service_contracts_menu.php");
echo "<br />";
echo "<form enctype='multipart/form-data' method='post' autocomplete='off' action='service_contracts2.php'>";	
echo "<table border=1 align='center'>";

echo "<tr><th><font color='brown'>Park</font></th><td><input name='park' type='text' size='25' value='$park' id='park' autocomplete='off'></td></tr>";

if($active==''){$active='y';}
if($active=="n"){$ckN="checked";$ckY="";}else{$ckN="";$ckY="checked";}	
echo "<tr><th>Contract Active</th><th>N <input type='radio' name='active' value='n'$ckN><br />Y <input type='radio' name='active' value='y'$ckY></th></tr>";
/*
echo "<tr><th></th><th><input type=submit name=record_search submit value=search>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type=submit name=record_insert submit value=add></th></tr>";
*/
echo "<tr><th></th><th><input type=submit name=record_search submit value=search></th></tr>";



echo "</table>";	 

echo "</html>";
?>