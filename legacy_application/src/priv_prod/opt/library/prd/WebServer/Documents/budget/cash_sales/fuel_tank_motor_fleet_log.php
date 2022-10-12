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

//if($beacnum=='60033016'){echo "<br />beacnum=$beacnum<br />";}


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





if($submit_exp_acct=='ADD_Exp')
{
	
$query20191220a="select park_acct_desc from coa where ncasnum='$exp_acct_add' and cash_type='disburse' ";
$result20191220a = mysqli_query($connection, $query20191220a) or die ("Couldn't execute query 20191220a.  $query20191220a");

$row20191220a=mysqli_fetch_array($result20191220a);
extract($row20191220a);
//echo "<br />park_acct_desc=$park_acct_desc<br />";

// User provided Account# is NOT a Valid Expenditure Account per TABLE=coa.ncasnum
if($park_acct_desc=='')
{
$photo_location="/budget/infotrack/icon_photos/mission_icon_photos_228.ico";
$photo_location2="<img src='$photo_location' height='100' width='100'>";	
	
echo "<table align='center'><tr><td>$photo_location2</td><th>Oops! $exp_acct_add is not a VALID Expenditure Account per TABLE=coa</th></tr></table>"; 
echo "<table align='center'><tr><td><font size='7'><a href='/budget/cash_sales/page2_form.php?step=1&edit=y'>Return to Form</a></font></td></tr></table>";
exit;
}


// User provided Account# is a Valid Expenditure Account per TABLE=coa.ncasnum
if($park_acct_desc!='')
{
$query20191220b="select count(id) as 'curr_record_count' from crs_products_park_exp where park='admi' and revenue_account='$exp_acct_add'";
$result20191220b = mysqli_query($connection, $query20191220b) or die ("Couldn't execute query 20191220b.  $query20191220b");
$row20191220b=mysqli_fetch_array($result20191220b);
extract($row20191220b);
//echo "<br />curr_record_count=$curr_record_count<br />";

// record already exist in table, but need to set active=y
if($curr_record_count==1)
{
$query20191220c="update crs_products_park_exp set active='y' where park='admi' and revenue_account='$exp_acct_add' ";
$result20191220c = mysqli_query($connection, $query20191220c) or die ("Couldn't execute query 20191220c.  $query20191220c");
	
}

// add New record into table
if($curr_record_count==0)
{
$query20191220d="insert into crs_products_park_exp set revenue_account='$exp_acct_add',revenue_name='$park_acct_desc',cash_type='disburse',park='admi' ";
$result20191220d = mysqli_query($connection, $query20191220d) or die ("Couldn't execute query 20191220d.  $query20191220d");

$query20191220e="update crs_products_park_exp set product_name=concat(revenue_account,'-',revenue_name),product_name2=concat(revenue_account,'-',revenue_name) where park='admi' and revenue_account='$exp_acct_add' ";
$result20191220e = mysqli_query($connection, $query20191220e) or die ("Couldn't execute query 20191220e.  $query20191220e");


	
}
}

//echo "<br /><table align='center'><tr><th>Update Successful. Return to <a href='/budget/cash_sales/page2_form.php?step=1&edit=y'>Form</a></th></tr></table><br />";
$array = array("/budget/infotrack/icon_photos/mission_icon_success_1.png", "/budget/infotrack/icon_photos/mission_icon_success_5.png", "/budget/infotrack/icon_photos/mission_icon_success_8.png", "/budget/infotrack/icon_photos/mission_icon_success_10.png");
	$k=array_rand($array);
	$photo_location=$array[$k];
	$photo_location2="<img src='$photo_location' height='100' width='100'>";
echo "<table align='center'><tr><td>$photo_location2</td><td><font size='7' color='brown'>Account $exp_acct_add ($park_acct_desc) added to drop-down list Thanks!</font></td></tr></table>";
echo "<table align='center'><tr><td><font size='7'><a href='/budget/cash_sales/page2_form.php?step=1&edit=y'>Return to Form</a></font></td></tr></table>";

exit;
}	
	
if($submit_rev_acct=='ADD_Rev')
{
	
$query20191220f="select park_acct_desc as 'park_acct_desc2' from coa where ncasnum='$rev_acct_add' and cash_type='receipt' ";
$result20191220f = mysqli_query($connection, $query20191220f) or die ("Couldn't execute query 20191220f.  $query20191220f");

$row20191220f=mysqli_fetch_array($result20191220f);
extract($row20191220f);
echo "<br />park_acct_desc2=$park_acct_desc2<br />";

// User provided Account# is NOT a Valid Revenue Account per TABLE=coa.ncasnum
if($park_acct_desc2=='')
{
$photo_location="/budget/infotrack/icon_photos/mission_icon_photos_228.ico";
$photo_location2="<img src='$photo_location' height='100' width='100'>";	
	
echo "<table align='center'><tr><td>$photo_location2</td><th>Oops! $rev_acct_add is not a VALID Revenue Account per TABLE=coa</th></tr></table>"; 
echo "<table align='center'><tr><td><font size='7'><a href='/budget/cash_sales/page2_form.php?step=1&edit=y'>Return to Form</a></font></td></tr></table>";
exit;
}

// User provided Account# is a Valid Expenditure Account per TABLE=coa.ncasnum
if($park_acct_desc2!='')
{
$rev_acct_add2=str_pad($rev_acct_add, 9, '0', STR_PAD_LEFT);
echo "<br />rev_acct_add2=$rev_acct_add2<br />"; //exit;
	
$query20191220g="select count(id) as 'curr_record_count_rev' from crs_products_park where park='admi' and revenue_account='$rev_acct_add2'";
$result20191220g = mysqli_query($connection, $query20191220g) or die ("Couldn't execute query 20191220g.  $query20191220g");
$row20191220g=mysqli_fetch_array($result20191220g);
extract($row20191220g);

echo "<br />query20191220g=$query20191220g<br />";
echo "<br />curr_record_count_rev=$curr_record_count_rev<br />";
//exit;


// record already exist in table, but need to set active=y
if($curr_record_count_rev==1)
{
$query20191220h="update crs_products_park set active='y' where park='admi' and revenue_account='$rev_acct_add2' ";
$result20191220h = mysqli_query($connection, $query20191220h) or die ("Couldn't execute query 20191220h.  $query20191220h");
echo "<br />Line 164: Update Successful<br />";
//exit;
}




// add New record into table
if($curr_record_count_rev==0)
{
$query20191220j="insert into crs_products_park set revenue_account='$rev_acct_add2',revenue_name='$park_acct_desc2',cash_type='receipt',park='admi' ";
$result20191220j = mysqli_query($connection, $query20191220j) or die ("Couldn't execute query 20191220j.  $query20191220j");

$query20191220k="update crs_products_park set product_name=concat(revenue_account,'-',revenue_name),product_name2=concat(revenue_account,'-',revenue_name) where park='admi' and revenue_account='$rev_acct_add2' ";
$result20191220k = mysqli_query($connection, $query20191220k) or die ("Couldn't execute query 20191220k.  $query20191220k");


	
}
}

//echo "<br /><table align='center'><tr><th>Update Successful. Return to <a href='/budget/cash_sales/page2_form.php?step=1&edit=y'>Form</a></th></tr></table><br />";
$array = array("/budget/infotrack/icon_photos/mission_icon_success_1.png", "/budget/infotrack/icon_photos/mission_icon_success_5.png", "/budget/infotrack/icon_photos/mission_icon_success_8.png", "/budget/infotrack/icon_photos/mission_icon_success_10.png");
	$k=array_rand($array);
	$photo_location=$array[$k];
	$photo_location2="<img src='$photo_location' height='100' width='100'>";
echo "<table align='center'><tr><td>$photo_location2</td><td><font size='7' color='brown'>Account $rev_acct_add2 ($park_acct_desc2) added to drop-down list Thanks!</font></td></tr></table>";
echo "<table align='center'><tr><td><font size='7'><a href='/budget/cash_sales/page2_form.php?step=1&edit=y'>Return to Form</a></font></td></tr></table>";

exit;

}	
//}



$query12b="SELECT min(transdate_new) as 'mindate',max(transdate_new) as 'maxdate'
 from crs_tdrr_division_history_parks_manual
 WHERE 1 and concession_location='$concession_location'
 and deposit_transaction='n'
 and amount != '0.00'
 ";
 
//echo "<br />Line 114: query12b=$query12b";
 
$result12b = mysqli_query($connection, $query12b) or die ("Couldn't execute query 12b.  $query12b");

$row12b=mysqli_fetch_array($result12b);
extract($row12b);//brings back number of records paid by check

if($mindate==''){$mindate=$today;}
if($maxdate==''){$maxdate=$today;}

$mindate=str_replace("-","",$mindate);
$maxdate=str_replace("-","",$maxdate);

if($previous_date<$mindate){$previous_date=$mindate;}
if($next_date>$today){$next_date=$today;}
//if($previous_date<$mindate){echo "yes<br /><br />";} else {echo "no<br /><br />";}

//echo "mindate=$mindate<br /><br />";
//echo "previous_date=$previous_date<br /><br />";

//echo "maxdate=$maxdate<br /><br />";
//echo "next_date=$next_date<br /><br />";



$query12c="SELECT datediff('$today','$mindate') as 'diffdate'
 ";
 
$result12c = mysqli_query($connection, $query12c) or die ("Couldn't execute query 12c.  $query12c");

$row12c=mysqli_fetch_array($result12c);
extract($row12c);//brings back number of records paid by check
$diffdate2=$diffdate+1;

//echo "diffdate2=$diffdate2<br /><br />";

//echo "check count=$ck_count";
//$mindate_footer2=date('m-d-y', strtotime($mindate_footer));
//$maxdate_footer2=date('m-d-y', strtotime($maxdate_footer));


//$revenue_collection_period=$mindate_footer2." thru ".$maxdate_footer2;


$query11="SELECT transdate_new as 'transaction_date',payment_type,product_name,amount,account_name,ncas_account,sed,comment
from crs_tdrr_division_history_parks_manual
where concession_location='$concession_location'
and deposit_transaction='n' 
and amount != '0.00'
order by id asc "; 






/*

$query11="select id,park,center,fyear as 'fiscal_year',cash_month,cash_month_number,cash_month_calyear,tag_num,vehicle_num,vehicle_location,driver_name,gallons,
 usage_day,cashier,cashier_date
 from fuel_tank_usage_detail
 where park='$parkcode' and cash_month='$cash_month' and fyear='$fyear' and cash_month_calyear='$cash_month_calyear'
 order by id asc ; ";
*/
	
	
//echo "<br />Line 180: query11=$query11<br />"; //exit;


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
 
 
 // 6/1/15: LAWA Seasonal employee Paula Wagner,  Budget Officer Tammy Dodd,  Accountant Tony Bass
 /*
 if($tempid=='wagner9210' or $beacnum=='60032781' or $beacnum=='60032793')
 {
 echo "<table align='center'><tr><td><a href='page2_form.php?parkcode=$parkcode&cash_month=$cash_month&fyear=$fyear&cash_month_calyear=$cash_month_calyear&edit=y'>Edit Form</a></td></tr></table>";
 }
 */
 
 /*
 $query11a="SELECT count(id) as 'record_count'
from fuel_tank_usage_detail
WHERE park='$parkcode' and cash_month='$cash_month' and fyear='$fyear' and cash_month_calyear='$cash_month_calyear'
";
*/

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
 
 
 
 
//echo "query11a=$query11a<br /><br />";
 
//echo "record_count=$record_count<br />"; //exit;
 /*
 $step1_instructions="<font color='brown'>Cash Handling Procedures:</font><font color='blue'> All \"monies & receipts\" are delivered to the \"Deposit Cashier\" on the same day collected</font>";
 */
/*
  echo "<table align='center' bgcolor='cornsilk'>
 <tr><th style='text-align:center'>Cash Handling Procedures</th></tr>
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
 

 
 /*
echo "<p>";
 echo "<h2>Unordered List with Default Bullets</h2>

<ul>
  <li>Coffee</li>
  <li>Tea</li>
  <li>Milk</li>
</ul>";  
 echo "</p>";
  */
 /*
 if($edit != 'y' and $record_count != '0')
 {
 $query11b="delete from crs_tdrr_division_history_parks_manual
            where concession_location='$concession_location'
			and amount='0.00'
			and deposit_id='pending'
 ";
 
$result11b = mysqli_query($connection, $query11b) or die ("Couldn't execute query 11b.  $query11b");
 
 if($num11!='0')
 {
 //include("cash_sales_total_header.php");
 
 $days_elapsed_message=" collected over $diffdate2 days";
 
 if($diffdate2 > 6 or $total_sales >= '250.00'){$deposit_message="(Deposit Required)";}
 //echo "deposit_message=$deposit_message<br /><br />";
 
 echo "<table align='center'>
 <tr bgcolor='cornsilk'><td><font color='blue'>$total_sales $days_elapsed_message</font><font color='red'> $deposit_message</font></td></tr></table>";

}


if($num11=='0')
 {
 //include("cash_sales_total_header.php");
 
 $days_elapsed_message=" collected today";
 
 if($diffdate2 > 6 or $total_sales >= '250.00'){$deposit_message="(Deposit Required)";}
 //echo "deposit_message=$deposit_message<br /><br />";
 
 echo "<table align='center'>
 <tr bgcolor='cornsilk'><td><font color='blue'>$total_sales $days_elapsed_message</font><font color='red'> $deposit_message</font></td></tr></table>";

}












echo "<br />";
 echo "<table align='center'><tr><td><a href='page2_form.php?concession_location=$concession_location&edit=y'>Update Form</a></td></tr></table>";
 
 echo "<br />";
 
 echo "<br />";
 //}
 
 //echo "<div id='table1'>";
 echo "<table>";
//echo "<table border=1 id='table1'>";
echo "<table border='1' align='center'>";
//echo "<tr><th colspan='5'>DENR Daily Receipt Check Log</th></tr>";
echo "<tr>"; 
//echo "<th align=left><font color=brown>ORMS Deposit ID</font></th>";
//echo "<th align=left><font color=brown>Controllers Deposit ID</font></th>";  
echo "<th align=left><font color=brown>Entry Date</font></th>";     
echo "<th align=left><font color=brown>Payment Type</font></th>";
echo "<th align=left><font color=brown>Account Name</font></th>";
//echo "<th align=left><font color=brown>Vehicle#</font></th>";
echo "<th align=left><font color=brown>Amount</font></th>";
//echo "<th align=left><font color=brown>Gallons<br />(Example: 12.40)</font></th>";

//echo "<th align=left><font color=brown>ID</font></th>";
             
echo "</tr>";

//$row=mysqli_fetch_array($result);


// The while statement steps through the $result variable one row ($row, which is an array created by mysqli_fetch_array) at a time
//$c=1;
while ($row11=mysqli_fetch_array($result11)){
 
 extract($row11);
 $transaction_date2=date('m-d-y', strtotime($transaction_date));
 
 if($amount=='0.00'){$amount='';}
 //if($amount==''){$sed2='';}
 
 //if($gallons=='0.00'){$gallons='';}
 $table_bg2='cornsilk';
 if($c==''){$t=" bgcolor='$table_bg2'";$c=1;}else{$t='';$c='';}
 echo "<tr$t>";
 
 //echo "<td><a href='crs_deposits_cashier_deposit.php?deposit_id=$deposit_id2&GC=$GC' '>Update</a></td>";		   
//echo "<td>$orms_deposit_id</td>";	
echo "<td>$transaction_date2</td>";  	   
echo "<td>$payment_type</td>";                      
//echo "<td>$checknum</td>";                      
echo "<td>$account_name</td>";                      
//echo "<td>$vehicle_num</td>";  
  echo "<td>$amount</td>";                    
 //echo "<td>$gallons</td>";                         
// echo "<td>$id</td>";                         
  
              
//echo "<td>$bank_deposit_date</td>";                      
//echo "<td>$cashier</td>";                      
    
       
              
           
echo "</tr>";




}

 
 
  echo "</table>";
 echo "</div>";
 }
 */
 
 /*
 $query11="select id,park,center,fyear as 'fiscal_year',cash_month,cash_month_number,cash_month_calyear,tag_num,vehicle_num,vehicle_location,driver_name,gallons,
 usage_day,cashier,cashier_date
 from fuel_tank_usage_detail
 where park='$parkcode' and cash_month='$cash_month' and fyear='$fyear' and cash_month_calyear='$cash_month_calyear'	 ; ";
 */
 
 
 
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
 
 
//TABLE=crs_deposit_counts is the Container TABLE to collect the Total "sales amounts" for all the "sales transactions" entered into  
//     TABLE=crs_tdrr_division_history_parks_manual. 1 or More Records are established in TABLE=crs_deposit_counts for each Park Deposit.
//     If a Park has 1 Sales Location it will have 1 Record for each Park Deposit. If the Park has 2 Sales Locations it will have 2 Records
//     for each Park Deposit  and so on........
// It is also the Container TABLE to collect "Cash & Check Counts" for each "Park Deposit"-"Sales Location" combination 
// The query below establishes record(s) in TABLE=crs_deposit_counts.  TABLE=crs_deposit_counts has a 
//     3 Field Unique:  concession_location (aka park), manual_deposit_id, sales_location 
// The Query to "insert ignore"  New records into TABLE=crs_deposit_accounts will not allow the "3 Field Unique" to be violated
//     & will only insert NEW "3 Field Unique" Records
// Even if a Park has NO "sales transactions" for a Specific Location, the Query below still creates a Record in TABLE=crs_deposit_counts
// so we can effectively track Sales for all Park Locations (even Park Locations that had Zero Sales)

$query13a="insert ignore into crs_deposit_counts(concession_location,manual_deposit_id,sales_location)
select '$concession_location','$manual_deposit_id',location_name
from crs_locations
where park_code='$concession_location' ";
 
 
$result13a=mysqli_query($connection, $query13a) or die ("Couldn't execute query 13a. $query13a");
 
$query13b="insert ignore into crs_tdrr_division_deposits_manual(park,manual_deposit_id)
select '$concession_location','$manual_deposit_id'
 ";
 
 
$result13b=mysqli_query($connection, $query13b) or die ("Couldn't execute query 13b. $query13b"); 
 
 
 
 
 
 
 
 
 
/*
$query14="select id,park,center,fyear as 'fiscal_year',cash_month,cash_month_number,cash_month_calyear,tag_num,vehicle_num,vehicle_location,driver_name,gallons,
 usage_day,cashier,cashier_date
 from fuel_tank_usage_detail
 where park='$parkcode' and cash_month='$cash_month' and fyear='$fyear' and cash_month_calyear='$cash_month_calyear'
 order by id asc ; ";		
*/

//if($report_type=='day'){$period=" and transdate_new='$today_date' ";}

// changed on 1/30/19
/*
$query14="SELECT transdate_new as 'transaction_date',payment_type,product_name,amount,account_name,ncas_account,sed,center,sales_location,comment,id
from crs_tdrr_division_history_parks_manual
where concession_location='$concession_location'
and deposit_transaction='n' 
and transdate_new='$today_date'
order by id asc ";
*/

$query14="SELECT transdate_new as 'transaction_date',payment_type,product_name,amount,account_name,ncas_account,sed,center,sales_location,comment,center,center_name,check_name,id
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
 
 //collected on the day
 
 
 
 
 
 
 
 
 
 
 //if($num11!='0')
 /*
 if($today_date=$today)
 {
 //include("cash_sales_total_header.php");
 
 $days_elapsed_message=" total collected over $diffdate2 days";
 
 if($diffdate2 > 6 or $total_sales >= '250.00'){$deposit_message="(Deposit Required)";}
 //echo "deposit_message=$deposit_message<br /><br />";
 
 echo "<table align='center'>
 <tr bgcolor='cornsilk'><td><font color='blue'>$total_sales $days_elapsed_message</font><font color='red'> $deposit_message</font></td></tr></table>";

}
*/

//if($num11=='0')


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
include("products2_menu.php"); // Tag Array from Fuel Database
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
 if($fs_approver_count == 1)
{
include("checks_menu.php"); // Tag Array from Fuel Database
}
 
 
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
// Tammy Dodd/Heide Rumble/Rebecca Owen in Budget Office
if($beacnum=='60032781' or $beacnum=='60036015' or $beacnum=='60033242')
{
if($sale_type_add != 'rev' and $sale_type_add != 'exp' )
{
echo "<th align=left><font color=brown><a href='page2_form.php?edit=y&sale_type_add=rev'>ADD Rev</a>SaleType<a href='page2_form.php?edit=y&sale_type_add=exp'> ADD Exp</a></font></th>";
}
if($sale_type_add=='rev')
{
echo "<th align=left><font color=brown>SaleType<form action='page2_form.php'>NCAS Rev# <input type='text' name='rev_acct_add' value='$rev_acct_add'><input type='submit' name='submit_rev_acct' value='ADD_Rev'><input type='hidden' name='edit' value='y'</form></th>";
}
if($sale_type_add=='exp')
{
echo "<th align=left><font color=brown>SaleType<form action='page2_form.php'>NCAS Exp# <input type='text' name='exp_acct_add' value='$exp_acct_add'><input type='submit' name='submit_exp_acct' value='ADD_Exp'><input type='hidden' name='edit' value='y'</form></th>";
}

}

if($beacnum!='60032781' and $beacnum!='60036015' and $beacnum!='60033242')
{
echo "<th align=left><font color=brown>SaleType</font></th>";	
}



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
 
 //echo "<td><a href='crs_deposits_cashier_deposit.php?deposit_id=$deposit_id2&GC=$GC' '>Update</a></td>";		   
//echo "<td>$orms_deposit_id</td>";	
   
//echo "<td><input type='text' name='usage_day[]' value='$usage_day'></td>"; 


  
/*
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

*/



  
//echo "<td><input type='text'   name='usage_date[]' id='datepicker' size='15'></td>";                   
//echo "<td><input type='text' name='tag_num[]' value='$tag_num'></td>"; 

/*
echo "<td>";
 
 echo "<select name=\"taglist[]\"><option value=''></option>";

for ($n=0;$n<count($tagArray);$n++){
$con=$tagArray[$n];
if($tag_num==$con){$s="selected";}else{$s="value";}
//$s="value";
		echo "<option $s='$con'>$tagArray[$n]</option>\n";
       }

echo "</select>";
echo "</td>";

*/





                     
//echo "<td><input type='text' name='vehicle_num[]' value='$vehicle_num'></td>";
//echo "<td><input type='text' name='driver_name[]' autocomplete='off' value='$driver_name'></td>";  
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
if($center_name==$con){$s="selected";}else{$s="value";}
//echo "<option $s='$con'>$locationArray[$n]</option>\n";
echo "<option $s='$con'>$centerArray[$n]</option>\n";
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

if($fs_approver_count==1)
{
echo "<br />";	
echo "<select name=\"check_name[]\"><option value=''></option>";	
for ($n=0;$n<count($checkArray);$n++){
$con=$checkArray[$n];
if($check_name==$con){$s="selected";}else{$s="value";}
//$s="value";
		echo "<option $s='$con'>$checkArray[$n]</option>\n";
       }

echo "</select>";	
}	
echo "</td>";


echo "<td>";
// echo "<input type='text' name='product[]' autocomplete='off' value='$product'><br />";
//if($fs_approver_count==1){echo "Revenue Accts:";}
if($fs_approver_count==1){echo "<select name=\"product_name[]\"><option value=''>REVENUE ACCOUNT</option>";}
if($fs_approver_count!=1){echo "<select name=\"product_name[]\"><option value=''></option>";}

for ($n=0;$n<count($tagArray);$n++){
$con=$tagArray[$n];
if($product_name==$con){$s="selected";}else{$s="value";}
//$s="value";
		echo "<option $s='$con'>$tagArray[$n]</option>\n";
       }

echo "</select>";
if($fs_approver_count==1)
{
echo "<br />";
echo "OR";
}
if($fs_approver_count==1)
{echo "<select name=\"product2_name[]\"><option value=''>EXPENDITURE ACCOUNT</option>";
for ($n=0;$n<count($product2Array);$n++){
$con=$product2Array[$n];
//if($product_name2==$con){$s="selected";}else{$s="value";}
// changed on 4/24/19
if($product_name==$con){$s="selected";}else{$s="value";}
//$s="value";
		echo "<option $s='$con'>$product2Array[$n]</option>\n";
       }
echo "</select>";

echo "</td>";
}


                 
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
//echo "<input type='hidden' name='ctdd_id' value='$ctdd_id'>";
//echo "<input type='hidden' name='parkcode' value='$parkcode'>";
//echo "<input type='hidden' name='cash_month' value='$cash_month'>";
//echo "<input type='hidden' name='fyear' value='$fyear'>";
//echo "<input type='hidden' name='cash_month_calyear' value='$cash_month_calyear'>";

 //echo "<tr><td></td><td></td><td></td><td><td>Detail Total Debits</td></tr>";
 //echo "<tr><td></td><td></td><td></td><td>$total_check_amount</td><td>Detail Total Credits</tr>";
  echo "</table>";
 echo "</div>";
 echo "</form>";
 //echo "<pre>";print_r($checknum);"</pre>";//exit;
 }
 echo "</body></html>";
 
 
 
 
?>