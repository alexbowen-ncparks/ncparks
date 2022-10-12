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
$query1="update crj_posted1 SET";
for($j=0;$j<$num1;$j++){
$query2=$query1;
	$query2.=" crj_posted1.crj='y'
               where crj_posted1.center='$center[$j]'
  	           and crj_posted1.description_f3='$bd_first3[$j]'
               and crj_posted1.f_year='$fiscal_year' ";
		
//echo "query2=$query2";exit;
$result=mysqli_query($connection, $query2) or die ("Couldn't execute query 2. $query2");
}	

echo "update successful";

/*
{header("location: project1_menu_web.php?comment=y&add_comment=y&folder=community&project_category=&category_selected=y&project_name=&name_selected=y&note_group=&project_note_id=$project_note_id&message=1");}
*/
 
 ?>




















