<?php
session_start();

if(!$_SESSION["budget"]["tempID"]){echo "access denied";exit;
//header("location: /login_form.php?db=budget");
//header("location: /login_form.php?db=budget");
}
//echo "<pre>";print_r($_SESSION);"</pre>";  //exit;
$tempid_original=$_SESSION['budget']['tempID'];
//echo "<br />Line 9: tempid_original=$tempid_original<br />";

extract($_REQUEST);

//echo "<pre>";print_r($_REQUEST);"</pre>";  exit;

//echo "$player<br />";//exit;
//echo "$ck<br />";exit;

include("../../include/salt.inc"); // salt phrase
$ck_budD=md5($salt);
//echo "$ck_budS";echo "<br />";
//echo "hello world";
//echo "$ck_budD";


if($ck_budS != $ck_budD){echo "Access denied";exit;}
//echo "Welcome";

$database2="divper";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
//include("../../include/activity.php");// database connection parameters
//include("../budget/~f_year.php");
include("~f_year.php");
////mysql_connect($host,$username,$password);
@mysqli_select_db($connection, $database2) or die( "Unable to select database");

$query5="SELECT emid
FROM emplist
where tempID='$player' ";

$result5 = mysqli_query($connection, $query5) or die ("Couldn't execute query 5. $query5");

$row5=mysqli_fetch_array($result5);

extract($row5);//brings back emid as $emid

//echo $emid;exit;


include("../../include/salt.inc"); // salt phrase
//$emid=$player_view_menu;
$ck=md5($salt.$emid);
//echo "<br />tempid_original=$tempid_original<br />"; exit;
// 10/07/22 Cole Goodnight added tempID to the header to allow for logging in as another user by tempID instead of emid
header("Location: budget.php?tempID=$player&emid=$emid&ck=$ck&tempid_original=$tempid_original&forum=blank");

//echo "$salt";exit;
//if($level=='5' and $tempID !='Dodd3454'){include("menus3.php");}
//if($level=='5'){include("menus3.php");}

//echo "<h1>Home Page: Fiscal Year:$f_year</h1></div></body></html>";

       
?>	   
	   
