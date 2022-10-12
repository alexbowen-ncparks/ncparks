<?php

//echo "<pre>";print_r($_REQUEST);echo "</pre>";//exit;
session_start();
//echo "<pre>";print_r($_SESSION);echo "</pre>";exit;
$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempid=$_SESSION['budget']['tempID'];
//echo $tempid;
extract($_REQUEST);
//echo "<pre>";print_r($_REQUEST);echo "</pre>"; exit;
$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/connectROOT.inc"); // connection parameters
mysql_select_db($database, $connection); // database
include("../../../../include/activity.php");// database connection parameters

$start_date2=str_replace("-","",$start_date);
$end_date2=str_replace("-","",$end_date);

//echo "start_date2=$start_date2<br />";
//echo "end_date2=$end_date2<br />";

//exit;
/*
$query0="update pcard_unreconciled_xtnd_temp2
         set dpr='y' where (division='park' or division='canc' or division='capi' or division='dpr_manual') ";
		 */
		 
/*		 
$query0="update pcard_unreconciled_xtnd_temp2
         set dpr='y' where (division='park' or division='capi' or division='dpr_manual') ";		 
		  
	
mysql_query($query0) or die ("Couldn't execute query 0.  $query0");
*/




/*
$query1="update pcard_unreconciled_xtnd_temp2
         set card_number2=substring(card_number,-4)
         where 1		 ";
		  
		  
mysql_query($query1) or die ("Couldn't execute query 1.  $query1");

*/

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
		  
		  
mysql_query($query2a) or die ("Couldn't execute query 2a.  $query2a");





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
		  
		  
mysql_query($query2) or die ("Couldn't execute query 2.  $query2");

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
		  
		  
mysql_query($query2a) or die ("Couldn't execute query 2a.  $query2a");


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
		  
		  
mysql_query($query2b) or die ("Couldn't execute query 2b.  $query2b");


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
		  
		  
mysql_query($query2c) or die ("Couldn't execute query 2c.  $query2c");


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

		  
mysql_query($query2d) or die ("Couldn't execute query 2d.  $query2d");

*/

/*
$query2e="update pcard_unreconciled_xtnd_temp2
          set xtnd_report_date='$end_date2'
		  where 1 ";
		  
		  
mysql_query($query2e) or die ("Couldn't execute query 2e.  $query2e");
*/


$query3="update pcard_unreconciled_xtnd_temp2
         set date_posted_new=concat(mid(post_date,7,4),mid(post_date,1,2),mid(post_date,4,2))
         where 1  ";
		  
		  
mysql_query($query3) or die ("Couldn't execute query 3.  $query3");


$query4="update pcard_unreconciled_xtnd_temp2
         set date_purchased_new=concat(mid(trans_date,7,4),mid(trans_date,1,2),mid(trans_date,4,2))
         where 1  ";
		  
		  
mysql_query($query4) or die ("Couldn't execute query 4.  $query4");



$query5="update pcard_unreconciled_xtnd_temp2
         set company='4601'
         where location='1656'  ";
		  
		  
mysql_query($query5) or die ("Couldn't execute query 5.  $query5");



$query6="update pcard_unreconciled_xtnd_temp2
         set company='4604'
         where location='1669'  ";
		  
		  
mysql_query($query6) or die ("Couldn't execute query 6.  $query6");


$query7="update pcard_unreconciled_xtnd_temp2
         set report_date='$end_date2'
         where 1  ";
		  
		  
mysql_query($query7) or die ("Couldn't execute query 7.  $query7");


$query8="update pcard_unreconciled_xtnd_temp2
         set account_id=card_number2
         where 1  ";
		  
		  
mysql_query($query8) or die ("Couldn't execute query 8.  $query8");



$query9="update pcard_unreconciled_xtnd_temp2
         set document=trans_id
         where 1  ";
		  
		  
mysql_query($query9) or die ("Couldn't execute query 9.  $query9");


$query10="update pcard_unreconciled_xtnd_temp2
         set date_posted=concat(mid(post_date,1,2),'/',mid(post_date,4,2),'/',mid(post_date,9,2))
         where 1  ";
		  
		  
mysql_query($query10) or die ("Couldn't execute query 10.  $query10");


$query11="update pcard_unreconciled_xtnd_temp2
         set date_purchased=concat(mid(trans_date,1,2),'/',mid(trans_date,4,2),'/',mid(trans_date,9,2))
         where 1  ";
		  
		  
mysql_query($query11) or die ("Couldn't execute query 11.  $query11");
//echo "OK Line 129"; exit;



$query12="update pcard_unreconciled_xtnd_temp2
         set primary_account_holder=concat(last_name,',',' ',first_name)
         where 1  ";
		  
		  
mysql_query($query12) or die ("Couldn't execute query 12.  $query12");





$query13="update pcard_unreconciled_xtnd_temp2
          set purchase_amount=amount,amount_allocated=amount,vendor=merchant_name
		  where 1 ";
		  
mysql_query($query13) or die ("Couldn't execute query 13.  $query13");

/*
$query14="update pcard_unreconciled_xtnd_temp2,pcard_users
set pcard_unreconciled_xtnd_temp2.pcard_users_match='y'
where pcard_unreconciled_xtnd_temp2.dpr='y'
and pcard_unreconciled_xtnd_temp2.card_number2=pcard_users.card_number; ";
		  
mysql_query($query14) or die ("Couldn't execute query 14.  $query14");


$query15="truncate table pcard_unreconciled_xtnd_temp2_count";

mysql_query($query15) or die ("Couldn't execute query 15.  $query15");


$query15a="
insert into pcard_unreconciled_xtnd_temp2_count(xtnd_report_date,card_number2,last_name,first_name,records)
SELECT xtnd_report_date,card_number2,last_name,first_name,count(id) as 'records'  FROM `pcard_unreconciled_xtnd_temp2` WHERE `dpr` LIKE 'y' 
group by xtnd_report_date,card_number2,last_name,first_name
order by xtnd_report_date,card_number2,last_name,first_name";

mysql_query($query15a) or die ("Couldn't execute query 15a.  $query15a");
*/

$query23a="update budget.project_substeps_detail set status='complete' where project_category='$project_category'
         and project_name='$project_name' and step_group='$step_group' and step_num='$step_num' and substep_num='$substep_num' ";
			 
mysql_query($query23a) or die ("Couldn't execute query 23a.  $query23a");




$query24="select * from budget.project_substeps_detail
         where project_category='$project_category' and project_name='$project_name'
		 and step_group='$step_group'  and step_num='$step_num' and status='pending' "; 

$result24=mysql_query($query24) or die ("Couldn't execute query 24.  $query24");

$num24=mysql_num_rows($result24);

//echo "pending_items=$num4";exit;

//if($num4==0){echo "done"}; if ($num4!=0){echo "$num4 pending items"}; exit;
if($num24==0)

{$query25="update budget.project_steps_detail set status='complete' where project_category='$project_category'
         and project_name='$project_name' and step_group='$step_group' and step_num='$step_num' ";
mysql_query($query25) or die ("Couldn't execute query 25.  $query25");}
//mysql_close();

if($num24==0)

{header("location: step_group.php?project_category=$project_category&project_name=$project_name&step_group=$step_group ");}

if($num24!=0)

{header("location: step$step_group$step_num.php?project_category=$project_category&project_name=$project_name&step_group=$step_group&step_num=$step_num ");}
//echo "OK Line 151"; exit;

 
 
 ?>




















