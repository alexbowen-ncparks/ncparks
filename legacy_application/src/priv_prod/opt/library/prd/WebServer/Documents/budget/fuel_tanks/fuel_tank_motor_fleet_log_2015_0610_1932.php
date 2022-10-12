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
 usage_date,cashier,cashier_date
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
 if($tempid=='wagner9210' or $beacnum=='60032781' or $beacnum=='60032793')
 {
 echo "<table align='center'><tr><td><a href='page2_form.php?parkcode=$parkcode&cash_month=$cash_month&fyear=$fyear&cash_month_calyear=$cash_month_calyear&edit=y'>Edit Form</a></td></tr></table>";
 }
 if($edit!='y')
 {
 echo "<div id='table1'>";
 echo "<table border=1 id='table1'>";
//echo "<tr><th colspan='5'>DENR Daily Receipt Check Log</th></tr>";
echo "<tr>"; 
echo "<th align=left><font color=brown>Pump Date</font></th>";
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
echo "<td>$usage_date</td>";                      
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
 usage_date,cashier,cashier_date
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
 usage_date,cashier,cashier_date
 from fuel_tank_usage_detail
 where park='$parkcode' and cash_month='$cash_month' and fyear='$fyear' and cash_month_calyear='$cash_month_calyear'	 ; ";		
		  
		  
		  
//echo "query11=$query11";//exit;
$result14 = mysql_query($query14) or die ("Couldn't execute query 14.  $query14 ");
 $num14=mysql_num_rows($result14);	
 echo "<div>";
// echo "<form>";
 echo "<table border=1 id='table1'>";
//echo "<tr><th colspan='5'>DENR Daily Receipt Check Log</th></tr>";
echo "<tr>"; 
//echo "<th align=left><font color=brown>ORMS Deposit ID</font></th>";
//echo "<th align=left><font color=brown>Controllers Deposit ID</font></th>";  
     
echo "<th align=left><font color=brown>Pump Date</font></th>";
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
   
echo "<td><input type='text' name='usage_date[]' value='$usage_date'></td>";                      
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