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

//echo $concession_location;


//echo "<pre>";print_r($_SERVER);"</pre>";//exit;
//echo "<pre>";print_r($_SESSION);"</pre>"; //exit;
//echo "<pre>";print_r($_REQUEST);"</pre>";//exit;

//echo "<pre>";print_r($_SESSION);"</pre>";//exit;

$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
include("../../../include/activity.php");// database connection parameters
//include("../budget/~f_year.php");
include("../../budget/~f_year.php");

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

	  
$result1b = mysqli_query($connection, $query1b) or die ("Couldn't execute query 1b.  $query1b");
		  
$row1b=mysqli_fetch_array($result1b);

extract($row1b);
echo "Line 59: manager_count=$manager_count<br />"; //exit;

if($manager_nick){$manager_first=$manager_nick;}	

$query1c="select first_name as 'fs_approver_first',nick_name as 'fs_approver_nick',last_name as 'fs_approver_last',count(id) as 'fs_approver_count'
          from cash_handling_roles
		  where park='admi' and role='fs_approver' and tempid='$tempid' ";	 

$result1c = mysqli_query($connection, $query1c) or die ("Couldn't execute query 1c.  $query1c");
		  
$row1c=mysqli_fetch_array($result1c);

echo "Line 71: query1c=$query1c<br />";

extract($row1c);
echo "<html>";
echo "</body>";

if($cashier_count==1)
{
echo "<form enctype='multipart/form-data' method='post' autocomplete='off' action='crs_deposits_cashier_deposit_update.php'>";




echo "<table border=1>";
     
	   echo "<tr>";
	   
	     
	   echo "<th>Deposit Slip<input type='file' id='document' name='document'><input type='hidden' name='content_mode' value='$content_mode' /><input type='hidden' name='MAX_FILE_SIZE' value='2000000'><br /><font color='blue'>Amount must equal $bank_deposit_total</font></th>";	   
	    echo "</tr>";
	  
	   	   echo "</table>";

}

if($cashier_count==1)
{
echo "<table>";
echo "<tr><th>Cashier: $cashier_first $cashier_last</th><td>Approved:<input type='checkbox' name='cashier_approved' value='y' >";
echo "<input type='hidden' name='checks' value='$check'>
<input type='hidden' name='orms_deposit_id' value='$deposit_id'>
<input type='hidden' name='rcf_amount' value='$rcf_amount'>
<input type='hidden' name='rcf' value='$rcf'>
<input type='hidden' name='crs_park' value='$crs_park'>
<input type='hidden' name='controllers_next' value='$controllers_next'>";
echo "<input type='submit' name='submit' value='Submit'></tr>";
//echo "<tr><th>Manager: $manager</th><td>Approved:<input type='checkbox' name='manager_approved' value='y'>
echo "</form>";
}
echo "Line 110: manager_count=$manager_count<br />"; //exit;
if($manager_count==1)
{
echo "Line 113: manager_count=$manager_count<br />"; //exit;
$query1c="select cashier from crs_tdrr_division_deposits
          where park='$concession_location' and orms_deposit_id='$deposit_id' ";
		  
		  
//echo "query1c=$query1c<br />";//exit;		  
		  
		  
$result1c = mysqli_query($connection, $query1c) or die ("Couldn't execute query 1c.  $query1c");
		  
$row1c=mysqli_fetch_array($result1c);

extract($row1c);		  
$cashier='Ake2721';
		  
if($cashier)

{  


$query1d="select 
          cash_handling_roles.first_name as 'cashier_first',
		  cash_handling_roles.nick_name as 'cashier_nick',
		  cash_handling_roles.last_name as 'cashier_last'
		  from cash_handling_roles
		  where park='$concession_location' and role='cashier' and tempid='$cashier' ";	

//echo "query1d=$query1d<br />";//exit;		  

$result1d = mysqli_query($connection, $query1d) or die ("Couldn't execute query 1d.  $query1d");
		  
$row1d=mysqli_fetch_array($result1d);

extract($row1d);
if($cashier_nick){$cashier_first=$cashier_nick;}	

$query1d="select 
          cash_handling_roles.first_name as 'cashier_first',
		  cash_handling_roles.nick_name as 'cashier_nick',
		  cash_handling_roles.last_name as 'cashier_last'
		  from cash_handling_roles
		  where park='$concession_location' and role='cashier' and tempid='$cashier' ";	

//echo "query1d=$query1d<br />";//exit;		  

$result1d = mysqli_query($connection, $query1d) or die ("Couldn't execute query 1d.  $query1d");
		  
$row1d=mysqli_fetch_array($result1d);

extract($row1d);




echo "<form method='post' autocomplete='off' action='crs_deposits_manager_deposit_update.php'>";
// 1/4/2016: Comments required for all PASU's if Over/short is more than $10
//if($beacnum=='60033087')
{

$query12_a="select sum(amount) as 'over_short_amount' from crs_tdrr_division_history_parks
            where deposit_id='$deposit_id'
            and ncas_account='000437995' ";
		 
//echo "query12_a=$query12_a<br />";		 

$result12_a = mysqli_query($connection, $query12_a) or die ("Couldn't execute query 12_a.  $query12_a");

$row12_a=mysqli_fetch_array($result12_a);
extract($row12_a);
if($over_short_amount==''){$over_short_amount='0';}
//echo "over_short_amount=$over_short_amount<br />";


}
echo "<table>";
echo "<tr><th>Cashier: $cashier_first $cashier_last</th><td><img height='25' width='25' src='/budget/infotrack/icon_photos/green_checkmark1.png' alt='picture of green check mark'></img></td></tr>";




echo "<tr><th>Manager: $manager_first $manager_last</th><td>Approved:<input type='checkbox' name='manager_approved' value='y'>";
//echo "<input type='hidden' name='checks' value='$check'>";
echo "<input type='hidden' name='orms_deposit_id' value='$deposit_id'>";
//echo "<input type='hidden' name='controllers_next' value='$controllers_next'>";
echo "<input type='submit' name='submit' value='Submit'></tr>";
echo "</table>";
echo "</form>";

}
}

echo "Line 204: fs_approver_count=$fs_approver_count<br />";
if($fs_approver_count==1)
{



$concession_location=$park_fs_approver;


$query1c="select cashier from crs_tdrr_division_deposits
          where park='$concession_location' and orms_deposit_id='$deposit_id' ";
		  
		  
//echo "query1c=$query1c<br />";//exit;		  
		  
		  
$result1c = mysqli_query($connection, $query1c) or die ("Couldn't execute query 1c.  $query1c");
		  
$row1c=mysqli_fetch_array($result1c);

extract($row1c);		  
		  

$query1d="select 
          cash_handling_roles.first_name as 'cashier_first',
		  cash_handling_roles.nick_name as 'cashier_nick',
		  cash_handling_roles.last_name as 'cashier_last'
		  from cash_handling_roles
		  left join crs_tdrr_division_deposits on cash_handling_roles.park=crs_tdrr_division_deposits.park
		  where crs_tdrr_division_deposits.orms_deposit_id='$deposit_id' 
		  and crs_tdrr_division_deposits.cashier=cash_handling_roles.tempid ";	

//echo "query1d=$query1d<br />";//exit;		  

$result1d = mysqli_query($connection, $query1d) or die ("Couldn't execute query 1d.  $query1d");
		  
$row1d=mysqli_fetch_array($result1d);

extract($row1d);
if($cashier_nick){$cashier_first=$cashier_nick;}	


$query1e="select 
          cash_handling_roles.first_name as 'manager_first',
		  cash_handling_roles.nick_name as 'manager_nick',
		  cash_handling_roles.last_name as 'manager_last'
		  from cash_handling_roles
		  left join crs_tdrr_division_deposits on cash_handling_roles.park=crs_tdrr_division_deposits.park
		  where crs_tdrr_division_deposits.orms_deposit_id='$deposit_id' 
		  and crs_tdrr_division_deposits.manager=cash_handling_roles.tempid ";	

//echo "query1e=$query1e<br />";//exit;		  

$result1e = mysqli_query($connection, $query1e) or die ("Couldn't execute query 1e.  $query1e");
		  
$row1e=mysqli_fetch_array($result1e);

extract($row1e);
if($cashier_nick){$cashier_first=$cashier_nick;}



echo "<form method='post' autocomplete='off' action='crs_deposits_fs_approver_deposit_update.php'>";


echo "<table>";
echo "<tr><th>Cashier: $cashier_first $cashier_last</th><td><img height='25' width='25' src='/budget/infotrack/icon_photos/green_checkmark1.png' alt='picture of green check mark'></img></td></tr>";

echo "<tr><th>Manager: $manager_first $manager_last</th><td><img height='25' width='25' src='/budget/infotrack/icon_photos/green_checkmark1.png' alt='picture of green check mark'></img></td></tr>";


echo "<tr><th>FS Approver: $fs_approver_first $fs_approver_last</th><td>Approved:<input type='checkbox' name='fs_approver_approved' value='y'></td>";
//echo "<input type='hidden' name='checks' value='$check'>";
echo "<input type='hidden' name='orms_deposit_id' value='$deposit_id'>";
//echo "<input type='hidden' name='controllers_next' value='$controllers_next'>";
echo "<td><input type='submit' name='submit' value='Submit'></td></tr>";
echo "</table>";
echo "</form>";


}





////mysql_close();




echo "</body>";
echo "</html>";



?>