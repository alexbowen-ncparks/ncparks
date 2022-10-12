<?php
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
$sql = "SELECT cid_fund_balances.center, center.center_desc, sum( fundsin - fundsout )  AS  'funds_allocated', sum( payments )  AS  'payments', sum( fundsin - fundsout - payments )  AS  'balance'
FROM cid_fund_balances
LEFT  JOIN center ON cid_fund_balances.center = center.center
WHERE cid_fund_balances.center =  '$center'
GROUP  BY center";
}


if($rec_count==1)
{
//echo "<br><br>$sql";//exit;
$sql = "SELECT cid_fund_balances.center, center.center_desc, sum( fundsin - fundsout )  AS  'funds_allocated', sum( payments )  AS  'payments', sum( fundsin - fundsout - payments )  AS  'balance'
FROM cid_fund_balances
LEFT  JOIN center ON cid_fund_balances.center = center.new_center
WHERE cid_fund_balances.center =  '$center'
GROUP  BY center";
}


echo "<br><br>Line 66: $sql";  //exit;











if($showSQL=="1"){echo "<br><br>$sql<br><br><b>file: b/centerQuery.php</b><br>";}

//echo "<br><br>$sql";//exit;
?>