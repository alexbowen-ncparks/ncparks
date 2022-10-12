<?php
session_start();
$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempid=$_SESSION['budget']['tempID'];
extract($_REQUEST);
//echo "<pre>";print_r($_REQUEST);echo "</pre>"; exit;

$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
include("../../../../include/activity.php");// database connection parameters

$query3="select * from pcard_unreconciled where center='$new_center' and transdate_new >= '20170701' order by transdate_new desc ;";



// The variable $result is a PHP resource containing the results of the MySQL query. Its contents can only be used by PHP.
$result3 = mysqli_query($connection, $query3) or die ("Couldn't execute query 3.  $query3");


echo "<table border=1>";
 
echo "<tr>"; 
echo "<th>ncasnum</th>";  
echo "<th>amount</th>";  
echo "<th>transid_new</th>";  
echo "<th>center</th>";  
echo "<th>transdate_new</th>";  
echo "<th>ncas_yn</th>";  
echo "</tr>";


while ($row3=mysqli_fetch_array($result3)){

// The extract function automatically creates individual variables from the array $row
//These individual variables are the names of the fields queried from MySQL
extract($row3);

echo "<tr>";
echo "<td>$ncasnum</td>";
echo "<td>$amount</td>";
echo "<td>$transid_new</td>";
echo "<td>$center</td>";
echo "<td>$transdate_new</td>";
echo "<td>$ncas_yn</td>";





echo "</tr>";

}
echo "</table>";





?>