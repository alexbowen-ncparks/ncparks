<?php
//echo "Welcome to Step6"; exit;
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
		   where 1 and center != '1680507' group by center ; 
		   "; 
		   
	//echo "<br />Query2=$query2";			   
			
 $result2 = mysqli_query($connection, $query2) or die ("Couldn't execute query 2.  $query2 ");
 
 $query3="insert into crs_tdrr_cc_adj
           (center,ncas_account,amount)
		   select center,'434410003',-sum(oob)
		   from crs_taxes2
		   where 1 and center != '1680507' group by center ; 
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
 
 
$query5a="update crs_tdrr_cc,center_taxes
            set crs_tdrr_cc.parkcode=center_taxes.parkcode
            where crs_tdrr_cc.center=center_taxes.center
			and crs_tdrr_cc.center='1680507' ; ";
		   
//echo "<br />Query5a=$query5a";		   
			
$result5a = mysqli_query($connection, $query5a) or die ("Couldn't execute query 5a.  $query5a "); 
 
 
 

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
 

$query25="update crs_tdrr_cc_all
set center='2235',
parkcode='PART',
company_type='4602',
depositid_cc='$deposit_ccgift'
where
ncas_account='000218110'
and depositid_cc='$deposit_dates';
";



/*
$query25="update crs_tdrr_cc_all
set center='1680504',
parkcode='ADMI',
company_type='4601',
ncas_account='434390005'
where
ncas_account='000218110'
and depositid_cc='$deposit_dates';
";
*/
		   
//echo "<br />Query25=$query25";		   
			
 $result25 = mysqli_query($connection, $query25) or die ("Couldn't execute query 25.  $query25 ");


// comments added on 12/29/19 (t bass) 
 // The current File:  "bank_deposits_menu_cc_test_mod6.php" is an INCLUDE File in:  /budget/concessions/bank_deposits_menu_cc_test.php. 
 // Go to File: /budget/concessions/bank_deposits_menu_cc_test.php and notice that their are numerous INCLUDE Files. The current File only gets INCLUDED if $step=6
 
 // "Credit Card transaction data" is provided periodically to the DPR "Administrator of Cash Receipts Journals". (Budget Office-Heide Rumble) via CSV File.
 // The CSV data always includes a small number of transactions without a valid ncas account number
 // The original WebPage for Uploading the CSV File takes place in /budget/concessions/bank_deposits_menu_cc_test.php  (if $step=1)
      // The Original WebPage has several INCLUDES (step1, step1a, step2, step3, step4, step6). 
	  //These are the Steps "Administrator" must perform to 1) bring CSV Data into MoneyCounts 2)Cleanup data 3)Add additional field data
	  //Step 1 has a task to complete (ie. Upload CSV File).  Once complete, the remaining steps (1a,2,3,4,6) (with their own INCLUDE Files) are performed    
 
// Originally, one of the Cleanup Steps (Step4) was used to deal with those "transactions without a valid ncas account number".
// For the sake of simplicity, ncas account number 434410003 (camping) was assigned to those small number of Credit Card transactions without a Valid ncas account number
// As it turns out NOT ALL Parks on CRS System actually have Camping at their Park
// The QUERY below is designed to be "park specific" when assigning a Valid ncas account number for those CRS Parks.
// All of these transactions ("original transactions from CSV File" +  "adjusting entries") reside in TABLE=crs_tdrr_cc_all 
// In one of the previous Steps (step3-form &step4-query update)"Administrator" assigned a Unique Deposit ID for transactions in the current UPLOAD (crs_tdrr_cc_all.depositid_cc_all.depositid_cc) 

// The Query below must make sure it only Updates records in TABLE=crs_tdrr_cc_all that meet a certain criteria
    // A) must update only records for the specific Deposit ID for the New Upload (assigned in previous Steps 3&4)
	// B) must update only records where crs_tdrr_cc_all.entry_type='adjustment'
	// C) must update only records where ncas_account=434410003 (crs_tdrr_cc_all.ncas_account='434410003')
	// D) The source for the "park specific ncas account number" comes form TABLE=center.crj_cc_account2adjust
 
 $query25a="update crs_tdrr_cc_all as t1,center as t2
            set t1.ncas_account=t2.crj_cc_account2adjust
            where t1.depositid_cc='$deposit_dates'
			and t1.entry_type='adjustment'
			and t1.ncas_account='434410003'
			and t1.center=t2.new_center
			and t2.new_center != '' ";

		   
//echo "<br />Query25a=$query25a";		   
			
 $result25a = mysqli_query($connection, $query25a) or die ("Couldn't execute query 25a.  $query25a ");
 
 $query25b="update crs_tdrr_cc_all as t1,crs_tdrr_cc_accounts as t2
            set t1.account_name=t2.account_name,t1.rank=t2.rank
            where t1.depositid_cc='$deposit_dates'
			and t1.entry_type='adjustment'
            and t1.ncas_account=t2.ncas_account ";

		   
//echo "<br />Query25b=$query25b";		   
			
 $result25b = mysqli_query($connection, $query25b) or die ("Couldn't execute query 25b.  $query25b ");
 
 
 
 $query25c="update crs_tdrr_cc_all 
            set new_date=concat(mid(transaction_date,7,4),mid(transaction_date,1,2),mid(transaction_date,4,2)) 
			WHERE depositid_cc='$deposit_dates' ";

		   
//echo "<br />Query25c=$query25c";		   
			
 $result25c = mysqli_query($connection, $query25c) or die ("Couldn't execute query 25c.  $query25c ");
 
 
 $query26="update crs_tdrr_cc_all set depositid_cc_last_deposit='$today_date' where  depositid_cc='$deposit_dates'; ";

		   
//echo "<br />Query26=$query26";		   
			
 $result26 = mysqli_query($connection, $query26) or die ("Couldn't execute query 26.  $query26 ");
 
 
 
 
 
 
$query26a="select min(new_date) as 'start_date' from crs_tdrr_cc_all where depositid_cc='$deposit_dates' and entry_type != 'adjustment' ";

		   
//echo "<br />Query26a=$query26a";		   
			
$result26a = mysqli_query($connection, $query26a) or die ("Couldn't execute query 26a.  $query26a ");
 
$row26a=mysqli_fetch_array($result26a);

extract($row26a); 
 
 
$query26b="select max(new_date) as 'end_date' from crs_tdrr_cc_all where depositid_cc='$deposit_dates' and entry_type != '$adjustment' ";

		   
//echo "<br />Query26b=$query26b";		   
			
$result26b = mysqli_query($connection, $query26b) or die ("Couldn't execute query 26b.  $query26b ");
 
$row26b=mysqli_fetch_array($result26b);

extract($row26b);  
 
 
$query26c="select sum(amount) as 'tax_adjust',count(id) as 'tax_adjust_count' 
           from crs_tdrr_cc_all
           where depositid_cc='$deposit_dates' and ncas_account='000211940' and entry_type='adjustment' ";

		   
//echo "<br />Query26c=$query26c";		   
			
$result26c = mysqli_query($connection, $query26c) or die ("Couldn't execute query 26c.  $query26c ");
 
$row26c=mysqli_fetch_array($result26c);

extract($row26c);  
 
 
$query26d="select sum(amount) as 'revenue_adjust',count(id) as 'revenue_adjust_count' 
           from crs_tdrr_cc_all
		   where depositid_cc='$deposit_dates' and (ncas_account != '000211940' and ncas_account != '000300000') and entry_type='adjustment' ";

		   
//echo "<br />Query26d=$query26d";		   
			
$result26d = mysqli_query($connection, $query26d) or die ("Couldn't execute query 26d.  $query26d ");
 
$row26d=mysqli_fetch_array($result26d);

extract($row26d);
 
 
 
$query27="insert into crs_tdrr_cc_all_deposits(`depositid_cc`, `depositid_cc_entry_date`, `amount_total`, `f_year`, `start_date`, `end_date`,`tax_adjust`,`tax_adjust_count`,`revenue_adjust`,`revenue_adjust_count`)
          select `depositid_cc`, `depositid_cc_last_deposit`, sum(`amount`), `f_year`, '$start_date', '$end_date','$tax_adjust','$tax_adjust_count','$revenue_adjust','$revenue_adjust_count'
          from crs_tdrr_cc_all
          where 1 and depositid_cc='$deposit_dates'
          group by f_year,depositid_cc ";

		   
//echo "<br />Query27=$query27";		   
			
$result27 = mysqli_query($connection, $query27) or die ("Couldn't execute query 27.  $query27 "); 
 
 
 
$query27a="update crs_tdrr_cc_all set depositid_cc_last_deposit='$today_date' where  depositid_cc='$deposit_ccgift'; ";

		   
//echo "<br />Query27a=$query27a";		   
			
$result27a = mysqli_query($connection, $query27a) or die ("Couldn't execute query 27a.  $query27a "); 
 
 
 
 $query27b="insert into crs_tdrr_cc_all_deposits(`depositid_cc`, `depositid_cc_entry_date`, `amount_total`, `f_year`)
          select `depositid_cc`, `depositid_cc_last_deposit`, sum(`amount`), `f_year`
          from crs_tdrr_cc_all
          where 1 and depositid_cc='$deposit_ccgift'
          group by f_year,depositid_cc ";

		   
//echo "<br />Query27b=$query27b";		   
			
$result27b = mysqli_query($connection, $query27b) or die ("Couldn't execute query 27b.  $query27b "); 
 
 
 
 
 
 
 //echo "ok"; 
header("location: bank_deposits_menu_cc_test.php?step=1");
 
?>