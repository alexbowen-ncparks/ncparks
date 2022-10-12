<?php
session_start();
//echo "<pre>";print_r($_SESSION);echo "</pre>";exit;
$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempid=$_SESSION['budget']['tempID'];
//echo $tempid;
//extract($_REQUEST);
//echo "<pre>";print_r($_REQUEST);echo "</pre>"; //exit;
$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
//include("../../../../include/activity.php");// database connection parameters
//$status='complete';
$project_category='fms';
$project_name='weekly_updates';
$step_group='C';
$step_num='1j';

//echo "<br />project_category=$project_category<br />";
//echo "<br />project_name=$project_name<br />";
//echo "<br />step_group=$step_group<br />";
//echo "<br />step_num=$step_num<br />";


//echo "<br />Line 27<br />";

//exit;
/*
$query1="SELECT back_date_yn from project_steps_mode where 1
         and project_category='$project_category' and project_name='$project_name'
         limit 1		 ";

$result1 = mysqli_query($connection, $query1) or die ("Couldn't execute query 1.  $query1");

$row1=mysqli_fetch_array($result1);
extract($row1);//brings back max (end_date) as $end_date


//echo "<br />back_date_set=$back_date_set<br />";
echo "<br />back_date_yn=$back_date_yn<br />";

$query1="SELECT cy,py1 from fiscal_year where active_year='y' ";
         
		 
//echo "query1=$query1<br />";		 

$result1 = mysqli_query($connection, $query1) or die ("Couldn't execute query 1.  $query1");

$row1=mysqli_fetch_array($result1);
extract($row1);	

echo "<br />cy=$cy<br />";
echo "<br />py1=$py1<br />";

if($back_date_yn=='n'){$fiscal_year=$cy;}
if($back_date_yn=='y'){$fiscal_year=$py1;}

echo "<br />fiscal_year=$fiscal_year<br >";

//exit;

$query1a="update project_steps set back_date_yn='$back_date_yn' where project_category='$project_category' and project_name='$project_name' ";
$result1a = mysqli_query($connection, $query1a) or die ("Couldn't execute query 1a.  $query1a");


$query1b="update project_steps_detail set back_date_yn='$back_date_yn' where project_category='$project_category' and project_name='$project_name' ";
$result1b = mysqli_query($connection, $query1b) or die ("Couldn't execute query 1b.  $query1b");





//echo "<br />Line 35: back_date_yn<br />";

$query3="SELECT max(acctdate) as 'last_update' FROM `exp_rev` where sys != 'wa' and f_year='$fiscal_year' ";

$result3 = mysqli_query($connection, $query3) or die ("Couldn't execute query 3.  $query3");

$row3=mysqli_fetch_array($result3);
extract($row3);//brings back $last_update

// get start_date for New Weekly Update
$last_update2=str_replace("-","",$last_update);  //get rid of hyphens in last_update
$last_update3=strtotime("$last_update"); //unix time for last_update
$last_update4=($last_update3+60*60*24); //unix time for last_update + 1day
$last_update5=date("Ymd", $last_update4);  //yyyymmdd for last_update + 1day
$start_date=$last_update5;

// get end_date for New Weekly Update
$todays_date=date("Ymd", time() );
if($back_date_yn=='n'){$end_date=$todays_date;}
if($back_date_yn=='y')
{
$query="SELECT end_date FROM `fiscal_year` where report_year='$py1' ";

$result = mysqli_query($connection, $query) or die ("Couldn't execute query .  $query");

$row=mysqli_fetch_array($result);
extract($row);//brings back $last_update
$end_date=str_replace("-","",$end_date);
$start_date=$end_date;

}
*/

$query0="select back_date_yn,fiscal_year,start_date,end_date
         from project_steps_mode
		 where project_category='$project_category' and project_name='$project_name' "; 



$result0 = mysqli_query($connection, $query0) or die ("Couldn't execute query 0.  $query0");

$row0=mysqli_fetch_array($result0);
extract($row0);




$query1="update project_steps set fiscal_year='$fiscal_year',start_date='$start_date',
         end_date='$end_date',back_date_yn='$back_date_yn',status='pending', time_complete='', time_elapsed_sec='', time_elapsed_min='' where 1 and project_category='$project_category'
		 and project_name='$project_name' "; 



mysqli_query($connection, $query1) or die ("Couldn't execute query 1.  $query1");


$query2="update project_steps_detail set fiscal_year='$fiscal_year',start_date='$start_date',
         end_date='$end_date',back_date_yn='$back_date_yn',status='pending' where 1 and project_category='$project_category'
		 and project_name='$project_name' "; 
		 
		 
mysqli_query($connection, $query2) or die ("Couldn't execute query 2.  $query2");


//echo "<br />Line 109<br />";
//exit;


$query1a="truncate table cab_dpr_temp; ";

//echo "line 24: query=$query<br />"; exit;
			 
mysqli_query($connection, $query1a) or die ("Couldn't execute query1a.  $query1a");


$query1b="truncate table bd725_dpr_temp; ";

//echo "line 24: query=$query<br />"; exit;
			 
mysqli_query($connection, $query1b) or die ("Couldn't execute query1b.  $query1b");



$query1e="truncate table bd725_dpr_temp_pre; ";

//echo "line 24: query=$query<br />"; exit;
			 
mysqli_query($connection, $query1e) or die ("Couldn't execute query1e.  $query1e");


$query1f="truncate table exp_rev_dncr_osc2; ";

//echo "line 24: query=$query<br />"; exit;
			 
mysqli_query($connection, $query1f) or die ("Couldn't execute query1f.  $query1f");


$query1g="truncate table exp_rev_dncr_osc3; ";

//echo "line 24: query=$query<br />"; exit;
			 
mysqli_query($connection, $query1g) or die ("Couldn't execute query1g.  $query1g");

/*
$query1h="truncate table pcard; ";

//echo "line 24: query=$query<br />"; exit;
			 
mysqli_query($connection, $query1h) or die ("Couldn't execute query1h.  $query1h");
*/




/*
$query30="update budget.project_steps_detail set status='complete' 
          where project_category='$project_category' and project_name='$project_name'
		  and step_group='$step_group' and step_num='$step_num' ";
		  
		  
mysqli_query($connection, $query30) or die ("Couldn't execute query 30.  $query30");
*/

//echo "<br />Line 116<br />";
//exit;

/*
echo "<br />project_category=$project_category<br />";
echo "<br />project_name=$project_name<br />";
echo "<br />step_group=$step_group<br />";
echo "<br />step_num=$step_num<br />";
echo "<br />fiscal_year=$fiscal_year<br />";
echo "<br />start_date=$start_date<br />";
echo "<br />end_date=$end_date<br />";

echo "<br />Line 195<br />";
exit;

*/




{header("location: /budget/dncr_upload_cs2.php?project_category=$project_category&project_name=$project_name&step_group=$step_group&fiscal_year=$fiscal_year&start_date=$start_date&end_date=$end_date&report_type=form");}





 
 ?>