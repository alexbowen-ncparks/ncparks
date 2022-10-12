<?php


session_start();

if(!$_SESSION["budget"]["tempID"]){echo "access denied";exit;
}

$active_file=$_SERVER['SCRIPT_NAME'];

$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempID=$_SESSION['budget']['tempID'];
$beacnum=$_SESSION['budget']['beacon_num'];
$concession_location=$_SESSION['budget']['select'];
$concession_center=$_SESSION['budget']['centerSess'];

extract($_REQUEST);
//echo "$player<br />";//exit;
//echo "$ck<br />";//exit;

$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
include("../../include/activity.php");// database connection parameters
//include("../budget/~f_year.php");
include("../budget/~f_year.php");

$table="rbh_multiyear_concession_fees3";

$query10="SELECT body_bgcolor,table_bgcolor,table_bgcolor2
from concessions_customformat
WHERE 1 
";
//echo "query10=$query10<br />";
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

//include("../budget/menu1314.php");

include("../../include/salt.inc"); // salt phrase
$ck_budD=md5($salt);
//echo "$ck_budS";echo "<br />";exit;
//echo "hello world";
//echo "$ck_budD";exit;


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

//echo "query5=$query5";//exit;

$result5 = mysqli_query($connection, $query5) or die ("Couldn't execute query 5. $query5");

$row5=mysqli_fetch_array($result5);

extract($row5);//brings back emid as $emid

//echo $emid;//exit;


include("../../include/salt.inc"); // salt phrase
//$emid=$player_view_menu;
$ck=md5($salt.$emid);
header("Location: budget.php?emid=$emid&ck=$ck&forum=blank");

//echo "$salt";exit;
//if($level=='5' and $tempID !='Dodd3454'){include("menus3.php");}
//if($level=='5'){include("menus3.php");}

//echo "<h1>Home Page: Fiscal Year:$f_year</h1></div></body></html>";

       
?>	   
	   