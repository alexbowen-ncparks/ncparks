<?php

//echo "<pre>";print_r($_REQUEST);echo "</pre>";//exit;
session_start();
//echo "<pre>";print_r($_SESSION);echo "</pre>";exit;
$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempid=$_SESSION['budget']['tempID'];
//echo $tempid;
extract($_REQUEST);
$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
include("../../../../include/activity.php");// database connection parameters
//echo "submit1=$submit1";echo "submit2=$submit2";exit;
echo "<pre>";print_r($_REQUEST);"</pre>";//exit;

echo "<html>";
echo "<head>
<style>
body { background-color: #FFF8DC; }
table { background-color: #FFF8DC; font-color: blue; font-size: 15;}
TH{font-family: Arial; font-size: 15pt;}
TD{font-family: Arial; font-size: 15pt;}
input{style=font-family: Arial; font-size:14.0pt}
</style>

</head>";

//echo "<body bgcolor=>";

//echo "<H3 ALIGN=CENTER > <A href=welcome.php> Return HOME </A></H3>";
echo "<H1 ALIGN=LEFT > <font color=brown><i>$project_name-$step_group$step_num</font></i></H1>";
echo "<H2 ALIGN=center><font size=4><b><A href=/budget/admin/weekly_updates/main.php?project_category=fms&project_name=weekly_updates> Return Weekly Updates-HOME </A></font></H2>";

echo "<br />";


$query3="SELECT * FROM beacon_paydates where 1 order by paydate desc";



// The variable $result is a PHP resource containing the results of the MySQL query. Its contents can only be used by PHP.
$result3 = mysqli_query($connection, $query3) or die ("Couldn't execute query 3.  $query3");

////mysql_close();
echo "<table border=1>";

echo "<tr> <th>Paydate</th> <th>Status</th> </tr>";

// The while statement steps through the $result variable one row ($row, which is an array created by mysqli_fetch_array) at a time
while ($row3=mysqli_fetch_array($result3)){

// The extract function automatically creates individual variables from the array $row
//These individual variables are the names of the fields queried from MySQL
extract($row3);
//echo $status;

//if($c==''){$t=" bgcolor='#B4CDCD'";$c=1;}else{$t='';$c='';}
if($status=='complete'){$t=" bgcolor='yellow'";}else{$t=" bgcolor='#B4CDCD'";}
if($status=='complete'){$fcolor1='red';}else{$fcolor1='black';}	
	 
echo "<tr$t>";	



echo   "<td>
        <form method='post' action='stepE1_update.php'>
		<input type='text' size='10' name='paydate' autocomplete='off' value='$paydate'>
		<input type='hidden' name='fiscal_year' value='$fiscal_year'>
		<input type='hidden' name='start_date' value='$start_date'>
		<input type='hidden' name='end_date' value='$end_date'>
		<input type='hidden' name='project_category' value='$project_category'>
		<input type='hidden' name='project_name' value='$project_name'>
		<input type='hidden' name='step_group' value='$step_group'>
		<input type='hidden' name='step_num' value='$step_num'>
	    <input type='submit' name='submit' value='Update'>
		</form>
        </td>";
            
echo "<td> <font color=$fcolor1>$status</font></td>";
   
echo "</tr>";

}

echo "</table></body></html>";

 
 
 ?>




















