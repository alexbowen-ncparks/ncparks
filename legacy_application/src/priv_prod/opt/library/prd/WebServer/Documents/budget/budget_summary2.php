<?php
session_start();

if(!$_SESSION["budget"]["tempID"]){echo "access denied";exit;
//header("location: https://10.35.152.9/login_form.php?db=budget");
//header("location: https://10.35.152.9/login_form.php?db=budget");
}


$active_file=$_SERVER['SCRIPT_NAME'];
$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempID=$_SESSION['budget']['tempID'];
$beacnum=$_SESSION['budget']['beacon_num'];
$user_activity_location=$_SESSION['budget']['select'];
$centerS=$_SESSION['budget']['centerSess'];

extract($_REQUEST);

//echo "<pre>";print_r($_SERVER);"</pre>";//exit;
echo "<pre>";print_r($_SESSION);"</pre>";//exit;
echo "<pre>";print_r($_REQUEST);"</pre>";//exit;


$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database

include("../../include/activity.php");

//include("../budget/~f_year.php");


include("~f_year.php");

$sql = "CREATE temporary TABLE `budget1_unposted1` ( `center` varchar( 15 ) NOT NULL default '', `account` varchar( 15 ) NOT NULL default '', `vendor_name` varchar( 50 ) NOT NULL default '', `transaction_date` date NOT NULL default '0000-00-00', `transaction_number` varchar( 30 ) NOT NULL default '', `transaction_amount` decimal( 12, 2 ) NOT NULL default '0.00', `transaction_type` varchar( 30 ) NOT NULL default '', `source_table` varchar( 30 ) NOT NULL default '', `source_id` varchar( 10 ) NOT NULL default '0', `post2ncas` char( 1 ) NOT NULL default 'n', `system_entry_date` date NOT NULL default '0000-00-00', `id` int( 10 ) unsigned NOT NULL AUTO_INCREMENT , PRIMARY KEY ( `id` ) ) ENGINE = MyISAM ;
";//echo "$sql";
$result = mysqli_query($connection, $sql) or die ("Couldn't execute query 4. $sql");
if($showSQL==1){echo "$sql<br /><br />";}

$sql = "insert into budget1_unposted1( center, account, vendor_name, transaction_date, transaction_number, transaction_amount, transaction_type, source_table, source_id ) select ncas_center, ncas_account, vendor_name, datesql, ncas_invoice_number, ncas_invoice_amount,'cdcs','cid_vendor_invoice_payments', id from cid_vendor_invoice_payments where 1 and post2ncas != 'y' and ncas_credit != 'x' group by id;
";//echo "$sql";
$result = mysqli_query($connection, $sql) or die ("Couldn't execute query 4. $sql");
if($showSQL==1){echo "$sql<br /><br />";}

$sql = "insert into budget1_unposted1( center, account, vendor_name, transaction_date, transaction_number, transaction_amount, transaction_type, source_table, source_id ) select ncas_center, ncas_account, vendor_name, datesql, ncas_invoice_number, -ncas_invoice_amount,'cdcs','cid_vendor_invoice_payments', id from cid_vendor_invoice_payments where 1 and post2ncas != 'y' and ncas_credit = 'x' group by id;
";//echo "$sql";
$result = mysqli_query($connection, $sql) or die ("Couldn't execute query 4. $sql");
if($showSQL==1){echo "$sql<br /><br />";}

$sql = "insert into budget1_unposted1( center, account, vendor_name, transaction_date, transaction_number, transaction_amount, transaction_type, source_table, source_id ) select center, ncasnum, concat('pcard','-',cardholder,'-',vendor_name,'-',trans_date), transdate_new, transid_new, sum(amount),'pcard','pcard_unreconciled', id from pcard_unreconciled where 1 and ncas_yn != 'y' group by id;
";//echo "$sql";
$result = mysqli_query($connection, $sql) or die ("Couldn't execute query 4. $sql");
if($showSQL==1){echo "$sql<br /><br />";}

$sql = "insert into budget1_unposted1( center, account, vendor_name, transaction_date, transaction_number, transaction_amount, transaction_type, source_table, source_id ) select center, ncasnum, concat(postitle,'-',posnum,'-',tempid), datework,'na', sum(rate*hr1311),'seapay','seapay_unposted', prid from seapay_unposted where 1 group by prid;
";//echo "$sql";
$result = mysqli_query($connection, $sql) or die ("Couldn't execute query 4. $sql");
if($showSQL==1){echo "$sql<br /><br />";}

$sql = "CREATE temporary TABLE `po_encumbrance_totals1` ( `view` char( 3 ) NOT NULL default 'all', `center` varchar( 15 ) NOT NULL default '', `account` varchar( 15 ) NOT NULL default '', `xtnd_balance` decimal( 12, 2 ) NOT NULL default '0.00', `id` int( 10 ) unsigned NOT NULL AUTO_INCREMENT , PRIMARY KEY ( `id` ) ) ENGINE = MyISAM ;
";//echo "$sql";
$result = mysqli_query($connection, $sql) or die ("Couldn't execute query 4. $sql");
if($showSQL==1){echo "$sql<br /><br />";}

$sql = "insert into po_encumbrance_totals1 (center,account,xtnd_balance) select center,acct,sum(po_remaining_encumbrance) from xtnd_po_encumbrances where 1 group by center,acct;
";//echo "$sql";
$result = mysqli_query($connection, $sql) or die ("Couldn't execute query 4. $sql");
if($showSQL==1){echo "$sql<br /><br />";}

$sql = "CREATE temporary TABLE `budget1_available1` ( `center` varchar( 15 ) NOT NULL default '', `account` varchar( 15 ) NOT NULL default '', `py1_amount` decimal( 12, 2 ) NOT NULL default '0.00', `allocation_amount` decimal( 12, 2 ) NOT NULL default '0.00', `cy_amount` decimal( 12, 2 ) NOT NULL default '0.00', `unposted_amount` decimal( 12, 2 ) NOT NULL default '0.00', `source` varchar( 30 ) NOT NULL default '0.00', `budget_group` varchar( 30 ) NOT NULL default '', `encumbered_funds` decimal( 12, 2 ) NOT NULL default '0.00', `id` int( 10 ) unsigned NOT NULL AUTO_INCREMENT , PRIMARY KEY ( `id` ) ) ENGINE = MyISAM ;
";//echo "$sql";
$result = mysqli_query($connection, $sql) or die ("Couldn't execute query 4. $sql");
if($showSQL==1){echo "$sql<br /><br />";}

$sql = "insert into budget1_available1( center, account, py1_amount, allocation_amount, cy_amount, unposted_amount, source ) select center, ncasnum, sum(amount_py1), '', sum(amount_cy),'','act3' from act3 where 1 group by center,ncasnum;
";//echo "$sql";
$result = mysqli_query($connection, $sql) or die ("Couldn't execute query 4. $sql");
if($showSQL==1){echo "$sql<br /><br />";}

$sql = "insert into budget1_available1(center,account,py1_amount,allocation_amount,cy_amount,unposted_amount,source) select center,ncas_acct,'',sum(allocation_amount),'','','budget_center_allocations' from budget_center_allocations where 1 and fy_req='$f_year' group by center,ncas_acct;
";//echo "$sql";
$result = mysqli_query($connection, $sql) or die ("Couldn't execute query 4. $sql");
if($showSQL==1){echo "$sql<br /><br />";}

$sql = "insert into budget1_available1(center,account,encumbered_funds,source) select center,account,sum(xtnd_balance),'po_encumbrance_totals1' from po_encumbrance_totals1 where 1 group by center,account;
";//echo "$sql";
$result = mysqli_query($connection, $sql) or die ("Couldn't execute query 4. $sql");
if($showSQL==1){echo "$sql<br /><br />";}

$sql = "insert into budget1_available1( center, account, py1_amount, allocation_amount, cy_amount, unposted_amount, source ) select center, account,'','','', sum(transaction_amount),'budget1_unposted1' from budget1_unposted1 where 1 and post2ncas != 'y' group by center,account;
";//echo "$sql";
$result = mysqli_query($connection, $sql) or die ("Couldn't execute query 4. $sql");
if($showSQL==1){echo "$sql<br /><br />";}


$sql = "update budget1_available1,coa set budget1_available1.budget_group=coa.budget_group where budget1_available1.account=coa.ncasnum;
";//echo "$sql";
$result = mysqli_query($connection, $sql) or die ("Couldn't execute query 4. $sql");
if($showSQL==1){echo "$sql<br /><br />";}

$sql = "select budget1_available1.budget_group, sum( py1_amount + allocation_amount) as 'cy_budget', sum( cy_amount) as 'cy_posted', sum( unposted_amount) as 'cy_unposted', sum(py1_amount+allocation_amount-cy_amount-unposted_amount) as 'available_funds',sum(py1_amount+allocation_amount)/12 as 'monthly_budget',round((sum(cy_amount+unposted_amount)/(sum(py1_amount+allocation_amount)/12)),1) as 'months_used' from budget1_available1  left join coa on budget1_available1.account=coa.ncasnum where 1 and budget1_available1.center='$centerS' and coa.track_center='y' group by budget1_available1.budget_group order by budget1_available1.budget_group;
";//echo "$sql";
$result = mysqli_query($connection, $sql) or die ("Couldn't execute query 4. $sql");
if($showSQL==1){echo "$sql<br /><br />";}
echo "<table border='1'>";
echo "<tr>
<th>budget_group</th>
<th>cy_budget</th>
<th>cy_posted</th>
<th>cy_unposted</th>
<th>available_funds</th>
<th>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
<th>monthly_budget</th>
<th>months_used</th>
</tr>";
while($row=mysqli_fetch_array($result)){
extract($row);
if($available_funds<0){$f1="<font color='red'>";$f2="</font>";}else{$f1="<font color='green'>";$f2="</font>";}
$cy_budget=number_format($cy_budget,2);
$cy_posted=number_format($cy_posted,2);
$cy_unposted=number_format($cy_unposted,2);
$available_funds=number_format($available_funds,2);
$monthly_budget=number_format($monthly_budget,2);
echo "<tr>
<td align='right'><a href='/budget/a/current_year_budget.php?center=$centerS&budget_group_menu=$budget_group&submit=x'>$budget_group</a></td>
<td align='right'>$cy_budget</td>
<td align='right'>$cy_posted</td>
<td align='right'>$cy_unposted</td>
<td align='right'>$f1$available_funds$f2</td>
<td></td>
<td align='right'>$monthly_budget</td>
<td align='right'>$months_used</td>
</tr>";
}
echo "</table>";

?>