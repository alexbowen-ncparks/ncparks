<?php

//echo "<pre>";print_r($_REQUEST);echo "</pre>";//exit;
session_start();

if(!$_SESSION["budget"]["tempID"]){echo "access denied";exit;}

$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempid=$_SESSION['budget']['tempID'];
extract($_REQUEST);
//echo "<pre>";print_r($_REQUEST);echo "</pre>"; exit;
//echo "<pre>";print_r($_SESSION);echo "</pre>";exit;
$project_category='FMS';
$project_name='vendors_admin';
$step_group='B';


$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
include("../../../../include/activity.php");// database connection parameters

if($reset=='y')
{
$query23a="update budget.project_steps_detail set status='pending' where project_category='$project_category' and project_name='$project_name' and step_group='$step_group'  ";			 
mysqli_query($connection, $query23a) or die ("Couldn't execute query 23a.  $query23a");
}

$query1="SELECT highlight_color from infotrack_customformat where user_id='$tempid' ";
$result1 = mysqli_query($connection, $query1) or die ("Couldn't execute query 1.  $query1");
$row1=mysqli_fetch_array($result1);
extract($row1);

include ("../../../budget/menu1415_v1.php");
if($report_type==''){$report_type='form';}

if($report_type=='form'){$report_form="<img height='25' width='25' src='/budget/infotrack/icon_photos/green_checkmark1.png' alt='picture of green check mark'></img>";}
if($report_type=='reports'){$report_reports="<img height='25' width='25' src='/budget/infotrack/icon_photos/green_checkmark1.png' alt='picture of green check mark'></img>";}
//if($report_type=='vehicles'){$report_vehicles="<img height='25' width='25' src='/budget/infotrack/icon_photos/green_checkmark1.png' alt='picture of green check mark'></img>";}

echo "<style>
td {padding: 10px;}
th {padding: 10px;}
</style>";



echo "<br /><table align='center' border='1' align='left'>";
echo "<tr>";
echo "<th><font color='brown'>$project_name</font></th>";
//echo "<th><a href='step_group_vendors_admin.php?fyear=$fyear&report_type=vehicles'>Fuel<br />Verification</a><br />$report_vehicles </th>";
echo "<th><a href='step_group_vendors_admin.php?fyear=$fyear&report_type=form&reset=y'>Update<br />Form</a><br />$report_form</th>";
echo "<th><a href='step_group_vendors_admin.php?fyear=$fyear&report_type=reports'>Reports</a><br />$report_reports </th>";
echo "</tr>";
echo "</table>";

echo "<br />";
/*
if($report_type=='vehicles')
{

echo "<table align='center'><tr><td>Code Pending</td></tr></table>";

}
*/

if($report_type=='form')
{


echo "<br />";

$query3="SELECT * from project_steps_detail where 1 and project_category='$project_category'
        and project_name='$project_name' and step_group='$step_group' order by step_num asc";


echo "query3=$query3<br />";
// The variable $result is a PHP resource containing the results of the MySQL query. Its contents can only be used by PHP.
$result3 = mysqli_query($connection, $query3) or die ("Couldn't execute query 3.  $query3");
$num3=mysqli_num_rows($result3);


echo "<table align='center' border=1>"; 
echo"<tr>";
echo "<td align='center'><font color='brown'>StepNum</font></td>";
echo "<td align='center'><font color='brown'>StepName</font></td>";
echo "<td align='center'><font color=red>Action</font></td>";
echo "</tr>";

// The while statement steps through the $result variable one row ($row, which is an array created by mysqli_fetch_array) at a time
while ($row3=mysqli_fetch_array($result3))
	{	
	
	extract($row3);
	if($status=='complete'){$t=" bgcolor='#95e965'";}else{$t=" bgcolor='#B4CDCD'";}
	if($status=='complete'){$fcolor1='red';}else{$fcolor1='black';}	
echo "<tr$t>";
		echo "<td align='center'>$step_num</td>
		   <td>$step_name</td>
		   <td>
		   <form method='post' action='step$step_group$step_num.php'>
		   <input type='hidden' name='fiscal_year' value='$fiscal_year'>	   
		   <input type='hidden' name='project_category' value='$project_category'>	   
		   <input type='hidden' name='project_name' value='$project_name'>	   
		   <input type='hidden' name='start_date' value='$start_date'>	   
		   <input type='hidden' name='end_date' value='$end_date'>	   
		   <input type='hidden' name='step_group' value='$step_group'>	   
		   <input type='hidden' name='step_num' value='$step_num'>	   
		   <input type='hidden' name='step' value='$step'>	   
		   <input type='hidden' name='step_name' value='$step_name'>	   
		   <input type='hidden' name='link' value='$link'>	   
		   <input type='submit' name='submit1' value='Execute'>
		   </form>
		   </td>";						 
echo "</tr>";	
	}

echo "</table>";



}

if($report_type=='reports')
echo "<table align='center'><tr><td>Code Pending</td></tr></table>";	
	/*
{
include("fyear_head_wex_bill.php");// database connection parameters
echo "<br />";
$report_listing="SELECT system_entry_date,user_id,ncas_invoice_number,month,calyear,sum(ncas_invoice_amount) as 'monthly_bill_total'
                  from wex_report
		          where 1 and fyear='$fyear'
				  and active='y'
		          group by ncas_invoice_number
		          order by system_entry_date desc   ";

	
echo "report_listing=$report_listing <br />";
	
$result_report_listing = mysqli_query($connection, $report_listing) or die ("Couldn't execute report listing.  $report_listing");
$num_report_listing=mysqli_num_rows($result_report_listing);  
				  
echo "<table align='center' border='1' padding='5'>";
echo "<tr><th>Invoice<br />Number</th><th>Total<br />Amount</th><th>Entered<br />by</th></tr>";				  
			  
				  
 while ($row_report_listing=mysqli_fetch_array($result_report_listing))
	{	
	
extract($row_report_listing);	

$monthly_bill_total2=number_format($monthly_bill_total,2);
if($table_bg2==''){$table_bg2='cornsilk';}
if($color==''){$t=" bgcolor='$table_bg2' ";$color=1;}else{$t='';$color='';}

echo "<tr$t>";
echo "<td><font color='brown'>$ncas_invoice_number</font> <a href='/budget/acs/acsFind.php?ncas_invoice_number=$ncas_invoice_number&submit_acs=Find' target='_blank'><img height='40' width='40' src='/budget/infotrack/icon_photos/magnify.png' alt='picture of home'></img></a><br />$month-$calyear</td>";
echo "<td>$monthly_bill_total2</td>";
echo "<td>$user_id</td>";
//echo "<td><a href='/budget/acs/acsFind.php?ncas_invoice_number=$ncas_invoice_number&submit_acs=Find' target='_blank'>CDCS</a></td>";

	
	
	
echo "</tr>";				  
}

echo "</table>";	
}
*/
echo "</body></html>";

?>