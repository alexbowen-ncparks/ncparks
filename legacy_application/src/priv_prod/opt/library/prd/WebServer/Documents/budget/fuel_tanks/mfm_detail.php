 <?php

session_start();


if (!$_SESSION["budget"]["tempID"]) {echo "Access denied";exit;}
$active_file=$_SERVER['SCRIPT_NAME'];

$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempid=$_SESSION['budget']['tempID'];
$beacnum=$_SESSION['budget']['beacon_num'];
$concession_location=$_SESSION['budget']['select'];
$concession_center=$_SESSION['budget']['centerSess'];
extract($_REQUEST);
//$ctdd_id=$id;
//echo "ctdd_id=$ctdd_id<br />";
//echo $concession_location;

//echo "<pre>";print_r($_SERVER);"</pre>";//exit;
//echo "<pre>";print_r($_SESSION);"</pre>";//exit;
//echo "<pre>";print_r($_REQUEST);"</pre>";//exit;

//echo "<pre>";print_r($_SESSION);"</pre>";exit;
$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database


$query11="select id,park,center,fyear as 'fiscal_year',cash_month,cash_month_number,cash_month_calyear,tag_num,vehicle_num,vehicle_location,driver_name,gallons,
 usage_day
 from fuel_tank_usage_detail
 where park='$parkcode' and cash_month='$cash_month' and fyear='$fyear' and cash_month_calyear='$cash_month_calyear'
 order by id asc ; ";

	
	
//echo "query11=$query11<br />"; //exit;


$result11 = mysqli_query($connection, $query11) or die ("Couldn't execute query 11.  $query11 ");
 $num11=mysqli_num_rows($result11);	
 echo "<html>";
echo "<head>
<title>MoneyTracker</title>";


include ("test_style.php");
echo "<style>";
echo "#table1{
width:800px;
	margin-left:auto; 
    margin-right:auto;
	}";
echo "</style>";
echo "</head>";

include("../../budget/menu1314_tony.html");


 echo "<br />";
 echo "<br />";
 
 
 // 6/1/15: LAWA Seasonal employee Paula Wagner,  Budget Officer Tammy Dodd,  Accountant Tony Bass
 /*
 if($tempid=='wagner9210' or $beacnum=='60032781' or $beacnum=='60032793')
 {
 echo "<table align='center'><tr><td><a href='page2_form.php?parkcode=$parkcode&cash_month=$cash_month&fyear=$fyear&cash_month_calyear=$cash_month_calyear&edit=y'>Edit Form</a></td></tr></table>";
 }
 */
 
 
 $query11a="SELECT count(id) as 'record_count',sum(gallons) as 'gallons_total'
from fuel_tank_usage_detail
WHERE park='$parkcode' and cash_month='$cash_month' and fyear='$fyear' and cash_month_calyear='$cash_month_calyear'
";

$result11a=mysqli_query($connection, $query11a) or die ("Couldn't execute query 11a. $query11a");

$row11a=mysqli_fetch_array($result11a);

extract($row11a);
 
 //echo "query11a=$query11a<br />";
 
 //echo "record_count=$record_count<br />"; //exit;
 
 $query12="SELECT reimbursement_rate,document_location,cashier,cashier_date,manager,manager_date
from fuel_tank_usage
WHERE park='$parkcode' and cash_month='$cash_month' and fyear='$fyear' and cash_month_calyear='$cash_month_calyear'
";

$result12=mysqli_query($connection, $query12) or die ("Couldn't execute query 12. $query12");

$row12=mysqli_fetch_array($result12);

extract($row12);
 
 
//echo "cashier=$cashier<br />";
 
if($manager_count=='1' and $cashier==''){echo "<table align='center'><tr><td><img height='40' width='40' src='/budget/infotrack/icon_photos/info2.png' alt='picture of green check mark'></img><font color='brown' class='cartRow2'>Steps 1-3 have not been completed by Cashier</font></td></tr></table>"; exit;} 
 
 
$gas_cost=number_format($gallons_total*$reimbursement_rate,2); 

$administrative_fee=number_format($gallons_total*.12,2);
$refund_total=number_format($gas_cost+$administrative_fee,2);

 /*
 
 if($tempid=='wagner9210' or $beacnum=='60032781' or $beacnum=='60032793')
 {

 
 echo "<table align='center'><tr><td><a href='page2_form.php?parkcode=$parkcode&cash_month=$cash_month&fyear=$fyear&cash_month_calyear=$cash_month_calyear&edit=y&step=3'>Edit Form</a></td></tr></table>";
 
  
 }
 
 */
 
 //echo "<div id='table1'>";
 //echo "<div style='float:center'>";
 
 
 echo "<br /><table align='center'><tr><th><img height='75' width='75' src='fala_fuel_tank.jpg' alt='picture of fuel tank'></img><font color='brown'></b>Park Fuel for Motor Fleet Vehicles </font>($cash_month $cash_month_calyear)<font color='green'>-$parkname</font></b></th></tr></table>";
 
 echo "<br /><br />";
 
 echo "<table>";
//echo "<table border=1 id='table1'>";
echo "<table border='1' align='center'>";
//echo "<tr><th colspan='5'>DENR Daily Receipt Check Log</th></tr>";
echo "<tr>"; 
//echo "<th align=left><font color=brown>ORMS Deposit ID</font></th>";
//echo "<th align=left><font color=brown>Controllers Deposit ID</font></th>";  
     
echo "<th align=left><font color=brown>$cash_month</font></th>";
echo "<th align=left><font color=brown>License#</font></th>";
echo "<th align=left><font color=brown>Vehicle#</font></th>";
echo "<th align=left><font color=brown>Driver<br /> (First & Last Name)</font></th>";
echo "<th align=left><font color=brown>Gallons</font></th>";

//echo "<th align=left><font color=brown>ID</font></th>";
             
echo "</tr>";

//$row=mysqli_fetch_array($result);


// The while statement steps through the $result variable one row ($row, which is an array created by mysqli_fetch_array) at a time
//$c=1;
while ($row11=mysqli_fetch_array($result11)){
 
 extract($row11);
 if($gallons=='0.00'){$gallons='';}
 $table_bg2='cornsilk';
 if($c==''){$t=" bgcolor='$table_bg2'";$c=1;}else{$t='';$c='';}
 echo "<tr$t>";
 
 //echo "<td><a href='crs_deposits_cashier_deposit.php?deposit_id=$deposit_id2&GC=$GC' '>Update</a></td>";		   
//echo "<td>$orms_deposit_id</td>";		   
echo "<td>$usage_day</td>";                      
//echo "<td>$checknum</td>";                      
echo "<td>$tag_num</td>";                      
echo "<td>$vehicle_num</td>";  
  echo "<td>$driver_name</td>";                    
 echo "<td>$gallons</td>";                         
 //echo "<td>$id</td>";                         
  
              
//echo "<td>$bank_deposit_date</td>";                      
//echo "<td>$cashier</td>";                      
    
       
              
           
echo "</tr>";




}
/*
 echo "<tr><td></td><td></td><td></td><td><td>Detail Total Debits</td></tr>";
 */
 
 //echo "<tr><td></td><td></td><td>Total Gallons</td><td>$gallons_total</td></tr>";
 
 
 
 
  echo "</table>";
  echo "<br /><br />";
  echo "<table align='center'>";
  echo "<tr><td></td><td></td><td><font color='brown' class='cartRow2'>Total Gallons</td><td>$gallons_total</td></tr>";
  echo "<tr><td></td><td></td><td><font color='brown' class='cartRow2'>Gas Rate-Invoice<a href='$document_location' target='_blank'><img height='25' width='25' src='/budget/infotrack/icon_photos/magnify.png' alt='picture of green check mark'></img></a></td><td>$reimbursement_rate</td></tr>";
 echo "<tr><td></td><td></td><td><font color='brown' class='cartRow2'>Gas Cost</td><td>$gas_cost</td></tr>";
 echo "<tr><td></td><td></td><td><font color='brown' class='cartRow2'>Administrative Fee<br />(12 cents per gallon)</td><td>$administrative_fee</td></tr>";
 echo "<tr><td></td><td></td><td><font color='brown' class='cartRow2'>Park Refund</td><td>$refund_total</td></tr>";
 echo "</table>";
 
  echo "<br /><br />";

  
if($cashier_count=='1')
{  
echo "<form method='post' autocomplete='off' action='fuel_log_approval.php'>";

echo "<table align='center'>";
echo "<tr><th>Cashier: $cashier_first $cashier_last</th><td>Approved:<input type='checkbox' name='cashier_approved' value='y' >";
echo "<input type='hidden' name='parkcode' value='$parkcode'>
<input type='hidden' name='cash_month' value='$cash_month'>
<input type='hidden' name='cash_month_calyear' value='$cash_month_calyear'>
<input type='hidden' name='fyear' value='$fyear'>
<input type='hidden' name='role' value='cashier'>
<input type='submit' name='submit' value='Submit'></td></tr>";

echo "</table>";

echo "</form>";


}

if($manager_count=='1')
{

$query1a="select first_name as 'cashier_first',nick_name as 'cashier_nick',last_name as 'cashier_last',count(id) as 'cashier_count'
          from cash_handling_roles
		  where tempid='$cashier' ";	 

$result1a = mysqli_query($connection, $query1a) or die ("Couldn't execute query 1a.  $query1a");
		  
$row1a=mysqli_fetch_array($result1a);

extract($row1a);



echo "<form method='post' autocomplete='off' action='fuel_log_approval.php'>";


echo "<table align='center'>";
echo "<tr><th>Cashier: $cashier_first $cashier_last</th><td><img height='25' width='25' src='/budget/infotrack/icon_photos/green_checkmark1.png' alt='picture of green check mark'></img></td></tr>";


echo "<tr><th>Manager: $manager_first $manager_last</th><td>Approved:<input type='checkbox' name='manager_approved' value='y'>";

echo "<input type='hidden' name='parkcode' value='$parkcode'>
<input type='hidden' name='cash_month' value='$cash_month'>
<input type='hidden' name='cash_month_calyear' value='$cash_month_calyear'>
<input type='hidden' name='fyear' value='$fyear'>
<input type='hidden' name='role' value='manager'>
<input type='submit' name='submit' value='Submit'></td></tr>";


echo "</table>";
echo "</form>";

}



/*
$query13="SELECT document_location
from fuel_tank_usage
WHERE park='$parkcode' and cash_month='$cash_month' and fyear='$fyear' and cash_month_calyear='$cash_month_calyear'
";
*/


//echo "query13=$query13<br />";

/*
$result13=mysqli_query($connection, $query13) or die ("Couldn't execute query 13. $query13");

$row13=mysqli_fetch_array($result13);

extract($row13);



echo "<table align='center'><tr><td>document_location=$document_location</td></tr></table>";

*/

//echo "</div>";
 
 
 
 //echo "<div style='float:left'>";

 
 
 
 //echo "</div>";
 /*
 $query11="select id,park,center,fyear as 'fiscal_year',cash_month,cash_month_number,cash_month_calyear,tag_num,vehicle_num,vehicle_location,driver_name,gallons,
 usage_day,cashier,cashier_date
 from fuel_tank_usage_detail
 where park='$parkcode' and cash_month='$cash_month' and fyear='$fyear' and cash_month_calyear='$cash_month_calyear'	 ; ";
 */
 
 
 

 //echo "</body></html>";
 
 
 
 
?>