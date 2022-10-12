<?php

session_start();

if(!$_SESSION["budget"]["tempID"]){echo "access denied";exit;
//header("location: https://legacypriv36.dev.dpr.ncparks.gov/login_form.php?db=budget");
}

$tempID=$_SESSION['budget']['tempID'];

$system_entry_date=date("Ymd");


extract($_REQUEST);

//echo "<pre>";print_r($_SERVER);"</pre>";//exit;
//echo "<pre>";print_r($_SESSION);"</pre>";//exit;
//echo "<pre>";print_r($_REQUEST);"</pre>";exit;
//exit;

if($project_category==""){echo "<font color='brown' size='5'>Oops:We did not receive all the Values from your Form<br /><br /> Click the BACK button on your Browser to complete Form</font><br />";exit;}
if($project_name==""){echo "<font color='brown' size='5'>Oops:We did not receive all the Values from your Form<br /><br /> Click the BACK button on your Browser to complete Form</font><br />";exit;}
//if($project_note==""){echo "<font color='brown' size='5'>Oops:We did not receive all the Values from your Form<br /><br /> Click the BACK button on your Browser to return to the Form</font><br />";exit;}
//if($web_address==""){echo "<font color='brown' size='5'>Oops:We did not receive all the Values from your Form<br /><br /> Click the BACK button on your Browser to return to the Form</font><br />";exit;}


$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters

mysqli_select_db($connection, $database); // database 



//$project_category = stripslashes($project_category);
$query4="insert into infotrack_projects_community3(user,system_entry_date,project_category,project_name,note_group)
         values('$tempID','$system_entry_date','$project_category','$project_name','project')";
		 
$result4 = mysqli_query($connection, $query4) or die ("Couldn't execute query 4.  $query4");



//echo $project_name;exit;

//$urlencode="$folder&project_category=$project_category&category_selected=y&project_name=$project_name&name_selected=y";

//header("location: project1_menu.php?folder=$urlencode");

header("location: project1_menu.php?folder=community&project_category=$project_category&category_selected=y&project_name=$project_name&name_selected=y&note_group=web&add_record=y");
?>



















	














