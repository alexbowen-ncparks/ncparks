<?php
//These are placed outside of the webserver directory for security

session_start();

if(!$_SESSION["budget"]["tempID"]){echo "access denied";exit;
}

$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database

//session_start();
include("../../../include/activity.php");
extract($_REQUEST);
$level=$_SESSION['budget']['level'];
//$center=$_SESSION['budget']['centerSess'];
// Construct Query to be passed to Excel Export
//$varQuery="submit=Submit&center=$center&budget_group=$budget_group&track_rcc=$track_rcc";
$varQuery="submit=Submit&center=$center";

//print_r($_SESSION);//EXIT;
//print_r($_REQUEST);//EXIT;


// ******** Edit/Update Status ***********
if($p_ok=="y" and $level>4){

$query="UPDATE `cid_vendor_invoice_payments` 
set post2ncas='y'
WHERE id='$idPass'";
//echo "$query<br>";exit;
$result = mysqli_query($connection, $query) or die ("Couldn't execute query 0. $query");
}// end if


$m="trans_unpost";
if($rep==""){include("../menu.php");}


if($level<2){$center=$_SESSION['budget']['centerSess'];//$submit="submit";
}

if($rep==""){

// Display Form
echo "<html><header></header<title></title><body>
<table align='center'><form method='POST' action='transactions_unposted.php'>";

if($level>1){
echo "<tr><td colspan='3'>";
$sql="SELECT section,parkcode,center as varCenter from center where fund='1280' order by section,parkcode,center";
$result = mysqli_query($connection, $sql) or die ("Couldn't execute query 1. $sql");
while ($row=mysqli_fetch_array($result)){
extract($row);$pc[]=$parkcode;$c[]=$varCenter;$sec[]=$section;}

//print_r($c);

echo "<select name=\"center\" onChange=\"MM_jumpMenu('parent',this,0)\"><option selected>Select Center</option>";
for ($n=0;$n<count($c);$n++){
$show=$sec[$n]."-".$pc[$n]."-".$c[$n];
if($center==$c[$n]||$center==$show){$s="selected";}else{$s="value";}
$con=$c[$n];
		echo "<option $s='transactions_unposted.php?m=trans_unpost&center=$con'>$show</option>\n";
       }
   echo "</select></td>";}

if($level>3){echo "<td><input type='text' name='center' size='8'><input type='hidden' name='m' value='trans_unpost'><input type='submit' name='m' value='Find'></td>";}

if($center==""||$center=="Select Center"){echo "<font color='red'>You must select a Center.</font>";exit;}
echo "<tr><td colspan='7'><a href='transactions_unposted.php?$varQuery&rep=excel'>Excel Export</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<font color='DarkRed' size='+1'>$message</font></td></tr>";

echo "</table>";
}

//echo "c1=$center";

$find="-";
$testStr=strpos($center,$find);
if($testStr>0){
$cen=explode("-",$center);
$center=$cen[2];
}

// ********** Queries ***********
 $query = "truncate table budget1_unposted;";
    $result = @mysqli_query($connection, $query,$connection);
if($showSQL=="1"){echo "$query<br><br>";}

/*inserts  */
 $query = "insert into budget1_unposted(
center,
account,
vendor_name,
transaction_date,
transaction_number,
transaction_amount,
transaction_type,
source_table,
source_id
)
select
ncas_center,
ncas_account,
vendor_name,
datesql,
ncas_invoice_number,
ncas_invoice_amount,'cdcs','cid_vendor_invoice_payments',
id
from cid_vendor_invoice_payments
where 1
and post2ncas != 'y'
group by id";
 $result = @mysqli_query($connection, $query,$connection);
if($showSQL=="1"){echo "$query<br><br>";}

/*inserts   */
 $query = "insert into budget1_unposted(
center,
account,
vendor_name,
transaction_date,
transaction_number,
transaction_amount,
transaction_type,
source_table,
source_id
)
select
center,
ncasnum,
concat('pcard','-',cardholder,'-',vendor_name,'-',trans_date),
transdate_new,
transid_new,
sum(amount),'pcard','pcard_unreconciled',
id
from pcard_unreconciled
where 1
and ncas_yn != 'y'
group by id;";
  $result = @mysqli_query($connection, $query,$connection);
if($showSQL=="1"){echo "$query<br><br>";}

/*inserts */
 $query = "insert into budget1_unposted(
center,
account,
vendor_name,
transaction_date,
transaction_number,
transaction_amount,
transaction_type,
source_table,
source_id
)
select
center,
ncasnum,
concat(postitle,'-',posnum,'-',tempid),
datework,'na',
sum(rate*hr1311),'seapay','seapay_unposted',
prid
from seapay_unposted
where 1
group by prid";
 $result = @mysqli_query($connection, $query,$connection);
if($showSQL=="1"){echo "$query<br><br>";}

$sql="Select *
from budget1_unposted
where center='$center'
order by center,account";

if($showSQL||$level>4){
echo "$sql<br><br>";//exit;
}

//echo "$sql<br><br>";//exit;

$result = mysqli_query($connection, $sql) or die ("Couldn't execute query. $sql");
$num=mysqli_num_rows($result);

if($rep=="excel"){header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment; filename=transactions_unposted.xls');
}

// Display Results
echo "<html><header></header><title>Transactions Unposted</title><body>";
//echo "<table border='1'><tr bgcolor='burlywood'><td>Transactions Unposted</td></tr></table>";
echo "<table align='left'><tr><th>Transactions Unposted</th></tr></table><br /><br />";
echo "<table border='1' align='center'><tr><td colspan='4' align='center'><font color='blue'>$num</font> records returned</td>";

//echo "<td colspan='4' align='center'><a href='transaction_unposted.php?$varQuery'>Excel</a> Export</td>";

//echo "<td colspan='4' align='center'><a href='/budget/c/operating_expense_available.php'>Operating Budget Available</a></td>";

echo "</tr>";

$header="<tr><th>center</th><th>account</th><th>vendor_name</th><th>transaction_date</th><th>transaction_number</th><th>transaction_type</th><th>transaction_amount</th><th>source_id</th>";
//echo "<th>quick<br>post</th>";
echo "</tr>";
echo "$header";

if($message!=""){$_SESSION['budget']['checkID'][]=$idRow;}

while($row=mysqli_fetch_array($result)){
extract($row); 
$amtTotal+=$transaction_amount;$amt=$amount;
$amount=number_format($amount,2);

if($ckNCAS!="" AND $ckNCAS!=$ncas_account){echo "<tr><td colspan='8'>&nbsp;</td></tr>";}
$ckNCAS=$ncas_account;

if(in_array($id,$_SESSION['budget']['checkID'])){
$rc=" bgcolor='yellow'";}
else{$rc="";
if($p_ok=="y" and $id==$idPass){$rc=" bgcolor='aliceblue'";}
}

echo "<tr$rc><td align='center'>$center</td><td>$account</td><td width='150'>$vendor_name</td><td>$transaction_date</td><td align='center'>$transaction_number</td><td>$transaction_type</td><td align='right'>$transaction_amount</td><td align='right'>$source_id</td>";
/*
echo "<td align='center'><a href='quick_lookup.php?submit=submit&center=$center&budget_group=$budget_group&amount=$amt&id=$id'>lookup</a></td>";
*/
echo "</tr>";
}
$amtTotal=number_format($amtTotal,2);
echo "<tr><td colspan='7' align='right'>$amtTotal</td></tr>";
echo "</table></body></html>";

?>