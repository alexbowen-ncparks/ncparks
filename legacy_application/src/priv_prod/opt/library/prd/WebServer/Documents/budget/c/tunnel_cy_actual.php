<?php
// called from budget/c/operating_expense_available.php
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

//echo "<pre>";print_r($_REQUEST);"</pre>";  //exit;
//echo "<pre>";print_r($_SESSION);"</pre>"; //exit;
$center_first4=substr($center,0,4);
//echo "<br />center_first4=$center_first4<br />";



// Construct Query to be passed to Excel Export
$varQuery="submit=Submit&center=$center&budget_group=$budget_group&track_rcc=y";

//print_r($_SESSION);//EXIT;
//echo "<pre>";print_r($_REQUEST);echo "</pre>";EXIT;

$level=$_SESSION[budget][level];

//if($rep=="" and !$id){include("../menu.php");}
if($level<2){$center=$_SESSION[budget][centerSess_new];}

if($level>1 and $center_first4=='1280')
{

$query10="SELECT new_center from center where center='$center' ";
//echo "query10=$query10<br />";
$result10=mysqli_query($connection, $query10) or die ("Couldn't execute query 10. $query10");

$row10=mysqli_fetch_array($result10);

extract($row10);

$center=$new_center;



}

if($rep==""){

// Display Form
echo "<html><header></header<title></title><body>
<table align='center'><tr>";

echo "</table>";
}

//$s=strpos($center,"-");
//if($s>0){$cen=explode("-",$center);$center=$cen[2];}

// Make f_year
if($f_year==""){

include("../~f_year.php");

}


/*
if($rep=="excel"){header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment; filename=quick_lookup.xls');
}
*/

$sql="SELECT max(acctdate) as maxDate from exp_rev WHERE 1";
$result = mysqli_query($connection, $sql) or die ("Couldn't execute query. $sql");
$row=mysqli_fetch_array($result);extract($row);
if($showSQL){echo "$sql<br><br>";}


$sql="SELECT f_year, exp_rev.center, acctdate AS 'postdate', acct AS 'account', park_acct_desc AS 'description', exp_rev.description AS 'vendor', invoice, sum( debit - credit ) AS 'amount', center.center_desc
FROM exp_rev
LEFT JOIN coa ON exp_rev.acct = coa.ncasnum
LEFT JOIN center ON exp_rev.center = center.new_center
WHERE 1 AND exp_rev.center = '$center' AND acct = '$acct' AND f_year = '$f_year'
GROUP BY exp_rev.whid
order by acctdate desc";
if($showSQL){echo "$sql<br><br>";}
$result = mysqli_query($connection, $sql) or die ("Couldn't execute query. $sql");
$num=mysqli_num_rows($result);
if($num==1){$r="Transaction";}else{$r="Transactions";}

echo "$sql<br><br>";//exit;

// Display Results
echo "<html><header></header><title>CY_Actual Tunnel Down</title><body>
<table align='center' cellpadding='6'>";
/*
echo "<tr><td colspan='4' align='center'><font color='green' size='+1'><br>Your Search Found $num <font color='red'>POSTED</font> Transactions for</font> $center_desc $center $acct which totals $cy_actual</td></tr>";

echo "<tr><th>vendor</th><th>postdate</th><th>transaction_number</th><th>amount</th></tr>
";
*/

while($row=mysqli_fetch_array($result)){
extract($row); $totAmount+=$amount;
if(!$i){$cy_actual=number_format($cy_actual,2);
echo "<tr><td colspan='4' align='center'><font color='green' size='+1'><br>Your Search Found $num <font color='red'>POSTED</font> $r for</font> <font color='blue'>$center_desc</font> $center $acct which totals $cy_actual</td></tr>";

echo "<tr><th>vendor</th><th>postdate</th><th>transaction_number</th><th>amount</th></tr>
";
$i=1;}

echo "<tr><td align='center'>$vendor</td><td align='center'>$postdate</td><td align='center'>$invoice</td><td align='right'>$amount</td></tr>";
}
$totAmount=number_format($totAmount,2);
echo "<tr><td colspan='8' align='right'><b>$totAmount</b></td></tr></table></body></html>";
//} end if f_year
?>