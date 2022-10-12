<?php

//echo "<pre>";print_r($_REQUEST);echo "</pre>"; //exit;
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
$step_group='J';
$step_num='0';

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

//exit;

if($back_date_yn=='n')
{

include("stepJ01.php");
echo "<li><b>(45)</b> stepJ01.php (OK)</li>";



include("stepJ1.php");
echo "<li><b>(46)</b> stepJ1.php (OK)</li>";



include("stepJ2.php");
echo "<li><b>(47)</b> stepJ2.php (OK)</li>";



include("stepJ3.php");
echo "<li><b>(48)</b> stepJ3.php (OK)</li>";



include("stepJ4.php");
echo "<li><b>(49)</b> stepJ4.php (OK)</li>";



include("stepJ5.php");
echo "<li><b>(50)</b> stepJ5.php (OK)</li>";



include("stepJ6.php");
echo "<li><b>(51)</b> stepJ6.php (OK)</li>";



include("stepJ7.php");
echo "<li><b>(52)</b> stepJ7.php (OK)</li>";



include("stepJ8.php");
echo "<li><b>(53)</b> stepJ8.php (OK)</li>";



include("stepJ8a.php");
echo "<li><b>(54)</b> stepJ8a.php (OK)</li>";



include("stepJ8b.php");
echo "<li><b>(55)</b> stepJ8b.php (OK)</li>";



include("stepJ8c.php");
echo "<li><b>(56)</b> stepJ8c.php (OK)</li>";



include("stepJ8d.php");
echo "<li><b>(57)</b> stepJ8d.php (OK)</li>";



include("stepJ8e.php");
echo "<li><b>(58)</b> stepJ8e.php (OK)</li>";



include("stepJ8f.php");
echo "<li><b>(59)</b> stepJ8f.php (OK)</li>";



include("stepJ8g.php");
echo "<li><b>(60)</b> stepJ8g.php (OK)</li>";



include("stepJ8h.php");
echo "<li><b>(61)</b> stepJ8h.php (OK)</li>";



include("stepJ8j.php");
echo "<li><b>(62)</b> stepJ8j.php (OK)</li>";



include("stepJ8k.php");
echo "<li><b>(63)</b> stepJ8k.php (OK)</li>";



include("stepJ8m.php");
echo "<li><b>(64)</b> stepJ8m.php (OK)</li>";



include("stepJ8n.php");
echo "<li><b>(65)</b> stepJ8n.php (OK)</li>";



include("stepJ8p.php");
echo "<li><b>(66)</b> stepJ8p.php (OK)</li>";



include("stepJ8q.php");
echo "<li><b>(67)</b> stepJ8q.php (OK)</li>";



include("stepJ8r.php");
echo "<li><b>(68)</b> stepJ8r.php (OK)</li>";



include("stepJ8s.php");
echo "<li><b>(69)</b> stepJ8s.php (OK)</li>";



include("stepJ8t.php");
echo "<li><b>(70)</b> stepJ8t.php (OK)</li>";



include("stepJ8u.php");
echo "<li><b>(71)</b> stepJ8u.php (OK)</li>";



include("stepJ8v.php");
echo "<li><b>(72)</b> stepJ8v.php (OK)</li>";



include("stepJ8w.php");
echo "<li><b>(73)</b> stepJ8w.php (OK)</li>";



include("stepJ8x.php");
echo "<li><b>(74)</b> stepJ8x.php (OK)</li>";



include("stepJ8y.php");
echo "<li><b>(75)</b> stepJ8y.php (OK)</li>";



include("stepJ8z.php");
echo "<li><b>(76)</b> stepJ8z.php (OK)</li>";



include("stepJ8z1.php");
echo "<li><b>(77)</b> stepJ8z1.php (OK)</li>";



include("stepJ9b.php");
echo "<li><b>(78)</b> stepJ9b.php (OK)</li>";



include("stepJ9c.php");
echo "<li><b>(79)</b> stepJ9c.php (OK)</li>";



include("stepJ9c1.php");
echo "<li><b>(80)</b> stepJ9c1.php (OK)</li>";



include("stepJ9d.php");
echo "<li><b>(81)</b> stepJ9d.php (OK)</li>";



include("stepJ9f.php");
echo "<li><b>(82)</b> stepJ9f.php (OK)</li>";



include("stepJ9g.php");
echo "<li><b>(83)</b> stepJ9g.php (OK)</li>";



include("stepJ9h.php");
echo "<li><b>(84)</b> stepJ9h.php (OK)</li>";



include("stepJ9p.php");
echo "<li><b>(85)</b> stepJ9p.php (OK)</li>";



include("stepJ9q.php");
echo "<li><b>(86)</b> stepJ9q.php (OK)</li>";



include("stepJ9s.php");
echo "<li><b>(87)</b> stepJ9s.php (OK)</li>";



include("stepJ9t1.php");
echo "<li><b>(88)</b> stepJ9t1.php (OK)</li>";



include("stepJ9u.php");
echo "<li><b>(89)</b> stepJ9u.php (OK)</li>";



include("stepJ9u2.php");
echo "<li><b>(90)</b> stepJ9u2.php (OK)</li>";



include("stepJ9u4.php");
echo "<li><b>(91)</b> stepJ9u4.php (OK)</li>";



include("stepJ9u5.php");
echo "<li><b>(92)</b> stepJ9u5.php (OK)</li>";



include("stepJ9u6.php");
echo "<li><b>(93)</b> stepJ9u6.php (OK)</li>";



include("stepJ9u8.php");
echo "<li><b>(94)</b> stepJ9u8.php (OK)</li>";


include("stepJ9u8a.php");
echo "<li><b>(95)</b> stepJ9u8a.php (OK)</li>";



}



$query23a="update budget.project_steps_detail set status='complete' where project_category='$project_category'
         and project_name='$project_name' and step_group='$step_group' and step_num='$step_num' ";
			 
mysqli_query($connection, $query23a) or die ("Couldn't execute query 23a.  $query23a");



echo "<br />Update Complete<br />";


exit;

//{header("location: step_group.php?project_category=$project_category&project_name=$project_name&step_group=$step_group&fiscal_year=$fiscal_year&start_date=$start_date&end_date=$end_date&report_type=form");}
  

 ?>