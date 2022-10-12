<?php

session_start();

if(!$_SESSION["budget"]["tempID"]){echo "access denied";exit;
//header("location: /login_form.php?db=budget");
}

$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
include("../../../include/authBUDGET.inc");
//print_r($_REQUEST);//exit;
//echo "<pre>";print_r($_SERVER);echo "<pre>";//exit;
//echo "<pre>";print_r($_SESSION);echo "<pre>";//exit;
include("../../../include/activity.php");
extract($_REQUEST);

if(@$f_year==""){include("../~f_year.php");}

$sql="Select date_format(max(acctdate),'%m/%d/%Y') as maxDate from exp_rev where 1";
 $result = @mysqli_query($connection, $sql,$connection);
$row=mysqli_fetch_array($result); extract($row);
//echo "menu=$menu";
if(@$menu=="mmc") {include("../menus4.php");}

else

{
if(@$rep=="")
	{
	if(!isset($budget_group_menu)){$budget_group_menu="";}
	if($budget_group_menu!=""){include("park_budget_menu.php");}
	}
	
}


//print_r($_REQUEST);
//echo "<pre>"; print_r($_SESSION); echo "</pre>"; // exit;


// Get menu values for Budget Group
if($level==1){$bgArray[]="";}
$sql="SELECT DISTINCT (budget_group)
FROM coa
WHERE budget_group != 'land' AND budget_group != 'buildings' AND budget_group != 'reserves' AND budget_group != 'funding_receipt' AND budget_group != 'funding_disburse' AND budget_group != 'professional_services'
ORDER BY budget_group";

$result = mysqli_query($connection, $sql) or die ("Couldn't execute query 1. $sql");
while ($row=mysqli_fetch_array($result)){$bgArray[]=$row['budget_group'];}
//$bgArray=array(" ", "equipment","grants","operating_expenses","operating_revenues","payroll_permanent","payroll_temporary","purchase4resale","reimbursements","travel");

// *********** Level > 2 ************
if($_SESSION['budget']['level']>2){//print_r($_REQUEST);EXIT;


if(@$rep==""){
include_once("../menu.php");
echo "<table align='center'><form action=\"current_year_budget_test4.php\">";

// Menu 000
echo "<td><font color='green'>Current Year budget for</font> => Budget Group: <select name=\"budget_group_menu\">"; 
for ($n=0;$n<count($bgArray);$n++){
$con=$bgArray[$n];
if($budget_group_menu==$con){$s="selected";}else{$s="value";}
		echo "<option $s='$con'>$bgArray[$n]\n";
       }
   echo "</select></td>";
   
   
$sql="SELECT section,parkcode,center as varCenter from center where fund='1280' order by section,parkcode,center";
$result = mysqli_query($connection, $sql) or die ("Couldn't execute query 1. $sql");
while ($row=mysqli_fetch_array($result)){
extract($row);$pc[]=$parkcode;$c[]=$varCenter;$sec[]=$section;}

if(!isset($lev1)){$lev1="";}
if(!isset($lev2)){$lev2="";}
echo "<td>$lev1 $lev2<select name=\"center\"><option selected>Select Center</option>";
for ($n=0;$n<count($c);$n++)
	{
	if(@$center==$c[$n])
		{$s="selected";$passParkcode=$pc[$n];}else{$s="value";}
	$con=$c[$n];
			echo "<option $s='$con'>$sec[$n]-$pc[$n]-$c[$n]</option>\n";
		   }
   echo "</select></td>";
   
         
  if($budget_group_menu=="equipment"){echo "<td>View Approved  <a href='/budget/aDiv/equipment_division.php?passParkcode=$passParkcode&passLevel=1&pay_center=$center&f_year=$f_year&division_approved=y&submit=Submit'>Equipment Items</a></td>";}
  
echo "<td><input type='submit' name='submit' value='Submit'></form></td>";

if(@$submit)
	{
	if(!isset($link_parkcode)){$link_parkcode="";}
	echo "<td>Excel <a href='current_year_budget.php?$varQuery&rep=excel'>export</a></td>";
	echo "<td>View <a href='/budget/aDiv/seasonal_payroll_payments.php?parkcode=$link_parkcode&center=$center&submit=Submit&f_year=$f_year' target='_blank'>Payments</a> for Temporary Payroll</td>";
	}

echo "</tr></table>";
}
if(@$center==""){exit;}
}// end Level > 2


// ************* Level 2 *****************
if($_SESSION['budget']['level'] == 2){
//print_r($_REQUEST);EXIT;
if($rep==""){
include_once("../menu.php");
include_once("../../../include/parkRCC.inc");

$distCode=$_SESSION[budget][select];
echo "<table align='center'><form action=\"current_year_budget.php\">";
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

$result = mysqli_query($connection, $sql) or die ("Couldn't execute query 1. $sql");
while ($row=mysqli_fetch_array($result)){
extract($row);$pc[]=$parkcode;$c[]=$varCenter;$sec[]=$section;}

echo "<table align='center'><form><tr>";
// Menu 000

echo "<td><font color='green'>Current Year budget for</font> => Budget Group: <select name=\"budget_group_menu\">"; 
for ($n=0;$n<count($bgArray);$n++){
$con=$bgArray[$n];
if($budget_group_menu==$con){$s="selected";}else{$s="value";}
		echo "<option $s='$con'>$bgArray[$n]\n";
       }
   echo "</select></td>";

echo "<td><select name=\"center\"><option selected>Select Center</option>";
for ($n=0;$n<count($c);$n++){
$con=$c[$n];
if($center==$con){$s="selected";}else{$s="value";}
		echo "<option $s='$con'>$sec[$n]-$pc[$n]-$c[$n]\n";
       }
   echo "</select>  FY <input type='text' name='f_year' value='$f_year' size='5' READONLY>
<input type='submit' name='submit' value='Submit'></td>";

if($submit)
	{
	$link="";
	$link1="";
	$link2="";
	if($budget_group_menu=="payroll_temporary")
		{
		$link="<td>View <a href='/budget/aDiv/seasonal_payroll_payments.php?parkcode=$link_parkcode&center=$center&submit=Submit&f_year=$f_year' target='_blank'>Payments</a> for Temporary Payroll</td>";
		}
	
	if($budget_group_menu=="payroll_temporary_receipt")
		{
		$link1="<td>View <a href='/budget/aDiv/seasonal_payroll_payments.php?parkcode=$link_parkcode&center=$center&submit=Submit&f_year=$f_year' target='_blank'>Payments</a> for Temporary Payroll</td></td>";
		}
		   
	  if($budget_group_menu=="equipment")
		{
		$link2="<td>View Approved  <a href='/budget/aDiv/equipment_division.php?pay_center=$center&f_year=$f_year&division_approved=y&submit=Submit' target='_blank'>Equipment Items</a></td>";
		}
		   
	   echo "</select></td>";
	   
	if($budget_group_menu!="payroll_temporary"){
	echo "<td>Excel <a href='current_year_budget.php?$varQuery&rep=excel'>export</a></td></tr>";}
	
	}
echo "<tr><td>$link $link1 $link2</td></tr>";
echo "</form></tr></table>";
}

if($center==""){exit;}
}// end Level = 2


// *********** Level 1 ************
if($_SESSION['budget']['level']==1){

if(@$rep==""){

$center=$_SESSION['budget']['centerSess'];
$link_parkcode=$_SESSION['budget']['select'];

//print_r($_SESSION);

echo "<table align='center'><form><tr>";
// Menu 000

if($budget_group_menu=="payroll_temporary"){
$link="<td>View <a href='/budget/aDiv/seasonal_payroll_payments.php?parkcode=$link_parkcode&center=$center&submit=Submit&f_year=$f_year' target='_blank'>Payments</a> for Temporary Payroll</td>";
}

if($budget_group_menu=="payroll_temporary_receipt"){$link1="<td>View <a href='/budget/aDiv/seasonal_payroll_payments.php?parkcode=$link_parkcode&center=$center&submit=Submit&f_year=$f_year' target='_blank'>Payments</a> for Temporary Payroll</td></td>";}

echo "<td><font color='blue'><b>Current Year budget for</b></font> => Budget Group: <select name=\"budget_group_menu\" onChange=\"MM_jumpMenu('parent',this,0)\">>"; 
for ($n=0;$n<count($bgArray);$n++){
$con=$bgArray[$n]; $varMenu="current_year_budget.php?center=$center&budget_group_menu=";
if(@$budget_group_menu==$con){$s="selected";}else{$s="value";}
		echo "<option $s='$varMenu$con'>$bgArray[$n]\n";
       }
       
  if($budget_group_menu=="equipment"){$link2="<td>View Approved  <a href='/budget/aDiv/equipment_division.php?pay_center=$center&f_year=$f_year&submit=Submit' target='_blank'>Equipment Items</a></td>";}

if(!isset($link)){$link="";}
if(!isset($link1)){$link1="";}
if(!isset($link2)){$link2="";}
   echo "</select></td>$link $link1 $link2";

if($budget_group_menu!="payroll_temporary"){   
echo "<td>Excel <a href='current_year_budget.php?$varQuery&rep=excel'>export</a></td>";}

   echo "</tr></table>";
   
}

if($budget_group_menu==""){exit;}

include_once("../../../include/parkcountyRCC.inc");
//include_once("subDist.php");

// Kludge to allow NERI to also work with MOJE
if(@$S=="12802859" || @$S=="12802857"){
	if($parkcode=="MOJE"){$center="12802857";
	$_SESSION['budget']['centerSess']="12802857";
	}
	else
	{$center="12802859";
	$_SESSION['budget']['centerSess']="12802859";
	}
	}
else{$center=$_SESSION['budget']['centerSess'];}
}// end Level = 1

mysqli_select_db($connection, $database);

// ********** Queries ***********
 $query = "CREATE  temporary TABLE `budget1_unposted1` (
`center` varchar( 15 ) NOT NULL default '',
`account` varchar( 15 ) NOT NULL default '',
`vendor_name` varchar( 50 ) NOT NULL default '',
`transaction_date` date NOT NULL default '0000-00-00',
`transaction_number` varchar( 30 ) NOT NULL default '',
`transaction_amount` decimal( 12, 2 ) NOT NULL default '0.00',
`transaction_type` varchar( 30 ) NOT NULL default '',
`source_table` varchar( 30 ) NOT NULL default '',
`source_id` varchar( 10 ) NOT NULL default '0',
`post2ncas` char( 1 ) NOT NULL default 'n',
`system_entry_date` date NOT NULL default '0000-00-00',
`id` int( 10 ) unsigned NOT NULL AUTO_INCREMENT ,
PRIMARY KEY ( `id` )
) ENGINE = MyISAM ;
";
    $result = @mysqli_query($connection, $query,$connection);
if(@$showSQL=="1"){echo "$query<br><br>";}

/*inserts  */
 $query = "insert into budget1_unposted1( center, account, vendor_name, transaction_date, transaction_number, transaction_amount, transaction_type, source_table, source_id ) select ncas_center, ncas_account, vendor_name, datesql, ncas_invoice_number, ncas_invoice_amount,'cdcs','cid_vendor_invoice_payments', id from cid_vendor_invoice_payments where 1 and post2ncas != 'y' and ncas_credit != 'x' group by id;
 ";
 $result = @mysqli_query($connection, $query,$connection);
if(@$showSQL=="1"){echo "$query<br><br>";}

/*inserts   */
 $query = "insert into budget1_unposted1( center, account, vendor_name, transaction_date, transaction_number, transaction_amount, transaction_type, source_table, source_id ) select ncas_center, ncas_account, vendor_name, datesql, ncas_invoice_number, -ncas_invoice_amount,'cdcs','cid_vendor_invoice_payments', id from cid_vendor_invoice_payments where 1 and post2ncas != 'y' and ncas_credit = 'x' group by id;
";
  $result = @mysqli_query($connection, $query,$connection);
if(@$showSQL=="1"){echo "$query<br><br>";}

/*inserts   */
 $query = "insert into budget1_unposted1( center, account, vendor_name, transaction_date, transaction_number, transaction_amount, transaction_type, source_table, source_id ) select center, ncasnum, concat('pcard','-',cardholder,'-',vendor_name,'-',trans_date), transdate_new, transid_new, sum(amount),'pcard','pcard_unreconciled', id from pcard_unreconciled where 1 and ncas_yn != 'y' group by id;
";
  $result = @mysqli_query($connection, $query,$connection);
if(@$showSQL=="1"){echo "$query<br><br>";}

/*inserts */
 $query = "insert into budget1_unposted1( center, account, vendor_name, transaction_date, transaction_number, transaction_amount, transaction_type, source_table, source_id ) select center, ncasnum, concat(postitle,'-',posnum,'-',tempid), datework,'na', sum(rate*hr1311),'seapay','seapay_unposted', prid from seapay_unposted where 1 group by prid;
";
 $result = @mysqli_query($connection, $query,$connection);
if(@$showSQL=="1"){echo "$query<br><br>";}

/*TRUNCATE */
 $query = "CREATE  temporary TABLE `po_encumbrance_totals1` (
`view` char( 3 ) NOT NULL default 'all',
`center` varchar( 15 ) NOT NULL default '',
`account` varchar( 15 ) NOT NULL default '',
`xtnd_balance` decimal( 12, 2 ) NOT NULL default '0.00',
`id` int( 10 ) unsigned NOT NULL AUTO_INCREMENT ,
PRIMARY KEY ( `id` )
) ENGINE = MyISAM ;
";
 $result = @mysqli_query($connection, $query,$connection);
if(@$showSQL=="1"){echo "$query<br><br>";}
 
/*inserts   */
 $query = "insert into po_encumbrance_totals1 (center,account,xtnd_balance) select center,acct,sum(po_remaining_encumbrance) from xtnd_po_encumbrances where 1 group by center,acct;
";
 $result = @mysqli_query($connection, $query,$connection);
if(@$showSQL=="1"){echo "$query<br><br>";}


/*TRUNCATE */
 $query = "CREATE temporary TABLE `budget1_available1` (
`center` varchar( 15 ) NOT NULL default '',
`account` varchar( 15 ) NOT NULL default '',
`py1_amount` decimal( 12, 2 ) NOT NULL default '0.00',
`allocation_amount` decimal( 12, 2 ) NOT NULL default '0.00',
`cy_amount` decimal( 12, 2 ) NOT NULL default '0.00',
`unposted_amount` decimal( 12, 2 ) NOT NULL default '0.00',
`source` varchar( 30 ) NOT NULL default '0.00',
`budget_group` varchar( 30 ) NOT NULL default '',
`encumbered_funds` decimal( 12, 2 ) NOT NULL default '0.00',
`id` int( 10 ) unsigned NOT NULL AUTO_INCREMENT ,
PRIMARY KEY ( `id` )
) ENGINE = MyISAM ;
";
 $result = @mysqli_query($connection, $query,$connection);
if(@$showSQL=="1"){echo "$query<br><br>";}
 

/*inserts   */
 $query = "insert into budget1_available1( center, account, py1_amount, allocation_amount, cy_amount, unposted_amount, source ) select center, ncasnum, sum(amount_py1), '', sum(amount_cy),'','act3' from act3 where 1 group by center,ncasnum;
";
 $result = @mysqli_query($connection, $query,$connection);
if(@$showSQL=="1"){echo "$query<br><br>";}

/*inserts */
 $query = "insert into budget1_available1(center,account,py1_amount,allocation_amount,cy_amount,unposted_amount,source) select center,ncas_acct,'',sum(allocation_amount),'','','budget_center_allocations' from budget_center_allocations where 1 and fy_req='$f_year' group by center,ncas_acct;
";
 $result = @mysqli_query($connection, $query,$connection);
if(@$showSQL=="1"){echo "$query<br><br>";}

/*inserts */
 $query = "insert into budget1_available1(center,account,encumbered_funds,source) select center,account,sum(xtnd_balance),'po_encumbrance_totals1' from po_encumbrance_totals1 where 1 group by center,account;
";
 $result = @mysqli_query($connection, $query,$connection);
if(@$showSQL=="1"){echo "$query<br><br>";}


/*inserts */
 $query = "insert into budget1_available1( center, account, py1_amount, allocation_amount, cy_amount, unposted_amount, source ) select center, account,'','','', sum(transaction_amount),'budget1_unposted1' from budget1_unposted1 where 1 and post2ncas != 'y' group by center,account;
";
 $result = @mysqli_query($connection, $query,$connection);
if(@$showSQL=="1"){echo "$query<br><br>";}


/*UPDATE */
 $query = "update budget1_available1,coa set budget1_available1.budget_group=coa.budget_group where budget1_available1.account=coa.ncasnum;
";
 $result = @mysqli_query($connection, $query,$connection);
if(@$showSQL=="1"){echo "$query<br><br>";}

//if($scope=="park"){
$whereFilter="and budget1_available1.center='$center'";
$groupBy="group by budget1_available1.center,budget1_available1.account";
//}

if(@$dist){
$whereFilter="and center.dist='$dist'";
$groupBy="group by budget1_available1.center";
}

/*
if($budget_group_menu=="operating_revenues" || $budget_group_menu=="purchase4resale" || $budget_group_menu=="grants" || $budget_group_menu=="reimbursements"){$sign="-";$sign2="-";}else{$sign="";$sign2="+";}
*/

//{$sign="-";$sign2="-";}else{$sign="";$sign2="+";}

/*select query for center budgets*/
//echo "budget_group_menu=$budget_group_menu";exit;

$revArray=array("other_revenues","pfr_revenues","grants","reimbursements","par3","rental_and_use","crs_fees","donations","fees","operating_contracts","pier_permits");

if(in_array($budget_group_menu,$revArray))
{
$sql="select center.parkcode, budget1_available1.center, center.dist, center.section, budget1_available1.budget_group, budget1_available1.account, coa.park_acct_desc as 'account_description', -sum( py1_amount) as 'py_amount', sum( allocation_amount) as 'cy_allocation', sum( -py1_amount + allocation_amount) as 'cy_budget', -sum( cy_amount) as 'cy_posted', sum( unposted_amount) as 'cy_unposted', sum(py1_amount-allocation_amount-cy_amount+unposted_amount) as 'available_funds', sum(encumbered_funds) as 'unpaid_purchase_orders' from budget1_available1 left join center on budget1_available1.center=center.center left join coa on budget1_available1.account=coa.ncasnum where 1 and budget1_available1.center like '1280%' 
$whereFilter
and budget1_available1.budget_group='$budget_group_menu'
$groupBy
order by parkcode";
}
else
{
$sql="select center.parkcode, budget1_available1.center, center.dist, center.section, budget1_available1.budget_group, budget1_available1.account, coa.park_acct_desc as 'account_description', sum( py1_amount) as 'py_amount', sum( allocation_amount) as 'cy_allocation', sum( py1_amount + allocation_amount) as 'cy_budget', sum( cy_amount) as 'cy_posted', sum( unposted_amount) as 'cy_unposted', sum(py1_amount+allocation_amount-cy_amount-unposted_amount) as 'available_funds', sum(encumbered_funds) as 'unpaid_purchase_orders' from budget1_available1 left join center on budget1_available1.center=center.center left join coa on budget1_available1.account=coa.ncasnum where 1 and budget1_available1.center like '1280%' 
$whereFilter
and budget1_available1.budget_group='$budget_group_menu'
$groupBy
order by parkcode";
}



//echo "$sql<br>";//exit;

if(@@$showSQL=="1"){echo "$sql<br>";}

//$varQuery=$_SERVER[QUERY_STRING];

echo "<table border='1'><tr>";

$headerArray=array("parkcode","center",
"dist","section","budget_group","account",
"account_description","py_amount",
"cy_allocation","cy_budget",
"cy_posted","cy_unposted",
"available_funds");
IF($budget_group_menu=="operating_expenses" OR $budget_group_menu=="equipment"){$headerArray[]="unpaid_purchase_orders";}
$headerArray[]="months_used";
$headerArray[]="yearly_percent_change";

$dontShow=array("center","dist","section","budget_group");

$count=count($headerArray);
for($i=0;$i<$count;$i++)
	{
	$h=$headerArray[$i];
	if(!in_array($h,$dontShow)){
		@$selectFields.=$h.",";
	if(@$rep==""){$h=str_replace("_","<br>",$h);}
		@$header.="<th>".$h."</th>";
						}
	}
	
if(@$rep=="excel"){echo "$header</tr>";} // see fmod below


$result = mysqli_query($connection, $sql) or die ("Couldn't execute query. $sql<br />".mysqli_error());
//$num=mysqli_num_rows($result);
while($row=mysqli_fetch_array($result)){
extract($row);

$a_parkcode[]=$parkcode;// 1
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
$a_unpaid_purchase_orders[]=$unpaid_purchase_orders;// 13


}// end while

echo "<tr><td colspan='12'><font color='red'>Report Date: $maxDate</font></td></tr>";
echo "<tr>";

if($budget_group_menu=="operating_expenses"){echo "<td colspan='3'><a href='op_exp_transfer.php?f_year=$f_year&center=$center&submit=Submit' target='_blank'>Transfer Funds</a> between Accounts</td></tr>";}

$yy=10;

for($i=0;$i<count($a_parkcode);$i++){
$x=2;

$r=fmod($i,$x);if($r==0){$bc=" bgcolor='aliceblue'";}else{$bc="";}
$body ="<tr$bc>";

$center=$a_center[$i];
$acct=$a_account[$i];

$py_amount=$a_py_amount[$i];
$tunnelPYamount="<a href='/budget/c/tunnel_py_actual.php?center=$center&acct=$acct&py_amount=$py_amount&prev_year=prev' target='_blank'>$py_amount</a>";

$cy_allocation=$a_cy_allocation[$i];
$tunnelCYallocation="<a href='/budget/c/tunnel_cy_allocation.php?center=$center&acct=$acct&passedAmount=$cy_allocation&f_year=$f_year' target='_blank'>$cy_allocation</a>";

$cy_posted=$a_cy_posted[$i];
$tunnelPost="<a href='/budget/c/tunnel_cy_actual.php?center=$center&acct=$acct&cy_actual=$cy_posted' target='_blank'>$cy_posted</a>";


$cy_unposted=$a_cy_unposted[$i];
$tunnelUnpost="<a href='/budget/c/tunnel_cy_unpost.php?center=$center&acct=$acct' target='_blank'>$cy_unposted</a>";

if(fmod($i,$yy)==0 and @$rep==""){echo "$header";}

$yearly_percent_change=round(($cy_allocation)/($py_amount + .01)*100,1);

if($a_available_funds[$i]<0){$fv1="<font color='red'>";$fv2="</font>";}else{$fv1="";$fv2="";}

$body.="<td align='center'>$a_parkcode[$i]</td>
<td align='right'>$a_account[$i]</td>

<td align='right'>$a_account_description[$i]</td>

<td align='right'>$tunnelPYamount</td>
<td align='right'>$tunnelCYallocation</td>
<td align='right'>$a_cy_budget[$i]</td>
<td align='right'>$tunnelPost</a></td>
<td align='right'>$tunnelUnpost</td>
<td align='right'>$fv1$a_available_funds[$i]$fv2</td>";

IF($budget_group_menu=="operating_expenses" OR $budget_group_menu=="equipment"){
$aupo="<a href=\"popupUnPurOrder.php?center=$center&acct=$acct\" onclick=\"return popitup('popupUnPurOrder.php?center=$center&acct=$acct')\">$a_unpaid_purchase_orders[$i]</a>";

$body.="<td align='right'>$aupo</td>";}

$body.="<td align='right'>$a_months_used[$i]</td>
<td align='right'>$yearly_percent_change</td>

</tr>";

@$tot_py_amount+=$a_py_amount[$i];
@$tot_cy_allocation+=$a_cy_allocation[$i];
@$tot_cy_budget+=$a_cy_budget[$i];
@$tot_cy_posted+=$a_cy_posted[$i];
@$tot_cy_unposted+=$a_cy_unposted[$i];
@$tot_available_funds+=$a_available_funds[$i];
@$tot_unpaid_purchase_orders+=$a_unpaid_purchase_orders[$i];

echo "$body";
}
$amount=numFormat($tot_py_amount);
$allocation=numFormat($tot_cy_allocation);
$budget=numFormat($tot_cy_budget);
$posted=numFormat($tot_cy_posted);
$unposted=numFormat($tot_cy_unposted);
$funds=numFormat($tot_available_funds);
$unpaid_purchase_orders=numFormat($tot_unpaid_purchase_orders);

$calc_months=round(($tot_cy_posted+$tot_cy_unposted)/($tot_cy_budget/12),1);
$yearly_percent_change_tot=round(($tot_cy_allocation)/($tot_py_amount + .01)*100,1);
echo "<tr><td colspan='4' align='right'><b>$amount</b></td>
<td align='right'><b>$allocation</b></td>
<td align='right'><b>$budget</b></td>
<td align='right'><b>$posted</b></td>
<td align='right'><b>$unposted</b></td>
<td align='right'><b>$funds</b></td>";

IF($budget_group_menu=="operating_expenses" OR $budget_group_menu=="equipment"){
echo "<td align='right'><b>$unpaid_purchase_orders</b></td>";}

echo "<td align='right'><b>$calc_months</b></td>
<td align='right'><b>$yearly_percent_change_tot</b></td>
</tr>";

echo "</table></body></html>";

function numFormat($nf){

if($nf<0){$fv1="<font color='red'>";$fv2="</font>";}else{$fv1="";$fv2="";}
$nf=$fv1.number_format($nf,2).$fv2;
return $nf;}
?>



