<?php
//echo "<pre>";print_r($_REQUEST);echo "</pre>";//exit;
session_start();
//echo "<pre>";print_r($_SESSION);echo "</pre>";exit;
$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempid=$_SESSION['budget']['tempID'];
//echo $tempid;
extract($_REQUEST);
echo "<pre>";print_r($_REQUEST);"</pre>";//exit;
$start_date=str_replace("-","",$start_date);
$end_date=str_replace("-","",$end_date);
$today_date=date("Ymd");
echo "start_date=$start_date";
echo "<br />"; 
echo "end_date=$end_date";//exit;
echo "<br />"; 
echo "today_date=$today_date";exit;

include("../../../../include/connectBUDGET.inc");// database connection parameters
//echo "submit1=$submit1";echo "submit2=$submit2";exit;

$query1="";
mysqli_query($connection, $query1) or die ("Couldn't execute query 1. $query1");

$query2="";
mysqli_query($connection, $query2) or die ("Couldn't execute query 2. $query2");

$query3="";
mysqli_query($connection, $query3) or die ("Couldn't execute query 3. $query3");

$query4="";
mysqli_query($connection, $query4) or die ("Couldn't execute query 4. $query4");

$query5="";
mysqli_query($connection, $query5) or die ("Couldn't execute query 5. $query5");

$query6="";
mysqli_query($connection, $query6) or die ("Couldn't execute query 6. $query6");

$query7="";
mysqli_query($connection, $query7) or die ("Couldn't execute query 7. $query7");

$query8="";
mysqli_query($connection, $query8) or die ("Couldn't execute query 8. $query8");

$query9="";
mysqli_query($connection, $query9) or die ("Couldn't execute query 9. $query9");

$query10="";
mysqli_query($connection, $query10) or die ("Couldn't execute query 10. $query10");

$query11="";
mysqli_query($connection, $query11) or die ("Couldn't execute query 11. $query11");

$query12="";
mysqli_query($connection, $query12) or die ("Couldn't execute query 12. $query12");

$query13="";
mysqli_query($connection, $query13) or die ("Couldn't execute query 13. $query13");

$query14="";
mysqli_query($connection, $query14) or die ("Couldn't execute query 14. $query14");

$query15="";
mysqli_query($connection, $query15) or die ("Couldn't execute query 15. $query15");

$query16="";
mysqli_query($connection, $query16) or die ("Couldn't execute query 16. $query16");

$query17="";
mysqli_query($connection, $query17) or die ("Couldn't execute query 17. $query17");

$query18="";
mysqli_query($connection, $query18) or die ("Couldn't execute query 18. $query18");

$query19="";
mysqli_query($connection, $query19) or die ("Couldn't execute query 19. $query19");

$query20="";
mysqli_query($connection, $query20) or die ("Couldn't execute query 20. $query20");

$query23a="update budget.project_steps_detail set status='complete' where project_category='$project_category'
         and project_name='$project_name' and step_group='$step_group' and step_num='$step_num' ";
			 
mysqli_query($connection, $query23a) or die ("Couldn't execute query 23a.  $query23a");

$query24="select * from budget.project_steps_detail
         where project_category='$project_category' and project_name='$project_name'
		 and step_group='$step_group'  and status='pending' "; 

$result24=mysqli_query($connection, $query24) or die ("Couldn't execute query 24.  $query24");

$num24=mysqli_num_rows($result24);

//echo "pending_items=$num4";exit;

//if($num4==0){echo "done"}; if ($num4!=0){echo "$num4 pending items"}; exit;
if($num24==0)

{$query25="update budget.project_steps set status='complete' where project_category='$project_category'
         and project_name='$project_name' and step_group='$step_group' ";
mysqli_query($connection, $query25) or die ("Couldn't execute query 25.  $query25");}
////mysql_close();

if($num24==0)

{header("location: main.php?project_category=$project_category&project_name=$project_name ");}

if($num24!=0)

{header("location: step_group.php?project_category=$project_category&project_name=$project_name&step_group=$step_group&fiscal_year=$fiscal_year&start_date=$start_date&end_date=$end_date");}




?>

























