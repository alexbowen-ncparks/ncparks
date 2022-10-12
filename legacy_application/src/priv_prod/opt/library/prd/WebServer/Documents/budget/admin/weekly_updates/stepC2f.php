<?php



$sql="truncate table reconcilement_dpr";
mysqli_query($connection, $sql) or die ("Couldn't execute query sql.  $sql");

    
$sql="insert into reconcilement_dpr(fund,cab_dpr,bd725_dpr,exp_rev)
select fund,sum(disburse_amt-receipt_amt),'',''
from cab_dpr
where 1 and f_year='$fiscal_year'
and dpr_valid='y'
group by cab_dpr.fund";
mysqli_query($connection, $sql) or die ("Couldn't execute query sql.  $sql");


$sql="insert into reconcilement_dpr(fund,cab_dpr,bd725_dpr,exp_rev)
select fund,'',sum(disburse_amt-receipt_amt),''
from bd725_dpr
where 1 and f_year='$fiscal_year'
and dpr='y'
group by bd725_dpr.fund";
mysqli_query($connection, $sql) or die ("Couldn't execute query sql.  $sql");

$sql="insert into reconcilement_dpr(fund,cab_dpr,bd725_dpr,exp_rev)
select fund,'','',sum(debit-credit)
from exp_rev_ws
where 1 and f_year='$fiscal_year'
group by exp_rev_ws.new_fund";
mysqli_query($connection, $sql) or die ("Couldn't execute query sql.  $sql");


$sql="truncate table reconcilement_dpr2";
mysqli_query($connection, $sql) or die ("Couldn't execute query sql.  $sql");


$sql="insert into reconcilement_dpr2(fund,cab_dpr,bd725_dpr,exp_rev,oob)
select fund,cab_dpr,bd725_dpr,sum(exp_rev) as 'exp_rev', sum(cab_dpr+bd725_dpr-exp_rev) as 'oob'
from reconcilement_dpr
where 1
and (fund != '1685' and fund != '2235' and fund != '2802' and fund != '2803' and fund != '2605')
group by fund";

mysqli_query($connection, $sql) or die ("Couldn't execute query sql.  $sql");

$sql="update reconcilement_dpr2 set oob=cab_dpr+bd725_dpr-exp_rev where 1";

mysqli_query($connection, $sql) or die ("Couldn't execute query sql.  $sql");

$sql="select id from reconcilement_dpr2 where oob != '0.00' ";
//echo "<br />line 75: sql=$sql";
$result=mysqli_query($connection, $sql) or die ("Couldn't execute query sql.  $sql");

$num24=mysqli_num_rows($result);
//echo "<br />line 79: num24=$num24<br />"; exit;

	

if($num24!=0)
{
echo "<table align='center'><tr><td><font size='5'>TABLE=exp_rev_ws OUT of Balance</font><a href='/budget/b/reconcile.php?fy=$fiscal_year&fromTable=exp_rev_ws&submit=Submit' target='_blank'>VIEW</a></td></tr></table>";
exit;	

}

/*
if($num24==0)
{
echo "<table align='center'><tr><td><font size='5'>TABLE=exp_rev_ws is BALANCED!</font></td></tr></table>";
exit;	

}

*/



 ?>