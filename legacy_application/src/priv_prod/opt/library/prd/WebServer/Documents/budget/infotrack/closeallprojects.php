<?php

session_start();
$myusername=$_SESSION['myusername'];

if(!isset($myusername)){
header("location:index.php");
}

include("../../include/connect.php");
$project_status=$_POST['project_status'];
$database="mamajone_cookiejar";
$table="projects";

////mysql_connect($host,$username,$password);
@mysql_select_db($database) or die( "Unable to select database");
$query="update $table
set project_status='closed'
WHERE  user_id='$myusername' ";


// The variable $result is a PHP resource containing the results of the MySQL query. Its contents can only be used by PHP.
$result = mysqli_query($connection, $query) or die ("Couldn't execute query 1.  $query");

//The number of rows returned from the MySQL query.
//$num=mysqli_num_rows($result);
//echo "n=$num";
//exit;

// frees the connection to MySQL
 ////mysql_close();

 
/*echo "<html>";
echo "<head>

<title>Welcome</title>
<style>

body { background-color: #FFF8DC; }
form { background-color: white; font-color: blue; font-size: 15;}
table { background-color: white; font-color: blue; font-size: 15;}
TH{font-family: Arial; font-size: 15pt;}
TD{font-family: Arial; font-size: 15pt;}



//h1 { background-color: white; font-color: red; }



</style>

</head>";


//echo "<body bgcolor=#FFFFb4>";

echo "<H3 ALIGN=CENTER > <A href=welcome.php> Return HOME </A></H3>";

 echo "</html>";
 */
 
 header("location: welcome.php");
 ?>






















