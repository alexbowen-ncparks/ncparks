<?php
//echo "<pre>";print_r($_REQUEST);echo "</pre>";//exit;
session_start();
//echo "<pre>";print_r($_SESSION);echo "</pre>";exit;
$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempid=$_SESSION['budget']['tempID'];
//echo $tempid;
extract($_REQUEST);
//echo "<pre>";print_r($_REQUEST);echo "</pre>";//exit;

//$start_date=str_replace("-","",$start_date);
//$end_date=str_replace("-","",$end_date);
//echo "start_date=$start_date";
//echo "<br />"; 
//echo "end_date=$end_date"; exit;
$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
include("../../../../include/activity.php");// database connection parameters
//echo "submit1=$submit1";echo "submit2=$submit2";exit;

$start_date=str_replace("-","",$start_date);
$end_date=str_replace("-","",$end_date);



$query1="truncate table ere_unmatched;
";
mysqli_query($connection, $query1) or die ("Couldn't execute query 1. $query1");
//echo "ok1";

$query2="insert into ere_unmatched(
center,
park,
account,
vendor,
invoice,
amount,
cvip_id,
postdate,
recon,ncasnum,id)
select
exp_rev_extract.center,
exp_rev_extract.parkcode,
concat(exp_rev_extract.acct,'-',coa.park_acct_desc),
exp_rev_extract.description,
exp_rev_extract.invoice,
exp_rev_extract.debit_credit,
exp_rev_extract.cvip_id,
exp_rev_extract.acctdate,
 'n',exp_rev_extract.acct,''
from exp_rev_extract
left join center on exp_rev_extract.center=center.center
left join coa on exp_rev_extract.acct=coa.ncasnum
where 1
and exp_rev_extract.cvip_id=''
and exp_rev_extract.acctdate >=
'$start_date'
and exp_rev_extract.acctdate <= 
'$end_date'
order by exp_rev_extract.center,exp_rev_extract.description;
";
mysqli_query($connection, $query2) or die ("Couldn't execute query 2. $query2");
//echo "ok2";


$query3="truncate table ere_unmatched_credits;
";
mysqli_query($connection, $query3) or die ("Couldn't execute query 3. $query3");
//echo "ok3";


$query4="insert into ere_unmatched_credits (identifier,count_identifier,amount,sign,ere_unmatched_id)
select
concat(center,'_',invoice,'_',abs(amount),'_',postdate) as 'identifier',
count(concat(center,'_',invoice,'_',abs(amount),'_',postdate)) as 'count_identifier',
amount,'credit',id
from ere_unmatched
where amount < '0'
group by identifier ;
";
mysqli_query($connection, $query4) or die ("Couldn't execute query 4. $query4");

//echo "ok4";


$query5="truncate table ere_unmatched_debits;
";
mysqli_query($connection, $query5) or die ("Couldn't execute query 5. $query5");

//echo "ok5";

$query6="insert into ere_unmatched_debits (identifier,count_identifier,amount,sign,ere_unmatched_id)
select
concat(center,'_',invoice,'_',abs(amount),'_',postdate) as 'identifier',
count(concat(center,'_',invoice,'_',abs(amount),'_',postdate)) as 'count_identifier' ,
amount,'debit',id
from ere_unmatched
where amount > '0'
group by identifier;
";
mysqli_query($connection, $query6) or die ("Couldn't execute query 6. $query6");

//echo "ok6";


$query7="update ere_unmatched_debits,ere_unmatched_credits
set ere_unmatched_debits.correction='y'
where ere_unmatched_debits.identifier=ere_unmatched_credits.identifier
and ere_unmatched_debits.count_identifier='1'
and ere_unmatched_credits.count_identifier='1';
";
mysqli_query($connection, $query7) or die ("Couldn't execute query 7. $query7");

//echo "ok7";

$query8="update ere_unmatched_credits,ere_unmatched_debits
set ere_unmatched_credits.correction='y'
where ere_unmatched_credits.identifier=ere_unmatched_debits.identifier
and ere_unmatched_credits.count_identifier='1'
and ere_unmatched_debits.count_identifier='1';
";
mysqli_query($connection, $query8) or die ("Couldn't execute query 8. $query8");

//echo "ok8";

$query9="update ere_unmatched,ere_unmatched_debits
set ere_unmatched.cvip_id='nm'
where ere_unmatched.id=ere_unmatched_debits.ere_unmatched_id
and ere_unmatched_debits.correction='y';
";
mysqli_query($connection, $query9) or die ("Couldn't execute query 9. $query9");

//echo "ok9";

$query10="update ere_unmatched,ere_unmatched_credits
set ere_unmatched.cvip_id='nm'
where ere_unmatched.id=ere_unmatched_credits.ere_unmatched_id
and ere_unmatched_credits.correction='y';
";
mysqli_query($connection, $query10) or die ("Couldn't execute query 10. $query10");

//echo "ok10";

$query11="update ere_unmatched
set recon='y'
where cvip_id='nm';
";
mysqli_query($connection, $query11) or die ("Couldn't execute query 11. $query11");

//echo "ok11";



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

























