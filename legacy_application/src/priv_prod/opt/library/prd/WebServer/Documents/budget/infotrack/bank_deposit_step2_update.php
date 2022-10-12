<?php

//echo "<pre>";print_r($_REQUEST);echo "</pre>"; //exit;
session_start();
if(!$_SESSION["budget"]["tempID"]){echo "access denied";exit;}

//echo "<pre>";print_r($_SESSION);echo "</pre>"; //exit;
$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempid=$_SESSION['budget']['tempID'];
$beacnum=$_SESSION['budget']['beacon_num'];
$concession_location=$_SESSION['budget']['select'];
$concession_center=$_SESSION['budget']['centerSess'];


if($concession_location=='ADM'){$concession_location='ADMI';}

echo "concession_location=$concession_location<br /><br />";

//echo "tempid=$tempid<br /><br />";
//echo "level=$level<br /><br />";
//echo "concession_center=$concession_center<br /><br />";
//echo "concession_location=$concession_location<br /><br />"; exit;


//echo "hello<br /><br />";

//echo $tempid;
extract($_REQUEST);
$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
include("../../../../include/activity.php");// database connection parameters
//echo "submit1=$submit1";echo "submit2=$submit2";exit;
echo "num14=$num14<br /><br />";
//echo "<pre>";print_r($_REQUEST);"</pre>"; exit;



$system_entry_date=date("Ymd");




$query1="update crs_deposit_counts SET";
for($j=0;$j<$num14;$j++){
$query2=$query1;


$total_amount2=$total_amount[$j];
$total_amount2=str_replace(",","",$total_amount2);
$total_amount2=str_replace("$","",$total_amount2);
//if($total_amount2=='0.00'){continue;}



$cash_amount2=$cash_amount[$j];
$cash_amount2=str_replace(",","",$cash_amount2);
$cash_amount2=str_replace("$","",$cash_amount2);
//if($cash_amount2=='0.00'){continue;}


$check_amount2=$check_amount[$j];
$check_amount2=str_replace(",","",$check_amount2);
$check_amount2=str_replace("$","",$check_amount2);
//if($cash_amount2=='0.00'){continue;}



$sales_location2=$sales_location[$j];

	//$query2.=" payment_type='$payment_type2',";
	$query2.=" sales_total='$total_amount2',";
	//$query2.=" account_name='$account_name2',";
	$query2.=" cash_total='$cash_amount2',";
	$query2.=" check_total='$check_amount2' ";
	$query2.=" where manual_deposit_id='$manual_deposit_id' and sales_location='$sales_location2'";
	
		
	
echo "query2=$query2<br /><br />";		

$result2=mysqli_query($connection, $query2) or die ("Couldn't execute query 2. $query2");
}	

echo "Update Successful<br /><br />";
echo "<img height='40' width='40' src='/budget/infotrack/icon_photos/green_checkmark1.png' alt='picture of home'></img>";	 
/*

$query4="update crs_tdrr_division_history_parks_manual,crs_products_park
         set crs_tdrr_division_history_parks_manual.ncas_account=crs_products_park.revenue_account,
		     crs_tdrr_division_history_parks_manual.account_name=crs_products_park.revenue_name
         where crs_tdrr_division_history_parks_manual.product_name=crs_products_park.product_name		 
		 and crs_tdrr_division_history_parks_manual.concession_location='$concession_location'		 
		 and crs_products_park.park='$concession_location'
		 and crs_tdrr_division_history_parks_manual.deposit_transaction='n'
          ";
		 
echo "query4=$query4<br />";

$result4=mysqli_query($connection, $query4) or die ("Couldn't execute query 4. $query4");	




$query6="update crs_tdrr_division_history_parks_manual,coa
         set crs_tdrr_division_history_parks_manual.account_taxable='y'
		 where crs_tdrr_division_history_parks_manual.ncas_account=coa.ncasnum2
		 and coa.taxable='y'
		 and crs_tdrr_division_history_parks_manual.concession_location='$concession_location'
         and crs_tdrr_division_history_parks_manual.deposit_transaction='n'  ";
		 


$result6=mysqli_query($connection, $query6) or die ("Couldn't execute query 6. $query6");	



$query7="update crs_tdrr_division_history_parks_manual,center_taxes
         set crs_tdrr_division_history_parks_manual.taxcenter=center_taxes.taxcenter,
         crs_tdrr_division_history_parks_manual.tax_rate=center_taxes.tax_rate_total
         where crs_tdrr_division_history_parks_manual.center=center_taxes.center 
         and crs_tdrr_division_history_parks_manual.concession_location='$concession_location'
         and crs_tdrr_division_history_parks_manual.deposit_transaction='n'	 ";
		 
//echo "query7=$query7<br />";


$result7=mysqli_query($connection, $query7) or die ("Couldn't execute query 7. $query7");	

//echo "Update Successful<br /><br />";
//exit;


$query8="update crs_tdrr_division_history_parks_manual
         set tax_factor='1.00'
         where account_taxable='n'	
         and concession_location='$concession_location'
         and deposit_transaction='n'  ";
		 
//echo "query8=$query8<br />";

$result8=mysqli_query($connection, $query8) or die ("Couldn't execute query 8. $query8");	



$query9="update crs_tdrr_division_history_parks_manual
         set tax_factor=1+(tax_rate/100)
         where account_taxable='y'	
         and concession_location='$concession_location'
         and deposit_transaction='n'  ";
		 
//echo "query9=$query9<br />";

$result9=mysqli_query($connection, $query9) or die ("Couldn't execute query 9. $query9");	


$query10="update crs_tdrr_division_history_parks_manual
         set pretax_amount=amount,
		 sales_tax='0.00'
         where account_taxable='n'	
         and concession_location='$concession_location'
         and deposit_transaction='n'  ";
		 
//echo "query10=$query10<br />";

$result10=mysqli_query($connection, $query10) or die ("Couldn't execute query 10. $query10");	

$query11="update crs_tdrr_division_history_parks_manual
         set pretax_amount=amount/tax_factor
		 where account_taxable='y'	
         and concession_location='$concession_location'
         and deposit_transaction='n'  ";
		 
//echo "query11=$query11<br />";

$result11=mysqli_query($connection, $query11) or die ("Couldn't execute query 11. $query11");	

$query12="update crs_tdrr_division_history_parks_manual
         set sales_tax=amount-pretax_amount
		 where account_taxable='y'	
         and concession_location='$concession_location'
         and deposit_transaction='n'  ";
		 
//echo "query12=$query12<br />";

$result12=mysqli_query($connection, $query12) or die ("Couldn't execute query 12. $query12");	



//echo "Update Successful<br /><br />";

	 

header("location: page2_form.php?edit=y");

//header("location: crs_deposit_transactions_manual.php?concession_center=$concession_center&concession_location=$concession_location&edit=y");
*/
 
 ?>




















