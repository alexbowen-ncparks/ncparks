<?php
extract($_REQUEST);
session_start();
$myusername=$_SESSION['myusername'];

if(!isset($myusername)){
header("location:index.php");
}

include("../../include/connect.php");
$database="mamajone_cookiejar";
$table="test_20100426";


////mysql_connect($host,$username,$password);
@mysql_select_db($database) or die( "Unable to select database");


if(isset($_POST['submit']))

   {

     $filename=$_POST['filename'];

     $handle = fopen("$filename", "r");

     while (($data = fgetcsv($handle, 1000, ",")) !== FALSE)

     {

    

       $import="INSERT into test_20100426(last_name,first_name) values('$data[0]','$data[1]')";

       mysqli_query($connection, $import) or die(mysqli_error());

     }

     fclose($handle);

     print "Import done";

 

   }

   else

   {

 

      print "<form action='import.php' method='post'>";

      print "Type file name to import:<br>";

      print "<input type='text' name='filename' size='20'><br>";

      print "<input type='submit' name='submit' value='submit'></form>";

   }


?>
























 




















