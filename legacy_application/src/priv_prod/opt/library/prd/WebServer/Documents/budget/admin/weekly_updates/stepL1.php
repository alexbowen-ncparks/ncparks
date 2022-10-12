<?php

//echo "<pre>";print_r($_REQUEST);echo "</pre>";exit;
session_start();
$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempid=$_SESSION['budget']['tempID'];
extract($_REQUEST);
//echo "hello world";exit;
//echo "<pre>";print_r($_SESSION); echo "</pre>"; //exit;
//echo "<pre>";print_r($_REQUEST); echo "</pre>"; //exit;

$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
include("../../../../include/activity.php");// database connection parameters
//if($submit1=="Update")



$query1="select max(report_date) as 'max_date' from pcard_report_dates where active='y' " ;
$result1 = mysqli_query($connection, $query1) or die ("Couldn't execute query 1.  $query1");
$row1=mysqli_fetch_array($result1);
extract($row1);
$max_date=str_replace("-","",$max_date);

//echo "max_date=$max_date"; //exit;


$query2="select report_date,xtnd_start,xtnd_end from pcard_report_dates where report_date='$max_date' "  ;
$result2 = mysqli_query($connection, $query2) or die ("Couldn't execute query 2.  $query2");
$row2=mysqli_fetch_array($result2);
extract($row2);
//echo "start_date=$start_date";exit;
// The variable $result is a PHP resource containing the results of the MySQL query. Its contents can only be used by PHP.


echo "<html>";
echo "<head>
<style>
body { background-color: #FFF8DC; }
table { background-color: white; font-color: blue; font-size: 15;}
TH{font-family: Arial; font-size: 15pt;}
TD{font-family: Arial; font-size: 15pt;}

</style>
	


</head>";



//echo "<H3 ALIGN=CENTER > <A href=welcome.php> Return HOME </A></H3>";
echo "<H1 ALIGN=LEFT > <font color=brown><i>$project_name-StepGroup $step_group-$step</font></i></H1>";
echo "<H3 ALIGN=LEFT > <font color=blue>StepName-$step_name</font></H1>";
echo "<H2 ALIGN=center><font size=4><b><A href=/budget/admin/weekly_updates/main.php?project_category=fms&project_name=weekly_updates> Return Weekly Updates-HOME </A></font></H2>";
echo "<H2 ALIGN=center>"; 
echo "</H3>";

echo "<br />";

echo
"<form method=post action=stepL1_update.php>";

echo "<table border=1>";
       echo "<tr><th><font color='blue'>WEEK</font></th><th><font color='blue'>XTND Start</font></th><th><font color='blue'>XTND End</font></th><th><font color='blue'>Report Date</font></th>";
	   echo "<tr><td>PriorWeek</td><td><font color='blue'><input name='xtnd_start' type='text' readonly='readonly' id='xtnd_start' value='$xtnd_start'></font></td><td><input name='xtnd_end' type='text' readonly='readonly' id='xtnd_end' value='$xtnd_end'></td><td><input name='report_date' type='text' readonly='readonly' id='report_date' value='$report_date'></td></tr>";
       echo "<tr><td>CurrentWeek</td><td><font color='blue'><input name='xtnd_start_new' type='text' id='xtnd_start_new'></font></td><td><input name='xtnd_end_new' type='text' id='xtnd_end_new'></td><td><input name='report_date_new' type='text' id='report_date_new'></td><td><input type='submit' name='submit2' value='UPDATE'></td></tr>";
	  echo "</table>";
	   echo "</form>";

echo "</html>";


//if($submit2=="Update")

 /* { 
 
 $query3="insert into budget.pcard_report_dates(xtnd_start,xtnd_end,report_date)
         values ('$xtnd_start_new','$xtnd_end_new','$report_date_new')" ;
			 
mysqli_query($connection, $query3) or die ("Couldn't execute query 3.  $query3");

 }
 
 


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

{header("location: step_group.php?project_category=$project_category&project_name=$project_name
      &step_group=$step_group&step_name=$step_name&fiscal_year=$fiscal_year&start_date=$start_date
	  &end_date=$end_date");}

*/
 
?>

























