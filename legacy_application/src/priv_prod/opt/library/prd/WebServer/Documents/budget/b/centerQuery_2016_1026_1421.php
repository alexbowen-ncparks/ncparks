<?php
$sql = "truncate table cid_fund_balances";
$result = @mysql_query($sql);

//if($level>4){$showSQL=1;}

$sql = "INSERT  INTO cid_fund_balances( center, fundsin, fundsout, payments )
SELECT fund_in, sum( amount ) ,  '',  ''
FROM partf_fund_trans
GROUP  BY fund_in";
$result = @mysql_query($sql);
if($showSQL=="1"){echo "<br><br>$sql";}

//echo "<br><br>$sql";//exit;
$sql = "INSERT  INTO cid_fund_balances( center, fundsin, fundsout, payments )
SELECT fund_out,  '', sum( amount ) ,  ''
FROM partf_fund_trans
GROUP  BY fund_out";
$result = @mysql_query($sql);
if($showSQL=="1"){echo "<br><br>$sql";}

//echo "<br><br>$sql";//exit;
$sql = "INSERT  INTO cid_fund_balances( center, fundsin, fundsout, payments )
SELECT center,  '',  '', sum( amount )
FROM partf_payments
GROUP  BY center";
//echo "$sql";exit;
$result = @mysql_query($sql);
if($showSQL=="1"){echo "<br><br>$sql";}

//echo "<br><br>$sql";//exit;
$sql = "SELECT cid_fund_balances.center, center.center_desc, sum( fundsin - fundsout )  AS  'funds_allocated', sum( payments )  AS  'payments', sum( fundsin - fundsout - payments )  AS  'balance'
FROM cid_fund_balances
LEFT  JOIN center ON cid_fund_balances.center = center.new_center
WHERE cid_fund_balances.center =  '$center'
GROUP  BY center";
if($showSQL=="1"){echo "<br><br>$sql<br><br><b>file: b/centerQuery.php</b><br>";}

//echo "<br><br>$sql";//exit;
?>