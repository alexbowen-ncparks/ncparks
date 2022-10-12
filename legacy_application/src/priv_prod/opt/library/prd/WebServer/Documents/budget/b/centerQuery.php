<?php
//echo "<br /><b>WELCOME centerQuery.php</b><br />";

$query = "truncate table budget.cid_fund_balances_unposted ";
$result = @mysqli_query($connection, $query);

$query = "insert into cid_fund_balances_unposted( center, project_number,account, vendor_name, system_entry_date, transaction_date, transaction_number, transaction_type, transaction_amount,source_id,parkcode) select ncas_center, project_number,ncas_account, vendor_name, system_entry_date, datesql, ncas_invoice_number,'cdcs', ncas_invoice_amount, id,'' from cid_vendor_invoice_payments where 1 and post2ncas != 'y' and ncas_credit != 'x' group by id;
";
$result = @mysqli_query($connection, $query);

$query = "insert into cid_fund_balances_unposted( center, project_number,account, vendor_name, system_entry_date, transaction_date, transaction_number, transaction_type, transaction_amount,source_id,parkcode) select ncas_center, project_number,ncas_account, vendor_name, system_entry_date, datesql, ncas_invoice_number,'cdcs', -ncas_invoice_amount, id,'' from cid_vendor_invoice_payments where 1 and post2ncas != 'y' and ncas_credit = 'x' group by id;
";
$result = @mysqli_query($connection, $query);

$query = "insert into cid_fund_balances_unposted(center, project_number,account, vendor_name, system_entry_date, transaction_date, transaction_number, transaction_type, transaction_amount,source_id,parkcode,pcard_admin,pcard_report_date,pcard_start_date,pcard_end_date  ) 
          select center, projnum,ncasnum, concat('pcard','-',cardholder,'-',vendor_name,'-',trans_date), xtnd_rundate_new,transdate_new, transid_new, 'pcard',sum(amount), pcard_unreconciled.id,'',admin_num,pcard_unreconciled.report_date,pcard_report_dates.xtnd_start,pcard_report_dates.xtnd_end 
		  from pcard_unreconciled
		  left join pcard_report_dates on pcard_unreconciled.report_date=pcard_report_dates.report_date
		  where 1 and ncas_yn != 'y' group by id;
";
$result = @mysqli_query($connection, $query);




$sql = "truncate table cid_fund_balances";
$result = @mysqli_query($connection, $sql);

//if($level>4){$showSQL=1;}

$sql = "INSERT  INTO cid_fund_balances( center, fundsin, fundsout, payments )
SELECT fund_in, sum( amount ) ,  '',  ''
FROM partf_fund_trans
GROUP  BY fund_in";
$result = @mysqli_query($connection, $sql);
if($showSQL=="1"){echo "<br><br>$sql";}

//echo "<br><br>$sql";//exit;
$sql = "INSERT  INTO cid_fund_balances( center, fundsin, fundsout, payments )
SELECT fund_out,  '', sum( amount ) ,  ''
FROM partf_fund_trans
GROUP  BY fund_out";
$result = @mysqli_query($connection, $sql);
if($showSQL=="1"){echo "<br><br>$sql";}

//echo "<br><br>$sql";//exit;
$sql = "INSERT  INTO cid_fund_balances( center, fundsin, fundsout, payments )
SELECT center,  '',  '', sum( amount )
FROM partf_payments
GROUP  BY center";
//echo "$sql";exit;
$result = @mysqli_query($connection, $sql);



$sql = "INSERT  INTO cid_fund_balances( center, fundsin, fundsout, payments,unposted )
SELECT center,  '',  '', '', sum(transaction_amount)
FROM cid_fund_balances_unposted
GROUP  BY center";
//echo "$sql";exit;
$result = @mysqli_query($connection, $sql);





if($showSQL=="1"){echo "<br><br>$sql";}

$query1="SELECT count(ceid) as 'rec_count' from center
         where new_center='$center' ";
		 
//echo "<br />Query1=$query1<br />";

$result1 = mysqli_query($connection, $query1) or die ("Couldn't execute query 1.  $query1");

$row1=mysqli_fetch_array($result1);
extract($row1);//brings back max (end_date) as $end_date
//echo "<br />rec_count=$rec_count<br />";



if($rec_count==0)
{
//echo "<br><br>$sql";//exit;
$sql = "SELECT cid_fund_balances.center, center.center_desc,center.f_year_funded, sum( fundsin - fundsout )  AS  'funds_allocated', sum( payments )  AS  'payments', sum( fundsin - fundsout - payments )  AS  'balance',sum(unposted) as 'unposted_total',sum(fundsin-fundsout-payments-unposted) as 'center_avail_funds'
FROM cid_fund_balances
LEFT  JOIN center ON cid_fund_balances.center = center.center
WHERE cid_fund_balances.center =  '$center'
GROUP  BY center";
}


if($rec_count==1)
{
//echo "<br><br>$sql";//exit;
$sql = "SELECT cid_fund_balances.center, center.center_desc,center.f_year_funded, sum( fundsin - fundsout )  AS  'funds_allocated', sum( payments )  AS  'payments', sum( fundsin - fundsout - payments )  AS  'balance',sum(unposted) as 'unposted_total',sum(fundsin-fundsout-payments-unposted) as 'center_avail_funds'
FROM cid_fund_balances
LEFT  JOIN center ON cid_fund_balances.center = center.new_center
WHERE cid_fund_balances.center =  '$center'
GROUP  BY center";
}


//echo "<br><br>Line 66: $sql";  exit;











if($showSQL=="1"){echo "<br><br>$sql<br><br><b>file: b/centerQuery.php</b><br>";}

//echo "<br><br>$sql";//exit;
?>