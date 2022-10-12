<?php
// called from budget/c/operating_expense_available.php
//These are placed outside of the webserver directory for security

session_start();

if(!$_SESSION["budget"]["tempID"]){echo "access denied";exit;
}



include("../../../include/authBUDGET.inc"); // used to authenticate users
$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
include("../../../include/activity.php");

// Construct Query to be passed to Excel Export
foreach($_REQUEST as $k => $v){
if($k!="PHPSESSID"){$varQuery.=$k."=".$v."&";}
}
//echo "$varQuery";exit;
session_start();
extract($_REQUEST);
//print_r($_SESSION);//EXIT;
//echo "<pre>";print_r($_REQUEST);echo "</pre>";EXIT;

$level=$_SESSION['budget']['level'];

//if($rep=="" and !$id){include("../menu.php");}
if($level<2){$center=$_SESSION['budget']['centerSess_new'];}

if($rep==""){

// Display Form
echo "<html><header></header<title></title><body>
<table align='center'><tr>";

echo "</table>";
}

include("../~f_year.php");

/*
if($rep=="excel"){header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment; filename=quick_lookup.xls');
}
*/

/*
$sql="SELECT max(acctdate) as maxDate from exp_rev WHERE 1";
$result = mysqli_query($connection, $sql) or die ("Couldn't execute query. $sql");
$row=mysqli_fetch_array($result);extract($row);
*/

$sql="Select center,ncas_acct,fy_req,allocation_date,allocation_amount,allocation_justification,allocation_level as 'source',budget_group,comments
from budget_center_allocations
where fy_req='$f_year'
and center='$center'
and ncas_acct='$acct'
order by allocation_date desc
";
if($showSQL){echo "$sql<br><br>";}
$result = mysqli_query($connection, $sql) or die ("Couldn't execute query. $sql");
$num=mysqli_num_rows($result);
if($num==1){$r="Transaction";}else{$r="Transactions";}

//echo "$sql<br><br>";//exit;

// Display Results
echo "<html><header></header><title>CY_Allocation Tunnel Down</title><body>
<table align='center' cellpadding='6'>";


while($row=mysqli_fetch_array($result)){
extract($row); $totAmount+=$allocation_amount;
if(!$i){$py_amount=number_format($passedAmount,2);
//<font color='red'>POSTED</font>
echo "<tr><td colspan='4' align='center'><font color='green' size='+1'><br>Your Search Found $num  $r for</font> <font color='blue'>$center_desc</font> $center $acct which totals $py_amount</td></tr>";


//{$h=str_replace("_","<br>",$h);}

echo "<tr><th>fy_req</th><th align=left>transfer_date</th><th align=left>transfer<br />amount</th><th align=left>transfer_source</th><th align=left>transfer_type</th><th align=center>comments</th></tr>
";
$i=1;}

echo "<tr><td align='center'>$fy_req</td><td>$allocation_date</td><td align='left'>$allocation_amount</td><td>$source</td><td>$allocation_justification</td><td align=center>$comments</td></tr>";
}
$totAmount=number_format($totAmount,2);
echo "<tr><td></td><td></td><td align='left'<b>$totAmount</b></td></tr></table></body></html>";
//echo "<tr><td colspan='3' align='left'><b>$totAmount</b></td></tr></table></body></html>";
?>