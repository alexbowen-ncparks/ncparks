<?php

session_start();

$active_file=$_SERVER['SCRIPT_NAME'];

$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempid=$_SESSION['budget']['tempID'];
$beacnum=$_SESSION['budget']['beacon_num'];
$concession_location=$_SESSION['budget']['select'];
$concession_center=$_SESSION['budget']['centerSess'];
$concession_center_L3=substr($concession_center,-3);
$first_fyear_deposit=$concession_center_L3.'001';
//echo "concession_center_L3=$concession_center_L3<br />";//exit;
//echo "first_fyear_deposit=$first_fyear_deposit";//exit;


extract($_REQUEST);

//echo "<pre>";print_r($_SESSION);"</pre>";//exit;
//echo "<pre>";print_r($_REQUEST);"</pre>"; exit;


/*

$rc_total=array_sum($rc_amount);
*/


$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
include("../../../include/activity.php");// database connection parameters

/*
$query11a="select first_name as 'cashier_first',nick_name as 'cashier_nick',last_name as 'cashier_last',count(id) as 'cashier_count'
          from cash_handling_roles
		  where park='$concession_location' and role='cashier' and tempid='$tempid' ";	 

$result11a = mysqli_query($connection, $query11a) or die ("Couldn't execute query 11a.  $query11a");
		  
$row11a=mysqli_fetch_array($result11a);

extract($row11a);

if($cashier_nick){$cashier_first=$cashier_nick;}			  
		  



if($cashier_count==1)
{

$checknum0=$checknum[0]; //echo "checknum0=$checknum0<br />";
$payor0=$payor[0]; //echo "payor0=$payor0<br />";
$payor_bank0=$payor_bank[0]; //echo "payor0=$payor0<br />";
//echo "payor_bank0=$payor_bank0<br />";exit;
$ck_amount0=$ck_amount[0]; //echo "ck_amount0=$ck_amount0<br />";
$description0=$description[0]; //echo "description0=$description0<br />";

$ck_count=count($checknum); //echo "ck_count=$ck_count<br />";//exit;



$source_table="crs_tdrr_division_deposits";



if($rcf=='y')//{echo "rcf=y";}else {echo "rcf not equal y";} exit;
{echo "Contact Tony P Bass";exit;}


$query11a1="select cashier,controllers_deposit_id from crs_tdrr_division_deposits
            where orms_deposit_id='$orms_deposit_id' ";	 

$result11a1 = mysqli_query($connection, $query11a1) or die ("Couldn't execute query 11a1.  $query11a1");
		  
$row11a1=mysqli_fetch_array($result11a1);

extract($row11a1);

if($controllers_deposit_id != '')
{

$cashier2=substr($cashier,0,-4);

echo "<font color='brown' size='5'><b>Oops! Cashier Form for Bank Deposit# $controllers_deposit_id already completed by $cashier2 </b></font><br />";exit;
}

if($bank_deposit_date==""){echo "<font color='brown' size='5'><b>Bank Deposit Date Missing<br /><br />Click the BACK button on your Browser to enter Bank Deposit Date</b></font><br />";exit;}

define('PROJECTS_UPLOADPATH','documents_bank_deposits/');
$document=$_FILES['document']['name'];

$document_format2=substr($document, -3);

if($document_format2=='jpg' or $document_format2=='JPG'){$format_ok='y';} else {$format_ok='n';}

if($document==""){echo "<font color='brown' size='5'><b>No Document Found. <br /><br />Please hit back button on Browser to Upload Document</b></font>";exit;}

if($format_ok=='n'){echo "<font color='brown' size='5'><b>Filetype is NOT in JPG Format. Please Upload a JPG File. <br /><br />Please hit back button on Browser to Upload JPG File</b></font>";exit;}



if($checks=='yes' and $checknum0==''){echo "<font color='brown' size='5'><b> Please fill out check listing</b></font>";exit;}



if($cashier_approved==""){echo "<font color='brown' size='5'><b>Cashier Approval missing<br /><br />Click the BACK button on your Browser to enter Cashier Approval</b></font><br />";exit;}





$entered_by=$tempid;

$cashier=$entered_by;








$query11a2="SELECT f_year as 'current_fyear' from crs_tdrr_division_deposits
            where orms_deposit_id='$orms_deposit_id' ";
		 
 

$result11a2 = mysqli_query($connection, $query11a2) or die ("Couldn't execute query 11a2.  $query11a2");

$row11a2=mysqli_fetch_array($result11a2);
extract($row11a2);


$query11a3="SELECT count(f_year) as 'current_fyear_count' from crs_tdrr_division_deposits
            where park='$concession_location' and f_year='$current_fyear' and cashier != '' ";
		 
	 

$result11a3 = mysqli_query($connection, $query11a3) or die ("Couldn't execute query 11a3.  $query11a3");

$row11a3=mysqli_fetch_array($result11a3);
extract($row11a3);


if($current_fyear_count == 0){$controllers_next=$first_fyear_deposit;}


if($current_fyear_count != 0)

{
$query11b="SELECT max(controllers_deposit_id) as 'controllers_max' FROM crs_tdrr_division_deposits where park='$concession_location'
and f_year='$current_fyear' ";




$result11b = mysqli_query($connection, $query11b) or die ("Couldn't execute query 11b.  $query11b");
$row11b=mysqli_fetch_array($result11b);
extract($row11b);

$controllers_next=$controllers_max+1;



}

*/
$entered_by=$tempid;

$sed=date("Ymd");

//if($justification_manager==""){echo "<font color='brown' size='5'><b>Justification missing<br /><br />Click the BACK button on your Browser to enter Justification</b></font><br />";exit;}

if($employee_approval_type==""){echo "<font color='brown' size='5'><b>employee approval type missing<br /><br />Click the BACK button on your Browser to enter employee approval type</b></font><br />";exit;}


if($manager_approved==""){echo "<font color='brown' size='5'><b>Manager Approval missing<br /><br />Click the BACK button on your Browser to enter Manager Approval</b></font><br />";exit;}





if($manager_approved=='y' and $employee_approval_type=='other')
{
	
if($employee_approval_type=='other' and $justification_manager=='')
{

include("../../budget/menu1314_tony.html");	
$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
$query12a="select * from pcard_users where id='$id' ";		
echo "query12a=$query12a<br />";  
		  
$result12a = mysqli_query($connection, $query12a) or die ("Couldn't execute query 12a.  $query12a");
		  
$row12a=mysqli_fetch_array($result12a);

extract($row12a); 
echo "<form method='post' autocomplete='off' action='pcard_manager_approval_update.php'>";
$report_type='reports';
if($report_type=='reports'){$report_reports="<img height='35' width='35' src='/budget/infotrack/icon_photos/green_checkmark1.png' alt='picture of green check mark'></img>";}

echo "<table align='center' border='1'>";


	
echo "<tr>";
echo "<th><img height='75' width='125' src='credit_card2.jpg' alt='picture of credit card'></img><br />Procurement Card</th>";

//echo "<th><a href='pcard_request1.php?step=1&edit=y&report_type=form'>Request Form<br />$report_form</a></th>";

echo "<th>Request Status<br/>$report_reports</th>";


//echo "<iframe width='420' height='315' src='https://www.youtube.com/embed/SSR6ZzjDZ94' frameborder='0' allowfullscreen></iframe>";
//include("music_slideshow2.php");
//echo "</th>";
echo "</tr>";	
	
	
	
echo "</table>";
echo "<br />";
echo "<table align='center'>";

echo "<tr><th colspan='2'>PCARD Approval for Employee:<br /><font color='red'>NON-Park Employee Justification</font></th></tr>";
/*
echo "<tr><td bgcolor='lightpink'>$first_name $middle_initial $last_name $suffix<br />Emp# $employee_number<br />Pos# $position_number<br />Title: $job_title<br />Phone# $phone_number<br />PCARD Quiz Score: $student_score</td></tr>";
*/

echo "<tr><td bgcolor='lightpink'>$first_name $middle_initial $last_name $suffix<br />Emp# $employee_number<br />Pos# $position_number<br />Title: $job_title<br />Phone# $phone_number</td></tr>";





echo "<tr><th>Manager $manager_first $manager_last Justification: <textarea name='justification_manager' rows='5' cols='40'>$justification_manager</textarea></th></tr>";	
echo "<tr>";
echo "<td align='left'>";
echo "Approval for Employee PCARD:<input type='checkbox' name='manager_approved' value='y'>";
echo "<input type='hidden' name='fyear' value='$fyear'>
<input type='hidden' name='id' value='$id'>
<input type='hidden' name='employee_approval_type' value='other'>
<input type='hidden' name='record_count' value='$num12'>
<input type='submit' name='submit' value='Submit'>";
echo "</form>";
echo "</td>";
echo "</form>";
echo "</table>";

	
exit;}	


if($employee_approval_type=='other' and $justification_manager!='')
{

$query1="update pcard_users set manager='$entered_by',manager_date='$sed',employee_approval_type='$employee_approval_type'
         where id='$id' ";  

  
  
 echo "query1=$query1<br />"; 
		 
$result1 = mysqli_query($connection, $query1) or die ("Couldn't execute query 1.  $query1");	

//$justification_manager2=stripslashes($justification_manager);

$query2="update pcard_users
         set pcard_users.justification_manager='$justification_manager'
         where pcard_users.id='$id' ";  

  
  
  
 echo "query2=$query2<br />";  
		 
$result2 = mysqli_query($connection, $query2) or die ("Couldn't execute query 2.  $query2");



//exit;


}






}

	
if($manager_approved=='y' and $employee_approval_type!='other')
{	
$query1="update pcard_users set manager='$entered_by',manager_date='$sed',employee_approval_type='$employee_approval_type'
         where id='$id' ";  

  
		 
$result1 = mysqli_query($connection, $query1) or die ("Couldn't execute query 1.  $query1");	



$query2="update pcard_users,pcard_users_justification
         set pcard_users.justification_manager=pcard_users_justification.justification
         where pcard_users.employee_approval_type=pcard_users_justification.job_title
		 and pcard_users.id='$id' ";  

  
		 
$result2 = mysqli_query($connection, $query2) or die ("Couldn't execute query 2.  $query2");	




}


{header("location: pcard_request4.php?menu=RCard ");}



?>