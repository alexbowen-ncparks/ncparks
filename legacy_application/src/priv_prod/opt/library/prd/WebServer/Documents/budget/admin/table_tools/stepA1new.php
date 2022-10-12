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
echo "<H1 ALIGN=LEFT > <font color=brown><i>$project_name</font></i></H1>";
echo "<H3 ALIGN=LEFT > <font color=blue>$step_name</font></H3>";
echo "<H2 ALIGN=center><font size=4><b><A href=/budget/admin/table_tools/main.php?project_category=fms&project_name=table_tools>Table Tools-HOME </A></font></H2>";


echo "<br />";



$sql = "SHOW TABLES FROM $dbname";
$result = mysqli_query($connection, $sql);
$num=mysqli_num_rows($result);
echo "records=$num";
while($col=mysqli_fetch_array($result)){
$tables[]=$col[0];
}
//echo "<pre>";print_r($tables);"</pre>";exit;


echo "<table border=1>";
 
echo "<tr>"; 
    
 echo " <th><font color=blue>Table</font></th>";
 echo " <th><font color=blue>Action</font></th>";
 echo "</tr>";


for ($n=0;$n<$num;$n++){
echo "<form method='post' action='table_delete_verify.php'>";	
echo "<tr$t>";	      
	  	   
echo  "<td><input type='text' size='60' readonly='readonly' name='table_name' value='$tables[$n]'</td>";
	      


echo "<input type='hidden' name='dbname' value='$dbname'>";
echo  "<td><input type='submit' name='submit2' value='DELETE'>";
echo   "</form>";
echo "</td>";
echo "</tr>";

}	 
echo "</table>";
	

echo "</html>";
	

?>