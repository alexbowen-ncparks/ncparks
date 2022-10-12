<?php
//session_start();

session_start();

if(!$_SESSION["budget"]["tempID"]){echo "access denied";exit;
}



include("../../../include/authBUDGET.inc");
//echo "<pre>";print_r($_SESSION);echo "</pre>";//exit;
//echo "<pre>";print_r($_SERVER);echo "</pre>";//exit;
//echo "<pre>";print_r($_REQUEST);echo "</pre>";exit;
//$dbTable="partf_payments";

$file="year2year_comparison_py_drill.php";
$varQuery=$_SERVER[QUERY_STRING];// ECHO "v=$varQuery";//exit;

extract($_REQUEST);

$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database


// **************  Show Results ***************

if($rep=="excel"){
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment; filename=year2year_comparison_py_drill.xls');
echo "<html><body>";
echo "<table border='1' cellpadding='3' align='center'>";

}

echo "<table border='1' cellpadding='3' align='center'>";

// ******** Show Results ***********

$revArray=array("operating_revenues","purchase4resale","grants","reimbursements");


// ****** Body Query

include("../~f_year.php");

$testAccount=substr($account,0,2);
if($testAccount==43){
$query="SELECT  mid(acctdate,5,2) as 'month', mid(acctdate,1,4) as 'year' ,exp_rev.description as 'vendor',  -sum(debit-credit) as 'amount'  FROM exp_rev LEFT JOIN coa ON exp_rev.acct = coa.ncasnum where 1 and center='$center' and ncasnum='$account' and exp_rev.f_year='$f_year'
group by
mid(acctdate,1,4),
mid(acctdate,5,2),
exp_rev.description
order by
mid(acctdate,1,4),
mid(acctdate,5,2),
exp_rev.description;
";
}
else
{$query="SELECT  mid(acctdate,5,2) as 'month', mid(acctdate,1,4) as 'year' ,exp_rev.description as 'vendor',  sum(debit-credit) as 'amount'  FROM exp_rev LEFT JOIN coa ON exp_rev.acct = coa.ncasnum where 1 and center='$center' and ncasnum='$account' and exp_rev.f_year='$f_year'
group by
mid(acctdate,1,4),
mid(acctdate,5,2),
exp_rev.description
order by
mid(acctdate,1,4),
mid(acctdate,5,2),
exp_rev.description;
";
}
   $result = @mysqli_query($connection, $query,$connection);
if($showSQL){echo "$query<br><br>";}//echo "$query<br><br>";exit;

if($rep==""){
echo "<table border='1' cellpadding='3' align='center'>";
//echo "<tr><td><a href='$file?account=$account&budget_group=$budget_group&rep=excel'>Excel Export</a></td></tr>";
echo "<tr><td colspan='4' align='center'>$desc</td></tr></table>";
}

//Explicitly populate $headerArray instead of dynamic
unset($headerArray);
unset($header);
$headerArray=array("month","year","vendor","amount");

$count=count($headerArray);
for($i=0;$i<$count;$i++){
$h=$headerArray[$i];
$header.="<th>".$h."</th>";}

echo "<div align='center'><table border='1'><tr>$header</tr>";

$j=1;
if($rep=="excel"){$forceText="'";}
while($row = mysqli_fetch_array($result)){
extract($row);

$py_amountTOT+=$amount;
if($rep==""){if(fmod($j,20)==0){echo "$header";}$j++;}

if($amount<0){
$f1="<font color='red'>";$f2="</font>";
}
else{$f1="";$f2="";$tr="";}

$amt=number_format($amount,2);

if($ckMonth!="" AND $month!=$ckMonth){
if($subAmt<0){$f3="<font color='red'>";$f4="</font>";}else{$f3="";$f4="";}
$subAmt=number_format($subAmt,2);
$tr=" bgcolor='AliceBlue'";
echo "<tr$tr><td colspan='4' align='right'>$f3$subAmt$f4</td></tr>";$subAmt="$amount";
$tr="";}else{$subAmt+=$amount;}

echo "<tr$tr>";
echo "
<td align='center'>$month</td>
<td align='left'>$year</td>
<td align='left'>$vendor</td>
<td align='right'>$f1$amt$f2</td>
</tr>";
$ckMonth=$month; 
	}// end while

// ****** Totals
$py_amountTOT=number_format($py_amountTOT,2);

if($amount<0){
$f1="<font color='red'>";$f2="</font>";
}
else{$f1="";$f2="";}

echo "<tr><td colspan='5' align='right'>$f1$py_amountTOT$f2</td>

</tr>";
echo "</table></div></body></html>";

?>