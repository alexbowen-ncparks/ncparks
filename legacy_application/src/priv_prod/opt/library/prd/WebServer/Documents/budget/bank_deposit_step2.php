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
if($concession_location=='ADM'){$concession_location='ADMI';}
extract($_REQUEST);
$system_entry_date=date("Ymd");
$today_date=$system_entry_date;
//$ctdd_id=$id;
//echo "ctdd_id=$ctdd_id<br />";
//echo $concession_location;

//echo "<pre>";print_r($_SERVER);"</pre>";//exit;
//echo "<pre>";print_r($_SESSION);"</pre>";//exit;
//echo "<pre>";print_r($_REQUEST);"</pre>"; //exit;

//echo "<pre>";print_r($_SESSION);"</pre>";exit;
$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database




$query12b="SELECT min(transdate_new) as 'mindate',max(transdate_new) as 'maxdate'
 from crs_tdrr_division_history_parks_manual
 WHERE 1 and concession_location='$concession_location'
 and deposit_transaction='n'
 and amount != '0.00'
 ";
 
$result12b = mysqli_query($connection, $query12b) or die ("Couldn't execute query 12b.  $query12b");

$row12b=mysqli_fetch_array($result12b);
extract($row12b);//brings back number of records paid by check

$query12c="SELECT datediff('$today_date','$mindate') as 'diffdate'
 ";
 
$result12c = mysqli_query($connection, $query12c) or die ("Couldn't execute query 12c.  $query12c");

$row12c=mysqli_fetch_array($result12c);
extract($row12c);//brings back number of records paid by check
$diffdate2=$diffdate+1;

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


echo "<link rel=\"stylesheet\" href=\"/js/jquery_1.10.3/jquery-ui.css\" />
<script src=\"/js/jquery_1.10.3/jquery-1.9.1.js\"></script>
<script src=\"/js/jquery_1.10.3/jquery-ui.js\"></script>
<link rel=\"stylesheet\" href=\"/resources/demos/style.css\" />";
//echo "<link rel=\"stylesheet\" href=\"test_style_1657.css\" />";
echo "<link rel='stylesheet' type='text/css' href='1533d.css' />";

echo "
<script>
$(function() {
$( \"#datepicker\" ).datepicker({dateFormat: 'yy-mm-dd'});
});
</script>";









echo "</head>";

include("../../budget/menu1314_tony.html");

/*
  echo "<table align='center' bgcolor='cornsilk'>
 <tr><th style='text-align:center'>Cash Handling Procedures2</th></tr>
 <tr><td style='text-align:left'><li><font color='blue'>All \"monies & receipts\" are delivered directly to the</font> <font color='red'>Deposit Cashier</font><font color='blue'> on the same day collected</font></li></td></tr>
 <tr><td style='text-align:left'><li><font color='blue'>If Park Office is closed, \"monies & receipts\" are delivered to a \"lock & key\" location under the control of the</font><font color='red'> Deposit Cashier</font></li></td></tr>
 <tr><td style='text-align:left'><li><font color='red'>Deposit Cashier</font><font color='blue'> verifies accuracy of monies received from each Sales Location</font></li></td></tr> 
 <tr><td style='text-align:left'><li><font color='red'>Deposit Cashier</font><font color='blue'> enters \"Sales info\" into form on a daily basis</font></li></td></tr>
 <tr><td style='text-align:left'><li><font color='red'>Deposit Cashier</font><font color='blue'> secures all \"monies & receipts\" under \"lock & key\" until Bank Deposit</font></li></td></tr> 
 <tr><td style='text-align:left'><li><font color='red'>Deposit Cashier</font><font color='blue'> prepares bank deposit slip & delivers \"monies & slip\" to</font><font color='red'> Ranger</font><font color='blue'> for Bank Deposit</font></li></td></tr>
 <tr><td style='text-align:left'><li><font color='red'>Deposit Cashier</font><font color='blue'> completes Cash Receipts Journal & submits for </font><font color='red'> Manager</font><font color='blue'> Approval</font></li></td></tr>
 <tr><td style='text-align:left'><li><font color='red'>Manager</font><font color='blue'> approves Cash Receipts Journal within 2 business days of Bank Deposit </font></li></td></tr>
 </table>";
 echo "<br />";
 */
//$edit='y';
 
 if($depid != '')
{
echo "<table align='center'><tr><th><img height='25' width='25' src='/budget/infotrack/icon_photos/green_checkmark1.png' alt='picture of green check mark'></img>Deposit created for $depamt Click on Step3 to complete the Cash Receipts Journal</th></tr></table>"; exit; 

}
 
if($edit=='y')
 {
 /*
 $query11b=" ";
 
$result11b = mysqli_query($connection, $query11b) or die ("Couldn't execute query 11b.  $query11b");


$query11c=" ";
 
 echo "query11c=$query11c<br /><br />";
 echo "cashier_count=$cashier_count<br /><br />";
 echo "manager_count=$manager_count<br /><br />";
$result11c = mysqli_query($connection, $query11c) or die ("Couldn't execute query 11c.  $query11c");

$row11c=mysqli_fetch_array($result11c);
extract($row11c);//brings back number of records paid by check

*/
/*
$query13a="SELECT manual_deposit_id,sum(amount) as 'cash_total'
 from crs_tdrr_division_history_parks_manual
 WHERE 1 and concession_location='$concession_location'
 and deposit_transaction='n'
 and amount != '0.00'
 and payment_type='cash'
 ";
 
$result13a = mysqli_query($connection, $query13a) or die ("Couldn't execute query 13a.  $query13a");

$row13a=mysqli_fetch_array($result13a);
extract($row13a);//brings back number of records paid by check

echo "cash_total=$cash_total for manual_deposit_id=$manual_deposit_id<br /><br />";


$query13b="SELECT manual_deposit_id,sum(amount) as 'check_total'
 from crs_tdrr_division_history_parks_manual
 WHERE 1 and concession_location='$concession_location'
 and deposit_transaction='n'
 and amount != '0.00'
 and payment_type='check'
 ";
 
$result13b = mysqli_query($connection, $query13b) or die ("Couldn't execute query 13b.  $query13b");

$row13b=mysqli_fetch_array($result13b);
extract($row13b);//brings back number of records paid by check

echo "check_total=$check_total for manual_deposit_id=$manual_deposit_id<br /><br />";

*/

$query13a="SELECT sales_location,manual_deposit_id,sum(amount) as 'total_amount'
from crs_tdrr_division_history_parks_manual
where concession_location='$concession_location'
and deposit_transaction='n' 
and amount != '0.00'
group by sales_location
order by sales_location asc ";
  
		  
		  
//echo "query13a=$query13a<br /><br />";//exit;
$result13a = mysqli_query($connection, $query13a) or die ("Couldn't execute query 13a.  $query13a ");
 $num13a=mysqli_num_rows($result13a);

while ($row13a=mysqli_fetch_array($result13a)){
 
extract($row13a);

$query13b="update crs_deposit_counts
           set sales_total='$total_amount'
		   where manual_deposit_id='$manual_deposit_id'
           and sales_location='$sales_location'  ";
	

//echo "query13b=$query13b<br ><br />";//exit;
	
		   
$result13b = mysqli_query($connection, $query13b) or die ("Couldn't execute query 13b.  $query13b ");


}

//exit;


$query14="SELECT manual_deposit_id,sales_location,sales_total as 'total_amount',cash_total as 'cash_amount',check_total as 'check_amount',grand_total,adjustment
from crs_deposit_counts
where concession_location='$concession_location'
and manual_deposit_id='$manual_deposit_id' ";
  
		  
		  
//echo "query11=$query11";//exit;
$result14 = mysqli_query($connection, $query14) or die ("Couldn't execute query 14.  $query14 ");
 $num14=mysqli_num_rows($result14);



 
 echo "<div>";



 
//include("products_menu.php"); // Tag Array from Fuel Database
//include("payments_menu.php"); // Tag Array from Fuel Database
//include("locations_menu.php"); // Tag Array from Fuel Database
//echo "<pre>"; print_r($paymentArray); echo "</pre>";//exit;
 
 if($update1 != 'y')
 {
 
 
 
 echo "<table align='center'><tr><th><font size='6'>Count Monies for Bank Deposit</font></th></tr></table>";
 echo "<br />";
// echo "<form>";
 echo "<table border=1 id='table1'>";
//echo "<tr><th colspan='5'>DENR Daily Receipt Check Log</th></tr>";
echo "<tr>"; 
//echo "<th align=left><font color=brown>ORMS Deposit ID</font></th>";
//echo "<th align=left><font color=brown>Controllers Deposit ID</font></th>";  
 echo "<th align=left><font color=brown>Location</font></th>"; 
 
echo "<th align=left><font color=brown>Cash</font></th>";
echo "<th align=left><font color=brown>Check</font></th>";
//echo "<th align=left><font color=brown>Total Money</font></th>";
//echo "<th align=left><font color=brown>Total Sales</font></th>";
//if($update1=='y'){echo "<th align=left><font color=brown>CheckCount</font></th>";}
/*
//echo "<th align=left><font color=brown>Vehicle#</font></th>";
echo "<th align=left><font color=brown>DepositAdjustment</font></th>";
echo "<th align=left><font color=brown>Comment</font></th>";
*/
             
echo "</tr>";

//echo  "<form method='post' autocomplete='off' action='check_listing_update.php'>";
//echo  "<form method='post' autocomplete='off' action='fuel_log_update.php'>";
//echo  "<form method='post' autocomplete='off' action='transaction_detail_manual_update2.php'>";
echo  "<form method='post' autocomplete='off' action='bank_deposit_step2_update.php'>";

while ($row14=mysqli_fetch_array($result14)){
 
 extract($row14);
 
 $location_total=number_format(($cash_amount+$check_amount),2);
 $total_count+=$location_total;
 
 $total_sales+=$total_amount;
 if($adjustment=='0.00'){$adjustment_icon="<img height='40' width='40' src='/budget/infotrack/icon_photos/green_checkmark1.png' alt='picture of home'></img>";}
 
 
 if($adjustment!='0.00'){$adjustment_icon="<img height='40' width='40' src='/budget/infotrack/icon_photos/xmark1.png' alt='picture of home'></img>";}
 
 
 
 
 //if($cash_amount=='0.00'){$cash_amount='';}
 //if($check_amount=='0.00'){$check_amount='';}
 /*
 //$sed2=date('m-d-y', strtotime($sed));
 $transaction_date2=date('m-d-y', strtotime($transaction_date));
 
 if($amount=='0.00'){$amount='';}
 if($amount==''){$sed2='';}
 */
 
 $table_bg2='lightcyan';
 if($c==''){$t=" bgcolor='$table_bg2'";$c=1;}else{$t='';$c='';}
 echo "<tr$t>";
 
 
echo "<td>$sales_location</td>"; 

//echo "<td><textarea name='payment_type[]' cols='20' rows='2'>$payment_type</textarea></td> ";                  
//echo "<td><textarea name='account_name[]' cols='40' rows='2'>$account_name</textarea></td> "; 


//echo "<td><input type='text' name='account_name[]' autocomplete='off' value='$account_name'></td>"; 
//echo "<td><input type='text' name='cash_amount[]' autocomplete='off' placeholder='cash total' value='$cash_amount' ></td>"; 
//echo "<td><input type='text' name='check_amount[]' autocomplete='off' placeholder='check total' value='$check_amount' ></td>"; 

echo "<td><input type='text' name='cash_amount[]' autocomplete='off'  value='$cash_amount' ></td>"; 
echo "<td><input type='text' name='check_amount[]' autocomplete='off'  value='$check_amount' ></td>"; 
//echo "<td>$location_total</td>";
//echo "<td>$total_amount</td>"; 
/*
if($update1=='y')
{
echo "<td>$adjustment_icon</td>";
//if($adjustment!='0.00'){echo "<td><form><input type='text'></form></td>";}

}
*/

//echo "<td><input type='text' name='comment[]' autocomplete='off' value='$comment'></td>"; 
//echo "<td><textarea name='comment[]' cols='30' rows='2' placeholder='Optional Comment'>$comment</textarea></td> ";   
 //echo "<td><input type='hidden' name='id[]' value='$id' ></td>"; 	                   
//echo "<td>$checknum</td>";                      
echo "<input type='hidden' name='sales_location[]' value='$sales_location'>";  
echo "<input type='hidden' name='total_amount[]' value='$total_amount'>";  
              
//echo "<td>$bank_deposit_date</td>";                      
//echo "<td>$cashier</td>";                      
    
       
              
           
echo "</tr>";




}

//if($cashier_count==1){
echo "<tr><td colspan='8' align='right'><input type='submit' name='submit' value='Update1'></td></tr>";
//}
echo "<input type='hidden' name='step' value='2'>";
echo "<input type='hidden' name='manual_deposit_id' value='$manual_deposit_id'>";
echo "<input type='hidden' name='num14' value='$num14'>";
echo "</div>";
 echo "</form>";

/*
$total_count=number_format($total_count,2);
$total_sales=number_format($total_sales,2);
$oob=number_format(($total_count-$total_sales),2);
if($oob==0){$oob_message="Total Money of $total_count for Deposit for is CORRECT <img height='40' width='40' src='/budget/infotrack/icon_photos/green_checkmark1.png' alt='picture of home'></img>";}
if($oob<0){$oob_message="Total Money of $total_count for Deposit is SHORT by $oob <img height='40' width='40' src='/budget/infotrack/icon_photos/xmark1.png' alt='picture of home'></img><br /><br /><form action=''><input type='text' placeholder='Enter Comment'><input type='submit' name='comment_update' value='Add Comment'></form> ";}
if($oob>0){$oob_message="Total Money of $total_count for Deposit is OVER by $oob <img height='40' width='40' src='/budget/infotrack/icon_photos/xmark1.png' alt='picture of home'></img><br /><br /><form action=''><input type='text' placeholder='Enter Comment'><input type='submit' name='comment_update' value='Add Comment'></form> ";}


echo "<tr><td colspan='3' align='right'>$oob_message</td><td>$total_count</td><td>$total_sales</td><td></td></tr>";
*/

  echo "</table>";
 }
 
 if($update1 == 'y')
 {
 $query14a="SELECT sum(grand_total) as 'deposit_total',sum(adjustment) as 'deposit_oob'
 from crs_deposit_counts
 WHERE 1 and manual_deposit_id='$manual_deposit_id'
 ";
 //echo "query14a=$query14a<br /><br />";
$result14a = mysqli_query($connection, $query14a) or die ("Couldn't execute query 14a.  $query14a");

$row14a=mysqli_fetch_array($result14a);
extract($row14a);//brings back number of records paid by check

if($deposit_oob<0)
{
$deposit_oob2=-$deposit_oob;
$deposit_oob2=number_format($deposit_oob2,2,'.','');
$header_oob_message=" <font color='red' size='5'>&nbsp;&nbsp;($deposit_oob2 Shortage)</font>";
}


if($deposit_oob>0)
{
$deposit_oob=number_format($deposit_oob,2,'.','');
$header_oob_message=" <font color='red' size='5'>&nbsp;&nbsp;($deposit_oob Overage)</font>";
}

$deposit_total=number_format($deposit_total,2,'.','');
//$deposit_oob=number_format($deposit_oob,2,'.','');


//echo "deposit_total=$deposit_total<br /><br />";
//echo "deposit_oob=$deposit_oob<br /><br />";
 
 //echo "results from Update1<br /><br />";
 echo "<table align='center'><tr><th><font color='brown' size='6'>$deposit_total Counted for Bank Deposit</font>$header_oob_message</th></tr></table>";
 echo "<br />";
 echo "<table border=1 id='table1'>";
//echo "<tr><th colspan='5'>DENR Daily Receipt Check Log</th></tr>";
echo "<tr>"; 
//echo "<th align=left><font color=brown>ORMS Deposit ID</font></th>";
//echo "<th align=left><font color=brown>Controllers Deposit ID</font></th>";  
 echo "<th align=left><font color=brown>Location</font></th>"; 
 
echo "<th align=left><font color=brown>Cash<br />Count</font></th>";
echo "<th align=left><font color=brown>Check<br />Count</font></th>";
echo "<th align=left><font color=brown>Total<br />Count</font></th>";
echo "<th align=left><font color=brown>Total<br />Receipts</font></th>";
echo "<th align=left><font color=brown>Comments</font></th>";
//if($update1=='y'){echo "<th align=left><font color=brown>CheckCount</font></th>";}
/*
//echo "<th align=left><font color=brown>Vehicle#</font></th>";
echo "<th align=left><font color=brown>DepositAdjustment</font></th>";
echo "<th align=left><font color=brown>Comment</font></th>";
*/
             
echo "</tr>";

//echo  "<form method='post' autocomplete='off' action='check_listing_update.php'>";
//echo  "<form method='post' autocomplete='off' action='fuel_log_update.php'>";
//echo  "<form method='post' autocomplete='off' action='transaction_detail_manual_update2.php'>";
//echo  "<form method='post' autocomplete='off' action='bank_deposit_step2_update.php'>";

while ($row14=mysqli_fetch_array($result14)){
 
 extract($row14);
 
 $location_total=number_format(($cash_amount+$check_amount),2,'.','');
 //$location_total=$cash_amount+$check_amount;
 $total_count+=$location_total;
 $total_cash+=$cash_amount;
 $total_check+=$check_amount;
 
 $total_sales+=$total_amount;
 if($adjustment=='0.00'){$adjustment_icon="<img height='30' width='30' src='/budget/infotrack/icon_photos/green_checkmark1.png' alt='picture of home'></img>Balanced";}
 
 
 if($adjustment<'0.00'){
$adjustment2=-$adjustment;
$adjustment2=number_format($adjustment2,2,'.','');
 
 
 //$adjustment_icon="<img height='30' width='30' src='/budget/infotrack/icon_photos/xmark1.png' alt='picture of home'></img>Count is Short by $adjustment2";}
 $adjustment_icon="<font color='red'>$adjustment2 Shortage</font>";}
 
 if($adjustment>'0.00')
 
 {$adjustment_icon="<font color='red'>$adjustment Overage</font>";}
 
 
 
 
 
 //if($cash_amount=='0.00'){$cash_amount='';}
 //if($check_amount=='0.00'){$check_amount='';}
 /*
 //$sed2=date('m-d-y', strtotime($sed));
 $transaction_date2=date('m-d-y', strtotime($transaction_date));
 
 if($amount=='0.00'){$amount='';}
 if($amount==''){$sed2='';}
 */
 
 $table_bg2='lightcyan';
 if($c==''){$t=" bgcolor='$table_bg2'";$c=1;}else{$t='';$c='';}
 echo "<tr$t>";
 
 
echo "<td>$sales_location</td>"; 

//echo "<td><textarea name='payment_type[]' cols='20' rows='2'>$payment_type</textarea></td> ";                  
//echo "<td><textarea name='account_name[]' cols='40' rows='2'>$account_name</textarea></td> "; 


//echo "<td><input type='text' name='account_name[]' autocomplete='off' value='$account_name'></td>"; 
//echo "<td><input type='text' name='cash_amount[]' autocomplete='off' placeholder='cash total' value='$cash_amount' ></td>"; 
//echo "<td><input type='text' name='check_amount[]' autocomplete='off' placeholder='check total' value='$check_amount' ></td>"; 

echo "<td>$cash_amount</td>"; 
echo "<td>$check_amount</td>"; 
echo "<td>$location_total</td>";
echo "<td>$total_amount</td>"; 

echo "<td>$adjustment_icon</td>";
//if($adjustment!='0.00'){echo "<td><form><input type='text'></form></td>";}




//echo "<td><input type='text' name='comment[]' autocomplete='off' value='$comment'></td>"; 
//echo "<td><textarea name='comment[]' cols='30' rows='2' placeholder='Optional Comment'>$comment</textarea></td> ";   
 //echo "<td><input type='hidden' name='id[]' value='$id' ></td>"; 	                   
//echo "<td>$checknum</td>";                      
//echo "<input type='hidden' name='sales_location[]' value='$sales_location'>";  
//echo "<input type='hidden' name='total_amount[]' value='$total_amount'>";  
              
//echo "<td>$bank_deposit_date</td>";                      
//echo "<td>$cashier</td>";                      
    
       
              
           
echo "</tr>";




}
echo "</table>";

//$location_total=number_format(($cash_amount+$check_amount),2,'.','');
/*
echo "<table border='1' align='center'>";
       
	   echo "<tr>";
	     
	   
	   echo "<th>bank deposit date<br /><input name='bank_deposit_date' type='text' id='datepicker' size='15'></th>";	   
	   //echo "<th>deposit amount<br /><input name='bank_deposit_ type='text'</th>";	   
	   echo "<th>Deposit Slip<input type='file' id='document' name='document'><input type='hidden' name='content_mode' value='$content_mode' /><input type='hidden' name='MAX_FILE_SIZE' value='2000000'><br /><font color='blue'>Amount must equal $bank_deposit_total</font></th>";	   
	   //echo "<th>Cashier<br /> <font color='blue'>$cashier</font></th>";
	   //echo "<th>Manager<br /> <font color='blue'>$manager</font></th>";
	   echo "</tr>";
	   
	   	   echo "</table>";
 */
$total_count=number_format($total_count,2,'.','');
$total_sales=number_format($total_sales,2,'.','');
$oob=number_format(($total_count-$total_sales),2,'.','');

$total_cash=number_format($total_cash,2,'.','');
$total_check=number_format($total_check,2,'.','');

//echo "oob=$oob<br /><br />";
if($oob == 0){$oob_icon="<img height='40' width='40' src='/budget/infotrack/icon_photos/green_checkmark1.png' alt='picture of home'></img>";}
if($oob < 0){$oob_icon="<img height='40' width='40' src='/budget/infotrack/icon_photos/xmark1.png' alt='picture of home'></img>";}
if($oob < 0){$oob_icon="<img height='40' width='40' src='/budget/infotrack/icon_photos/xmark1.png' alt='picture of home'></img>";}
if($oob > 0){$oob_icon="<img height='40' width='40' src='/budget/infotrack/icon_photos/xmark1.png' alt='picture of home'></img>";}
//echo "<br /><br />";
/*
echo "<table align='center'>";
echo "<tr><td><font color='brown'>Total</font></td><td><font color='brown'>$total_cash</font></td><td><font color='brown'>$total_check</font></td><td><font color='brown'>$total_count</font></td><td><font color='brown'>$total_sales</font></td><td><font color='brown'>$oob_icon</font></td></tr>";
 echo "</table>";
 */
echo "</div>";

//count lower than receipts

if($oob<0)
{
$oob2=-$oob;
$oob2=number_format($oob2,2,'.','');
echo "<br />";


 

echo "<form method='post' action='bank_deposit_step2_update3.php'>";
/*
echo "<table align='center'><tr>
<th>bank deposit date<input name='bank_deposit_date' type='text' id='datepicker' size='15'></th><th>Deposit Slip<input type='file' id='document' name='document'><input type='hidden' name='content_mode' value='$content_mode' /><input type='hidden' name='MAX_FILE_SIZE' value='2000000'><br /><font color='blue'>Amount must equal $bank_deposit_total</font></th></tr><tr></tr>
<tr>
<th><textarea rows='4' cols='50' name='comment' placeholder='Explanation of $oob2 Shortage'></textarea></th>
<th>Cashier: $cashier_first $cashier_last<br />Approved:<input type='checkbox' name='cashier_approved' value='y' >
<input type='hidden' name='manual_deposit_id' value='$manual_deposit_id'>
<input type='hidden' name='deposit_amount' value='$total_count'>
<input type='submit' name='submit' value='Submit'>
</th>
</tr>
</table>";
*/

//echo "total_check=$total_check<br /><br />";

/*
if($total_check>'0.00')
{
echo "<table border='1' align='center'>";
echo "<tr>";
echo "<th>Check#</th><th>Payor</th><th>Payor<br />Bank</th><th>Amount</th><th>Description</th>";
echo "</tr>";
echo "<tr>";
echo "<td><input name='checknum[]' type='text' size='10' value=''></td>";
echo "<td><input name='payor[]' type='text' size='25' value=''></td>";
echo "<td><input name='payor_bank[]' type='text' size='25' value=''></td>";
echo "<td><input name='ck_amount[]' type='text' size='9' value=''></td>";
echo "<td><input name='description[]' type='text' size='25' value=''></td>";
echo "</tr>";
echo "<tr>";
echo "<td><input name='checknum[]' type='text' size='10' value=''></td>";
echo "<td><input name='payor[]' type='text' size='25' value=''></td>";
echo "<td><input name='payor_bank[]' type='text' size='25' value=''></td>";
echo "<td><input name='ck_amount[]' type='text' size='9' value=''></td>";
echo "<td><input name='description[]' type='text' size='25' value=''></td>";
echo "</tr>";
echo "<tr>";
echo "<td><input name='checknum[]' type='text' size='10' value=''></td>";
echo "<td><input name='payor[]' type='text' size='25' value=''></td>";
echo "<td><input name='payor_bank[]' type='text' size='25' value=''></td>";
echo "<td><input name='ck_amount[]' type='text' size='9' value=''></td>";
echo "<td><input name='description[]' type='text' size='25' value=''></td>";
echo "</tr>";
echo "<tr>";
echo "<td><input name='checknum[]' type='text' size='10' value=''></td>";
echo "<td><input name='payor[]' type='text' size='25' value=''></td>";
echo "<td><input name='payor_bank[]' type='text' size='25' value=''></td>";
echo "<td><input name='ck_amount[]' type='text' size='9' value=''></td>";
echo "<td><input name='description[]' type='text' size='25' value=''></td>";
echo "</tr>";
echo "</table>";
}
*/

echo "<table align='center'>";
echo "<tr>";
//echo "<th>bank deposit date<input name='bank_deposit_date' type='text' id='datepicker' size='15'></th><th>Deposit Slip<input type='file' id='document' name='document'><input type='hidden' name='content_mode' value='$content_mode' /><input type='hidden' name='MAX_FILE_SIZE' value='20000000'></font></th>";
//$oob=$oob2;
echo "<th><textarea rows='4' cols='50' name='comment' placeholder='Explanation of $oob2 Shortage'></textarea></th>";
echo "<th>Cashier: $cashier_first $cashier_last<br />Approved:<input type='checkbox' name='cashier_approved' value='y' >
<input type='hidden' name='manual_deposit_id' value='$manual_deposit_id'>
<input type='hidden' name='deposit_amount' value='$total_count'>
<input type='hidden' name='oob' value='$oob'>
<input type='submit' name='submit' value='Submit'>
</th>";
echo "</tr>";
echo "</table>";


}
//count higher than receipts
if($oob>0)
{
echo "<br />";
echo "<form method='post' action='bank_deposit_step2_update3.php'>";

//echo "total_check=$total_check<br /><br />";

/*
if($total_check>'0.00')
{
echo "<table border='1' align='center'>";
echo "<tr>";
echo "<th>Check#</th><th>Payor</th><th>Payor<br />Bank</th><th>Amount</th><th>Description</th>";
echo "</tr>";
echo "<tr>";
echo "<td><input name='checknum[]' type='text' size='10' value=''></td>";
echo "<td><input name='payor[]' type='text' size='25' value=''></td>";
echo "<td><input name='payor_bank[]' type='text' size='25' value=''></td>";
echo "<td><input name='ck_amount[]' type='text' size='9' value=''></td>";
echo "<td><input name='description[]' type='text' size='25' value=''></td>";
echo "</tr>";
echo "<tr>";
echo "<td><input name='checknum[]' type='text' size='10' value=''></td>";
echo "<td><input name='payor[]' type='text' size='25' value=''></td>";
echo "<td><input name='payor_bank[]' type='text' size='25' value=''></td>";
echo "<td><input name='ck_amount[]' type='text' size='9' value=''></td>";
echo "<td><input name='description[]' type='text' size='25' value=''></td>";
echo "</tr>";
echo "<tr>";
echo "<td><input name='checknum[]' type='text' size='10' value=''></td>";
echo "<td><input name='payor[]' type='text' size='25' value=''></td>";
echo "<td><input name='payor_bank[]' type='text' size='25' value=''></td>";
echo "<td><input name='ck_amount[]' type='text' size='9' value=''></td>";
echo "<td><input name='description[]' type='text' size='25' value=''></td>";
echo "</tr>";
echo "<tr>";
echo "<td><input name='checknum[]' type='text' size='10' value=''></td>";
echo "<td><input name='payor[]' type='text' size='25' value=''></td>";
echo "<td><input name='payor_bank[]' type='text' size='25' value=''></td>";
echo "<td><input name='ck_amount[]' type='text' size='9' value=''></td>";
echo "<td><input name='description[]' type='text' size='25' value=''></td>";
echo "</tr>";
echo "</table>";
}
*/

echo "<table align='center'>";
echo "<tr>";
//echo "<th>bank deposit date<input name='bank_deposit_date' type='text' id='datepicker' size='15'></th><th>Deposit Slip<input type='file' id='document' name='document'><input type='hidden' name='content_mode' value='$content_mode' /><input type='hidden' name='MAX_FILE_SIZE' value='20000000'></font></th>";
echo "<th><textarea rows='4' cols='50' name='comment' placeholder='Explanation of $oob Overage'></textarea></th>";
echo "<th>Cashier: $cashier_first $cashier_last<br />Approved:<input type='checkbox' name='cashier_approved' value='y' >
<input type='hidden' name='manual_deposit_id' value='$manual_deposit_id'>
<input type='hidden' name='deposit_amount' value='$total_count'>
<input type='hidden' name='oob' value='$oob'>
<input type='submit' name='submit' value='Submit'>
</th>";
echo "</tr>";
echo "</table>";


}



/*
if($oob>0)
{$oob_message="Deposit Amount is greater than Sales Receipts by $oob <form action=''><input type='text' placeholder='Enter Comment'><input type='submit' name='comment_update' value='Add Comment'></form> ";

//$oob_icon="<img height='40' width='40' src='/budget/infotrack/icon_photos/xmark1.png' alt='picture of home'></img>";
echo "<tr><td colspan='6'><font color='red'>$oob_message</font></td></tr>";
}
*/


/*
if($oob>0)
{$oob_message="Total Money of $total_count for Deposit is OVER by $oob <img height='40' width='40' src='/budget/infotrack/icon_photos/xmark1.png' alt='picture of home'></img><br /><br /><form action=''><input type='text' placeholder='Enter Comment'><input type='submit' name='comment_update' value='Add Comment'></form> ";
}
*/

//echo "<tr><td colspan='3' align='right'>$oob_message</td><td>$total_count</td><td>$total_sales</td><td>$oob_icon</td></tr>";
//echo "<tr><td colspan='6'><font color='red'>$oob_message</font></td></tr>";

//echo "<input type='hidden' name='ctdd_id' value='$ctdd_id'>";
//echo "<input type='hidden' name='parkcode' value='$parkcode'>";
//echo "<input type='hidden' name='cash_month' value='$cash_month'>";
//echo "<input type='hidden' name='fyear' value='$fyear'>";
//echo "<input type='hidden' name='cash_month_calyear' value='$cash_month_calyear'>";

 //echo "<tr><td></td><td></td><td></td><td><td>Detail Total Debits</td></tr>";
 //echo "<tr><td></td><td></td><td></td><td>$total_check_amount</td><td>Detail Total Credits</tr>";
 
 
 
 
 if($oob==0)
{
echo "<br /><br />";
echo  "<form method='post' autocomplete='off' action='bank_deposit_step2_update3.php'>";
//echo "total_check=$total_check<br /><br />";

/*
if($total_check>'0.00')
{
echo "<table border='1' align='center'>";
echo "<tr>";
echo "<th>Check#</th><th>Payor</th><th>Payor<br />Bank</th><th>Amount</th><th>Description</th>";
echo "</tr>";
echo "<tr>";
echo "<td><input name='checknum[]' type='text' size='10' value=''></td>";
echo "<td><input name='payor[]' type='text' size='25' value=''></td>";
echo "<td><input name='payor_bank[]' type='text' size='25' value=''></td>";
echo "<td><input name='ck_amount[]' type='text' size='9' value=''></td>";
echo "<td><input name='description[]' type='text' size='25' value=''></td>";
echo "</tr>";
echo "<tr>";
echo "<td><input name='checknum[]' type='text' size='10' value=''></td>";
echo "<td><input name='payor[]' type='text' size='25' value=''></td>";
echo "<td><input name='payor_bank[]' type='text' size='25' value=''></td>";
echo "<td><input name='ck_amount[]' type='text' size='9' value=''></td>";
echo "<td><input name='description[]' type='text' size='25' value=''></td>";
echo "</tr>";
echo "<tr>";
echo "<td><input name='checknum[]' type='text' size='10' value=''></td>";
echo "<td><input name='payor[]' type='text' size='25' value=''></td>";
echo "<td><input name='payor_bank[]' type='text' size='25' value=''></td>";
echo "<td><input name='ck_amount[]' type='text' size='9' value=''></td>";
echo "<td><input name='description[]' type='text' size='25' value=''></td>";
echo "</tr>";
echo "<tr>";
echo "<td><input name='checknum[]' type='text' size='10' value=''></td>";
echo "<td><input name='payor[]' type='text' size='25' value=''></td>";
echo "<td><input name='payor_bank[]' type='text' size='25' value=''></td>";
echo "<td><input name='ck_amount[]' type='text' size='9' value=''></td>";
echo "<td><input name='description[]' type='text' size='25' value=''></td>";
echo "</tr>";
echo "</table>";
}
*/


echo "<table align='center'>";
echo "<tr>";
echo "<th>Cashier: $cashier_first $cashier_last</th>";
//echo "<td><font color='brown'>Bank Deposit Amount = $total_count</font></td>";
echo "<td>Approved:<input type='checkbox' name='cashier_approved' value='y' >
<input type='hidden' name='manual_deposit_id' value='$manual_deposit_id'>
<input type='hidden' name='deposit_amount' value='$total_count'>
<input type='submit' name='submit' value='Submit'>
</td>";

echo "</table>";
echo "</form>";

}
 
 /*
 if($cashier_count==1)
{
echo "<table>";
echo "<tr><th>Cashier: $cashier_first $cashier_last</th><td>Approved:<input type='checkbox' name='cashier_approved' value='y' >";
echo "<input type='hidden' name='checks' value='$check'>
<input type='hidden' name='orms_deposit_id' value='$deposit_id'>
<input type='hidden' name='rcf_amount' value='$rcf_amount'>
<input type='hidden' name='rcf' value='$rcf'>
<input type='hidden' name='controllers_next' value='$controllers_next'>";
echo "<input type='submit' name='submit' value='Submit'></tr>";
//echo "<tr><th>Manager: $manager</th><td>Approved:<input type='checkbox' name='manager_approved' value='y'>
echo "</form>";
echo "</div>";
}
*/
 
 
 
 
 
 
 
 
 }
 //echo "<pre>";print_r($checknum);"</pre>";//exit;
 }
 echo "</body></html>";
 
 
 
 
?>