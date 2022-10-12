<?php
//session_start();

session_start();

if(!$_SESSION["budget"]["tempID"]){echo "access denied";exit;
}

$active_file=$_SERVER['SCRIPT_NAME'];

$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempid=$_SESSION['budget']['tempID'];
$beacnum=$_SESSION['budget']['beacon_num'];
$concession_location=$_SESSION['budget']['select'];
$concession_center=$_SESSION['budget']['centerSess'];



extract($_REQUEST);


$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database



if($delrec=='y')
{

$query0="update crs_tdrr_division_history set valid_record='n' where id='$delid' ";

//echo "<br />query0=$query0<br />";
//exit;
$result0=mysqli_query($connection, $query0) or die ("Couldn't execute query 0. $query0");

$query0a="select sum(amount) as 'new_end_bal'
          from crs_tdrr_division_history
          where center='$center' and deposit_id='none' and valid_record='y' ";
		  
//echo "<br />query0a=$query0a<br />";		  
		  
$result0a=mysqli_query($connection, $query0a) or die ("Couldn't execute query 0a. $query0a");
$row0a=mysqli_fetch_array($result0a);

extract($row0a);


$query0b="select sum(amount) as 'new_transaction_amount'
          from crs_tdrr_division_history
          where center='$center' and deposit_id='none' and valid_record='y' and transdate_new='$effect_date' ";
		  
//echo "<br />query0b=$query0b<br />";
		  
$result0b=mysqli_query($connection, $query0b) or die ("Couldn't execute query 0b. $query0b");
$row0b=mysqli_fetch_array($result0b);

extract($row0b);
if($new_transaction_amount==''){$new_transaction_amount='0.00';}

//echo "<br />new_end_bal=$new_end_bal<br />";
//echo "<br />new_transaction_amount=$new_transaction_amount<br />";

$query0c="select deposit_amount from cash_summary where center='$center' and effect_date='$effect_date' ";
		  
//echo "<br />query0c=$query0c<br />";
		  
$result0c=mysqli_query($connection, $query0c) or die ("Couldn't execute query 0c. $query0c");
$row0c=mysqli_fetch_array($result0c);

extract($row0c);

//echo "<br />deposit_amount=$deposit_amount<br />";

$query0d="update cash_summary set transaction_amount='$new_transaction_amount',end_bal='$new_end_bal' where center='$center' and effect_date='$effect_date' ";
		  
//echo "<br />query0d=$query0d<br />";
		  
$result0d=mysqli_query($connection, $query0d) or die ("Couldn't execute query 0d. $query0d");

//$new_beg_bal=$new_end_bal-$new_transaction_amount-$deposit_amount;
$new_beg_bal=$new_end_bal-$new_transaction_amount+$deposit_amount;

$query0e="update cash_summary set beg_bal='$new_beg_bal' where center='$center' and effect_date='$effect_date' ";
		  
//echo "<br />query0e=$query0e<br />";
		  
$result0e=mysqli_query($connection, $query0e) or die ("Couldn't execute query 0e. $query0e");


$query0f="update cash_summary set undeposited_amount=beg_bal-deposit_amount where center='$center' and effect_date='$effect_date' ";
		  
//echo "<br />query0f=$query0f<br />";
		  
$result0f=mysqli_query($connection, $query0f) or die ("Couldn't execute query 0f. $query0f");




$query1="insert into crs_tdrr_division_history_adjust(`crs`, `transaction_date`, `revenue_location_id`, `revenue_location_name`, `transaction_location_id`, `transaction_location_name`, `payment_type`, `product_id`, `product_name`, `amount`, `account_id`, `account_name`, `batch_deposit_date`, `batch_id`, `deposit_id`, `adjustment`, `valid_record`, `revenue_note`, `center`, `ncas_account`, `taxcenter`, `transdate_new`, `deposit_date_new`, `transdate_day`, `deposit_date_day`, `deposit_transaction`, `record_id`) 
         select `crs`, `transaction_date`, `revenue_location_id`, `revenue_location_name`, `transaction_location_id`, `transaction_location_name`, `payment_type`, `product_id`, `product_name`, `amount`, `account_id`, `account_name`, `batch_deposit_date`, `batch_id`, `deposit_id`, `adjustment`, `valid_record`, `revenue_note`, `center`, `ncas_account`, `taxcenter`, `transdate_new`, `deposit_date_new`, `transdate_day`, `deposit_date_day`, `deposit_transaction`, `record_id`
		 from crs_tdrr_division_history where id='$delid' ";
		 
//echo "<br />query1=$query1<br />";		 

$result1=mysqli_query($connection, $query1) or die ("Couldn't execute query 1. $query1");



header("location: crs_tdrr_undeposited.php ");




}	



echo "<html>";
echo "<head>
<title>MoneyTracker</title>";

//include ("test_style.php");
include ("test_style.php");

echo "</head>";

//include("../../../budget/menu1314.php");
include ("../../../budget/menu1415_v1.php");
//include("menu1314_cash_receipts.php");
//include ("park_deposits_report_menu_v3.php");
//include ("widget2.php");

//include("widget1.php");


//echo "<H1 ALIGN=left><font color=brown><i>$myusername-Articles</i></font></H1>";
echo "<br />";

//include ("park_deposits_report_menu_v3.php");

// (60036015 Accounting Clerk  Rod Bridges)   (60032781 Budget Officer Tammy Dodd)   (60096024 Seasonal Maria Cucurullo) 
// (60032997 Accounting Clerk Rachel Gooding)
// (60033242 Budget Office Rebecca Owen)


//include ("park_deposits_report_menu_v3_division.php");
echo "<table align='center' border='1' cellspacing='5'>";
echo "<tr><th>$parkcode-Undeposited Funds</th></tr>";
echo "</table>";
/*
echo "<table align='center' border='1' cellspacing='5'>";
echo "<tr><th>NOTE: If Import includes Erroneous Record, Click </th></tr>";
echo "</table>";
*/


$query2="SELECT max(effect_date) as 'effect_date' from cash_summary where 1 ";

$result2=mysqli_query($connection, $query2) or die ("Couldn't execute query 2. $query2");

$row2=mysqli_fetch_array($result2);

extract($row2);



echo "<table border='1' cellspacing='5' align='center'>";
echo "<tr><th>transaction_date</th><th>payment_type</th><th>account_id</th><th>account_name</th><th>record type</th><th>undeposited_amount</th></tr>";


$query = "SELECT t1.center,t1.transdate_new,t1.payment_type,t1.account_id,t1.account_name,t1.adjustment,t1.amount,id 
          from crs_tdrr_division_history as t1
		  left join center as t2 on t1.center=t2.center
		  where t2.parkcode='$parkcode' and deposit_id='none' and valid_record='y' order by t1.transdate_new ";

echo "<br />Line 81: query=$query<br />";

$result = mysqli_query($connection, $query) or die ("Couldn't execute query.  $query ");
$num=mysqli_num_rows($result);		


$var_total="";

while($row = mysqli_fetch_array($result)){
extract($row);
$var_total+=$amount;
$amount2=number_format($amount,2);

if($trans_max=='0000-00-00'){$trans_max=$trans_min;}
$collection_period=$trans_min.' thru '.$trans_max;

if($adjustment=='n'){$record_type='csv_import';}
if($adjustment=='y'){$record_type='adjustment';}

if($table_bg2==''){$table_bg2='cornsilk';}
    if($c==''){$t=" bgcolor='$table_bg2' ";$c=1;}else{$t='';$c='';}


echo "<tr$t>";

echo "<td align='center'>$transdate_new</td>";
echo "<td align='center'>$payment_type</td>";
echo "<td align='center'>$account_id</td>";
echo "<td align='center'>$account_name</td>";
echo "<td align='center'>$record_type</td>";
echo "<td align='center'>$amount</td>";
echo "<td align='center'><font class='cartRow'><a href='crs_tdrr_undeposited_detail.php?parkcode=$parkcode&center=$center&effect_date=$effect_date&delrec=y&delid=$id'>REMOVE</a></font></td>";



echo "</tr>";
	}// end while
	
echo "<tr><th></th><th></th><th></th><th></th><th>Total</th><th>$var_total</th>";	

echo "</table>";


echo "</html>";

?>