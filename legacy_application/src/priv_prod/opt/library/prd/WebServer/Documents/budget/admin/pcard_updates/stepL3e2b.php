<?php

//echo "<pre>";print_r($_REQUEST);echo "</pre>";//exit;
session_start();
//echo "<pre>";print_r($_SESSION);echo "</pre>";exit;
$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempid=$_SESSION['budget']['tempID'];
//echo $tempid;
extract($_REQUEST);
//echo "<pre>";print_r($_REQUEST);echo "</pre>";exit;
$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
include("../../../../include/activity.php");// database connection parameters
$start_date2=str_replace("-","",$start_date);
$end_date2=str_replace("-","",$end_date);

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


$query1a="delete from pcard
          where
		  (
		  (mid(post_date,7,4)!='2016') and
		  (mid(post_date,7,4)!='2017') and
		  (mid(post_date,7,4)!='2018') and
		  (mid(post_date,7,4)!='2019') and
		  (mid(post_date,7,4)!='2020') and
		  (mid(post_date,7,4)!='2021') 		  
		  
		  )
           		  ";		  
		  
mysqli_query($connection, $query1a) or die ("Couldn't execute query 1a.  $query1a");

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










/*
$query2a="update pcard_unreconciled_xtnd_temp2,pcard_users
         set pcard_unreconciled_xtnd_temp2.admin_num=pcard_users.admin,
		     pcard_unreconciled_xtnd_temp2.location=pcard_users.location,
		     pcard_unreconciled_xtnd_temp2.center=pcard_users.center,
		     pcard_unreconciled_xtnd_temp2.last_name=pcard_users.last_name,
		     pcard_unreconciled_xtnd_temp2.first_name=pcard_users.first_name
			 where pcard_unreconciled_xtnd_temp2.card_number2='3090'
			 and pcard_unreconciled_xtnd_temp2.cardholder like '%pippin%'
			 and pcard_users.card_number='3090'
			 and pcard_users.last_name like '%pippin%'
    		 and pcard_unreconciled_xtnd_temp2.dpr='y'	 ";
		  
		  
mysqli_query($connection, $query2a) or die ("Couldn't execute query 2a.  $query2a");


$query2b="update pcard_unreconciled_xtnd_temp2,pcard_users
         set pcard_unreconciled_xtnd_temp2.admin_num=pcard_users.admin,
		     pcard_unreconciled_xtnd_temp2.location=pcard_users.location,
		     pcard_unreconciled_xtnd_temp2.center=pcard_users.center,
		     pcard_unreconciled_xtnd_temp2.last_name=pcard_users.last_name,
		     pcard_unreconciled_xtnd_temp2.first_name=pcard_users.first_name
			 where pcard_unreconciled_xtnd_temp2.card_number2='3090'
			 and pcard_unreconciled_xtnd_temp2.cardholder like '%dowdy%'
			 and pcard_users.card_number='3090'
			 and pcard_users.last_name like '%dowdy%' 
			 and pcard_unreconciled_xtnd_temp2.dpr='y'	 ";
		  
		  
mysqli_query($connection, $query2b) or die ("Couldn't execute query 2b.  $query2b");


$query2c="update pcard_unreconciled_xtnd_temp2,pcard_users
         set pcard_unreconciled_xtnd_temp2.admin_num=pcard_users.admin,
		     pcard_unreconciled_xtnd_temp2.location=pcard_users.location,
		     pcard_unreconciled_xtnd_temp2.center=pcard_users.center,
		     pcard_unreconciled_xtnd_temp2.last_name=pcard_users.last_name,
		     pcard_unreconciled_xtnd_temp2.first_name=pcard_users.first_name
			 where pcard_unreconciled_xtnd_temp2.card_number2='5896'
			 and pcard_unreconciled_xtnd_temp2.cardholder like '%crate%'
			 and pcard_users.card_number='5896'
			 and pcard_users.last_name like '%crate%' 
			 and pcard_unreconciled_xtnd_temp2.dpr='y'	 ";
		  
		  
mysqli_query($connection, $query2c) or die ("Couldn't execute query 2c.  $query2c");


$query2d="update pcard_unreconciled_xtnd_temp2,pcard_users
         set pcard_unreconciled_xtnd_temp2.admin_num=pcard_users.admin,
		     pcard_unreconciled_xtnd_temp2.location=pcard_users.location,
		     pcard_unreconciled_xtnd_temp2.center=pcard_users.center,
		     pcard_unreconciled_xtnd_temp2.last_name=pcard_users.last_name,
		     pcard_unreconciled_xtnd_temp2.first_name=pcard_users.first_name
			 where pcard_unreconciled_xtnd_temp2.card_number2='5896'
			 and pcard_unreconciled_xtnd_temp2.cardholder like '%abbott%'
			 and pcard_users.card_number='5896'
			 and pcard_users.last_name like '%abbott%' 
			 and pcard_unreconciled_xtnd_temp2.dpr='y'	 ";

		  
mysqli_query($connection, $query2d) or die ("Couldn't execute query 2d.  $query2d");

*/

/*
$query2e="update pcard_unreconciled_xtnd_temp2
          set xtnd_report_date='$end_date2'
		  where 1 ";
		  
		  
mysqli_query($connection, $query2e) or die ("Couldn't execute query 2e.  $query2e");
*/


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


/*
$query6="update pcard_unreconciled_xtnd_temp2
         set company='4604'
         where location='1669'  ";
		  
		  
mysqli_query($connection, $query6) or die ("Couldn't execute query 6.  $query6");

*/


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

/*
$query14="update pcard_unreconciled_xtnd_temp2,pcard_users
set pcard_unreconciled_xtnd_temp2.pcard_users_match='y'
where pcard_unreconciled_xtnd_temp2.dpr='y'
and pcard_unreconciled_xtnd_temp2.card_number2=pcard_users.card_number; ";
		  
mysqli_query($connection, $query14) or die ("Couldn't execute query 14.  $query14");


$query15="truncate table pcard_unreconciled_xtnd_temp2_count";

mysqli_query($connection, $query15) or die ("Couldn't execute query 15.  $query15");


$query15a="
insert into pcard_unreconciled_xtnd_temp2_count(xtnd_report_date,card_number2,last_name,first_name,records)
SELECT xtnd_report_date,card_number2,last_name,first_name,count(id) as 'records'  FROM `pcard_unreconciled_xtnd_temp2` WHERE `dpr` LIKE 'y' 
group by xtnd_report_date,card_number2,last_name,first_name
order by xtnd_report_date,card_number2,last_name,first_name";

mysqli_query($connection, $query15a) or die ("Couldn't execute query 15a.  $query15a");
*/




$query23a="update budget.project_substeps_detail set status='complete' where project_category='$project_category'
         and project_name='$project_name' and step_group='$step_group' and step_num='$step_num' and substep_num='$substep_num' ";
			 
mysqli_query($connection, $query23a) or die ("Couldn't execute query 23a.  $query23a");


{header("location: step$step_group$step_num.php?project_category=$project_category&project_name=$project_name&step_group=$step_group&step_num=$step_num ");}

 
 ?>