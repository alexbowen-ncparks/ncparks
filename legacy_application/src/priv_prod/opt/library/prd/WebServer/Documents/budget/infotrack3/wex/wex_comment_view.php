<?php
session_start();

if(!$_SESSION["budget"]["tempID"]){echo "access denied";exit;}
extract($_REQUEST);

//echo "<pre>";print_r($_REQUEST);echo "</pre>"; exit;
//echo "<pre>";print_r($_SESSION);echo "</pre>";exit;

$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
include("../../../../include/activity.php");// database connection parameters

echo "<table align='center'>";
echo "<tr><th>$parkcode-WEX Fuel Compliance Comments</th></tr>";
echo "<tr><th>$wex_month $wex_month_calyear</th></tr>";

$query11="select cashier,cashier_comment,manager,manager_comment from wex_vehicle_compliance where id='$id' ";



echo "query11=$query11<br />";


$result11 = mysqli_query($connection, $query11) or die ("Couldn't execute query 11.  $query11 ");
 $num11=mysqli_num_rows($result11);	
 
 
 echo "<table align='center' border='1' cellpadding='5'>";

echo 

"<tr> 
       <th align=left><font color=brown>Cashier Comment</font></th>
       <th align=left><font color=brown>Manager Comment</font></th>";
	  
while ($row11=mysqli_fetch_array($result11)){

// The extract function automatically creates individual variables from the array $row
//These individual variables are the names of the fields queried from MySQL
extract($row11);
//$park_oob=$cashier_amount-$manager_amount;
$cashier3=substr($cashier,0,-2);
$manager3=substr($manager,0,-2);	        
echo "<tr><td>$cashier3<br /><br />$cashier_comment</td><td>$manager3<br /><br />$manager_comment</td></tr>";     
       
              
}
 
 echo "</table>";
 
 
 
 
 
 
 
 
 
?>