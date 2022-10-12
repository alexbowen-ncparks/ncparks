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

if($project_category==""){echo "<font color='brown' size='5'>Oops:We did not receive all the Values from your Form<br /><br />Click the BACK button on your Browser to complete Form </font><br />";exit;}
if($project_name==""){echo "<font color='brown' size='5'>Oops:We did not receive all the Values from your Form<br /><br />Click the BACK button on your Browser to complete Form </font><br />";exit;}
if($project_note==""){echo "<font color='brown' size='5'>Oops:We did not receive all the Values from your Form<br /><br />Click the BACK button on your Browser to complete Form </font><br />";exit;}
if($web_address==""){echo "<font color='brown' size='5'>Oops:We did not receive all the Values from your Form<br /><br />Click the BACK button on your Browser to complete Form </font><br />";exit;}



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
$table1="infotrack_projects";
$table2="infotrack_projects_community";


////mysql_connect($host,$username,$password);
@mysql_select_db($database) or die( "Unable to select database");
//echo "hello world";
//if(submit=='Private'){echo "Private";exit;}
//if($submit=="Personal"){echo "Personal";}
//if($submit=="Community"){echo "Community";}



if($submit=='Add_WebPage' and $folder=='personal')

{
$query1="insert ignore into $table1
(user,system_entry_date,project_category,project_name,project_note,weblink,note_group) 
values ('$myusername','$system_entry_date','$project_category','$project_name',
'$project_note','$web_address','web')";

mysqli_query($connection, $query1) or die ("Couldn't execute query 1.  $query");
}

//echo "ok";exit;
$project_note=addslashes($project_note);

if($submit=='Add_WebPage' and $folder=='community')

{


$query2b="insert ignore into $table2
(user,system_entry_date,project_category,project_name,project_note,weblink,embed_address,note_group) 
values ('$myusername','$system_entry_date','$project_category','$project_name',
'$project_note','$web_address','$embed_address','web')";

mysqli_query($connection, $query2b) or die ("Couldn't execute query 2b.  $query2b");
}




// frees the connection to MySQL
//////mysql_close();

//echo "Update Successful";

//echo "<br /><br />";

//echo "<A href=welcome.php>Return HOME </A>";

header("location: project1_menu.php?folder=$folder&project_category=$project_category&category_selected=y&project_name=$project_name&note_group=$note_group&name_selected=y&add_record=y");


?>