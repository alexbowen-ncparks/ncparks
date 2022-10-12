<?php

session_start();

if(!$_SESSION["budget"]["tempID"]){echo "access denied";exit;
}

$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
include("../../../include/authBUDGET.inc");
include("../../../include/activity.php");
extract($_REQUEST);

if(!$f_year){include("../~f_year.php");}

$sql="Select date_format(max(acctdate),'%m/%d/%Y') as maxDate from exp_rev where 1";
 $result = @mysqli_query($connection, $sql,$connection);
$row=mysqli_fetch_array($result); extract($row);

if($rep==""){
if($budget_group_menu!=""){include("park_budget_menu.php");}
}
//print_r($_REQUEST);
//print_r($_SESSION);

$checkCenter=strpos($center,"-");
if($checkCenter>0){
$parse=explode("-",$center);
$center=$parse[2];}

// Construct Query to be passed to Excel Export
$budget_group_menuEncode=urlencode($budget_group_menu);
$varQuery="submit=Submit&center=$center&track_rcc_menu=$track_rcc_menu&acct_cat_menu=$acct_cat_menu&budget_group_menu=$budget_group_menuEncode&f_year=$f_year";

if($rep=="excel"){header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment; filename=current_year_budget_by_acct.xls');
}

// Get menu values for Budget Group
//$bgArray[]="";
$sql="SELECT DISTINCT (budget_group)
FROM coa
WHERE budget_group != 'land' AND budget_group != 'buildings/other_structures' AND budget_group != 'reserves' AND budget_group != 'funding'
ORDER BY budget_group";
$result = mysqli_query($connection, $sql) or die ("Couldn't execute query 1. $sql");
while ($row=mysqli_fetch_array($result)){$bgArray[]=$row[budget_group];}
//$bgArray=array(" ", "equipment","grants","operating_expenses","operating_revenues","payroll_permanent","payroll_temporary","purchase4resale","reimbursements","travel");

// *********** Level > 3 ************
if($_SESSION[budget][level]>3){//print_r($_REQUEST);EXIT;


if($rep==""){
//include_once("../menu.php");
echo "<table align='center'>
<form action=\"current_year_budget_div_by_acct.php\">";

// Menu 000
echo "<td>Budget Group: <select name=\"budget_group_menu\">"; 
for ($n=0;$n<count($bgArray);$n++){
$con=$bgArray[$n];
if($budget_group_menu==$con){$s="selected";}else{$s="value";}
		echo "<option $s='$con'>$bgArray[$n]\n";
       }
   echo "</select></td>";
   
$sql="SELECT distinct section from center where 1 order by section";
$result = mysqli_query($connection, $sql) or die ("Couldn't execute query 1. $sql");
while ($row=mysqli_fetch_array($result)){
$sec[]=$row[section];}

echo "<td>$lev1 $lev2 Section: <select name=\"section\"><option selected></option>";
for ($n=0;$n<count($sec);$n++){
if($section==$sec[$n]){$s="selected";}else{$s="value";}
$con=$sec[$n];
		echo "<option $s='$con'>$sec[$n]</option>\n";
       }
   echo "</select></td>";
   
$sql="select distinct dist from center where 1 order by dist";
$result = mysqli_query($connection, $sql) or die ("Couldn't execute query 1. $sql");
while ($row=mysqli_fetch_array($result)){
$DIST[]=$row[dist];}

echo "<td>District: <select name=\"dist\"><option selected></option>";
for ($n=0;$n<count($DIST);$n++){
if($dist==$DIST[$n]){$s="selected";}else{$s="value";}
$con=$DIST[$n];
		echo "<option $s='$con'>$DIST[$n]</option>\n";
       }
   echo "</select></td>";
         
  if($budget_group_menu=="equipment"){echo "<td>View Approved  <a href='/budget/aDiv/equipment_division.php?passLevel=1&pay_center=$center&f_year=$f_year&division_approved=y&submit=Submit'>Equipment Items</a></td>";}
  
echo "<td><input type='submit' name='submit' value='Submit'></form></td>";

if($submit){
echo "<td>Excel <a href='current_year_budget_div_by_acct.php?$varQuery&rep=excel'>export</a></td>";}

echo "</tr></table>";
}
if($dist=="" AND $section=="" AND $budget_group_menu==""){exit;}
}// end Level > 3



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


/*TRUNCATE */
 $query = "truncate table budget1_available;";
 $result = @mysqli_query($connection, $query,$connection);
if($showSQL=="1"){echo "$query<br><br>";}
 

/*inserts   */
 $query = "insert into budget1_available( center, account, py1_amount, allocation_amount, cy_amount, unposted_amount, source ) 
 select center, 
 ncasnum, 
 sum(amount_py1), 
 '', 
 sum(amount_cy),
 '',
 'act3' 
 from act3 where 1 group by center,ncasnum;
";
 $result = @mysqli_query($connection, $query,$connection);
if($showSQL=="1"){echo "$query<br><br>";}

/*inserts   */
 $query = "insert into budget1_available (center,account,py1_amount,allocation_amount,cy_amount,unposted_amount,source)
select center,
ncas_acct,
'',
sum(allocation_amount),
'',
'',
'budget_center_allocations'
from budget_center_allocations
where 1
and fy_req='$f_year'
group by ncas_acct,center;
";
 $result = @mysqli_query($connection, $query,$connection);
if($showSQL=="1"){echo "$query<br><br>";}


/*inserts */
 $query = "insert into budget1_available(
center,
account,
py1_amount,
allocation_amount,
cy_amount,
unposted_amount,
source
)
select
center,
account,'','','',
sum(transaction_amount),'budget1_unposted'
from budget1_unposted
where 1
and post2ncas != 'y'
group by center,account;";
 $result = @mysqli_query($connection, $query,$connection);
if($showSQL=="1"){echo "$query<br><br>";}


/*UPDATE */
 $query = "update budget1_available,coa
set budget1_available.budget_group=coa.budget_group
where budget1_available.account=coa.ncasnum;";
 $result = @mysqli_query($connection, $query,$connection);
if($showSQL=="1"){echo "$query<br><br>";}

//$revArray=array("operating_revenues","purchase4resale","grants","reimbursements");
//if(in_array($budget_group_menu,$revArray)){$sign="-";$sign2="-";}else{$sign="";$sign2="+";}

$revArray=array("other_revenues","pfr_revenues","grants","reimbursements","par3","rental_and_use","crs_fees","donations","fees","operating_contracts","pier_permits");


if($level>3){

if(in_array($budget_group_menu,$revArray))
{
/*select query for center budgets*/


$where3="WHERE 1 AND budget1_available.center LIKE '1280%'";
$where3.=" AND budget1_available.budget_group = '$budget_group_menu'";
if($dist){$where3.=" and center.dist='$dist'";}
if($section){$where3.=" and center.section='$section'";}
$sql="SELECT budget1_available.account, coa.park_acct_desc, 
-sum(py1_amount) AS 'py_amount', 
sum(allocation_amount ) AS 'cy_allocation', 
sum(-py1_amount + allocation_amount ) AS 'cy_budget', 
-sum(cy_amount ) AS 'cy_posted', 
sum(unposted_amount ) AS 'cy_unposted', 
sum( py1_amount - allocation_amount - cy_amount + unposted_amount ) AS 'available_funds'
FROM budget1_available
LEFT JOIN center ON budget1_available.center = center.center
LEFT JOIN coa ON budget1_available.account = coa.ncasnum
$where3
GROUP BY budget1_available.account
ORDER BY budget1_available.account
";}

else

{

$where3="WHERE 1 AND budget1_available.center LIKE '1280%'";
$where3.=" AND budget1_available.budget_group = '$budget_group_menu'";
if($dist){$where3.=" and center.dist='$dist'";}
if($section){$where3.=" and center.section='$section'";}
$sql="SELECT budget1_available.account, coa.park_acct_desc, 
sum(py1_amount) AS 'py_amount', 
sum(allocation_amount ) AS 'cy_allocation', 
sum(py1_amount + allocation_amount ) AS 'cy_budget', 
sum(cy_amount ) AS 'cy_posted', 
sum(unposted_amount ) AS 'cy_unposted', 
sum( py1_amount + allocation_amount - cy_amount - unposted_amount ) AS 'available_funds'
FROM budget1_available
LEFT JOIN center ON budget1_available.center = center.center
LEFT JOIN coa ON budget1_available.account = coa.ncasnum
$where3
GROUP BY budget1_available.account
ORDER BY budget1_available.account
";}

}

//echo "$sql<br>";//exit;

if($showSQL=="1"){echo "$sql<br>";}

//$varQuery=$_SERVER[QUERY_STRING];

echo "<table border='1'><tr>";

$headerArray=array("account","park_acct_desc","center",
"dist","section","budget_group","py_amount",
"cy_allocation","cy_budget",
"cy_posted","cy_unposted",
"available_funds","months_used");

//if($level>1){
//$key=array_search();
//}

$dontShow=array("center","dist","section","budget_group");

$count=count($headerArray);
for($i=0;$i<$count;$i++){
$h=$headerArray[$i];
if(!in_array($h,$dontShow)){
	$selectFields.=$h.",";
if($rep=="" AND $h!="park_acct_desc"){$h=str_replace("_","<br>",$h);}
	$header.="<th>".$h."</th>";
					}
	}
	
if($rep=="excel"){echo "$header</tr>";} // see fmod below


$result = mysqli_query($connection, $sql) or die ("Couldn't execute query. $sql");
//$num=mysqli_num_rows($result);
while($row=mysqli_fetch_array($result)){
extract($row);

$a_account[]=$account;// 1
$a_account_description[]=$park_acct_desc;// 2
//$a_center[]=$center;// 
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

echo "<tr><td colspan='9'><font color='red'>Report Date: $maxDate</font><br />$where3</td></tr>";

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

$acctLink="<a href='/budget/a/curr_year_budget_div_by_acct_drill.php?account=$a_account[$i]&submit=Submit&budget_group=$budget_group_menu' target='_blank'>$a_account[$i]</a>";

$body.="<td align='left'>$acctLink</td>
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
echo "<tr><td colspan='3' align='right'><b>$amount</b></td>
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



