<?php
//echo "Welcome to Step6";
//$deposit_dates='06060606';
//$deposit_id='9000';
/*
$query1="truncate table crs_tdrr_cc_adj;";
 echo "<br />Query1=$query1";		
 $result1 = mysqli_query($connection, $query1) or die ("Couldn't execute query 1.  $query1 ");
 */
 
$today_date=date("Ymd");
 
 
 $query2="insert into crs_tdrr_cc_adj
           (center,ncas_account,amount)
		   select center,'000211940',sum(oob)
		   from crs_taxes2
		   where 1 group by center ; 
		   "; 
		   
	//echo "<br />Query2=$query2";			   
			
 $result2 = mysqli_query($connection, $query2) or die ("Couldn't execute query 2.  $query2 ");
 
 $query3="insert into crs_tdrr_cc_adj
           (center,ncas_account,amount)
		   select center,'434410003',-sum(oob)
		   from crs_taxes2
		   where 1 group by center ; 
		   "; 
		   
	//echo "<br />Query3=$query3";			   
			
 $result3 = mysqli_query($connection, $query3) or die ("Couldn't execute query 3.  $query3 ");
 
 
 
 
 $query4="update crs_tdrr_cc_adj
           set depositid_cc='$deposit_dates'
           where 1; ";
		   
//echo "<br />Query4=$query4";		   
			
 $result4 = mysqli_query($connection, $query4) or die ("Couldn't execute query 4.  $query4 "); 
 
 
 $query5="update crs_tdrr_cc_adj,center_taxes
            set crs_tdrr_cc_adj.parkcode=center_taxes.parkcode
            where crs_tdrr_cc_adj.center=center_taxes.center; ";
		   
//echo "<br />Query5=$query5";		   
			
 $result5 = mysqli_query($connection, $query5) or die ("Couldn't execute query 5.  $query5 "); 

$query6="insert into crs_tdrr_cc_all(
transaction_date,
revenue_location_id,
revenue_location_name,
payment_type,
amount,
revenue_type,
company_type,
revenue_code,
account_name,
batch_deposit_date,
batch_id,
deposit_id,
revenue_note,
center,
ncas_account,
taxcenter,
parkcode,
depositid_cc,
rank,
entry_type)
select
transaction_date,
revenue_location_id,
revenue_location_name,
payment_type,
amount,
revenue_type,
company_type,
revenue_code,
account_name,
batch_deposit_date,
batch_id,
deposit_id,
revenue_note,
center,
ncas_account,
taxcenter,
parkcode,
depositid_cc,
rank,
entry_type
from crs_tdrr_cc
where depositid_cc='$deposit_dates';
";
		   
//echo "<br />Query6=$query6";		   
			
 $result6 = mysqli_query($connection, $query6) or die ("Couldn't execute query 6.  $query6 "); 
 
 
$query7="insert into crs_tdrr_cc_all(
depositid_cc,
parkcode,
ncas_account,
center,
amount,
entry_type)
select
depositid_cc,
parkcode,
ncas_account,
center,
amount,'adjustment'
from crs_tdrr_cc_adj
where depositid_cc='$deposit_dates';
";
		   
//echo "<br />Query7=$query7";		   
			
 $result7 = mysqli_query($connection, $query7) or die ("Couldn't execute query 7.  $query7 "); 
 
 
$query8="update crs_tdrr_cc_all,center_taxes 
set crs_tdrr_cc_all.taxcenter=center_taxes.taxcenter
where crs_tdrr_cc_all.center=center_taxes.center
and entry_type='adjustment'
and depositid_cc='$deposit_dates';
";
		   
//echo "<br />Query8=$query8";		   
			
$result8 = mysqli_query($connection, $query8) or die ("Couldn't execute query 8.  $query8 ");
 
$query9="update crs_tdrr_cc_all
set company_type='1601'
where entry_type='adjustment'
and depositid_cc='$deposit_dates';
";
		   
//echo "<br />Query9=$query9";		   
			
 $result9 = mysqli_query($connection, $query9) or die ("Couldn't execute query 9.  $query9 ");
 
$query10="update crs_tdrr_cc_all,crs_tdrr_cc_accounts
set crs_tdrr_cc_all.account_name=crs_tdrr_cc_accounts.account_name
where crs_tdrr_cc_all.ncas_account=crs_tdrr_cc_accounts.ncas_account
and entry_type='adjustment'
and depositid_cc='$deposit_dates';
";
		   
//echo "<br />Query10=$query10";		   
			
 $result10 = mysqli_query($connection, $query10) or die ("Couldn't execute query 10.  $query10 ");
 
 $query11="update crs_tdrr_cc_all,crs_tdrr_cc_accounts
set crs_tdrr_cc_all.rank=crs_tdrr_cc_accounts.rank
where crs_tdrr_cc_all.ncas_account=crs_tdrr_cc_accounts.ncas_account
and entry_type='adjustment'
and depositid_cc='$deposit_dates';
";
		   
//echo "<br />Query11=$query11";		   
			
 $result11 = mysqli_query($connection, $query11) or die ("Couldn't execute query 11.  $query11 ");
 
 
$query11a="update crs_tdrr_cc_all
           set old_center=center
           where depositid_cc='$deposit_dates';
";
		   
//echo "<br />Query11=$query11";		   
			
 $result11a = mysqli_query($connection, $query11a) or die ("Couldn't execute query 11a.  $query11a ");
 
 
 
$query11b="update crs_tdrr_cc_all,center
           set crs_tdrr_cc_all.center=center.new_center
           where crs_tdrr_cc_all.old_center=center.old_center
           and depositid_cc='$deposit_dates';
";
		   
//echo "<br />Query11=$query11";		   
			
 $result11b = mysqli_query($connection, $query11b) or die ("Couldn't execute query 11b.  $query11b ");
 
 
$query11c="update crs_tdrr_cc_all
           set crs_tdrr_cc_all.company_type='4601'
           where depositid_cc='$deposit_dates';
";
		   
//echo "<br />Query11=$query11";		   
			
 $result11c = mysqli_query($connection, $query11c) or die ("Couldn't execute query 11c.  $query11c ");
 
 
  
 
 
//echo "deposit_dates=$deposit_dates";
$deposit_ccgift=$deposit_dates.GC;
//echo "deposit_ccgift=$deposit_ccgift";
 //echo "depositid_gift=$deposit_dates.GC";
 
/*
$query25="update crs_tdrr_cc_all
set center='2235',
parkcode='PART',
company_type='4602',
depositid_cc='$deposit_ccgift'
where
ncas_account='000218110'
and depositid_cc='$deposit_dates';
";
*/

$query25="update crs_tdrr_cc_all
set center='1680504',
parkcode='ADMI',
company_type='4601',
ncas_account='434390005'
where
ncas_account='000218110'
and depositid_cc='$deposit_dates';
";

		   
//echo "<br />Query25=$query25";		   
			
 $result25 = mysqli_query($connection, $query25) or die ("Couldn't execute query 25.  $query25 ");
 
 
 
 $query26="update crs_tdrr_cc_all set depositid_cc_last_deposit='$today_date' where  depositid_cc='$deposit_dates'; ";

		   
//echo "<br />Query26=$query26";		   
			
 $result26 = mysqli_query($connection, $query26) or die ("Couldn't execute query 26.  $query26 ");
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 //echo "ok"; 
header("location: bank_deposits_menu_cc_test.php?step=1");
 
?>