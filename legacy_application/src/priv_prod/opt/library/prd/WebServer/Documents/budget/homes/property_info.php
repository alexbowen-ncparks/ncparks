<?php
session_start();
if (!$_SESSION["budget"]["tempID"]) {echo "Access denied";exit;}
//echo "<pre>";print_r($_SESSION);echo "</pre>";exit;

/*
if(!isset($tempID)){
header("location: https://legacypriv36.dev.dpr.ncparks.gov/login_form.php?db=budget");
}
*/
//echo "<pre>";print_r($_SESSION);echo "</pre>";exit;
?>




<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitionalt//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
	
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
  <head>
    <title>Roaring Gap Homes</title>
    <link rel="stylesheet" type="text/css" href="admin2.css" />
  </head> 	
<body id="admin_properties">
        <div id="page">
		
        <div id="header">
		<img width="100%" height="100%" src="nrid_logo.jpg" alt="roaring gap photos"/>
		</div>
  
		
        <div id="navigation">
		   <ul id="coolMenu">

             <li><a href="home.php" id="home_nav">Home</a></li>
             <li><a href="admin_properties.php" id="admin_properties_nav">Properties</a></li>		
             <li><a href="admin_colors.php" id="admin_colors_nav">Colors</a></li>		
             <li><a href="infotrack/projects_menu.php?folder=community&add_record=y" id="admin_project_tracker_nav">Project Tracker</a></li>		
            </ul>
		</div>

<?php


extract($_REQUEST);
//echo "<pre>";print_r($_SERVER);"</pre>";//exit;
//echo "<pre>";print_r($_SESSION);"</pre>";//exit;
//echo "<pre>";print_r($_REQUEST);"</pre>";//exit;
/*
$lot_acreage=str_replace(",","",$lot_acreage);
$home_sf=str_replace(",","",$home_sf);
$heated_sf=str_replace(",","",$heated_sf);
$list_price=str_replace(",","",$list_price);
$list_price=str_replace("$","",$list_price);
*/

$active_file=$_SERVER['SCRIPT_NAME'];
$active_file_request=$_SERVER['REQUEST_URI'];

$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempID=$_SESSION['budget']['tempID'];
$beacnum=$_SESSION['budget']['beacon_num'];
$infotrack_location=$_SESSION['budget']['select'];
$infotrack_center=$_SESSION['budget']['centerSess'];
$pcode=$_SESSION['budget']['select'];


$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database 
//echo "f_year=$f_year";


if($submit=='Info'){


$query1="select * from property where 1 and `id`='$id' ";
         
$result1 = mysqli_query($connection, $query1) or die ("Couldn't execute query 1.  $query1");
$num1=mysqli_num_rows($result1);
$row1=mysqli_fetch_array($result1);
extract($row1);

//include("design_template1.html");
echo "<html>";
echo "<head>";
echo "<title>Edit Record</title>";
echo "</head>";
//echo "<body bgcolor='#FFF8DC'>";
echo "<body>";
echo "<H1 ALIGN=LEFT > <font color=brown><i>$id_label</i> </font></H1>";
//echo "<H1 ALIGN=LEFT > <font color='red'><i>Add Record</i></font></H1>";
//echo "<H3 ALIGN=CENTER > <A href=main.php> Return HOME </A></H3>";
//echo "<H1 ALIGN=CENTER > <font color='red'>Duplicate project_note_id=$project_note_id</font></H1>";

echo "<br/>";

echo "<form method='post' action='property_info.php'>";
echo "<table border=1>";

echo "<table border=1>";
       //echo "<form name='form1' method='post' action='duplicate_notes_insert.php'>";
	   echo "<tr><th><font color='blue'>Field</font></th><th>Value</th></tr>";
	   echo "<tr><td><font color='blue' >Property Name</td></font><td><input type='text' name='id_label' size='50' value=\"$id_label\"></td></tr>";
	   echo "<tr><td><font color='blue'>Comments</td></font><td><textarea name='comments' cols='30' rows='5'>$comments</textarea></td></tr>";
	   echo "<tr><td><font color='blue' >Lot Acreage</td></font><td><input type='text' name='lot_acreage' size='50' value=\"$lot_acreage\"></td></tr>";
	   echo "<tr><td><font color='blue' >Home square feet</td></font><td><input type='text' name='home_sf' size='50' value=\"$home_sf\"></td></tr>";
	   echo "<tr><td><font color='blue' >Heated square feet</td></font><td><input type='text' name='heated_sf' size='50' value=\"$heated_sf\"></td></tr>";
	   echo "<tr><td><font color='blue' >BedRooms</td></font><td><input type='text' name='bedrooms' size='50' value=\"$bedrooms\"></td></tr>";
	   echo "<tr><td><font color='blue' >Baths Full</td></font><td><input type='text' name='baths_full' size='50' value=\"$baths_full\"></td></tr>";
	   echo "<tr><td><font color='blue' >Baths Half</td></font><td><input type='text' name='baths_half' size='50' value=\"$baths_half\"></td></tr>";
	   echo "<tr><td><font color='blue' >Address Line1</td></font><td><input type='text' name='address1' size='50' value=\"$address1\"></td></tr>";
	   echo "<tr><td><font color='blue' >Address Line2</td></font><td><input type='text' name='address2' size='50' value=\"$address2\"></td></tr>";
	   echo "<tr><td><font color='blue' >City</td></font><td><input type='text' name='city' size='50' value=\"$city\"></td></tr>";
	   echo "<tr><td><font color='blue' >County</td></font><td><input type='text' name='county' size='50' value=\"$county\"></td></tr>";
	   echo "<tr><td><font color='blue' >State</td></font><td><input type='text' name='state' size='50' value=\"$state\"></td></tr>";
	   echo "<tr><td><font color='blue' >ZipCode</td></font><td><input type='text' name='zip' size='50' value=\"$zip\"></td></tr>";
	   echo "<tr><td><font color='blue' >List Price</td></font><td><input type='text' name='list_price' size='50' value=\"$list_price\"></td></tr>";
	   
	   	   echo "</table>";

//echo "<br /> <br />";
echo "<input type='hidden' name='id' value='$id'>";
echo "<input type='submit' name='submit' value='Update'>";

echo "</form>";

echo "</body>";
echo "</html>";



}


if($submit=='Update')

{

$query2="update property 
 set `id_label`='$id_label',
     `comments`='$comments',
     `lot_acreage`='$lot_acreage',
     `home_sf`='$home_sf',
     `heated_sf`='$heated_sf',
     `bedrooms`='$bedrooms',
     `baths_full`='$baths_full',
     `baths_half`='$baths_half',
     `address1`='$adress1',
     `address2`='$address2',
     `city`='$city',
     `county`='$county',
     `state`='$state',
     `zip`='$zip',
     `list_price`='$list_price' 
	  where `id`='$id' ";

mysqli_query($connection, $query2) or die ("Couldn't execute query 2.  $query2");
header("location: property_menu.php");
}
//echo "query2=$query2";


 ?>



