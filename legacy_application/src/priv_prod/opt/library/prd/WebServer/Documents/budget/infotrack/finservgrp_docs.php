<?php

/*   *** INCLUDE file inventory ***
include("/opt/library/prd/WebServer/include/iConnect.inc")
include("../../../include/activity.php")
include ("../../budget/menu1415_v1.php")
*/
session_start();

if(!$_SESSION["budget"]["tempID"]){echo "access denied";exit;
//header("location: /login_form.php?db=budget");
}

//$file = "articles_menu.php";
//$lines = count(file($file));


//$table="infotrack_projects";
//echo "<pre>";print_r($_REQUEST);"</pre>"; exit;
//echo "<pre>";print_r($_SESSION);"</pre>"; exit;

$active_file=$_SERVER['SCRIPT_NAME'];
$active_file_request=$_SERVER['REQUEST_URI'];

$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempID=$_SESSION['budget']['tempID'];
$beacnum=$_SESSION['budget']['beacon_num'];
$infotrack_location=$_SESSION['budget']['select'];
$infotrack_center=$_SESSION['budget']['centerSess'];
$pcode=$_SESSION['budget']['select'];
$fs_group=$_SESSION['budget']['fs_group'];
$fs_mgr=$_SESSION['budget']['fs_mgr'];

$tempID2=substr($tempID,0,-2);
//if($tempID2=='Kno'){$tempID2='Knott';}


extract($_REQUEST);

echo "fs_group=$fs_group<br />";
echo "fs_mgr=$fs_mgr<br />";
echo "mc_module=$mc_module<br />";


//echo "<pre>";print_r($_SERVER);"</pre>";//exit;
//echo "<pre>";print_r($_SESSION);"</pre>";//exit;

$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters

mysqli_select_db($connection, $database); // database 


$query1="SELECT name as 'module_name' from mc_modules where id='$mc_module' ";
$result1=mysqli_query($connection, $query1) or die ("Couldn't execute query 1. $query1");
$row1=mysqli_fetch_array($result1);
extract($row1);

echo "Line 81: module_name=$module_name";

if($edit=='y')
{
	
$query2="SELECT report_name as 'report_nameF' from budget.position_report where report_id=$repid ";
echo "<br />query2=$query2<br />";
$result2=mysqli_query($connection, $query2) or die ("Couldn't execute query 2. $query2");
$row2=mysqli_fetch_array($result2);
extract($row2);	
	
echo "<br />report_nameF=$report_nameF<br />";	
	
}

//$module_name="cash_and_check";
//echo "beacnum=$beacnum";


echo"
<html>
<head>
<title>MC Procedures</title>";
echo "</head>";

include ("../../budget/menu1415_v1.php");


echo "<table align='center'>";
echo "<tr><th><br />Financial Services Group</th></tr>";

echo "<tr><th>Help Documents: $module_name</th></tr>";

echo "</table>";

echo "<br /><br />";
echo "<table align='center'>";

echo "<tr><th>Document Name</th><th></th><th></th></tr>";

echo "<tr>";
//FORM to ADD a New Position Report
echo "<form enctype='multipart/form-data' method='post' autocomplete='off' action='finservgrp_docs_add.php'>";	
echo "<td><input type='text' name='report_nameF' size='30' value='$report_nameF'></td>";
echo "<td><input type='file' id='document' name='document'><input type='hidden' name='content_mode' value='$content_mode' /><input type='hidden' name='MAX_FILE_SIZE' value='2000000'></td>"; 
echo "<th><input type=submit name=record_insert submit value=add></th>";
echo "<input type='hidden' name='edit' value='$edit'>";
echo "<input type='hidden' name='report_id' value='$repid'>";
echo "<input type='hidden' name='mc_module' value='$mc_module'>";
echo "</form>";
echo "</tr>";

echo "</table>";

//}

echo "<br />";

$query4="SELECT report_id,report_name,report_location,fs_user,fs_user_date FROM position_report where fs_group='y' and mc_module=$mc_module and active='y' order by report_name";
		 
echo "query4=$query4<br /><br />";
	 
$result4 = mysqli_query($connection, $query4) or die ("Couldn't execute query 4.  $query4");
$num4=mysqli_num_rows($result4);
//echo "<br />";
//echo "<table><tr><td><font size='4' color='red'>$num4 Reports</font></td></tr></table>";
echo "<table align='center'><tr>";
//echo "<th><img height='50' width='50' src='/budget/infotrack/icon_photos/reports1.png' alt='reports icon' title='MyReports'></img><br />Help Links<br />$module_name</th>";
//echo "<img height='75' width='125' src='credit_card2.jpg' alt='picture of credit card'></img><br />Procurement Card</th>";
echo "<td><font color=brown class='cartRow'></font></td>";
if($num<2){echo "<td><font size='4' color='red'>$num4 Document</font></td>";} else {echo "<td><font size='4' color='red'>$num4 Documents</font></td>";}

echo "</tr>";

echo "</table>";

echo "<br />";
echo "<table border='1' align='center'>";
echo "<tr><th>Document Name</th><th>ID</th></tr>";

while ($row4=mysqli_fetch_array($result4)){


extract($row4);

//if($status_ok=="n"){$status_message="<font color='red'>(pending)</font>";} else {$status_message="";}

//if($c==''){$t=" bgcolor='$table_bg2'";$c=1;}else{$t='';$c='';}
if($table_bg2==''){$table_bg2='cornsilk';}
if($color==''){$t=" bgcolor='$table_bg2' ";$color=1;}else{$t='';$color='';}


echo "<tr$t>";
echo "<td><a href='$report_location' title='$description' target='_blank'>$report_name</a><br /><br />$fs_user ($fs_user_date)</td>";
echo "<td><font color='brown'><a href='finservgrp_docs.php?mc_module=$mc_module&edit=y&repid=$report_id'>$report_id</a></font></td>"; 
echo "</tr>";

}

 echo "</table>";
 echo "</body>";
 //echo "hello";
 echo "</html>";
 
 
 ?>