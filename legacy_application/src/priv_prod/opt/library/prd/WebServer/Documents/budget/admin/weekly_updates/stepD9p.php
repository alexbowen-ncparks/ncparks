<?php

//echo "<pre>";print_r($_REQUEST);echo "</pre>";//exit;
session_start();
//echo "<pre>";print_r($_SESSION);echo "</pre>";//exit;
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
//echo "<pre>";print_r($_REQUEST);"</pre>";//exit;


////mysql_connect($host,$username,$password);
@mysql_select_db($database) or die( "Unable to select database");

/*
echo "<font color='blue'><b>Tom SCRIPT to upload XTND FileData to Database Tables</b></font>";
echo "<h2>Big Picture. I click 1 button & http://www.dpr.ncparks.gov/budget/admin/weekly_updates/stepD9p.php runs and all my Tables are populated without me individually selecting txt files from c:/xtnd_downloads/</h2>";
echo "Notes:<ul><li>See TABLE=xtnd_data_upload for Source Location and Destination Table for txt files</li>
<ul><li>The source_folder is always: c:\xtnd_downloads\  (whether my computer or someone elses)</li>
<li>The source_file is the same name as the destination table with .txt extension</li>
<li>The destination_table is the Table Name. Contents to Table will already be truncated prior to stepD9p.php</li>
</ul></ul>
Tom: Currently when I upload these text files to database using PHPmyAdmin, I make the following modifications prior to Uploading File:<ul><li>format of imported file=CSV</li><li>Fields terminated by \ t</li><li>Fields enclosed by: BLANK (No value)</li><li>Fields escaped by: \ </li></ul>
<p>Ideally: This once I click on this Step, this PHP file will run this script which updates ALL destination_tables from TABLE=xtnd_data_upload WITHOUT me doing anything</p> Thanks and call with questions, Tony";
exit;
*/



$query9="update project_steps_detail set status='complete' 
        where project_category='$project_category' and project_name='$project_name'
		and step_group= '$step_group' and step_num= '$step_num' "; 

mysqli_query($connection, $query9) or die ("Couldn't execute query 9.  $query9");

$query10="select * from project_steps_detail
         where project_category='$project_category' and project_name='$project_name'
		 and step_group='$step_group'  and status='pending' "; 

$result10=mysqli_query($connection, $query10) or die ("Couldn't execute query 10.  $query10");

$num10=mysqli_num_rows($result10);

//echo "pending_items=$num4";exit;

//if($num4==0){echo "done"}; if ($num4!=0){echo "$num4 pending items"}; exit;
if($num10==0)

{$query11="update project_steps set status='complete',time_complete=unix_timestamp(now()) where project_category='$project_category' and project_name='$project_name' and step_group='$step_group' ";
		 
mysqli_query($connection, $query11) or die ("Couldn't execute query 11.  $query11");
}

if($num10==0)

{header("location: main.php?project_category=$project_category&project_name=$project_name ");}

if($num10!=0)

{header("location: step_group.php?project_category=$project_category&project_name=$project_name&step_group=$step_group&fiscal_year=$fiscal_year&start_date=$start_date&end_date=$end_date");}

 
 ?>




















