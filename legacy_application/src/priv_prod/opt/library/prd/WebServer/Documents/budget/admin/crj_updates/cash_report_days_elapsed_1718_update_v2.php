<?php

session_start();

//echo "<pre>";print_r($_REQUEST);echo "</pre>"; exit;
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
include("../../../../include/activity.php");// database connection parameters
//echo "submit1=$submit1";echo "submit2=$submit2";exit;
//echo "<pre>";print_r($_REQUEST);"</pre>"; exit;
//echo "fiscal_year=$fiscal_year";exit;
/*
$query2="SELECT count( hid )-1 as 'days_elapsed'
FROM `mission_headlines`
WHERE 1
AND date >= '$deposit_date'
AND date <= '$manager_date'
AND weekend = 'n'";
*/
$today=date("Ymd", time() );

$query0="truncate table cash_report_days_elapsed1;";
		 

mysqli_query($connection, $query0) or die ("Couldn't execute query 0.  $query0");


$query1a="insert into cash_report_days_elapsed1
(park,center,deposit_id,deposit_date,manager_date,manager)
select park,center,orms_deposit_id,orms_deposit_date,manager_date,manager
from crs_tdrr_division_deposits
where download_date >= '20140702' and trans_table='y'
and f_year='1718' ; ";
			 
mysqli_query($connection, $query1a) or die ("Couldn't execute query 1a.  $query1a");



$query1c="update cash_report_days_elapsed1
          set today_date='$today'
		  where 1";
			 
mysqli_query($connection, $query1c) or die ("Couldn't execute query 1c.  $query1c");


$query1c1="update cash_report_days_elapsed1
          set manager_date2=manager_date
		  where manager_date != '0000-00-00' ";
			 
mysqli_query($connection, $query1c1) or die ("Couldn't execute query 1c1.  $query1c1");

$query1c2="update cash_report_days_elapsed1
          set manager_date2=today_date
		  where manager_date = '0000-00-00' ";
			 
mysqli_query($connection, $query1c2) or die ("Couldn't execute query 1c2.  $query1c2");




$query1="select count(id) as 'total_records' from cash_report_days_elapsed1 where 1";
$result1 = mysqli_query($connection, $query1) or die ("Couldn't execute query 1.  $query1");
$row1=mysqli_fetch_array($result1);
extract($row1);//brings back max (end_date) as $end_date
echo "<br />total_records=$total_records<br />";



for($j=1;$j<=$total_records;$j++){

$query2="select deposit_date,manager_date2 from cash_report_days_elapsed1 where id = '$j' ";
$result2 = mysqli_query($connection, $query2) or die ("Couldn't execute query 2.  $query2");
$row2=mysqli_fetch_array($result2);
extract($row2);         
              
$query3="SELECT count( hid )-1 as 'days_elapsed'
         FROM `mission_headlines`
         WHERE date >= '$deposit_date' and date <= '$manager_date2'
         and weekend='n' ";

$result3 = mysqli_query($connection, $query3) or die ("Couldn't execute query 3.  $query3");
$row3=mysqli_fetch_array($result3);
extract($row3);    		 
		 
$query3a="update cash_report_days_elapsed1
          set days_elapsed='$days_elapsed'
		  where id = '$j' ";

//echo "<br />Line 56: query3a=$query3a<br />";
$result3a = mysqli_query($connection, $query3a) or die ("Couldn't execute query 3a.  $query3a");
		  
		 
}	

//echo "Line 54 exit"; exit;



$query4="update crs_tdrr_division_deposits,cash_report_days_elapsed1
         set crs_tdrr_division_deposits.crj_days_elapsed=cash_report_days_elapsed1.days_elapsed
		 where crs_tdrr_division_deposits.orms_deposit_id=cash_report_days_elapsed1.deposit_id
		 and crs_tdrr_division_deposits.f_year='1718'
		 ";
			 
mysqli_query($connection, $query4) or die ("Couldn't execute query 4.  $query4");

//825 records updated for query4


$query4a1="update crs_tdrr_division_deposits
          set crj_compliance='y'
          where crj_elapsed_override='y' 
          and download_date >= '20140702' 
          and f_year='1718'
           ";
			 
mysqli_query($connection, $query4a1) or die ("Couldn't execute query 4a1.  $query4a1");






$query4a="update crs_tdrr_division_deposits
          set crj_compliance='n'
          where crj_days_elapsed >= '4' 
          and download_date >= '20140702' 
          and f_year='1718'
          and crj_elapsed_override='n'  ";
			 
mysqli_query($connection, $query4a) or die ("Couldn't execute query 4a.  $query4a");


$query5="truncate table cash_report_days_elapsed2;";
		 
			 
mysqli_query($connection, $query5) or die ("Couldn't execute query 5.  $query5");


$query6="insert into cash_report_days_elapsed2(playstation,complete)
         SELECT park,count(id)  FROM `crs_tdrr_division_deposits` WHERE 1  and crj_compliance='y'
		 and trans_table='y'
		 and version3_active='y'
		 and f_year='1718'
		 group by park order by park ";
		 
			 
mysqli_query($connection, $query6) or die ("Couldn't execute query 6.  $query6");


//33 records updated

$query7="insert into cash_report_days_elapsed2(playstation,total)
         SELECT park,count(id)  FROM `crs_tdrr_division_deposits` WHERE 1 and download_date >= '20140702' and trans_table='y'
		 and version3_active='y'
		 and f_year='1718'
		 group by park order by park ";
		 
			 
mysqli_query($connection, $query7) or die ("Couldn't execute query 7.  $query7");

// 33 records updated


$query8="truncate table cash_report_days_elapsed3;";
		 
			 
mysqli_query($connection, $query8) or die ("Couldn't execute query 8.  $query8");


$query9="insert into cash_report_days_elapsed3(playstation,complete,total)
         select playstation,sum(complete),sum(total)
		 from cash_report_days_elapsed2
		 where 1
		 group by playstation; ";
		 
			 
mysqli_query($connection, $query9) or die ("Couldn't execute query 9.  $query9");

// 33 records updated


$query10="update mission_scores,cash_report_days_elapsed3
          set mission_scores.complete=cash_report_days_elapsed3.complete,
          mission_scores.total=cash_report_days_elapsed3.total
		  where mission_scores.playstation=cash_report_days_elapsed3.playstation
		  and mission_scores.gid='11' and mission_scores.fyear='1718' ";
		 
			 
mysqli_query($connection, $query10) or die ("Couldn't execute query 10.  $query10");

// 33 records updated

$query11="update mission_scores
set percomp=complete/total*100
where gid = '11' and fyear='1718' 
and total >= '1' ";



$result11=mysqli_query($connection, $query11) or die ("Couldn't execute query11. $query11");

// 34 records updated


$query25="update project_steps_detail set status='complete' where project_category='fms'
         and project_name='daily_updates' and step_group='C' and step_num='4a'  ";
mysqli_query($connection, $query25) or die ("Couldn't execute query 25.  $query25");



//header("location: /budget/infotrack/position_reports.php?menu=1&report_id=285");
header("location: /budget/admin/daily_updates/step_group.php?project_category=fms&project_name=daily_updates&step_group=C ");


 
 ?>