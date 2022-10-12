<?php
session_start();

if(!$_SESSION["budget"]["tempID"]){echo "access denied";exit;
}
$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database

$query33="SELECT park,download_date,orms_deposit_date,orms_deposit_id,bank_deposit_date,controllers_deposit_id,orms_deposit_amount,cashier,manager,park_complete,crj_compliance,cashier_date,manager_date,orms_depositor FROM crs_tdrr_division_deposits where 1 and download_date='$hid_date' order by park";


echo "$query33"; 
$result33 = mysqli_query($connection, $query33) or die ("Couldn't execute query 33.  $query33");
echo "<table border=1 align='center'>";
 
echo 

"<tr>";
echo "<th>Park</th>";
echo "<th>Download Date</th>";
echo "<th>CRS Deposit Date</th>";
echo "<th>CRS Deposit#</th>";
echo "<th>CRS Depositor</th>";
echo "<th>Bank Deposit Date</th>";
echo "<th>Bank Deposit#</th>";
echo "<th>Deposit Amount</th>";
echo "<th>Cashier</th>";
echo "<th>Cashier Date</th>";
echo "<th>Manager</th>";
echo "<th>Manager Date</th>";
echo "<th>Park Complete</th>";
echo "<th>CRJ Compliance</th>";
echo "</tr>";
//echo "</table>";

while ($row33=mysqli_fetch_array($result33)){

// The extract function automatically creates individual variables from the array $row
//These individual variables are the names of the fields queried from MySQL
extract($row33);
//echo $status;

//if($c==''){$t=" bgcolor='#B4CDCD'";$c=1;}else{$t='';$c='';}
//if($status=='complete'){$t=" bgcolor='yellow'";}else{$t=" bgcolor='#B4CDCD'";}
//if($status=='complete'){$fcolor1='red';}else{$fcolor1='black';}	
//if($status=='complete'){$bgc='yellow'";}else{$bgc='#B4CDCD';}
if($park_complete=='y'){$t=" bgcolor=lightgreen";}
if($park_complete=='n'){$t=" bgcolor=lightpink";}
if($crj_compliance=='n'){$mark="<br /><img height='25' width='25' src='/budget/infotrack/icon_photos/xmark1.png' alt='picture of green check mark'></img>";} else {$mark="<br /><img height='25' width='25' src='/budget/infotrack/icon_photos/green_checkmark1.png' alt='picture of green check mark'></img>";}
//echo $status;

//echo"<tr$t>";
echo"<tr$t>";
echo "<td>$park</td>";
echo "<td>$download_date</td>";
echo "<td>$orms_deposit_date</td>";
echo "<td>$orms_deposit_id</td>";
echo "<td>$orms_depositor</td>";
echo "<td>$bank_deposit_date</td>";
echo "<td>$controllers_deposit_id</td>";
echo "<td>$orms_deposit_amount</td>";
echo "<td>$cashier</td>";
echo "<td>$cashier_date</td>";
echo "<td>$manager</td>";
echo "<td>$manager</td>";
echo "<td>$manager_date</td>";
echo "<td>$crj_compliance $mark</td>";


	      
echo "</tr>";

}



echo "</table>";





//exit;
// The while statement steps through the $result variable one row ($row, which is an array created by mysqli_fetch_array) at a time


?>