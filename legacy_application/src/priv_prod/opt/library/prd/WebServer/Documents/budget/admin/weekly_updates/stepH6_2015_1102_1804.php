<?php
//echo "<pre>";print_r($_REQUEST);echo "</pre>";//exit;
session_start();
//echo "<pre>";print_r($_SESSION);echo "</pre>";exit;
$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempid=$_SESSION['budget']['tempID'];
//echo $tempid;
extract($_REQUEST);
//echo "<pre>";print_r($_REQUEST);"</pre>";//exit;
$start_date=str_replace("-","",$start_date);
$end_date=str_replace("-","",$end_date);
//echo "start_date=$start_date";
//echo "<br />"; 
//echo "end_date=$end_date";exit;
$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/connectROOT.inc"); // connection parameters
mysql_select_db($database, $connection); // database
include("../../../../include/activity.php");// database connection parameters
//echo "submit1=$submit1";echo "submit2=$submit2";exit;

$query1="update exp_rev_extract,center
set exp_rev_extract.parkcode=center.parkcode
where exp_rev_extract.center=center.center;
";
mysql_query($query1) or die ("Couldn't execute query 1. $query1");

$query2="update exp_rev_extract,coa
set exp_rev_extract.account_description=coa.park_acct_desc
where exp_rev_extract.acct=coa.ncasnum;
";
mysql_query($query2) or die ("Couldn't execute query 2. $query2");

$query3="CREATE TABLE `budget`.`ciaa_count_exp_rev` (
`ciaa` varchar( 60 ) NOT NULL default '',
`ciaa_count` int( 10 ) NOT NULL default '0',
`id` int( 10 ) unsigned NOT NULL AUTO_INCREMENT ,
PRIMARY KEY ( `id` ) ,
KEY `ciaa` ( `ciaa` )
) ENGINE = MyISAM ;
";
mysql_query($query3) or die ("Couldn't execute query 3. $query3");

$query4="insert into ciaa_count_exp_rev(ciaa,ciaa_count)
select ciaa,count(ciaa)
from exp_rev_extract
where 1
and exp_rev_extract.cvip_id=''
and acctdate >= 
'$start_date'
and acctdate <= 
'$end_date'
group by ciaa;
";
mysql_query($query4) or die ("Couldn't execute query 4. $query4");

$query5="update exp_rev_extract,ciaa_count_exp_rev
set exp_rev_extract.ciaa_count=ciaa_count_exp_rev.ciaa_count
where exp_rev_extract.ciaa=ciaa_count_exp_rev.ciaa
and exp_rev_extract.cvip_id=''
and exp_rev_extract.acctdate >= 
'$start_date'
and exp_rev_extract.acctdate <= 
'$end_date'
;
";
mysql_query($query5) or die ("Couldn't execute query 5. $query5");

$query6="CREATE TABLE `budget`.`caa_count_exp_rev` (
`caa` varchar( 60 ) NOT NULL default '',
`caa_count` int( 10 ) NOT NULL default '0',
`id` int( 10 ) unsigned NOT NULL AUTO_INCREMENT ,
PRIMARY KEY ( `id` ) ,
KEY `ciaa` ( `caa` )
) ENGINE = MyISAM ;";
mysql_query($query6) or die ("Couldn't execute query 6. $query6");


$query6a="insert into caa_count_exp_rev(caa,caa_count)
select caa,count(caa)
from exp_rev_extract
where 1
and exp_rev_extract.cvip_id=''
and acctdate >= 
'$start_date'
and acctdate <= 
'$end_date'
group by caa;";
mysql_query($query6a) or die ("Couldn't execute query 6a. $query6a");

$query7="update exp_rev_extract,caa_count_exp_rev
set exp_rev_extract.caa_count=caa_count_exp_rev.caa_count
where exp_rev_extract.caa=caa_count_exp_rev.caa
and exp_rev_extract.cvip_id=''
and exp_rev_extract.acctdate >= 
'$start_date'
and exp_rev_extract.acctdate <= 
'$end_date'
;
";
mysql_query($query7) or die ("Couldn't execute query 7. $query7");

$query8="drop table ciaa_count_exp_rev;

";
mysql_query($query8) or die ("Couldn't execute query 8. $query8");

$query9="drop table caa_count_exp_rev;";
mysql_query($query9) or die ("Couldn't execute query 9. $query9");

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

























