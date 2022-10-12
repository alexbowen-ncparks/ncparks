<?php

session_start();
$myusername=$_SESSION['myusername'];

if(!isset($myusername)){
header("location:index.php");
}
$system_entry_date=date("Ymd");
extract($_REQUEST);
//echo "<pre>";print_r($_REQUEST);"</pre>";exit;
//echo $system_entry_date;exit;
//print_r($_SESSION);echo "</pre>";exit;

if($project_category==""){echo "<font color='red' size='5'>Error Message:</font> <font color='blue'>Form is missing Values. Please enter Values for all Form boxes</font><br />Click the BACK button on your Browser to return to the Form";exit;}
if($project_name==""){echo "<font color='red' size='5'>Error Message:</font> <font color='blue'>Form is missing Values. Please enter Values for all Form boxes</font><br />Click the BACK button on your Browser to return to the Form";exit;}
if($project_note==""){echo "<font color='red' size='5'>Error Message:</font> <font color='blue'>Form is missing Values. Please enter Values for all Form boxes</font><br />Click the BACK button on your Browser to return to the Form";exit;}
//if($web_address==""){echo "<font color='red' size='5'>Error Message:</font> <font color='blue'>Form is missing Values. Please enter Values for all Form boxes</font><br />Click the BACK button on your Browser to return to the Form";exit;}



//$date=$_POST['date'];
//$project_category=$_POST['project_category'];
//$project_name=$_POST['project_name'];
//$project_note=$_POST['project_note'];
//$weblink=$_POST['weblink'];
$date=date("Ymd");
//$project_start_date=$_POST['project_start_date'];
//$project_end_date=$_POST['project_end_date'];
//$project_status=$_POST['project_status'];


include("../../include/connect.php");
$database="mamajone_cookiejar";
$table1="project_notes";
$table2="project_notes_community";


////mysql_connect($host,$username,$password);
@mysql_select_db($database) or die( "Unable to select database");
//echo "hello world";
//if(submit=='Private'){echo "Private";exit;}
//if($submit=="Personal"){echo "Personal";}
//if($submit=="Community"){echo "Community";}



if($submit=="Personal")

{
$query1="insert ignore into $table1
(user,system_entry_date,project_category,project_name,project_note,weblink) 
values ('$myusername','$system_entry_date','$project_category','$project_name',
'$project_note','$web_address')";

mysqli_query($connection, $query1) or die ("Couldn't execute query 1.  $query");
}

//echo "ok";exit;
if($submit=="Community")

{
$query2="insert ignore into $table2
(user,system_entry_date,project_category,project_name,project_note,weblink) 
values ('$myusername','$system_entry_date','$project_category','$project_name',
'$project_note','$web_address')";

mysqli_query($connection, $query2) or die ("Couldn't execute query 2.  $query2");
}




// frees the connection to MySQL
//////mysql_close();

//echo "Update Successful";

//echo "<br /><br />";

//echo "<A href=welcome.php>Return HOME </A>";

header("location: note_add.php?&project_category=$project_category&project_name=$project_name&add_your_own=y&message=Update Successful");


?>
