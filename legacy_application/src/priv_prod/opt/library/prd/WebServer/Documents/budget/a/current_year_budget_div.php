<?php

session_start();

if(!$_SESSION["budget"]["tempID"]){echo "access denied";exit;
}


//echo "Please contact Tom Howard at  tom.howard@ncmail.net and indicate there was a problem:  file = /a/current_year_budget_div.php";
//exit;


$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
include("../../../include/authBUDGET.inc");

//include("../../../include/activity.php");
//print_r($_REQUEST);exit;
extract($_REQUEST);
//echo "<pre>"; print_r($_SESSION); echo "</pre>";  //exit;

if(@$f_year==""){include("../~f_year.php");}

$sql="Select date_format(max(acctdate),'%m/%d/%Y') as maxDate from exp_rev where 1";
 $result = @mysqli_query($connection, $sql,$connection);
$row=mysqli_fetch_array($result); extract($row);

/*
if(@$rep==""){
	if($_SESSION['budget']['beacon_num']=="60032779"){
	include_once("../menuAssistDirect.php");}
	else{if($budget_group_menu!=""){include("park_budget_menu.php");}
		}
	}
*/


if(@$rep==""){include_once("../menu1314.php");}


$checkCenter=@strpos($center,"-");
if($checkCenter>0){
$parse=explode("-",$center);
$center=$parse[2];}

// Construct Query to be passed to Excel Export
$budget_group_menuEncode=urlencode($budget_group_menu);
if(!isset($center)){$center="";}
if(!isset($track_rcc_menu)){$track_rcc_menu="";}
if(!isset($acct_cat_menu)){$acct_cat_menu="";}
$varQuery="submit=Submit&center=$center&track_rcc_menu=$track_rcc_menu&acct_cat_menu=$acct_cat_menu&budget_group_menu=$budget_group_menuEncode&f_year=$f_year";

if(@$rep=="excel"){header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment; filename=curren_year_budget.xls');
}

// Get menu values for Budget Group
//$bgArray[]="";
$sql="SELECT DISTINCT (budget_group)
FROM coa
WHERE budget_group != 'land' AND budget_group != 'buildings' AND budget_group != 'reserves' AND budget_group != 'funding_receipt' AND budget_group != 'funding_disburse' AND budget_group != 'professional_services' and budget_group != 'operating_expenses'
ORDER BY budget_group";
/*
WHERE budget_group != 'land' AND budget_group != 'buildings/other_structures' AND budget_group != 'reserves' AND budget_group != 'funding'
*/
$result = mysqli_query($connection, $sql) or die ("Couldn't execute query 1. $sql");
while ($row=mysqli_fetch_array($result))
	{
	$bgArray[]=$row['budget_group'];
	}
//$bgArray=array(" ", "equipment","grants","operating_expenses","operating_revenues","payroll_permanent","payroll_temporary","purchase4resale","reimbursements","travel");

// *********** Level > 2 ************
if($_SESSION['budget']['level']>2){//print_r($_REQUEST);EXIT;


if(@$rep==""){
//include_once("../menu.php");
echo "<table align='center'><form action=\"current_year_budget_div.php\">";

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
while ($row=mysqli_fetch_array($result))
	{
	$sec[]=@$row['section'];
	}

echo "<td>$lev1 $lev2 Section: <select name=\"section\"><option selected></option>";
for ($n=0;$n<count($sec);$n++)
	{
	if(@$section==$sec[$n]){$s="selected";}else{$s="value";}
	$con=$sec[$n];
			echo "<option $s='$con'>$sec[$n]</option>\n";
	}
   echo "</select></td>";
   
$sql="select distinct dist from center where 1 order by dist";
$result = mysqli_query($connection, $sql) or die ("Couldn't execute query 1. $sql");
while ($row=mysqli_fetch_array($result)){
$DIST[]=$row['dist'];}

echo "<td>District: <select name=\"dist\"><option selected></option>";
for ($n=0;$n<count($DIST);$n++)
	{
	if(@$dist==$DIST[$n]){$s="selected";}else{$s="value";}
	$con=$DIST[$n];
			echo "<option $s='$con'>$DIST[$n]</option>\n";
	}
   echo "</select></td>";
 /*        
  if($budget_group_menu=="equipment"){echo "<td>View Approved  <a href='/budget/aDiv/equipment_division.php?passLevel=1&pay_center=$center&f_year=$f_year&division_approved=y&submit=Submit'>Equipment Items</a></td>";}
*/  
echo "<td><input type='submit' name='submit' value='Submit'></form></td>";

//if($submit){echo "<td>Excel <a href='current_year_budget_div.php?$varQuery&rep=excel'>export</a></td>";}

echo "</tr></table>";
}
if(@$dist=="" AND @$section=="" AND @$budget_group_menu==""){exit;}
}// end Level > 2


// ************* Level 2 *****************
if($_SESSION['budget']['level'] == 2){
//print_r($_REQUEST);EXIT;
if(@$rep==""){
//include_once("../menu.php");
include_once("../../../include/parkRCC.inc");

$distCode=$_SESSION['budget']['select'];
echo "<table align='center'><form action=\"current_year_budget_div.php\">";
switch($distCode){
case "EADI":
$distCode="east";
break;
case "NODI":
$distCode="north";
break;
case "SODI":
$distCode="south";
break;
case "WEDI":
$distCode="west";
break;
}
$D=$distCode."-NCAS";
$DP=$distCode."-PARK";

$array1=array($D,$DP);

$where="where dist='$distCode' and section='operations' and fund='1280'";

$sql="SELECT section,parkcode,center as varCenter from center $where order by section,parkcode,center";
//echo "$sql";

$result = mysqli_query($connection, $sql) or die ("Couldn't execute query 1. $sql");
while ($row=mysqli_fetch_array($result)){
extract($row);$pc[]=$parkcode;$c[]=$varCenter;$sec[]=$section;}
//echo "<pre>"; print_r($c); echo "</pre>"; // exit;

echo "<table align='center'><form><tr>";
// Menu 000

echo "<td>Budget Group: <select name=\"budget_group_menu\">"; 
for ($n=0;$n<count($bgArray);$n++){
$con=$bgArray[$n];
if($budget_group_menu==$con){$s="selected";}else{$s="value";}
		echo "<option $s='$con'>$bgArray[$n]\n";
       }
   echo "</select></td>";

   echo "<td>
   <input type='hidden' name='section' value='operations'>
   <input type='hidden' name='dist' value='$distCode'>
<input type='submit' name='submit' value='Submit'></td>";

if($submit){

if($budget_group_menu=="payroll_temporary"){$link="<td>View All Positions for <a href='/budget/aDiv/seasonal_payroll.php?center=$center&submit=Submit&f_year=$f_year&division_approved=y' target='_blank'>Temporary Payroll</a></td>";}

if($budget_group_menu=="payroll_temporary_receipt"){$link1="<td>View All Positions for <a href='/budget/aDiv/seasonal_payroll.php?center=$center&submit=Submit&f_year=$f_year&division_approved=y&ncas_account='531312' target='_blank'>Temporary Payroll</a></td>";}
       
  if($budget_group_menu=="equipment"){$link2="<td>View Approved  <a href='/budget/aDiv/equipment_division.php?pay_center=$center&f_year=$f_year&division_approved=y&submit=Submit' target='_blank'>Equipment Items</a></td>";}
       
   echo "</select></td>";


//echo "<td>Excel <a href='current_year_budget_div.php?$varQuery&rep=excel'>export</a></td>";
echo "</tr>";
}
echo "<tr><td>$link $link1 $link2</td></tr>";
echo "</form></tr></table>";
}

if($budget_group_menu==""){exit;}
}// end Level = 2


// *********** Level 1 ************
if($_SESSION['budget']['level']==1){

//$center=$_SESSION[budget][centerSess];

$S=$_SESSION['budget']['centerSess'];

if(@$rep==""){

//include_once("subDist.php");

// Kludge to allow NERI to also work with MOJE
if(($S=="12802859"||$S=="12802857") and $budget_group_menu!=""){
$file0=$_SERVER[PHP_SELF];
$file=$file0."?budget_group_menu=$budget_group_menu&parkcode=";
$daCode=array("NERI","MOJE"); //print_r($daCode);exit;
$daCenter=array("12802859","12802857"); //print_r($daCenter);exit;
	if($parkcode=="MOJE"){$center="12802857";
	$_SESSION['budget']['centerSess']="12802857";
	}
	else
	{$center="12802859";
	$_SESSION['budget']['centerSess']="12802859";
	}
	echo "<tr><td><form><select name=\"center\" onChange=\"MM_jumpMenu('parent',this,0)\"><option selected>Select Center</option>";$s="value";
for ($n=0;$n<count($daCode);$n++){
$con1=$file.$daCode[$n];
		echo "<option $s='$con1'>$daCode[$n]-$daCenter[$n]\n";
       }
   echo "</select></td></tr></table>";
	}
else{$center=$_SESSION['budget']['centerSess'];}

echo "<table align='center'><form><tr>";
// Menu 000

if($budget_group_menu=="payroll_temporary"){$link="<td>View All Positions for <a href='/budget/aDiv/seasonal_payroll.php?submit=Submit&f_year=$f_year&division_approved=y' target='_blank'>Temporary Payroll</a></td>";}

if($budget_group_menu=="payroll_temporary_receipt"){$link1="<td>View All Positions for <a href='/budget/aDiv/seasonal_payroll.php?center=$center&submit=Submit&f_year=$f_year&division_approved=y&ncas_account='531312' target='_blank'>Temporary Payroll</a></td>";}

echo "<td><font color='blue'><b>Current Year</b></font> Budget Groups: <select name=\"budget_group_menu\" onChange=\"MM_jumpMenu('parent',this,0)\">>"; 
for ($n=0;$n<count($bgArray);$n++){
$con=$bgArray[$n]; $varMenu="current_year_budget_div.php?parkcode=$parkcode&budget_group_menu=";
if($budget_group_menu==$con){$s="selected";}else{$s="value";}
		echo "<option $s='$varMenu$con'>$bgArray[$n]\n";
       }
       
  if($budget_group_menu=="equipment"){$link2="<td>View Approved  <a href='/budget/aDiv/equipment_division.php?pay_center=$center&f_year=$f_year&submit=Submit' target='_blank'>Equipment Items</a></td>";}
       
   echo "</select></td>$link $link1 $link2";
   
//echo "<td>Excel <a href='current_year_budget_div.php?$varQuery&rep=excel'>export</a></td>";

   echo "</tr></table>";
   
}

if($budget_group_menu==""){exit;}

include_once("../../../include/parkcountyRCC.inc");
//include_once("subDist.php");

// Kludge to allow NERI to also work with MOJE
if($S=="12802859"||$S=="12802857"){
	if($parkcode=="MOJE"){$center="12802857";
	$_SESSION[budget][centerSess]="12802857";
	}
	else
	{$center="12802859";
	$_SESSION[budget][centerSess]="12802859";
	}
	}
else{$center=$_SESSION[budget][centerSess];}
}// end Level = 1


// ********** Queries ***********
 $query = "truncate table budget1_unposted;";
    $result = @mysqli_query($connection, $query);
//echo "$query<br><br>";
if(@$showSQL=="1"){echo "$query<br><br>";}

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
source_id,system_entry_date
)
select
ncas_center,
ncas_account,
vendor_name,
datesql,
ncas_invoice_number,
ncas_invoice_amount,'cdcs','cid_vendor_invoice_payments',
id,system_entry_date
from cid_vendor_invoice_payments
where 1
and post2ncas != 'y' and ncas_credit != 'x'
group by id;";
 $result = @mysqli_query($connection, $query);
if(@$showSQL=="1"){echo "$query<br><br>";}

/*inserts   */
 $query = "insert into budget1_unposted(
 center, account,
 vendor_name,
 transaction_date,
 transaction_number,
 transaction_amount,
 transaction_type,
 source_table,
 source_id,system_entry_date ) select ncas_center,
 ncas_account,
 vendor_name,
 datesql,
 ncas_invoice_number,
 -ncas_invoice_amount,
'cdcs',
'cid_vendor_invoice_payments',
 id,
 system_entry_date
 from cid_vendor_invoice_payments
 where 1 and post2ncas != 'y' and ncas_credit = 'x'
 group by id;
";
  $result = @mysqli_query($connection, $query);
if(@$showSQL=="1"){echo "$query<br><br>";}

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
source_id,system_entry_date
)
select
center,
ncasnum,
concat('pcard','-',cardholder,'-',vendor_name,'-',trans_date),
transdate_new,
transid_new,
sum(amount),'pcard','pcard_unreconciled',
id,xtnd_rundate_new
from pcard_unreconciled
where 1
and ncas_yn != 'y'
group by id;";
  $result = @mysqli_query($connection, $query);
if(@$showSQL=="1"){echo "$query<br><br>";}

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
group by prid;";
 $result = @mysqli_query($connection, $query);
if(@$showSQL=="1"){echo "$query<br><br>";}


$query="update budget1_unposted,coa
        set budget1_unposted.budget_group=coa.budget_group
		where budget1_unposted.account=coa.ncasnum;";


$result = @mysqli_query($connection, $query);
if(@$showSQL=="1"){echo "$query<br><br>";}


/*TRUNCATE */
 $query = "truncate table budget1_available;";
 $result = @mysqli_query($connection, $query);
if(@$showSQL=="1"){echo "$query<br><br>";}
 

/*inserts   */
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
ncasnum,
sum(amount_py1),
'',
sum(amount_cy),
'',
'act3'
from act3
where 1
group by center,ncasnum;";
 $result = @mysqli_query($connection, $query);
if(@$showSQL=="1"){echo "$query<br><br>";}


/*inserts   */
 $query = "insert into budget1_available(center,account,py1_amount,allocation_amount,cy_amount,unposted_amount,source)
select center,ncas_acct,'',sum(allocation_amount),'','','budget_center_allocations'
from
budget_center_allocations
where 1
and fy_req='$f_year'
group by center,ncas_acct;
";
 $result = @mysqli_query($connection, $query);
if(@$showSQL=="1"){echo "$query<br><br>";}

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
 $result = @mysqli_query($connection, $query);
if(@$showSQL=="1"){echo "$query<br><br>";}


/*UPDATE */
 $query = "update budget1_available,coa
set budget1_available.budget_group=coa.budget_group
where budget1_available.account=coa.ncasnum;";
 $result = @mysqli_query($connection, $query);
 
 
 /*
 $query = "update budget1_available,center 
            set budget1_available.center=center.old_center 
            where budget1_available.center=center.new_center
";
 $result = @mysqli_query($connection, $query,$connection);
 */
 
 
 
 
if(@$showSQL=="1"){echo "$query<br><br>";}


$sign1="+";$sign2="+";$sign3="";$sign4="-";
//if($budget_group_menu=="grants"){$sign="-";$sign2="-";}

/*
if($budget_group_menu=="funding_receipt" || $budget_group_menu=="operating_revenues" || $budget_group_menu=="purchase4resale_revenues" || $budget_group_menu=="reimbursements"){$sign1="-";$sign2="+";$sign3="-";$sign4="+";}
*/

if($budget_group_menu=="crs_fees" || $budget_group_menu=="donations" || $budget_group_menu=="fees" || $budget_group_menu=="operating_contracts" || $budget_group_menu=="other_revenues" || $budget_group_menu=="par3" || $budget_group_menu=="pfr_revenues" || $budget_group_menu=="pier_permits" || $budget_group_menu=="reimbursements" || $budget_group_menu=="rental_and_use" || $budget_group_menu=="grants" )
{$sign1="-";$sign2="+";$sign3="-";$sign4="+";}

//select query for center budgets

if(@$distCode){$where3=" and center.dist='$distCode'";}
if(@$dist){$where3=" and center.dist='$dist'";}
if(@$section){$where3=$where3." and center.section='$section'";}

if(!isset($where3)){$where3="";}
//echo $where3;exit;

$sql="select
center.parkcode,
budget1_available.center,
center.dist,
center.section,
budget1_available.budget_group,
budget1_available.account,
coa.park_acct_desc as 'account_description',
sum(0 $sign1 py1_amount) as 'py_amount',
sum(allocation_amount) as 'cy_allocation',
sum(0 $sign1 py1_amount + allocation_amount) as 'cy_budget',
sum(0 $sign1 cy_amount) as 'cy_posted',
sum(unposted_amount) as 'cy_unposted',
$sign3 sum(0 $sign1 py1_amount+allocation_amount $sign4 cy_amount-unposted_amount) as 'available_funds'
from budget1_available
left join center on budget1_available.center=center.new_center
left join coa on budget1_available.account=coa.ncasnum
where 1 
and budget1_available.center like '1680%'
$where3
and budget1_available.budget_group='$budget_group_menu'

group by budget1_available.center
order by parkcode;";

//echo "<font color='red'>Line 528: $sql</font><br>";//exit;

if(@$showSQL=="1"){echo "$sql<br>";}

//$varQuery=$_SERVER[QUERY_STRING];
// 9/19/2018 begin

//if($budget_group_menu=="operating_expenses" AND $level<3)
if($budget_group_menu!="equipment" AND $level==2)
{$linkOE="<td><a href='/budget/a/op_exp_transfer_dist.php?budget_group_menu=$budget_group_menu&section=operations&dist=$distCode&submit=Submit'>Transfer Funds</a></td><td>between Parks</td>";}


/*

if($budget_group_menu=="opex-repairs_building" AND $level<3){$linkOE="<td><a href='/budget/a/opex_repairs_building_dist.php?budget_group_menu=$budget_group_menu&section=operations&dist=$distCode&submit=Submit'>Transfer Funds</a></td><td>between Parks</td>";}




if($budget_group_menu=="payroll_temporary" AND $level<3){$linkOE="<td><a href='/budget/a/temp_payroll_transfer_dist.php?budget_group_menu=$budget_group_menu&section=operations&dist=$distCode&submit=Submit'>Transfer Funds</a></td><td>between Parks</td>";}
*/
if($budget_group_menu=="operating_expenses" AND $level>2){$linkOE="<td colspan='4' align='center'><a href='/budget/a/op_exp_transfer_section.php?budget_group_menu=$budget_group_menu&submit=Submit'>Transfer Funds</a> between Centers</td>";}

// 9/19/2018 end
if($budget_group_menu=="equipment"){$linkEquip="<td colspan='3'><a href='/budget/a/equipment_order_status.php?budget_group_menu=$budget_group_menu&section=operations&dist=$dist&submit=Submit' target='_blank'>View Equipment Order Status</a></td>";}

$headerArray=array("parkcode","center",
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
	@$selectFields.=$h.",";
if(@$rep==""){$h=str_replace("_","<br>",$h);}
	@$header.="<th>".$h."</th>";
					}
	}
	
$dontShowTotal=array("parkcode","center","dist","section","budget_group");

for($i=0;$i<$count;$i++){
$h=$headerArray[$i];
if(!in_array($h,$dontShowTotal)){
if(@$rep==""){$h=str_replace("_","<br>",$h);}
	@$headerTotal.="<th>".$h."</th>";
					}
	}
$result = mysqli_query($connection, $sql) or die ("Couldn't execute query. $sql");
//$num=mysqli_num_rows($result);
while($row=mysqli_fetch_array($result)){
extract($row);

$a_parkcode[]=strtoupper($parkcode);// 1
$a_center[]=$center;// 2
$a_dist[]=$dist;// 3
$a_section[]=$section;// 4
$a_budget_group[]=$budget_group;// 5
$a_account[]=$account;// 6
$a_account_description[]=$account_description;// 7
$a_py_amount[]=$py_amount;// 8
$a_cy_allocation[]=$cy_allocation;// 9
$a_cy_budget[]=$cy_budget;// 10
$a_cy_posted[]=$cy_posted;// 11
$a_cy_unposted[]=$cy_unposted;// 12
$a_available_funds[]=$available_funds;// 13
$a_months_used[]=@round(($cy_posted+$cy_unposted)/($cy_budget/12),1);// 14


}// end while

$sum_py_amount=array_sum($a_py_amount);
$sum_cy_allocation=array_sum($a_cy_allocation);

$sum_cy_budget=array_sum($a_cy_budget);
$sum_cy_posted=array_sum($a_cy_posted);
$sum_cy_unposted=array_sum($a_cy_unposted);
$sum_available_funds=array_sum($a_available_funds);

$calc_months=round(($sum_cy_posted+$sum_cy_unposted)/($sum_cy_budget/12),1);


$sum_py_amountF=number_format($sum_py_amount,2);
$sum_cy_allocationF=number_format($sum_cy_allocation,2);
$sum_cy_budgetF=number_format($sum_cy_budget,2);
$sum_cy_postedF=number_format($sum_cy_posted,2);
$sum_cy_unpostedF=number_format($sum_cy_unposted,2);
$sum_available_fundsF=number_format($sum_available_funds,2);

if(@$rep=="excel"){echo "<table border='1'><tr>$header</tr>";} // see fmod below

if(@$rep==""){echo "<table border='1' align='center' cellpadding='4'>
<tr><td></td>$headerTotal</tr>
<tr><td align='right'>Totals:</td>";
if($sum_py_amount>-1){$color="blue";}else{$color="red";}
echo "<td><font color='$color'>$sum_py_amountF</font></td>";
if($sum_cy_allocation>-1){$color="blue";}else{$color="red";}
echo "<td><font color='$color'>$sum_cy_allocationF</font></td>";
if($sum_cy_budget>-1){$color="blue";}else{$color="red";}
echo "<td><font color='$color'>$sum_cy_budgetF</font></td>";
if($sum_cy_posted>-1){$color="blue";}else{$color="red";}
echo "<td><font color='$color'>$sum_cy_postedF</font></td>";
if($sum_cy_unposted>-1){$color="blue";}else{$color="red";}
echo "<td><font color='$color'>$sum_cy_unpostedF</font></td>";
if($sum_available_funds>-1){$color="blue";}else{$color="red";}
echo "<td align='center'><font color='$color'>$sum_available_fundsF</font></td>";
echo "<td align='center'><font color='blue'>$calc_months</font></td>
</tr></table><table border='1' align='center'>";
}

if(!isset($linkEquip)){$linkEquip="";}
echo "<tr><td colspan='5'><font color='red'>Report Date: $maxDate</font></td>$linkOE$linkEquip</tr>";

$yy=10;

for($i=0;$i<count($a_parkcode);$i++){
$x=2;

$r=fmod($i,$x);if($r==0){$bc=" bgcolor='aliceblue'";}else{$bc="";}
$body ="<tr$bc>";

$center=$a_center[$i];
$acct=$a_account[$i];
$cy_posted=$a_cy_posted[$i];

if($level<2){$tunnelPost="<a href='/budget/c/tunnel_cy_actual.php?center=$center&acct=$acct&cy_actual=$cy_posted' target='_blank'>$cy_posted</a>";}else{$tunnelPost=$cy_posted;}

$cy_unposted=$a_cy_unposted[$i];

$tunnelParkCode="<a href='/budget/a/current_year_budget.php?budget_group_menu=$budget_group_menu&center=$center&submit=Submit' target='_blank'>$a_parkcode[$i]</a>";


if($level<2){$tunnelUnpost="<a href='/budget/c/tunnel_cy_unpost.php?center=$center&acct=$acct' target='_blank'>$cy_unposted</a>";}else{$tunnelUnpost=$cy_unposted;}

if(fmod($i,$yy)==0 and @$rep==""){echo "$header";}

$fv1="";$fv2="";
$fv11="";$fv21="";
if($a_available_funds[$i]<0){$fv11="<font color='red'>";$fv21="</font>";}
if($a_cy_allocation[$i]<0){$fv1="<font color='red'>";$fv2="</font>";}

$body.="<td align='center'>$tunnelParkCode</td>
<td align='center'>$center</td>
<td align='right'>$a_py_amount[$i]</td>
<td align='right'>$fv1$a_cy_allocation[$i]$fv2</td>
<td align='right'>$a_cy_budget[$i]</td>
<td align='right'>$tunnelPost</a></td>
<td align='right'>$tunnelUnpost</td>
<td align='right'>$fv11$a_available_funds[$i]$fv21</td>
<td align='right'>$a_months_used[$i]</td>

</tr>";

@$tot_py_amount+=$a_py_amount[$i];
@$tot_cy_allocation+=$a_cy_allocation[$i];
@$tot_cy_budget+=$a_cy_budget[$i];
@$tot_cy_posted+=$a_cy_posted[$i];
@$tot_cy_unposted+=$a_cy_unposted[$i];
@$tot_available_funds+=$a_available_funds[$i];

echo "$body";
}
$amount=numFormat($tot_py_amount);
$allocation=numFormat($tot_cy_allocation);
$budget=numFormat($tot_cy_budget);
$posted=numFormat($tot_cy_posted);
$unposted=numFormat($tot_cy_unposted);
$funds=numFormat($tot_available_funds);

$calc_months=round(($tot_cy_posted+$tot_cy_unposted)/($tot_cy_budget/12),1);

if($allocation<0){$color="red";}else{$color="black";}


echo "<tr><td></td><td colspan='2' align='right'><b>$amount</b></td>
<td align='right'><b><font color=$color>$allocation</font></b></td>
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
//echo "<pre>"; print_r($bgArray); echo "</pre>";  //exit;
//echo "<pre>"; print_r($distcode); echo "</pre>";  //exit;
//echo $con;
?>



