<?php

//echo "<pre>";print_r($_REQUEST);echo "</pre>";exit;
session_start();
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
echo "<pre>";print_r($_REQUEST);"</pre>"; exit;
//echo "fiscal_year=$fiscal_year";exit;
/*
$query2="SELECT count( hid )-1 as 'days_elapsed'
FROM `mission_headlines`
WHERE 1
AND date >= '$deposit_date'
AND date <= '$manager_date'
AND weekend = 'n'";
*/

$query1="SELECT count( hid )-1 as 'days_elapsed'
FROM `mission_headlines`
WHERE 1
";
for($j=0;$j<$num1e;$j++){
$query2=$query1;
	$query2.=" and date >= '$deposit_date[$j]'
	           and date <= '$manager_date2[$j]'
			   and weekend='n'";
     $result2 = mysqli_query($connection, $query2) or die ("Couldn't execute query 2.  $query2");

     $row2=mysqli_fetch_array($result2);
     extract($row2);         
              
$query3="update cash_report_days_elapsed1 
         set days_elapsed='$days_elapsed'
         where id='$id[$j]'	";	

//echo "query3=$query3";		 
		 
$result3 = mysqli_query($connection, $query3) or die ("Couldn't execute query 3.  $query3");
		 
//echo "query2=$query2";exit;
//$result=mysqli_query($connection, $query2) or die ("Couldn't execute query 2. $query2");
}	

//echo "Line 54 exit"; exit;



$query4="update crs_tdrr_division_deposits,cash_report_days_elapsed1
         set crs_tdrr_division_deposits.crj_days_elapsed=cash_report_days_elapsed1.days_elapsed
		 where crs_tdrr_division_deposits.orms_deposit_id=cash_report_days_elapsed1.deposit_id
		 ";
			 
mysqli_query($connection, $query4) or die ("Couldn't execute query 4.  $query4");

//825 records updated for query4


$query4a="update crs_tdrr_division_deposits
          set crj_compliance='n'
          where crj_days_elapsed >= '4' 
          and download_date >= '20140702' 
          and f_year='1516'
          and crj_elapsed_override='n'  ";
			 
mysqli_query($connection, $query4a) or die ("Couldn't execute query 4a.  $query4a");


//161 records updated for query4a


/*
$query4b="update crs_tdrr_division_deposits
          set crj_compliance='y'
          where orms_deposit_date >= '20150911' and orms_deposit_date <= '20151009'		  
          ";
			 
mysqli_query($connection, $query4b) or die ("Couldn't execute query 4b.  $query4b");

*/

// 46 records updated for query4b

/*
$query4c="update crs_tdrr_division_deposits
          set crj_elapsed_override='y'
          where f_year='1516'
          and (crj_days_elapsed='3' or crj_days_elapsed='4')		  
          ";
			 
mysqli_query($connection, $query4c) or die ("Couldn't execute query 4c.  $query4c");
*/


/*
$query4c1="update crs_tdrr_division_deposits
          set crj_elapsed_override='y'
          where orms_deposit_date >= '20150911' and orms_deposit_date <= '20151009'	
          ";
			 
mysqli_query($connection, $query4c1) or die ("Couldn't execute query 4c1.  $query4c1");

*/


/*


$query4d="update crs_tdrr_division_deposits
          set crj_compliance='y'
          where crj_elapsed_override='y'
          and f_year='1516'
          ";
			 
mysqli_query($connection, $query4d) or die ("Couldn't execute query 4d.  $query4d");

*/

$query5="truncate table cash_report_days_elapsed2;";
		 
			 
mysqli_query($connection, $query5) or die ("Couldn't execute query 5.  $query5");


$query6="insert into cash_report_days_elapsed2(playstation,complete)
         SELECT park,count(id)  FROM `crs_tdrr_division_deposits` WHERE 1  and crj_compliance='y'
		 and trans_table='y'
		 and version3_active='y'
		 and f_year='1516'
		 group by park order by park ";
		 
			 
mysqli_query($connection, $query6) or die ("Couldn't execute query 6.  $query6");


//33 records updated

$query7="insert into cash_report_days_elapsed2(playstation,total)
         SELECT park,count(id)  FROM `crs_tdrr_division_deposits` WHERE 1 and download_date >= '20140702' and trans_table='y'
		 and version3_active='y'
		 and f_year='1516'
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
		  and mission_scores.gid='11' and mission_scores.fyear='1516' ";
		 
			 
mysqli_query($connection, $query10) or die ("Couldn't execute query 10.  $query10");

// 33 records updated

$query11="update mission_scores
set percomp=complete/total*100
where gid = '11' and fyear='1516'  ";



$result11=mysqli_query($connection, $query11) or die ("Couldn't execute query11. $query11");

// 34 records updated


header("location: /budget/infotrack/position_reports.php?menu=1&report_id=244");







//echo "update successful";
//and crj_posted1_v2.f_year='$fiscal_year'
/*
{header("location: project1_menu_web.php?comment=y&add_comment=y&folder=community&project_category=&category_selected=y&project_name=&name_selected=y&note_group=&project_note_id=$project_note_id&message=1");}
*/
 
 ?>




















