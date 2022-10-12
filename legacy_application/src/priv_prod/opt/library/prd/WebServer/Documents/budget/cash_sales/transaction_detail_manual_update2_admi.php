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
if($concession_location=='ADMI'){$sales_location='financial services group';}
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

//$transaction_date = substr($orms_deposit_date,5,2)."/".substr($orms_deposit_date,8,2)."/".substr($orms_deposit_date,0,4);

//echo "transaction_date=$transaction_date<br />"; exit;


// Assumptions: Only Park Staff with level=1 will create Deposits.  All Monies will be Credited to the Park CENTER (1 Center ONLY)

//if($level==1)
{
$query1="update crs_tdrr_division_history_parks_manual SET";
for($j=0;$j<$num14;$j++){
$query2=$query1;
$center2=$center[$j];
$amount2=$amount[$j];
$amount2=str_replace(",","",$amount2);
$amount2=str_replace("$","",$amount2);
if($amount2=='0.00'){continue;}
//$payment_type2=addslashes($payment_type[$j]);
//$account_name2=addslashes($account_name[$j]);
$product_name2=addslashes($product_name[$j]);
if($product_name2==''){continue;}

$comment2=addslashes($comment[$j]);
//if($product_name2==''){continue;}


$payment_type2=($payment_type[$j]);
if($payment_type2==''){continue;}

//$id2=($id[$j]);

//$comments2=addslashes($comments);

	//$query2.=" payment_type='$payment_type2',";
	$query2.=" amount='$amount2',";
	$query2.=" center='$center2',";
	//$query2.=" account_name='$account_name2',";
	$query2.=" payment_type='$payment_type2',";
	$query2.=" sales_location='$sales_location',";
	$query2.=" comment='$comment2',";
	$query2.=" product_name='$product_name2'";
	$query2.=" where id='$id[$j]'";
	//$query2.=" concession_location='$concession_location',";
	//$query2.=" center='$concession_center',";
	//$query2.=" entered_by='$tempid',";
	//$query2.=" sed='$system_entry_date',";
	//$query2.=" transdate_new='$system_entry_date',";
	//$query2.=" ncas_account='$ncas_account2'";
		
	
echo "query2=$query2<br />";		

$result2=mysqli_query($connection, $query2) or die ("Couldn't execute query 2. $query2");
}	
}

echo "Update Successful<br /><br />";
exit;

// Assumption: Only Raleigh Staff with level > 3 will Create Deposits with Monies for credit to multiple Centers
/*
if($level>3)
{
$query1="insert into crs_tdrr_division_history_parks_manual SET";
for($j=0;$j<9;$j++){
$query2=$query1;

$amount2=$amount[$j];
$amount2=str_replace(",","",$amount2);
$amount2=str_replace("$","",$amount2);
if($amount2==''){continue;}
//$payment_type2=addslashes($payment_type[$j]);
//$account_name2=addslashes($account_name[$j]);
$ncas_account2=($ncas_account[$j]);
if($ncas_account2==''){continue;}

$payment_type2=($payment_type[$j]);
if($payment_type2==''){continue;}

$center3=($center2[$j]);
if($center3==''){continue;}


//$comments2=addslashes($comments);

	//$query2.=" payment_type='$payment_type2',";
	$query2.=" amount='$amount2',";
	//$query2.=" account_name='$account_name2',";
	$query2.=" payment_type='$payment_type2',";
	$query2.=" concession_location='$concession_location',";
	$query2.=" center='$center3',";
	$query2.=" entered_by='$tempid',";
	$query2.=" sed='$system_entry_date',";
	$query2.=" transdate_new='$system_entry_date',";
	$query2.=" ncas_account='$ncas_account2'";
		
	
//echo "query2=$query2<br />";		

$result2=mysqli_query($connection, $query2) or die ("Couldn't execute query 2. $query2");
}	
}
*/

//echo "Update Successful<br /><br />";


/*
$query3="update crs_tdrr_division_history_parks_manual
         set ncas_account=lpad(ncas_account,9,'0')
         where concession_location='$concession_location'
		 and deposit_transaction='n' ";
	
*/

	
//echo "query3=$query3<br />";

//$result3=mysqli_query($connection, $query3) or die ("Couldn't execute query 3. $query3");		 


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


/*
$query5="update crs_tdrr_division_history_parks_manual
         set account_name='over_short'
         where ncas_account='000437995'
		 and concession_location='$concession_location'
         and deposit_transaction='n'  ";
		 
//echo "query5=$query5<br />";

$result5=mysqli_query($connection, $query5) or die ("Couldn't execute query 5. $query5");	
*/

$query6="update crs_tdrr_division_history_parks_manual,coa
         set crs_tdrr_division_history_parks_manual.account_taxable='y'
		 where crs_tdrr_division_history_parks_manual.ncas_account=coa.ncasnum2
		 and coa.taxable='y'
		 and crs_tdrr_division_history_parks_manual.concession_location='$concession_location'
         and crs_tdrr_division_history_parks_manual.deposit_transaction='n'  ";
		 
//echo "query6=$query6<br />";


$result6=mysqli_query($connection, $query6) or die ("Couldn't execute query 6. $query6");	





/*
$query6a="update crs_tdrr_division_history_parks_manual,coa
         set crs_tdrr_division_history_parks_manual.account_name=coa.park_acct_desc
		 where crs_tdrr_division_history_parks_manual.ncas_account=coa.ncasnum2
		 and crs_tdrr_division_history_parks_manual.concession_location='$concession_location'
         and crs_tdrr_division_history_parks_manual.deposit_transaction='n'  ";
		 
//echo "query6a=$query6a<br />";


$result6a=mysqli_query($connection, $query6a) or die ("Couldn't execute query 6a. $query6a");	
*/



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

 
 ?>




















