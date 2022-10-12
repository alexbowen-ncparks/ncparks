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
//echo "<pre>";print_r($_REQUEST);print_r($_SESSION);echo "</pre>";exit;
// Construct Query to be passed to Excel Export
foreach($_REQUEST as $k => $v){
if($v and $k!="PHPSESSID"){$varQuery.=$k."=".$v."&";}
}
$passQuery=$varQuery;
   $varQuery.="rep=excel";    

if($rep=="excel"){header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment; filename=division_budget.xls');
include("division_budget_header.php");
}


// *********** Level > 3 ************
if($_SESSION[budget][level]>3){//print_r($_REQUEST);EXIT;

if($rep==""){
include_once("../menu.php");
include("division_budget_header.php");


if($f_year==""){include("../~f_year.php");}


if($showSQL==1){$p="method='POST'";}
echo "<hr><table align='center'><form action='division_budget.php' $p><tr>";

// Menu 1
echo "<td align='center'>Fiscal Year<br><input type='text' name='f_year' value='$f_year' size='7'></td>";
   

// Menu 3
$sql="SELECT DISTINCT (budget_group)
FROM coa
WHERE budget_group != 'land' AND budget_group != 'buildings' AND budget_group != 'reserves' AND budget_group != 'funding_receipt' AND budget_group != 'funding_disburse' AND budget_group != 'professional_services'
ORDER BY budget_group";
$result = mysqli_query($connection, $sql) or die ("Couldn't execute query 1. $sql");
while ($row=mysqli_fetch_array($result)){
$menuArray[]=$row[budget_group];}

if($budget_group){$budget_group_ck=$budget_group;}else{$budget_group_ck="operating_expenses";}
echo "<td align='center'>Budget Group<br><select name=\"budget_group\">";
for ($n=0;$n<count($menuArray);$n++){
if($budget_group_ck==$menuArray[$n]){$s="selected";}else{$s="value";}
$con=$menuArray[$n];
		echo "<option $s='$con'>$menuArray[$n]</option>\n";
       }
   echo "</select></td>";
   
// Menu 5
echo "<td align='center'>NCAS Num<br><input type='text' name='ncas_num' value='' size='12'></td>";
   
   echo "<td align='center'><input type='checkbox' name='showSQL' value='1'>Show SQL</td>";
   
   echo "<td>
<input type='submit' name='submit' value='Submit'>";
echo "</form></td><form><td><input type='submit' name='reset' value='Reset'></td></form><td><a href='division_budget.php?$varQuery'>Excel</a></td></tr></table>";
}
}// end Level > 3

if($submit!="Submit"){exit;}

// ********* Body Queries ***************
 $query = "truncate table budget_request;";
 $result = @mysqli_query($connection, $query,$connection);
if($showSQL=="1"){echo "$query<br><br>";}
/*
$query = "insert into budget_request(ncas_num,center,authorized,amount_py3,amount_py2,amount_py1,amount_cy,approved_changes,unapproved_requests)
select account,fund,sum(authorized),'','','','','',''
from authorized_budget
where 1
and f_year='$f_year' and account not like '5338%'
group by account,fund;";
 $result = @mysqli_query($connection, $query,$connection);
if($showSQL=="1"){echo "$query<br><br>";}
*/

$query = "insert into budget_request(ncas_num,center,authorized,amount_py3,amount_py2,amount_py1,amount_cy,approved_changes,unapproved_requests)
select account,fund,sum(authorized),'','','','','',''
from authorized_budget
where 1
and f_year='$f_year' 
group by account,fund;";
 $result = @mysqli_query($connection, $query,$connection);
if($showSQL=="1"){echo "$query<br><br>";}

/*
$query = "insert into budget_request(ncas_num,center,authorized,amount_py3,amount_py2,amount_py1,amount_cy,approved_changes,unapproved_requests) select account,fund,sum(-authorized),'','','','','','' from authorized_budget where 1 and f_year='0708' and account like '5338%'
group by account,fund;
";
 $result = @mysqli_query($connection, $query,$connection);
if($showSQL=="1"){echo "$query<br><br>";}
*/
 $query = "insert into budget_request(ncas_num,center,authorized,amount_py3,amount_py2,amount_py1,amount_cy,approved_changes,unapproved_requests)
select ncasnum,center,'',sum(amount_py3),sum(amount_py2),sum(amount_py1),sum(amount_cy),''
,''
from act3
where 1
group by ncasnum,center;";
 $result = @mysqli_query($connection, $query,$connection);
if($showSQL=="1"){echo "$query<br><br>";}

 $query = "insert into budget_request(ncas_num,center,authorized,amount_py3,amount_py2,amount_py1,amount_cy,approved_changes,unapproved_requests)
select ncas_acct,center,
'',
'',
'',
'',
'',
sum(allocation_amount),
''
from budget_center_allocations
where 1 and fy_req='$f_year'
group by ncas_acct,center;";
 $result = @mysqli_query($connection, $query,$connection);
if($showSQL=="1"){echo "$query<br><br>";}

 $query = "insert into budget_request(ncas_num,center,authorized,amount_py3,amount_py2,amount_py1,amount_cy,approved_changes,unapproved_requests)
select acct,center,'','','','','','',sum(requested_increase+district_change+division_change) as 'unapproved_requests'
from opexpense_request_3
where 1
and division_approved='n'
and f_year='$f_year'
group by acct,center;";
 $result = @mysqli_query($connection, $query,$connection);
if($showSQL=="1"){echo "$query<br><br>";}


 $query = "insert into budget_request(ncas_num,center,authorized,amount_py3,amount_py2,amount_py1,amount_cy,approved_changes,unapproved_requests) 
select ncas_number,center,'','','','','','',sum(allocation_amount)
from manual_allocations_3
where 1
and approved='n'
and f_year='$f_year'
group by ncas_number,center;";
 $result = @mysqli_query($connection, $query,$connection);
if($showSQL=="1"){echo "$query<br><br>";}

//Explicitly populate $headerArray instead of dynamic
$headerArray=array("ncas_num","ncasnum_description","authorized_budget","approved_budget","available_funds");

$decimalFlds=array("approved_budget","authorized_budget","available_funds");

//print_r($decimalFlds);
//print_r($headerArray);


$whereFilter="where 1";

if($budget_group){$whereFilter.=" and coa.budget_group='$budget_group'";}
if($ncas_num){$whereFilter.=" and budget_request.ncas_num='$ncas_num'";}


$revArray=array("other_revenues","pfr_revenues","grants","reimbursements","par3","rental_and_use","crs_fees","donations","fees","funding_receipt","professional_services","operating_contracts","pier_permits");

/*select query*/

if(in_array($budget_group,$revArray)){
$sql="select ncas_num,park_acct_desc as 'ncasnum_description', sum(authorized) as 'authorized_budget',sum(-amount_py1-approved_changes) as 'approved_budget', sum(-authorized-amount_py1-approved_changes) as 'available_funds' from budget_request left join coa on budget_request.ncas_num=coa.ncasnum
where 1 and coa.budget_group='$budget_group' and center like '1280%' group by ncas_num order by ncas_num;
";}else{
$sql="select ncas_num,park_acct_desc as 'ncasnum_description', sum(authorized) as 'authorized_budget',
sum(amount_py1+approved_changes) as 'approved_budget', sum(authorized-amount_py1-approved_changes) as 'available_funds'
from budget_request
left join coa on budget_request.ncas_num=coa.ncasnum
$whereFilter
and center like '1280%'
group by ncas_num
order by ncas_num";}

//echo "$sql<br>";//exit;

if($showSQL=="1"){echo "$sql<br>";}


$count=count($headerArray);
for($i=0;$i<$count;$i++){
$h=$headerArray[$i];
$header.="<th>".$h."</th>";}


$result = mysqli_query($connection, $sql) or die ("Couldn't execute query. $sql");
//$num=mysqli_num_rows($result);

// Populate array with result
while($row=mysqli_fetch_array($result)){
$b[]=$row;
}

//************ Produce the Header ************
$summaryHeaders=array("f_year","authorized_budget","approved_budget","unapproved_requests","available_funds");

for($i=0;$i<count($b);$i++){
for($j=0;$j<count($summaryHeaders);$j++){
	$var=$b[$i][$summaryHeaders[$j]];
	if($summaryHeaders[$j]!="f_year"){
	$totArrayH[$summaryHeaders[$j]]+=$var;}else{$totArrayH[$summaryHeaders[$j]]=$f_year;}
	}
}

echo "<table border='1'><tr>";
	for($j=0;$j<count($summaryHeaders);$j++){
	if($totArrayH[$summaryHeaders[$j]]){
	$var=$totArrayH[$summaryHeaders[$j]];
	if($var<0){$f1="<font color='red'>";$f2="</font>";}else{$f1="<font color='blue'>";$f2="</font>";}
	if($summaryHeaders[$j]=="f_year"){$v=$var;}else{$v=numFormat($var);}
	echo "<td align='center'><b>$summaryHeaders[$j]</b><br>$f1$v$f2</td>";}else{echo "<td></td>";}
}

echo "</tr></table>";

//************ Produce the Body ************
echo "<table border='1'>";
echo "<tr>$header</tr>";

if($level>3){
//$radioFlds=array("district_approved","division_approved");

//if($edit){$editFlds=array("budget_hrs","budget_weeks","district_approved","division_approved");}

$x=2;
echo "<tr>";
	for($i=0;$i<count($b);$i++){
	$r=fmod($i,$x);if($r==0){$bc=" bgcolor='aliceblue'";}else{$bc="";}
echo "<tr$bc>";

	for($j=0;$j<count($headerArray);$j++){
	$var=$b[$i][$headerArray[$j]];
	if($headerArray[$j]=="status" and $var=="inactive"){
	$bc=" bgcolor='yellow'";}
	
	if($headerArray[$j]=="request_id"){$er=$var;}
		
	if($headerArray[$j]=="ncas_num"){$var="<a href='/budget/a/curr_year_budget_div_by_acct_drill.php?account=$var&budget_group=$budget_group&submit=Submit' target='_blank'>$var</a>";}
	
	if($var<0){$f1="<font color='red'>";$f2="</font>";}else{$f1="";$f2="";}
	
	if(in_array($headerArray[$j],$decimalFlds)){
	$a="<td align='right'$bc>";
	$totArray[$headerArray[$j]]+=$var;
	if($headerArray[$j]=="budget_rate"){$var=number_format($var,3);}else{$var=numFormat($var);}
			}else{$a="<td$bc>";}
			if(in_array($headerArray[$j],$editFlds)){
			$cs="7";
	if($headerArray[$j]=="equipment_description" || $headerArray[$j]=="justification"){$cs="25";}else{
if($headerArray[$j]=="ncas_account" || $headerArray[$j]=="pay_center"){$cs="10";}
}
			if(in_array($headerArray[$j],$radioFlds)){
	if($var=="y")
{$ckY="checked";$ckN="";}else{$ckN="checked";$ckY="";}

echo "<td align='center'$bc>
<font color='green'>Y</font><input type='radio' name='$headerArray[$j][$er]' value='y'$ckY>
 <font color='red'>N</font><input type='radio' name='$headerArray[$j][$er]' value='n'$ckN></td>";}
else
			
			{echo "<td align='center'$bc><input type='text' name='$headerArray[$j][$er]' value='$var' size='$cs'></td>";}
			
			}else{echo "$a$f1$var$f2</td>";}	
	}
	
echo "</tr>";
	}
}// end if level > 4


echo "<tr>";
	for($j=0;$j<count($headerArray);$j++){
	if($totArray[$headerArray[$j]]){
	$var=$totArray[$headerArray[$j]];
	if($var<0){$f1="<font color='red'>";$f2="</font>";}else{$f1="";$f2="";}
	if($headerArray[$j]=="budget_rate"){$v=number_format($var,3);}else{$v=numFormat($var);}
	echo "<td align='right'>$f1<b>$v</b>$f2</td>";}else{echo "<td></td>";}
}

echo "</tr><tr>$header</tr></table></body></html>";

function numFormat($nf){
$nf=number_format($nf,2);
return $nf;}
?>



