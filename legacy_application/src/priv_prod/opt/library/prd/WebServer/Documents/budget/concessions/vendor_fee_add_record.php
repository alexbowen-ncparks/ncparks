<?php

session_start();

$active_file=$_SERVER['SCRIPT_NAME'];

$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempid=$_SESSION['budget']['tempID'];
$beacnum=$_SESSION['budget']['beacon_num'];
$concession_location=$_SESSION['budget']['select'];
$concession_center=$_SESSION['budget']['centerSess'];



extract($_REQUEST);
$fee_amount=str_replace(",","",$fee_amount);
$fee_amount=str_replace("$","",$fee_amount);
$ncas_center=str_replace("-","",$ncas_center);



//echo "tempid=$tempid";

//echo "<pre>";print_r($_SERVER);"</pre>";//exit;
//echo "<pre>";print_r($_SESSION);"</pre>"; exit;
echo "<pre>";print_r($_REQUEST);"</pre>"; 
//exit;


$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
include("../../../include/activity.php");// database connection parameters
//include("../budget/~f_year.php");
//include("../../budget/~f_year.php");

//if($beacnum !="60032793" and $beacnum != '60033162'){echo "<font color='red' size='5'>Message:"; print_r($_SESSION['budget']['tempID']);echo " does not have access to this report</font>";exit;}
/*
if($level=='5' and $tempID !='Dodd3454')
{

echo "beacon_number:$beacnum";
echo "<br />";
echo "concession_location:$concession_location";
echo "<br />";
echo "concession_center:$concession_center";
echo "<br />";
}
*/



if($f_year==""){echo "<font color='brown' size='5'>Oops:We did not receive all the Values from your Form<br /><br />Click the BACK button on your Browser to complete Form </font><br />";exit;}
if($fee_period==""){echo "<font color='brown' size='5'>Oops:We did not receive all the Values from your Form<br /><br />Click the BACK button on your Browser to complete Form </font><br />";exit;}
if($park==""){echo "<font color='brown' size='5'>Oops:We did not receive all the Values from your Form<br /><br />Click the BACK button on your Browser to complete Form </font><br />";exit;}
if($vendor_name==""){echo "<font color='brown' size='5'>Oops:We did not receive all the Values from your Form<br /><br />Click the BACK button on your Browser to complete Form </font><br />";exit;}
if($fee_amount==""){echo "<font color='brown' size='5'>Oops:We did not receive all the Values from your Form<br /><br />Click the BACK button on your Browser to complete Form </font><br />";exit;}
if($check_num==""){echo "<font color='brown' size='5'>Oops:We did not receive all the Values from your Form<br /><br />Click the BACK button on your Browser to complete Form </font><br />";exit;}

if($beacnum != '60032781')
{
if($internal_deposit_num==""){echo "<font color='brown' size='5'>Oops:We did not receive all the Values from your Form<br /><br />Click the BACK button on your Browser to complete Form </font><br />";exit;}
}


//if($ncas_post_date==""){echo "<font color='brown' size='5'>Oops:We did not receive all the Values from your Form<br /><br />Click the BACK button on your Browser to complete Form </font><br />";exit;}
if($ncas_center==""){echo "<font color='brown' size='5'>Oops:We did not receive all the Values from your Form<br /><br />Click the BACK button on your Browser to complete Form </font><br />";exit;}
if($ncas_account==""){echo "<font color='brown' size='5'>Oops:We did not receive all the Values from your Form<br /><br />Click the BACK button on your Browser to complete Form </font><br />";exit;}
//if($ncas_invoice_num==""){echo "<font color='brown' size='5'>Oops:We did not receive all the Values from your Form<br /><br />Click the BACK button on your Browser to complete Form </font><br />";exit;}
if($tempid==""){echo "<font color='brown' size='5'>Oops:We did not receive all the Values from your Form<br /><br />Click the BACK button on your Browser to complete Form </font><br />";exit;}


$entered_by=substr($tempid,0,-4);

//$date=$_POST['date'];
//$project_category=$_POST['project_category'];
//$project_name=$_POST['project_name'];
//$project_note=$_POST['project_note'];
//$weblink=$_POST['weblink'];
$system_entry_date=date("Ymd");
//$project_start_date=$_POST['project_start_date'];
//$project_end_date=$_POST['project_end_date'];
//$project_status=$_POST['project_status'];



// Retrieves the Current Fiscal Year

$query1a="SELECT report_year as 'fyear_active' from fiscal_year where active_year_concession_fees='y' ";

$result1a=mysqli_query($connection, $query1a) or die ("Couldn't execute query 1a. $query1a");

$row1a=mysqli_fetch_array($result1a);

extract($row1a);

echo "<br />f_year=$f_year<br />";
echo "<br />fyear_active=$fyear_active<br />";

// Current Year Records

if($f_year==$fyear_active)
{

$query1="insert into concessions_vendor_fees
(f_year,fee_period,park,vendor_name,fee_amount,vendor_ck_num,internal_deposit_num,ncas_center,ncas_account,system_entry_date,entered_by) 
values ('$f_year','$fee_period','$park','$vendor_name','$fee_amount','$check_num','$internal_deposit_num','$ncas_center','$ncas_account','$system_entry_date','$entered_by')";

echo "<br />current year query=$query1<br />";
//exit;

mysqli_query($connection, $query1) or die ("Couldn't execute query 1.  $query");


//$rbh_field='cy_amount';

/*
$query1="truncate table rbh_multiyear_concession_fees2";
		 
//echo "query1=$query1<br />";		 

$result1 = mysqli_query($connection, $query1) or die ("Couldn't execute query 1.  $query1");

//$row1=mysqli_fetch_array($result1);
//extract($row1);	

$query2="insert into rbh_multiyear_concession_fees2(center,ncas_account,park,vendor,fyear,amount)
         select ncas_center,ncas_account,park,vendor_name,f_year,sum(fee_amount)
		 from concessions_vendor_fees where f_year='$f_year'
		 group by ncas_center,park,vendor_name";
		 
//echo "query2=$query2<br />";		 

$result2 = mysqli_query($connection, $query2) or die ("Couldn't execute query 2.  $query2");


$query3="update rbh_multiyear_concession_fees3 as t1,rbh_multiyear_concession_fees2 as t2
         set t1.cy_amount=t2.amount
		 where t1.center=t2.center
		 and t1.ncas_account=t2.ncas_account
		 and t1.park=t2.park
		 and t1.vendor=t2.vendor ";
		 
echo "query3=$query3<br />";		 

$result3 = mysqli_query($connection, $query3) or die ("Couldn't execute query 3.  $query3");
*/
	
}

// Previous Year Records

if($f_year!=$fyear_active)
{

$query1="insert into concessions_vendor_fees
(f_year,fee_period,park,vendor_name,fee_amount,vendor_ck_num,internal_deposit_num,ncas_center,ncas_account,system_entry_date,entered_by) 
values ('$f_year','$fee_period','$park','$vendor_name','$fee_amount','$check_num','$internal_deposit_num','$ncas_center','$ncas_account','$system_entry_date','$entered_by')";

echo "<br />previous year query=$query1<br />";
//exit;

mysqli_query($connection, $query1) or die ("Couldn't execute query 1.  $query");


}

echo "<br />End of Page<br />";
//exit;

header("location: vendor_fees_drilldown1.php?park=$park&vendor_name=$vendor_name&ncas_center=$ncas_center&f_year=$f_year");


?>