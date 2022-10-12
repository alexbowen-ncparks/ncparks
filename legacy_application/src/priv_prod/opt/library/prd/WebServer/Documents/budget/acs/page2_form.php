<?php

session_start();
if(!$_SESSION["budget"]["tempID"]){echo "access denied";exit;
//header("location: https://10.35.152.9/login_form.php?db=budget");
}
$active_file=$_SERVER['SCRIPT_NAME'];

$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempid=$_SESSION['budget']['tempID'];
$beacnum=$_SESSION['budget']['beacon_num'];
$concession_location=$_SESSION['budget']['select'];
$concession_center=$_SESSION['budget']['centerSess'];

if($concession_location=='ADM'){$concession_location='ADMI';}

//$system_entry_date=date("Ymd");

extract($_REQUEST);

$system_entry_date=date("Ymd");
$today_date=$system_entry_date;
$today_date2=date('m-d-y', strtotime($today_date));
//$edit='y';
//$deposit_id='104885853';

//echo "<pre>";print_r($_REQUEST);"</pre>";//exit;

//echo "<pre>";print_r($_SESSION);"</pre>";  //exit;



$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
include("../../../include/activity.php");// database connection parameters
//include("../budget/~f_year.php");
include("../../budget/~f_year.php");


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

echo "</head>";

//include("../../budget/menu1314.php");

include ("../../budget/menu1415_v1.php");
include("1418.html");
echo "<style>";
echo "input[type='text'] {width: 200px;}";

echo "</style>";


echo "<br />";



//echo "<font color=blue size=5>";





$query1a="select first_name as 'cashier_first',nick_name as 'cashier_nick',last_name as 'cashier_last',count(id) as 'cashier_count'
          from cash_handling_roles
		  where park='$concession_location' and role='cashier' and tempid='$tempid' ";	 

//echo "query1a=$query1a<br /><br />";		  
		  
$result1a = mysqli_query($connection, $query1a) or die ("Couldn't execute query 1a.  $query1a");
		  
$row1a=mysqli_fetch_array($result1a);

extract($row1a);

if($cashier_nick){$cashier_first=$cashier_nick;}			  
		  
//if($concession_location=='CACR' and $tempid=='Schliebener'){$cashier_count=1; $cashier_first='Jessica'; $cashier_last='Schliebener';}

$query1b="select first_name as 'manager_first',nick_name as 'manager_nick',last_name as 'manager_last',count(id) as 'manager_count'
          from cash_handling_roles
		  where park='$concession_location' and role='manager' and tempid='$tempid' ";	

//echo "query1b=$query1b<br /><br />";		  

//if($beacnum=='60033148'){echo "query1b=$query1b";}		  
$result1b = mysqli_query($connection, $query1b) or die ("Couldn't execute query 1b.  $query1b");
		  
$row1b=mysqli_fetch_array($result1b);

extract($row1b);

if($manager_nick){$manager_first=$manager_nick;}	


$query1c="select first_name as 'fs_approver_first',nick_name as 'fs_approver_nick',last_name as 'fs_approver_last',count(id) as 'fs_approver_count'
          from cash_handling_roles
		  where park='$concession_location' and role='fs_approver' and tempid='$tempid' ";	

//echo "query1c=$query1c<br /><br />";		  

//if($beacnum=='60033148'){echo "query1b=$query1b";}		  
$result1c = mysqli_query($connection, $query1c) or die ("Couldn't execute query 1c.  $query1c");
		  
$row1c=mysqli_fetch_array($result1c);

extract($row1c);

if($fs_approver_nick){$fs_approver_first=$manager_nick;}	



 $query11e="select center_desc from center where parkcode='$concession_location'   ";	 
 
 
//echo "query1d=$query1d<br />";//exit;		  

$result11e = mysqli_query($connection, $query11e) or die ("Couldn't execute query 11e.  $query11e");
		  
$row11e=mysqli_fetch_array($result11e);

extract($row11e);



$center_location = str_replace("_", " ", $center_desc);
 
 
echo "<br />";

 
 

echo "<br />";
if($report_type==''){$report_type='form';}
if($report_type=='form'){$report_form="<img height='35' width='35' src='/budget/infotrack/icon_photos/green_checkmark1.png' alt='picture of green check mark'></img>";}
if($report_type=='reports'){$report_reports="<img height='35' width='35' src='/budget/infotrack/icon_photos/green_checkmark1.png' alt='picture of green check mark'></img>";}

echo "<style>
td {
    padding: 10px;
}

th {
    padding: 10px;
}



</style>";


if($cashier_count==1 or $manager_count==1 or $fs_approver_count==1)
{


//echo "<table border=1 align='center'>";
echo "<table align='center' border='1'>";

/*
echo "<tr><th colspan='2'><img height='75' width='75' src='fala_fuel_tank.jpg' alt='picture of bank'></img>Cash & Check Sales<br />$today_date</th></tr>";
*/
/*
echo "<tr><th><img height='75' width='75' src='fala_fuel_tank.jpg' alt='picture of bank'></img></th><th>Cash & Check Sales<br /><font color='red'>Undeposited Funds</font><br />$today_date2</th></tr>";
*/

//echo "<tr><th><img height='75' width='75' src='fala_fuel_tank.jpg' alt='picture of bank'></img></th><th>Cash & Check Sales NOT Deposited</th></tr>";
/*
echo "<tr><th><img height='75' width='75' src='bundle.gif' alt='picture of bank'></img></th><th>Cash & Check Sales NOT Deposited</th>
<th><iframe width='420' height='315' src='https://www.youtube.com/embed/SSR6ZzjDZ94' frameborder='0' allowfullscreen></iframe></th></tr>";
*/
	
echo "<tr><th><img height='75' width='125' src='credit_card2.jpg' alt='picture of credit card'></img><br />Procurement Card</th><th><a href='page2_form.php?step=1&edit=y&report_type=form'>Request Form<br />$report_form</a></th><th><a href='page2_form.php?step=1&edit=y&report_type=reports'>Request Status<br/>$report_reports</a></th>";


//echo "<iframe width='420' height='315' src='https://www.youtube.com/embed/SSR6ZzjDZ94' frameborder='0' allowfullscreen></iframe>";
//include("music_slideshow2.php");
//echo "</th>";
echo "</tr>";	
	
	
	
echo "</table>";
echo "<br />";
include("../../budget/menu1314_tony.html");

 if($beacnum=='60032793')
 {
 $pid='73';
 include("../../budget/infotrack/slide_toggle_procedures_module2_abstract.php");
 }
include("../../budget/infotrack/slide_toggle_procedures_module2_pid68.php");
//include("head_steps.php");
//include("fuel_tank_motor_fleet_log.php");



//if($report_type=='form')
//{
//echo "<form enctype='multipart/form-data' method='post' autocomplete='off' action='bank_deposit_slip_update.php'>";
echo "<form enctype='multipart/form-data' method='post' autocomplete='off' action=''>";
//echo "<tr><td>parkcode</td><td><input type='text' name='parkcode' value='$parkcodeACS' size='5'></tr>";
echo "<table align='center'><tr><th>admin</th><td><input type='text' name='admin' value='$parkcodeACS' size='5' autocomplete='off'></tr>";


	
	//echo "	<tr><td>admin</td><td><input type='text' name='admin' value='$admin' size='5'></td></tr>";
	//echo "<tr><th title='reg=1656 ci=1669'>location</th><td><input type='text' name='location' value='$location' size='5' autocomplete='off'></td></tr>";
	//echo "<tr><th>center</th><td><input type='text' name='center' value='$center' size='5' autocomplete='off'></td></tr>";	
	echo "<tr><th>last_name</th><td><input name=\"last_name\" type=\"text\" value=\"$last_name\" autocomplete='off'>
	</td></tr>";
	echo "<tr><th>first_name</th><td><input type='text' name='first_name' value='$first_name' autocomplete='off'></td></tr>";
	echo "<tr><th>job_title</th><td><input type='text' name='job_title' value='$job_title' size='10' autocomplete='off'></td></tr>";
	echo "<tr><th>phone_number</th><td><input type='text' name='phone_number' value='$phone_number' size='10' autocomplete='off'></td></tr>";
	echo "<tr><th>Justification</th><td><textarea name='justification' rows='5' cols='40'>$justification</textarea></td></tr>";
		
	echo "<tr><th>card_type</th><td><select name='card_type'>
  <option value=''></option>
  <option value='reg'>regular</option>
  <option value='ci'>capital_improvement</option>
 </select></td></tr>";	
 echo "<tr><th>Upload DNCR Form (PDF Only)</th><td><input type='file' id='document' name='document'><input type='hidden' name='content_mode' value='$content_mode' /><input type='hidden' name='MAX_FILE_SIZE' value='2000000'>
<input type='hidden' name='orms_deposit_id' value='$orms_deposit_id'>
<input type='hidden' name='id' value='$id'>
<input type='submit' name='submit' value='Submit'></td>";

	
	
	
	
	
	
	
	echo "</table>";
echo "</form>";


}

////mysql_close();

echo "</body>";
echo "</html>";



?>