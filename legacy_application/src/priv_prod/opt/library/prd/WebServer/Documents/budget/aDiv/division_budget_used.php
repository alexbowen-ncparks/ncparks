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

$f_year=$_REQUEST['f_year_pass'];

if($rep=="excel"){header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment; filename=division_budget_used.xls');
//include("division_budget_used_header.php");
}


// *********** Level > 3 ************
if($_SESSION['budget']['level']>3){//print_r($_REQUEST);EXIT;

if($rep==""){
include_once("../menu.php");
include("division_budget_used_header.php");

if($showSQL==1){$p="method='POST'";}
echo "<hr><table align='center'><form action='division_budget_used.php' $p><tr>";

// Menu 1
echo "<td align='center'>Fiscal Year<br><input type='text' name='f_year_pass' value='$f_year' size='7'></td>";
   
// Menu 2
$sql="select distinct(budget_group)
from coa
where 1
order by budget_group;";
$result = mysqli_query($connection, $sql) or die ("Couldn't execute query 1. $sql");
while ($row=mysqli_fetch_array($result)){
$menuArray[]=$row['budget_group'];}

echo "<td align='center'>Budget Group<br><select name=\"budget_group\">";
for ($n=0;$n<count($menuArray);$n++){
if($budget_group==$menuArray[$n]){$s="selected";}else{$s="value";}
if($budget_group=="" and $menuArray[$n]=="operating_expenses"){$s="selected";}
$con=$menuArray[$n];
		echo "<option $s='$con'>$menuArray[$n]</option>\n";
       }
   echo "</select></td>";

// Menu 3

$sql="SELECT distinct section from center where 1 order by section";
$result = mysqli_query($connection, $sql) or die ("Couldn't execute query 1. $sql");
while ($row=mysqli_fetch_array($result)){
$sec[]=$row['section'];}

echo "<td align='center'>Section<br><select name=\"section\"><option selected></option>";
for ($n=0;$n<count($sec);$n++){
if($section==$sec[$n]){$s="selected";}else{$s="value";}
$con=$sec[$n];
		echo "<option $s='$con'>$sec[$n]</option>\n";
       }
   echo "</select></td>";
   
   
unset($menuArray);
// Menu 4
$sql="select distinct(dist) from center where fund='1280' order by dist";
$result = mysqli_query($connection, $sql) or die ("Couldn't execute query 1. $sql");
while ($row=mysqli_fetch_array($result)){
$menuArray[]=$row[dist];}

echo "<td align='center'>District<br><select name=\"dist\">";
for ($n=0;$n<count($menuArray);$n++){
if($dist==$menuArray[$n]){$s="selected";}else{$s="value";}
$con=$menuArray[$n];
		echo "<option $s='$con'>$menuArray[$n]</option>\n";
       }
   echo "</select></td>";
   
   echo "<td align='center'><input type='checkbox' name='showSQL' value='1'>Show SQL</td>";
   
   echo "<td>
<input type='submit' name='submit' value='Submit'>";
echo "</form></td><form><td><input type='submit' name='reset' value='Reset'></td></form><td><a href='division_budget_used.php?$varQuery'>Excel</a></td></tr></table>";
}
}// end Level > 4

if($submit!="Submit"){exit;}

// ********* Body Queries ***************
 $query = "truncate table budget_used;";
 $result = @mysqli_query($connection, $query,$connection);
if($showSQL=="1"){echo "$query<br><br>";}

$query = "insert into budget_used(ncas_num,center,authorized,amount_py3,amount_py2,amount_py1,amount_cy,approved_changes,unapproved_requests,amount_lytt) select account,fund,sum(authorized),'','','','','','','' from authorized_budget where 1 and f_year='$f_year' group by account,fund;";
 $result = @mysqli_query($connection, $query,$connection);
if($showSQL=="1"){echo "$query<br><br>";}

 $query = "insert into budget_used(ncas_num,center,authorized,amount_py3,amount_py2,amount_py1,amount_cy,approved_changes,unapproved_requests,amount_lytt) select ncasnum,center,'',sum(amount_py3),sum(amount_py2),sum(amount_py1),sum(amount_cy),sum(allocation_amount),'',sum(amount_lytt) from act3 where 1 group by ncasnum,center;";
 $result = @mysqli_query($connection, $query,$connection);
if($showSQL=="1"){echo "$query<br><br>";}

 $query = "insert into budget_used(ncas_num,center,authorized,amount_py3,amount_py2,amount_py1,amount_cy,approved_changes,unapproved_requests,amount_lytt) select acct,center,'','','','','','',sum(requested_increase+district_change+division_change) as 'unapproved_requests','' from opexpense_request_3 where 1 and division_approved='n' and f_year='$f_year' group by acct,center;";
 $result = @mysqli_query($connection, $query,$connection);
if($showSQL=="1"){echo "$query<br><br>";}

 $query = "insert into budget_used(ncas_num,center,authorized,amount_py3,amount_py2,amount_py1,amount_cy,approved_changes,unapproved_requests,amount_lytt) 
select ncas_number,center,'','','','','','',sum(allocation_amount),''
from manual_allocations_3
where 1
and approved='n'
and f_year='$f_year'
group by ncas_number,center;"; //echo "$query";
 $result = @mysqli_query($connection, $query,$connection);
if($showSQL=="1"){echo "$query<br><br>";}


//Explicitly populate $headerArray instead of dynamic
//"unapproved_requests","unapproved_budget",
$headerArray=array("budget_group","parkcode","center","dist","approved_budget","amount_cy","current_available","months_used_cy","months_used_py");

$decimalFlds=array("approved_budget","unapproved_requests","unapproved_budget","amount_cy","current_available");

//print_r($decimalFlds);
//print_r($headerArray);


$whereFilter="where 1";

if($budget_group){$whereFilter.=" and coa.budget_group='$budget_group'";}
if($section){$whereFilter.=" and center.section='$section'";}
if($dist){$whereFilter.=" and dist='$dist'";}


/*select query*/

$sql="select budget_group,
parkcode,
budget_used.center,
dist,
sum(amount_cy) as 'amount_cy',
sum(amount_py1+approved_changes) as 'approved_budget',
sum(unapproved_requests) as 'unapproved_requests', 
sum(amount_py1+approved_changes+unapproved_requests-amount_cy) as 'current_available', round(sum(amount_cy)/(sum(amount_py1+approved_changes+unapproved_requests+.0001)/12),1) as 'months_used_cy',
round(sum(amount_lytt)/(sum(amount_py1+.001)/12),1) as 'months_used_py',
sum(amount_py1+approved_changes+unapproved_requests) as 'unapproved_budget'
from budget_used
left join coa on budget_used.ncas_num=coa.ncasnum
left join center on budget_used.center=center.center 
$whereFilter
and budget_used.center like '1280%'
group by budget_group,parkcode order by parkcode";

//echo "$sql<br>";//exit;

if($showSQL=="1"){echo "$sql<br>";}

$exclude=array("unapproved_requests","unapproved_budget");

$count=count($headerArray);
for($i=0;$i<$count;$i++){
$h=$headerArray[$i];
if(in_array($h,$exclude)){continue;}
$header.="<th>".$h."</th>";}


$result = mysqli_query($connection, $sql) or die ("Couldn't execute query. $sql");
//$num=mysqli_num_rows($result);

// Populate array with result
while($row=mysqli_fetch_array($result)){
$b[]=$row;
}
$count=count($b);

$sql="Select date_format(max(acctdate), '%a, %e %M %Y') as maxDate from exp_rev where 1";
$result = mysqli_query($connection, $sql) or die ("Couldn't execute query. $sql");
$row=mysqli_fetch_array($result); extract($row);

//************ Produce the Body ************
echo "<table border='1'>";
echo "<tr><td colspan='3' align='center'><font color='red'>Report Date: $maxDate</font></td><td colspan='2' align='center'>Record Count: $count</td></tr>";
echo "<tr>$header</tr>";

if($level>3){
//$radioFlds=array("district_approved","division_approved");

//if($edit){$editFlds=array("budget_hrs","budget_weeks","district_approved","division_approved");}

$x=2;
echo "<tr>";
	for($i=0;$i<$count;$i++){
	$r=fmod($i,$x);if($r==0){$bc=" bgcolor='aliceblue'";}else{$bc="";}
echo "<tr$bc>";

	for($j=0;$j<count($headerArray);$j++){
	$var=$b[$i][$headerArray[$j]];
	if($headerArray[$j]=="status" and $var=="inactive"){
	$bc=" bgcolor='yellow'";}//else{$bc="";}
	if($headerArray[$j]=="request_id"){$er=$var;}
	if($var<0){$f1="<font color='red'>";$f2="</font>";}else{$f1="";$f2="";}
	if(in_array($headerArray[$j],$decimalFlds)){
	$a="<td align='right'$bc>";
	$totArray[$headerArray[$j]]+=$var;
	if($headerArray[$j]=="budget_rate"){$var=number_format($var,3);}else{$var=numFormat($var);}
			}else{$a="<td$bc align='center'>";}
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
	echo "<td align='right'><b>$v</b></td>";}else{echo "<td></td>";}
}

echo "</tr></table></body></html>";

function numFormat($nf){
$nf=number_format($nf,2);
return $nf;}
?>



