<?php

session_start();
//echo "<pre>";print_r($_SESSION);echo "</pre>";exit;
$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempid=$_SESSION['budget']['tempID'];
//echo $tempid;
extract($_REQUEST);
//echo "<pre>";print_r($_REQUEST);"</pre>";//exit;
$start_date=str_replace("-","",$start_date);
$end_date=str_replace("-","",$end_date);
//echo "start_date=$start_date";
//echo "<br />"; 
//echo "end_date=$end_date";exit;
$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
include("../../../../include/activity.php");// database connection parameters
//echo "submit1=$submit1";echo "submit2=$submit2";exit;

$dbname = 'budget';

$sql = "select center,center_desc from center where 1";
$result = mysqli_query($connection, $sql);
$num=mysqli_num_rows($result);
echo "records=$num";
while($col=mysqli_fetch_array($result)){
$tables[]=$col[1];
}
//echo "<pre>";print_r($tables);"</pre>";exit;


echo "<table border=1>";
 
echo "<tr>"; 
    
 echo " <th><font color=blue>Center</font></th>";
 echo "</tr>";

echo "<form method=post action=stepA1_updatetest.php>";	
for ($n=0;$n<$num;$n++){

echo "<tr$t>";	      
//echo "<form method=post action=stepG5_update.php>";	   
echo  "<td><input type='text' size='60' readonly='readonly' name='table_name' value='$tables[$n]'</td>";
	      
echo "</tr>";

}
echo "</table>";
	

?>