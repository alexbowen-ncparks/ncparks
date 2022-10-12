<?php

session_start();

if(!$_SESSION["budget"]["tempID"]){echo "access denied";exit;
//header("location: /login_form.php?db=budget");
}

//$file = "articles_menu.php";
//$lines = count(file($file));


//$table="infotrack_projects";
//echo "<pre>";print_r($_REQUEST);"</pre>";//exit;

$active_file=$_SERVER['SCRIPT_NAME'];
$active_file_request=$_SERVER['REQUEST_URI'];

$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempID=$_SESSION['budget']['tempID'];
$beacnum=$_SESSION['budget']['beacon_num'];
$infotrack_location=$_SESSION['budget']['select'];
$infotrack_center=$_SESSION['budget']['centerSess'];
$pcode=$_SESSION['budget']['select'];

$tempID2=substr($tempID,0,-2);

//echo "tempID2=$tempID2";

//echo "beacnum=$beacnum";

//echo "<pre>";print_r($_SERVER);"</pre>";

//echo "active_file=$active_file<br />";
//echo "active_file_request=$active_file_request<br />";


extract($_REQUEST);
//echo "<pre>";print_r($_SERVER);"</pre>";//exit;
//if($level=='5' and $tempID !='Dodd3454')
//echo "pcode=$pcode";
//echo "<pre>";print_r($_SESSION);"</pre>";//exit;
//echo "<pre>";print_r($_REQUEST);"</pre>";//exit;


//include("../../../include/connectBUDGET.inc");// database connection parameters
//include("../../../include/activity.php");// database connection parameters
//include("../budget/~f_year.php");
//include("../../budget/~f_year.php");
$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database 
//echo "f_year=$f_year";

$query1="SELECT body_bgcolor,table_bgcolor,table_bgcolor2
from infotrack_customformat
WHERE 1 and user_id='$tempID'
";

$result1=mysqli_query($connection, $query1) or die ("Couldn't execute query 1. $query1");

$row1=mysqli_fetch_array($result1);

extract($row1);

$body_bg=$body_bgcolor;
$table_bg=$table_bgcolor;
$table_bg2=$table_bgcolor2;

$query1="SELECT filegroup,report_name
from infotrack_filegroup
WHERE 1 and filename='$active_file'
";

$result1=mysqli_query($connection, $query1) or die ("Couldn't execute query 11. $query11");

$row1=mysqli_fetch_array($result1);

extract($row1);


$query2="select report_id,report_name,report_location,sed,status_ok,new_tab,dpr,download_available,description
         from gaming_links where 1 order by report_name ";
		 
echo "query2=$query2<br />";		 
		 
$result2=mysqli_query($connection, $query2) or die ("Couldn't execute query 2. $query2");		 
		 
$num2=mysqli_num_rows($result2);		 
		 
		 
//echo "beacnum=$beacnum";
echo"
<html>
<head>
<title>MC Gaming</title>";
echo "</head>";
//include("../../budget/menu1314_procedures.php");
include("../../budget/menu1314.php");
include("menu_add_records1.php");
echo "<table border='1'>";
echo "<tr><th>report_name</th><th>report_id</th></tr>";



while ($row2=mysqli_fetch_array($result2)){
extract($row2);


if($table_bg2==''){$table_bg2='cornsilk';}
if($color==''){$t=" bgcolor='$table_bg2' ";$color=1;}else{$t='';$color='';}

echo "<tr$t  align='left'>";
echo "<td><a href='$report_location' title='$description' target='_blank'>$report_name</a></td>";
echo "<td>$report_id</td>";
echo "</tr>";
}

echo "</table>"; 
 echo "</body>";
 echo "</html>";
 
 
 ?>
 