<?php
include("~f_year.php");
if(!isset($showSQL)){$showSQL="";}
//echo "<br />concession_location=$concession_location<br />";
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

$sql = "CREATE temporary TABLE `budget1_available1` ( `center` varchar( 15 ) NOT NULL default '',`center_description` varchar( 75 ) NOT NULL default '',`center_code` varchar( 4 ) NOT NULL default '', `region` varchar( 15 ) NOT NULL default '',`district` varchar( 15 ) NOT NULL default '', `account` varchar( 15 ) NOT NULL default '', `account_description` varchar( 50 ) NOT NULL default '',`py1_amount` decimal( 12, 2 ) NOT NULL default '0.00', `allocation_amount` decimal( 12, 2 ) NOT NULL default '0.00', `cy_amount` decimal( 12, 2 ) NOT NULL default '0.00', `unposted_amount` decimal( 12, 2 ) NOT NULL default '0.00', `source` varchar( 30 ) NOT NULL default '0.00', `budget_group` varchar( 30 ) NOT NULL default '', `encumbered_funds` decimal( 12, 2 ) NOT NULL default '0.00', `id` int( 10 ) unsigned NOT NULL AUTO_INCREMENT , PRIMARY KEY ( `id` ) ) ENGINE = MyISAM ;
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


$sql = "update budget1_available1,coa
        set budget1_available1.budget_group=coa.budget_group,budget1_available1.account_description=coa.park_acct_desc
		where budget1_available1.account=coa.ncasnum;
";//echo "$sql";
$result = mysqli_query($connection, $sql) or die ("Couldn't execute query 4. $sql");


$sql = "update budget1_available1,center
        set budget1_available1.region=center.region,budget1_available1.center_description=center.center_desc,budget1_available1.center_code=center.parkcode
		where budget1_available1.center=center.new_center
		and budget1_available1.center like '1680%'
";//echo "$sql";
$result = mysqli_query($connection, $sql) or die ("Couldn't execute query 4. $sql");


$sql = "update budget1_available1,center
        set budget1_available1.district=center.dist
		where budget1_available1.center=center.new_center
		and budget1_available1.center like '1680%'
";//echo "$sql";
$result = mysqli_query($connection, $sql) or die ("Couldn't execute query 4. $sql");



$sql = "truncate table budget1_available1_test2 ";
$result = mysqli_query($connection, $sql) or die ("Couldn't execute query 4. $sql");

$sql = "insert into budget1_available1_test2
        select * from budget1_available1 ";
$result = mysqli_query($connection, $sql) or die ("Couldn't execute query 4. $sql");

$sql = "delete from budget1_available1_test2
        where (py1_amount='0.00' and allocation_amount='0.00' and cy_amount='0.00' and unposted_amount='0.00' and encumbered_funds='0.00') ";
		
$result = mysqli_query($connection, $sql) or die ("Couldn't execute query 4. $sql");


$sql = "delete from budget1_available1_test2
        where center not like '1680%' ";
		
$result = mysqli_query($connection, $sql) or die ("Couldn't execute query 4. $sql");
/*
$sql = "update budget1_available1_test2 set valid_center='n' where 1 ";
		
$result = mysqli_query($connection, $sql) or die ("Couldn't execute query 4. $sql");
*/





$sql = "truncate table budget1_available1_test3 ";
$result = mysqli_query($connection, $sql) or die ("Couldn't execute query 4. $sql");

$sql = "insert into budget1_available1_test3(center,center_code,region,budget_group,py1_amount,allocation_amount,cy_amount,unposted_amount)
        select center,center_code,region,budget_group,sum(py1_amount),sum(allocation_amount),sum(cy_amount),sum(unposted_amount)
        from budget1_available1_test2 where 1 group by center,budget_group		";

$result = mysqli_query($connection, $sql) or die ("Couldn't execute query 4. $sql");


$sql = "update budget1_available1_test3
        set budget_amount=py1_amount+allocation_amount,spent_amount=cy_amount+unposted_amount
		where 1";

$result = mysqli_query($connection, $sql) or die ("Couldn't execute query 4. $sql");

$sql = "update budget1_available1_test3
        set available_amount=budget_amount-spent_amount
		where 1";

$result = mysqli_query($connection, $sql) or die ("Couldn't execute query 4. $sql");


$sql = "update budget1_available1_test3
        set months_used=spent_amount/(budget_amount/12)
		where 1";

$result = mysqli_query($connection, $sql) or die ("Couldn't execute query 4. $sql");


$sql = "update budget1_available1_test3 as t1,center as t2
        set t1.district=t2.dist
		where t1.center=t2.new_center
		and t2.new_center like '1680%' ";

$result = mysqli_query($connection, $sql) or die ("Couldn't execute query 4. $sql");







$sql = "truncate table budget1_available1_test4 ";
$result = mysqli_query($connection, $sql) or die ("Couldn't execute query 4. $sql");

$sql = "insert into budget1_available1_test4(region,district,budget_group,py1_amount,allocation_amount,budget_amount,cy_amount,unposted_amount,spent_amount,available_amount)
        select region,district,budget_group,sum(py1_amount),sum(allocation_amount),sum(budget_amount),sum(cy_amount),sum(unposted_amount),sum(spent_amount),sum(available_amount)
        from budget1_available1_test3 where 1 group by district,budget_group		";

$result = mysqli_query($connection, $sql) or die ("Couldn't execute query 4. $sql");



$sql = "update budget1_available1_test4
        set months_used=spent_amount/(budget_amount/12)
		where 1";

$result = mysqli_query($connection, $sql) or die ("Couldn't execute query 4. $sql");


//echo "<br />budget_summary_repopulate.php  LINE: 178<br />"; exit;


?>