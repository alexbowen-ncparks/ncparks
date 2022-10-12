<?php

//echo "<pre>";print_r($_REQUEST);echo "</pre>";exit;
session_start();
if(!$_SESSION["budget"]["tempID"]){echo "access denied";exit;}

//echo "<pre>";print_r($_SESSION);echo "</pre>"; //exit;
$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempid=$_SESSION['budget']['tempID'];
//echo $tempid;
extract($_REQUEST);
$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
include("../../../../../include/activity.php");// database connection parameters
//echo "submit1=$submit1";echo "submit2=$submit2";exit;
//echo "<pre>";print_r($_REQUEST);"</pre>"; exit;



//$system_entry_date=date("Ymd");

$transaction_date = substr($orms_deposit_date,5,2)."/".substr($orms_deposit_date,8,2)."/".substr($orms_deposit_date,0,4);

//echo "transaction_date=$transaction_date<br />"; exit;


$query1="insert into crs_tdrr_division_history_parks SET";
for($j=0;$j<4;$j++){
$query2=$query1;

$amount2=$amount[$j];
$amount2=str_replace(",","",$amount2);
$amount2=str_replace("$","",$amount2);
if($amount2==''){continue;}
//$payment_type2=addslashes($payment_type[$j]);
//$account_name2=addslashes($account_name[$j]);
$ncas_account2=($ncas_account[$j]);
//$comments2=addslashes($comments);

	//$query2.=" payment_type='$payment_type2',";
	$query2.=" amount='$amount2',";
	//$query2.=" account_name='$account_name2',";
	$query2.=" deposit_id='$deposit_id',";
	$query2.=" revenue_location_id='$old_center',";
	$query2.=" transaction_location_id='$old_center',";
	$query2.=" center='$new_center',";
	$query2.=" new_center='$new_center',";
	$query2.=" old_center='$old_center',";
	$query2.=" taxcenter='$taxcenter',";
	$query2.=" ncas_account='$ncas_account2',";
	$query2.=" transaction_date='$transaction_date',";
	$query2.=" transdate_new='$orms_deposit_date',";
	$query2.=" deposit_date_new='$orms_deposit_date',";
	$query2.=" deposit_transaction='y',";
	$query2.=" source='manual',";
	$query2.=" payment_type='cash',";
	$query2.=" adjustment='y',";
	$query2.=" fs_comments='$comments'";
	
	
//echo "query2=$query2<br />";		

$result=mysqli_query($connection, $query2) or die ("Couldn't execute query 2. $query2");
}	







$query3="update crs_tdrr_division_history_parks
         set ncas_account=lpad(ncas_account,9,'0')
         where center='$center'
         and deposit_id='$deposit_id'
         and source='manual' ";
		 
//echo "query3=$query3<br />";

$result3=mysqli_query($connection, $query3) or die ("Couldn't execute query 3. $query3");		 






$query4="update crs_tdrr_division_history_parks,coa
         set crs_tdrr_division_history_parks.account_name=coa.park_acct_desc
         where 
		 crs_tdrr_division_history_parks.ncas_account=coa.ncasnum2		 
		 and crs_tdrr_division_history_parks.center='$new_center'
         and crs_tdrr_division_history_parks.deposit_id='$deposit_id'
         and crs_tdrr_division_history_parks.source='manual' ";
		 
//echo "query4=$query4<br />";

$result4=mysqli_query($connection, $query4) or die ("Couldn't execute query 4. $query4");	





$query5="update crs_tdrr_division_history_parks
         set account_name='over_short'
         where ncas_account='000437995'
		 and center='$new_center'
         and deposit_id='$deposit_id'
         and source='manual'  ";
		 
//echo "query5=$query5<br />";

$result5=mysqli_query($connection, $query5) or die ("Couldn't execute query 5. $query5");	





	 
$query5a="update crs_tdrr_division_history_parks
         set account_name='over_short'
         where ncas_account='000437995'
		 and center='$new_center'
         and deposit_id='$deposit_id'
         and source='manual'  ";
		 
//echo "query5=$query5<br />";

$result5a=mysqli_query($connection, $query5a) or die ("Couldn't execute query 5a. $query5a");		 
	 

	 
	 
	 

header("location: crs_deposits_crj_reports_final.php?deposit_id=$deposit_id&GC=n");

 
 ?>




















