
<?php
//echo "<pre>";print_r($_REQUEST);echo "</pre>";//exit;
session_start();

if(!$_SESSION["budget"]["tempID"]){echo "access denied";exit;
}



$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempid=$_SESSION['budget']['tempID'];
extract($_REQUEST);
//echo "<pre>";print_r($_REQUEST);echo "</pre>"; //exit;

$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
include("../../../include/activity.php");// database connection parameters

include ("../../budget/menu1415_v1.php");	
//include("../../budget/menu1314.php");	
//include("service_contracts_menu.php");
//include("money_quotes_menu.php");




$query="SELECT id,quote_comment FROM `money_quotes` WHERE `round` LIKE '2' ORDER BY `money_quotes`.`quote_comment` ASC";

//echo "query=$query";
$result = mysqli_query($connection, $query) or die ("Couldn't execute query .  $query");
$num=mysqli_num_rows($result);
echo "<br />";
echo "<table align='center' border='1' cellspacing='5'>";

echo "<tr>";
while ($row=mysqli_fetch_array($result)){

// The extract function automatically creates individual variables from the array $row
//These individual variables are the names of the fields queried from MySQL
extract($row);

echo "<td>$quote_comment</td>";



}	
echo "</tr>";
echo "</table>";













?>