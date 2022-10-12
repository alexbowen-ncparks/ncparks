<?php

session_start();

if(!$_SESSION["budget"]["tempID"]){echo "access denied";exit;}


$active_file=$_SERVER['SCRIPT_NAME'];
$active_file_request=$_SERVER['REQUEST_URI'];

$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempID=$_SESSION['budget']['tempID'];
$beacnum=$_SESSION['budget']['beacon_num'];
$playstation=$_SESSION['budget']['select'];
$playstation_center=$_SESSION['budget']['centerSess'];
//$pcode=$_SESSION['budget']['select'];

if($playstation=='ADM'){$playstation='ADMI';}
$scorer=$tempID;


extract($_REQUEST);
//echo "<pre>";print_r($_SERVER);"</pre>";//exit;
//echo "<pre>";print_r($_SESSION);"</pre>";//exit;
//echo "<pre>";print_r($_REQUEST);"</pre>";//exit;
include("../../budget/menu1314.php");
$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database 
$query1="select * from colors where 1 order by color_name";

         
$result1 = mysqli_query($connection, $query1) or die ("Couldn't execute query 1.  $query1");
$num1=mysqli_num_rows($result1);
//$row1=mysqli_fetch_array($result1);
//echo "query1=$query1";exit;
//extract($row1);
//echo "id_label=$id_label";exit;

echo
 "
<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitionalt//EN'
    'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'>
	
<html xmlns='http://www.w3.org/1999/xhtml' lang='en' xml:lang='en'>
  <head>
    <title>MoneyCounts</title>";
//echo "<link rel='stylesheet' type='text/css' href='admin2.css' />";	
include ("admin_colors2.php");   
echo "</head> 
  <body id='admin_colors'>";
  
//echo "color_name2=$color_name2";echo"<br />";//exit;
  
echo "<div id='page' align='center'>";
/*		
 echo "<div id='header'>
		<img width='100%' height='100%' src='nrid_logo.jpg' alt='roaring gap photos'/>
		</div>";
*/		
       echo " <div id='navigation'>
		   <ul id='coolMenu'>

             
             <li><a href='admin_colors.php' id='admin_colors_nav'>Colors</a></li>		
             
			 
            </ul>
		</div>";





//echo "color_name=$color_name";exit;
echo "<table border=1 align='center'>";

//echo "<tr><th>Background Color</th></tr>";
echo "<tr><th bgcolor='$color_name2'>Background Selection:$color_name2</th></tr>";

echo "</table>";
echo "<br />";
//echo "<br />";
//echo "<br />";
//echo "</tr>";
//echo "<div class='column1of4'>";
echo "<table align='center'>";
//echo "<table border=1>";
//echo "<td><font size=5 color=brown class='cartRow'><b>Projects</b></font></td>";
while ($row1=mysqli_fetch_array($result1)){

// The extract function automatically creates individual variables from the array $row
//These individual variables are the names of the fields queried from MySQL
extract($row1);
echo "<tr>";
/*
echo 
"<td bgcolor='$color_name'>

<form method='post' action='admin_colors.php'>
<input type='submit' name='color_name2' value='$color_name' style='background-color:$color_name' 
> </form>

</td>";
*/
echo "<td><form method='post' action='update_preferences.php' align='center'>
<input type='submit' name='bgcolor' value='$color_name' style='background-color:$color_name' 
> </form>";


echo "</tr>";

}

 echo "</table>";

echo "</div>";



//echo "</div>";
echo "</body>";


echo "</html>";

?>











		
        