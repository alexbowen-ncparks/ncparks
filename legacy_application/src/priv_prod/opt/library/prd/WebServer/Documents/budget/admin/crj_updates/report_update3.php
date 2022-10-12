<?php

//echo "<pre>";print_r($_REQUEST);echo "</pre>";//exit;
/*
session_start();
$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempid=$_SESSION['budget']['tempID'];
extract($_REQUEST);
echo "<pre>";print_r($_REQUEST);echo "</pre>";//exit;
*/
$report_date=str_replace("-","",$report_date);
/*
echo "report_date=$report_date";echo "<br />";
$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
include("../../../../include/activity.php");// database connection parameters

$database2="budget";
////mysql_connect($host,$username,$password);
@mysql_select_db($database2) or die( "Unable to select database");
*/
$query44="update crs_tdrr_history
set bdd_f2=mid(batch_deposit_date,1,2)
where 1;";

$result44 = mysqli_query($connection, $query44) or die ("Couldn't execute query 44.  $query44");

$query44a="update crs_tdrr_history
set bdd_f2_fix='y'
where bdd_f2 like '%/%';";

$result44a = mysqli_query($connection, $query44a) or die ("Couldn't execute query 44a.  $query44a");

$query44b="update crs_tdrr_history
set bdd_f2_new=concat('0',mid(bdd_f2,1,1))
where bdd_f2_fix='y';";

$result44b = mysqli_query($connection, $query44b) or die ("Couldn't execute query 44b.  $query44b");

$query44c="update crs_tdrr_history
set batch_deposit_date2=batch_deposit_date
where bdd_f2_fix != 'y';";

$result44c = mysqli_query($connection, $query44c) or die ("Couldn't execute query 44c.  $query44c");


$query44d="update crs_tdrr_history
set batch_deposit_date2=concat(bdd_f2_new,mid(batch_deposit_date,2,8))
where bdd_f2_fix='y';
";

$result44d = mysqli_query($connection, $query44d) or die ("Couldn't execute query 44d.  $query44d");

$query44e="update crs_tdrr_history
set bdd_s2=mid(batch_deposit_date2,4,2)
where 1;";

$result44e = mysqli_query($connection, $query44e) or die ("Couldn't execute query 44e.  $query44e");

$query44f="update crs_tdrr_history
set bdd_s2_fix='y'
where bdd_s2 like '%/%';";

$result44f = mysqli_query($connection, $query44f) or die ("Couldn't execute query 44f.  $query44f");

$query44g="update crs_tdrr_history
set bdd_s2_new=concat('0',mid(bdd_s2,1,1))
where bdd_s2_fix='y';";

$result44g = mysqli_query($connection, $query44g) or die ("Couldn't execute query 44g.  $query44g");

$query44h="update crs_tdrr_history
set batch_deposit_date3=batch_deposit_date2
where bdd_s2_fix != 'y';";

$result44h = mysqli_query($connection, $query44h) or die ("Couldn't execute query 44h.  $query44h");


$query44j="update crs_tdrr_history
set batch_deposit_date3=concat(mid(batch_deposit_date2,1,3),bdd_s2_new,mid(batch_deposit_date2,5,5))
where bdd_s2_fix='y';";

$result44j = mysqli_query($connection, $query44j) or die ("Couldn't execute query 44j.  $query44j");


$query44k="update crs_tdrr_history
set bdd_new=concat(mid(batch_deposit_date3,7,4),mid(batch_deposit_date3,1,2),mid(batch_deposit_date3,4,2))
where 1;";

$result44k = mysqli_query($connection, $query44k) or die ("Couldn't execute query 44k.  $query44k");

$query44m="update crs_tdrr_history
set bdd_new=trim(bdd_new) where 1;";

$result44m = mysqli_query($connection, $query44m) or die ("Couldn't execute query 44m.  $query44m");


$query33="SELECT day1 as 'day1',day2 as 'day2',day3 as 'day3',day4 as 'day4',day5 as 'day5',day6 as 'day6',day7 as 'day7' from crj_report_dates where report_date='$report_date' ";

$result33 = mysqli_query($connection, $query33) or die ("Couldn't execute query 33.  $query33");

$row33=mysqli_fetch_array($result33);
extract($row33);//brings back max (fiscal_year) as $fiscal_year
$day1=str_replace("-","",$day1);
$day2=str_replace("-","",$day2);
$day3=str_replace("-","",$day3);
$day4=str_replace("-","",$day4);
$day5=str_replace("-","",$day5);
$day6=str_replace("-","",$day6);
$day7=str_replace("-","",$day7);

//echo "day1=$day1";echo "<br />";
//echo "day2=$day2";echo "<br />";
//echo "day3=$day3";echo "<br />";
//echo "day4=$day4";echo "<br />";
//echo "day5=$day5";echo "<br />";//exit;
//echo "day6=$day6";echo "<br />";//exit;
//echo "day7=$day7";echo "<br />";//exit;


$query11a="truncate table crj_weekly1; ";

$result11a = mysqli_query($connection, $query11a) or die ("Couldn't execute query 11a.  $query11a");

$query11b="insert into crj_weekly1(center,report_date,day1)
select center,'$report_date',sum(amount) from crs_tdrr_history where bdd_new='$day1' group by center;";

$result11b = mysqli_query($connection, $query11b) or die ("Couldn't execute query 11b.  $query11b");

$query11c="insert into crj_weekly1(center,report_date,day2)
select center,'$report_date',sum(amount) from crs_tdrr_history where bdd_new='$day2' group by center;";

$result11c = mysqli_query($connection, $query11c) or die ("Couldn't execute query 11c.  $query11c");

$query11d="insert into crj_weekly1(center,report_date,day3)
select center,'$report_date',sum(amount) from crs_tdrr_history where bdd_new='$day3' group by center;";

$result11d = mysqli_query($connection, $query11d) or die ("Couldn't execute query 11d.  $query11d");

$query11e="insert into crj_weekly1(center,report_date,day4)
select center,'$report_date',sum(amount) from crs_tdrr_history where bdd_new='$day4' group by center;";

$result11e = mysqli_query($connection, $query11e) or die ("Couldn't execute query 11e.  $query11e");

$query11f="insert into crj_weekly1(center,report_date,day5)
select center,'$report_date',sum(amount) from crs_tdrr_history where bdd_new='$day5' group by center; ";

$result11f = mysqli_query($connection, $query11f) or die ("Couldn't execute query 11f.  $query11f");

$query11g="insert into crj_weekly1(center,report_date,day6)
select center,'$report_date',sum(amount) from crs_tdrr_history where bdd_new='$day6' group by center; ";

$result11g = mysqli_query($connection, $query11g) or die ("Couldn't execute query 11g.  $query11g");

$query11h="insert into crj_weekly1(center,report_date,day7)
select center,'$report_date',sum(amount) from crs_tdrr_history where bdd_new='$day7' group by center; ";

$result11h = mysqli_query($connection, $query11h) or die ("Couldn't execute query 11h.  $query11h");

$query11j="truncate table crj_weekly2;";

$result11j = mysqli_query($connection, $query11j) or die ("Couldn't execute query 11j.  $query11j");

$query11k="insert into crj_weekly2(center,report_date,day1,day2,day3,day4,day5,day6,day7)
select center,report_date,sum(day1),sum(day2),sum(day3),sum(day4),sum(day5),sum(day6),sum(day7)
from crj_weekly1
where report_date='$report_date'
group by center;";

$result11k = mysqli_query($connection, $query11k) or die ("Couldn't execute query 11k.  $query11k");
//exit;
$query11m="delete from crj_weekly3 where report_date='$report_date';";

$result11m = mysqli_query($connection, $query11m) or die ("Couldn't execute query 11m.  $query11m");

$query11n="insert into crj_weekly3(center,report_date)
select center,'$report_date'
from crj_centers
where 1;";

$result11n = mysqli_query($connection, $query11n) or die ("Couldn't execute query 11n.  $query11n");
//exit;

$query11p="update crj_weekly3,crj_weekly2
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

$result11p = mysqli_query($connection, $query11p) or die ("Couldn't execute query 11p.  $query11p");


$query11r="update crj_weekly3,center
          set crj_weekly3.park=center.parkcode
		  where crj_weekly3.center=center.center; ";

$result11r = mysqli_query($connection, $query11r) or die ("Couldn't execute query 11r.  $query11r");


$query11s="update crj_weekly3 
          set total=day1+day2+day3+day4+day5+day6+day7
		  where 1; ";

$result11s = mysqli_query($connection, $query11s) or die ("Couldn't execute query 11s.  $query11s");



//echo "Update Successful";exit;

//echo "Report Update 2 under construction";echo "<br />";


?>