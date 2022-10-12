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


//echo "<link rel='stylesheet' type='text/css' href='1533d.css' />";

//echo "</head>";

//include("../../budget/menu1314.php");
//include ("../../budget/menu1415_v1.php");
//include("1418.html");
echo "<script language='JavaScript'>

function confirmLink()
{
 bConfirm=confirm('Are you sure you want to delete this score?')
 return (bConfirm);
}

function confirmLink2()
{
 bConfirm=confirm('Are you sure you want to approve this score?')
 return (bConfirm);
}


";
echo "</script>";


//echo "<br />";

echo "</head>";
include("../../budget/menu1314_tony.html");
include ("../../budget/menu1415_v1.php");
include("1418.html");
echo "<style>";
echo "input[type='text'] {width: 200px;}";

echo "</style>";
//echo "</head>";
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

//echo "query1b=$query1b"; 
$result1b = mysqli_query($connection, $query1b) or die ("Couldn't execute query 1b.  $query1b");
		  
$row1b=mysqli_fetch_array($result1b);

extract($row1b);

if($manager_nick){$manager_first=$manager_nick;}	


/*
$query1c="select first_name as 'fs_approver_first',nick_name as 'fs_approver_nick',last_name as 'fs_approver_last',count(id) as 'fs_approver_count'
          from cash_handling_roles
		  where park='admi' and role='fs_approver' and tempid='$tempid' ";	 

$result1c = mysqli_query($connection, $query1c) or die ("Couldn't execute query 1c.  $query1c");
		  
$row1c=mysqli_fetch_array($result1c);

extract($row1c);


if($fs_approver_count==1)
{

$query1b="select park as 'park_fs_approver'
          from crs_tdrr_division_deposits
		  where orms_deposit_id='$deposit_id' ";	

//echo "query1d=$query1d<br />";//exit;		  

$result1b = mysqli_query($connection, $query1b) or die ("Couldn't execute query 1b.  $query1b");
		  
$row1b=mysqli_fetch_array($result1b);

extract($row1b);


}
		  
*/		  
/*
if($manager_count==1)
{

echo "<table border=1>";
      
	   echo "<tr>";
	   
	   
	   $query1e="select bank_deposit_date from crs_tdrr_division_deposits
	             where orms_deposit_id='$deposit_id'     ";	

//echo "query1d=$query1d<br />";//exit;		  

$result1e = mysqli_query($connection, $query1e) or die ("Couldn't execute query 1e.  $query1e");
		  
$row1e=mysqli_fetch_array($result1e);

extract($row1e);
$bank_deposit_date2=date('m-d-y', strtotime($bank_deposit_date));	   
	   
	  
	   echo "</tr>";
	   
	   	   echo "</table>";
}		   

*/



 /*
 if($fs_approver_count==1)
 {
 $query11e="select center_desc from center where parkcode='$park_fs_approver'   ";	
 }
 else
 {
 $query11e="select center_desc from center where parkcode='$concession_location'   ";	 
 }
 
 
 
 
//echo "query1d=$query1d<br />";//exit;		  

$result11e = mysqli_query($connection, $query11e) or die ("Couldn't execute query 11e.  $query11e");
		  
$row11e=mysqli_fetch_array($result11e);

extract($row11e);



$center_location = str_replace("_", " ", $center_desc);
//echo "center location=$center_location";
 
 
 echo "<div class='mc_header'>";
echo "<table><tr><th><img height='50' width='50' src='/budget/infotrack/icon_photos/bank.jpg' alt='picture of bank'></img></th><th><font color='blue'>MoneyCounts-$center_location</font></th></tr></table>";
echo "</div>";
 
 
 
 
 
 
 
 
 
 
//$result11=mysqli_query($connection, $query11) or die ("Couldn't execute query 11. $query11");

//$row11=mysqli_fetch_array($result11);

//extract($row11);
echo "<br />";
//echo "<div id='body'>";
/*
echo "<div class='column1of4'>";
echo "<table><tr><th>Deposit</th><td><font color='blue'>  $controllers_next</font></td></tr></table>"; 
*/
echo "<div class='column1of4'>";
//echo "<table><tr><th>Deposit<br /><font color='blue'>$controllers_next</font></th></tr></table>"; 
/*
if($cashier_count==1)
{
$query12="select id,location,cashier_amount as 'cash_amount' from cash_imprest_location_counts
          where park='$parkcode' and fyear='$fyear' and cash_month='$cash_month'
          order by location ";
		  
		  
		  
$query12a="select authorized_match as 'authorized_match' from cash_imprest_count_detail
          where park='$parkcode' and fyear='$fyear' and cash_month='$cash_month' ";		  
		  
$result12a = mysqli_query($connection, $query12a) or die ("Couldn't execute query 12a.  $query12a");
		  
$row12a=mysqli_fetch_array($result12a);

extract($row12a);		  
		  
//echo "authorized_match=$authorized_match<br />";		  
		  
}
 */
 
 if($manager_count==1)
{

		  
		  
$query12a="select * from pcard_users where id='$id' ";		
//echo "query12a=$query12a<br />";  
		  
$result12a = mysqli_query($connection, $query12a) or die ("Couldn't execute query 12a.  $query12a");
		  
$row12a=mysqli_fetch_array($result12a);

extract($row12a); 

$pcard_holder_admin=strtolower($admin);

//echo "pcard_holder_admin=$pcard_holder_admin<br />";
		  
//echo "id=$id<br />";		  
		  
}
 
 
 
 
//echo "query12=$query12";
			
 //$result12 = mysqli_query($connection, $query12) or die ("Couldn't execute query 12.  $query12 ");
 //$num12=mysqli_num_rows($result12);
/*
echo "<table border=1>";


echo "<tr><th colspan='2'>Imprest Cash Count:&nbsp;$cash_month $cash_month_calyear</th></tr>";
while ($row12=mysqli_fetch_array($result12))
	{

	// The extract function automatically creates individual variables from the array $row
	//These individual variables are the names of the fields queried from MySQL
	extract($row12);
	

		echo "<tr$t>"; 
		//echo "<td>$rank</td>";
		//echo "<td>$parkcode</td>";			
		//echo "<td>$company</td>";
		//echo "<td>$ncas_account</td>";
		//echo "<td>$center</td>";
		
		//echo "<td>$sto $sign $stc</td>";
		echo "<td>$location</td>";
		echo "<td>$cash_amount</td>";
		//echo "<td></td>";	   
		echo "</tr>";


		
		
	}
echo "<td><font color='blue'>$bank_deposit_total</td></font></tr>";	

echo "</table>";

*/

//echo "</div>";







//echo "</div>";
echo "<br />";
/*
echo "<table border=5 cellspacing=5>";

echo "<tr><th><a href='cash_count_cashier.php?parkcode=$parkcode&cash_month=$cash_month&fyear=$fyear&cash_month_calyear=$cash_month_calyear&add_location=y'>Add Location</A></th></tr>";	

 
echo "</table>";
*/
echo "<br />";
/*
if($add_location=='y')
{
echo "<form method='post' autocomplete='off'  action='cash_count_cashier.php'>";
echo "<table><tr>";
echo "<td><input type='text' placeholder='Enter Location Name' name='sales_location'></input></td><td><input type='submit' name='add_location' value='Submit'></td>";
echo "</tr></table>";
echo "
<input type='hidden' name='parkcode' value='$parkcode'>
<input type='hidden' name='cash_month' value='$cash_month'>
<input type='hidden' name='fyear' value='$fyear'>
<input type='hidden' name='cash_month_calyear' value='$cash_month_calyear'>";
echo "</form>";
echo "<br />";

}
*/


//echo "<div id='row2_col_1'; style='clear:both';'float:left';>"; 


//echo "<br /><br />";
//echo "<form>";
/*
if($cashier_count==1)
{
echo "<form method='post' autocomplete='off' action='cash_count_cashier_update.php'>";
echo "<table border=1>";



echo "<tr><th colspan='2'>Imprest Cash Count:&nbsp;$cash_month $cash_month_calyear</th></tr>";
while ($row12=mysqli_fetch_array($result12))
	{

	// The extract function automatically creates individual variables from the array $row
	//These individual variables are the names of the fields queried from MySQL
	extract($row12);
	

		echo "<tr$t>"; 
		//echo "<td>$rank</td>";
		//echo "<td>$parkcode</td>";			
		//echo "<td>$company</td>";
		//echo "<td>$ncas_account</td>";
		//echo "<td>$center</td>";
		
		//echo "<td>$sto $sign $stc</td>";
		echo "<td><input type='text' name='location[]' value='$location' readonly='readonly'></td>";
		echo "<td><input type='text' name='cashier_amount[]' value='$cash_amount'></td>";
		//echo "<td></td>";	   
		echo "</tr>";

echo "<input type='hidden' name='id[]' value='$id'>";
		
		
	}
	
	



echo "<table>";
echo "<tr><th>Cashier: $cashier_first $cashier_last</th><td>&nbsp;&nbsp;Verified:<input type='checkbox' name='cashier_approved' value='y' >";
echo "<input type='hidden' name='fyear' value='$fyear'>
<input type='hidden' name='cash_month' value='$cash_month'>
<input type='hidden' name='record_count' value='$num12'>";
if($authorized_match != 'y')
{
echo "<input type='submit' name='submit' value='Submit'>";
}
echo "</td>";
echo"</tr>";
//echo "<tr><th>Manager: $manager</th><td>Approved:<input type='checkbox' name='manager_approved' value='y'>
echo "</form>";
echo "</div>";
}
*/
if($manager_count==1)
{
echo "<form method='post' autocomplete='off' action='pcard_manager_approval_update.php'>";
echo "<table border='1' align='center'>";



echo "<tr><th colspan='2'>PCARD Approval for Employee:</th></tr>";
/*
echo "<tr><td bgcolor='lightpink'>$first_name $middle_initial $last_name $suffix<br />Emp# $employee_number<br />Pos# $position_number<br />Title: $job_title<br />Phone# $phone_number<br />PCARD Quiz Score: $student_score</td></tr>";
*/

echo "<tr><td bgcolor='lightpink'>$first_name $middle_initial $last_name $suffix<br />Emp# $employee_number<br />Pos# $position_number<br />Title: $job_title<br />Phone# $phone_number</td></tr>";






/*
while ($row12=mysqli_fetch_array($result12))
	{

	// The extract function automatically creates individual variables from the array $row
	//These individual variables are the names of the fields queried from MySQL
	extract($row12);
	

		echo "<tr$t>"; 
		//echo "<td>$rank</td>";
		//echo "<td>$parkcode</td>";			
		//echo "<td>$company</td>";
		//echo "<td>$ncas_account</td>";
		//echo "<td>$center</td>";
		
		//echo "<td>$sto $sign $stc</td>";
		echo "<td><input type='text' name='location[]' value='$location' readonly='readonly'></td>";
		echo "<td><input type='text' name='manager_amount[]' value='$cash_amount'></td>";
		//echo "<td></td>";	   
		echo "</tr>";

echo "<input type='hidden' name='id[]' value='$id'>";
		
		
	}
	*/

echo "<table align='center'>";
/*
echo "<tr><th>Manager $manager_first $manager_last Justification: <textarea name='justification_manager' rows='5' cols='40'>$justification_manager</textarea></th></tr>";
*/

 echo "<tr>";
	  echo "<th>Employee Approval Type";
	  //echo "<th>";
	 //$service_type='waste_normal';
	  echo "<select name='employee_approval_type'>";
	   echo "<option value=''></option>";
	   

if($maintenance=='maintenance')
{echo "<option selected='maintenance'>maintenance</option>";} else {echo "<option value='maintenance'>maintenance</option>";}		   
	   
if($service_type=='office_assistant')
{echo "<option selected='office_assistant'>office_assistant</option>";} else {echo "<option value='office_assistant'>office_assistant</option>";}

if($service_type=='ranger')
{echo "<option selected='ranger'>ranger</option>";} else {echo "<option value='ranger'>ranger</option>";}

if($service_type=='superintendent')
{echo "<option selected='superintendent'>superintendent</option>";} else {echo "<option value='superintendent'>superintendent</option>";}

//if($pcard_holder_admin=='admn' or $pcard_holder_admin=='dede' or $pcard_holder_admin=='fama' or $pcard_holder_admin=='nara' or $pcard_holder_admin=='opad' or $pcard_holder_admin=='stpa' or $pcard_holder_admin=='rema')
//{	
if($service_type=='other')
{echo "<option selected='other'>other</option>";} else {echo "<option value='other'>other</option>";}
//}

echo "</select>";
echo "</th>";
echo "</tr>";   




//echo "<tr><th>Manager Justification: <textarea name='justification_manager' rows='5' cols='40'>$justification_manager</textarea></th></tr>";
echo "<tr>";
echo "<td align='left'>";
echo "Approval for Employee PCARD:<input type='checkbox' name='manager_approved' value='y'>";
echo "<input type='hidden' name='fyear' value='$fyear'>
<input type='hidden' name='id' value='$id'>
<input type='hidden' name='record_count' value='$num12'>
<input type='submit' name='submit' value='Submit'>";
echo "</form>";
echo "</td>";
echo "</form>";
echo "</table>";
}

//echo "fs_approver_count=$fs_approver_count<br />";
/*
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
echo "</div>";

}

*/



////mysql_close();





echo "</body>";
echo "</html>";



?>