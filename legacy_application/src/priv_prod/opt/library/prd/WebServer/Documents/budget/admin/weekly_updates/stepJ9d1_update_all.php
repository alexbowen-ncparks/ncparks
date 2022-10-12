<?php
ini_set('display_errors',1);
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

//echo "hello line 17<br />";
//echo "fiscal_year=$fiscal_year<br />";
echo "<pre>";print_r($_POST);"</pre>";   exit;

//echo "<pre>"; "</pre>";   //exit;

$fld_array=array_keys($_POST);
//echo "<pre>";print_r($fld_array);"</pre>";  // exit;
$skip=array("id","submit2","fiscal_year","project_category","project_name","start_date","end_date","step_group","step_num","step","step_name");
for($i=0; $i<count($fld_array); $i++)
	{
	$fld=$fld_array[$i];
	if(in_array($fld, $skip)){continue;}
	$query="update bd725_dpr_new_extract SET ";
	foreach($fld_array as $index=>$fld)
		{
		if(in_array($fld, $skip)){continue;}
		$value=$_POST[$fld][$i];
		$query.="`".$fld."`='".mysqli_real_escape_string($value)."', ";
		}
	$query=rtrim($query,", ");
	$query.=" where id='".$_POST['id'][$i]."'";
	//echo "$query<br />";
	
	$result=mysqli_query($connection, $query) or die ("Couldn't execute query.  $query");
	}
	
//exit;

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




















