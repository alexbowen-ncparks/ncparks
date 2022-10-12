<?php

$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
include("../../../include/authBUDGET.inc");
//print_r($_REQUEST); //exit;
extract($_REQUEST);

$table="test";

if(isset($_POST['submit']))

   {

     $filename=$_POST['filename'];

     $handle = fopen("$filename", "r");

     while (($data = fgetcsv($handle, 1000, ",")) !== FALSE)

     {

    

       $import="INSERT into test(last_name,first_name,sex) values('$data[0]','$data[1]','$data[2]')";

       mysqli_query($connection, $import) or die(mysqli_error());

     }

     fclose($handle);

     print "Import done";

 

   }

   else

   {

 

      print "<form action='import2.php' method='post'>";

      print "Type file name to import:<br>";

      print "<input type='text' name='filename' size='20'><br>";

      print "<input type='submit' name='submit' value='submit'></form>";

   }


?>
























 




















