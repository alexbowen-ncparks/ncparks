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




$database="divper";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database

//Heide Rumble "tempid Value" in Division Personnel DB (TABLE=empinfo) was changed to Rumble9889.  This is a Kludge to make sure the correct First Name and Last name come back IF $tempid=Rumble2030
if($tempid=='Rumble2030'){$tempid='Rumble9889';}

$sql = "SELECT Nname,Fname,Lname,phone From empinfo where tempID='$tempid'";
//echo "sql=$sql<br />"; //exit;
$result = mysqli_query($connection, $sql) or die ("Couldn't execute query. $sql");
$row=mysqli_fetch_array($result);
extract($row);

$prepared_by=$Fname." ".$Lname;

$received_by=$prepared_by;



$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
include("../../../../include/activity.php");// database connection parameters





$query14k="update wex_report
         set prepared_by='$prepared_by',received_by='$received_by'
		 where 1 
		 and valid='n' ";
		 
$result14k=mysqli_query($connection, $query14k) or die ("Couldn't execute query 14k.  $query14k");

$tempid2=substr($tempid,0,-2);

$query14m="update wex_report
         set user_id='$tempid2'
		 where 1
         and valid='n' ";

//echo "query14m=$query14m<br />"; exit;
		 
$result14m=mysqli_query($connection, $query14m) or die ("Couldn't execute query 14m.  $query14m");


$system_entry_date=date("Ymd");

$prepared_date=date('m/d/Y', strtotime($system_entry_date));


$query14n="update wex_report
           set system_entry_date='$system_entry_date',prepared_date='$prepared_date'
           where 1
           and valid='n'  ";
		 
$result14n=mysqli_query($connection, $query14n) or die ("Couldn't execute query 14n.  $query14n");



$query14p = "SELECT invoice_date
FROM  `wex_report` 
WHERE valid='n'
LIMIT 1 ";

echo "query14p=$query14p<br />"; 

$result14p=mysqli_query($connection, $query14p) or die ("Couldn't execute query 14p.  $query14p");

$row14p=mysqli_fetch_array($result14p);
extract($row14p);

echo "invoice_date=$invoice_date <br />";  //2015-02-28

$invoice_date2=str_replace("-","",$invoice_date);

echo "invoice_date2=$invoice_date2 <br />";  //20150228

$datesql=$invoice_date2;    //20150228

$ncas_invoice_date=substr($invoice_date2,4,2)."/".substr($invoice_date2,6,2)."/".substr($invoice_date2,0,4);

//$datesql=substr($ncas_invoice_date,6,4).substr($ncas_invoice_date,0,2).substr($ncas_invoice_date,3,2);
//.mid($ncas_invoice_date,1,2).mid($ncas_invoice_date,4,2);
$due_date_calc1=strtotime("$datesql");
$due_date_calc2=($due_date_calc1)+(60*60*24*14);
$due_date_calc3=date("Ymd", $due_date_calc2);
$due_date=substr($due_date_calc3,4,2)."/".substr($due_date_calc3,6,2)."/".substr($due_date_calc3,0,4)."-ADM";  // 02/25/2015-ADM
//echo "ncas_invoice_date=$ncas_invoice_date<br />"; //exit;
//echo "datesql=$datesql<br />";  //exit;
//echo "due_date=$due_date<br />";  exit;


$query14r="update wex_report
           set ncas_invoice_date='$ncas_invoice_date',ncas_invoice_number=invoice_number,datesql='$datesql',due_date='$due_date'
           where 1 
		   and valid='n' ";

$result14r=mysqli_query($connection, $query14r) or die ("Couldn't execute query 14r.  $query14r");


$query14s="update wex_report
           set ncas_number=mid(ncas_account,3,4) 
           where 1
           and valid='n'  ";

$result14s=mysqli_query($connection, $query14s) or die ("Couldn't execute query 14s.  $query14s");


$query14t="update wex_report
           set net_amount=amount-rebate_adjust,
		       ncas_invoice_amount=amount-rebate_adjust,
			   invoice_total=amount-rebate_adjust
           where 1 
		   and valid='n' ";

$result14t=mysqli_query($connection, $query14t) or die ("Couldn't execute query 14t.  $query14t");


$parkcode="ADM";


$query17="update wex_report 
          set ncas_fund=mid(center,1,4),
          ncas_rcc=mid(center,5,4),
          ncas_center=center,
          parkcode='$parkcode'
          where 1 
          and valid='n'  ";
		 

$result17=mysqli_query($connection, $query17) or die ("Couldn't execute query 17.  $query17");



$query18="insert into cid_vendor_invoice_payments
(prefix,ncas_number,ncas_account,ncas_budget_code,prepared_by,prepared_date,comments,ncas_company,ncas_invoice_date,datesql,system_entry_date,
 due_date,ncas_invoice_number,ncas_invoice_amount,invoice_total,ncas_remit_code,vendor_name,vendor_address,
 pay_entity,vendor_number,group_number,user_id,parkcode,ncas_fund,ncas_rcc,ncas_center,received_by,approved_by)
 
 select prefix,ncas_number,ncas_account,ncas_budget_code,prepared_by,prepared_date,comments,ncas_company,ncas_invoice_date,datesql,system_entry_date,
 due_date,ncas_invoice_number,sum(ncas_invoice_amount),sum(invoice_total),ncas_remit_code,vendor_name,vendor_address,
 pay_entity,vendor_number,group_number,user_id,parkcode,ncas_fund,ncas_rcc,ncas_center,received_by,approved_by
 
 from wex_report
 where 1
 and valid='n'
 group by ncas_account,ncas_center
 order by ncas_account,ncas_center
 "; 


$result18=mysqli_query($connection, $query18) or die ("Couldn't execute query 18.  $query18");
 
 
 
$query1="update wex_detail set transaction_date=lpad(transaction_date,10,'0')
         where 1 and valid='n'   ";


//echo "query1=$query1<br />";

$result1 = mysqli_query($connection, $query1) or die ("Couldn't execute query 1.  $query1");


$query1a="update wex_detail set transaction_date=replace(transaction_date,'00','0')
         where 1 and valid='n'   ";


//echo "query1a=$query1a<br />";


$result1a = mysqli_query($connection, $query1a) or die ("Couldn't execute query 1a.  $query1a");
 
 
 
 
 
 $query1b="update wex_detail set transaction_date_pos5=mid(transaction_date,5,1)
         where 1 and valid='n'   ";


//echo "query1b=$query1b<br />";

//exit;
// The variable $result is a PHP resource containing the results of the MySQL query. Its contents can only be used by PHP.
$result1b = mysqli_query($connection, $query1b) or die ("Couldn't execute query 1b.  $query1b");

//exit;
/*
echo "SELECT transaction_date,transaction_date_pos5,concat(mid(transaction_date,1,3),'0',mid(transaction_date,4,6)) FROM `wex_detail` WHERE `calyear` LIKE '2018' AND `month` LIKE 'january' ";

*/

$query1c="update wex_detail set transaction_date2=transaction_date
          where 1 and transaction_date_pos5 != '/' and valid='n'   ";
		 
		 
//echo "query1c=$query1c<br />";

//exit;
// The variable $result is a PHP resource containing the results of the MySQL query. Its contents can only be used by PHP.
$result1c = mysqli_query($connection, $query1c) or die ("Couldn't execute query 1c.  $query1c");

$query1d="update wex_detail set transaction_date2=concat(mid(transaction_date,1,3),'0',mid(transaction_date,4,6))
         where 1 and transaction_date_pos5 = '/' and valid='n'  ";

//echo "query1d=$query1d<br />";

//exit;
// The variable $result is a PHP resource containing the results of the MySQL query. Its contents can only be used by PHP.
$result1d = mysqli_query($connection, $query1d) or die ("Couldn't execute query 1d.  $query1d");
 
 
  
$query1e="update wex_detail 
          set transaction_date3=concat(mid(transaction_date2,7,4),mid(transaction_date2,1,2),mid(transaction_date2,4,2))
          where 1 and valid='n'		  ";

//echo "query1e=$query1e<br />";

//exit;
// The variable $result is a PHP resource containing the results of the MySQL query. Its contents can only be used by PHP.
$result1e = mysqli_query($connection, $query1e) or die ("Couldn't execute query 1e.  $query1e");
  
  
  
  
  
  
  
  
  
 

$query19="update wex_detail 
          set valid='y'
          where valid='n'  ";
		 

$result19=mysqli_query($connection, $query19) or die ("Couldn't execute query 19.  $query19");



$query20="update wex_report 
          set valid='y'
          where valid='n'  ";
		 

$result20=mysqli_query($connection, $query20) or die ("Couldn't execute query 20.  $query20");








$query23a="update budget.project_steps_detail set status='complete' where project_category='$project_category'
         and project_name='$project_name' and step_group='$step_group' and step_num='$step_num' ";
			 
mysqli_query($connection, $query23a) or die ("Couldn't execute query 23a.  $query23a");


////mysql_close();



{header("location: step_group.php?project_category=$project_category&project_name=$project_name&step_group=$step_group&fiscal_year=$fiscal_year&start_date=$start_date&end_date=$end_date&report=y&report_type=form ");}




 ?>



















