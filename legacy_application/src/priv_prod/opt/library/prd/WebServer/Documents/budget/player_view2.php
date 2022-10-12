<?php
extract($_REQUEST);
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
@mysql_select_db($database2) or die( "Unable to select database");

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
header("Location: budget.php?emid=$emid&ck=$ck&forum=blank&menu=mmc");

//echo "$salt";exit;
//if($level=='5' and $tempID !='Dodd3454'){include("menus3.php");}
//if($level=='5'){include("menus3.php");}

//echo "<h1>Home Page: Fiscal Year:$f_year</h1></div></body></html>";

       
?>	   
	   