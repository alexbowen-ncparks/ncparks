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
 where park='$parkcode' and cash_month='$cash_month' and fyear='$fyear' and cash_month_calyear='$cash_month_calyear'	 ; ";

		 
echo "query11=$query11<br />"; //exit;


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
 if($edit!='y')
 {
 echo "<div id='table1'>";
 echo "<table border=1 id='table1'>";
//echo "<tr><th colspan='5'>DENR Daily Receipt Check Log</th></tr>";
echo "<tr>"; 
echo "<th align=left><font color=brown>Pump Day</font></th>";
echo "<th align=left><font color=brown>License#</font></th>";
//echo "<th align=left><font color=brown>Vehicle#</font></th>";
echo "<th align=left><font color=brown>Driver</font></th>";
echo "<th align=left><font color=brown>Gallons</font></th>";

//echo "<th align=left><font color=brown>Bank<br />Deposit<br />Date</font></th>";
//echo "<th align=left><font color=brown>Cashier</font></th>";
	   
     
      
       
              
echo "</tr>";

//$row=mysql_fetch_array($result);


// The while statement steps through the $result variable one row ($row, which is an array created by mysql_fetch_array) at a time
//$c=1;
while ($row11=mysql_fetch_array($result11)){
 
 extract($row11);
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
  
              
//echo "<td>$bank_deposit_date</td>";                      
//echo "<td>$cashier</td>";                      
    
       
              
           
echo "</tr>";




}
/*
 echo "<tr><td></td><td></td><td></td><td><td>Detail Total Debits</td></tr>";
 echo "<tr><td></td><td></td><td></td><td>$total_check_amount</td><td>Detail Total Credits</tr>";
 */
 
 
  echo "</table>";
 echo "</div>";
 }
 
 $query11="select id,park,center,fyear as 'fiscal_year',cash_month,cash_month_number,cash_month_calyear,tag_num,vehicle_num,vehicle_location,driver_name,gallons,
 usage_day,cashier,cashier_date
 from fuel_tank_usage_detail
 where park='$parkcode' and cash_month='$cash_month' and fyear='$fyear' and cash_month_calyear='$cash_month_calyear'	 ; ";
 
 
 
 
if($edit=='y')
 {
 $system_entry_date=date("Ymd");
 $query12="insert into fuel_tank_usage_detail SET";
 for($j=0;$j<5;$j++){
$query13=$query12;
//$comment_note2=addslashes($comment_note[$j]);
	$query13.=" park='$parkcode', ";
	$query13.=" center='$center', ";
	$query13.=" fyear='$fyear', ";
	$query13.=" cash_month='$cash_month', ";
	$query13.=" cash_month_number='$cash_month_number', ";
	$query13.=" cash_month_calyear='$cash_month_calyear', ";
	$query13.=" cashier='$cashier' ";
//	$query2.=" status='$status[$j]'";
//	$query2.=" where comment_id='$comment_id[$j]'";
		

$result13=mysql_query($query13) or die ("Couldn't execute query 13. $query13");
}	
 

$query14="select id,park,center,fyear as 'fiscal_year',cash_month,cash_month_number,cash_month_calyear,tag_num,vehicle_num,vehicle_location,driver_name,gallons,
 usage_day,cashier,cashier_date
 from fuel_tank_usage_detail
 where park='$parkcode' and cash_month='$cash_month' and fyear='$fyear' and cash_month_calyear='$cash_month_calyear'	 ; ";		
		  
		  
		  
//echo "query11=$query11";//exit;
$result14 = mysql_query($query14) or die ("Couldn't execute query 14.  $query14 ");
 $num14=mysql_num_rows($result14);	
 echo "<div>";
 
 $days = array("01", "02", "03", "04", "05", "06", "07", "08", "09", "10", "11", "12", "13", "14", "15", "16", "17", "18", "19", "20", "21", "22", "23", "24", "25", "26", "27", "28", "29", "30", "31");
 
 
 
 
// echo "<form>";
 echo "<table border=1 id='table1'>";
//echo "<tr><th colspan='5'>DENR Daily Receipt Check Log</th></tr>";
echo "<tr>"; 
//echo "<th align=left><font color=brown>ORMS Deposit ID</font></th>";
//echo "<th align=left><font color=brown>Controllers Deposit ID</font></th>";  
     
echo "<th align=left><font color=brown>$cash_month</font></th>";
echo "<th align=left><font color=brown>License#</font></th>";
//echo "<th align=left><font color=brown>Vehicle#</font></th>";
echo "<th align=left><font color=brown>Driver</font></th>";
echo "<th align=left><font color=brown>Gallons</font></th>";

echo "<th align=left><font color=brown>ID</font></th>";
             
echo "</tr>";

//echo  "<form method='post' autocomplete='off' action='check_listing_update.php'>";
echo  "<form method='post' autocomplete='off' action='fuel_log_update.php'>";

while ($row14=mysql_fetch_array($result14)){
 
 extract($row14);
 $table_bg2='cornsilk';
 if($c==''){$t=" bgcolor='$table_bg2'";$c=1;}else{$t='';$c='';}
 echo "<tr$t>";
 
 //echo "<td><a href='crs_deposits_cashier_deposit.php?deposit_id=$deposit_id2&GC=$GC' '>Update</a></td>";		   
//echo "<td>$orms_deposit_id</td>";	
   
//echo "<td><input type='text' name='usage_day[]' value='$usage_day'></td>"; 

/* 
echo "<td><select name='range_day_start[]'><option></option>";

echo "<option value='01'"; if($range_day_start=='01'){echo "selected";}echo ">01</option>";
echo "<option value='02'"; if($range_day_start=='02'){echo "selected";}echo ">02</option>";
echo "<option value='03'"; if($range_day_start=='03'){echo "selected";}echo ">03</option>";
echo "<option value='04'"; if($range_day_start=='04'){echo "selected";}echo ">04</option>";
echo "<option value='05'"; if($range_day_start=='05'){echo "selected";}echo ">05</option>";
echo "<option value='06'"; if($range_day_start=='06'){echo "selected";}echo ">06</option>";
echo "<option value='07'"; if($range_day_start=='07'){echo "selected";}echo ">07</option>";
echo "<option value='08'"; if($range_day_start=='08'){echo "selected";}echo ">08</option>";
echo "<option value='09'"; if($range_day_start=='09'){echo "selected";}echo ">09</option>";
echo "<option value='10'"; if($range_day_start=='10'){echo "selected";}echo ">10</option>";
echo "<option value='11'"; if($range_day_start=='11'){echo "selected";}echo ">11</option>";
echo "<option value='12'"; if($range_day_start=='12'){echo "selected";}echo ">12</option>";
echo "<option value='13'"; if($range_day_start=='13'){echo "selected";}echo ">13</option>";
echo "<option value='14'"; if($range_day_start=='14'){echo "selected";}echo ">14</option>";
echo "<option value='15'"; if($range_day_start=='15'){echo "selected";}echo ">15</option>";
echo "<option value='16'"; if($range_day_start=='16'){echo "selected";}echo ">16</option>";
echo "<option value='17'"; if($range_day_start=='17'){echo "selected";}echo ">17</option>";
echo "<option value='18'"; if($range_day_start=='18'){echo "selected";}echo ">18</option>";
echo "<option value='19'"; if($range_day_start=='19'){echo "selected";}echo ">19</option>";
echo "<option value='20'"; if($range_day_start=='20'){echo "selected";}echo ">20</option>";
echo "<option value='21'"; if($range_day_start=='21'){echo "selected";}echo ">21</option>";
echo "<option value='22'"; if($range_day_start=='22'){echo "selected";}echo ">22</option>";
echo "<option value='23'"; if($range_day_start=='23'){echo "selected";}echo ">23</option>";
echo "<option value='24'"; if($range_day_start=='24'){echo "selected";}echo ">24</option>";
echo "<option value='25'"; if($range_day_start=='25'){echo "selected";}echo ">25</option>";
echo "<option value='26'"; if($range_day_start=='26'){echo "selected";}echo ">26</option>";
echo "<option value='27'"; if($range_day_start=='27'){echo "selected";}echo ">27</option>";
echo "<option value='28'"; if($range_day_start=='28'){echo "selected";}echo ">28</option>";
echo "<option value='29'"; if($range_day_start=='29'){echo "selected";}echo ">29</option>";
echo "<option value='30'"; if($range_day_start=='30'){echo "selected";}echo ">30</option>";
echo "<option value='31'"; if($range_day_start=='31'){echo "selected";}echo ">31</option>";

echo "</select>
<br />$usage_day</td>";
*/
  

 echo "<td>";
 
 echo "<select name=\"dayofmonth[]\"><option value=''></option>";

for ($n=0;$n<count($days);$n++){
$con=$days[$n];
if($usage_day==$con){$s="selected";}else{$s="value";}
//$s="value";
		echo "<option $s='$con'>$days[$n]</option>\n";
       }

echo "</select>";
echo "</td>";





  
//echo "<td><input type='text'   name='usage_date[]' id='datepicker' size='15'></td>";                   
echo "<td><input type='text' name='tag_num[]' value='$tag_num'></td>";                      
//echo "<td><input type='text' name='vehicle_num[]' value='$vehicle_num'></td>";
echo "<td><input type='text' name='driver_name[]' value='$driver_name'></td>";                       
echo "<td><input type='text' name='gallons[]' value='$gallons'></td>"; 
 echo "<td><input type='text' name='id[]' value='$id' readonly='readonly'></td>"; 	                   
//echo "<td>$checknum</td>";                      
  
              
//echo "<td>$bank_deposit_date</td>";                      
//echo "<td>$cashier</td>";                      
    
       
              
           
echo "</tr>";




}

echo "<tr><td colspan='8' align='right'><input type='submit' name='submit2' value='Update'></td></tr>";
//echo "<input type='hidden' name='project_note_id' value='$project_note_id'>";
echo "<input type='hidden' name='num14' value='$num14'>";
echo "<input type='hidden' name='ctdd_id' value='$ctdd_id'>";
 //echo "<tr><td></td><td></td><td></td><td><td>Detail Total Debits</td></tr>";
 //echo "<tr><td></td><td></td><td></td><td>$total_check_amount</td><td>Detail Total Credits</tr>";
  echo "</table>";
 echo "</div>";
 echo "</form>";
 //echo "<pre>";print_r($checknum);"</pre>";//exit;
 }
 echo "</body></html>";
 
 
 
 
?>