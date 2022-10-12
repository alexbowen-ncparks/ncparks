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

//echo "<pre>";print_r($_REQUEST);"</pre>"; //exit;

$fee_amount=str_replace(",","",$fee_amount);

$fee_amount=str_replace("$","",$fee_amount);



if($level=='5' and $tempID !='Dodd3454')

{

//echo "<pre>";print_r($_SERVER);"</pre>";//exit;

//echo "<pre>";print_r($_SESSION);"</pre>";//exit;

//echo "<pre>";print_r($_REQUEST);"</pre>";exit;

}
$Lname=substr($tempid,0,-4);
$system_entry_date=date("Ymd");
//echo "tempid=$tempid";
//echo "Lname=$Lname";

//echo "<pre>";print_r($_SESSION);"</pre>";//exit;
//echo "<pre>";print_r($_REQUEST);"</pre>";exit;

$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
include("../../../include/activity.php");// database connection parameters
//include("../budget/~f_year.php");
//include("../../budget/~f_year.php");


//include("../budget/~f_year.php");

//include("../../budget/~f_year.php");

//if($beacnum !="60032793" and $beacnum != '60033162'){echo "<font color='red' size='5'>Message:"; print_r($_SESSION['budget']['tempID']);echo " does not have access to this report</font>";exit;}



if($f_year==""){echo "<font color='brown' size='5'>Oops:We did not receive all the Values from your Form<br /><br />Click the BACK button on your Browser to complete Form </font><br />";exit;}

if($fee_period==""){echo "<font color='brown' size='5'>Oops:We did not receive all the Values from your Form<br /><br />Click the BACK button on your Browser to complete Form </font><br />";exit;}

if($park==""){echo "<font color='brown' size='5'>Oops:We did not receive all the Values from your Form<br /><br />Click the BACK button on your Browser to complete Form </font><br />";exit;}

if($vendor_name==""){echo "<font color='brown' size='5'>Oops:We did not receive all the Values from your Form<br /><br />Click the BACK button on your Browser to complete Form </font><br />";exit;}

if($fee_amount==""){echo "<font color='brown' size='5'>Oops:We did not receive all the Values from your Form<br /><br />Click the BACK button on your Browser to complete Form </font><br />";exit;}

if($check_num==""){echo "<font color='brown' size='5'>Oops:We did not receive all the Values from your Form<br /><br />Click the BACK button on your Browser to complete Form </font><br />";exit;}

if($internal_deposit_num==""){echo "<font color='brown' size='5'>Oops:We did not receive all the Values from your Form<br /><br />Click the BACK button on your Browser to complete Form </font><br />";exit;}

//if($ncas_post_date==""){echo "<font color='brown' size='5'>Oops:We did not receive all the Values from your Form<br /><br />Click the BACK button on your Browser to complete Form </font><br />";exit;}

if($ncas_center==""){echo "<font color='brown' size='5'>Oops:We did not receive all the Values from your Form<br /><br />Click the BACK button on your Browser to complete Form </font><br />";exit;}

if($ncas_account==""){echo "<font color='brown' size='5'>Oops:We did not receive all the Values from your Form<br /><br />Click the BACK button on your Browser to complete Form </font><br />";exit;}

//if($ncas_invoice_num==""){echo "<font color='brown' size='5'>Oops:We did not receive all the Values from your Form<br /><br />Click the BACK button on your Browser to complete Form </font><br />";exit;}

if($id==""){echo "<font color='brown' size='5'>Oops:We did not receive all the Values from your Form<br /><br />Click the BACK button on your Browser to complete Form </font><br />";exit;}


// Retrieves the Current Fiscal Year

$query1a="SELECT report_year as 'fyear_active' from fiscal_year where active_year_concession_fees='y' ";

$result1a=mysqli_query($connection, $query1a) or die ("Couldn't execute query 1a. $query1a");

$row1a=mysqli_fetch_array($result1a);

extract($row1a);


echo "<br />f_year=$f_year<br />";
echo "<br />fyear_active=$fyear_active<br />";
//exit;

// Current Year Records

if($f_year==$fyear_active)
{

		   
$query12="update concessions_vendor_fees
          set f_year='$f_year',fee_period='$fee_period',park='$park',vendor_name='$vendor_name',fee_amount='$fee_amount',vendor_ck_num='$check_num',internal_deposit_num='$internal_deposit_num',
          ncas_center='$ncas_center',ncas_account='$ncas_account',entered_by='$Lname',system_entry_date='$system_entry_date' where id='$id' ";	
		  
echo "<br />current year query12=$query12<br />";
//exit;		  
	
$result12=mysqli_query($connection, $query12) or die ("Couldn't execute query 12. $query12");

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

/*
$rbh_field='cy_amount';

$query1="select sum(fee_amount) as 'rbh_value' from concessions_vendor_fees where f_year='$f_year' and park='$park' and vendor_name='$vendor_name' ";
		 
echo "query1=$query1<br />";		 

$result1 = mysqli_query($connection, $query1) or die ("Couldn't execute query 1.  $query1");

$row1=mysqli_fetch_array($result1);
extract($row1);	
	
	
echo "<br /><br />rbh_field=$rbh_field<br /><br />";	
echo "<br /><br />rbh_value=$rbh_value<br /><br />";

echo "<br /><br />edit_record_concession_vendor_fees.php:  Line 143 <br /><br />";


$query2="update rbh_multiyear_concession_fees3
         set $rbh_field='$rbh_value'
		 where park='$park' and vendor='$vendor_name' ";
		 
$result2 = mysqli_query($connection, $query2) or die ("Couldn't execute query 2.  $query2");


//exit;		
*/	
	
}

// Previous Year Records

if($f_year!=$fyear_active)
{

$query12="update concessions_vendor_fees
          set f_year='$f_year',fee_period='$fee_period',park='$park',vendor_name='$vendor_name',fee_amount='$fee_amount',vendor_ck_num='$check_num',internal_deposit_num='$internal_deposit_num',
          ncas_center='$ncas_center',ncas_account='$ncas_account',entered_by='$Lname',system_entry_date='$system_entry_date' where id='$id' ";	
		  
echo "<br />previous year query12=$query12<br />";
//exit;	  
		  
	
$result12=mysqli_query($connection, $query12) or die ("Couldn't execute query 12. $query12");


}

echo "<br />End of Page<br />";
//exit;



header("location: vendor_fees_drilldown1.php?park=$park&vendor_name=$vendor_name&f_year=$f_year");





?>