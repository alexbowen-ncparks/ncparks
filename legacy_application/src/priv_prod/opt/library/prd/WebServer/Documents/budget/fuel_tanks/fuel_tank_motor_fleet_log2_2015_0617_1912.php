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
include("/opt/library/prd/WebServer/include/connectROOT.inc"); // connection parameters
mysql_select_db($database, $connection); // database


$query11="select id,park,center,fyear as 'fiscal_year',cash_month,cash_month_number,cash_month_calyear,tag_num,vehicle_num,vehicle_location,driver_name,gallons,
 usage_day,cashier,cashier_date
 from fuel_tank_usage_detail
 where park='$parkcode' and cash_month='$cash_month' and fyear='$fyear' and cash_month_calyear='$cash_month_calyear'
 order by id asc ; ";

	
	
//echo "query11=$query11<br />"; //exit;


$result11 = mysql_query($query11) or die ("Couldn't execute query 11.  $query11 ");
 $num11=mysql_num_rows($result11);	
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

$result11a=mysql_query($query11a) or die ("Couldn't execute query 11a. $query11a");

$row11a=mysql_fetch_array($result11a);

extract($row11a);
 
 //echo "query11a=$query11a<br />";
 
 //echo "record_count=$record_count<br />"; //exit;
 
 
 
 
 
  
 /*
 
 if($tempid=='wagner9210' or $beacnum=='60032781' or $beacnum=='60032793')
 {

 
 echo "<table align='center'><tr><td><a href='page2_form.php?parkcode=$parkcode&cash_month=$cash_month&fyear=$fyear&cash_month_calyear=$cash_month_calyear&edit=y&step=3'>Edit Form</a></td></tr></table>";
 
  
 }
 
 */
 
 //echo "<div id='table1'>";
 echo "<table>";
//echo "<table border=1 id='table1'>";
echo "<table border='1' align='center'>";
//echo "<tr><th colspan='5'>DENR Daily Receipt Check Log</th></tr>";
echo "<tr>"; 
//echo "<th align=left><font color=brown>ORMS Deposit ID</font></th>";
//echo "<th align=left><font color=brown>Controllers Deposit ID</font></th>";  
     
echo "<th align=left><font color=brown>$cash_month</font></th>";
echo "<th align=left><font color=brown>License#</font></th>";
//echo "<th align=left><font color=brown>Vehicle#</font></th>";
echo "<th align=left><font color=brown>Driver<br /> (First & Last Name)</font></th>";
echo "<th align=left><font color=brown>Gallons</font></th>";

echo "<th align=left><font color=brown>ID</font></th>";
             
echo "</tr>";

//$row=mysql_fetch_array($result);


// The while statement steps through the $result variable one row ($row, which is an array created by mysql_fetch_array) at a time
//$c=1;
while ($row11=mysql_fetch_array($result11)){
 
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
//echo "<td>$vehicle_num</td>";  
  echo "<td>$driver_name</td>";                    
 echo "<td>$gallons</td>";                         
 echo "<td>$id</td>";                         
  
              
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
  echo "<tr><td></td><td></td><td><font color='brown' class='cartRow2'>Gas Rate</td><td>3.4114</td></tr>";
 echo "<tr><td></td><td></td><td><font color='brown' class='cartRow2'>Gas Cost</td><td>125.37</td></tr>";
 echo "<tr><td></td><td></td><td><font color='brown' class='cartRow2'>Administrative Fee</td><td>15.04</td></tr>";
 echo "<tr><td></td><td></td><td><font color='brown' class='cartRow2'>Refund Total</td><td>140.41</td></tr>";
 echo "</table>";
 
  
  
  
 echo "</div>";
 
 
 
 /*
 $query11="select id,park,center,fyear as 'fiscal_year',cash_month,cash_month_number,cash_month_calyear,tag_num,vehicle_num,vehicle_location,driver_name,gallons,
 usage_day,cashier,cashier_date
 from fuel_tank_usage_detail
 where park='$parkcode' and cash_month='$cash_month' and fyear='$fyear' and cash_month_calyear='$cash_month_calyear'	 ; ";
 */
 
 
 

 echo "</body></html>";
 
 
 
 
?>