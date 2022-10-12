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
//echo "<pre>";print_r($_REQUEST);"</pre>";exit;
//echo "fiscal_year=$fiscal_year";exit;




for($j=0;$j<$num1e;$j++){
$query2=$query1;
	     
              
$query3="update crs_tdrr_division_deposits 
         set manual_yn='y',
		 manual_count='$manual_count[$j]',
		 manual_amount='$manual_amount[$j]'
         where orms_deposit_id='$crs_deposit_id[$j]'
         and f_year='$f_year[$j]' ";	

echo "query3=$query3<br /><br />";		 
		 
$result3 = mysqli_query($connection, $query3) or die ("Couldn't execute query 3.  $query3");
		 
//echo "query2=$query2";exit;
//$result=mysqli_query($connection, $query2) or die ("Couldn't execute query 2. $query2");
}	



echo "update successful";

 
 ?>




















