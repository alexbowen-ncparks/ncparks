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

$query1a="select first_name as 'cashier_first',nick_name as 'cashier_nick',last_name as 'cashier_last',count(id) as 'cashier_count'
          from cash_handling_roles
		  where park='$concession_location' and role='cashier' and tempid='$tempid' ";	 

$result1a = mysqli_query($connection, $query1a) or die ("Couldn't execute query 1a.  $query1a");
		  
$row1a=mysqli_fetch_array($result1a);

extract($row1a);

if($cashier_nick){$cashier_first=$cashier_nick;}			  
		  


$query1b="select first_name as 'manager_first',nick_name as 'manager_nick',last_name as 'manager_last',count(id) as 'manager_count'
          from cash_handling_roles
		  where park='$concession_location' and role='manager' and tempid='$tempid' ";	 

//if($beacnum=='60033148'){echo "query1b=$query1b";}		  
$result1b = mysqli_query($connection, $query1b) or die ("Couldn't execute query 1b.  $query1b");
		  
$row1b=mysqli_fetch_array($result1b);

extract($row1b);

if($manager_nick){$manager_first=$manager_nick;}	
/*
$query11e="select center_desc from center where parkcode='$concession_location'   ";	 
 
 
//echo "query1d=$query1d<br />";//exit;		  

$result11e = mysqli_query($connection, $query11e) or die ("Couldn't execute query 11e.  $query11e");
		  
$row11e=mysqli_fetch_array($result11e);

extract($row11e);



$center_location = str_replace("_", " ", $center_desc);
*/

//include("fyear_head_wex_vehicles.php");// database connection parameters
//echo "<br />";
//include("fyear_months_head_wex_vehicles.php");// database connection parameters

echo "hello line 12";
echo "<table border=1 align='center'>";

//echo "<tr><th colspan='2'><img height='50' width='100' src='/budget/infotrack/icon_photos/mission_icon_photos_251.png' alt='picture of pci'></img>PCI Compliance:&nbsp;$cash_month $cash_month_calyear</th></tr>";

$query8a="select text_code from svg_graphics where id='10'  ";
		 
//echo "query8a=$query8a<br />";		 

$result8a = mysqli_query($connection, $query8a) or die ("Couldn't execute query 8a.  $query8a");

$row8a=mysqli_fetch_array($result8a);
extract($row8a);

echo "<tr><th colspan='2'>$text_code<br />WEX Fuel Verification:&nbsp;$wex_month $wex_month_calyear</th></tr>";

/*
echo "<tr><th colspan='2'><img height='75' width='75' src='fala_fuel_tank.jpg' alt='picture of bank'></img>PCI Compliance:&nbsp;$cash_month $cash_month_calyear</th></tr>";
*/

	
echo "</table>";
echo "<br />";


$query2="SELECT * from wex_detail where 1 and wex_fyear='$wex_fyear' and month='$wex_month' and center_code='$parkcode'
         order by center_code,optional_embossing,transaction_date3,transaction_time      ";


echo "query2=$query2<br />";
// The variable $result is a PHP resource containing the results of the MySQL query. Its contents can only be used by PHP.
$result2 = mysqli_query($connection, $query2) or die ("Couldn't execute query 2.  $query2");
$num2=mysqli_num_rows($result2);


echo "<table align='center' border='1'>";
 
echo 

"<tr>";

echo "<td align='center'><font color='brown'>center<br />code</font></td>";
echo "<td align='center'><font color='brown'>card number</font></td>";
echo "<td align='center'><font color='brown'>vehicle make/plate<br />vin number</font></td>";
//echo "<td align='center'><font color='brown'>miles_driven<br />since_last_purchase</font></td>";
//echo "<td align='center'><font color='brown'>odometer reading</font></td>";

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
	
	$current_odometer_previous=$current_odometer2;
	$optional_embossing_previous=$optional_embossing;
	//$t_previous=$t;
	extract($row2);
	//$rank=$rank+1;
//if($optional_embossing==$previous_optional_embossing)	
$unit_of_measure=$unit_of_measure.L;	
if($adjusted_odometer == ''){$current_odometer2=$current_odometer;}
if($adjusted_odometer != ''){$current_odometer2=$adjusted_odometer;}
if($optional_embossing == $optional_embossing_previous){$distance_driven=$current_odometer2-$current_odometer_previous;}
//if($table_bg2==''){$table_bg2='cornsilk';}
//if($color==''){$t=" bgcolor='$table_bg2' ";$color=1;}else{$t='';$color='';}


if($optional_embossing2==''){$t="lightcyan";}

if($optional_embossing2!='')
{
if($optional_embossing2==$optional_embossing and $t2=='lightcyan'){$t="lightcyan";}
if($optional_embossing2==$optional_embossing and $t2=='cornsilk'){$t="cornsilk";}

if($optional_embossing2!=$optional_embossing and $t2=='lightcyan'){$t="cornsilk";}
if($optional_embossing2!=$optional_embossing and $t2=='cornsilk'){$t="lightcyan";}
	
}

	
echo "<tr bgcolor='$t'>";

echo "<td>$center_code</td>";	
echo "<td>$card_number</td>";	
echo "<td>$driver_first_name(<font color='red'><b>$optional_embossing</b></font>)<br />$vin</td>";		
//echo "<td>previous odometer:$previous_odometer<br />current odometer:$current_odometer2<br /><br />$distance_driven miles</td>";	
//echo "<td><font color='red'>$distance_driven miles</font><br /><br />current odometer:$current_odometer2</td>";	
//echo "<td><font color='red'>$distance_driven miles</font></td>";	
//echo "<td>$current_odometer2</td>";	
echo "<td><font color='red'>$transaction_date3</font><br />$transaction_time</td>";	

echo "<td><font color='red'>$merchant_name</font><br />$merchant_address<br />$merchant_city<br />$merchant_state</td>";	
//echo "<td>$transaction_time</td>";	

//echo "<td>$driver_last_name</td>";	
//echo "<td>$vin</td>";	

//echo "<td>$fuel_type</td>";	
echo "<td>$product_description<br />$units $unit_of_measure @ $unit_cost /GAL =<font color='red'>$total_fuel_cost</font></td>";	
//echo "<td>$current_odometer_previous</td>";
//echo "<td>$optional_embossing_previous</td>";
//echo "<td>$t_previous</td>";
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

$optional_embossing2=$optional_embossing;
$t2=$t; 	
	
	
}

echo "</table>";
echo "<br /><br />";

if($beacnum != '60032781')
{

if($cashier_count==1)
{
echo "<form method='post' autocomplete='off' action='wex_approval_update.php'>";


echo "<table align='center'>";
echo "<tr><th>Cashier: $cashier_first $cashier_last</th><td>&nbsp;&nbsp;Wex Charges verified<input type='checkbox' name='cashier_approved' value='y' >";
echo "<input type='hidden' name='wex_fyear' value='$wex_fyear'>";
echo "<input type='hidden' name='wex_month' value='$wex_month'>";
echo "<input type='hidden' name='wex_month_calyear' value='$wex_month_calyear'>";

if($tempid=='Schliebener8585')
{
echo "<input type='submit' name='cashier_submit' value='Submit'>";
}

echo "</td>";

echo"</tr>";
//echo "<tr><th>Manager: $manager</th><td>Approved:<input type='checkbox' name='manager_approved' value='y'>
echo "</form>";
}

if($manager_count==1)
{

$query3="select cashier as 'cashier_tempid' from wex_vehicle_compliance
		  where park='$concession_location' and wex_month='$wex_month' and wex_month_calyear='$wex_month_calyear' ";	

echo "<br />Line 300: query3=$query3<br />";		  

$result3 = mysqli_query($connection, $query3) or die ("Couldn't execute query 3.  $query3");
		  
$row3=mysqli_fetch_array($result3);

extract($row3);	

	
$query4="select first_name as 'cashier_first',nick_name as 'cashier_nick',last_name as 'cashier_last',count(id) as 'cashier_count'
          from cash_handling_roles
		  where park='$concession_location' and role='cashier' and tempid='$cashier_tempid' ";	

echo "<br />Line 313: query4=$query4<br />";				  

$result4 = mysqli_query($connection, $query4) or die ("Couldn't execute query 4.  $query4");
		  
$row4=mysqli_fetch_array($result4);

extract($row4);	
	
	
	
	
	
	
echo "<form method='post' autocomplete='off' action='wex_approval_update.php'>";


echo "<table align='center' border='1'>";
echo "<tr><th>Cashier: $cashier_first $cashier_last</th><td>&nbsp;&nbsp;Wex Charges verified";
echo "<img height='25' width='25' src='/budget/infotrack/icon_photos/green_checkmark1.png' alt='picture of green check mark'></img>";
echo "</td>";

echo"</tr>";
echo "<tr><th>Manager: $manager_first $manager_last</th><td>&nbsp;&nbsp;Wex Charges approved<input type='checkbox' name='manager_approved' value='y' >";
echo "<textarea rows='11' cols='35' name='manager_comment' placeholder='Manager Comments'>$manager_comment</textarea>";
echo "<input type='hidden' name='wex_fyear' value='$wex_fyear'>";
echo "<input type='hidden' name='wex_month' value='$wex_month'>";
echo "<input type='hidden' name='wex_month_calyear' value='$wex_month_calyear'>";

if($tempid=='Conolly1463')
{
echo "<input type='submit' name='manager_submit' value='Submit'>";
}

echo "</td>";

echo"</tr>";
echo "</table>";


//echo "<tr><th>Manager: $manager</th><td>Approved:<input type='checkbox' name='manager_approved' value='y'>
echo "</form>";
}

}













?>