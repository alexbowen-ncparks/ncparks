<?php
$database="budget";
$db="budget";

session_start();

if(!$_SESSION["budget"]["tempID"]){echo "access denied";exit;
}


include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
include("../../../include/authBUDGET.inc");
extract($_REQUEST);
//echo "<pre>";//print_r($_REQUEST);
//print_r($_SESSION);echo "</pre>";
// Construct Query to be passed to Excel Export
foreach($_REQUEST as $k => $v){
if($v and $k!="PHPSESSID"){$varQuery.=$k."=".$v."&";}
}
$passQuery=$varQuery;
   $varQuery.="rep=excel";    

$level=$_SESSION[budget][level];

if($rep=="excel"){header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment; filename=equipment_division.xls');
}

// Get f_year
include("../~f_year.php");

echo "<table align='center'>";


//if($submit!="Submit"){exit;}
//$showSQL=1;
// ********* Body Queries ***************
 $query = "truncate table equipment_payments1;";
    $result = @mysqli_query($connection, $query,$connection);
if($showSQL=="1"){echo "$query<br><br>";}

 $query = "insert into equipment_payments1(
er_num,
center,
account,
vendor_name,
transaction_date,
transaction_number,
transaction_amount,
transaction_type,
source_table,
source_id,
post2ncas
)
select
er_num,
ncas_center,
ncas_account,
vendor_name,
datesql,
ncas_invoice_number,
ncas_invoice_amount,'cdcs','cid_vendor_invoice_payments',
id,
post2ncas
from cid_vendor_invoice_payments
where 1
and er_num != ''
group by id;
";
 $result = @mysqli_query($connection, $query,$connection);
if($showSQL=="1"){echo "$query<br><br>";}

 $query = "insert into equipment_payments1(
er_num,
center,
account,
vendor_name,
transaction_date,
transaction_number,
transaction_amount,
transaction_type,
source_table,
source_id,
post2ncas
)
select
equipnum,
center,
ncasnum,
concat('pcard','-',cardholder,'-',vendor_name,'-',trans_date),
transdate_new,
transid_new,
sum(amount),'pcard','pcard_unreconciled',
id,
ncas_yn
from pcard_unreconciled
where 1
and equipnum != ''
group by id;
";
  $result = @mysqli_query($connection, $query,$connection);
if($showSQL=="1"){echo "$query<br><br>";}

/*select query for er num*/
$sql="select 
equipment_payments1.er_num,
equipment_payments1.center,
equipment_payments1.account,
equipment_payments1.vendor_name,
equipment_payments1.transaction_date,
equipment_payments1.transaction_number,
equipment_payments1.transaction_amount,
equipment_payments1.transaction_type,
equipment_payments1.source_table,
equipment_payments1.source_id,
equipment_payments1.post2ncas
from equipment_payments1
left join equipment_request_3 on equipment_payments1.er_num=equipment_request_3.er_num
where equipment_payments1.center='$center'
and f_year='$f_year'
and division_approved='y'
order by equipment_payments1.er_num,equipment_payments1.transaction_date;
";

//echo "$sql<br>";exit;

if($showSQL=="1"){echo "$sql<br>";}

if($rep==""){
$goBack="<tr><td colspan='6' align='center'><font size='+1'><a href='/budget/a/current_year_budget.php?center=$center&parkcode=$parkcode&budget_group_menu=equipment'>Return</a></font> to <font color='green'>Park Budget</font></td><td><a href='er_all_pay.php?$varQuery'>Excel</a></td></tr>";}

$result = mysqli_query($connection, $sql) or die ("Couldn't execute query. $sql");
$num=mysqli_num_rows($result);

echo "<table border='1'>$goBack";

$headerArray=array("er_num",  "vendor_name","transaction_number","transaction_date","transaction_amount","transaction_type","post2ncas");
$replaceArray=array("er_num","transaction_number","transaction_date","transaction_amount","transaction_type");
$decimalFlds=array("transaction_amount");

If(!is_array($dontShow)){$dontShow=array();}

$count=count($headerArray);
for($i=0;$i<$count;$i++){
$h=$headerArray[$i];
if(!in_array($h,$dontShow)){
	$selectFields.=$h.",";
if(@$rep==""){
if(in_array($h,$replaceArray)){$h=str_replace("_","<br>",$h);}
			}
	$header.="<th>".$h."</th>";
					}
	}

while($row=mysqli_fetch_array($result)){
$b[]=$row;
}// end while

$cen=$b[0][center];

if($num<1){$notice="<br />No payment has been made yet.";}

echo "<tr><td colspan='$count'>&nbsp;&nbsp;&nbsp;<font color='red' size='+1'>$num payments</font> for center $cen $notice for $f_year</td></tr>";

$x=2;
if($passYY){$yy=$passYY;}else{$yy=10;}

echo "<tr>";
	for($i=0;$i<count($b);$i++){
//	$r=fmod($i,$x);if($r==0){$bc=" bgcolor='aliceblue'";}else{$bc="";}

$nextER=$b[$i][er_num];

if($ckER!=$nextER and $i!=0){
$sub_amt=numFormat($sub_amt);
echo "<tr bgcolor='LemonChiffon'><td colspan='5' align='right'> $sub_amt</td></tr>";
$sub_amt="";}

if(fmod($i,$yy)==0 and $rep=="" and $ckER!=$nextER){echo "<tr>$header</tr>";}

echo "<tr$bc>";
	for($j=0;$j<count($headerArray);$j++){

	$var=$b[$i][$headerArray[$j]];
	$fieldName=$headerArray[$j];
	
	if($fieldName=="er_num"){$er=$var;}
	
	if($fieldName=="post2ncas"){
	if($var=="y"){
	$yesTot+=$b[$i][transaction_amount];
	$cc=" bgcolor='#7FFFD4'";}// aquamarine1
	else{
	$noTot+=$b[$i][transaction_amount];$cc=" bgcolor='#FF6A6A'";}// IndianRed1
	}else{$cc="";}
	
	if(in_array($fieldName,$decimalFlds)){
	$a="<td align='right'$cc>";
	$sub_amt+=$var;
	$totArray[$fieldName]+=$var;
	$var=numFormat($var);}else{$a="<td$cc>";}
	
	echo "$a$var</td>";
	}
	
echo "</tr>";
$ckER=$er;
	}// end $b array
	
	// Totals
echo "<tr>"; // Wheat1

	$yesTot=numFormat($yesTot);
	$noTot=numFormat($noTot);
echo "<td colspan='4' align='right'>Posted Amount of <font color='green'>$yesTot</font>  +  Unposted Amount of <font color='red'>$noTot</font> = </td>";

	$var=$totArray[transaction_amount];
	$v=numFormat($var);
	echo "<td align='right'><b>$v</b></td></tr>";

/*
$footer="<tr><td colspan='8' align='center'>Equipment Budget <a href='popupex.html' onclick=\"return popitup('explain_search.php?subject=equipment')\">Terminology</a></td></tr>";
*/

//$footer="<tr><td colspan='9' align='center'><font color='red'>Close window to exit.</font></td></tr>";

echo "$footer</table></body></html>";

function numFormat($nf){
$nf=number_format($nf,2);
return $nf;}
?>



