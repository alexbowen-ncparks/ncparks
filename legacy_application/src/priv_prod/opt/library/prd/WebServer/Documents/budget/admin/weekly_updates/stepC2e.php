<?php

//echo "<pre>";print_r($_REQUEST);echo "</pre>";//exit;
session_start();
$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempid=$_SESSION['budget']['tempID'];
extract($_REQUEST);
echo "<pre>";print_r($_REQUEST);echo "</pre>";//exit;

$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
include("../../../../include/activity.php");// database connection parameters

echo "<html>";
echo "<head>
<style>
body { background-color: #FFF8DC; }
table { background-color: white; font-color: blue; font-size: 15;}
TH{font-family: Arial; font-size: 15pt;}
TD{font-family: Arial; font-size: 15pt;}

</style>
	


</head>";

//echo "<body bgcolor=>";

//echo "<H3 ALIGN=CENTER > <A href=welcome.php> Return HOME </A></H3>";

echo "<br /><br />";


$query3="select * from budget.bd725_dpr where match_coa != 'y';";



// The variable $result is a PHP resource containing the results of the MySQL query. Its contents can only be used by PHP.
$result3 = mysqli_query($connection, $query3) or die ("Couldn't execute query 3.  $query3");

////mysql_close();
echo "<table border=1>";
 
echo "<tr>"; 
echo "<th>BC</th>";      
echo "<th>Fund</th>";      
echo "<th>Fund_Descript</th>";      
echo "<th>Account</th>";      
echo "<th>Account_Descript</th>";      
echo "<th>total_budget</th>";      
echo "<th>unallotted</th>";      
echo "<th>total_allotments</th>";      
echo "<th>current</th>";      
echo "<th>YTD</th>";      
echo "<th>PTD</th>";      
echo "<th>allotment_balance</th>";      
echo "<th>f_year</th>";      
echo "<th>match_center_table</th>";      
echo "<th>match_coa</th>";      
echo "<th>Cash_Type</th>";      
echo "<th>Receipt_Amt</th>";      
echo "<th>Disburse_Amt</th>";      
echo "<th>XTND_rundate</th>";      
echo "<th>ID</th>";      
       
     
echo "</tr>";

// The while statement steps through the $result variable one row ($row, which is an array created by mysqli_fetch_array) at a time
while ($row3=mysqli_fetch_array($result3)){

// The extract function automatically creates individual variables from the array $row
//These individual variables are the names of the fields queried from MySQL
extract($row3);
//echo $status;

//if($c==''){$t=" bgcolor='#B4CDCD'";$c=1;}else{$t='';$c='';}
if($status=='complete'){$t=" bgcolor='yellow'";}else{$t=" bgcolor='#B4CDCD'";}
if($status=='complete'){$fcolor1='red';}else{$fcolor1='black';}	
//if($status=='complete'){$bgc='yellow'";}else{$bgc='#B4CDCD';}

//echo $status;

echo "<tr$t>";	
echo "<td>$BC</td>";      
echo "<td>$FUND</td>";      
echo "<td>$Fund_Descript</td>";      
echo "<td>$Account</td>";      
echo "<td>$Account_Descript</td>";      
echo "<td>$total_budget</td>";      
echo "<td>$unallotted</td>";      
echo "<td>$total_allotments</td>";      
echo "<td>$current</td>";      
echo "<td>$ytd</td>";      
echo "<td>$ptd</td>";      
echo "<td>$allotment_balance</td>";      
echo "<td>$f_year</td>";      
echo "<td>$match_center_table</td>";      
echo "<td>$match_coa</td>";      
echo "<td>$cash_type</td>";      
echo "<td>$receipt_amt</td>";      
echo "<td>$disburse_amt</td>";      
echo "<td>$xtnd_rundate</td>";      
echo "<td>$id</td>";     	      
echo "</tr>";



}

echo "</table></body></html>";

?>

























