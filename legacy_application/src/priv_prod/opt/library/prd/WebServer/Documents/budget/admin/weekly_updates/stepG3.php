<?php

//echo "<pre>";print_r($_REQUEST);echo "</pre>";//exit;
session_start();
//echo "<pre>";print_r($_SESSION);echo "</pre>";exit;
$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempid=$_SESSION['budget']['tempID'];
//echo $tempid;
extract($_REQUEST);
$end_date=str_replace("-","",$end_date);
$start_date=str_replace("-","",$start_date);


//echo "<pre>";print_r($_REQUEST);echo "</pre>";//exit;
//echo "start_date=$start_date <br />"; //exit;
//echo "end_date=$end_date <br />";exit;

$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
include("../../../../include/activity.php");// database connection parameters

/*
$query19m1="DROP TABLE pcew; ";
			 
mysqli_query($connection, $query19m1) or die ("Couldn't execute query 19m1.  $query19m1");

$query19m2="DROP TABLE pcew_credits; ";
			 
mysqli_query($connection, $query19m2) or die ("Couldn't execute query 19m2.  $query19m2");

$query19m3="DROP TABLE pcew_debits; ";
			 
mysqli_query($connection, $query19m3) or die ("Couldn't execute query 19m3.  $query19m3");

$query19m4="DROP TABLE pcew_debits_count; ";
			 
mysqli_query($connection, $query19m4) or die ("Couldn't execute query 19m4.  $query19m4");


$query19m5="DROP TABLE pcew_credits_count; ";
			 
mysqli_query($connection, $query19m5) or die ("Couldn't execute query 19m5.  $query19m5");
*/



$query1="update pcard_extract_worksheet
set ca=concat(center,'-',debit_credit)
where 1;
";
			 
mysqli_query($connection, $query1) or die ("Couldn't execute query 1.  $query1");

/*
$query2="CREATE TABLE budget.pcew (
`view` char( 3 ) NOT NULL default '',
`ca` varchar( 30 ) NOT NULL default '',
`count` decimal( 5, 0 ) NOT NULL default '0'
) ENGINE = MyISAM ;
";
			 
mysqli_query($connection, $query2) or die ("Couldn't execute query 2.  $query2");
*/


$query2="TRUNCATE TABLE  `pcew`  ";
			 
mysqli_query($connection, $query2) or die ("Couldn't execute query 2.  $query2");



$query3="insert into pcew (view,ca,count)
select 'all',ca,count(ca)
from pcard_extract_worksheet
where 1
group by ca;
";
			 
mysqli_query($connection, $query3) or die ("Couldn't execute query 3.  $query3");

$query4="update pcard_extract_worksheet,pcew
set pcard_extract_worksheet.ca_count=pcew.count
where pcard_extract_worksheet.ca=pcew.ca;
";
			 
mysqli_query($connection, $query4) or die ("Couldn't execute query 4.  $query4");
/*
$query5="DROP TABLE pcew; 
";
			 
mysqli_query($connection, $query5) or die ("Couldn't execute query 5.  $query5");
*/

$query6="update pcard_extract_worksheet
set ca_abs=
concat(center,'-',abs(debit_credit))
where 1;
";
			 
mysqli_query($connection, $query6) or die ("Couldn't execute query 6.  $query6");

$query7="update pcard_extract_worksheet
set amount=abs(debit_credit)
where 1;
";
			 
mysqli_query($connection, $query7) or die ("Couldn't execute query 7.  $query7");

$query8="update pcard_extract_worksheet
set sign='debit'
where debit_credit>'0';
";
			 
mysqli_query($connection, $query8) or die ("Couldn't execute query 8.  $query8");

$query9="update pcard_extract_worksheet
set sign='credit'
where debit_credit<'0';
";
			 
mysqli_query($connection, $query9) or die ("Couldn't execute query 9.  $query9");

$query10="update pcard_extract_worksheet
set date_amount=concat(acctdate,'-',amount)
where 1;
";
			 
mysqli_query($connection, $query10) or die ("Couldn't execute query 10.  $query10");

$query11="update pcard_extract_worksheet
set post_date=acctdate
where 1;
";
			 
mysqli_query($connection, $query11) or die ("Couldn't execute query 11.  $query11");
/*
$query12="CREATE TABLE budget.pcew_credits (
`acctdate` date NOT NULL default '0000-00-00',
`amount` decimal( 13, 2 ) NOT NULL default '0.00',
`sign` varchar( 10 ) NOT NULL default '',
`center` varchar( 15 ) NOT NULL default '',
`acct` varchar( 15 ) NOT NULL default '',
`date_amount` varchar( 30 ) NOT NULL default '',
`date_amount_count` decimal( 5, 0 ) NOT NULL default '0',
`debit_matches` decimal( 5, 0 ) NOT NULL default '0',
`correction` char( 1 ) NOT NULL default '',
`id` varchar( 10 ) NOT NULL default ''
) ENGINE = MyISAM ;
";
			 
mysqli_query($connection, $query12) or die ("Couldn't execute query 12.  $query12");
*/

$query12="TRUNCATE TABLE  `pcew_credits` ";
			 
mysqli_query($connection, $query12) or die ("Couldn't execute query 12.  $query12");


$query13="insert into pcew_credits (acctdate,amount,sign,center,acct,date_amount,id)
select acctdate,amount,sign,center,acct,date_amount,id
from pcard_extract_worksheet
where sign='credit';
";
			 
mysqli_query($connection, $query13) or die ("Couldn't execute query 13.  $query13");

/*
$query14="CREATE TABLE `budget`.`pcew_debits` (
`acctdate` date NOT NULL default '0000-00-00',
`amount` decimal( 13, 2 ) NOT NULL default '0.00',
`sign` varchar( 10 ) NOT NULL default '',
`center` varchar( 15 ) NOT NULL default '',
`acct` varchar( 15 ) NOT NULL default '',
`date_amount` varchar( 30 ) NOT NULL default '',
`date_amount_count` decimal( 5, 0 ) NOT NULL default '0',
`correction` char( 1 ) NOT NULL default '',
`id` varchar( 10 ) NOT NULL default ''
) ENGINE = MyISAM ;
";
			 
mysqli_query($connection, $query14) or die ("Couldn't execute query 14.  $query14");
*/

$query14="TRUNCATE TABLE  `pcew_debits` ";
			 
mysqli_query($connection, $query14) or die ("Couldn't execute query 14.  $query14");


$query15="insert into pcew_debits (acctdate,amount,sign,center,acct,date_amount,id)
select acctdate,amount,sign,center,acct,date_amount,id
from pcard_extract_worksheet
where sign='debit';
";
			 
mysqli_query($connection, $query15) or die ("Couldn't execute query 15.  $query15");

/*
$query16="CREATE TABLE `budget`.`pcew_debits_count` (
`date_amount` varchar( 30 ) NOT NULL default '',
`count` decimal( 5, 0 ) NOT NULL default '0'
) ENGINE = MyISAM ;
";
			 
mysqli_query($connection, $query16) or die ("Couldn't execute query 16.  $query16");
*/

$query16="TRUNCATE TABLE  `pcew_debits_count` ";
			 
mysqli_query($connection, $query16) or die ("Couldn't execute query 16.  $query16");







$query17="insert into pcew_debits_count (date_amount,count)
select date_amount,count(date_amount)
from pcew_debits
where 1
group by date_amount;
";
			 
mysqli_query($connection, $query17) or die ("Couldn't execute query 17.  $query17");

$query18="update pcew_debits,pcew_debits_count
set pcew_debits.date_amount_count=pcew_debits_count.count
where pcew_debits.date_amount=pcew_debits_count.date_amount;
";
			 
mysqli_query($connection, $query18) or die ("Couldn't execute query 18.  $query18");

/*
$query19="CREATE TABLE `budget`.`pcew_credits_count` (
`date_amount` varchar( 30 ) NOT NULL default '',
`count` decimal( 5, 0 ) NOT NULL default '0'
) ENGINE = MyISAM ;
";
			 
mysqli_query($connection, $query19) or die ("Couldn't execute query 19.  $query19");
*/


$query19="TRUNCATE TABLE  `pcew_credits_count` ";
			 
mysqli_query($connection, $query19) or die ("Couldn't execute query 19.  $query19");









$query19a="insert into pcew_credits_count (date_amount,count)
select date_amount,count(date_amount)
from pcew_credits
where 1
group by date_amount;
";
			 
mysqli_query($connection, $query19a) or die ("Couldn't execute query 19a.  $query19a");

$query19b="update pcew_credits,pcew_credits_count
set pcew_credits.date_amount_count=pcew_credits_count.count
where pcew_credits.date_amount=pcew_credits_count.date_amount;
";
			 
mysqli_query($connection, $query19b) or die ("Couldn't execute query 19b.  $query19b");

$query19c="update pcew_credits,pcew_debits
set pcew_credits.debit_matches=pcew_debits.date_amount_count
where pcew_credits.date_amount=pcew_debits.date_amount;
";
			 
mysqli_query($connection, $query19c) or die ("Couldn't execute query 19c.  $query19c");

$query19d="update pcew_credits
set pcew_credits.correction='m'
where debit_matches !='0';
";
			 
mysqli_query($connection, $query19d) or die ("Couldn't execute query 19d.  $query19d");

$query19e="update pcew_credits
set correction='n'
where debit_matches='0';
";
			 
mysqli_query($connection, $query19e) or die ("Couldn't execute query 19e.  $query19e");

$query19f="update pcew_debits,pcew_credits
set pcew_debits.correction='m'
where pcew_debits.date_amount=pcew_credits.date_amount
and pcew_credits.correction='m';
";
			 
mysqli_query($connection, $query19f) or die ("Couldn't execute query 19f.  $query19f");


$query19g="update pcew_debits
set correction='n'
where correction='';
";
			 
mysqli_query($connection, $query19g) or die ("Couldn't execute query 19g.  $query19g");

$query19h="update pcard_extract_worksheet,pcew_credits
set pcard_extract_worksheet.correction=pcew_credits.correction
where pcard_extract_worksheet.id=pcew_credits.id;
";
			 
mysqli_query($connection, $query19h) or die ("Couldn't execute query 19h.  $query19h");

$query19i="update pcard_extract_worksheet,pcew_debits
set pcard_extract_worksheet.correction=pcew_debits.correction
where pcard_extract_worksheet.id=pcew_debits.id;
";
			 
mysqli_query($connection, $query19i) or die ("Couldn't execute query 19i.  $query19i");

/*
$query19j="DROP TABLE pcew_credits; 
";
			 
mysqli_query($connection, $query19j) or die ("Couldn't execute query 19j.  $query19j");

$query19k="DROP TABLE pcew_debits; 
";
			 
mysqli_query($connection, $query19k) or die ("Couldn't execute query 19k.  $query19k");

$query19m="DROP TABLE pcew_debits_count; 
";
			 
mysqli_query($connection, $query19m) or die ("Couldn't execute query 19m.  $query19m");

$query19n="DROP TABLE pcew_credits_count; 
";
			 
mysqli_query($connection, $query19n) or die ("Couldn't execute query 19n.  $query19n");
*/


$query23a="update budget.project_steps_detail set status='complete' where project_category='$project_category'
         and project_name='$project_name' and step_group='$step_group' and step_num='$step_num' ";
			 
mysqli_query($connection, $query23a) or die ("Couldn't execute query 23a.  $query23a");

$query24="select * from budget.project_steps_detail
         where project_category='$project_category' and project_name='$project_name'
		 and step_group='$step_group'  and status='pending' "; 

$result24=mysqli_query($connection, $query24) or die ("Couldn't execute query 24.  $query24");

$num24=mysqli_num_rows($result24);

//echo "pending_items=$num4";exit;

//if($num4==0){echo "done"}; if ($num4!=0){echo "$num4 pending items"}; exit;
if($num24==0)

{$query25="update budget.project_steps set status='complete' where project_category='$project_category'
         and project_name='$project_name' and step_group='$step_group' ";
mysqli_query($connection, $query25) or die ("Couldn't execute query 25.  $query25");}
////mysql_close();

if($num24==0)

{header("location: main.php?project_category=$project_category&project_name=$project_name ");}

if($num24!=0)

{header("location: step_group.php?project_category=$project_category&project_name=$project_name&step_group=$step_group&fiscal_year=$fiscal_year&start_date=$start_date&end_date=$end_date");}
	  


 ?>




















