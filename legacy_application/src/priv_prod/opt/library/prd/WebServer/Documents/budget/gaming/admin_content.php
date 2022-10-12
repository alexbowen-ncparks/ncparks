<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitionalt//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
	
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
  <head>
    <title>Roaring Gap Homes</title>
    <link rel="stylesheet" type="text/css" href="admin2.css" />
  </head> 	
<body id="admin_content">
        <div id="page">
		
        <div id="header">
		<img width="100%" height="100%" src="nrid_logo.jpg" alt="roaring gap photos"/>
		</div>
  
		
        <div id="navigation">
		   <ul id="coolMenu">

             <li><a href="home.php" id="home_nav">Home</a></li>
             <li><a href="admin_properties.php" id="admin_properties_nav">Properties</a></li>		
             <li><a href="admin_content.php" id="admin_content_nav">Content</a></li>		
             <li><a href="admin_colors.php" id="admin_colors_nav">Colors</a></li>		
             <li><a href="infotrack/projects_menu.php?folder=community&project_category=roaring_gap.net&category_selected=y&add_record=y" id="admin_project_tracker_nav">Web Search</a></li>		
             <li><a href="infotrack/projects_menu2.php?folder=community" id="admin_project_tracker2_nav">Web Search2</a></li>		
            </ul>
		</div>

<?php
session_start();
$myusername=$_SESSION['myusername'];
$active_file=$_SERVER['SCRIPT_NAME'];
if(!isset($myusername)){
header("location: http://roaringgap.net/login.php");
}
extract($_REQUEST);

//echo "<pre>";print_r($_SERVER);"</pre>";//exit;
//echo "<pre>";print_r($_SESSION);"</pre>";//exit;
//echo "<pre>";print_r($_REQUEST);"</pre>";exit;
include("../include/connect.php");

$db_name="mamajone_roaring"; // Database name
//$tbl_name="propertyinfotrack_projects_community"; // Table name

// Connect to server and select databse.
////mysql_connect("$host", "$username", "$password")or die("cannot connect");
mysql_select_db("$db_name")or die("cannot select DB");

//$query1="select distinct id,id_label from property where 1 order by id";
         
//$result1 = mysqli_query($connection, $query1) or die ("Couldn't execute query 1.  $query1");
//$num1=mysqli_num_rows($result1);


if($content_mode==''){$content_mode='add_file';}

if($content_mode=='add_file'){$add_file="class='cartRow'";}
if($content_mode=='add_link'){$add_link="class='cartRow'";}
if($content_mode=='view'){$view="class='cartRow'";}

//echo "content_mode=$content_mode";echo "<br />";
//echo "highlight_add=$highlight_add";echo "<br />";
//echo "highlight_view=$highlight_view";echo "<br />";

echo "<table border='1'>
<tr>
<th><font $add_file><a href='admin_content.php?content_mode=add_file'>Add <br />File</a></font></th>
<th><font $add_link><a href='admin_content.php?content_mode=add_link'>Add <br />Link</a></font></th>
<th><font $view><a href='admin_content.php?content_mode=view'>View</a></th>
</tr>
</table>";

if($content_mode=='add_file')
{
//echo "<h2>Add Content</h2>";
echo "
<table border='1'>

<tr><th>Category</th><th>Type</th>
<th>Description<font color='red'> 5 Word limit</font></th>
<th>Locate File</th>
<th>Upload File</th></tr>

<tr>

<td>
<form enctype='multipart/form-data' method='post' action='admin_content_upload.php'>
<input type='radio' name='content_category' value='community' />Community Asset<br />
<input type='radio' name='content_category' value='client_education' />Client Education<br />
<input type='radio' name='content_category' value='realtor_credentials' />Realtor Credentials<br />
<input type='radio' name='content_category' value='partners' />Partners<br />
</td>

<td>
<input type='radio' name='content_type' value='document' />Document<br />
<input type='radio' name='content_type' value='photo' />Photo<br />
<input type='radio' name='content_type' value='audio' />Audio<br />
<input type='radio' name='content_type' value='video' />Video<br />
</td>

<td>
<input type='text' name='content_title' value='' size='50' maxlength='50'/>
</td>

<td>
<input type='file' id='upload_file' name='upload_file'>
<input type='hidden' name='user_name' value='$myusername' />
<input type='hidden' name='content_mode' value='$content_mode' />
<input type='hidden' name='MAX_FILE_SIZE' value='50000000'>
</td>

<td>
<input type='submit' name='submit' value='submit' >
</td>
";

//echo "<td>";

//echo "<input type='submit' name='submit' value='Submit' />
//echo "</td>";
echo "</tr>
</form>
</table>";
}

if($content_mode=='add_link')
{
//echo "<h2>Add Content</h2>";
echo "
<table border='1'>

<tr><th>Category</th><th>Type</th>
<th>Description<font color='red'> 5 Word limit</font></th>
<th>WebLink (URL Address)</th>


<tr>

<td>
<form method='post' action='admin_content_web_upload.php'>
<input type='radio' name='content_category' value='community' />Community Asset<br />
<input type='radio' name='content_category' value='client_education' />Client Education<br />
<input type='radio' name='content_category' value='realtor_credentials' />Realtor Credentials<br />
<input type='radio' name='content_category' value='partners' />Partners<br />
</td>

<td>

<input type='radio' name='content_type' value='webpage' />WebPage
</td>

<td>
<input type='text' name='content_title' value='' size='50' maxlength='50'/>
</td>

<td>
<input type='text' name='weblink' value='' size='50' maxlength='150'/>
</td>

<td>

<input type='hidden' name='user_name' value='$myusername' />
<input type='hidden' name='content_mode' value='$content_mode' />
<input type='submit' name='submit' value='submit' >
</td>
";

//echo "<td>";

//echo "<input type='submit' name='submit' value='Submit' />
//echo "</td>";
echo "</tr>
</form>
</table>";
}







echo
 "</div>
</body>
</html>";



?>











		
        