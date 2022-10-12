<?php
//ini_set('display_errors',1);
//echo "<pre>";print_r($_REQUEST);echo "</pre>";//exit;
session_start();
//echo "<pre>";print_r($_SESSION);echo "</pre>";exit;
$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempid=$_SESSION['budget']['tempID'];
//echo $tempid;
extract($_REQUEST);
$end_date=str_replace("-","",$end_date);
//echo $end_date; exit;
//echo "<pre>";print_r($_REQUEST);echo "</pre>";exit;
//echo "tempid=$tempid<br />";

/*
$database="divper";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database

$sql = "SELECT Nname,Fname,Lname,phone From empinfo where tempID='$tempid'";

$result = mysqli_query($connection, $sql) or die ("Couldn't execute query. $sql");
$row=mysqli_fetch_array($result);
extract($row);

$prepared_by=$Fname." ".$Lname;

$received_by=$prepared_by;
*/


$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
include("../../../../include/activity.php");// database connection parameters



$query1="insert into wex_report(center,center_code,ncas_account,amount,month,calyear,valid,invoice_number,invoice_date,rebate_amount,comments)
         select center,center_code,ncas_account,sum(net_cost) as 'amount',month,calyear,valid,invoice_number,invoice_date,rebate_amount,comments
       	 from wex_detail where valid='n'
         group by center,ncas_account ";
			 
$result1 = mysqli_query($connection, $query1) or die ("Couldn't execute query 1.  $query1");

//exit;

//echo "query1<br />";

$query2="select sum(amount) as 'month_total'
         from wex_report
		 where valid='n' ";
		 
//echo "query2=$query2<br />";		 

$result2 = mysqli_query($connection, $query2) or die ("Couldn't execute query 2.  $query2");

$row2=mysqli_fetch_array($result2);
extract($row2);
//echo "month_total=$month_total <br />";  // 6254.67  (first time run)


$query3="update wex_report
         set month_total='$month_total'
		 where valid='n' ";
			 
$result3 = mysqli_query($connection, $query3) or die ("Couldn't execute query 3.  $query3");

//echo "query3<br />";


$query4="update wex_report
         set monthly_percent=(amount/month_total)
		 where valid='n' ";
			 
$result4 = mysqli_query($connection, $query4) or die ("Couldn't execute query 4.  $query4");


$query5="update wex_report
         set rebate_adjust=(rebate_amount*monthly_percent)
		 where valid='n' ";
			 
$result5 = mysqli_query($connection, $query5) or die ("Couldn't execute query 5.  $query5");

//echo "query5<br />";




$query6="select sum(rebate_adjust) as 'rebate_adjust_total' from wex_report where valid='n' ";  

echo "query6=$query6 <br />";

$result6 = mysqli_query($connection, $query6) or die ("Couldn't execute query 6.  $query6");

$row6=mysqli_fetch_array($result6); 

extract($row6);  
echo "rebate_adjust_total=$rebate_adjust_total <br />";  // 110.21  (first time run)

//exit;



//echo "query6<br />";


$query7="select center as 'center_adjust',ncas_account as 'ncas_account_adjust',rebate_adjust,(rebate_amount-$rebate_adjust_total) as 'adj_amount' from wex_report where valid='n' order by amount desc limit 1 ";   // brings back center_adjust=12802963, amount_adjust=913.98, adj_amount=-.01
			 
$result7 = mysqli_query($connection, $query7) or die ("Couldn't execute query 7.  $query7");


$row7=mysqli_fetch_array($result7); 

extract($row7);     // brings back record with the highest amount:  center as 'center_adjust', amount as 'amount_adjust', rebate as 'rebate_amount'
 
//extract brings back following (EXAMPLE Only:  Includes values for the first run of this Report)

//$center_adjust=12802963;
//$ncas_account_adjust=533310;
//$rebate_adjust=16.10;
//$adj_amount=-.01;   



$rebate_adjust2=$rebate_adjust+$adj_amount;  // 16.10-.01 =  16.09


$query7a="update wex_report
          set rebate_adjust='$rebate_adjust2'
          where valid='n'
          and center='$center_adjust'
          and ncas_account='$ncas_account_adjust'		  
		  ";

		  
//echo "query7a=$query7a <br />";		  

$result7a = mysqli_query($connection, $query7a) or die ("Couldn't execute query 7a.  $query7a");

/* 2022-05-25: CCOOPER - Ticket 286 - WEX: CACR center was not being returned
from the center table, it was not 'unique' enough

$query7b="update wex_report,center
          set wex_report.center=center.new_center
          where valid='n'
          and wex_report.center_code=center.parkcode";  */

$query7b="update wex_report,center
          set wex_report.center=center.new_center
          where valid='n'
          and wex_report.center_code=center.parkcode
          and center.new_center like '1680%'		  
		  ";
/* 2022-05-25: End CCOOPER */
		  
//echo "query7a=$query7a <br />";		  

$result7b = mysqli_query($connection, $query7b) or die ("Couldn't execute query 7b.  $query7b");












//echo "incomplete_records=$incomplete_records <br />";  exit;

//if($incomplete_records != '0') {$icr='y';} else {$icr='n';)
//if($incomplete_records == '0') {include("stepB2a.php");} //All records have Center Values
//inif($incomplete_records != '0') {include("stepB2b.php");} //1+ Records are missing Center Values

$query23a="update budget.project_steps_detail set status='complete' where project_category='$project_category'
         and project_name='$project_name' and step_group='$step_group' and step_num='$step_num' ";
		 
		 
//echo "query23a=$query23a<br />"; exit;		 
			 
mysqli_query($connection, $query23a) or die ("Couldn't execute query 23a.  $query23a");



//exit;


{header("location: step_group.php?project_category=$project_category&project_name=$project_name&step_group=$step_group&fiscal_year=$fiscal_year&start_date=$start_date&end_date=$end_date&report=y&report_type=form ");}















 ?>




















