<?php
$dbTable="partf_payments";
$file="prtf_center_budget_a.php";
$fileMenu="prtf_center_budget_menu.php";

//echo "<pre>";print_r($_REQUEST);echo "</pre>";//exit;
session_start();
$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/connectROOT.inc"); // connection parameters
mysql_select_db($database, $connection); // database
include("../../../include/activity.php");
$system_entry_date2=date("Ymd");
//echo "<pre>";print_r($_SESSION);echo "</pre>";//exit;
$level=$_SESSION['budget']['level'];
if($level<1){echo "Access denied. Contact Tony Bass or Tom Howard. File budget/b/prtf_center_budget_a.php line 16.";}

if($_SESSION['budget']['beacon_num']=="60033160"){
	// Carol Tingley - Head Nat. Res.
	$level=5;}

if($_SESSION['budget']['beacon_num']=="60032790"){
	// Sue Regier - Land Res.
	$level=5;}
	
if($_SESSION['budget']['beacon_num']=="60032877"){
	// Siobhan - Exhibits
	$level=4;}
if($_SESSION['budget']['beacon_num']=="60092637"){
	// Martin Kane-Exhibits
	$level=4;}
	
if($_SESSION['budget']['beacon_num']=="60032833"){
	// Erin Lawrence-Design and Development
	$level=4;}	


if($_SESSION['budget']['beacon_num']=="60032794"){
	// Laura Fuller (NRC)
	$level=4;}	





	
extract($_REQUEST);

if($stop_pay_change=='y')
{
if($stop_pay_status=='n'){$stop_pay='y';}	
if($stop_pay_status=='y'){$stop_pay='n';}	
	
$query = "update center set stop_pay='$stop_pay' where new_center='$center' ";

//echo "<br><br>$query";//exit;

$result = @MYSQL_QUERY($query,$connection);	
	
}


if($add_funds_change=='y')
{
	
$query = "insert into partf_fund_trans
          set trans_type='buof_manual',fund_in='$new_center',amount='$add_funds_amount',comments='increase to approved amount per xtnd',
		      date_new='$system_entry_date2'  ";

echo "<br><br>$query";  exit;

//$result = @MYSQL_QUERY($query,$connection);	
	
}



if(!isset($showSQL)){$showSQL="";}
	
// Determine access
if($level<4){
if($_SESSION['budget']['report'][0]=="prtf_center_budget"){$temp=$_SESSION['budget']['tempID'];$ln=substr($temp,0,-4);
//$access="and partf_projects.manager like '%$ln'";
$center=strtoupper($center);$centerman=$_SESSION['budget']['manager'];

}

if($level==2){
include_once("../../../include/get_parkcodes.php");
$parkList=$_SESSION['budget']['select'];// Get district
$da=${"array".$parkList}; //print_r($da);exit;
if(in_array($parkList,$da)){$WHERE.=" and park='$distPark'";}else{echo "<br><br>You do not have access privileges for this database [$db] report at $level $posTitle. Contact Tom Howard tom.howard@ncmail.net if you wish to gain access.<br>prtf_center_budget.php<br>budget.php<br>dist=$parkList $distPark";exit;}
}
else
{
if(!$temp){echo "yes0 You do not have access privileges for this database [Budget] report [$file] at Level: $level $posTitle. Contact Tom Howard tom.howard@ncmail.net if you wish to gain access.";exit;}
		}
}


$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/connectROOT.inc"); // connection parameters
mysql_select_db($database, $connection); // database

// Get most recent date from Exp_Rev
$sql="SELECT DATE_FORMAT(max(datenew),'Report Date: <font color=\'red\'>%c/%e/%y</font>') as maxDate FROM `partf_payments` WHERE 1";
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
if($level>2){$add="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href='/budget/partf.php?submit=Add'>Add</a> New Project";}
if($varQuery){echo "<a href='$file?$varQuery&rep=excel'>Excel Export</a>$add";}
}

// ************* Center ********************
if($center!=""){

if($statusFilter!=""){$statusA=explode(",",strtoupper($statusFilter));}
//print_r($statusA);

$query = "update partf_projects
set project_center_year_type=concat(projnum,'-',center,'-',yearfundf,'-',projcat,'-',spo_number)
where 1";
    $result = @MYSQL_QUERY($query,$connection);
if($showSQL=="1"){echo "<br><br>$query";}
    
 $query = "truncate table cid_project_balances";
    $result = @MYSQL_QUERY($query,$connection);
if($showSQL=="1"){echo "<br><br>$query";}

 $query = "insert into cid_project_balances(projnum,approved,pm_allocation,expenses)
select projnum,sum(div_app_amt),'',''
from partf_projects
where 1 and center='$center'and projyn='y'
group by projnum;";

//echo "<br><br>$query";//exit;

  $result = @MYSQL_QUERY($query,$connection);
if($showSQL=="1"){echo "<br><br>$query";}
 $af=mysql_affected_rows();
if($af==0){echo "<br><br>No project found for $query";exit;}

 $query = "insert into cid_project_balances(projnum,approved,pm_allocation,expenses)
select proj_num,'','',sum(amount)
from partf_payments
where 1 and center='$center'
group by proj_num";
   $result = @MYSQL_QUERY($query,$connection);
if($showSQL=="1"){echo "<br><br>$query";}

//echo "<br><br>$query";//exit;

 $query = "insert into cid_project_balances(projnum,approved,pm_allocation,expenses)
select projnum,'',pm_allocation,''
from pm_allocations
where 1 and center='$center'
group by projnum";
  $result = @MYSQL_QUERY($query,$connection);
if($showSQL=="1"){echo "<br><br>$query";}

//echo "<br><br>$query";//exit;
if(!isset($access)){$access="";}
 $query = "select park,projname,partf_projects.project_center_year_type,sum(approved) as
'approved',sum(pm_allocation) as 'pm_allocation', sum(expenses) as 'expenses', sum(approved-expenses) as 'balancePB', statusper as 'status',dateadded,statusper_fi_date,manager, cid_project_balances.projnum
from cid_project_balances
left join partf_projects on cid_project_balances.projnum=partf_projects.projnum
where 1 $access
group by cid_project_balances.projnum
order by park,status desc, partf_projects.projnum asc";
   $result = @MYSQL_QUERY($query,$connection);
if($showSQL=="1"){echo "<br><br>$query";}
//echo "<br>$query";

//echo "</tr>";
while($row = mysql_fetch_array($result)){
extract($row);

if($balancePB>0 and $status!="FI" and $status!="CA" and $status!="TR"){$proj_bal=$balancePB;} else{$proj_bal="";}

$parkAray[]=$park;
$projnumArray[]=$projnum;
$projnameArray[]=$projname;
$project_center_year_typeArray[]=$project_center_year_type;
$approvedArray[]=$approved;
$expensesArray[]=$expenses;
$balanceArray[]=$balancePB;
$statusArray[]=$status;
$dateaddedArray[]=substr($dateadded,0,4)."-".substr($dateadded,4,4);
$statusper_fi_date_Array[]=$statusper_fi_date;
$managerArray[]=$manager;

$total_approved=@$total_approved+$approved;
$total_expenses=@$total_expenses+$expenses;
$total_balance=@$total_balance+@$balance;
$total_proj_bal=@$total_proj_bal+$proj_bal;

}// end while

$total_approved=number_format($total_approved,2);
$total_pm=number_format($total_pm,2);
$total_expenses=number_format($total_expenses,2);
$total_balance=number_format($total_balance,2);



if($center){

include("centerQuery.php");

//echo "<br><br>$sql";//exit;
$result = @mysql_query($sql);
$row = mysql_fetch_array($result);
 extract($row);
 $funds_allocated=number_format($funds_allocated,2);
 $payments=number_format($payments,2);
$available_funds=number_format($balance-$total_proj_bal,2);
if($available_funds<0){$available_funds="<font color='red'>".$available_funds."</font>";}
 $balance=number_format($balance,2);

echo "<br>DPR PARTF BUDGETS LOOKUP BY CENTERS<hr>";
echo "<table border='1' cellpadding='3' align='center'>";

$total_proj_balF=number_format($total_proj_bal,2);
echo "<tr>
<th>center_desc</th><th>funds_allocated</th><th width='90'>payments</th><th width='90'>Center balance on <font color='red'>$datenew</font></th>
<th>Project Balances</th><th>Available Funds</th>";
if($beacnum=$_SESSION['budget']['beacon_num']=='60032781')
{
echo "<th>Center Pay Status<br />(Budget Officer ONLY)</th>";
echo "<th>Add Funds<br />(Budget Officer ONLY)</th>";
	
}
echo "</tr><tr>
<td>$center_desc</td><td align='center'>$funds_allocated";
echo "</td><td align='center'>$payments</td><td align='center'>$balance</td><td align='center'>$total_proj_balF</td><td align='center'>$available_funds</td>";
if($beacnum=$_SESSION['budget']['beacon_num']=='60032781')
{
	
$query1="SELECT stop_pay from center where new_center='$center' ";

$result1 = mysql_query($query1) or die ("Couldn't execute query 1.  $query1");

$row1=mysql_fetch_array($result1);
extract($row1);//brings back max (end_date) as $end_date	
if($stop_pay=='y'){$stop_pay_mess='Pay=<font color=red>NO</font>';}	
if($stop_pay=='n'){$stop_pay_mess='Pay=<font color=green>YES</font>';}	
	
	echo "<td>$stop_pay_mess<form action='prtf_center_budget_a.php'><input type='submit' name='stop_pay_change' value='change_pay_status'><input type='hidden' name='stop_pay_change' value='y'><input type='hidden' name='center' value='$center'><input type='hidden' name='submit' value='Submit'><input type='hidden' name='stop_pay_status' value='$stop_pay'></form></td>";
	
	echo "<td><form action='prtf_center_budget_a.php'><input type='text' name='add_funds_amount'><input type='submit' name='add_funds_x' value='add_funds'><input type='hidden' name='add_funds_change' value='y'><input type='hidden' name='center' value='$center'><input type='hidden' name='submit' value='Submit'></form></td>";
	
	
	
	
}
echo "</tr></table>";
}

echo "<table border='1' cellpadding='3' align='center'><tr><td colspan='8' align='center'>PARTF Budget for <b><font color='red'>Center $center</font></b> using PARTF_Payments $maxDate&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type='button' value='Status Codes' onclick=\"return popitup('terminology.php')\"></td></tr><tr><th>park</th><th>projname</th><th>project_center_year_type</th><th align='right'>approved</th><th align='right'>expenses</th><th align='right'>balance</th><th>status</th><th>manager</th></tr>";

for($i=0;$i<count($project_center_year_typeArray);$i++)
	{
	if($table_bg2==''){$table_bg2='cornsilk';}
    if($c==''){$t=" bgcolor='$table_bg2' ";$c=1;}else{$t='';$c='';}
	$testStatus=strtoupper($statusArray[$i]);
	if(!@$statusA || in_array($testStatus,$statusA))
		{
		$a=number_format($approvedArray[$i],2);
		$expense_link="<a href='prtf_center_budget.php?projnum=$projnumArray[$i]&center=$center&q=e' target='_blank'>".number_format($expensesArray[$i],2)."</a>";
		$b=number_format($balanceArray[$i],2);
		
		$status_link="<a href='park_project_balances.php?projnum=$projnumArray[$i]&status=1&cen=$center'>".$statusArray[$i]."</a>";
		
		echo "<tr$t>
		<td>$parkAray[$i]</td>
		<td>$projnameArray[$i]</td>
		<td>$project_center_year_typeArray[$i]<a href='/budget/partf.php?projstring=$project_center_year_typeArray[$i]&Submit=Find'>View</a></td>
		<td align='right'>$a</td>
		<td align='right'>$expense_link</td>
		<td align='right'>$b</td>
		<td align='center'>$dateaddedArray[$i]<br />$status_link<br />";
		if($statusper_fi_date_Array[$i]!='0000-00-00'){echo "$statusper_fi_date_Array[$i]";} 
		echo "</td>
		<td>$managerArray[$i]</td>
		</tr>";
		}// end if
	}// end for

echo "<tr>
<td colspan='4' align='right'><b>$total_approved</b></td>";
echo "<td align='right'><b>$total_expenses</b></td>

</tr></table>";
}// end if
//print_r($parkArray);
echo "</div></body></html>";

?>