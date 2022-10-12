<?php


session_start();

if(!$_SESSION["budget"]["tempID"]){echo "access denied";exit;
}


$dbTable="partf_payments"; 
$file="prtf_center_budget.php";
$fileMenu="prtf_center_budget_menu.php";

//echo "<pre>";print_r($_REQUEST);echo "</pre>";//exit;
session_start();
//echo "<pre>";print_r($_SESSION);echo "</pre>";//exit;
$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/connectROOT.inc"); // connection parameters
mysql_select_db($database, $connection); // database
include("../../../include/activity.php");
//echo "<pre>";print_r($_SESSION);echo "</pre>";//exit;
$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$beacnum=$_SESSION['budget']['beacon_num'];
//echo "<br />beacnum=$beacnum<br />";
if($beacnum==60032913){$level=4;} //wedi disu (mcelhone8290)
if($beacnum==60032912){$level=4;} //eadi disu (fullwood1940)
if($beacnum==60033019){$level=4;} //sodi disu (greenwood3841)
if($beacnum==60032956){$level=4;} //sodi district maintenance (mitchell9781)
if($beacnum==60032958){$level=4;} //wedi district maintenance (baumgardner4159)
if($beacnum==60032977){$level=4;} //nodi district maintenance (noel4543)
if($beacnum==60032957){$level=4;} //eadi district maintenance (johnson4374)
if($beacnum==60033135){$level=4;} //nodi district I&E (bockhahn1844)
if($beacnum==60032875){$level=4;} //wedi district I&E (becker7900)
if($beacnum==60032907){$level=4;} //sodi district I&E (hurtado0730)
if($beacnum==60032931){$level=4;} //wedi oa (bunn8227)
if($beacnum==60032892){$level=4;} //eadi oa (quinn0398)
if($beacnum==60033148){$level=4;} //nodi oa (brown4109)
if($beacnum==60033093){$level=4;} //sodi oa (mitchener8455)
if($beacnum==60095488){$level=4;} //nrc laura fuller (Fuller1234)

//echo "<br />line 28: level=$level<br />";
extract($_REQUEST);
// Determine access
if($level<4){
//if($_SESSION[budget][report][0]=="prtf_center_budget")

if($_SESSION['budget']['position']=="maintenance mechanic v")
{$temp=$_SESSION['budget']['tempID'];$ln=substr($temp,0,-4);
$access="and partf_projects.manager like '%$ln'";
$center=strtoupper($center);
if($temp=="ONeal2990" AND $center=="4E74"){$access="";}
}
/*
if($_SESSION['budget']['position']=="parks district superintendent")
{$distCode=$_SESSION['budget']['select'];
switch($distCode){
case "EADI":
$menuList="array".$distCode; $parkList=${$menuList};
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
$access="and partf_projects.dist ='$distCode'";}
*/
}
$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/connectROOT.inc"); // connection parameters
mysql_select_db($database, $connection); // database

if($submit=="Update"){
	$sql="Select projnum From partf_projects
	where center='$center'
	and projyn='y';
	";
$result = mysql_query($sql) or die ("Couldn't execute update. $sql");
while($row=mysql_fetch_array($result)){
		$proj_num_array[]=$row['projnum'];
		}
		if(!in_array($proj_num,$proj_num_array)){
			echo "<font color='red'>You tried to entered an incorrect Project Number ($proj_num) for Center $center for record xtid=$xtid.</font> Contact Tony if you have any question.";}
			else{
	$sql="UPDATE partf_payments
		SET proj_num='$proj_num'
		WHERE xtid='$xtid'
		";  //echo "$sql";//exit;
$result = mysql_query($sql) or die ("Couldn't execute update. $sql");}
	}



if($q=="e"){
// Drilldown for proj_num

// Restrict Edit capability
if($_SESSION['budget']['beacon_num']=="60032790"){// Sue Regier - Land Res.	
	$edit_yes=1;}
if($level>4){$edit_yes=1;}
	
$sql="SELECT proj_num, center, datenew, invoice, vendorname, pcard_vendor, pcard_name, account, coa.park_acct_desc AS  'acct_desc', amount, purch_descr_input AS  'purch_desc',partf_payments.contract_num AS DPR_contract_num,partf_payments.contract_amt,partf_payments.xtid
FROM partf_payments
LEFT  JOIN coa ON partf_payments.account = coa.ncasnum
WHERE proj_num =  '$projnum' AND center =  '$center'
ORDER  BY  `center` , datenew DESC 
";
$result = mysql_query($sql) or die ("Couldn't execute query 0. $sql");
$num=mysql_num_rows($result);

if($rep=="excel"){header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment; filename=prtf_center_budget.xls');
}


if($rep==""){
$varQuery=$_SERVER[QUERY_STRING];
//include("$fileMenu");
}
echo "<table align='center' border='1' cellpadding='3'>";

if($varQuery){echo "<tr><td><a href='$file?$varQuery&rep=excel'>Excel Export</a></td><td colspan='3' align='center'><font color='red'><b>$num records</b></font></td><td colspan='11' align='center'>Close this window or tab when done.</td></tr>";}

echo "<tr><th>Project Number</th><th>Center</th><th>Date</th><th>Invoice</th><th>Vendor Name</th><th>Pcard Vendor</th><th>Pcard name</th><th>Account</th><th>Account Desc.</th><th>Amount</th><th>Purchase Desc.</th><th>DPR contract num</th><th>contract amt</th><th>xtid</th></tr>";
$i=0;
while($row=mysql_fetch_array($result)){
extract($row);
$amountF=number_format($amount,2);
$contract_amtF=number_format($contract_amt,2);

if($amount<0){$f1="<font color='red'>";$f2="</font>";}else{$f1="";$f2="";}
if($contract_amt<0){$f3="<font color='red'>";$f4="</font>";}else{$f3="";$f4="";}
//$center="&nbsp;".$center;
echo "<tr>";

if($proj_num=="na" and $edit_yes==1){
	$varPN="<a href='prtf_center_budget.php?projnum=$proj_num&center=$center&q=e&pass_xtid=$xtid'>$proj_num</a>";
		if($pass_xtid==$xtid){$varPN="<form><input type='text' name='proj_num' size='6'>
		<input type='hidden' name='projnum' value='na'>
		<input type='hidden' name='center' value='$center'>
		<input type='hidden' name='q' value='e'>
		<input type='hidden' name='xtid' value='$xtid'>
		<input type='submit' name='submit' value='Update'>
		</form>";}
	}else{$varPN=$proj_num;}
echo "<td align='center'>$varPN</td>";

echo "<td align='center'>$center</td><td>$datenew</td><td>$invoice</td><td>$vendorname</td><td>$pcard_vendor</td><td>$pcard_name</td><td>$account</td><td>$acct_desc</td><td align='right'>$f1$amountF$f2</td><td>$purch_desc</td><td align='center'>$DPR_contract_num</td><td align='right'>$f3$contract_amtF$f4</td>";
if($level<5){echo "<td>$xtid</td>";}else{echo "<td><a href='prtf_center_budget_edit.php?xtid=$xtid'>$xtid</a></td>";}
echo "</tr>";

$total=$total+$amount;
$totalCA=$totalCA+$contract_amt;
}// end while

$totalF=number_format($total,2);
$totalCAF=number_format($totalCA,2);

echo "<tr><td colspan='9' align='right'><b>Grand Total:</b></td><td  align='right'>$totalF</td><td></td><td></td><td  align='right'>$totalCAF</td></tr>";

echo "<tr><td colspan='11' align='center'>Close this window or tab when done.</td></table>";
exit;}


// Get most recent date from Exp_Rev
$sql="SELECT DATE_FORMAT(max(datenew),'Report Date: %c/%e/%y') as maxDate FROM `partf_payments` WHERE 1";
$result = mysql_query($sql) or die ("Couldn't execute query 0. $sql");
$row=mysql_fetch_array($result);
extract($row);

if($rep=="excel"){header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment; filename=prtf_center_budget.xls');
}


// ******** Show Results ***********

if($rep==""){
$varQuery=$_SERVER[QUERY_STRING];
include("$fileMenu");
if($varQuery){echo "<a href='$file?$varQuery&rep=excel'>Excel Export</a>";}
}


// ************* Manager ********************
if($centerman!=""){
echo "<table border='1' cellpadding='3' align='center'>";

$query = "update center set center_num_name_year=concat(center,'_',center_desc,'_',f_year_funded)
where 1;";
    $result = @MYSQL_QUERY($query,$connection);
    
 $query = "truncate table cid_project_balances;";
    $result = @MYSQL_QUERY($query,$connection);

 $query = "insert into cid_project_balances(projnum,approved,pm_allocation,expenses,center)
select projnum,sum(div_app_amt),'','',partf_projects.center
from partf_projects
left join center on partf_projects.center=center.center
where 1 and center.centerman='$centerman' and partf_projects.projyn='y'
group by partf_projects.center;";
   $result = @MYSQL_QUERY($query,$connection);

 $query = "insert into cid_project_balances(projnum,approved,pm_allocation,expenses,center)
select proj_num,'','',sum(amount),partf_payments.center
from partf_payments
left join center on partf_payments.center=center.center
where 1 and center.centerman='$centerman'
group by partf_payments.center;";
  $result = @MYSQL_QUERY($query,$connection);

 $query = "insert into cid_project_balances(projnum,approved,pm_allocation,expenses,center)
select pm_allocations.projnum,'',sum(pm_allocation),'',pm_allocations.center
from pm_allocations
left join center on pm_allocations.center=center.center
where 1 and center.centerman='$centerman'
group by pm_allocations.center;";
  $result = @MYSQL_QUERY($query,$connection);

 $query = "select center.centerman as manager,center_num_name_year as project_center_year_type,sum(approved)as 'approved',sum(pm_allocation)as'pm_allocation',sum(expenses)as'expenses',sum(approved-expenses) as'balance'
from cid_project_balances
left join center on cid_project_balances.center=center.center
where 1
group by cid_project_balances.center
order by f_year_funded asc";
   $result = @MYSQL_QUERY($query,$connection);
//echo "$query";

// pm_allocation removed
echo "<tr><td colspan='9' align='center'>PARTF Budget for $centerman using PARTF_Payments $maxDate</td></tr><tr><th>center_num_name_year</th><th align='right'>approved</th><th align='right'>expenses</th><th align='right'>balance</th><th>manager</th>";

echo "</tr>";
while($row = mysql_fetch_array($result)){
extract($row);
$approvedF=number_format($approved,2);
$c=explode("_",$project_center_year_type);
$center_link="<a href='prtf_center_budget.php?center=$c[0]'>$project_center_year_type</a>";
$pm_link=number_format($pm_allocation,2);

//$expense_link="<a href='prtf_center_budget.php?projnum=$projnum&center=$varCenter&q=e'>".number_format($expenses,2)."</a>";
$expense_link=number_format($expenses,2);

$balanceF=number_format($balance,2);
$project_center_year_type=strtolower($project_center_year_type);
$manager=strtolower($manager);
echo "<tr>";
/*
echo "<td>$center_link</td><td align='right'>$approvedF</td><td align='right'>$pm_link</td><td align='right'>$expense_link</td><td align='right'>$balanceF</td><td>$manager</td>";
*/
// pm_link removed
echo "<td>$center_link</td><td align='right'>$approvedF</td>
<td align='right'>$expense_link</td><td align='right'>$balanceF</td><td>$manager</td>";
echo "</tr>";
$total_approved=$total_approved+$approved;
$total_pm=$total_pm+$pm_allocation;
$total_expenses=$total_expenses+$expenses;
$total_balance=$total_balance+$balance;
}// end while
$total_approved=number_format($total_approved,2);
$total_pm=number_format($total_pm,2);
$total_expenses=number_format($total_expenses,2);
$total_balance=number_format($total_balance,2);
echo "<tr>
<td colspan='3' align='right'><b>$total_approved</b></td>
<td align='right'><b>$total_pm</b></td>
<td align='right'><b>$total_expenses</b></td>
<td align='right'><b>$total_balance</b></td>
</tr></table>";
}// end if


// ************* Park ********************
if(@$parkcode!="")
	{
	echo "<table border='1' cellpadding='3' align='center'>";
	
	$query = "update partf_projects
	set project_center_year_type=concat(projnum,'-',center,'-',yearfundf,'-',projcat)
	where 1";
		$result = @MYSQL_QUERY($query,$connection);
		
	 $query = "truncate table cid_project_balances";
		$result = @MYSQL_QUERY($query,$connection);
	
	 $query = "insert into cid_project_balances (projnum,approved,pm_allocation,expenses)
	select projnum, sum(div_app_amt), '',''
	from partf_projects
	where 1 and park='$parkcode' and projyn='y'
	group by projnum";
	   $result = @MYSQL_QUERY($query,$connection);
	
	 $query = "insert into cid_project_balances(projnum,approved,pm_allocation,expenses)
	select proj_num,'','',sum(amount)
	from partf_payments
	left join partf_projects on partf_payments.proj_num=partf_projects.projnum
	where 1 and partf_projects.park='$parkcode'
	group by proj_num";
	  $result = @MYSQL_QUERY($query,$connection);
	
	 $query = "insert into cid_project_balances(projnum,approved,pm_allocation,expenses)
	select pm_allocations.projnum,'',pm_allocation,''
	from pm_allocations
	left join partf_projects on pm_allocations.projnum=partf_projects.projnum
	where 1 and partf_projects.park='$parkcode'
	group by projnum";
	  $result = @MYSQL_QUERY($query,$connection);
	
	 $query = "select park,projname,partf_projects.project_center_year_type,sum(approved) as
	'approved',sum(pm_allocation) as 'pm_allocation', sum(expenses) as 'expenses', sum(approved-expenses) as 'balance', statusper as 'status',manager, cid_project_balances.projnum,partf_projects.center as varCenter
	from cid_project_balances
	left join partf_projects on cid_project_balances.projnum=partf_projects.projnum
	where 1
	group by cid_project_balances.projnum
	order by partf_projects.center desc";
	   $result = @MYSQL_QUERY($query,$connection);
	//echo "$query";
	
	echo "<tr><td colspan='9' align='center'>PARTF Budget for $parkcode using PARTF_Payments $maxDate</td></tr><tr><th>park</th><th>projname</th><th>project_center_year_type</th><th align='right'>approved</th><th align='right'>expenses</th><th align='right'>balance</th><th>status</th><th>manager</th>";
	
	echo "</tr>";
	while($row = mysql_fetch_array($result)){
	extract($row);
	$approvedF=number_format($approved,2);
	
	//$pm_link="<a href='prtf_pm_allocation.php?projnum=$projnum'>".number_format($pm_allocation,2)."</a>";
	$pm_link=number_format($pm_allocation,2);
	
	//$expense_link="<a href='prtf_center_budget.php?projnum=$projnum&center=$varCenter&q=e'>".number_format($expenses,2)."</a>";
	$expense_link=number_format($expenses,2);
	
	$balanceF=number_format($balance,2);
	$project_center_year_type=strtolower($project_center_year_type);
	$manager=strtolower($manager);
	echo "<tr>";
	
	echo "<td>$park</td><td>$projname</td><td>$project_center_year_type</td><td align='right'>$approvedF</td><td align='right'>$expense_link</td><td align='right'>$balanceF</td><td>$status</td><td>$manager</td>";
	
	echo "</tr>";
	$total_approved=$total_approved+$approved;
	$total_pm=$total_pm+$pm_allocation;
	$total_expenses=$total_expenses+$expenses;
	$total_balance=$total_balance+$balance;
	}// end while
	$total_approved=number_format($total_approved,2);
	$total_pm=number_format($total_pm,2);
	$total_expenses=number_format($total_expenses,2);
	$total_balance=number_format($total_balance,2);
	echo "<tr>
	<td colspan='4' align='right'><b>$total_approved</b></td>
	<td align='right'><b>$total_pm</b></td>
	<td align='right'><b>$total_expenses</b></td>
	<td align='right'><b>$total_balance</b></td>
	<td></td></tr></table>";
	}// end if

// ************* Center ********************
if(@$center!="")
	{
	echo "<table border='1' cellpadding='3' align='center'>";
	
	$query = "update partf_projects
	set project_center_year_type=concat(projnum,'-',center,'-',yearfundf,'-',projcat)
	where 1";
		$result = @MYSQL_QUERY($query,$connection);
		
	 $query = "truncate table cid_project_balances";
		$result = @MYSQL_QUERY($query,$connection);
	
	 $query = "insert into cid_project_balances(projnum,approved,pm_allocation,expenses)
	select projnum,sum(div_app_amt),'',''
	from partf_projects
	where 1 and center='$center'and projyn='y'
	group by projnum;";
	
	  $result = @MYSQL_QUERY($query,$connection);
	 $af=mysql_affected_rows();
	if($af==0){echo "No project found for $query";exit;}
	
	 $query = "insert into cid_project_balances(projnum,approved,pm_allocation,expenses)
	select proj_num,'','',sum(amount)
	from partf_payments
	where 1 and center='$center'
	group by proj_num";
	   $result = @MYSQL_QUERY($query,$connection);
	
	 $query = "insert into cid_project_balances(projnum,approved,pm_allocation,expenses)
	select projnum,'',pm_allocation,''
	from pm_allocations
	where 1 and center='$center'
	group by projnum";
	  $result = @MYSQL_QUERY($query,$connection);
	
	 $query = "select park,projname,partf_projects.project_center_year_type,sum(approved) as
	'approved',sum(pm_allocation) as 'pm_allocation', sum(expenses) as 'expenses', sum(approved-expenses) as 'balance', statusper as 'status',manager, cid_project_balances.projnum
	from cid_project_balances
	left join partf_projects on cid_project_balances.projnum=partf_projects.projnum
	where 1 $access
	group by cid_project_balances.projnum
	order by park, partf_projects.projnum asc";
	   $result = @MYSQL_QUERY($query,$connection);
	//echo "$query";
	
	echo "<tr><td colspan='7' align='center'>PARTF Budget for Center $center using PARTF_Payments $maxDate</td></tr><tr><th>park</th><th>projname</th><th>project_center_year_type</th><th align='right'>approved</th><th align='right'>expenses</th><th align='right'>balance</th><th>status</th><th>manager</th>";
	
	echo "</tr>";
	while($row = mysql_fetch_array($result)){
	extract($row);
	$approvedF=number_format($approved,2);
	
	//if($level>3){
	//$pm_link="<a href='prtf_pm_allocation.php?projnum=$projnum'>".number_format($pm_allocation,2)."</a>";
	//}
	//else
	//{$pm_link=number_format($pm_allocation,2);}
	
	$expense_link="<a href='prtf_center_budget.php?projnum=$projnum&center=$center&q=e'>".number_format($expenses,2)."</a>";
	//$expensesF=number_format($expenses,2);
	if($balance>0 and $status!="FI"){$proj_bal+=$balance;}
	$available_funds=$balance-$proj_bal;
	
	$balanceF=number_format($balance,2);
	$project_center_year_type=strtolower($project_center_year_type);
	$manager=strtolower($manager);
	echo "<tr>";
	
	echo "<td>$park</td><td>$projname</td><td>$project_center_year_type</td><td align='right'>$approvedF</td><td align='right'>$expense_link</td><td align='right'>$balanceF</td><td>$status</td><td>$manager</td>";
	
	echo "</tr>";
	$total_approved=$total_approved+$approved;
	//$total_pm=$total_pm+$pm_allocation;
	$total_expenses=$total_expenses+$expenses;
	$total_balance=$total_balance+$balance;
	}// end while
	$total_approved=number_format($total_approved,2);
	$total_pm=number_format($total_pm,2);
	$total_expenses=number_format($total_expenses,2);
	$total_balance=number_format($total_balance,2);
	echo "<tr>
	<td colspan='4' align='right'><b>$total_approved</b></td>";
	//<td align='right'><b>$total_pm</b></td>
	echo "<td align='right'><b>$total_expenses</b></td>
	<td align='right'><b>$total_balance</b></td>
	<td>$proj_bal</td></tr></table>";
	}// end if

// ************* yearfundf ********************
if(@$yearfundf!="")
	{
	echo "<table border='1' cellpadding='3' align='center'>";
	
	$query = "update partf_projects
	set project_center_year_type=concat(projnum,'-',center,'-',yearfundf,'-',projcat)
	where 1";
		$result = @MYSQL_QUERY($query,$connection);
		
	 $query = "truncate table cid_project_balances";
		$result = @MYSQL_QUERY($query,$connection);
	
	 $query = "insert into cid_project_balances (projnum,approved,pm_allocation,expenses)
	select projnum, sum(div_app_amt), '',''
	from partf_projects
	where 1 and yearfundf='$yearfundf' and projyn='y'
	group by projnum";
	   $result = @MYSQL_QUERY($query,$connection);
	
	 $query = "insert into cid_project_balances(projnum,approved,pm_allocation,expenses)
	select proj_num,'','',sum(amount)
	from partf_payments
	left join partf_projects on partf_payments.proj_num=partf_projects.projnum
	where 1 and partf_projects.yearfundf='$yearfundf'
	group by proj_num";
	  $result = @MYSQL_QUERY($query,$connection);
	
	 $query = "insert into cid_project_balances(projnum,approved,pm_allocation,expenses)
	select pm_allocations.projnum,'',pm_allocation,''
	from pm_allocations
	left join partf_projects on pm_allocations.projnum=partf_projects.projnum
	where 1 and partf_projects.yearfundf='$yearfundf'
	group by projnum";
	  $result = @MYSQL_QUERY($query,$connection);
	
	 $query = "select park,projname,partf_projects.project_center_year_type,sum(approved) as
	'approved',sum(pm_allocation) as 'pm_allocation', sum(expenses) as 'expenses', sum(approved-expenses) as 'balance', statusper as 'status',manager, cid_project_balances.projnum,partf_projects.center as varCenter
	from cid_project_balances
	left join partf_projects on cid_project_balances.projnum=partf_projects.projnum
	where 1 $access
	group by cid_project_balances.projnum
	order by partf_projects.park asc";
	   $result = @MYSQL_QUERY($query,$connection);
	//echo "$query";
	
	echo "<tr><td colspan='9' align='center'>PARTF Budget for $yearfundf using PARTF_Payments $maxDate</td></tr><tr><th>park</th><th>projname</th><th>project_center_year_type</th><th align='right'>approved</th><th align='right'>expenses</th><th align='right'>balance</th><th>status</th><th>manager</th>";
	
	echo "</tr>";
	while($row = mysql_fetch_array($result)){
	extract($row);
	$approvedF=number_format($approved,2);
	
	//$pm_link="<a href='prtf_pm_allocation.php?projnum=$projnum'>".number_format($pm_allocation,2)."</a>";
	$pm_link=number_format($pm_allocation,2);
	
	//$expense_link="<a href='prtf_center_budget.php?projnum=$projnum&center=$varCenter&q=e'>".number_format($expenses,2)."</a>";
	$expense_link=number_format($expenses,2);
	
	$balanceF=number_format($balance,2);
	$project_center_year_type=strtolower($project_center_year_type);
	$manager=strtolower($manager);
	echo "<tr>";
	/*
	echo "<td>$park</td><td>$projname</td><td>$project_center_year_type</td><td align='right'>$approvedF</td><td align='right'>$pm_link</td><td align='right'>$expense_link</td><td align='right'>$balanceF</td><td>$status</td><td>$manager</td>";
	*/
	echo "<td>$park</td><td>$projname</td><td>$project_center_year_type</td><td align='right'>$approvedF</td><td align='right'>$expense_link</td><td align='right'>$balanceF</td><td>$status</td><td>$manager</td>";
	
	echo "</tr>";
	$total_approved=$total_approved+$approved;
	$total_pm=$total_pm+$pm_allocation;
	$total_expenses=$total_expenses+$expenses;
	$total_balance=$total_balance+$balance;
	}// end while
	$total_approved=number_format($total_approved,2);
	$total_pm=number_format($total_pm,2);
	$total_expenses=number_format($total_expenses,2);
	$total_balance=number_format($total_balance,2);
	echo "<tr>
	<td colspan='4' align='right'><b>$total_approved</b></td>
	<td align='right'><b>$total_pm</b></td>
	<td align='right'><b>$total_expenses</b></td>
	<td align='right'><b>$total_balance</b></td>
	<td></td></tr></table>";
	}// end if
echo "</div></body></html>";

?>