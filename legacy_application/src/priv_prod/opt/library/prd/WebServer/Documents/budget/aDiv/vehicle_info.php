<?php

session_start();
if(!$_SESSION["budget"]["tempID"]){echo "access denied";exit;
//header("location: https://legacypriv36.dev.dpr.ncparks.gov/login_form.php?db=budget");
}

$active_file=$_SERVER['SCRIPT_NAME'];

$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempID=$_SESSION['budget']['tempID'];
$beacnum=$_SESSION['budget']['beacon_num'];
$concession_location=$_SESSION['budget']['select'];
$concession_center=$_SESSION['budget']['centerSess'];

extract($_REQUEST);
/*
echo "level=$level<br />";
echo "posTitle=$posTitle<br />";
echo "tempID=$tempID<br />";
echo "beacnum=$beacnum<br />";
echo "concession_location=$concession_location<br />";
echo "concession_center=$concession_center<br />";
*/

//echo "<pre>";print_r($_SERVER);"</pre>";//exit;
//echo "<pre>";print_r($_SESSION);"</pre>";//exit;
//echo "<pre>";print_r($_REQUEST);"</pre>";exit;

$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
include("../../include/activity.php");// database connection parameters
//include("../budget/~f_year.php");
include("../../budget/~f_year.php");



include ("../../budget/menu1415_v1.php");

/*
$database="fuel";
$db="fuel";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
include("../../include/activity.php");// database connection parameters
//include("../budget/~f_year.php");
include("../../budget/~f_year.php");
*/


//$park="neri" ;
$query3="SELECT license as 'plate',fas_num,year,make,model,vin,mileage
FROM fuel.vehicle
where 1
and center_code='$park'
ORDER BY plate";

$result3 = mysqli_query($connection, $query3) or die ("Couldn't execute query 3.  $query3");

$num3=mysqli_num_rows($result3);

//echo "query3=$query3<br />";

echo "<html>";
echo "<body>";
echo "<table align='center'><tr><td>Vehicles:<font color='red'> $num3 </font></td></tr></table>";

echo "<table align='center' border='1'>";

//$row=mysqli_fetch_array($result);

echo "<tr>";
// The while statement steps through the $result variable one row ($row, which is an array created by mysqli_fetch_array) at a time
//$c=1;
echo "<th align='left'><font color='red'>$park </font><font color='brown'>Vehicle Info</th>"; 
//echo "<th align='left'><font color='brown'>ParkName</font></th>"; 
/*
echo "<th align='left'><font color='brown'>Year</font></th>"; 
echo "<th align='left'><font color='brown'>Make</font></th>"; 
echo "<th align='left'><font color='brown'>Model</font></th>"; 
echo "<th align='left'><font color='brown'>VIN</font></th>"; 
echo "<th align='left'><font color='brown'>Mileage</font></th>"; 
*/
echo "</tr>";


while ($row3=mysqli_fetch_array($result3)){

// The extract function automatically creates individual variables from the array $row
//These individual variables are the names of the fields queried from MySQL
extract($row3);
/*
$cy_amount=number_format($cy_amount,2);
$py1_amount=number_format($py1_amount,2);
$py2_amount=number_format($py2_amount,2);
$py3_amount=number_format($py3_amount,2);
*/

$table_bg2="cornsilk";

if($c==''){$t=" bgcolor='$table_bg2' ";$c=1;}else{$t='';$c='';}


echo 

"<tr$t>"; 
               
           
        // echo "<td><a href='reports_one_budget_group_summary_by_center.php?budget_group=$budget_group'>$budget_group</a></td>"; 
		 echo "<td>";
		 echo "<table>";
		 echo "<tr>";
		 echo "<td><font color='brown'>$year $make $model</font></td>";
		 echo "</tr>";
		 echo "<tr>";
		 echo "<td><font color='red'>PLATE# $plate</font></td>";
		 echo "</tr>";		 
		 /*
		 echo "<tr>";
		 echo "<td><font color='brown'>$make</font></td>";
		 echo "</tr>";
		 echo "<tr>";
		 echo "<td><font color='brown'>$model</font></td>";
		 echo "</tr>";
		 */
		 echo "<tr>";
		 echo "<td><font color='brown'>VIN# $vin</font></td>";
		 echo "</tr>";
		 echo "<tr>";
		 echo "<td><font color='brown'>FAS# $fas_num</font></td>";
		 echo "</tr>";		 
		 echo "<tr>";
		 echo "<td><font color='red'>Current Mileage (&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;)</font></td>";
		 echo "</tr>";
		 echo "</tr>";
		 echo "</table>";
		 echo "</td>";
		 
		 
echo "</tr>";

}

 


 echo "</table></body></html>";

