<?php

session_start();
if(!$_SESSION["budget"]["tempID"]){echo "access denied";exit;}

//echo "<pre>";print_r($_SESSION);echo "</pre>"; //exit;
$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempid=$_SESSION['budget']['tempID'];
$beacnum=$_SESSION['budget']['beacon_num'];
$concession_location=$_SESSION['budget']['select'];
$concession_center=$_SESSION['budget']['centerSess'];

//$file = "articles_menu.php";
//$lines = count(file($file));
$system_entry_date=date("Ymd");
$today=date("Ymd");
//$table="infotrack_projects";

//echo "<pre>";print_r($_SESSION);"</pre>"; //exit;
//echo "<pre>";print_r($_REQUEST);"</pre>"; exit;


extract($_REQUEST);

//$invoice_num2=str_replace('-','',$invoice_num);
//$invoice_num2=strtoupper($invoice_num2);
//$invoice_amount2=str_replace(",","",$invoice_amount);
//$invoice_amount2=str_replace("$","",$invoice_amount2);

if($cashier_approved != "y"){echo "<font color='brown' size='5'>Oops:We did not receive Approval<br /><br /> Click the BACK button on your Browser to Approve Form</font><br />";exit;}
//if($invoice_date==""){echo "<font color='brown' size='5'>Oops:We did not receive all the Values from your Form<br /><br /> Click the BACK button on your Browser to complete Form</font><br />";exit;}
//if($invoice_amount==""){echo "<font color='brown' size='5'>Oops:We did not receive all the Values from your Form<br /><br /> Click the BACK button on your Browser to complete Form</font><br />";exit;}
//if($service_period==""){echo "<font color='brown' size='5'>Oops:We did not receive all the Values from your Form<br /><br /> Click the BACK button on your Browser to complete Form</font><br />";exit;}


$database="budget";
$db="budget";

include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection,$database); // database
include("../../../include/activity_new.php");// database connection parameters
include("../../budget/~f_year.php");

//echo "<br />Line 45: Update Successful<br />"; exit;

if($park != 'admn' and $park != 'ADMN')
{
$query2b="update `budget_service_contracts`.`contracts`,`budget`.`cash_handling_roles`
          set `budget_service_contracts`.`contracts`.`contract_admin_tempid`=`budget`.`cash_handling_roles`.`tempid`
          where `budget`.`cash_handling_roles`.`park`='$park' and `budget`.`cash_handling_roles`.`lead_superintendent`='y'
          and `budget_service_contracts`.`contracts`.id='$scid'		  ";
		  
//echo "<br />query2b=$query2b<br />";		  
		  
$result2b=mysqli_query($connection,$query2b) or die ("Couldn't execute query2b. $query2b");

//echo "<br />Line 57: Update Successful<br />"; exit;
}



$query2c="select `contract_admin_tempid` from `budget_service_contracts`.`contracts` where `id`='$scid' ";
		  
//echo "<br />query2b=$query2b<br />";		  
		  
$result2c=mysqli_query($connection,$query2c) or die ("Couldn't execute query2c. $query2c");
$row2c=mysqli_fetch_array($result2c);
extract($row2c);


//echo "<br />Line 71: Update Successful<br />"; exit;



$tempid2='Dodd3454';



$query2d="update `budget_service_contracts`.`invoices`
         set `cashier`='$tempid',`cashier_date`='$today',`cashier_approved`='y',`contract_administrator`='$contract_admin_tempid',`contract_administrator_date`='$today',`contract_administrator_approved`='y'
         where `scid`='$scid' and `invoice_num`='$invoice_num' ";
//echo "query=$query<br />";

$result2d=mysqli_query($connection,$query2d) or die ("Couldn't execute query2d. $query2d");


$query2d1="update `budget_service_contracts`.`invoices`
         set `manager`='$tempid2',`manager_date`='$today',`manager_approved`='y'
         where `scid`='$scid' and `invoice_num`='$invoice_num' ";
//echo "query=$query<br />";

$result2d1=mysqli_query($connection,$query2d1) or die ("Couldn't execute query2d1. $query2d1");





$query2e="update `budget_service_contracts`.`pay_lines` set `cashier_approved`='y' where `scid`='$scid' and `invoice_num`='$invoice_num' ";
//echo "query=$query<br />";

$result2e=mysqli_query($connection,$query2e) or die ("Couldn't execute query2e. $query2e");


$query2e1="update `budget_service_contracts`.`pay_lines` set `manager_approved`='y' where `scid`='$scid' and `invoice_num`='$invoice_num' ";
//echo "query=$query<br />";

$result2e1=mysqli_query($connection,$query2e1) or die ("Couldn't execute query2e1. $query2e1");


$query2e2="delete from `budget_service_contracts`.`invoices_paylines` where `scid`='$scid' and `invoice_num`='$invoice_num' ";
//echo "query=$query<br />";

$result2e2=mysqli_query($connection,$query2e2) or die ("Couldn't execute query2e2. $query2e2");



$query2f="insert into `budget_service_contracts`.`invoices_paylines`(`scid`,`invoice_num`,`payline_num`,`invoice_amount`,`cashier_approved`)
          select `scid`,`invoice_num`,`payline_num`,`payline_amount`,`cashier_approved`
          from `budget_service_contracts`.`pay_lines`
          where scid='$scid' and invoice_num='$invoice_num'	and `cashier_approved`='y'	  ";
////echo "<br /><br />query2f=$query2f<br /><br />";
//exit;

$result2f=mysqli_query($connection,$query2f) or die ("Couldn't execute query2f. $query2f");


$query2f1="update `budget_service_contracts`.`invoices_paylines`
           set `manager_approved`='y'
          where scid='$scid' and invoice_num='$invoice_num'	and `cashier_approved`='y'	  ";
////echo "<br /><br />query2f1=$query2f1<br /><br />";
//exit;

$result2f1=mysqli_query($connection,$query2f1) or die ("Couldn't execute query2f1. $query2f1");


$query2f2="update `budget_service_contracts`.`invoices`
           set `last_invoice`='n'
          where scid='$scid'  ";
////echo "<br /><br />query2f2=$query2f2<br /><br />";
//exit;

$result2f2=mysqli_query($connection,$query2f2) or die ("Couldn't execute query2f2. $query2f2");


$query2f3="update `budget_service_contracts`.`invoices`
           set `last_invoice`='y'
          where scid='$scid' and invoice_num='$invoice_num'	and `cashier_approved`='y'	  ";
////echo "<br /><br />query2f3=$query2f3<br /><br />";
//exit;

$result2f3=mysqli_query($connection,$query2f3) or die ("Couldn't execute query2f3. $query2f3");






//exit;

$query2g="update `budget_service_contracts`.`invoices_paylines`,`budget_service_contracts`.`po_lines`
          set `budget_service_contracts`.`invoices_paylines`.`begin_balance`=`budget_service_contracts`.`po_lines`.`po_line_num_beg_bal`
		  where `budget_service_contracts`.`invoices_paylines`.`scid`=`budget_service_contracts`.`po_lines`.`scid`
		  and `budget_service_contracts`.`invoices_paylines`.`payline_num`=`budget_service_contracts`.`po_lines`.`po_line_num`
		  and `budget_service_contracts`.`invoices_paylines`.`scid`='$scid'
		  and `budget_service_contracts`.`po_lines`.`scid`='$scid' ";
//echo "<br /><br />query2g=$query2g<br /><br />";
//exit;

$result2g=mysqli_query($connection,$query2g) or die ("Couldn't execute query2g. $query2g");








$query3="SELECT `scid`,`payline_num`,sum(`payline_amount`) as 'total_linepay'
         from `budget_service_contracts`.`pay_lines`
         where `scid`='$scid' and `cashier_approved`='y'
         group by `scid`,`payline_num`		 ";		 



		 

////echo "query3=$query3<br />";	
		 
		 
//$query4="select po_line_num,po_line_num_beg_bal from service_contracts_po_lines where service_contracts_po_lines.scid='272' group by service_contracts_po_lines.po_line_num";		 
//$query5="select payline_num,concat('payline',payline_num,sum(payline_amount)) from service_contracts_invoices_paylines where scid='272' group by payline_num";		 
		 
		 
$result3 = mysqli_query($connection,$query3) or die ("Couldn't execute query 3.  $query3");
$num3=mysqli_num_rows($result3);


while ($row3=mysqli_fetch_array($result3))
{
extract($row3);

$query4="update `budget_service_contracts`.`invoices_paylines`
         set `cummulative_amount`='$total_linepay'
		 where `scid`='$scid' and `invoice_num`='$invoice_num' and `payline_num`='$payline_num' ";

////echo "<br /><br />query4=$query4<br /><br />";
$result4 = mysqli_query($connection,$query4) or die ("Couldn't execute query 4.  $query4");


}


////echo "<br /><br />Line 135<br /><br />"; exit;









//echo "<br />Line 96: Update Successful<br />"; exit;



//header("location: all_invoices_new.php ");
header("location: service_contracts1_invoice_search.php ");





?>