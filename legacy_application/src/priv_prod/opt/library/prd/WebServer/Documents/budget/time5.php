<?php

session_start();

if(!$_SESSION["budget"]["tempID"]){echo "access denied";exit;
//header("location: https://legacypriv36.dev.dpr.ncparks.gov/login_form.php?db=budget");
}

//echo "<pre>";print_r($_SESSION);echo "</pre>";exit;
//echo "<pre>";print_r($_REQUEST);echo "</pre>"; //exit;
$level=$_SESSION['budget']['level'];
$tempID=$_SESSION['budget']['tempID'];
$posTitle=$_SESSION['budget']['position'];
$beacon_num=$_SESSION['budget']['beacon_num'];
$pcode=$_SESSION['budget']['select'];
$centerSess=$_SESSION['budget']['centerSess'];
//echo $tempid;
extract($_REQUEST);
//$menu_fa='fa1';
//$source_table='flag';
echo "Re-code at EOY for the following year";
echo "<pre>";print_r($_REQUEST);echo "</pre>"; exit;
$database="budget";
$db="budget";
//include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
//mysqli_select_db($connection, $database); // database
mysqli_select_db($connection,$database); // database
//include("../../../include/activity_new.php");// database connection parameters
//include("../../budget/~f_year.php");

//Update Table=flag.days_elapsed with days_elapsed=0 thru days_elapsed=10
//$sed=date("Ymd");
//$query="update flag set today_time='$sed' where 1 ";
//$result=mysqli_query($connection,$query) or die ("Couldn't execute query. $query");
	// Set timezone
	date_default_timezone_set('America/New_York');

	// Start date
	$date = '2017-07-01';
	$date2 = '2017-06-30';
	// End date
	$end_date = '2018-06-30';
    $hid='1265';
	
	
	
	echo "<table>";
	while (strtotime($date) <= strtotime($end_date)) {
		        $dow=date('l',strtotime($date));
		        $dow2=date('l',strtotime($date2));
				$query="insert into yearly_dates(hid,date1,dow1,date2,dow2) select '$hid','$date','$dow','$date2','$dow2' ";
				
                echo "<tr><td>$hid</td><td>$date</td><td>$dow</td><td>$date2</td><td>$dow2</td><td>$query</td></tr>";
				
				
                $result=mysqli_query($connection,$query) or die ("Couldn't execute query. $query");
				
				$date = date ("Y-m-d", strtotime("+1 day", strtotime($date)));
				$date2 = date ("Y-m-d", strtotime("+1 day", strtotime($date2)));
				$hid++;
	}
    echo "</table>";
	


$query="update yearly_dates set date1_year=mid(date1,1,4) where 1 ";
$result=mysqli_query($connection,$query) or die ("Couldn't execute query. $query");

	
$query="update yearly_dates set date1_month='july' where mid(date1,6,2)='07' ";
$result=mysqli_query($connection,$query) or die ("Couldn't execute query. $query");

$query="update yearly_dates set date1_month='august' where mid(date1,6,2)='08' ";
$result=mysqli_query($connection,$query) or die ("Couldn't execute query. $query");		
	
$query="update yearly_dates set date1_month='september' where mid(date1,6,2)='09' ";
$result=mysqli_query($connection,$query) or die ("Couldn't execute query. $query");		
	
$query="update yearly_dates set date1_month='october' where mid(date1,6,2)='10' ";
$result=mysqli_query($connection,$query) or die ("Couldn't execute query. $query");		
	
$query="update yearly_dates set date1_month='november' where mid(date1,6,2)='11' ";
$result=mysqli_query($connection,$query) or die ("Couldn't execute query. $query");		
	
$query="update yearly_dates set date1_month='december' where mid(date1,6,2)='12' ";
$result=mysqli_query($connection,$query) or die ("Couldn't execute query. $query");		
	
$query="update yearly_dates set date1_month='january' where mid(date1,6,2)='01' ";
$result=mysqli_query($connection,$query) or die ("Couldn't execute query. $query");		
	
$query="update yearly_dates set date1_month='february' where mid(date1,6,2)='02' ";
$result=mysqli_query($connection,$query) or die ("Couldn't execute query. $query");		
	
$query="update yearly_dates set date1_month='march' where mid(date1,6,2)='03' ";
$result=mysqli_query($connection,$query) or die ("Couldn't execute query. $query");		
	
$query="update yearly_dates set date1_month='april' where mid(date1,6,2)='04' ";
$result=mysqli_query($connection,$query) or die ("Couldn't execute query. $query");		

$query="update yearly_dates set date1_month='may' where mid(date1,6,2)='05' ";
$result=mysqli_query($connection,$query) or die ("Couldn't execute query. $query");	

$query="update yearly_dates set date1_month='june' where mid(date1,6,2)='06' ";
$result=mysqli_query($connection,$query) or die ("Couldn't execute query. $query");	

$query="update yearly_dates set date1_month2=mid(date1,6,2) where 1 ";
$result=mysqli_query($connection,$query) or die ("Couldn't execute query. $query");	

$query="update yearly_dates set date1_day=mid(date1,9,2) where 1 ";
$result=mysqli_query($connection,$query) or die ("Couldn't execute query. $query");

$query="update yearly_dates set date2_mdy=concat(mid(date2,6,2),'-',mid(date2,9,2),'-',mid(date2,3,2)) where 1 ";
$result=mysqli_query($connection,$query) or die ("Couldn't execute query. $query");

$query="update yearly_dates set date1_day='1' where date1_day='01' ";
$result=mysqli_query($connection,$query) or die ("Couldn't execute query. $query");

$query="update yearly_dates set date1_day='2' where date1_day='02' ";
$result=mysqli_query($connection,$query) or die ("Couldn't execute query. $query");

$query="update yearly_dates set date1_day='3' where date1_day='03' ";
$result=mysqli_query($connection,$query) or die ("Couldn't execute query. $query");

$query="update yearly_dates set date1_day='4' where date1_day='04' ";
$result=mysqli_query($connection,$query) or die ("Couldn't execute query. $query");

$query="update yearly_dates set date1_day='5' where date1_day='05' ";
$result=mysqli_query($connection,$query) or die ("Couldn't execute query. $query");

$query="update yearly_dates set date1_day='6' where date1_day='06' ";
$result=mysqli_query($connection,$query) or die ("Couldn't execute query. $query");

$query="update yearly_dates set date1_day='7' where date1_day='07' ";
$result=mysqli_query($connection,$query) or die ("Couldn't execute query. $query");

$query="update yearly_dates set date1_day='8' where date1_day='08' ";
$result=mysqli_query($connection,$query) or die ("Couldn't execute query. $query");

$query="update yearly_dates set date1_day='9' where date1_day='09' ";
$result=mysqli_query($connection,$query) or die ("Couldn't execute query. $query");


$query="update yearly_dates set header_message=concat(dow1,' ',date1_month,' ',date1_day,',',' ',date1_year) where 1 ";
$result=mysqli_query($connection,$query) or die ("Couldn't execute query. $query");

$query="update yearly_dates set header_message2=concat(dow2,' ',date2_mdy) where 1 ";
$result=mysqli_query($connection,$query) or die ("Couldn't execute query. $query");

$query="update yearly_dates set weekend='y' where (dow1='saturday' or dow1='sunday') ";
$result=mysqli_query($connection,$query) or die ("Couldn't execute query. $query");

$query="insert into mission_headlines(hid,date,header_message,header_message2,header_message2_date,weekend)
        select hid,date1,header_message,header_message2,date2,weekend
		from yearly_dates where 1 ";
$result=mysqli_query($connection,$query) or die ("Couldn't execute query. $query");

echo "<br />Line 150 successful<br />";






?>
