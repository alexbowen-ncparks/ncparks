<?php
// 10/11/19:  php file formally known as 1) /budget/admin/pcard_updates/stepL3e2b.php  and 2) /budget/admin/pcard_updates/stepL3e2d1.php

//former stepL3e2b.php STARTS


//echo "<pre>";print_r($_REQUEST);echo "</pre>"; exit;
session_start();
//echo "<pre>";print_r($_SESSION);echo "</pre>";exit;
$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempid=$_SESSION['budget']['tempID'];
//echo $tempid;
extract($_REQUEST);
//echo "<pre>";print_r($_REQUEST);echo "</pre>";exit;
// ** CCOOPER if there's an issue with pulling pcards and you fall behind backdate here! $today_date="20220615";
$today_date=date("Ymd");


$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
//include("../../../../include/activity.php");// database connection parameters
//include("../../../include/activity.php");// database connection parameters
//include("/opt/library/prd/WebServer/include/activity.php"); // connection parameters

$query2a1="SELECT min(id) as 'week_id' from pcard_report_dates where active='n'";


//echo "query2a1=$query2a1<br />";
// The variable $result is a PHP resource containing the results of the MySQL query. Its contents can only be used by PHP.
$result2a1 = mysqli_query($connection, $query2a1) or die ("Couldn't execute query 2a1.  $query2a1");

$row2a1=mysqli_fetch_array($result2a1);
extract($row2a1);

//echo "week_id=$week_id<br />";

$query2a2="SELECT xtnd_start as 'start_date',xtnd_end as 'end_date',f_year as 'fiscal_year' 
           from pcard_report_dates where id='$week_id' ";


//echo "query2a2=$query2a2<br />";
// The variable $result is a PHP resource containing the results of the MySQL query. Its contents can only be used by PHP.
$result2a2 = mysqli_query($connection, $query2a2) or die ("Couldn't execute query 2a2.  $query2a2");

$row2a2=mysqli_fetch_array($result2a2);
extract($row2a2);
/*
echo "<br />start_date=$start_date<br />";
echo "<br />end_date=$end_date<br />";

echo "<br />Line: 50<br />"; 

exit;
*/

$end_date_header=$end_date;
$start_date2=str_replace("-","",$start_date);
$end_date2=str_replace("-","",$end_date);


$start_date2=str_replace("-","",$start_date);
$end_date2=str_replace("-","",$end_date);


////


$query2="update pcard set neg_amount='yes' where right(amount,1)='-' and right(amount,2) != '--' ";
		  
		  
mysqli_query($connection, $query2) or die ("Couldn't execute query 2.  $query2");


$query22="update pcard set neg_amount='no' where neg_amount != 'yes' ";
		  
		  
mysqli_query($connection, $query22) or die ("Couldn't execute query 22.  $query22");




$query2a="update pcard set amount2=concat('-',(LEFT(amount,LENGTH(amount)-1))) where neg_amount='yes' ";

//echo "<br />query2a=$query2a <br />"; exit;
		  
		  
mysqli_query($connection, $query2a) or die ("Couldn't execute query 2a.  $query2a");


$query2b="update pcard set amount2=concat('-',(LEFT(amount,LENGTH(amount)-1))) where neg_amount='yes' ";
		  
		  
mysqli_query($connection, $query2b) or die ("Couldn't execute query 2b.  $query2b");


$query2c="update pcard set amount3=amount where neg_amount='no' ";
		  
		  
mysqli_query($connection, $query2c) or die ("Couldn't execute query 2c.  $query2c");


$query2d="update pcard set amount3=amount2 where neg_amount='yes' ";
		  
		  
mysqli_query($connection, $query2d) or die ("Couldn't execute query 2d.  $query2d");



$query2d1="update pcard set amount=amount2 where neg_amount='yes' ";
		  
		  
mysqli_query($connection, $query2d1) or die ("Couldn't execute query 2d1.  $query2d1");



////



$query1="UPDATE pcard
         set cardholder=TRIM(cardholder),
		     division=trim(division),
			 post_date=trim(post_date),
			 trans_date=trim(trans_date),
			 amount=trim(amount),
			 merchant_name=trim(merchant_name),
			 city_state=trim(city_state),
			 trans_id=trim(trans_id),
			 card_number=trim(card_number)		 
		 ";
		  
		  
mysqli_query($connection, $query1) or die ("Couldn't execute query 1.  $query1");

/*  01-27-22: ccooper - was deleting 2022 data from pcard
		$query1a="delete from pcard where ((mid(post_date,7,4)<'2016'))";

	07-07-22: ccooper [TIC338] - had to add (mid(post_date,7,4)!='2022') to orig, in order to clean up the extra header information in the table.
	changing the refactored query to:
	"delete from pcard where ((mid(post_date,7,4)<'2016'))";
	was not capturing "non-year" data (ie. numbers)

	We tried "WHERE ((mid(post_date,7,4)!<'2015'));" and other "NOT()" variations but the NOT portion is not satifactory SQL code and does not run in Workbench.

	07-14-22: ccooper - Tony improved the logic of the statement, so I commented out the original (below):
	
	$query1a="delete from pcard
          where
		  (
		  (mid(post_date,7,4)!='2016') and
		  (mid(post_date,7,4)!='2017') and
		  (mid(post_date,7,4)!='2018') and
		  (mid(post_date,7,4)!='2019') and
		  (mid(post_date,7,4)!='2020') and
		  (mid(post_date,7,4)!='2021') and	  
		  (mid(post_date,7,4)!='2022')	    
		  )"; 
*/
 	$query1a="delete from pcard where (((mid(post_date,7,4))) NOT BETWEEN 2016 AND 2099)";        		  

 /* End 
	  01-27-2022: refactored code above.
 	  07-07-2022: refactor fails on text that is pulled into records (see budget.pcard information in OneNote for today) THIS is why the 2 report pcard file was not clearing properly.
 	    
	  07-14-2022: Tony logic change
*/		  

mysqli_query($connection, $query1a) or die ("Couldn't execute query 1a.  $query1a");


$query10="select count(id) as pc_record_count from budget.pcard where 1";

echo "query10=$query10";

$result10=mysqli_query($connection, $query10) or die ("Couldn't execute query 10. $query10");

$row10=mysqli_fetch_array($result10);

extract($row10);

if($pc_record_count<1){echo "<br /><br /><font color='red' size='5'>CSV File ERROR. NO Records Detected</font><br /><br />"; exit;}



$query11="select count(id) as pc_record_count from budget.pcard where card_number like '%E+%' ";

echo "query11=$query11";

$result11=mysqli_query($connection, $query11) or die ("Couldn't execute query 11. $query11");

$row11=mysqli_fetch_array($result11);

extract($row11);

if($pc_record_count>0){echo "<br /><br /><font color='red' size='5'>CSV File ERROR. Erroneous Records Detected</font><br /><br />"; exit;}


//echo "<br />pcard_weekly_report_add.php  LINE 201<br />";
//exit;

// 2022-07-08: ccooper - uncomment 'exit;' below when testing csv import
//exit;


$query1b="insert ignore into pcard_unreconciled_xtnd_temp2
         (cardholder,division,post_date,trans_date,amount,merchant_name,city_state,trans_id,card_number)
         select cardholder,division,post_date,trans_date,amount,merchant_name,city_state,trans_id,card_number
         from pcard
         where 1		 
		 ";
		  
		  
mysqli_query($connection, $query1b) or die ("Couldn't execute query 1b.  $query1b");

$query1c="update pcard_unreconciled_xtnd_temp2
          set xtnd_report_date='$end_date2'
		  where 1 ";
		  
		  
mysqli_query($connection, $query1c) or die ("Couldn't execute query 1c.  $query1c");

$query1d="update pcard_unreconciled_xtnd_temp2
         set card_number2=substring(card_number,-4)
         where 1		 ";
		  
		  
mysqli_query($connection, $query1d) or die ("Couldn't execute query 1d.  $query1d");



$query1e="
update pcard_users,pcard_unreconciled_xtnd_temp2
set pcard_users.cardholder_xtnd=pcard_unreconciled_xtnd_temp2.cardholder
where pcard_users.card_number=pcard_unreconciled_xtnd_temp2.card_number2
and pcard_unreconciled_xtnd_temp2.cardholder like concat('%',pcard_users.last_name,'%')
and pcard_users.cardholder_xtnd='' ";

mysqli_query($connection, $query1e) or die ("Couldn't execute query 1e.  $query1e");



$query1f="
update pcard_unreconciled_xtnd_temp2,pcard_users
set pcard_unreconciled_xtnd_temp2.division='DPR_MANUAL'
where pcard_unreconciled_xtnd_temp2.card_number2=pcard_users.card_number
and pcard_unreconciled_xtnd_temp2.cardholder=pcard_users.cardholder_xtnd
and (pcard_unreconciled_xtnd_temp2.division='canc' or pcard_unreconciled_xtnd_temp2.division=''); ";

mysqli_query($connection, $query1f) or die ("Couldn't execute query 1f.  $query1f");


$query1g="
update pcard_unreconciled_xtnd_temp2
set division='OTHER'
where (division='canc' or division='')
";

mysqli_query($connection, $query1g) or die ("Couldn't execute query 1g.  $query1g");


$query1h="update pcard_unreconciled_xtnd_temp2
         set dpr='y' where (division='park' or division='capi' or division='dpr_manual') ";



mysqli_query($connection, $query1h) or die ("Couldn't execute query 1h.  $query1h");


$query1j="update pcard_unreconciled_xtnd_temp2
         set dpr='n' where dpr!='y' ";



mysqli_query($connection, $query1j) or die ("Couldn't execute query 1j.  $query1j");







$query2a="update pcard_unreconciled_xtnd_temp2,pcard_users
             set pcard_unreconciled_xtnd_temp2.admin_num=pcard_users.admin,
		     pcard_unreconciled_xtnd_temp2.location=pcard_users.location,
		     pcard_unreconciled_xtnd_temp2.center=pcard_users.center,
		     pcard_unreconciled_xtnd_temp2.last_name=pcard_users.last_name,
		     pcard_unreconciled_xtnd_temp2.first_name=pcard_users.first_name,
			 pcard_unreconciled_xtnd_temp2.pcard_users_match='y',
			 pcard_unreconciled_xtnd_temp2.pcard_users_cardholder_match='y'
			 where pcard_unreconciled_xtnd_temp2.card_number2=pcard_users.card_number 
			 and pcard_unreconciled_xtnd_temp2.cardholder=pcard_users.cardholder_xtnd       
             and pcard_unreconciled_xtnd_temp2.dpr='y'
			 ";
		  
		  
mysqli_query($connection, $query2a) or die ("Couldn't execute query 2a.  $query2a");





$query2="update pcard_unreconciled_xtnd_temp2,pcard_users
         set pcard_unreconciled_xtnd_temp2.admin_num=pcard_users.admin,
		     pcard_unreconciled_xtnd_temp2.location=pcard_users.location,
		     pcard_unreconciled_xtnd_temp2.center=pcard_users.center,
		     pcard_unreconciled_xtnd_temp2.last_name=pcard_users.last_name,
		     pcard_unreconciled_xtnd_temp2.first_name=pcard_users.first_name,
			 pcard_unreconciled_xtnd_temp2.pcard_users_match='y'
			 where pcard_unreconciled_xtnd_temp2.card_number2=pcard_users.card_number
             and pcard_unreconciled_xtnd_temp2.dpr='y'
             and pcard_unreconciled_xtnd_temp2.pcard_users_match != 'y'			 ";
		  
		  
mysqli_query($connection, $query2) or die ("Couldn't execute query 2.  $query2");



//added 10/4/19

$query1k="update pcard_unreconciled_xtnd_temp2
         set dpr='n' where dpr='y' and pcard_users_match='n' ";



mysqli_query($connection, $query1k) or die ("Couldn't execute query 1k.  $query1k");



$query3="update pcard_unreconciled_xtnd_temp2
         set date_posted_new=concat(mid(post_date,7,4),mid(post_date,1,2),mid(post_date,4,2))
         where 1  ";
		  
		  
mysqli_query($connection, $query3) or die ("Couldn't execute query 3.  $query3");


$query4="update pcard_unreconciled_xtnd_temp2
         set date_purchased_new=concat(mid(trans_date,7,4),mid(trans_date,1,2),mid(trans_date,4,2))
         where 1  ";
		  
		  
mysqli_query($connection, $query4) or die ("Couldn't execute query 4.  $query4");



$query5="update pcard_unreconciled_xtnd_temp2
         set company='4601'
         where location='1656'  ";
		  
		  
mysqli_query($connection, $query5) or die ("Couldn't execute query 5.  $query5");





$query7="update pcard_unreconciled_xtnd_temp2
         set report_date='$end_date2'
         where 1  ";
		  
		  
mysqli_query($connection, $query7) or die ("Couldn't execute query 7.  $query7");


$query8="update pcard_unreconciled_xtnd_temp2
         set account_id=card_number2
         where 1  ";
		  
		  
mysqli_query($connection, $query8) or die ("Couldn't execute query 8.  $query8");



$query9="update pcard_unreconciled_xtnd_temp2
         set document=trans_id
         where 1  ";
		  
		  
mysqli_query($connection, $query9) or die ("Couldn't execute query 9.  $query9");


$query10="update pcard_unreconciled_xtnd_temp2
         set date_posted=concat(mid(post_date,1,2),'/',mid(post_date,4,2),'/',mid(post_date,9,2))
         where 1  ";
		  
		  
mysqli_query($connection, $query10) or die ("Couldn't execute query 10.  $query10");


$query11="update pcard_unreconciled_xtnd_temp2
         set date_purchased=concat(mid(trans_date,1,2),'/',mid(trans_date,4,2),'/',mid(trans_date,9,2))
         where 1  ";
		  
		  
mysqli_query($connection, $query11) or die ("Couldn't execute query 11.  $query11");
//echo "OK Line 129"; exit;



$query12="update pcard_unreconciled_xtnd_temp2
         set primary_account_holder=concat(last_name,',',' ',first_name)
         where 1  ";
		  
		  
mysqli_query($connection, $query12) or die ("Couldn't execute query 12.  $query12");





$query13="update pcard_unreconciled_xtnd_temp2
          set purchase_amount=amount,amount_allocated=amount,vendor=merchant_name
		  where 1 ";
		  
mysqli_query($connection, $query13) or die ("Couldn't execute query 13.  $query13");

//echo "<br />Line 368<br />"; exit;

/*
$query23a="update budget.project_substeps_detail set status='complete' where project_category='$project_category'
         and project_name='$project_name' and step_group='$step_group' and step_num='$step_num' and substep_num='$substep_num' ";
			 
mysqli_query($connection, $query23a) or die ("Couldn't execute query 23a.  $query23a");


{header("location: step$step_group$step_num.php?project_category=$project_category&project_name=$project_name&step_group=$step_group&step_num=$step_num ");}

*/

//former stepL3e2b.php ENDS

//former stepL3e2d1.php STARTS


$query1="insert ignore into pcard_unreconciled_xtnd_temp2_perm
(`xtnd_report_date`, `cardholder`, `division`, `pcard_users_match`, `post_date`, `trans_date`, `amount`, `merchant_name`, `city_state`, `trans_id`, `card_number`, `card_number2`, `dpr`, `admin_num`, `location`, `date_posted_new`, `date_purchased_new`, `company`, `center`, `last_name`, `first_name`, `report_date`, `account_id`, `document`, `date_posted`, `date_purchased`, `primary_account_holder`, `purchase_amount`, `vendor`, `amount_allocated`)
SELECT `xtnd_report_date`, `cardholder`, `division`, `pcard_users_match`, `post_date`, `trans_date`, `amount`, `merchant_name`, `city_state`, `trans_id`, `card_number`, `card_number2`, `dpr`, `admin_num`, `location`, `date_posted_new`, `date_purchased_new`, `company`, `center`, `last_name`, `first_name`, `report_date`, `account_id`, `document`, `date_posted`, `date_purchased`, `primary_account_holder`, `purchase_amount`, `vendor`, `amount_allocated`
from pcard_unreconciled_xtnd_temp2 where 1 ";
		  
		  
mysqli_query($connection, $query1) or die ("Couldn't execute query 1.  $query1");


$query2="update pcard_unreconciled_xtnd_temp2_perm
set xtnd_rundate=concat(mid(xtnd_report_date,6,2),'/',mid(xtnd_report_date,9,2),'/',mid(xtnd_report_date,3,2))
where 1 and xtnd_report_date='$end_date2' ";
	
//echo "query2=$query2<br />";  exit;	
		  
mysqli_query($connection, $query2) or die ("Couldn't execute query 2.  $query2");

$query3="update pcard_unreconciled_xtnd_temp2_perm
         set card_number=card_number2
         where 1 and xtnd_report_date='$end_date2' ";
		  
		  
mysqli_query($connection, $query3) or die ("Couldn't execute query 3.  $query3");


$query4="update pcard_unreconciled_xtnd_temp2_perm
         set center=''
		 where center='none'
		 and xtnd_report_date='$end_date2' ";


//echo "<br />query4=$query4<br />";  exit;



$result4 = mysqli_query($connection, $query4) or die ("Couldn't execute query 4.  $query4");



//stepL3e2d1a.php


$query5="insert ignore into pcard_unreconciled_xtnd_temp2_perm_unique(cardholder,division,card_number2,dpr)
select cardholder,division,card_number2,dpr
from pcard_unreconciled_xtnd_temp2_perm
where 1
group by cardholder,division,card_number2,dpr; ";
		  
		  
mysqli_query($connection, $query5) or die ("Couldn't execute query 5.  $query5");

//echo "<br />Line 437<br />"; exit;

//stepL3e2d1b.php
//this is necessary because sometimes the weekly download from XTND includes DPR employee charges, BUT Rachel in Budget Office has not added PCARD/User to the "master pcard table" (table=pcard_users)
//Because of this, previous XTND downloads (which include all transactions for DNCR) may not have been MARKED as DPR employee charges.
// this is trying to identify transactions from "previous weeks" that were not previously identified as DPR Charges but now match a RECORD in Table=pcard_users
//Basically Rachel in Budget Office added DPR PCARD/USER "AFTER pcard transaction(s)" showed in my download.

$query6="update pcard_unreconciled_xtnd_temp2_perm,pcard_users
         set pcard_unreconciled_xtnd_temp2_perm.location=pcard_users.location, 
		     pcard_unreconciled_xtnd_temp2_perm.admin_num=pcard_users.admin, 
		     pcard_unreconciled_xtnd_temp2_perm.last_name=pcard_users.last_name, 
		     pcard_unreconciled_xtnd_temp2_perm.first_name=pcard_users.first_name,
		     pcard_unreconciled_xtnd_temp2_perm.center=pcard_users.center,
		     pcard_unreconciled_xtnd_temp2_perm.xtnd_report_date='$end_date2',
		     pcard_unreconciled_xtnd_temp2_perm.report_date='$end_date2',			 
		     pcard_unreconciled_xtnd_temp2_perm.division='DPR_MANUAL',
		     pcard_unreconciled_xtnd_temp2_perm.backdate='y',			 
			 pcard_unreconciled_xtnd_temp2_perm.dpr='y'
             where pcard_unreconciled_xtnd_temp2_perm.card_number2=pcard_users.card_number
             and pcard_unreconciled_xtnd_temp2_perm.cardholder like concat('%',pcard_users.last_name,'%')
             and pcard_unreconciled_xtnd_temp2_perm.dpr='n'	
             and pcard_unreconciled_xtnd_temp2_perm.xtnd_report_date >= '20170831'			 ";


//echo "<br />query6=$query6<br />";	//exit;

$result6 = mysqli_query($connection, $query6) or die ("Couldn't execute query 6.  $query6");


$query7="update pcard_unreconciled_xtnd_temp2_perm
         set primary_account_holder=concat(last_name,',',first_name)
         where xtnd_report_date='$end_date' and dpr='y' and backdate='y' ";


//echo "<br />query7=$query7<br />";	

$result7 = mysqli_query($connection, $query7) or die ("Couldn't execute query 7.  $query7");
//echo "<br />Line 475<br />"; exit;

//stepL3e2d3.php


$query8="truncate table budget.pcard_unreconciled_xtnd; ";
mysqli_query($connection, $query8) or die ("Couldn't execute query 8. $query8");

$query8a="truncate table budget.pcard_unreconciled_xtnd_temp; ";
mysqli_query($connection, $query8a) or die ("Couldn't execute query 8a. $query8a");

/* 2022-06-15: cooper and carter
 $query8b="truncate table budget.pcard_unreconciled_xtnd_temp2; ";
mysqli_query($connection, $query8b) or die ("Couldn't execute query 8b. $query8b");
*/

//stepL3e2d4.php


$query9="insert into pcard_unreconciled(location,admin_num,post_date,trans_date,amount,vendor_name,trans_id,pcard_num,cardholder_xtnd,xtnd_rundate,transdate_new,cardholder,transid_new,postdate_new,xtnd_rundate_new,center,company,last_name,first_name,report_date)
select location,admin_num,date_posted,date_purchased,amount,merchant_name,trans_id,card_number2,cardholder,
xtnd_rundate,date_purchased_new,primary_account_holder,trans_id,date_posted_new,'$end_date2',center,company,last_name,first_name,'$end_date2'
from pcard_unreconciled_xtnd_temp2_perm
where xtnd_report_date='$end_date2' and dpr='y' ; ";


//echo "<br />query9=$query9<br />"; 
//exit;

$result9 = mysqli_query($connection, $query9) or die ("Couldn't execute query 9.  $query9");


$query9a="update pcard_unreconciled,pcard_users
set pcard_unreconciled.employee_tempid=pcard_users.employee_tempid
where pcard_unreconciled.cardholder_xtnd=pcard_users.cardholder_xtnd
and pcard_unreconciled.pcard_num=pcard_users.card_number
and pcard_unreconciled.report_date='$end_date2' "; 

$result9a = mysqli_query($connection, $query9a) or die ("Couldn't execute query 9a.  $query9a");

$query9b="update pcard_unreconciled
          set admin_num='eadi'
		  where admin_num='core' 
		  and report_date >= '20171201' "; 

$result9b = mysqli_query($connection, $query9b) or die ("Couldn't execute query 9b.  $query9b");


$query9c="update pcard_unreconciled
          set admin_num='sodi'
		  where admin_num='pire'
          and report_date >= '20171201' "; 
		 

$result9c = mysqli_query($connection, $query9c) or die ("Couldn't execute query 9c.  $query9c");


$query9d="update pcard_unreconciled
          set admin_num='wedi'
		  where admin_num='more' 
		  and report_date >= '20171201' "; 
		  
		   

$result9d = mysqli_query($connection, $query9d) or die ("Couldn't execute query 9d.  $query9d");





$query9e="update pcard_report_dates
         set active='y',active_date='$today_date' where report_date='$end_date2' "; 

$result9e = mysqli_query($connection, $query9e) or die ("Couldn't execute query 9e.  $query9e");


$query9f="insert into pcard_report_dates_compliance(report_date,fiscal_year,admin_num,record_count)
select report_date,'$fiscal_year',admin_num,count(admin_num)
from pcard_unreconciled
where report_date='$end_date2'
group by admin_num;"; 

$result9f = mysqli_query($connection, $query9f) or die ("Couldn't execute query 9f.  $query9f");


$query0="truncate table budget.pcard; ";
mysqli_query($connection, $query0) or die ("Couldn't execute query 0. $query0");




/*
$query23a="update budget.project_substeps_detail set status='complete' where project_category='$project_category'
         and project_name='$project_name' and step_group='$step_group' and step_num='$step_num' and substep_num='$substep_num' ";
			 
mysqli_query($connection, $query23a) or die ("Couldn't execute query 23a.  $query23a");

$query24="select * from budget.project_substeps_detail
         where project_category='$project_category' and project_name='$project_name'
		 and step_group='$step_group'  and step_num='$step_num' and status='pending' "; 

$result24=mysqli_query($connection, $query24) or die ("Couldn't execute query 24.  $query24");

$num24=mysqli_num_rows($result24);
*/

{header("location: aDiv/pcard_weekly_reports.php?report_date=$end_date_header");}

//former stepL3e2d1.php ENDS



 
 ?>
