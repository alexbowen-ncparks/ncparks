<?php
session_start();
if (!$_SESSION["budget"]["tempID"]) {echo "Access denied";exit;}
//echo "<pre>";print_r($_SESSION);echo "</pre>";exit;

/*
if(!isset($tempID)){
header("location: /login_form.php?db=budget");
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

//include("design_template1.html");



$query4="select property.id,property.id_label,property_photos.label,property_photos.comments,
         property_photos.photo_location
         from property_photos
		 left join property on property_photos.id_property=property.id
         where property.id='$id'
         order by property_photos.id desc ";
         

//echo $query4;		 
$result4 = mysqli_query($connection, $query4) or die ("Couldn't execute query 4.  $query4");
$num4=mysqli_num_rows($result4);
/*
echo "<table border=1>";
echo "<tr>";
echo "<td><font size=5 color=brown><b>Photos</b></font></td>";
echo "</tr>";
echo "</table>";
echo "<br />";
echo "<table border=1>";
*/


echo "<br />";

if($submit=='Photos')
{
/*
echo "<table border=1>";
echo "<tr>";
echo "<td><font size=5 color=brown><b>$id_label</b></font></td>";

echo "<td>";

echo "<form method=post autocomplete='off' action=property_photos.php>";
echo "<input type='submit' name='submit' value='Add_Photo'></td>";
echo "<input type='hidden' name='id' value='$id'>";	
echo "<input type='hidden' name='id_label' value='$id_label'>";	
echo "<input type='hidden' name='add_property' value='y'>";	
echo "</form>";	

echo "</td>";

echo "</tr>";
echo "</table>";

}
*/


echo "<table>";
echo "<tr>";
echo "<td><font size=5 color=brown><b>$id_label</b></font></td>";

echo "</tr>";
echo "</table>";

echo "<table border='1'>";
echo "<tr>";
echo "<th><font color='brown'>New Photo Name</font></th>";

echo "<form method='post' action='property_photos.php'>";
     //echo "<td><textarea rows='2' cols='10' name='photo_title'>$photo_title</textarea></td>";
     echo "<td><input type='text' name='photo_label' size='30' value=\"$photo_label\"></td>";  
	 echo "<td><input type='submit' name='add_title' value='Enter'></td>";
	 echo "<td><input type='hidden' name='id_label' value=\"$id_label\"></td>";
	 echo "<input type='hidden' name='id' value='$id'>";	
	 
		 
echo "</form>";

echo "</tr>";
echo "</table>"; 


echo "<br />";
echo "<table border=1>";




while ($row4=mysqli_fetch_array($result4)){


extract($row4);
$countid=number_format($countid,0);
$rank=$rank+1;

if($c==''){$t=" bgcolor='$table_bg2'";$c=1;}else{$t='';$c='';}


echo 

"<tr$t>"; 

echo "<td><img src='$photo_location' height='200' width='400' /></td>"; 
echo "<td>$label</a></td>"; 
	          
echo "</tr>";

}

 echo "</table>";
}

if($add_title=='Enter')
{
/*
echo "<table>";
echo "<tr>";
echo "<td><font size=5 color=brown><b>$id_label</b></font></td>";

echo "</tr>";
echo "</table>";
echo "<table border='1'>";
echo "<tr>";
echo "<td><font size=4 color=brown><b>Photo Name: $photo_label</b></font></td>";

echo "</tr>";
echo "</table>";
*/
echo "<table>";
echo "<tr>";
echo "<td><font size=5 color=brown><b>$id_label</b></font></td>";

echo "</tr>";
echo "</table>";

echo "<table><tr><th><font color='brown'>Photo Name: </font></th>";
echo "<td>$photo_label</td></tr>";
echo "</table>";

echo "<form enctype='multipart/form-data' method='post' action='photo_add2.php'>";
echo "<input type='hidden' name='MAX_FILE_SIZE' value='50000000'>";
echo "<input type='file' id='document' name='document'>";
echo "<input type='hidden' name='id' value='$id'>";
echo "<input type='hidden' name='id_label' value=\"$id_label\">";
echo "<input type='hidden' name='photo_label' value=\"$photo_label\">";
echo "<br /> <br />";
echo "<input type='submit' value='add_photo' name='submit'>";
echo "</form>";
//echo "</table>";
}

/*
echo "<br />";
if($add_record=='y' and $note_group=='photo' and $add_title=='')
{
echo "<table>";
echo "<tr><th><font color='brown'>Photo Description</font></th></tr>";



echo "<form method=post action=photo_galleries.php>";
echo "<td><input type='text' name='photo_title' value='$photo_title'></textarea></td>";      
	  echo "<input type='hidden' name='project_category' value='$project_category'>";	   
	 echo "<input type='hidden' name='project_name' value='$project_name'>";	   
	 echo "<input type='hidden' name='note_group' value='$note_group'>";	   
	 echo "<input type='hidden' name='folder' value='$folder'>";	
	 echo "<input type='hidden' name='category_selected' value='y'>";	
	 echo "<input type='hidden' name='name_selected' value='y'>";	
	 echo "<input type='hidden' name='add_record' value='y'>";	
	 echo "<input type='hidden' name='add_title' value='y'>";
	 echo "<td><input type=submit name=submit value=Enter></td>";
	 echo "</form>";
echo "</tr>";
echo "</table>";     
}
if($add_record=='y' and $note_group=='photo' and $add_title=='y')
{
echo "<table><tr><th><font color='brown'>Photo Description: </font></th>";
echo "<td>$photo_title</td></tr>";
echo "</table>";

echo "<form enctype='multipart/form-data' method='post' action='photo_add2.php'>";
echo "<input type='hidden' name='MAX_FILE_SIZE' value='50000000'>";
echo "<input type='file' id='document' name='document'>";
echo "<input type='hidden' name='photo_title' value='$photo_title'>";
echo "<input type='hidden' name='project_category' value='$project_category'>";
echo "<input type='hidden' name='project_name' value='$project_name'>";
echo "<input type='hidden' name='note_group' value='$note_group'>";	   
echo "<input type='hidden' name='folder' value='$folder'>";	
echo "<br /> <br />";
echo "<input type='submit' value='add_photo' name='submit'>";
echo "</form>";
echo "</table>";

}

*/

  
 

 
 ?>
 