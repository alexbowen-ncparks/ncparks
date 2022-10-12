<?php

session_start();
$myusername=$_SESSION['myusername'];
$active_file=$_SERVER['SCRIPT_NAME'];
if(!isset($myusername)){
header("location:index.php");
}

$system_entry_date=date("Ymd");
extract($_REQUEST);

//echo "<pre>";print_r($_SERVER);"</pre>";//exit;
//echo "<pre>";print_r($_SESSION);"</pre>";//exit;
//echo "<pre>";print_r($_REQUEST);"</pre>";exit;

include("../../include/connect.php");
//include("../../include/activity.php");//exit;

////mysql_connect($host,$username,$password);
$database="mamajone_cookiejar";
$table="gd_graph";
//echo "<pre>";print_r($_REQUEST);"</pre>";//exit;
@mysql_select_db($database) or die( "Unable to select database");

include("../../include/activity.php");//exit;

$query1="select * from gd_graph where 1";

$result1=mysqli_query($connection, $query1) or die ("Couldn't execute query 1. $query1");

echo "<html>";
echo "<table border=1>";

echo

"<tr>
 
        <th>month</th>	
        <th>sales</th>
		
</tr>";	
 

while ($row1=mysqli_fetch_array($result1)){

// The extract function automatically creates individual variables from the array $row
//These individual variables are the names of the fields queried from MySQL
extract($row1);

echo 

"<tr>

           <td>$month</td>
           <td>$sales</td>
		           
        
</tr>";




}

 echo "</table>";

echo "</html>";

?>



















	














