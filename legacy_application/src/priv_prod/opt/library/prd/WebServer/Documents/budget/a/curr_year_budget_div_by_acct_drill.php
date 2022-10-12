<?php
$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
include("../../../include/authBUDGET.inc");
include("../../../include/activity.php");
extract($_REQUEST);

$sql="Select date_format(max(acctdate),'%m/%d/%Y') as maxDate from exp_rev where 1";
 $result = @mysqli_query($connection, $sql,$connection);
$row=mysqli_fetch_array($result); extract($row);

if(!$f_year){include("../~f_year.php");}

// Construct Query to be passed to Excel Export

$varQuery="submit=Submit&account=$account&f_year=$f_year";

if($rep=="excel"){header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment; filename=curr_year_budget_by_acct_drill.xls');
}


// *********** Level > 3 ************
if($_SESSION[budget][level]>3){//print_r($_REQUEST);EXIT;


if($rep==""){
//include_once("../menu.php");
echo "<table align='center'>
<form action=\"curr_year_budget_div_by_acct_drill.php\">";

if($submit){
echo "<td>Excel <a href='curr_year_budget_div_by_acct_drill.php?$varQuery&rep=excel'>export</a></td>";}

echo "</tr></table>";
}

}// end Level > 3



// ********** Queries ***********
 $query = "truncate table budget1_unposted;";
    $result = @mysqli_query($connection, $query,$connection);
if($showSQL=="1"){echo "$query<br><br>";}

/*inserts  */
 $query = "insert into budget1_unposted( center, account, vendor_name, transaction_date, transaction_number, transaction_amount, transaction_type, source_table, source_id )
 select ncas_center, ncas_account, vendor_name, datesql, ncas_invoice_number, ncas_invoice_amount,'cdcs','cid_vendor_invoice_payments', id from cid_vendor_invoice_payments where 1 and post2ncas != 'y' group by id;
";
 $result = @mysqli_query($connection, $query,$connection);
if($showSQL=="1"){echo "$query<br><br>";}

/*inserts   */
 $query = "insert into budget1_unposted( center, account, vendor_name, transaction_date, transaction_number, transaction_amount, transaction_type, source_table, source_id )
 select center, ncasnum, concat('pcard','-',cardholder,'-',vendor_name,'-',trans_date), transdate_new, transid_new, sum(amount),'pcard','pcard_unreconciled', id from pcard_unreconciled where 1 and ncas_yn != 'y' group by id;
";
  $result = @mysqli_query($connection, $query,$connection);
if($showSQL=="1"){echo "$query<br><br>";}

/*inserts */
 $query = "insert into budget1_unposted( center, account, vendor_name, transaction_date, transaction_number, transaction_amount, transaction_type, source_table, source_id )
 select center, ncasnum, concat(postitle,'-',posnum,'-',tempid), datework,'na', sum(rate*hr1311),'seapay','seapay_unposted', prid from seapay_unposted where 1 group by prid;
";
 $result = @mysqli_query($connection, $query,$connection);
if($showSQL=="1"){echo "$query<br><br>";}


/*TRUNCATE */
 $query = "truncate table budget1_available;";
 $result = @mysqli_query($connection, $query,$connection);
if($showSQL=="1"){echo "$query<br><br>";}
 

/*inserts   */
 $query = "insert into budget1_available( center, account, py1_amount, allocation_amount, cy_amount, unposted_amount, source )
 select center, ncasnum, sum(amount_py1), '',sum(amount_cy),'','act3' from act3 where 1 group by center,ncasnum;
";
 $result = @mysqli_query($connection, $query,$connection);
if($showSQL=="1"){echo "$query<br><br>";}

/*inserts   */
 $query = "insert into budget1_available(center,account,allocation_amount)
select center,ncas_acct,sum(allocation_amount)
from budget_center_allocations
where 1 and fy_req='$f_year' 
group by center,ncas_acct;

";
 $result = @mysqli_query($connection, $query,$connection);
if($showSQL=="1"){echo "$query<br><br>";}


/*inserts */
 $query = "insert into budget1_available( center, account, py1_amount, allocation_amount, cy_amount, unposted_amount, source )
 select center, account,'','','', sum(transaction_amount),'budget1_unposted' from budget1_unposted where 1 and post2ncas != 'y' group by center,account;
";
 $result = @mysqli_query($connection, $query,$connection);
if($showSQL=="1"){echo "$query<br><br>";}


/*UPDATE */
 $query = "update budget1_available,coa set budget1_available.budget_group=coa.budget_group where budget1_available.account=coa.ncasnum;
";
 $result = @mysqli_query($connection, $query,$connection);
if($showSQL=="1"){echo "$query<br><br>";}

if($budget_group_menu=="operating_revenues" || $budget_group_menu=="purchase4resale"){$sign="-";}

/*select query for center budgets*/

$revArray=array("operating_revenues","purchase4resale","grants","reimbursements");
if(in_array($budget_group,$revArray)){$sign="-";$sign2="-";}else{$sign="";$sign2="+";}

//echo "budget_group=$budget_group";exit;
if($level>3){
$where3="WHERE 1 AND budget1_available.account='$account' AND budget1_available.center like '1280%'";

$revArray=array("other_revenues","pfr_revenues","grants","reimbursements","par3","rental_and_use","crs_fees","donations","fees","funding_receipt","professional_services","operating_contracts","pier_permits");

/*select query*/

if(in_array($budget_group,$revArray))

{
$sql="SELECT center.parkcode, budget1_available.center, budget1_available.account, coa.park_acct_desc, -sum(py1_amount ) AS 'py_amount', sum( allocation_amount ) AS 'cy_allocation', -sum( py1_amount + allocation_amount ) AS 'cy_budget', -sum( cy_amount ) AS 'cy_posted', -sum( unposted_amount ) AS 'cy_unposted', sum( py1_amount + allocation_amount - cy_amount - unposted_amount ) AS 'available_funds'
FROM budget1_available LEFT JOIN center ON budget1_available.center = center.center
LEFT JOIN coa ON budget1_available.account = coa.ncasnum
$where3
GROUP BY budget1_available.account,budget1_available.center
ORDER BY center.parkcode
";
}

else

{

$sql="SELECT center.parkcode, budget1_available.center, budget1_available.account, coa.park_acct_desc, sum( py1_amount ) AS 'py_amount', sum( allocation_amount ) AS 'cy_allocation', sum( py1_amount + allocation_amount ) AS 'cy_budget', sum( cy_amount ) AS 'cy_posted', sum( unposted_amount ) AS 'cy_unposted', sum( py1_amount + allocation_amount - cy_amount - unposted_amount ) AS 'available_funds'
FROM budget1_available LEFT JOIN center ON budget1_available.center = center.center
LEFT JOIN coa ON budget1_available.account = coa.ncasnum
$where3
GROUP BY budget1_available.account,budget1_available.center
ORDER BY center.parkcode
";
}



}

//echo "$sql<br>";//exit;

if($showSQL=="1"){echo "$sql<br>";}

//$varQuery=$_SERVER[QUERY_STRING];

echo "<table border='1'><tr>";

$headerArray=array("parkcode","center","account","park_acct_desc",
"dist","section","budget_group","py_amount",
"cy_allocation","cy_budget",
"cy_posted","cy_unposted",
"available_funds","months_used");

//if($level>1){
//$key=array_search();
//}

$dontShow=array("dist","section","budget_group");

$count=count($headerArray);
for($i=0;$i<$count;$i++){
$h=$headerArray[$i];
if(!in_array($h,$dontShow)){
	$selectFields.=$h.",";
if($rep=="" AND $h!="park_acct_desc"){$h=str_replace("_","<br>",$h);}
	$header.="<th>".$h."</th>";
					}
	}
	
	
echo "<tr><td colspan='11'><font color='red'>Report Date: $maxDate</font></td></tr>";

if($rep=="excel"){echo "$header</tr>";} // see fmod below


$result = mysqli_query($connection, $sql) or die ("Couldn't execute query. $sql");
//$num=mysqli_num_rows($result);
while($row=mysqli_fetch_array($result)){
extract($row);

$a_parkcode[]=$parkcode;// 
$a_center[]=$center;// 
$a_account[]=$account;// 1
$a_account_description[]=$park_acct_desc;// 2
//$a_dist[]=$dist;// 
//$a_section[]=$section;// 
//$a_budget_group[]=$budget_group;// 
$a_py_amount[]=$py_amount;// 3
$a_cy_allocation[]=$cy_allocation;// 4
$a_cy_budget[]=$cy_budget;// 5
$a_cy_posted[]=$cy_posted;// 6
$a_cy_unposted[]=$cy_unposted;// 7
$a_available_funds[]=$available_funds;// 8
$a_months_used[]=round(($cy_posted+$cy_unposted)/($cy_budget/12),1);// 9


}// end while


$yy=10;

for($i=0;$i<count($a_account);$i++){
$x=2;

$r=fmod($i,$x);if($r==0){$bc=" bgcolor='aliceblue'";}else{$bc="";}
$body ="<tr$bc>";

$center=$a_center[$i];
$acct=$a_account[$i];
$cy_posted=$a_cy_posted[$i];
if($level<2){$tunnelPost="<a href='/budget/c/tunnel_cy_actual.php?center=$center&acct=$acct&cy_actual=$cy_posted' target='_blank'>$cy_posted</a>";}else{$tunnelPost=$cy_posted;}

$cy_unposted=$a_cy_unposted[$i];
/*
$tunnelUnpost="<a href='/budget/c/tunnel_cy_unpost.php?center=$center&acct=$acct' target='_blank'>$cy_unposted</a>";
*/

$tunnelUnpost=$cy_unposted;

if(fmod($i,$yy)==0 and $rep==""){echo "$header";}


if($a_available_funds[$i]<0){$fv1="<font color='red'>";$fv2="</font>";}else{$fv1="";$fv2="";}


$body.="<td align='left'>$a_parkcode[$i]</td>
<td align='left'>$center</td>
<td align='left'>$a_account[$i]</td>
<td align='left'>$a_account_description[$i]</td>
<td align='right'>$a_py_amount[$i]</td>
<td align='right'>$a_cy_allocation[$i]</td>
<td align='right'>$a_cy_budget[$i]</td>
<td align='right'>$tunnelPost</a></td>
<td align='right'>$tunnelUnpost</td>
<td align='right'>$fv1$a_available_funds[$i]$fv2</td>
<td align='right'>$a_months_used[$i]</td>

</tr>";

$tot_py_amount+=$a_py_amount[$i];
$tot_cy_allocation+=$a_cy_allocation[$i];
$tot_cy_budget+=$a_cy_budget[$i];
$tot_cy_posted+=$a_cy_posted[$i];
$tot_cy_unposted+=$a_cy_unposted[$i];
$tot_available_funds+=$a_available_funds[$i];

echo "$body";
}
$amount=numFormat($tot_py_amount);
$allocation=numFormat($tot_cy_allocation);
$budget=numFormat($tot_cy_budget);
$posted=numFormat($tot_cy_posted);
$unposted=numFormat($tot_cy_unposted);
$funds=numFormat($tot_available_funds);

$calc_months=round(($tot_cy_posted+$tot_cy_unposted)/($tot_cy_budget/12),1);
echo "<tr><td colspan='5' align='right'><b>$amount</b></td>
<td align='right'><b>$allocation</b></td>
<td align='right'><b>$budget</b></td>
<td align='right'><b>$posted</b></td>
<td align='right'><b>$unposted</b></td>
<td align='right'><b>$funds</b></td>
<td align='right'><b>$calc_months</b></td>
</tr>";

echo "</table></body></html>";

function numFormat($nf){

if($nf<0){$fv1="<font color='red'>";$fv2="</font>";}else{$fv1="";$fv2="";}
$nf=$fv1.number_format($nf,2).$fv2;
return $nf;}
?>



