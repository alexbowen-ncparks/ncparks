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

extract($_REQUEST);
//$deposit_id='104885853';

//echo "<pre>";print_r($_REQUEST);"</pre>";//exit;

//echo "<pre>";print_r($_SESSION);"</pre>";//exit;

//if($tempid=='McGrath9695'){echo "tempid=$tempid<br />";}

$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
include("../../../include/activity.php");// database connection parameters
//include("../budget/~f_year.php");
include("../../budget/~f_year.php");



$table="pcard_users";

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


echo "<link rel='stylesheet' type='text/css' href='1533d.css' />";

echo "</head>";

include("../../budget/menu1314.php");
//include("1418.html");
//echo "<style>";
//echo "input[type='text'] {width: 400px;}";

//echo "</style>";


echo "<br />";



echo "<font color=blue size=5>";



/*

$query1a="select first_name as 'cashier_first',nick_name as 'cashier_nick',last_name as 'cashier_last',count(id) as 'cashier_count'
          from cash_handling_roles
		  where park='$concession_location' and role='cashier' and tempid='$tempid' ";	 

$result1a = mysqli_query($connection, $query1a) or die ("Couldn't execute query 1a.  $query1a");
		  
$row1a=mysqli_fetch_array($result1a);

extract($row1a);

if($cashier_nick){$cashier_first=$cashier_nick;}			  
*/		  


$query1b="select first_name as 'manager_first',nick_name as 'manager_nick',last_name as 'manager_last',count(id) as 'manager_count'
          from cash_handling_roles
		  where park='$concession_location' and role='manager' and tempid='$tempid' ";	 

//if($beacnum=='60033148'){echo "query1b=$query1b";}		  
$result1b = mysqli_query($connection, $query1b) or die ("Couldn't execute query 1b.  $query1b");
		  
$row1b=mysqli_fetch_array($result1b);

extract($row1b);

if($manager_nick){$manager_first=$manager_nick;}	

if($beacnum=='60032997')
{

echo "<div class='column1of4'>";

 
 

		  
		  
$query12a="select * from pcard_users where id='$id' ";		  
		  
$result12a = mysqli_query($connection, $query12a) or die ("Couldn't execute query 12a.  $query12a");
		  
$row12a=mysqli_fetch_array($result12a);

extract($row12a); 
		  
echo "id=$id<br />";		  
		  

 
 $query1b="select first_name as 'buof_first',nick_name as 'buof_nick',last_name as 'buof_last',count(id) as 'buof_count'
          from cash_handling_roles
		  where role='fs_approver' and tempid='$tempid' ";	 

//if($beacnum=='60033148'){echo "query1b=$query1b";}		  
$result1b = mysqli_query($connection, $query1b) or die ("Couldn't execute query 1b.  $query1b");
		  
$row1b=mysqli_fetch_array($result1b);

extract($row1b);
 
 
$manager2=substr($manager,0,-2);
		
		
	
echo "<td><font color='blue'>$bank_deposit_total</td></font></tr>";	

echo "</table>";




echo "<br />";

echo "<br />";

echo "<div id='row2_col_1'; style='clear:both';'float:left';>"; 



if($fs_approver=='')
{

echo "<table border='1' cellpadding='5' align='center' >";
echo "<tr><th>Cardholder</th><th>Justification</th><th>Manager<br />Approval</th></tr>";
/*
echo "<tr><td bgcolor='lightpink'>$first_name $middle_initial $last_name $suffix<br />Emp# $employee_number<br />Pos# $position_number<br />Title: $job_title<br />Phone# $phone_number<br />PCARD Quiz Score: $student_score<br >Manager Approval: $manager</td></tr>";
*/
echo "<tr><td>$first_name $middle_initial $last_name $suffix<br />Emp# $employee_number<br />Pos# $position_number<br />Title: $job_title<br />Phone# $phone_number</td><td>$justification_manager</td><td>$manager2</td></tr>";




echo "</table>";
echo "<br /><br />";
echo "<table align='center'><tr><td><font color='red'>Budget Office: Final Authorized Form sent to DNCR</td></td></tr></table>";
/*
echo "<table border='1' align='center'>";
echo "<form enctype='multipart/form-data' method='post' autocomplete='off' action='pcard_buof_approval_update.php'>";
//echo "<tr><th>PCARD# (Last 4 ONLY)</th><td><input type='text' size='5' name='card_number' value='$card_number'></td></tr>";
echo "<td>Final Completed Approved Form (PDF Only)<br /><input type='file' id='document' name='document'><input type='hidden' name='content_mode' value='$content_mode' /></td></tr>";
echo "<tr><th>Budget Office: $buof_first $buof_last</th><td> Approval:<input type='checkbox' name='buof_approved' value='y'>";
echo "<input type='hidden' name='fyear' value='$fyear'>
<input type='hidden' name='MAX_FILE_SIZE' value='2000000'>
<input type='hidden' name='id' value='$id'>
<input type='hidden' name='record_count' value='$num12'>";

echo "<input type='submit' name='submit' value='Submit'>";

echo "</td>";
echo"</tr>";
//echo "<tr><th>Manager: $manager</th><td>Approved:<input type='checkbox' name='manager_approved' value='y'>
echo "</form>";
echo "</table>";
*/

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



}

if($fs_approver!='')
{
echo "<table><tr><td>Budget Office: PCARD Received from DNCR and sent to Parks</td></tr></table>";


echo "</div>";
}

}

////mysql_close();





echo "</body>";
echo "</html>";



?>