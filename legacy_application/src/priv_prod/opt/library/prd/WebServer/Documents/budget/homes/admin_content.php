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
<body id="admin_content">
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
				<li><a href="admin_properties.php" >Properties</a></li>
				<li><a href="admin_content.php"  >Content</a></li>
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
echo "<h1 align='left' font color='brown'>Admin Content</h1>";
echo "<table border='1'>
<tr>
<th><font $add_file><a href='admin_content.php?content_mode=add_file'>Add <br />File</a></font></th>
<th><font $add_link><a href='admin_content.php?content_mode=add_link'>Add <br />Link</a></font></th>
<th><font $view><a href='admin_content.php?content_mode=view'>View</a></th>
</tr>
</table>";
echo "<br />";
if($content_mode=='add_file')
{
//echo "<h2>Add Content</h2>";
echo "
<table border='1'>

<tr><th>Category</th><th>Type of File</th>
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











		
        