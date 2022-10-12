<?php

//echo "<pre>";print_r($_REQUEST);echo "</pre>";//exit;
session_start();
$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempid=$_SESSION['budget']['tempID'];
extract($_REQUEST);
echo "<pre>";print_r($_REQUEST);echo "</pre>";//exit;
$report_date=str_replace("-","",$report_date);
echo "report_date=$report_date";echo "<br />";
$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
include("../../../../include/activity.php");// database connection parameters

$database2="budget";
////mysql_connect($host,$username,$password);
@mysql_select_db($database2) or die( "Unable to select database");

$query4="update crs_tdrr_history
set bdd_f2=mid(batch_deposit_date,1,2)
where 1;";

$result4 = mysqli_query($connection, $query4) or die ("Couldn't execute query 4.  $query4");

$query4a="update crs_tdrr_history
set bdd_f2_fix='y'
where bdd_f2 like '%/%';";

$result4a = mysqli_query($connection, $query4a) or die ("Couldn't execute query 4a.  $query4a");

$query4b="update crs_tdrr_history
set bdd_f2_new=concat('0',mid(bdd_f2,1,1))
where bdd_f2_fix='y';";

$result4b = mysqli_query($connection, $query4b) or die ("Couldn't execute query 4b.  $query4b");

$query4c="update crs_tdrr_history
set batch_deposit_date2=batch_deposit_date
where bdd_f2_fix != 'y';";

$result4c = mysqli_query($connection, $query4c) or die ("Couldn't execute query 4c.  $query4c");


$query4d="update crs_tdrr_history
set batch_deposit_date2=concat(bdd_f2_new,mid(batch_deposit_date,2,8))
where bdd_f2_fix='y';
";

$result4d = mysqli_query($connection, $query4d) or die ("Couldn't execute query 4d.  $query4d");

$query4e="update crs_tdrr_history
set bdd_s2=mid(batch_deposit_date2,4,2)
where 1;";

$result4e = mysqli_query($connection, $query4e) or die ("Couldn't execute query 4e.  $query4e");

$query4f="update crs_tdrr_history
set bdd_s2_fix='y'
where bdd_s2 like '%/%';";

$result4f = mysqli_query($connection, $query4f) or die ("Couldn't execute query 4f.  $query4f");

$query4g="update crs_tdrr_history
set bdd_s2_new=concat('0',mid(bdd_s2,1,1))
where bdd_s2_fix='y';";

$result4g = mysqli_query($connection, $query4g) or die ("Couldn't execute query 4g.  $query4g");

$query4h="update crs_tdrr_history
set batch_deposit_date3=batch_deposit_date2
where bdd_s2_fix != 'y';";

$result4h = mysqli_query($connection, $query4h) or die ("Couldn't execute query 4h.  $query4h");


$query4j="update crs_tdrr_history
set batch_deposit_date3=concat(mid(batch_deposit_date2,1,3),bdd_s2_new,mid(batch_deposit_date2,5,5))
where bdd_s2_fix='y';";

$result4j = mysqli_query($connection, $query4j) or die ("Couldn't execute query 4j.  $query4j");


$query4k="update crs_tdrr_history
set bdd_new=concat(mid(batch_deposit_date3,7,4),mid(batch_deposit_date3,1,2),mid(batch_deposit_date3,4,2))
where 1;";

$result4k = mysqli_query($connection, $query4k) or die ("Couldn't execute query 4k.  $query4k");

$query4m="update crs_tdrr_history
set bdd_new=trim(bdd_new) where 1;";

$result4m = mysqli_query($connection, $query4m) or die ("Couldn't execute query 4m.  $query4m");


$query3="SELECT day1 as 'day1',day2 as 'day2',day3 as 'day3',day4 as 'day4',day5 as 'day5',day6 as 'day6',day7 as 'day7' from crj_report_dates where report_date='$report_date' ";

$result3 = mysqli_query($connection, $query3) or die ("Couldn't execute query 3.  $query3");

$row3=mysqli_fetch_array($result3);
extract($row3);//brings back max (fiscal_year) as $fiscal_year
$day1=str_replace("-","",$day1);
$day2=str_replace("-","",$day2);
$day3=str_replace("-","",$day3);
$day4=str_replace("-","",$day4);
$day5=str_replace("-","",$day5);
$day6=str_replace("-","",$day6);
$day7=str_replace("-","",$day7);

echo "day1=$day1";echo "<br />";
echo "day2=$day2";echo "<br />";
echo "day3=$day3";echo "<br />";
echo "day4=$day4";echo "<br />";
echo "day5=$day5";echo "<br />";//exit;
echo "day6=$day6";echo "<br />";//exit;
echo "day7=$day7";echo "<br />";//exit;


$query1a="truncate table crj_weekly1; ";

$result1a = mysqli_query($connection, $query1a) or die ("Couldn't execute query 1a.  $query1a");

$query1b="insert into crj_weekly1(center,report_date,day1)
select center,'$report_date',sum(amount) from crs_tdrr_history where bdd_new='$day1' group by center;";

$result1b = mysqli_query($connection, $query1b) or die ("Couldn't execute query 1b.  $query1b");

$query1c="insert into crj_weekly1(center,report_date,day2)
select center,'$report_date',sum(amount) from crs_tdrr_history where bdd_new='$day2' group by center;";

$result1c = mysqli_query($connection, $query1c) or die ("Couldn't execute query 1c.  $query1c");

$query1d="insert into crj_weekly1(center,report_date,day3)
select center,'$report_date',sum(amount) from crs_tdrr_history where bdd_new='$day3' group by center;";

$result1d = mysqli_query($connection, $query1d) or die ("Couldn't execute query 1d.  $query1d");

$query1e="insert into crj_weekly1(center,report_date,day4)
select center,'$report_date',sum(amount) from crs_tdrr_history where bdd_new='$day4' group by center;";

$result1e = mysqli_query($connection, $query1e) or die ("Couldn't execute query 1e.  $query1e");

$query1f="insert into crj_weekly1(center,report_date,day5)
select center,'$report_date',sum(amount) from crs_tdrr_history where bdd_new='$day5' group by center; ";

$result1f = mysqli_query($connection, $query1f) or die ("Couldn't execute query 1f.  $query1f");

$query1g="insert into crj_weekly1(center,report_date,day6)
select center,'$report_date',sum(amount) from crs_tdrr_history where bdd_new='$day6' group by center; ";

$result1g = mysqli_query($connection, $query1g) or die ("Couldn't execute query 1g.  $query1g");

$query1h="insert into crj_weekly1(center,report_date,day7)
select center,'$report_date',sum(amount) from crs_tdrr_history where bdd_new='$day7' group by center; ";

$result1h = mysqli_query($connection, $query1h) or die ("Couldn't execute query 1h.  $query1h");

$query1j="truncate table crj_weekly2;";

$result1j = mysqli_query($connection, $query1j) or die ("Couldn't execute query 1j.  $query1j");

$query1k="insert into crj_weekly2(center,report_date,day1,day2,day3,day4,day5,day6,day7)
select center,report_date,sum(day1),sum(day2),sum(day3),sum(day4),sum(day5),sum(day6),sum(day7)
from crj_weekly1
where report_date='$report_date'
group by center;";

$result1k = mysqli_query($connection, $query1k) or die ("Couldn't execute query 1k.  $query1k");
//exit;
$query1m="delete from crj_weekly3 where report_date='$report_date';";

$result1m = mysqli_query($connection, $query1m) or die ("Couldn't execute query 1m.  $query1m");

$query1n="insert into crj_weekly3(center,report_date)
select center,'$report_date'
from crj_centers
where 1;";

$result1n = mysqli_query($connection, $query1n) or die ("Couldn't execute query 1n.  $query1n");
//exit;

$query1p="update crj_weekly3,crj_weekly2
set crj_weekly3.day1=crj_weekly2.day1,
crj_weekly3.day2=crj_weekly2.day2,
crj_weekly3.day3=crj_weekly2.day3,
crj_weekly3.day4=crj_weekly2.day4,
crj_weekly3.day5=crj_weekly2.day5,
crj_weekly3.day6=crj_weekly2.day6,
crj_weekly3.day7=crj_weekly2.day7
where crj_weekly3.center=crj_weekly2.center
and crj_weekly3.report_date=crj_weekly2.report_date;
";

//echo "query5=$query5";

$result1p = mysqli_query($connection, $query1p) or die ("Couldn't execute query 1p.  $query1p");


$query1r="update crj_weekly3,center
          set crj_weekly3.park=center.parkcode
		  where crj_weekly3.center=center.center; ";

$result1r = mysqli_query($connection, $query1r) or die ("Couldn't execute query 1r.  $query1r");


$query1s="update crj_weekly3 
          set total=day1+day2+day3+day4+day5+day6+day7
		  where 1; ";

$result1s = mysqli_query($connection, $query1s) or die ("Couldn't execute query 1s.  $query1s");



echo "Update Successful";exit;

echo "Report Update 2 under construction";echo "<br />";


?>