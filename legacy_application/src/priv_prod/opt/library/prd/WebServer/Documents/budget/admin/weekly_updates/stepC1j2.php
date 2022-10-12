<?php

//echo "<pre>";print_r($_REQUEST);echo "</pre>"; exit;
session_start();
//echo "<pre>";print_r($_SESSION);echo "</pre>";exit;
$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempid=$_SESSION['budget']['tempID'];
//echo $tempid;
extract($_REQUEST);
//$end_date=str_replace("-","",$end_date);

//echo "<pre>";print_r($_REQUEST);echo "</pre>";  exit;
//echo "end_date=$end_date"; exit;
//Tables used:
//budget.cab_dpr,budget.coa,budget.authorized_budget,budget.valid_fund_accounts,
//budget.project_steps_detail,budget.project_steps

$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
//include("../../../../include/activity.php");// database connection parameters
//2018-0410
/*
$query14c="update bd725_dpr_temp,center
set bd725_dpr_temp.dpr='y'
where bd725_dpr_temp.fund=center.new_center
and bd725_dpr_temp.fund != '' ";

$result14c=mysqli_query($connection, $query14c) or die ("Couldn't execute query 14c.  $query14c");
*/


$project_category='fms';
$project_name='weekly_updates';
$step_group='C';
$step_num='1j2';

$query0="select back_date_yn,fiscal_year,start_date,end_date
         from project_steps_mode
		 where project_category='$project_category' and project_name='$project_name' "; 



$result0 = mysqli_query($connection, $query0) or die ("Couldn't execute query 0.  $query0");

$row0=mysqli_fetch_array($result0);
extract($row0);

$start_date2=str_replace("-","",$start_date);
$end_date2=str_replace("-","",$end_date);


$query0a="select start_date as 'first_day_of_fyear',end_date as 'last_day_of_fyear' from fiscal_year
         where start_date <= '$start_date2' and end_date >= '$start_date2'            ";

//echo "query0a=$query0a<br /><br />"; //exit;
			 
$result0a = mysqli_query($connection, $query0a) or die ("Couldn't execute query 0a.  $query0a");

$row0a=mysqli_fetch_array($result0a);
extract($row0a);

$first_day_of_fyear=str_replace("-","",$first_day_of_fyear);
$last_day_of_fyear=str_replace("-","",$last_day_of_fyear);


echo "<br />back_date_yn=$back_date_yn<br />";
echo "<br />fiscal_year=$fiscal_year<br />";
echo "<br />start_date=$start_date<br />";
echo "<br />start_date2=$start_date2<br />";
echo "<br />end_date=$end_date<br />";
echo "<br />end_date2=$end_date2<br />";
echo "<br />first_day_of_fyear=$first_day_of_fyear<br />";
echo "<br />last_day_of_fyear=$last_day_of_fyear<br />";

//echo "<pre>";print_r($_REQUEST);echo "</pre>"; exit;
//exit;

//echo "<br />hello world2<br />";




// these 10 steps run checks and balances between the 3 csv file uploads (exp_rev_ws,cab_dpr,bd725_dpr) that go into the tables, where the balancing takes place


include("stepC1j2a.php");
echo "<li><li><b>(1)</b> stepC1j2a.php (OK)</li>";


include("stepC1j2b.php");
echo "<li><b>(2)</b> stepC1j2b.php (OK)</li>";


include("stepC1j2c.php");
echo "<li><b>(3)</b> stepC1j2c.php (OK)</li>";



include("stepC1j2d.php");
echo "<li><b>(4)</b> stepC1j2d.php (OK)</li>";



include("stepC1j2e.php");
echo "<li><b>(5)</b> stepC1j2e.php (OK)</li>";





include("stepC1j4.php");
echo "<li><b>(6)</b> stepC1j4.php (OK)</li>";



include("stepC1j5.php");
echo "<li><b>(7)</b> stepC1j5.php (OK)</li>";





include("stepC1y.php");
echo "<li><b>(8)</b> stepC1y.php (OK)</li>";
//exit;








include("stepC2b.php");
echo "<li><b>(9)</b> stepC2b.php (OK)</li>";




include("stepC2f.php");
echo "<li><b>(10)</b> stepC2f.php (OK)</li>";






include("stepG1.php");
echo "<li><b>(11)</b> stepG1.php (OK)</li>";



include("stepG8n.php");
echo "<li><b>(12)</b> stepG8n.php (OK)</li>";
//exit;








include("stepG8p.php");
echo "<li><b>(13)</b> stepG8p.php (OK)</li>";
//exit;






include("stepG8t1.php");
echo "<li><b>(14)</b> stepG8t1.php (OK)</li>";
//exit;





include("stepG8u.php");
echo "<li><b>(15)</b> stepG8u.php (OK)</li>";
//exit;




include("stepG8u1.php");
echo "<li><b>(16)</b> stepG8u1.php (OK)</li>";
//exit;



include("stepG8u2.php");
echo "<li><b>(17)</b> stepG8u2.php (OK)</li>";
//exit;




include("stepG8u3.php");
echo "<li><b>(18)</b> stepG8u3.php (OK)</li>";
//exit;






include("stepG8u4.php");
echo "<li><b>(19)</b> stepG8u4.php (OK)</li>";
//exit;







include("stepH2.php");
echo "<li><b>(20)</b> stepH2.php (OK)</li>";



include("stepH3.php");
echo "<li><b>(21)</b> stepH3.php (OK)</li>";


include("stepH4.php");
echo "<li><b>(22)</b> stepH4.php (OK)</li>";


include("stepH6.php");
echo "<li><b>(23)</b> stepH6.php (OK)</li>";

include("stepH7.php");
echo "<li><b>(24)</b> stepH7.php (OK)</li>";



include("stepH8g1.php");
echo "<li><b>(25)</b> stepH8g1.php (OK)</li>";



include("stepH8j.php");
echo "<li><b>(26)</b> stepH8j.php (OK)</li>";





include("stepH8k.php");
echo "<li><b>(27)</b> stepH8k.php (OK)</li>";




include("stepH8m.php");
echo "<li><b>(28)</b> stepH8m.php (OK)</li>";



include("stepH8n.php");
echo "<li><b>(29)</b> stepH8n.php (OK)</li>";



include("stepH8u.php");
echo "<li><b>(30)</b> stepH8u.php (OK)</li>";






include("stepH8v11.php");
echo "<li><b>(31)</b> stepH8v11.php (OK)</li>";



include("stepH8v2.php");
echo "<li><b>(32)</b> stepH8v2.php (OK)</li>";



include("stepH8v4.php");
echo "<li><b>(33)</b> stepH8v4.php (OK)</li>";



include("stepH8v4a.php");
echo "<li><b>(34)</b> stepH8v4a.php (OK)</li>";



include("stepH8v5.php");
echo "<li><b>(35)</b> stepH8v5.php (OK)</li>";



include("stepH8v6a1.php");
echo "<li><b>(36)</b> stepH8v6a1.php (OK)</li>";



include("stepH8v6a2.php");
echo "<li><b>(37)</b> stepH8v6a2.php (OK)</li>";



include("stepH8v6a3.php");
echo "<li><b>(38)</b> stepH8v6a3.php (OK)</li>";



include("stepH8v6a4.php");
echo "<li><b>(39)</b> stepH8v6a4.php (OK)</li>";



include("stepH8v7.php");
echo "<li><b>(40)</b> stepH8v7.php (OK)</li>";



include("stepH8v8a.php");
echo "<li><b>(41)</b> stepH8v8a.php (OK)</li>";



include("stepH8v8b.php");
echo "<li><b>(42)</b> stepH8v8b.php (OK)</li>";



include("stepH8v8c.php");
echo "<li><b>(43)</b> stepH8v8c.php (OK)</li>";



include("stepH8v8d.php");
echo "<li><b>(44)</b> stepH8v8d.php (OK)</li>";








$query23a="update budget.project_steps_detail set status='complete' where project_category='$project_category'
         and project_name='$project_name' and step_group='$step_group' and step_num='$step_num' ";
			 
mysqli_query($connection, $query23a) or die ("Couldn't execute query 23a.  $query23a");



echo "<br />Update Complete<br />";



//exit;

//{header("location: step_group.php?project_category=$project_category&project_name=$project_name&step_group=$step_group&fiscal_year=$fiscal_year&start_date=$start_date&end_date=$end_date&report_type=form");}
{header("location: main.php?project_category=$project_category&project_name=$project_name ");} 


 ?>
 
