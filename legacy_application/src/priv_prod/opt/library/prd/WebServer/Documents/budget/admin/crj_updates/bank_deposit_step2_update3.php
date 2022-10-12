<?php


session_start();
if(!$_SESSION["budget"]["tempID"]){echo "access denied";exit;}


//echo "<pre>";print_r($_REQUEST);echo "</pre>"; //exit;
//echo "<pre>";print_r($_SESSION);echo "</pre>"; //exit;
$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempid=$_SESSION['budget']['tempID'];
$beacnum=$_SESSION['budget']['beacon_num'];
$concession_location=$_SESSION['budget']['select'];
$concession_center=$_SESSION['budget']['centerSess'];
$concession_center_new=$_SESSION['budget']['centerSess_new'];


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

if($cashier_approved==""){echo "<font color='brown' size='5'><b>Cashier Approval missing<br /><br />Click the BACK button on your Browser to enter Cashier Approval</b></font><br />";exit;}


$query1="update crs_tdrr_division_history_parks_manual
         set depositor='$tempid',deposit_date_new='$system_entry_date',comment='$comment',deposit_transaction='y'
         where manual_deposit_id='$manual_deposit_id'  ";
		 
echo "query1=$query1<br />";		 

$result1 = mysqli_query($connection, $query1) or die ("Couldn't execute query 1.  $query1");


$query1a="delete from crs_tdrr_division_history_parks_manual
          where manual_deposit_id='$manual_deposit_id' 
		  and amount='0.00' ";
		 
echo "query1a=$query1a<br />";		 

$result1a = mysqli_query($connection, $query1a) or die ("Couldn't execute query 1a.  $query1a");





$query2="update crs_tdrr_division_deposits_manual
         set deposit_complete='y'
         where manual_deposit_id='$manual_deposit_id'  ";
		 
echo "query2=$query2<br />";		 

$result2 = mysqli_query($connection, $query2) or die ("Couldn't execute query 2.  $query2");




$query16d="insert into crs_tdrr_division_deposits
(crs,center,new_center,old_center,orms_deposit_id,orms_start_date,orms_end_date,orms_deposit_date,orms_deposit_amount,download_date)
select 'n',new_center,new_center,center,manual_deposit_id,min(transdate_new),max(transdate_new),deposit_date_new,sum(amount),'$system_entry_date'
from crs_tdrr_division_history_parks_manual
where manual_deposit_id='$manual_deposit_id' "; 

$result16d = mysqli_query($connection, $query16d) or die ("Couldn't execute query 16d.  $query16d ");




$query17d="update crs_tdrr_division_deposits,center
           set crs_tdrr_division_deposits.park=center.parkcode
		   where crs_tdrr_division_deposits.new_center=center.new_center 
		   and crs_tdrr_division_deposits.orms_deposit_id='$manual_deposit_id' "; 


		   
$result17d = mysqli_query($connection, $query17d) or die ("Couldn't execute query 17d.  $query17d ");



$query17d1="update crs_tdrr_division_deposits
           set orms_depositor='$tempid'
		   where orms_deposit_id='$manual_deposit_id' "; 


		   
$result17d1 = mysqli_query($connection, $query17d1) or die ("Couldn't execute query 17d1.  $query17d1 ");




$query17e="insert into crs_tdrr_division_history_parks(
dncr, 
crs,  
payment_type, 
product_name, 
amount,  
account_name, 
deposit_id,  
center,  
new_center,  
old_center,  
ncas_account,  
taxcenter,  
transdate_new,  
deposit_date_new, 
deposit_transaction,  
source  
)

SELECT
'y',
'n',
payment_type,
product_name,
pretax_amount,
account_name,
manual_deposit_id,
new_center,
new_center,
center,
ncas_account,
taxcenter,
transdate_new,
deposit_date_new,
deposit_transaction,
'mc'
FROM crs_tdrr_division_history_parks_manual
WHERE manual_deposit_id='$manual_deposit_id' "; 


echo "query17e=$query17e<br />"; //exit;

$result17e = mysqli_query($connection, $query17e) or die ("Couldn't execute query 17e.  $query17e ");




$query17f="insert into crs_tdrr_division_history_parks(
dncr, 
crs,  
payment_type, 
product_name, 
amount,  
account_name, 
deposit_id,  
center,  
new_center,  
old_center,  
ncas_account,  
taxcenter,  
transdate_new,  
deposit_date_new, 
deposit_transaction,  
source 
)

SELECT
'y',
'n',
payment_type,
product_name,
sales_tax,
account_name,
manual_deposit_id,
new_center,
new_center,
center,
'000211940',
taxcenter,
transdate_new,
deposit_date_new,
deposit_transaction,
'mc'
FROM crs_tdrr_division_history_parks_manual
WHERE manual_deposit_id='$manual_deposit_id'
and account_taxable='y' "; 


echo "query17f=$query17f<br />"; //exit;

$result17f = mysqli_query($connection, $query17f) or die ("Couldn't execute query 17f.  $query17f ");

//echo "Update Successful<br />"; exit;



$query17e1="insert ignore into crs_tdrr_division_deposits_checks(center,orms_deposit_id,check_count)
SELECT center, deposit_id AS 'orms_deposit_id', count( id )
FROM `crs_tdrr_division_history_parks`
WHERE 1
AND
(payment_type = 'mon ord'
OR payment_type = 'per chq'
OR payment_type = 'cert chq'
or payment_type = 'check'
)
and deposit_id='$manual_deposit_id'
GROUP BY center, orms_deposit_id "; 

$result17e1 = mysqli_query($connection, $query17e1) or die ("Couldn't execute query 17e1.  $query17e1 ");



$query17e2="update crs_tdrr_division_deposits,crs_tdrr_division_deposits_checks
            set crs_tdrr_division_deposits.checks='y'
			where crs_tdrr_division_deposits.orms_deposit_id=
			crs_tdrr_division_deposits_checks.orms_deposit_id
            and crs_tdrr_division_deposits.orms_deposit_id='$manual_deposit_id'	"; 

$result17e2 = mysqli_query($connection, $query17e2) or die ("Couldn't execute query 17e2.  $query17e2 ");




$query17f="update crs_tdrr_division_deposits
set trans_table='y'
where crs_tdrr_division_deposits.orms_deposit_id='$manual_deposit_id' ";


//and days_elapsed > '0' "; 



$result17f = mysqli_query($connection, $query17f) or die ("Couldn't execute query 17f.  $query17f ");



$query17i="update crs_tdrr_division_deposits
set f_year='1516'
where orms_deposit_date >= '20150702'
and orms_deposit_date <= '20160701'
and orms_deposit_id='$manual_deposit_id'
and f_year=''
"; 

$result17i = mysqli_query($connection, $query17i) or die ("Couldn't execute query 17i.  $query17i ");




echo "OK<br />";

//header("location: page2_form.php?step=2&edit=y&update1=y");



 
 ?>




















