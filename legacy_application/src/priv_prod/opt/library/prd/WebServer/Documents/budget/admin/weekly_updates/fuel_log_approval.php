<?php

//echo "<pre>";print_r($_REQUEST);echo "</pre>";exit;
session_start();
if(!$_SESSION["budget"]["tempID"]){echo "access denied";exit;}

//echo "<pre>";print_r($_SESSION);echo "</pre>"; //exit;
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


if($role=='cashier')

{

if($cashier_approved==""){echo "<font color='brown' size='5'><b>Cashier Approval Missing. <br /><br />Click back button on Browser. Then Click the Approval Checkbox. Thanks!</b></font>";exit;}

$query8="update fuel_tank_usage
      	 set cashier='$tempid',cashier_date='$system_entry_date'
		 where park='$parkcode' and cash_month_calyear='$cash_month_calyear' and cash_month='$cash_month'   ";
		  
		  
		  
$result8=mysqli_query($connection, $query8) or die ("Couldn't execute query 8. $query8");		  
		  
		  
		  
		  
}


if($role=='manager')

{


if($manager_approved==""){echo "<font color='brown' size='5'><b>Manager Approval Missing. <br /><br />Click back button on Browser. Then Click the Approval Checkbox. Thanks!</b></font>";exit;}


$system_entry_date='20150701';
//$system_entry_date='20150710';
//$system_entry_date='20150715';
//$system_entry_date='20150720';
//$system_entry_date='20150725';
//$system_entry_date='20150731';
//$system_entry_date='20150801';


$query8="update fuel_tank_usage
      	 set manager='$tempid',manager_date='$system_entry_date'
		 where park='$parkcode' and cash_month_calyear='$cash_month_calyear' and cash_month='$cash_month' 	
          ";
		  
	  
$result8=mysqli_query($connection, $query8) or die ("Couldn't execute query 8. $query8");	  
	

	
$query8a="select manager_date from fuel_tank_usage
          where park='$parkcode' and cash_month_calyear='$cash_month_calyear' and cash_month='$cash_month' 	
          ";
		 
echo "query8a=$query8a<br />";		 

$result8a = mysqli_query($connection, $query8a) or die ("Couldn't execute query 8a.  $query8a");

$row8a=mysqli_fetch_array($result8a);
extract($row8a);	
	
echo "manager_date=$manager_date<br />";	
	
		

//$manager_date='20150701';	

//$manager_date='20150710';	

//$manager_date='20150715';	

//$manager_date='20150720';	


//$manager_date='20150725';

	
//$manager_date='20150731';


	
//$manager_date='20150801';	




		  
$query9="select score from cash_imprest_count_scoring
         where fyear='$fyear' and cash_month='$cash_month' and start_date2 <= '$manager_date'
		 and end_date2 >= '$manager_date' ";
		 
		 
echo "query9=$query9<br />";		 

$result9 = mysqli_query($connection, $query9) or die ("Couldn't execute query 9.  $query9");


$row9=mysqli_fetch_array($result9);
extract($row9);
		  
echo "manager_date=$manager_date<br />";	

if($score==''){$score='50';}
  
echo "score=$score<br />";	 exit;	  
		  
		  
		  
		  
		  
}


		  
		  
//echo "query8=$query8<br />"; exit;

		  





//header("location: page2_form.php?parkcode=$parkcode&cash_month=$cash_month&fyear=$fyear&cash_month_calyear=$cash_month_calyear&fyear=$fyear&step=3");
header("location: page1.php");


 
 ?>




















