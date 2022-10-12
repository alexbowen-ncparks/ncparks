<?php
session_start();
//echo "<pre>";print_r($_SESSION);echo "</pre>";exit;
$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempid=$_SESSION['budget']['tempID'];
//echo $tempid;
extract($_REQUEST);
//echo "<pre>";print_r($_REQUEST);echo "</pre>";exit;
$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
include("../../../../include/activity.php");// database connection parameters
//$status='complete';

if($status=='')

{

$query30="update budget.project_steps_detail set status='complete' 
          where project_category='$project_category' and project_name='$project_name'
		  and step_group='$step_group' and step_num='$step_num' ";
		  
		  
mysqli_query($connection, $query30) or die ("Couldn't execute query 30.  $query30");

$query31="select * from project_steps_detail
         where project_category='$project_category' and project_name='$project_name'
		 and step_group='$step_group'  and status='pending' "; 

$result31=mysqli_query($connection, $query31) or die ("Couldn't execute query 31.  $query31");

$num31=mysqli_num_rows($result31);

//echo "pending_items=$num4";exit;

//if($num4==0){echo "done"}; if ($num4!=0){echo "$num4 pending items"}; exit;
if($num31==0)

{$query32="update project_steps set status='complete' where project_category='$project_category'
         and project_name='$project_name' and step_group='$step_group' ";
mysqli_query($connection, $query32) or die ("Couldn't execute query 32.  $query32");}
////mysql_close();

{header("location: /budget/sips_bill_upload.php");}

}

if($status=='complete')

{
echo "stepb1.php line 53"; exit;
$query33="select * from project_steps_detail
         where project_category='its' and project_name='sips_phone_bill'
		 and step_group='B'  and step_num='1' "; 

$result33=mysqli_query($connection, $query33) or die ("Couldn't execute query 33.  $query33");

$row33=mysqli_fetch_array($result33);

extract($row33);//brings back max (fiscal_year) as $fiscal_year
/*
echo "project_category=$project_category";echo "<br />";
echo "project_name=$project_name";echo "<br />";
echo "step_group=$step_group";echo "<br />";
echo "step_name=$step_name";echo "<br />";
echo "fiscal_year=$fiscal_year";echo "<br />";
echo "start_date=$start_date";echo "<br />";
echo "end_date=$end_date";echo "<br />";exit;
*/

echo "<H3 ALIGN=left><A href='/budget/admin/sips_phone_bill/step_group.php?project_category=$project_category&project_name=$project_name&step_group=$step_group&step_name=$step_name&fiscal_year=$fiscal_year&start_date=$start_date&end_date=$end_date&report_type=form'>Return to SIPS Phone bill Update </A></H3>";


}

 
 ?>




















