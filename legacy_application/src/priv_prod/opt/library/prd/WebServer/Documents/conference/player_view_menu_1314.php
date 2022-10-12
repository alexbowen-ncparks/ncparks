<?php

session_start();

if(!$_SESSION["conference"]["tempID"]){echo "access denied";exit;
}

$level=$_SESSION['conference']['level'];
//$posTitle=$_SESSION['budget']['position'];
$tempid=$_SESSION['conference']['tempID'];
$beacnum=$_SESSION['conference']['beacon_num'];
$team=$_SESSION['conference']['select'];

extract($_REQUEST);
//echo "<pre>";print_r($_SESSION);echo "</pre>";exit;

/*
$database="conference";
$db="conference";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection,$database); // database
*/




include("../../include/salt.inc"); // salt phrase
$ck_budS=md5($salt);



/*
$database2="divper";
mysql_connect($host,$username,$password);
@mysql_select_db($database2) or die( "Unable to select database");
echo "MoneyCounts";
*/

$database="divper";
$db="divper";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection,$database); // database




/*
$query1="create database $db_backup";
$result1 = mysql_query($query1) or die ("Couldn't execute query 1.  $query1");
*/

$query5="SELECT emplist.tempID as 'player'
FROM emplist
where 1 and conference > '0'
ORDER BY emplist.tempID";

$result5 = mysqli_query($connection,$query5) or die ("Couldn't execute query 5. $query5");
while ($row5=mysqli_fetch_array($result5))
	{
	$tnArray[]=$row5['player'];
	}

//echo "<table align='center'><form action=\"current_year_budget_div1.php\">";
echo "<table><form action='player_view_1314.php' method='post' target='_blank'>";
echo "<tr>";
// Menu 000
echo "<td>Player: <select name=\"player\">"; 
for ($n=0;$n<count($tnArray);$n++){
$con=$tnArray[$n];
//if($player_view_menu==$con){$s="selected";}else{$s="value";}
$s="value";

		echo "<option $s='$con'>$tnArray[$n]</option>\n";
       }
   echo "</select></td>";   
  echo "<td><input type='submit' name='submit' value='Submit'></td>";
  echo "</tr>";
  echo "<input type='hidden' name='ck_budS' value='$ck_budS'>"; 
  
  
  echo "</form>"; 
 
echo "</table>"; 

$database="conference";
$db="conference";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection,$database); // database







?>