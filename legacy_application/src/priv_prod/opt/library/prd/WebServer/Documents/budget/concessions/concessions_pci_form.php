<?php

session_start();
if(!$_SESSION["budget"]["tempID"]){echo "access denied";exit;
//header("location: /login_form.php?db=budget");
}
$active_file=$_SERVER['SCRIPT_NAME'];

$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempid=$_SESSION['budget']['tempID'];
$tempID=$_SESSION['budget']['tempID'];
$beacnum=$_SESSION['budget']['beacon_num'];
$concession_location=$_SESSION['budget']['select'];
$concession_center=$_SESSION['budget']['centerSess'];

extract($_REQUEST);
//$deposit_id='104885853';

//echo "<pre>";print_r($_REQUEST);"</pre>";//exit;

//echo "<pre>";print_r($_SESSION);"</pre>"; //exit;

//if($tempid=='McGrath9695'){echo "tempid=$tempid<br />";}

$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
include("../../../include/activity.php");// database connection parameters
//include("../budget/~f_year.php");
include("../../budget/~f_year.php");

/*
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
*/
//echo "<br />";
//echo $filegroup;


//echo "<html>";
//echo "<head>
//<title>MoneyTracker</title>";
/*
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
*/

//echo "<link rel='stylesheet' type='text/css' href='1533d.css' />";

//echo "</head>";

//include("../../budget/menu1314.php");
include ("../../budget/menu1415_v1.php");
//include ("concessions_pci_menu.php");

//include("concessions1_instructions.php");
//include("concessions_pci_instructions.php");
//include ("concessions_pci_fyear.php");
//include("1418.html");
/*
echo "<style>";
echo "input[type='text'] {width: 200px;}";

echo "</style>";


echo "<br />";



echo "<font color=blue size=5>";
*/




$query1a="select first_name as 'cashier_first',nick_name as 'cashier_nick',last_name as 'cashier_last',count(id) as 'cashier_count'
          from cash_handling_roles
		  where park='$concession_location' and role='cashier' and tempid='$tempid' ";	 

$result1a = mysqli_query($connection, $query1a) or die ("Couldn't execute query 1a.  $query1a");
		  
$row1a=mysqli_fetch_array($result1a);

extract($row1a);

if($cashier_nick){$cashier_first=$cashier_nick;}			  
		  


$query1b="select first_name as 'manager_first',nick_name as 'manager_nick',last_name as 'manager_last',count(id) as 'manager_count'
          from cash_handling_roles
		  where park='$concession_location' and role='manager' and tempid='$tempid' ";	 

//if($beacnum=='60033148'){echo "query1b=$query1b";}		  
$result1b = mysqli_query($connection, $query1b) or die ("Couldn't execute query 1b.  $query1b");
		  
$row1b=mysqli_fetch_array($result1b);

extract($row1b);

if($manager_nick){$manager_first=$manager_nick;}	

 $query11e="select center_desc from center where parkcode='$concession_location'   ";	 
 
 
//echo "query1d=$query1d<br />";//exit;		  

$result11e = mysqli_query($connection, $query11e) or die ("Couldn't execute query 11e.  $query11e");
		  
$row11e=mysqli_fetch_array($result11e);

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
		  
$result12a = mysqli_query($connection, $query12a) or die ("Couldn't execute query 12a.  $query12a");
		  
$row12a=mysqli_fetch_array($result12a);

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
		  
$result12a = mysqli_query($connection, $query12a) or die ("Couldn't execute query 12a.  $query12a");
		  
$row12a=mysqli_fetch_array($result12a);

extract($row12a); 
		  
//echo "authorized_match=$authorized_match<br />";	

 
		  
}
 
 */	 
 
 
//echo "query12=$query12";
			
 //$result12 = mysqli_query($connection, $query12) or die ("Couldn't execute query 12.  $query12 ");
 //$num12=mysqli_num_rows($result12);

echo "<br />";


//echo "<div id='row2_col_1'; style='clear:both';'float:left';>"; 
//echo "<br /><br />";
//echo "<form>";

if($cashier_count==1)
{
//echo "<form method='post' autocomplete='off' action='cash_count_cashier_update.php'>";

echo "<table border=1 align='center'>";

$query8a="select text_code from svg_graphics where id='2'  ";
		 
//echo "query8a=$query8a<br />";		 

$result8a = mysqli_query($connection, $query8a) or die ("Couldn't execute query 8a.  $query8a");

$row8a=mysqli_fetch_array($result8a);
extract($row8a);	



echo "<table border=1 align='center'>";

//echo "<tr><th colspan='2'><img height='50' width='100' src='/budget/infotrack/icon_photos/mission_icon_photos_251.png' alt='picture of pci'></img>PCI Compliance:&nbsp;$cash_month $cash_month_calyear</th></tr>";



echo "<tr><th colspan='2'>$text_code<br />PCI Compliance:&nbsp;$cash_month $cash_month_calyear</th></tr>";

/*
echo "<tr><th colspan='2'><img height='75' width='75' src='fala_fuel_tank.jpg' alt='picture of bank'></img>PCI Compliance:&nbsp;$cash_month $cash_month_calyear</th></tr>";
*/

	
echo "</table>";
echo "<br />";

//echo "<form enctype='multipart/form-data' method='post' autocomplete='off' action='invoice_upload.php'>";
echo "<form enctype='multipart/form-data' method='post' autocomplete='off' action='concessions_pci_upload.php'>";
  


echo "<table border='3' align='center'>";
     
	   echo "<tr>";
	   
	   
	   
	   //echo "<tr><td><font color='brown'>(A)</font></td><td><font color='brown'>Locate last invoice for fuel</font></td></tr>";
	  // echo "<tr><td><font color='brown' class='cartRow2'>Enter Cost per gallon from last fuel invoice</font><input name='cost_per_gallon' type='text'  size='15'><br />(Example: 2.6530)</td></tr>";	   
	   //echo "<th>deposit amount<br /><input name='bank_deposit_ type='text'</th>";	   
	   echo "<tr><td><font color='brown' class='cartRow2'>Upload PCI Compliance Form (PDF Format)</font><input type='file' id='document' name='document'><input type='hidden' name='content_mode' value='$content_mode' /><input type='hidden' name='MAX_FILE_SIZE' value='2000000'></td>";	   
	   
	   echo "</tr>";
	   echo "<tr><td><font color='brown' class='cartRow2'>Click Submit</font><input type='submit' name='submit' value='Submit'></td></tr>";
	   //echo "<tr><th></th></tr>";
	  
	   	   echo "</table>";

echo "<input type='hidden' name='parkcode' value='$parkcode'>";
echo "<input type='hidden' name='cash_month' value='$cash_month'>";
echo "<input type='hidden' name='fyear' value='$fyear'>";
echo "<input type='hidden' name='cash_month_calyear' value='$cash_month_calyear'>";


echo "</form>";
//include("head_steps.php");

}


if($manager_count==1)
{
//echo "<form method='post' autocomplete='off' action='cash_count_cashier_update.php'>";

$query8a="select text_code from svg_graphics where id='2'  ";
		 
//echo "query8a=$query8a<br />";		 

$result8a = mysqli_query($connection, $query8a) or die ("Couldn't execute query 8a.  $query8a");

$row8a=mysqli_fetch_array($result8a);
extract($row8a);	



echo "<table border=1 align='center'>";

//echo "<tr><th colspan='2'><img height='50' width='100' src='/budget/infotrack/icon_photos/mission_icon_photos_251.png' alt='picture of pci'></img>PCI Compliance:&nbsp;$cash_month $cash_month_calyear</th></tr>";



echo "<tr><th colspan='2'>$text_code<br />PCI Compliance:&nbsp;$cash_month $cash_month_calyear</th></tr>";

	
echo "</table>";
echo "<br />";
/*
$query1a="select first_name as 'cashier_first',nick_name as 'cashier_nick',last_name as 'cashier_last',count(id) as 'cashier_count'
          from cash_handling_roles
		  where tempid='$cashier' ";	

echo "query1a=$query1a";		  

$result1a = mysqli_query($connection, $query1a) or die ("Couldn't execute query 1a.  $query1a");
		  
$row1a=mysqli_fetch_array($result1a);

extract($row1a);
*/


//echo "<form method='post' autocomplete='off' action='fuel_log_approval.php'>";
echo "<form method='post' autocomplete='off' action='concessions_pci_approval.php'>";


echo "<table align='center'>";
/*
echo "<tr><th>Cashier: $cashier_first $cashier_last</th><td><img height='25' width='25' src='/budget/infotrack/icon_photos/green_checkmark1.png' alt='picture of green check mark'></img></td></tr>";
*/


echo "<tr><th>Manager: $manager_first $manager_last</th><td>Approved:<input type='checkbox' name='manager_approved' value='y'>";

echo "<input type='hidden' name='parkcode' value='$parkcode'>
<input type='hidden' name='cash_month' value='$cash_month'>
<input type='hidden' name='cash_month_calyear' value='$cash_month_calyear'>
<input type='hidden' name='fyear' value='$fyear'>
<input type='hidden' name='role' value='manager'>
<input type='submit' name='submit' value='Submit'></td></tr>";


echo "</table>";
echo "</form>";

//include("head_steps.php");

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

//////mysql_close();

echo "</body>";
echo "</html>";



?>