<?php

session_start();

$active_file=$_SERVER['SCRIPT_NAME'];

$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempid=$_SESSION['budget']['tempID'];
$beacnum=$_SESSION['budget']['beacon_num'];
$concession_location=$_SESSION['budget']['select'];
$concession_center=$_SESSION['budget']['centerSess'];
$concession_center_L3=substr($concession_center,-3);
$first_fyear_deposit=$concession_center_L3.'001';
//echo "concession_center_L3=$concession_center_L3<br />";//exit;
//echo "first_fyear_deposit=$first_fyear_deposit";//exit;
//echo "<br />concession_location=$concession_location<br />";
//echo "<br />tempid=$tempid<br />";


extract($_REQUEST);
/*
if($beacnum=='60033160')
{	
echo "<pre>";print_r($_SESSION);"</pre>";//exit;
echo "<pre>";print_r($_REQUEST);"</pre>";  exit;
}
*/

if($cashier_submit != '' and $cashier_approved==''){echo "<font color='brown' font size='6'>Cashier Checkbox not checked. Please click Checkbox. Click Back Button on Browser to return to Form</font>"; exit;}
if($manager_submit != '' and $manager_approved==''){echo "<font color='brown' font size='6'>Manager Checkbox not checked. Please click Checkbox. Click Back Button on Browser to return to Form</font>"; exit;}

//echo "<br />Line 29<br />"; exit;







/*

$rc_total=array_sum($rc_amount);
*/


$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
include("../../../../include/activity.php");// database connection parameters


//echo "record_count=$record_count<br />";//exit;
//echo "parkcode=$parkcode<br />";
if($cashier_approved=='y')
{

$system_entry_date=date("Ymd");
$cashier=$tempid;

//query 4 Changed on 6/7/18
/*
$query4="update wex_vehicle_compliance
         set cashier='$cashier',cashier_date='$system_entry_date',cashier_comment='$cashier_comment'
		 where park='$concession_location' and wex_month='$wex_month' and wex_month_calyear='$wex_month_calyear' ";
*/		 

$query4="update wex_vehicle_compliance
         set cashier='$cashier',cashier_date='$system_entry_date',cashier_comment='$cashier_comment'
		 where park='$parkcode' and wex_month='$wex_month' and wex_month_calyear='$wex_month_calyear' ";



		 
$result4 = mysqli_query($connection, $query4) or die ("Couldn't execute query 4.  $query4");		 
		 
echo "query4=$query4<br />";		 
}



if($manager_approved=='y')
{
$system_entry_date=date("Ymd");
$manager=$tempid;


$query4="update wex_vehicle_compliance
         set manager='$manager',manager_date='$system_entry_date',manager_comment='$manager_comment'
		 where park='$parkcode' and wex_month='$wex_month' and wex_month_calyear='$wex_month_calyear' ";
		 
//echo "query4=$query4<br />"; exit;		 
		 
$result4 = mysqli_query($connection, $query4) or die ("Couldn't execute query 4.  $query4");	

$query4a="select manager_date from wex_vehicle_compliance
         where park='$parkcode' and wex_fyear='$wex_fyear' and wex_month='$wex_month'  ";
		 
		 
echo "query4a=$query4a<br />"; //exit;				 

$result4a = mysqli_query($connection, $query4a) or die ("Couldn't execute query 4a.  $query4a");


$row4a=mysqli_fetch_array($result4a);
extract($row4a);       




$query7="select score from cash_imprest_count_scoring
         where fyear='$wex_fyear' and cash_month='$wex_month' and start_date3 <= '$manager_date'
		 and end_date3 >= '$manager_date' ";
		 
		 
//echo "query7=$query7<br />"; exit;				 

$result7 = mysqli_query($connection, $query7) or die ("Couldn't execute query 7.  $query7");


$row7=mysqli_fetch_array($result7);
extract($row7);

if($score==''){$score='50.00';}

$query8="update wex_vehicle_compliance
         set score='$score'
         where park='$parkcode' and wex_fyear='$wex_fyear' and wex_month='$wex_month' and wex_month_calyear='$wex_month_calyear' ";
		 
		 
$result8 = mysqli_query($connection, $query8) or die ("Couldn't execute query 8.  $query8");		


$query8="update wex_vehicle_compliance
         set score='100'
         where park='$parkcode' and wex_fyear='1718' and wex_month='january' and wex_month_calyear='2018' ";
		 
		 
$result8 = mysqli_query($connection, $query8) or die ("Couldn't execute query 8.  $query8");	





$query8a = "SELECT sum(score)/count(id) as 'mission_score'
from wex_vehicle_compliance
WHERE 1
and wex_fyear='$wex_fyear'
and valid='y'
and park='$parkcode' ";

$result8a = mysqli_query($connection, $query8a) or die ("Couldn't execute query 8a.  $query8a");


$row8a=mysqli_fetch_array($result8a);
extract($row8a);




$query9="update mission_scores
         set percomp='$mission_score'
         where playstation='$parkcode' and gid='18'
         and fyear='$wex_fyear'	 ";
		 
		 
$result9 = mysqli_query($connection, $query9) or die ("Couldn't execute query 9.  $query9");



$query10="update mission_scores
         set percomp='.01'
		 where gid='18'
		 and percomp='0.00'
         and fyear='$wex_fyear' ";
		 
		 
$result10 = mysqli_query($connection, $query10) or die ("Couldn't execute query 10.  $query10");

//echo "query8=$query8<br />";

//echo "update successful<br />";

}


{header("location: wex_compliance.php?fyear=$wex_fyear ");}



?>