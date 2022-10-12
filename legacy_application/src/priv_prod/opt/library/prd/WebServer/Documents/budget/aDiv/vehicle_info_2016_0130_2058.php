<?php

session_start();
if(!$_SESSION["budget"]["tempID"]){echo "access denied";exit;
//header("location: /login_form.php?db=budget");
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
echo "<pre>";print_r($_SESSION);"</pre>";//exit;
//echo "<pre>";print_r($_REQUEST);"</pre>";exit;

$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/connectROOT.inc"); // connection parameters
mysql_select_db($database, $connection); // database
include("../../include/activity.php");// database connection parameters
//include("../budget/~f_year.php");
include("../../budget/~f_year.php");



include ("../../budget/menu1415_v1.php");


$database="fuel";
$db="fuel";
include("/opt/library/prd/WebServer/include/connectROOT.inc"); // connection parameters
mysql_select_db($database, $connection); // database
include("../../include/activity.php");// database connection parameters
//include("../budget/~f_year.php");
include("../../budget/~f_year.php");



$park="neri" ;
$query3="SELECT license as 'tag',year,make,model,vin,mileage
FROM vehicle
where 1
and center_code='$park'
ORDER BY tag";

$result3 = mysql_query($query3) or die ("Couldn't execute query 3.  $query3");

$num3=mysql_num_rows($result3);

echo "query3=$query3<br />";

echo "<html>";
echo "<body>";
echo "<table align='center'><tr><td>Vehicles:<font color='red'> $num3 </font></td></tr></table>";

echo "<table align='center' border='1'>";

//$row=mysql_fetch_array($result);

echo "<tr>";
// The while statement steps through the $result variable one row ($row, which is an array created by mysql_fetch_array) at a time
//$c=1;
echo "<th align='left'><font color='brown'>TAG#</font></th>"; 
//echo "<th align='left'><font color='brown'>ParkName</font></th>"; 
echo "<th align='left'><font color='brown'>Year</font></th>"; 
echo "<th align='left'><font color='brown'>Make</font></th>"; 
echo "<th align='left'><font color='brown'>Model</font></th>"; 
echo "<th align='left'><font color='brown'>VIN</font></th>"; 
echo "<th align='left'><font color='brown'>Mileage</font></th>"; 
echo "</tr>";


while ($row3=mysql_fetch_array($result3)){

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
		 echo "<td>$tag</td>"; 
          //echo "<td>$park_name</td>";
		  echo "<td>$year</td> 	
           <td>$make</td> 	
           <td>$model</td> 
           <td>$vin</td> 
           <td>$mileage</td> 
          
           
           
                
		  
		  
			  
			  
</tr>";

}

 


 echo "</table></body></html>";

?>