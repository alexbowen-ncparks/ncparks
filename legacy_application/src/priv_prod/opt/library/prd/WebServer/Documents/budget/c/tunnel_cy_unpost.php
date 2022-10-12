<?php
// called from budget/a/current_year_budget.php?budget_group_menu=???
//These are placed outside of the webserver directory for security

session_start();

if(!$_SESSION["budget"]["tempID"]){echo "access denied";exit;
}

$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database

session_start();
include("../../../include/activity.php");

extract($_REQUEST);
// Construct Query to be passed to Excel Export
$varQuery="submit=Submit&center=$center&budget_group=$budget_group&track_rcc=y";

//print_r($_SESSION);//EXIT;
//echo "<pre>";print_r($_REQUEST);echo "</pre>";EXIT;

$beacnum=$_SESSION['budget']['beacon_num'];
$level=$_SESSION[budget][level];

//if($rep=="" and !$id){include("../menu.php");}
if($level<2){$center=$_SESSION[budget][centerSess_new];}

if($rep==""){

// Display Form
echo "<html><header></header<title></title><body>
<table align='center'><tr>";

echo "</table>";
}
// Populate temporary table 
$sql="CREATE temporary TABLE `budget1_unposted1` ( `center` varchar( 15 ) NOT NULL default '', `account` varchar( 15 ) NOT NULL default '', `vendor_name` varchar( 75 ) NOT NULL default '', `transaction_date` date NOT NULL default '0000-00-00', `transaction_number` varchar( 30 ) NOT NULL default '', `transaction_amount` decimal( 12, 2 ) NOT NULL default '0.00', `transaction_type` varchar( 30 ) NOT NULL default '', `source_table` varchar( 30 ) NOT NULL default '', `source_id` varchar( 10 ) NOT NULL default '0', `post2ncas` char( 1 ) NOT NULL default 'n', `system_entry_date` date NOT NULL default '0000-00-00', `id` int( 10 ) unsigned NOT NULL AUTO_INCREMENT , PRIMARY KEY ( `id` ) ) ENGINE = MyISAM ;
";
$result = mysqli_query($connection, $sql) or die ("Couldn't execute query. $sql");
if($showSQL){echo "$sql<br><br>";}

$sql="insert into budget1_unposted1( center, account, vendor_name, transaction_date, transaction_number, transaction_amount, transaction_type, source_table, source_id, system_entry_date ) select ncas_center, ncas_account, vendor_name, datesql, ncas_invoice_number, ncas_invoice_amount,'cdcs','cid_vendor_invoice_payments', id, system_entry_date from cid_vendor_invoice_payments where 1 and post2ncas != 'y' and ncas_credit != 'x' group by id;
";
$result = mysqli_query($connection, $sql) or die ("Couldn't execute query. $sql");
if($showSQL){echo "$sql<br><br>";}

$sql="insert into budget1_unposted1( center, account, vendor_name, transaction_date, transaction_number, transaction_amount, transaction_type, source_table, source_id, system_entry_date ) select ncas_center, ncas_account, vendor_name, datesql, ncas_invoice_number, -ncas_invoice_amount,'cdcs','cid_vendor_invoice_payments', id, system_entry_date from cid_vendor_invoice_payments where 1 and post2ncas != 'y' and ncas_credit = 'x' group by id;
";
$result = mysqli_query($connection, $sql) or die ("Couldn't execute query. $sql");
if($showSQL){echo "$sql<br><br>";}

$sql="insert into budget1_unposted1( center, account, vendor_name, transaction_date, transaction_number, transaction_amount, transaction_type, source_table, source_id, system_entry_date ) select center, ncasnum, concat('pcard','-',cardholder,'-',vendor_name,'-',trans_date), transdate_new, transid_new, sum(amount),'pcard','pcard_unreconciled', id, xtnd_rundate_new from pcard_unreconciled where 1 and ncas_yn != 'y' group by id;
";
$result = mysqli_query($connection, $sql) or die ("Couldn't execute query. $sql");
if($showSQL){echo "$sql<br><br>";}

$sql="insert into budget1_unposted1( center, account, vendor_name, transaction_date, transaction_number, transaction_amount, transaction_type, source_table, source_id ) select center, ncasnum, concat(postitle,'-',posnum,'-',tempid), datework,'na', sum(rate*hr1311),'seapay','seapay_unposted', prid from seapay_unposted where 1 group by prid;
";
$result = mysqli_query($connection, $sql) or die ("Couldn't execute query. $sql");
if($showSQL){echo "$sql<br><br>";}

/*
$sql="update budget1_unposted1,center 
      set budget1_unposted1.center=center.old_center 
      where budget1_unposted1.center=center.new_center";
$result = mysqli_query($connection, $sql) or die ("Couldn't execute query. $sql");
*/


if($showSQL){echo "$sql<br><br>";}


//Get Report Date
$sql="SELECT date_format(max(acctdate),'%m/%d/%Y') as maxDate from exp_rev WHERE 1";
if($showSQL){echo "$sql<br><br>";}

$result = mysqli_query($connection, $sql) or die ("Couldn't execute query. $sql");
$row=mysqli_fetch_array($result);extract($row);

//Get Total Amount
$sql="Select sum( transaction_amount ) AS 'headAmount' from budget1_unposted1
where budget1_unposted1.center='$center' and account='$acct'
GROUP BY budget1_unposted1.center,budget1_unposted1.account";
if($showSQL){echo "$sql<br><br>";}
$result = mysqli_query($connection, $sql) or die ("Couldn't execute query. $sql");
$row=mysqli_fetch_array($result);extract($row);

$sql="Select budget1_unposted1.*, center.center_desc from budget1_unposted1
LEFT JOIN center ON budget1_unposted1.center = center.new_center
where budget1_unposted1.center='$center' and account='$acct'
GROUP BY budget1_unposted1.id";
if($showSQL){echo "$sql<br><br>";}
$result = mysqli_query($connection, $sql) or die ("Couldn't execute query. $sql");
$num=mysqli_num_rows($result);
if($num==1){$r="Transaction";}else{$r="Transactions";}

//echo "$sql";

// Display Results
echo "<html><header></header><title>CY_Actual Tunnel Down</title><body>
<table align='center' cellpadding='6'>";

while($row=mysqli_fetch_array($result)){
extract($row); $totAmount+=$transaction_amount;
if(!$i){$headAmount=number_format($headAmount,2);
echo "<tr><td colspan='5' align='center'><font color='green' size='+1'><br>Your Search Found $num $r <font color='red'>NOT-POSTED</font></font> for <font color='blue'>$center_desc</font><br />Report Date: $maxDate $center $acct which totals <font color='blue'>$headAmount</font></tr>";

echo "<tr><th>vendor</th><th>system_entry_date</th><th>transaction_date</th><th>transaction_number</th><th>amount</th><th>transaction_type</th><th>Source ID</td></tr>";
$i=1;}

echo "<tr><td align='left'>$vendor_name</td><td align='center'>$system_entry_date</td><td align='center'>$transaction_date</td><td align='center'>$transaction_number</td><td align='right'>$transaction_amount</td><td align='center'>$transaction_type</td><td align='center'>$source_id</td>";
//Dodd/Bass
if($beacnum=='60032781' or $beacnum=='60032793'){echo "<td><table border='1'><tr><td><a href='post_update.php?transaction_type=$transaction_type&source_id=$source_id&center=$center&acct=$acct' target='_blank'>Mark Paid</a></td></tr></table></td>";}
echo "</tr>";
}
$totAmount=number_format($totAmount,2);
echo "<tr><td colspan='5' align='right'><b>$totAmount</b></td></tr></table></body></html>";
//} // not usign f_year.php
?>