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
$project_category='ITS';
$project_name='wex_bill';
$step_group='B';


$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
include("../../../include/activity.php");// database connection parameters





if($reset=='y')
{
$query23a="update budget.project_steps_detail set status='pending' where project_category='$project_category'
         and project_name='$project_name' and step_group='$step_group'  ";
			 
mysqli_query($connection, $query23a) or die ("Couldn't execute query 23a.  $query23a");


}

$query1="SELECT highlight_color from infotrack_customformat
         where user_id='$tempid' ";
		 
//echo "query1=$query1<br />";		 

$result1 = mysqli_query($connection, $query1) or die ("Couldn't execute query 1.  $query1");

$row1=mysqli_fetch_array($result1);
extract($row1);


include("../../budget/menu1314.php");
echo "<html>";

echo "<head>";

echo "</head>";

//echo "<body bgcolor=>";

//echo "<H3 ALIGN=CENTER > <A href=welcome.php> Return HOME </A></H3>";
if(!isset($step)){$step="";}

echo "<br />";

$query3="SELECT * from project_steps_detail where 1 and project_category='$project_category'
        and project_name='$project_name' and step_group='$step_group' order by step_num asc";



// The variable $result is a PHP resource containing the results of the MySQL query. Its contents can only be used by PHP.
$result3 = mysqli_query($connection, $query3) or die ("Couldn't execute query 3.  $query3");
$num3=mysqli_num_rows($result3);
//////mysql_close();


/*
echo "<table><tr><td><font color='red'><b>Counter: $num3</b></font></td><td>";

include("../../infotrack/scoring/scoreG5.php");
include("../../infotrack/charts/bright_idea_chart.php");
echo "</td></tr></table>";

*/
if($report_type=='form'){$report_form="<img height='25' width='25' src='/budget/infotrack/icon_photos/green_checkmark1.png' alt='picture of green check mark'></img>";}
if($report_type=='reports'){$report_reports="<img height='25' width='25' src='/budget/infotrack/icon_photos/green_checkmark1.png' alt='picture of green check mark'></img>";}

echo "<style>
td {
    padding: 10px;
}

th {
    padding: 10px;
}



</style>";



echo "<br /><table align='center' border='1' align='left'><tr><th><font color='brown'>$project_name</font></th><th><a href='step_group_template1.php?fyear=$fyear&report_type=reports'>Reports</a><br />$report_reports </th><th><a href='step_group_template1.php?fyear=$fyear&report_type=form&reset=y'>Form</a><br />$report_form</th></tr></table>";

echo "<br />";

if($report_type=='form')
{
echo "<table align='center' border=1>";
 
echo 

"<tr> 
       
       <td align='center'><font color='brown'>StepNum</font></td>
       <td align='center'><font color='brown'>StepName</font></td>
       <td align='center'><font color=red>Action</font></td>";
   
                 
       
 

echo "</tr>";

// The while statement steps through the $result variable one row ($row, which is an array created by mysqli_fetch_array) at a time
while ($row3=mysqli_fetch_array($result3))
	{	
	// The extract function automatically creates individual variables from the array $row
	//These individual variables are the names of the fields queried from MySQL
	//$rank=@$rank+1;
	extract($row3);
	//$rank=$rank+1;
	
	
	//echo $status;
	//$rand = array("0", "1", "2", "3", "4", "5", "6", "7", "8", "9", "a", "b", "c", "d", "e", "f");
    //$color = "#".$rand[rand(0,15)].$rand[rand(0,15)].$rand[rand(0,15)].$rand[rand(0,15)].$rand[rand(0,15)].$rand[rand(0,15)];
	//if($c==''){$t=" bgcolor='#B4CDCD'";$c=1;}else{$t='';$c='';}
	
	if($status=='complete'){$t=" bgcolor='#95e965'";}else{$t=" bgcolor='#B4CDCD'";}
	//echo "t=$t<br />";
	if($status=='complete'){$fcolor1='red';}else{$fcolor1='black';}	
	//if($status=='complete'){$bgc='yellow'";}else{$bgc='#B4CDCD';}
	
	//echo $status;
	
	echo 
		
	"<tr$t>";	
	
		   
		   
		//echo "<td>$rank</td>";   
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
/*
if($report=='y')
{
echo "<br />";


$reportQ="SELECT service,account,sum(amount) as 'amount'
          from sips_phone_bill4
		  where 1
		  group by account,service
		  order by account,service
       ";

$total1="SELECT sum(amount) as 'total_amount1'
          from sips_phone_bill4
		  where 1
		 ";
		 


$result_total1 = mysqli_query($connection, $total1) or die ("Couldn't execute query total1.  $total1");

$row_total1=mysqli_fetch_array($result_total1);
extract($row_total1);
$total_amount1=number_format($total_amount1,2);

$result_report = mysqli_query($connection, $reportQ) or die ("Couldn't execute reportQ.  $reportQ");
$num_report=mysqli_num_rows($result_report);

echo "<table align='center' border='1'>";
echo "<tr><th>account</th><th>service</th><th>amount</th></tr>";
                 
       
 while ($row3=mysqli_fetch_array($result_report))
	{	
	
extract($row3);	

$amount=number_format($amount,2);


echo "<tr>";
echo "<td>$account</td>";
echo "<td>$service</td>";
echo "<td>$amount</td>";
	
	
	
echo "</tr>";
}
echo "<tr><td></td><td>Total</td><td>$total_amount1</td></tr>";
echo "</table>";


echo "<br />";


	   
$reportQ2="SELECT playstation as 'park',center,account,service,invoice_num,ncas_center,center_change,amount,id
          from sips_phone_bill4
		  where 1  
          order by account,service,center  ";
	   
	   


	   
$total2="SELECT sum(amount) as 'total_amount2'
          from sips_phone_bill4
		  where 1
		 
		 ";
		 
	 

$result_total2 = mysqli_query($connection, $total2) or die ("Couldn't execute query total2.  $total2");

$row_total2=mysqli_fetch_array($result_total2);
extract($row_total2);
$total_amount2=number_format($total_amount2,2);

$result_report2 = mysqli_query($connection, $reportQ2) or die ("Couldn't execute reportQ2.  $reportQ2");
$num_report2=mysqli_num_rows($result_report2);


$center_changed="<img height='25' width='25' src='/budget/infotrack/icon_photos/green_checkmark1.png' alt='picture of green check mark'></img>";

echo "<table align='center' border='1'>";
echo "<tr><td align='center'><font color='brown'>line#</font></td><td align='center'><font color='brown'>account</font></td><td align='center'><font color='brown'>service/<br />invoice#</font></td><td align='center'><font color='brown'>park</font></td><td align='center'><font color='brown'>center</font></td><td align='center'><font color='brown'>amount</font></td></tr>";
                 
       
 while ($row4=mysqli_fetch_array($result_report2))
	{	
	
extract($row4);	
$rank=@$rank+1;
$amount=number_format($amount,2);

if($account=='532819' and $center_change != 'y'){$t=" bgcolor='salmon' ";}else{$t=" bgcolor='lightgreen' ";}

echo "<tr$t>";
echo "<td>$rank</td>";
echo "<td>$account</td>";
echo "<td>$service<br />$invoice_num</td>";


echo "<td>$park</td>";

if($account=='532819' and $center_change != 'y' )
{
echo "<td align='center'>$center<br />";
echo "<form action='step_group.php'>";
echo "<input type='text' name='center_change'>";
echo "<input type='hidden' name='report_type'  value='form'>";
echo "<input type='hidden' name='report'  value='y'>";
echo "<input type='hidden' name='center_change_id'  value='$id'>";
echo "<input type='submit' value='Submit'>";
echo "</form>";

echo "</td>";
}

if($account=='532819' and $center_change == 'y' )
{
echo "<td align='center'>$center<br />";
echo "<form action='step_group.php'>";
echo "<input type='text' name='center_change'>";
echo "<input type='hidden' name='report_type'  value='form'>";
echo "<input type='hidden' name='report'  value='y'>";
echo "<input type='hidden' name='center_change_id'  value='$id'>";
echo "<input type='submit' value='Submit'>";
echo "</form>";
echo "$ncas_center $center_changed";


echo "</td>";
}


if($account != '532819')
{
echo "<td align='center'>$center</td>";
}





echo "<td>$amount</td>";
	
	
	
echo "</tr>";
}
echo "<tr bgcolor='lightgreen'><td></td><td></td><td></td><td></td><td>Total</td><td>$total_amount2</td></tr>";
echo "</table>";


}
*/

}


/*

if($report_type=='reports')
{






include("fyear_head_sips_phone_bill.php");// database connection parameters
echo "<br />";
$report_listing="SELECT system_entry_date,user_id,ncas_invoice_number,sum(ncas_invoice_amount) as 'monthly_bill_total'
                  from sips_phone_bill4_perm
		          where 1 and fyear='$fyear'
		          group by ncas_invoice_number
		          order by system_entry_date desc   ";

				  
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
echo "<td><font color='brown'>$ncas_invoice_number</font> <a href='/budget/acs/acsFind.php?ncas_invoice_number=$ncas_invoice_number&submit_acs=Find' target='_blank'><img height='40' width='40' src='/budget/infotrack/icon_photos/magnify.png' alt='picture of home'></img></a></td>";
echo "<td>$monthly_bill_total2</td>";
echo "<td>$user_id</td>";


	
	
	
echo "</tr>";				  
}

echo "</table>";	
}

*/
echo "</body></html>";

?>

























