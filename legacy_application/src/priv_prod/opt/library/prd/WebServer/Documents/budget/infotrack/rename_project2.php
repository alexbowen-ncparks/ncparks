<?php

session_start();
$myusername=$_SESSION['myusername'];

if(!isset($myusername)){
header("location:index.php");
}

extract($_REQUEST);
//echo "<pre>";print_r($_REQUEST);"</pre>";//exit;
//print_r($_SESSION);echo "</pre>";exit;
include("../../include/connect.php");
$database="mamajone_cookiejar";
$table1="projects";
$table2="project_notes";

////mysql_connect($host,$username,$password);
@mysql_select_db($database) or die( "Unable to select database");

$query0="select * from projects where project_category='$project_category_new' and project_name='$project_name_new' and user_id='$myusername' ";

$result0 = mysqli_query($connection, $query0) or die ("Couldn't execute query 0.  $query0");

//The number of rows returned from the MySQL query.
$num0=mysqli_num_rows($result0);
//echo "notebook count=$num0";exit;


if($project_category_new==""){echo "<font color='red' size='5'>Error Message:</font> <font color='blue'>You must enter a Value for both the NEW Category & NEW Topic to RE-name your Notebook</font><br />Click the BACK button on your Browser to return to the Form";exit;}
if($project_name_new==""){echo "<font color='red' size='5'>Error Message:</font> <font color='blue'>You must enter a Value for both the NEW Category & NEW Topic to RE-name your Notebook</font><br />Click the BACK button on your Browser to return to the Form";exit;}

//$project_category=$_POST['project_category'];
//$project_name=$_POST['project_name'];
//$project_category_new=$_POST['project_category_new'];
//$project_name_new=$_POST['project_name_new'];

//include("../../include/connect.php");
//$database="mamajone_cookiejar";
//$table1="projects";
//$table2="project_notes";

//////mysql_connect($host,$username,$password);
//@mysql_select_db($database) or die( "Unable to select database");

if($num0==1){

$query1="update project_notes set project_category='$project_category_new',project_name='$project_name_new' where
project_category='$project_category' and project_name='$project_name' and user='$myusername' ";

mysqli_query($connection, $query1) or die ("Couldn't execute query 1.  $query1");


$query2="delete from projects where project_category='$project_category'
and project_name='$project_name' 
and user_id='$myusername' ";

mysqli_query($connection, $query2) or die ("Couldn't execute query 2.  $query2");}



else

{

$query1a="update project_notes set project_category='$project_category_new',project_name='$project_name_new' where
project_category='$project_category' and project_name='$project_name' and user='$myusername' ";

mysqli_query($connection, $query1a) or die ("Couldn't execute query 1a.  $query1a");

$query2a="update projects set project_category='$project_category_new',project_name='$project_name_new' where
project_category='$project_category' and project_name='$project_name' and user_id='$myusername' ";

mysqli_query($connection, $query2a) or die ("Couldn't execute query 2a.  $query2a");}



/*$query2="delete from $table1 where project_category='$project_category_new' and project_name='$project_name_new' and user_id='$myusername' ";

mysqli_query($connection, $query2) or die ("Couldn't execute query 2.  $query2");

$query3= "insert into $table1(user_id,project_category,project_name) 
values ('$myusername','$project_category_new','$project_name_new')";

mysqli_query($connection, $query3) or die ("Couldn't execute query 3.  $query3");


$query4="delete from $table1 where project_category='$project_category' and project_name='$project_name' and user_id='$myusername' ";

mysqli_query($connection, $query4) or die ("Couldn't execute query 4.  $query4");



// frees the connection to MySQL
////mysql_close();

//echo "Update Successful";

//echo "<br /><br />";

//echo "<A href=welcome.php>Return HOME </A>";
*/
header("location: welcome.php");


?>