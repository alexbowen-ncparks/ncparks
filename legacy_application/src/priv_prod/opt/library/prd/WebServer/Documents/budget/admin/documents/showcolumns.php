<?php

$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // databaseparameters
include("../../../../include/authBUDGET.inc");
//print_r($_REQUEST); //exit;
extract($_REQUEST);
$table=$_POST['table'];


/*$result = mysqli_query($connection, 'SHOW COLUMNS FROM $table');
if (!$result) {
    echo 'Could not run query: ' . mysqli_error();
    exit;
}
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        print_r($row);
    }
}

*/
      print "<form action='showcolumns.php' method='post'>";

      print "Show columns for (type Table name):<br>";
	  
	  print "<input type='text' name='table' size='20'><br>";

      print "<input type='submit' name='submit' value='submit'></form>";

  
//echo $table; 


$result=mysqli_query($connection, show columns from $table);


?>
























 




















