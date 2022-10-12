 <?php

session_start();
//echo "fuel_tank_motor_fleet_log<br /><br />";

if (!$_SESSION["budget"]["tempID"]) {echo "Access denied";exit;}
$active_file=$_SERVER['SCRIPT_NAME'];

$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempid=$_SESSION['budget']['tempID'];
$beacnum=$_SESSION['budget']['beacon_num'];
$concession_location=$_SESSION['budget']['select'];
$concession_center=$_SESSION['budget']['centerSess'];
$concession_center_new=$_SESSION['budget']['centerSess_new'];
extract($_REQUEST);
//$system_entry_date=date("Ymd");
//$today_date=$system_entry_date;
if($concession_location=='ADM'){$concession_location='ADMI';}
$today=date("Ymd", time() );
if($today_date == ''){$today_date=$today;}
$previous_date=date("Ymd",strtotime($today_date)- 60 * 60 * 24);
$next_date=date("Ymd",strtotime($today_date)+ 60 * 60 * 24);

//echo "concession_center=$concession_center<br /><br />";
//echo "concession_center_new=$concession_center_new<br /><br />"; exit;

//if($report_type=='day'){$period=" and transdate_new='$today_date' ";}







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




$query11="SELECT transdate_new as 'transaction_date',payment_type,product_name,amount,account_name,ncas_account,sed,comment
from crs_tdrr_division_history_parks_manual
where concession_location='$concession_location'
and deposit_transaction='n' 
and amount != '0.00'
order by id asc "; 

	
//echo "query11=$query11<br />"; //exit;


$result11 = mysqli_query($connection, $query11) or die ("Couldn't execute query 11.  $query11 ");
$num11=mysqli_num_rows($result11);	
 
 
 //$result5 = mysqli_query($connection, $query5) or die ("Couldn't execute query 5.  $query5");
//$num5=mysqli_num_rows($result5);
 
 
 
 echo "<html>";
echo "<head>
<title>MoneyTracker</title>";


//include ("test_style.php");

echo "<style>";
echo "#table1{
width:800px;
	margin-left:auto; 
    margin-right:auto;
	}";
echo "</style>";

echo "</head>";

include("../../budget/menu1314_tony.html");
 include("../../budget/infotrack/slide_toggle_procedures_module2_pid68.php");
//include ("../../budget/menu1415_v1.php");

 echo "<br />";
 echo "<br />";
 
 


$query11a="SELECT sum(amount) as 'total_sales',count(id) as 'record_count'
from crs_tdrr_division_history_parks_manual
WHERE concession_location='$concession_location'
and deposit_transaction='n'
and transdate_new <= '$today_date' 
";


$result11a=mysqli_query($connection, $query11a) or die ("Couldn't execute query 11a. $query11a");

$row11a=mysqli_fetch_array($result11a);

extract($row11a);
 
 
 
 $query11a="SELECT sum(amount) as 'day_sales',count(id) as 'record_count'
from crs_tdrr_division_history_parks_manual
WHERE concession_location='$concession_location'
and deposit_transaction='n' 
and transdate_new='$today_date'
";


$result11a=mysqli_query($connection, $query11a) or die ("Couldn't execute query 11a. $query11a");

$row11a=mysqli_fetch_array($result11a);

extract($row11a);
 
 
 
 
if($edit=='y' or $record_count=='0')
 {
 
 $query11b="delete from crs_tdrr_division_history_parks_manual
            where concession_location='$concession_location'
			and amount='0.00'
			and deposit_transaction='n'
 ";
 
$result11b = mysqli_query($connection, $query11b) or die ("Couldn't execute query 11b.  $query11b");


$query11c="SELECT count(id) as 'record_count'
FROM crs_tdrr_division_deposits_manual
WHERE park = '$concession_location' and deposit_complete='y'
 ";
 
 //echo "query11c=$query11c<br /><br />";
 //echo "cashier_count=$cashier_count<br /><br />";
 //echo "manager_count=$manager_count<br /><br />";
$result11c = mysqli_query($connection, $query11c) or die ("Couldn't execute query 11c.  $query11c");

$row11c=mysqli_fetch_array($result11c);
extract($row11c);//brings back number of records paid by check

if($record_count==0)

{
$manual_deposit_id=$concession_location.'1000';
//echo "Line 347 manual_deposit_id=$manual_deposit_id<br /><br />";
}

if($record_count!=0)

{

$query11d="
SELECT CONCAT( '$concession_location', MAX( MID( manual_deposit_id, 5, 4 ) ) +1 ) as 'manual_deposit_id' 
FROM  `crs_tdrr_division_deposits_manual` 
WHERE park = '$concession_location' and deposit_complete='y'
 ";
 
 //echo "query11d=$query11d<br /><br />";
 
$result11d = mysqli_query($connection, $query11d) or die ("Couldn't execute query 11d.  $query11d");

$row11d=mysqli_fetch_array($result11d);
extract($row11d);//brings back number of records paid by check


//echo "Line 366 manual_deposit_id=$manual_deposit_id<br /><br />";


}




//echo "manual_deposit_id=$manual_deposit_id<br /><br />";




// $system_entry_date=date("Ymd");
 $query12="insert into crs_tdrr_division_history_parks_manual SET";
 for($j=0;$j<10;$j++){
$query13=$query12;
//$comment_note2=addslashes($comment_note[$j]);
	$query13.=" concession_location='$concession_location', ";
	if($level==1){$query13.=" center='$concession_center', ";}
	if($level==1){$query13.=" new_center='$concession_center_new', ";}
	$query13.=" manual_deposit_id='$manual_deposit_id', ";
	$query13.=" sed='$system_entry_date', ";
	$query13.=" transdate_new='$system_entry_date', ";
	$query13.=" cashier='$tempid' ";
//	$query2.=" status='$status[$j]'";
//	$query2.=" where comment_id='$comment_id[$j]'";
		

$result13=mysqli_query($connection, $query13) or die ("Couldn't execute query 13. $query13");
}	
 

$query13a="insert ignore into crs_deposit_counts(concession_location,manual_deposit_id,sales_location)
select '$concession_location','$manual_deposit_id',location_name
from crs_locations
where park_code='$concession_location' ";
 
 
$result13a=mysqli_query($connection, $query13a) or die ("Couldn't execute query 13a. $query13a");
 
$query13b="insert ignore into crs_tdrr_division_deposits_manual(park,manual_deposit_id)
select '$concession_location','$manual_deposit_id'
 ";
 
 
$result13b=mysqli_query($connection, $query13b) or die ("Couldn't execute query 13b. $query13b"); 
 
 
 
$query14="SELECT transdate_new as 'transaction_date',payment_type,product_name,amount,account_name,ncas_account,sed,center,sales_location,comment,id
from crs_tdrr_division_history_parks_manual
where concession_location='$concession_location'
and deposit_transaction='n' 
and transdate_new='$today_date'
order by id asc ";
  
//echo "query14=$query14<br /><br />";		  
		  
//echo "query11=$query11";//exit;
$result14 = mysqli_query($connection, $query14) or die ("Couldn't execute query 14.  $query14 ");
 $num14=mysqli_num_rows($result14);	
 echo "<div>";
 
 $today_date2=date('m-d-y', strtotime($today_date));
 $min_date2=date('m-d-y', strtotime($mindate));
 
 
$today_date_dow=date('l',strtotime($today_date));
if($day_sales==''){$day_sales='0.00';}
echo "<table align='center'>
<tr><th><br /><a href='/budget/cash_sales/page2_form.php?step=1&edit=y&today_date=$previous_date' title='previous day'><<</a>$today_date_dow $today_date2<a href='/budget/cash_sales/page2_form.php?step=1&edit=y&today_date=$next_date' title='next day'>>></a><br /><font color='blue'>$day_sales collected </font></th></tr>
</table>";
echo "<br />";
 
 
if($today_date==$today)
 {
 //include("cash_sales_total_header.php");
 //echo "total_sales=$total_sales<br /><br />";
 
 $days_elapsed_message=" collected over $diffdate2 days from $min_date2 thru $today_date2";
 
 if($diffdate2 > 6 or $total_sales >= '250.00'){$deposit_message="(Deposit Required)";}
 //echo "deposit_message=$deposit_message<br /><br />";
 
 echo "<table align='center'>
 <tr bgcolor='cornsilk'><td><font color='blue'>$total_sales $days_elapsed_message</font><font color='red'> $deposit_message</font></td></tr></table>";

}

 $days = array("01", "02", "03", "04", "05", "06", "07", "08", "09", "10", "11", "12", "13", "14", "15", "16", "17", "18", "19", "20", "21", "22", "23", "24", "25", "26", "27", "28", "29", "30", "31");
include("products_menu.php"); // Tag Array from Fuel Database
include("payments_menu.php"); // Tag Array from Fuel Database
if($fs_approver_count == 1)
{
include("centers_menu.php"); // Tag Array from Fuel Database
}
if($fs_approver_count != 1)
{
include("locations_menu.php"); // Tag Array from Fuel Database
}
//echo "<pre>"; print_r($centerArray); echo "</pre>";//exit;
 
 
 
// echo "<form>";
 echo "<table border=1 id='table1'>";
//echo "<tr><th colspan='5'>DENR Daily Receipt Check Log</th></tr>";
echo "<tr>"; 
//echo "<th align=left><font color=brown>ORMS Deposit ID</font></th>";
//echo "<th align=left><font color=brown>Controllers Deposit ID</font></th>";  
 echo "<th align=left><font color=brown>EntryDate</font></th>"; 
 if($fs_approver_count != 1)
 {
 echo "<th align=left><font color=brown>Location</font></th>";
 }
 if($fs_approver_count==1)
 {
 echo "<th align=left><font color=brown>Center</font></th>";
 }
echo "<th align=left><font color=brown>PaymentType</font></th>";
echo "<th align=left><font color=brown>SaleType</font></th>";
//echo "<th align=left><font color=brown>Vehicle#</font></th>";
echo "<th align=left><font color=brown>Amount</font></th>";
echo "<th align=left><font color=brown>Comment</font></th>";

             
echo "</tr>";

//echo  "<form method='post' autocomplete='off' action='check_listing_update.php'>";
//echo  "<form method='post' autocomplete='off' action='fuel_log_update.php'>";
echo  "<form method='post' autocomplete='off' action='transaction_detail_manual_update2.php'>";

while ($row14=mysqli_fetch_array($result14)){
 
 extract($row14);
 //$sed2=date('m-d-y', strtotime($sed));
 $transaction_date2=date('m-d-y', strtotime($transaction_date));
 
 if($amount=='0.00'){$amount='';}
 if($amount==''){$sed2='';}
 $table_bg2='cornsilk';
 if($c==''){$t=" bgcolor='$table_bg2'";$c=1;}else{$t='';$c='';}
 echo "<tr$t>";
 

echo "<td>$transaction_date2</td>"; 
//echo "<td><textarea name='payment_type[]' cols='20' rows='2'>$payment_type</textarea></td> ";                  
//echo "<td><textarea name='account_name[]' cols='40' rows='2'>$account_name</textarea></td> "; 


if($fs_approver_count != 1)
{
echo "<td>";
 
 echo "<select name=\"location_name[]\"><option value=''></option>";

for ($n=0;$n<count($locationArray);$n++){
$con=$locationArray[$n];
if($sales_location==$con){$s="selected";}else{$s="value";}
//$s="value";
		echo "<option $s='$con'>$locationArray[$n]</option>\n";
       }

echo "</select>";
echo "</td>";
}
if($fs_approver_count==1)
{
//echo "<td>";
echo "<td><input type='text' name='center[]' autocomplete='off' value='$center'><br />";
echo "<select name=\"center_name[]\"><option value=''></option>";

for ($n=0;$n<count($centerArray);$n++){
$con=$centerArray[$n];
//if($sales_location==$con){$s="selected";}else{$s="value";}
//echo "<option $s='$con'>$locationArray[$n]</option>\n";
echo "<option>$centerArray[$n]</option>\n";
       }

echo "</select>";
echo "</td>"; 
//echo "Input Box";
//echo "</td>";


}


echo "<td>";
 
 echo "<select name=\"payment_type[]\"><option value=''></option>";

for ($n=0;$n<count($paymentArray);$n++){
$con=$paymentArray[$n];
if($payment_type==$con){$s="selected";}else{$s="value";}
//$s="value";
		echo "<option $s='$con'>$paymentArray[$n]</option>\n";
       }

echo "</select>";
echo "</td>";


echo "<td>";
 
 echo "<select name=\"product_name[]\"><option value=''></option>";

for ($n=0;$n<count($tagArray);$n++){
$con=$tagArray[$n];
if($product_name==$con){$s="selected";}else{$s="value";}
//$s="value";
		echo "<option $s='$con'>$tagArray[$n]</option>\n";
       }

echo "</select>";
echo "</td>";



                 
//echo "<td><input type='text' name='account_name[]' autocomplete='off' value='$account_name'></td>"; 
echo "<td><input type='text' name='amount[]' autocomplete='off' value='$amount'></td>"; 
//echo "<td><input type='text' name='comment[]' autocomplete='off' value='$comment'></td>"; 
echo "<td><textarea name='comment[]' cols='30' rows='2' placeholder='Optional Comment'>$comment</textarea></td> "; 

 echo "<td><input type='hidden' name='id[]' value='$id' ></td>";
echo "<input type='hidden' name='fs_approver_count' value='$fs_approver_count'>";  

 
//echo "<td>$checknum</td>";                      
  
              
//echo "<td>$bank_deposit_date</td>";                      
//echo "<td>$cashier</td>";                      
    
       
              
           
echo "</tr>";




}
if($cashier_count==1)
{
echo "<tr><td colspan='8' align='right'><input type='submit' name='submit2' value='Update'></td></tr>";
}

if($fs_approver_count==1)
{
echo "<tr><td colspan='8' align='right'><input type='submit' name='submit2' value='Update'></td></tr>";
}


//echo "<input type='hidden' name='project_note_id' value='$project_note_id'>";
echo "<input type='hidden' name='num14' value='$num14'>";

  echo "</table>";
 echo "</div>";
 echo "</form>";
 //echo "<pre>";print_r($checknum);"</pre>";//exit;
 }
 echo "</body></html>";
 
 
 
 
?>