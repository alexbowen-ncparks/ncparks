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


$query3="select * from budget.cab_dpr where match_coa != 'y' and dpr_valid='y' ;";



// The variable $result is a PHP resource containing the results of the MySQL query. Its contents can only be used by PHP.
$result3 = mysqli_query($connection, $query3) or die ("Couldn't execute query 3.  $query3");

////mysql_close();
echo "<table border=1>";
 
echo "<tr>"; 
echo "<th>BC</th>";      
echo "<th>BC_Descript</th>";      
echo "<th>Fund</th>";      
echo "<th>Fund_Descript</th>";      
echo "<th>Acct</th>";      
echo "<th>Acct_Descript</th>";      
echo "<th>Certified</th>";      
echo "<th>Authorized</th>";      
echo "<th>Curr_Month</th>";      
echo "<th>YTD</th>";      
echo "<th>Unexpended</th>";      
echo "<th>Unrealized</th>";      
echo "<th>Encumbrances</th>";      
echo "<th>F_Year</th>";      
echo "<th>DPR</th>";      
echo "<th>Cash_Type</th>";      
echo "<th>Receipt_Amt</th>";      
echo "<th>Disburse_Amt</th>";      
echo "<th>XTND_rundate</th>";      
echo "<th>Match_COA</th>";      
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
echo "<td>$BC_Descript</td>";      
echo "<td>$Fund</td>";      
echo "<td>$Fund_Descript</td>";      
echo "<td>$Acct</td>";      
echo "<td>$Acct_Descript</td>";      
echo "<td>$Certified</td>";      
echo "<td>$Authorized</td>";      
echo "<td>$Curr_Month</td>";      
echo "<td>$YTD</td>";      
echo "<td>$Unexpended</td>";      
echo "<td>$Unrealized</td>";      
echo "<td>$Encumbrances</td>";      
echo "<td>$F_Year</td>";      
echo "<td>$DPR</td>";      
echo "<td>$Cash_Type</td>";      
echo "<td>$Receipt_Amt</td>";      
echo "<td>$Disburse_Amt</td>";      
echo "<td>$XTND_rundate</td>";      
echo "<td>$Match_COA</td>";      
echo "<td>$ID</td>";     	      
echo "</tr>";



}

echo "</table></body></html>";

?>

























