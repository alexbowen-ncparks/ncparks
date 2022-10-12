<?php
session_start();
if (!$_SESSION["budget"]["tempID"]) {echo "Access denied";exit;}
//echo "<pre>";print_r($_SESSION);echo "</pre>";exit;

/*
if(!isset($tempID)){
header("location: https://10.35.152.9/login_form.php?db=budget");
}
*/
//echo "<pre>";print_r($_SESSION);echo "</pre>";exit;
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitionalt//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
	
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
  <head>
    <title>Roaring Gap Homes</title>
    <link rel="stylesheet" type="text/css" href="home.css" />
  </head> 	
<body id="admin_properties">
        <div id="page">
		
        <div id="header">
		<a href="/budget/home.php">
		<img width="100%" height="100%" src="nrid_logo.jpg" alt="roaring gap photos"/></img>
		</a>
		</div>
  
<div id="centeredmenu">
	<ul>
		<li><a href="admin_properties.php">Admin</a>
			<ul>
				<li><a href="admin_properties.php">Properties</a></li>
				<li><a href="admin_content.php">Content</a></li>
				<li><a href="#">Link three</a></li>
				<li><a href="#">Link four</a></li>
				<li><a href="#">Link five</a></li>
			</ul>
		</li>
<!--		<li class="active"><a href="#" class="active">Tab two</a>-->
		<li><a href="#" class="active">Tab two</a>
			<ul>
				<li><a href="#">Link one</a></li>
				<li><a href="#">Link two</a></li>
				<li><a href="#">Link three</a></li>
				<li><a href="#">Link four</a></li>
				<li><a href="#">Link five is a long link that wraps</a></li>
			</ul>
		</li>
		<li><a href="#">Long tab three</a>
			<ul>
				<li><a href="#">Link one</a></li>
				<li><a href="#">Link two</a></li>
				<li><a href="#">Link three</a></li>
				<li><a href="#">Link four</a></li>
				<li><a href="#">Link five</a></li>
			</ul>
		</li>
		<li><a href="#">Tab four</a>
			<ul>
				<li><a href="#">Link one</a></li>
				<li><a href="#">Link two</a></li>
				<li><a href="#">Link three</a></li>
				<li><a href="#">Link four</a></li>
				<li><a href="#">Link five</a></li>
			</ul>
		</li>
		
	</ul>	
		
</div>		
        

<?php

extract($_REQUEST);

//echo "<pre>";print_r($_SERVER);"</pre>";//exit;
//echo "<pre>";print_r($_SESSION);"</pre>";//exit;
//echo "<pre>";print_r($_REQUEST);"</pre>";exit;
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


$query1="select distinct id,id_label from property where 1 order by id";
         
$result1 = mysqli_query($connection, $query1) or die ("Couldn't execute query 1.  $query1");
$num1=mysqli_num_rows($result1);
echo "<h1 align='left' font color='brown'>Admin Properties</h1>";
if($add_property!='y')
{
echo "<table border=1>";
echo "<tr>";
//echo "<td><font size=5 color=brown><b>Properties</b></font></td>";
echo "<td>";
echo "<form method=post autocomplete='off' action=property_menu.php>";

//echo "<td align='center'><font color='brown' size='5' class=cartRow>$project_category</font>";
//echo "<input name='property_label' type='text' size='75' id='property_label'>";

echo "<input type='submit' name='submit' value='Add_Property'></td>";
echo "</tr>";	
echo "<input type='hidden' name='folder' value='folder'>";	
echo "<input type='hidden' name='add_property' value='y'>";	

	  		 
      // echo "<tr><th>Weblink</th><td><textarea name= 'weblink' rows='1' cols='40'></textarea></td></tr>";
	  // echo "<tr><td colspan='4' align='center'><input type='submit' value='UPDATE'></td></tr>";
echo "</form>";	
echo "</td>";
echo "</tr>";
echo "</table>";
//echo "</table>";

$query1="select distinct id,id_label from property where 1 order by id";
         
$result1 = mysqli_query($connection, $query1) or die ("Couldn't execute query 1.  $query1");
$num1=mysqli_num_rows($result1);

/*
echo "<form method=post autocomplete='off' action=property_add.php>";

//echo "<td align='center'><font color='brown' size='5' class=cartRow>$project_category</font>";
//echo "<input name='property_label' type='text' size='75' id='property_label'>";

echo "<input type='submit' name='submit' value='Add_Property'></td>";
echo "</tr>";	
echo "<input type='hidden' name='folder' value='folder'>";	

	  		 
      // echo "<tr><th>Weblink</th><td><textarea name= 'weblink' rows='1' cols='40'></textarea></td></tr>";
	  // echo "<tr><td colspan='4' align='center'><input type='submit' value='UPDATE'></td></tr>";
echo "</form>";	

 echo "</table>";
*/
echo "<br />";
echo "<table border=1>";
//echo "<br />";
//echo "<br />";
//echo "</tr>";


//echo "<table border=1>";
//echo "<td><font size=5 color=brown class='cartRow'><b>Projects</b></font></td>";
while ($row1=mysqli_fetch_array($result1)){

// The extract function automatically creates individual variables from the array $row
//These individual variables are the names of the fields queried from MySQL
extract($row1);

//$countid=number_format($countid,0);
//$rank=$rank+1;



//if($c==''){$t=" bgcolor='$table_bg2'";$c=1;}else{$t='';$c='';}


//echo "<table border=1>";

//echo "<tr$t>"; 
echo "<tr>"; 
  //echo "<td>$rank</td>";   
  //echo "<td><font size='5'><a href='photos_menu.php'>$id</a></font></td>"; 
  echo "<td><font size='5' color='brown'><b>$id_label</b></font></td>";
  echo " <td>
				  <form method='post' action='property_info.php'>
				  <input type='hidden' name='id' value='$id'> 
				  <input type='submit' name='submit' value='Info'>
				  </form>
				  
          </td>";
		  
	echo " <td>
				  <form method='post' action='property_photos.php'>
				  <input type='hidden' name='id' value='$id'> 
				  <input type='hidden' name='id_label' value='$id_label'> 
				  <input type='submit' name='submit' value='Photos'>
				  </form>
				  
          </td>";	

	echo " <td>
				  <form method='post' action='property_documents.php'>
				  <input type='hidden' name='id' value='$id'> 
				  <input type='submit' name='submit' value='Documents'>
				  </form>
				  
          </td>";		  
		
		 
	          
echo "</tr>";

}

 echo "</table>";
}
if($add_property=='y')
{
echo "<table border=1>";
echo "<tr>";
echo "<td><font size=5 color=brown><b>New Property Form</b></font></td>";
echo "</td>";
echo "</tr>";
echo "</table>";
echo "<br />";
echo "<form name='form1' method='post' action='add_property.php'>";

echo "<font color=blue size=5>";



//echo  "user:<input name='user' type='text' id=user value=\"$user\">";
//echo "<br />system_entry_date:<input name='system_entry_date' type='text' id=system_entry_date value=\"$system_entry_date\">";
//echo "<br />Category:<input name='project_category' type='text' id=project_category size=50 value=\"$project_category\">";
//echo "<br />Topic:<input name='project_name' type='text' id=project_name size=50 value=\"$project_name\">";

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
//echo "<input type='hidden' name='cid' value='$cid'>";
echo "<input type='submit' name='submit'
value='Add_Property'>";

echo "</form>";
}
echo "</div>";
echo "</body>";


echo "</html>";

?>











		
        