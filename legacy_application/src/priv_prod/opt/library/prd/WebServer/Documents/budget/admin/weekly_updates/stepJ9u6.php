<?php
//echo "<pre>";print_r($_REQUEST);echo "</pre>";//exit;
session_start();
//echo "<pre>";print_r($_SESSION);echo "</pre>";exit;
$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempid=$_SESSION['budget']['tempID'];
//echo $tempid;
extract($_REQUEST);
//echo "<pre>";print_r($_REQUEST);"</pre>"; exit;
//$start_date=str_replace("-","",$start_date);
//$end_date=str_replace("-","",$end_date);
//$today_date=date("Ymd");
//echo "start_date=$start_date";
//echo "<br />"; 
//echo "end_date=$end_date";//exit;
//echo "<br />"; 
//echo "today_date=$today_date";exit;

/*
$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
include("../../../../include/activity.php");// database connection parameters
//echo "submit1=$submit1";echo "submit2=$submit2";exit;
*/

//$start_date=str_replace("-","",$start_date);
//$end_date=str_replace("-","",$end_date);
//$today_date=date("Ymd");


//echo "<br />start_date=$start_date<br />";
//echo "<br />"; 
//echo "<br />end_date=$end_date<br />"; //exit;
$query1="truncate table bd725_dpr_funding_sources ";
			 
mysqli_query($connection, $query1) or die ("Couldn't execute query 1.  $query1");

//echo "<br /><br />query1=$query1<br /><br />";

$query2="insert into bd725_dpr_funding_sources(center,funding_type,amount)
         select center,naspd_funding_type,sum(amount)
		 from exp_rev_funding_by_fyear
		 where 1
		 group by center,naspd_funding_type";
			 
mysqli_query($connection, $query2) or die ("Couldn't execute query 2.  $query2");
//echo "<br /><br />query2=$query2<br /><br />";


$query3="truncate table bd725_dpr_funding_sources2";
			 
mysqli_query($connection, $query3) or die ("Couldn't execute query 3.  $query3");
//echo "<br /><br />query3=$query3<br /><br />";


$query4="insert into bd725_dpr_funding_sources2(center,funding_sources)
         SELECT center,count(funding_type)
		 FROM `bd725_dpr_funding_sources`
		 WHERE 1
		 and funding_type != 'transfer'
		 group by center";
			 
mysqli_query($connection, $query4) or die ("Couldn't execute query 4.  $query4");
//echo "<br /><br />query4=$query4<br /><br />";


$query5="update bd725_dpr_funding_sources2 as t1,bd725_dpr_funding_sources as  t2
         set t1.funding_source=t2.funding_type 
		 where t1.funding_sources='1'
         and t2.funding_type != 'transfer' 
		 and t1.center=t2.center";
			 
mysqli_query($connection, $query5) or die ("Couldn't execute query 5.  $query5");
//echo "<br /><br />query5=$query5<br /><br />";


$query6="update bd725_dpr_funding_sources2
         set funding_source='multiple'
		 where funding_sources != '1'";
			 
mysqli_query($connection, $query6) or die ("Couldn't execute query 6.  $query6");
//echo "<br /><br />query6=$query6<br /><br />";







//exit;

/*

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

{$query25="update budget.project_steps set status='complete',time_complete=unix_timestamp(now())
where project_category='$project_category' and project_name='$project_name' and step_group='$step_group' ";
		 
mysqli_query($connection, $query25) or die ("Couldn't execute query 25.  $query25");
}
////mysql_close();

if($num24==0)

{header("location: main.php?project_category=$project_category&project_name=$project_name ");}

if($num24!=0)

{header("location: step_group.php?project_category=$project_category&project_name=$project_name&step_group=$step_group&fiscal_year=$fiscal_year&start_date=$start_date&end_date=$end_date");}

*/


?>