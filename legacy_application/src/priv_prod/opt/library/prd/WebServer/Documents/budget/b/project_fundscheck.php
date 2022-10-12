<?php
//if($level>4){$showSQL=1;}else{$showSQL="";}
$sql = "CREATE temporary TABLE `cid_fund_balances1` (
`center` varchar( 15 ) NOT NULL default '',
`fundsin` decimal( 12, 2 ) NOT NULL default '0.00',
`fundsout` decimal( 12, 2 ) NOT NULL default '0.00',
`payments` decimal( 12, 2 ) NOT NULL default '0.00',
`unposted` decimal( 12, 2 ) NOT NULL default '0.00',
`id` int( 10 ) unsigned NOT NULL AUTO_INCREMENT ,
PRIMARY KEY ( `id` )
) ENGINE = MyISAM ;
";
$result = @mysqli_query($connection, $sql);
if($showSQL=="1"){echo "<br><br>$sql";}


$sql = "INSERT INTO cid_fund_balances1( center, fundsin, fundsout, payments )
select fund_in,sum(amount),'',''
from partf_fund_trans
where fund_in=
'$center'
group by fund_in;
";
$result = @mysqli_query($connection, $sql);
if($showSQL=="1"){echo "<br><br>$sql";}

//echo "<br><br>$sql";//exit;
$sql = "INSERT INTO cid_fund_balances1( center, fundsin, fundsout, payments )
SELECT fund_out, '', sum( amount ) , ''
from partf_fund_trans
where fund_out=
'$center'
group by fund_out;
";
$result = @mysqli_query($connection, $sql);
if($showSQL=="1"){echo "<br><br>$sql";}

//echo "<br><br>$sql";//exit;
$sql = "INSERT INTO cid_fund_balances1( center, fundsin, fundsout, payments )
select center,'','',sum(amount)
from partf_payments
where center=
'$center'
group by center;
";
//echo "$sql";exit;
$result = @mysqli_query($connection, $sql);
if($showSQL=="1"){echo "<br><br>$sql";}

//echo "<br><br>$sql";//exit;
$sql = "insert into cid_fund_balances1(center,unposted)
select ncas_center,sum(ncas_invoice_amount)
FROM cid_vendor_invoice_payments 
where ncas_center=
'$center'
and post2ncas != 'y'
and ncas_credit != 'x'
group by ncas_center;
";
//echo "$sql";exit;
$result = @mysqli_query($connection, $sql);
if($showSQL=="1"){echo "<br><br>$sql";}

//echo "<br><br>$sql";//exit;
$sql = "INSERT INTO cid_fund_balances1( center,unposted )
SELECT ncas_center, -sum(ncas_invoice_amount )
FROM cid_vendor_invoice_payments 
where ncas_center=
'$center'
and post2ncas != 'y'
and ncas_credit = 'x'
group by ncas_center;
";
//echo "$sql";exit;
$result = @mysqli_query($connection, $sql);
if($showSQL=="1"){echo "<br><br>$sql";}

//echo "<br><br>$sql";//exit;
$sql = "INSERT INTO cid_fund_balances1( center,unposted )
select center,sum(amount)
from pcard_unreconciled
where center=
'$center'
and ncas_yn != 'y' 
group by center;
";
//echo "$sql";exit;
$result = @mysqli_query($connection, $sql);
if($showSQL=="1"){echo "<br><br>$sql";}

//echo "<br><br>$sql";//exit;
$sql = "select
cid_fund_balances1.center,
center.center_desc,
center.stop_pay,
sum(fundsin-fundsout) as 'funds_allocated',
sum(payments) as 'posted_payments',
sum(fundsin-fundsout-payments) as 'posted_balance',
sum(unposted) as 'unposted_payments',
sum(fundsin-fundsout-payments-unposted) as 'available_funds'
from cid_fund_balances1
left join center on cid_fund_balances1.center=center.new_center
where cid_fund_balances1.center=
'$center'
group by cid_fund_balances1.center;
";
if($showSQL=="1"){echo "<br><br>$sql<br><br><b>file: b/project_fundscheck.php</b><br>";}
echo "sql=$sql<br />";
echo "File: project_fundscheck ";//exit;
?>