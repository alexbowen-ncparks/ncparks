<?php
//echo "<pre>";print_r($_REQUEST);echo "</pre>";//exit;
session_start();
//echo "<pre>";print_r($_SESSION);echo "</pre>";exit;
$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempid=$_SESSION['budget']['tempID'];
//echo $tempid;
extract($_REQUEST);
$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/connectROOT.inc"); // connection parameters
mysql_select_db($database, $connection); // database
include("../../../../include/activity.php");// database connection parameters
//echo "submit1=$submit1";echo "submit2=$submit2";exit;
//echo "<pre>";print_r($_REQUEST);"</pre>";exit;

$query18a="DROP TABLE `pcu_unposted`;";
mysql_query($query18a) or die ("Couldn't execute query 18a. $query18a");



$query1="CREATE TABLE `pcard_transid_multiple_dates1` (
`pcard_transid` VARCHAR( 20 ) NOT NULL ,
`trans_date` DATE NOT NULL 
);";
mysql_query($query1) or die ("Couldn't execute query 1. $query1");

$query2="insert into pcard_transid_multiple_dates1
select distinct transid_new,transdate_new
from pcard_unreconciled
where 1;";
mysql_query($query2) or die ("Couldn't execute query 2. $query2");

$query3="CREATE TABLE `pcard_transid_multiple_dates2` (
`pcard_transid` VARCHAR( 20 ) NOT NULL ,
`count` varchar(10) not null 
);";
mysql_query($query3) or die ("Couldn't execute query 3. $query3");

$query4="insert into pcard_transid_multiple_dates2
select pcard_transid,count(pcard_transid)
from pcard_transid_multiple_dates1
where 1
group by pcard_transid;";
mysql_query($query4) or die ("Couldn't execute query 4. $query4");

$query5="update pcard_unreconciled,pcard_transid_multiple_dates2
set pcard_unreconciled.transid_date_count=pcard_transid_multiple_dates2.count
where pcard_unreconciled.transid_new=pcard_transid_multiple_dates2.pcard_transid;";
mysql_query($query5) or die ("Couldn't execute query 5. $query5");

$query6="DROP TABLE `pcard_transid_multiple_dates1`;";
mysql_query($query6) or die ("Couldn't execute query 6. $query6");

$query7="DROP TABLE `pcard_transid_multiple_dates2`;";
mysql_query($query7) or die ("Couldn't execute query 7. $query7");

$query8="update pcard_unreconciled
set ca=concat(center,'-',amount)
where 1;";
mysql_query($query8) or die ("Couldn't execute query 8. $query8");

$query9="update pcard_unreconciled
set ca_count_unposted='0'
where 1;";
mysql_query($query9) or die ("Couldn't execute query 9. $query9");

$query10="CREATE TABLE `budget`.`pcu_unposted` (
`view` char( 3 ) NOT NULL default '',
`ca` varchar( 30 ) NOT NULL default '0.00',
`ca_count` decimal( 5, 0 ) NOT NULL default '0',
`transid_new` varchar( 20 ) NOT NULL default '',
`trans_date` varchar( 20 ) NOT NULL default '0000-00-00',
`id` int( 10 ) unsigned NOT NULL AUTO_INCREMENT ,
PRIMARY KEY ( `id` ) ,
KEY `amount` ( `ca` )
) ENGINE = MyISAM ;";
mysql_query($query10) or die ("Couldn't execute query 10. $query10");

$query11="insert into pcu_unposted(view,ca,ca_count)
SELECT 'all',ca,count(ca)
FROM pcard_unreconciled
WHERE 1 and ncas_yn='n'
GROUP BY ca;";
mysql_query($query11) or die ("Couldn't execute query 11. $query11");

$query12="update pcard_unreconciled,pcu_unposted
set pcard_unreconciled.ca_count_unposted=pcu_unposted.ca_count
where pcard_unreconciled.ca=pcu_unposted.ca
and pcard_unreconciled.ncas_yn='n';";
mysql_query($query12) or die ("Couldn't execute query 12. $query12");

$query13="CREATE TABLE `budget`.`pcu_posted` (
`view` char( 3 ) NOT NULL default '',
`ca` varchar( 30 ) NOT NULL default '',
`count` decimal( 5, 0 ) NOT NULL default '0'
) ENGINE = MyISAM ;";
mysql_query($query13) or die ("Couldn't execute query 13. $query13");

$query14="insert into pcu_posted (view,ca,count)
select 'all',ca,count(ca)
from pcard_unreconciled
where 1
and ncas_yn='y'
group by ca;";
mysql_query($query14) or die ("Couldn't execute query 14. $query14");

$query15="update pcard_unreconciled
set ca_count_posted='' 
where 1;";
mysql_query($query15) or die ("Couldn't execute query 15. $query15");

$query16="update pcard_unreconciled,pcu_posted
set pcard_unreconciled.ca_count_posted=
pcu_posted.count
where pcard_unreconciled.ca=pcu_posted.ca
and pcard_unreconciled.ncas_yn='y';";
mysql_query($query16) or die ("Couldn't execute query 16. $query16");

$query17="DROP TABLE `pcu_posted`;";
mysql_query($query17) or die ("Couldn't execute query 17. $query17");

$query18="DROP TABLE `pcu_unposted`;";
mysql_query($query18) or die ("Couldn't execute query 18. $query18");

$query23a="update budget.project_steps_detail set status='complete' where project_category='$project_category'
         and project_name='$project_name' and step_group='$step_group' and step_num='$step_num' ";
			 
mysql_query($query23a) or die ("Couldn't execute query 23a.  $query23a");

$query24="select * from budget.project_steps_detail
         where project_category='$project_category' and project_name='$project_name'
		 and step_group='$step_group'  and status='pending' "; 

$result24=mysql_query($query24) or die ("Couldn't execute query 24.  $query24");

$num24=mysql_num_rows($result24);

//echo "pending_items=$num4";exit;

//if($num4==0){echo "done"}; if ($num4!=0){echo "$num4 pending items"}; exit;
if($num24==0)

{$query25="update budget.project_steps set status='complete' where project_category='$project_category'
         and project_name='$project_name' and step_group='$step_group' ";
mysql_query($query25) or die ("Couldn't execute query 25.  $query25");}
mysql_close();

if($num24==0)

{header("location: main.php?project_category=$project_category&project_name=$project_name ");}

if($num24!=0)

{header("location: step_group.php?project_category=$project_category&project_name=$project_name&step_group=$step_group&fiscal_year=$fiscal_year&start_date=$start_date&end_date=$end_date");}




?>

























