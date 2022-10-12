<?php

//echo "<pre>";print_r($_REQUEST);echo "</pre>"; 
//exit;
session_start();
if(!$_SESSION["budget"]["tempID"]){echo "access denied {stepA1}";exit;}
//echo "<pre>";print_r($_SESSION);echo "</pre>";exit;
$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempid=$_SESSION['budget']['tempID'];
//echo $tempid;
extract($_REQUEST);
$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
//echo "submit1=$submit1";echo "submit2=$submit2";exit;
//echo "<pre>";print_r($_REQUEST);"</pre>"; 
//echo "<br />reset_mode=$reset_mode<br />";
//exit;


//include("../../../budget/~f_year.php");

//$fiscal_year=$f_year;


//echo "<br />back_date_yn=$back_date_yn<br />";

//exit;


if($back_date_yn=='n'){$reset_mode='regular';}
if($back_date_yn=='y'){$reset_mode='backdate';}


//echo "<br />reset_mode=$reset_mode<br />";





if($reset_mode=='regular')
{$query0="update fiscal_year set back_date='n' where active_year='y'";
$result0 = mysqli_query($connection, $query0) or die ("Couldn't execute query0 .  $query0");

}

if($reset_mode=='backdate')
{$query0="update fiscal_year set back_date='y' where active_year='y'";
$result0 = mysqli_query($connection, $query0) or die ("Couldn't execute query0 .  $query0");


}

//exit;


$query="SELECT cy,py1,back_date FROM `fiscal_year` where active_year='y' ";

$result = mysqli_query($connection, $query) or die ("Couldn't execute query .  $query");

$row=mysqli_fetch_array($result);
extract($row);//brings back $last_update

//echo "<br />cy=$cy<br />";
//echo "<br />py1=$py1<br />";

//echo "<br />back_date=$back_date<br />";

if($back_date=='n'){$fiscal_year=$cy;}
if($back_date=='y'){$fiscal_year=$py1;}

//echo "<br />fiscal_year=$fiscal_year<br />";

//exit;


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

if($back_date=='n')
{
$query="SELECT start_date as 'firstday_fyear',end_date as 'lastday_fyear' FROM `fiscal_year` where report_year='$cy' ";

$result = mysqli_query($connection, $query) or die ("Couldn't execute query .  $query");

$row=mysqli_fetch_array($result);
extract($row);//brings back $last_update
$lastday_fyear=str_replace("-","",$lastday_fyear);	
$firstday_fyear=str_replace("-","",$firstday_fyear);	
	
if($todays_date > $lastday_fyear){$end_date=$lastday_fyear;}else{$end_date=$todays_date;}
if($start_date < $firstday_fyear){$start_date=$firstday_fyear;}
	
}

if($back_date=='y')
{
$query="SELECT end_date FROM `fiscal_year` where report_year='$py1' ";

$result = mysqli_query($connection, $query) or die ("Couldn't execute query .  $query");

$row=mysqli_fetch_array($result);
extract($row);//brings back $last_update
$end_date=str_replace("-","",$end_date);


}

/*
echo "<br />fiscal_year=$fiscal_year<br />";
echo "<br />start_date=$start_date<br />";
echo "<br />end_date=$end_date<br />";
echo "<br />project_category=$project_category<br />";
echo "<br />project_name=$project_name<br />";
echo "<br />back_date=$back_date<br />";
exit;
*/
 

$query1="update project_steps set back_date_yn='$back_date',fiscal_year='$fiscal_year',start_date='$start_date',end_date='$end_date',status='pending' where project_category='$project_category' and project_name='$project_name' "; 
mysqli_query($connection, $query1) or die ("Couldn't execute query 1.  $query1");


$query2="update project_steps_detail set back_date_yn='$back_date',fiscal_year='$fiscal_year',start_date='$start_date',end_date='$end_date',status='pending' where project_category='$project_category' and project_name='$project_name' "; 		 
mysqli_query($connection, $query2) or die ("Couldn't execute query 2.  $query2");


$query3="update project_steps_mode set back_date_yn='$back_date',fiscal_year='$fiscal_year',start_date='$start_date',end_date='$end_date' where project_category='$project_category' and project_name='$project_name' "; 		 
mysqli_query($connection, $query3) or die ("Couldn't execute query 3.  $query3");

 
 
 
?>