<?php
//echo "VEHICLES.PHP";




session_start();

if(!$_SESSION["budget"]["tempID"]){echo "access denied";exit;}

//$level=$_SESSION['budget']['level'];
//$posTitle=$_SESSION['budget']['position'];
//$tempid=$_SESSION['budget']['tempID'];



$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempID=$_SESSION['budget']['tempID'];
$tempid=$_SESSION['budget']['tempID'];
$beacnum=$_SESSION['budget']['beacon_num'];
$concession_location=$_SESSION['budget']['select'];
$concession_center=$_SESSION['budget']['centerSess'];
$system_entry_date=date("Ymd");
$system_entry_date2=date('m-d-y', strtotime($system_entry_date));
$system_entry_date_dow=date('l',strtotime($system_entry_date));




extract($_REQUEST);
//echo "<pre>";print_r($_REQUEST);echo "</pre>"; exit;
//echo "<pre>";print_r($_SESSION);echo "</pre>";exit;
//$project_category='ITS';
//$project_name='wex_bill';
//$step_group='B';


$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
include("../../../../include/activity.php");// database connection parameters
/*

$query1="SELECT highlight_color from infotrack_customformat
         where user_id='$tempid' ";
		 
//echo "query1=$query1<br />";		 

$result1 = mysqli_query($connection, $query1) or die ("Couldn't execute query 1.  $query1");

$row1=mysqli_fetch_array($result1);
extract($row1);
*/

//include("../../../budget/menu1314.php");
include ("../../../budget/menu1415_v1.php");

//include("fyear_head_wex_vehicles.php");// database connection parameters
//echo "<br />";
//include("fyear_months_head_wex_vehicles.php");// database connection parameters

echo "hello line 12";



$query2="SELECT * from wex_detail where 1 and wex_fyear='$wex_fyear' and month='$wex_month' and center_code='$parkcode'
         order by center_code,optional_embossing,transaction_date3,transaction_time      ";


echo "query2=$query2<br />";
// The variable $result is a PHP resource containing the results of the MySQL query. Its contents can only be used by PHP.
$result2 = mysqli_query($connection, $query2) or die ("Couldn't execute query 2.  $query2");
$num2=mysqli_num_rows($result2);


echo "<table align='center' border=1>";
 
echo 

"<tr>";

echo "<td align='center'><font color='brown'>center<br />code</font></td>";
echo "<td align='center'><font color='brown'>card number</font></td>";
echo "<td align='center'><font color='brown'>vehicle make/plate<br />vin number</font></td>";
echo "<td align='center'><font color='brown'>miles_driven_since_last_purchase</font></td>";

echo "<td align='center'><font color='brown'>transaction date/time</font></td>";
//echo "<td align='center'><font color='brown'>transaction time</font></td>";
echo "<td align='center'><font color='brown'>merchant name</font></td>";
//echo "<td align='center'><font color='brown'>plate number</font></td>";
//echo "<td align='center'><font color='brown'>vin number</font></td>";

//echo "<td align='center'><font color='brown'>fuel type</font></td>";
echo "<td align='center'><font color='brown'>fuel purchased</font></td>";
//echo "<td align='center'><font color='brown'>units</font></td>";
//echo "<td align='center'><font color='brown'>unit of measure</font></td>";
//echo "<td align='center'><font color='brown'>unit cost</font></td>";
//echo "<td align='center'><font color='brown'>total fuel cost</font></td>";
//echo "<td align='center'><font color='brown'>merchant name</font></td>";
//echo "<td align='center'><font color='brown'>merchant address</font></td>";
//echo "<td align='center'><font color='brown'>merchant city</font></td>";
//echo "<td align='center'><font color='brown'>merchant state</font></td>";
//echo "<td align='center'><font color='brown'>current odometer</font></td>";
//echo "<td align='center'><font color='brown'>adjusted odometer</font></td>";
//echo "<td align='center'><font color='brown'>previous odometer</font></td>";
//echo "<td align='center'><font color='brown'>distance driven</font></td>";
//echo "<td align='center'><font color='brown'>fuel economy</font></td>";
//echo "<td align='center'><font color='brown'>gross cost</font></td>";
//echo "<td align='center'><font color='brown'>exempt tax</font></td>";
//echo "<td align='center'><font color='brown'>net cost</font></td>";
//echo "<td align='center'><font color='brown'>post date</font></td>";
//echo "<td align='center'><font color='brown'>transaction#</font></td>";
       
   
                 
       
 

echo "</tr>";

// The while statement steps through the $result variable one row ($row, which is an array created by mysqli_fetch_array) at a time
while ($row2=mysqli_fetch_array($result2))
	{	
	// The extract function automatically creates individual variables from the array $row
	//These individual variables are the names of the fields queried from MySQL
	//$rank=@$rank+1;
	
	$previous_odometer2=$current_odometer2;
	extract($row2);
	//$rank=$rank+1;
	
$unit_of_measure=$unit_of_measure.L;	
if($adjusted_odometer == ''){$current_odometer2=$current_odometer;}
if($adjusted_odometer != ''){$current_odometer2=$adjusted_odometer;}

if($table_bg2==''){$table_bg2='cornsilk';}
if($color==''){$t=" bgcolor='$table_bg2' ";$color=1;}else{$t='';$color='';}
	
echo "<tr$t>";

echo "<td>$center_code</td>";	
echo "<td>$card_number</td>";	
echo "<td>$driver_first_name(<font color='red'><b>$optional_embossing</b></font>)<br />$vin</td>";		
//echo "<td>previous odometer:$previous_odometer<br />current odometer:$current_odometer2<br /><br />$distance_driven miles</td>";	
echo "<td>current odometer:$current_odometer2<br /><br /><font color='red'>$distance_driven miles</font></td>";	
echo "<td><font color='red'>$transaction_date3</font><br />$transaction_time</td>";	

echo "<td><font color='red'>$merchant_name</font><br />$merchant_address<br />$merchant_city<br />$merchant_state</td>";	
//echo "<td>$transaction_time</td>";	

//echo "<td>$driver_last_name</td>";	
//echo "<td>$vin</td>";	

//echo "<td>$fuel_type</td>";	
echo "<td>$product_description<br />$units $unit_of_measure @ $unit_cost /GAL =<font color='red'>$total_fuel_cost</font></td>";	
echo "<td>$previous_odometer2</td>";
//echo "<td>$units<br />$unit_of_measure</td>";	
//echo "<td>$unit_of_measure</td>";	
//echo "<td>$unit_cost</td>";	
//echo "<td>$total_fuel_cost</td>";	
//echo "<td><font color='red'>$merchant_name</font><br />$merchant_address<br />$merchant_city<br />$merchant_state</td>";	
//echo "<td>$merchant_address</td>";	
//echo "<td>$merchant_city</td>";	
//echo "<td>$merchant_state</td>";	
//echo "<td>$current_odometer</td>";	
//echo "<td>$adjusted_odometer</td>";	
//echo "<td>$previous_odometer</td>";	
//echo "<td>$distance_driven</td>";	
//echo "<td>$fuel_economy</td>";	
//echo "<td>$gross_cost</td>";	
//echo "<td>$exempt_tax</td>";	
//echo "<td>$net_cost</td>";	
//echo "<td>$post_date</td>";	
//echo "<td>$id</td>";			   
	
		
				  
						 
echo "</tr>";
	
	
	
	}

echo "</table>";




?>