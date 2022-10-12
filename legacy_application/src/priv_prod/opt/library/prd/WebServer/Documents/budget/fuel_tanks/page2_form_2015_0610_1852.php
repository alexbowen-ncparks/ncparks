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

extract($_REQUEST);
//$deposit_id='104885853';

//echo "<pre>";print_r($_REQUEST);"</pre>";//exit;

//echo "<pre>";print_r($_SESSION);"</pre>";//exit;

if($tempid=='McGrath9695'){echo "tempid=$tempid<br />";}

$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/connectROOT.inc"); // connection parameters
mysql_select_db($database, $connection); // database
include("../../../include/activity.php");// database connection parameters
//include("../budget/~f_year.php");
include("../../budget/~f_year.php");


$query10="SELECT body_bgcolor,table_bgcolor,table_bgcolor2
from concessions_customformat
WHERE 1 
";

$result10=mysql_query($query10) or die ("Couldn't execute query 10. $query10");

$row10=mysql_fetch_array($result10);

extract($row10);

$body_bg=$body_bgcolor;
$table_bg=$table_bgcolor;
$table_bg2=$table_bgcolor2;

$query11="SELECT filegroup
from concessions_filegroup
WHERE 1 and filename='$active_file'
";

$result11=mysql_query($query11) or die ("Couldn't execute query 11. $query11");

$row11=mysql_fetch_array($result11);

extract($row11);
//echo "<br />";
//echo $filegroup;


echo "<html>";
echo "<head>
<title>MoneyTracker</title>";


//echo "<link rel='stylesheet' type='text/css' href='1533d.css' />";

echo "</head>";

//include("../../budget/menu1314.php");
include ("../../budget/menu1415_v1.php");
include("1418.html");
echo "<style>";
echo "input[type='text'] {width: 400px;}";

echo "</style>";


echo "<br />";



echo "<font color=blue size=5>";





$query1a="select first_name as 'cashier_first',nick_name as 'cashier_nick',last_name as 'cashier_last',count(id) as 'cashier_count'
          from cash_handling_roles
		  where park='$concession_location' and role='cashier' and tempid='$tempid' ";	 

$result1a = mysql_query($query1a) or die ("Couldn't execute query 1a.  $query1a");
		  
$row1a=mysql_fetch_array($result1a);

extract($row1a);

if($cashier_nick){$cashier_first=$cashier_nick;}			  
		  


$query1b="select first_name as 'manager_first',nick_name as 'manager_nick',last_name as 'manager_last',count(id) as 'manager_count'
          from cash_handling_roles
		  where park='$concession_location' and role='manager' and tempid='$tempid' ";	 

//if($beacnum=='60033148'){echo "query1b=$query1b";}		  
$result1b = mysql_query($query1b) or die ("Couldn't execute query 1b.  $query1b");
		  
$row1b=mysql_fetch_array($result1b);

extract($row1b);

if($manager_nick){$manager_first=$manager_nick;}	

 $query11e="select center_desc from center where parkcode='$concession_location'   ";	 
 
 
//echo "query1d=$query1d<br />";//exit;		  

$result11e = mysql_query($query11e) or die ("Couldn't execute query 11e.  $query11e");
		  
$row11e=mysql_fetch_array($result11e);

extract($row11e);



$center_location = str_replace("_", " ", $center_desc);
//echo "center location=$center_location";
 
 
 //echo "<div class='mc_header'>";
 /*
echo "<table align='center'><tr><th><img height='75' width='75' src='fala_fuel_tank.jpg' alt='picture of bank'></img></th><th><font color='blue'>MoneyCounts-$center_location</font></th></tr></table>";
*/
//echo "</div>";
 
 
echo "<br />";
//echo "<div id='body'>";
/*
echo "<div class='column1of4'>";
echo "<table><tr><th>Deposit</th><td><font color='blue'>  $controllers_next</font></td></tr></table>"; 
*/
//echo "<div class='column1of4'>";
//echo "<table><tr><th>Deposit<br /><font color='blue'>$controllers_next</font></th></tr></table>"; 

/*
if($cashier_count==1)
{

$query12="select id,location,cashier_amount as 'cash_amount' from fuel_tank_usage_detail
          where park='$parkcode' and fyear='$fyear' and cash_month='$cash_month'
          order by location ";
		  
		  
		  
$query12a="select authorized_match as 'authorized_match' from fuel_tank_usage
          where park='$parkcode' and fyear='$fyear' and cash_month='$cash_month' ";		  
		  
$result12a = mysql_query($query12a) or die ("Couldn't execute query 12a.  $query12a");
		  
$row12a=mysql_fetch_array($result12a);

extract($row12a);		  
		  
 
		  
}
 
 */ 
 
 
 
 /*
 if($manager_count==1)
{

$query12="select id,location,manager_amount as 'cash_amount' from fuel_tank_usage_detail
          where park='$parkcode' and fyear='$fyear' and cash_month='$cash_month'
          order by location ";
		  
		  
$query12a="select authorized_match as 'authorized_match' from fuel_tank_usage
          where park='$parkcode' and fyear='$fyear' and cash_month='$cash_month' ";		  
		  
$result12a = mysql_query($query12a) or die ("Couldn't execute query 12a.  $query12a");
		  
$row12a=mysql_fetch_array($result12a);

extract($row12a); 
		  
//echo "authorized_match=$authorized_match<br />";	

 
		  
}
 
 */	 
 
 
//echo "query12=$query12";
			
 //$result12 = mysql_query($query12) or die ("Couldn't execute query 12.  $query12 ");
 //$num12=mysql_num_rows($result12);

echo "<br />";


//echo "<div id='row2_col_1'; style='clear:both';'float:left';>"; 
//echo "<br /><br />";
//echo "<form>";

if($cashier_count==1)
{
//echo "<form method='post' autocomplete='off' action='cash_count_cashier_update.php'>";

echo "<table border=1 align='center'>";




echo "<tr><th colspan='2'><img height='75' width='75' src='fala_fuel_tank.jpg' alt='picture of bank'></img>Park Fuel Log for Motor Fleet Vehicles:&nbsp;$cash_month $cash_month_calyear</th></tr>";

	
echo "</table>";
echo "<br />";


include("head_steps.php");

}


if($manager_count==1)
{
//echo "<form method='post' autocomplete='off' action='cash_count_cashier_update.php'>";

echo "<table border=1 align='center'>";




echo "<tr><th colspan='2'><img height='75' width='75' src='fala_fuel_tank.jpg' alt='picture of bank'></img>Park Fuel Log for Motor Fleet Vehicles:&nbsp;$cash_month $cash_month_calyear</th></tr>";

	
echo "</table>";
echo "<br />";


include("head_steps.php");

}



/*
if($manager_count==1)
{
echo "<form method='post' autocomplete='off' action=''>";
echo "<table border=1>";



echo "<tr><th colspan='2'>Park Fuel for Motor Fleet Vehicles:&nbsp;$cash_month $cash_month_calyear</th></tr>";
echo "</table>";

echo "<table>";
echo "<tr><th>Manager: $manager_first $manager_last</th><td>Approved:<input type='checkbox' name='manager_approved' value='y'>";
echo "<input type='hidden' name='fyear' value='$fyear'>
<input type='hidden' name='cash_month' value='$cash_month'>
<input type='hidden' name='record_count' value='$num12'>";
if($authorized_match != 'y')
{
echo "<input type='submit' name='submit' value='Submit'>";
}
echo "</td>";
echo"</tr>";
echo "</form>";
}
*/

mysql_close();

echo "</body>";
echo "</html>";



?>