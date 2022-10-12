<?php

//echo "<pre>";print_r($_REQUEST);echo "</pre>";//exit;
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
//echo "submit1=$submit1";echo "submit2=$submit2";exit;
//echo "<pre>";print_r($_REQUEST);"</pre>";exit;


//First occurrence of Page

if($submit1=="Update")

{

echo "<html>";
echo "<head>
<style>
body { background-color: #FFF8DC; }
table { background-color: #FFF8DC; font-color: blue; font-size: 15;}
TH{font-family: Arial; font-size: 15pt;}
TD{font-family: Arial; font-size: 15pt;}
input{style=font-family: Arial; font-size:14.0pt}
</style>
</head>";

echo "<H1 ALIGN=LEFT > <font color=brown><i>$project_name-Set Dates</i> </font></H1>";
echo "<H2 ALIGN=center><font size=4><b><A href=/budget/admin/fixed_asset_updates/step_group.php?project_category=fms&project_name=fixed_asset_updates&step_group=M> Return Fixed Asset Updates-HOME </A></font></H2>";
echo "<br />";
echo
"<form method=post autocomplete='off' action=stepM1.php>";
echo "<font size=5>"; 
echo "fiscal_year:<input name='fiscal_year' type='text' size='12' id=fiscal_year value='$fiscal_year'>";
echo "<br />";
echo "start_date:&nbsp<input name='start_date' type='text' size='12' id=start_date value='$start_date'>";
echo "<br />";
echo "end_date:&nbsp&nbsp&nbsp<input name='end_date' type='text' size='12' id=end_date value='$end_date'>";
echo "<input type='hidden' name='project_category' value='$project_category'>";	
echo "<input type='hidden' name='project_name' value='$project_name'>";	
echo "<input type='hidden' name='step_group' value='$step_group'>";	   
echo "<input type='hidden' name='step_num' value='$step_num'>";	

//echo "<br />";
//echo "complete:&nbsp&nbsp&nbsp<input name='complete' type='text' size='12' id=complete_date value='$complete'>";


echo "<br /><br />";

echo "&emsp";
echo "<input type=submit name=submit2 value=Update>";

echo "</form>";



echo "</html>";}
 
 //Second occurrence of Page
 if($submit2=="Update")
 
 {//update weekly_updates_steps for date fields and status field
 
$query1="update project_steps set fiscal_year='$fiscal_year',start_date='$start_date',
         end_date='$end_date',status='pending' where 1 and project_category='$project_category'
		 and project_name='$project_name' ";

echo "query1=$query1<br /><br />"; //exit;		 

mysqli_query($connection, $query1) or die ("Couldn't execute query 1.  $query1");

//update weekly_updates_steps for status field (set status field for step_group=a to complete)
//$query2="update weekly_updates_steps set status='complete' where step_group='A'"; 

//mysqli_query($connection, $query2) or die ("Couldn't execute query 2.  $query2");

//update weekly_updates_steps for date fields and status field
$query2="update project_steps_detail set fiscal_year='$fiscal_year',start_date='$start_date',
         end_date='$end_date',status='pending' where 1 and project_category='$project_category'
		 and project_name='$project_name' "; 
		 
//echo "query2=$query2<br /><br />"; exit;			 

mysqli_query($connection, $query2) or die ("Couldn't execute query 2.  $query2");



$query2a="update project_substeps_detail set fiscal_year='$fiscal_year',start_date='$start_date',
         end_date='$end_date',status='pending' where 1 and project_category='$project_category'
		 and project_name='$project_name' "; 

mysqli_query($connection, $query2a) or die ("Couldn't execute query 2a.  $query2a");

$start_date=str_replace("-","",$start_date);
$end_date=str_replace("-","",$end_date);
$today_date=date("Ymd");
/*
$query3="insert ignore into budget.pcard_report_dates(xtnd_start,xtnd_end,report_date)
         values('$start_date','$end_date','$end_date')";
mysqli_query($connection, $query3) or die ("Couldn't execute query 3. $query3");
*/



//echo "step_group=$step_group and step_num=$step_num";exit;
/* $query3="update project_steps_detail set status='complete' 
        where project_category='$project_category' and project_name='$project_name'
		and step_group= '$step_group' and step_num= '$step_num' "; 

mysqli_query($connection, $query3) or die ("Couldn't execute query 3.  $query3");

$query4="select * from project_steps_detail
         where project_category='$project_category' and project_name='$project_name'
		 and step_group='$step_group'  and status='pending' "; 

$result4=mysqli_query($connection, $query4) or die ("Couldn't execute query 4.  $query4");

$num4=mysqli_num_rows($result4);

//echo "pending_items=$num4";exit;

//if($num4==0){echo "done"}; if ($num4!=0){echo "$num4 pending items"}; exit;
if($num4==0)

{$query5="update project_steps set status='complete' where project_category='$project_category'
         and project_name='$project_name' and step_group='$step_group' ";
mysqli_query($connection, $query5) or die ("Couldn't execute query 5.  $query5");}

if($num4==0)

{header("location: main.php?project_category=$project_category&project_name=$project_name ");}

if($num4!=0)
*/

$query23a="update budget.project_steps_detail set status='complete' where project_category='$project_category'
         and project_name='$project_name' and step_group='$step_group' and step_num='$step_num' ";
			 
mysqli_query($connection, $query23a) or die ("Couldn't execute query 23a.  $query23a");


{header("location: step_group.php?project_category=$project_category&project_name=$project_name&step_group=$step_group&fiscal_year=$fiscal_year&start_date=$start_date&end_date=$end_date");}
}
 
 
 ?>




















