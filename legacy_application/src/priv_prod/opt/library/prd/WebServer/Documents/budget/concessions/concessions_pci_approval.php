<?php

//echo "<pre>";print_r($_REQUEST);echo "</pre>"; //exit;
session_start();
if(!$_SESSION["budget"]["tempID"]){echo "access denied";exit;}

//echo "<pre>";print_r($_SESSION);echo "</pre>"; exit;
$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempid=$_SESSION['budget']['tempID'];
//echo $tempid;
extract($_REQUEST);
$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
include("../../../include/activity.php");// database connection parameters
//echo "submit1=$submit1";echo "submit2=$submit2";exit;
//echo "<pre>";print_r($_REQUEST);"</pre>"; exit;
$system_entry_date=date("Ymd");



if($role=='manager')

{


if($manager_approved==""){echo "<font color='brown' size='5'><b>Manager Approval Missing. <br /><br />Click back button on Browser. Then Click the Approval Checkbox. Thanks!</b></font>";exit;}




$query8="update concessions_pci_compliance
      	 set manager='$tempid',manager_date='$system_entry_date'
		 where park='$parkcode' and cash_month_calyear='$cash_month_calyear' and cash_month='$cash_month' 	
          ";
		  
	  
$result8=mysqli_query($connection, $query8) or die ("Couldn't execute query 8. $query8");	  
	

	
$query8a="select manager_date from concessions_pci_compliance
          where park='$parkcode' and cash_month_calyear='$cash_month_calyear' and cash_month='$cash_month' 	
          ";
		 
//echo "query8a=$query8a<br />";		 

$result8a = mysqli_query($connection, $query8a) or die ("Couldn't execute query 8a.  $query8a");

$row8a=mysqli_fetch_array($result8a);
extract($row8a);	
	

		  
$query9="select score from cash_imprest_count_scoring
         where fyear='$fyear' and cash_month='$cash_month' and start_date <= '$manager_date'
		 and end_date >= '$manager_date' ";
		 
		 
//echo "query9=$query9<br />";		 

$result9 = mysqli_query($connection, $query9) or die ("Couldn't execute query 9.  $query9");


$row9=mysqli_fetch_array($result9);
extract($row9);
		  
//echo "manager_date=$manager_date<br />";	

if($score==''){$score='50';}
if($fyear=='1617' and $cash_month=='april'){$score='100.00';} 
if($fyear=='1617' and $cash_month=='may'){$score='100.00';} 
//cho "score=$score<br />";	   
if($manager_approved=='y' and $cash_month_calyear=='2015' and $cash_month=='june'){$score='100';}	  
		  
$query10="update concessions_pci_compliance
         set score='$score' 
		 where park='$parkcode' and cash_month_calyear='$cash_month_calyear' and cash_month='$cash_month' 	
          ";
		 
//echo "query10=$query10<br />";		 

$result10 = mysqli_query($connection, $query10) or die ("Couldn't execute query 10.  $query10");		  
		  
//exit;	



$query11 = "SELECT sum(score)/count(id) as 'mission_score'
from concessions_pci_compliance
WHERE 1
and fyear='$fyear'
and valid='y'
and park='$parkcode' ";


//echo "query11=$query11<br />"; //exit;

$result11 = mysqli_query($connection, $query11) or die ("Couldn't execute query 11.  $query11");


$row11=mysqli_fetch_array($result11);
extract($row11);

echo "mission_score=$mission_score<br />";  //exit;


$query12="update mission_scores
          set percomp='$mission_score'
		  where playstation='$parkcode' and gid='16' and fyear='$fyear' ";
		  
		  
		  
echo "query12=$query12<br />"; //exit;	


$result12=mysqli_query($connection, $query12) or die ("Couldn't execute query12. $query12");

/*
$query13="update mission_scores,center
          set mission_scores.percomp='0.00'
		  where mission_scores.playstation=center.parkcode
		  and center.fund='1280'
		  and center.fuel_tank='n'		  
		  and mission_scores.gid='13'
		  and mission_scores.fyear='$fyear'
		  ";
	*/	  
	

$query13="update mission_scores
set percomp='.01'
where playstation='$parkcode' and gid = '16' and fyear='$fyear' and percomp='0.00'  ";


echo "query13=$query13<br />";



$result13=mysqli_query($connection, $query13) or die ("Couldn't execute query13. $query13");


	
}

header("location: concessions_pci_report.php?menu=pci&fyear=$fyear");

 
 ?>




















