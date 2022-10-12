<?php


session_start();
echo "Line 5<br />";
if(!$_SESSION["budget"]["tempID"]){echo "access denied";exit;
}

$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
include("../../../include/authBUDGET.inc");

//include("../../../include/activity.php");

extract($_REQUEST);
//echo "<pre>";print_r($_REQUEST);print_r($_SESSION);echo "</pre>";  //exit;
// Construct Query to be passed to Excel Export
foreach($_REQUEST as $k => $v)
	{
	if($v and $k!="PHPSESSID")
		{
		$varQuery.=$k."=".$v."&";
		}
	}
$passQuery=@$varQuery;
   @$varQuery.="rep=excel";    

if(@$rep=="excel"){header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment; filename=denr_report.xls');
}

if($_SESSION['budget']['level']<3){EXIT;}

/*
if(@$rep==""){
	if($_SESSION['budget']['beacon_num']=="60032779"){
	include_once("../menuAssistDirect.php");}
	else{include_once("../menu.php");}
	}
*/
	
if(@$rep==""){include("../../budget/menus2.php");}	
	
	
	
	
	

if(@$f_year==""){include("../~f_year.php");}

if(@$showSQL==1)
	{
	@$p="method='POST'";
	}
	else
	{
	$p="";
	}
echo "<hr><table align='center'><form action='denr_report.php' $p><tr>";

// Menu 1
if(@$rep=="")
	{
	$menuArray=array("disburse","receipt");
	
	echo "<td align='center'><b>DENR REPORT</b> Cash Type: <select name=\"cash_type\">";
	for ($n=0;$n<count($menuArray);$n++)
		{
		if(@$cash_type==$menuArray[$n])
			{
			$s="selected";
			}
			else
			{
			$s="value";
			}
		$con=$menuArray[$n];
				echo "<option $s='$con'>$menuArray[$n]</option>\n";
		}
	   echo "</select></td>";
	   
	  echo "<td>
	<input type='submit' name='submit' value='Submit'>";
	echo "</form></td><td><a href='denr_report.php?$varQuery'>Excel</a></td></tr>
	<tr><td>View <a href='certified_authorized_budget.php' target='_blank'>Certified Authorized Budget</a></td></tr>
	</table>";
	
	if(@$submit!="Submit"){$cash_type="disburse";}
	}

//echo "<pre>";print_r($_REQUEST);print_r($_SESSION);echo "</pre>";  exit;

// ********* Body Queries ***************
 $query = "truncate table budget_request2;";
 $result = @mysqli_query($connection, $query);
if(@$showSQL=="1"){echo "$query<br><br>";}

$query = "insert into budget_request2(ncas_num,center,authorized,amount_py3,amount_py2,amount_py1,amount_cy,approved_changes,unapproved_requests,reversions) select account,fund,sum(authorized),'','','','','','','' from authorized_budget where 1 and f_year='$f_year'  group by account,fund;
";
 $result = @mysqli_query($connection, $query);
if(@$showSQL=="1"){echo "$query<br><br>";}

$query = "insert into budget_request2(ncas_num,center,authorized,amount_py3,amount_py2,amount_py1,amount_cy,approved_changes,unapproved_requests,reversions) select account,fund,'','','','','','','',sum(reversions) from reversions where 1 and f_year='$f_year'  group by account,fund;
";
 $result = @mysqli_query($connection, $query);
if(@$showSQL=="1"){echo "$query<br><br>";}

 $query = "insert into budget_request2(ncas_num,center,authorized,amount_py3,amount_py2,amount_py1,amount_cy,approved_changes,unapproved_requests,reversions) select ncasnum,center,'',sum(amount_py3),sum(amount_py2),sum(amount_py1),sum(amount_cy),'' ,'','' from act3 where 1 group by ncasnum,center;
";
 $result = @mysqli_query($connection, $query);
if(@$showSQL=="1"){echo "$query<br><br>";}

 $query = "insert into budget_request2(ncas_num,center,authorized,amount_py3,amount_py2,amount_py1,amount_cy,approved_changes,unapproved_requests,reversions) select ncas_acct,center, '', '', '', '', '', sum(allocation_amount), '','' from budget_center_allocations where 1 and fy_req='$f_year' group by ncas_acct,center;
";
 $result = @mysqli_query($connection, $query);
if(@$showSQL=="1"){echo "$query<br><br>";}

 $query = "insert into budget_request2(ncas_num,center,authorized,amount_py3,amount_py2,amount_py1,amount_cy,approved_changes,unapproved_requests,reversions) select ncas_number,center,'','','','','','',sum(allocation_amount),'' from manual_allocations_3 where 1 and approved='n' and f_year='$f_year' group by ncas_number,center;
";
 $result = @mysqli_query($connection, $query);
if(@$showSQL=="1"){echo "$query<br><br>";}


 $query = "update budget_request2,coa
set budget_request2.cash_type=coa.cash_type
where budget_request2.ncas_num=coa.ncasnum;
";
 $result = @mysqli_query($connection, $query);
if(@$showSQL=="1"){echo "$query<br><br>";}


 $query = "update budget_request2,coa
set budget_request2.budget_group=coa.budget_group
where budget_request2.ncas_num=coa.ncasnum;
";
 $result = @mysqli_query($connection, $query);
if(@$showSQL=="1"){echo "$query<br><br>";}


 $query = "truncate table budget_request3;
";
 $result = @mysqli_query($connection, $query);
if(@$showSQL=="1"){echo "$query<br><br>";}


 $query = "insert into budget_request3(ncas_num,center,authorized,amount_py3,amount_py2,amount_py1,amount_cy,approved_changes,unapproved_requests,reversions) select ncas_num,center,sum(authorized),sum(amount_py3),sum(amount_py2),sum(amount_py1),sum(amount_cy),sum(approved_changes),sum(unapproved_requests),sum(reversions) from budget_request2 where 1  and cash_type='disburse' group by ncas_num,center;
";
 $result = @mysqli_query($connection, $query);
if(@$showSQL=="1"){echo "$query<br><br>";}


 $query = "insert into budget_request3(ncas_num,center,authorized,amount_py3,amount_py2,amount_py1,amount_cy,approved_changes,unapproved_requests,reversions) select ncas_num,center,sum(authorized),-sum(amount_py3),-sum(amount_py2),-sum(amount_py1),-sum(amount_cy),sum(approved_changes),-sum(unapproved_requests),sum(reversions) from budget_request2 where 1  and cash_type='receipt' group by ncas_num,center;
";
 $result = @mysqli_query($connection, $query);
if(@$showSQL=="1"){echo "$query<br><br>";}


 $query = "update budget_request3,coa
set budget_request3.budget_group=coa.budget_group
where budget_request3.ncas_num=coa.ncasnum;
";
 $result = @mysqli_query($connection, $query);
if(@$showSQL=="1"){echo "$query<br><br>";}



 $query = "update budget_request3,coa
set budget_request3.cash_type=coa.cash_type
where budget_request3.ncas_num=coa.ncasnum;
";
 $result = @mysqli_query($connection, $query);
if(@$showSQL=="1"){echo "$query<br><br>";}


//Explicitly populate $headerArray instead of dynamic
$headerArray=array("cash_type","budget_group","authorized_budget","reversions","new_authorized","center_budgets","available_funds");

$decimalFlds=array("authorized_budget","reversions","new_authorized","center_budgets","available_funds");

//print_r($decimalFlds);
//print_r($headerArray);


 $query = "select  cash_type,budget_request3.budget_group,sum(authorized) as 'authorized_budget', sum(reversions) as 'reversions',sum(authorized-reversions) as 'new_authorized',sum(amount_py1+approved_changes) as 'center_budgets', sum(authorized-amount_py1-approved_changes-reversions) as 'available_funds' from budget_request3  where 1 and cash_type='$cash_type' and center like '1680%' group by budget_group,cash_type order by cash_type,budget_group
";
 $result = @mysqli_query($connection, $query);
if(@$showSQL=="1"){echo "$query<br><br>";}

echo "$query<br>";//exit;

$count=count($headerArray);
for($i=0;$i<$count;$i++)
	{
	$h=$headerArray[$i];
	@$header.="<th>".$h."</th>";
	}

// Populate array with result
while($row=mysqli_fetch_array($result))
	{
	$b[]=$row;
	}


//************ Produce the Body ************
echo "<table border='1'>";
echo "<tr>$header</tr>";

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
		
	if($headerArray[$j]=="ncas_num"){$var="<a href='/budget/a/curr_year_budget_div_by_acct_drill.php?account=$var&submit=Submit' target='_blank'>$var</a>";}
	
	
	if(@in_array($headerArray[$j],$decimalFlds))
		{
		$a="<td align='right'$bc>";
		@$totArray[$headerArray[$j]]+=$var;
		
		if(@$headerArray[$j]=="available_funds" AND $cash_type=="receipt")
			{$var=-($var);}
		
		if($var<0){$f1="<font color='red'>";$f2="</font>";}else{$f1="";$f2="";}
		if($headerArray[$j]=="budget_rate")
			{
			$var=number_format($var,3);
			}
			else
			{
			$var=numFormat($var);
			}
		}
		else
		{
		$a="<td$bc>";
		}
	if(@in_array($headerArray[$j],$editFlds))
		{
				$cs="7";
		if($headerArray[$j]=="equipment_description" || $headerArray[$j]=="justification")
			{
			$cs="25";
			}
		else
			{
			if($headerArray[$j]=="ncas_account" || $headerArray[$j]=="pay_center"){$cs="10";}
			}
	
		if(@in_array($headerArray[$j],$radioFlds))
			{
				if($var=="y")
			{$ckY="checked";$ckN="";}else{$ckN="checked";$ckY="";}
			
			echo "<td align='center'$bc>
			<font color='green'>Y</font><input type='radio' name='$headerArray[$j][$er]' value='y'$ckY>
			 <font color='red'>N</font><input type='radio' name='$headerArray[$j][$er]' value='n'$ckN></td>";
			 }
		else			
			{
			echo "<td align='center'$bc><input type='text' name='$headerArray[$j][$er]' value='$var' size='$cs'></td>";
			}
				
		}
		else
		{
			
			if($headerArray[$j]=="center_budgets"){
				$bg=$b[$i]['budget_group'];
				$link="/budget/a/current_year_budget_div.php?budget_group_menu=$bg&submit=Submit";
				$var="<a href='$link'>$var</a>";}
			echo "$a$f1$var$f2</td>";
		}
			@$f1=""; @$f2="";
	}
	
echo "</tr>";
	}



echo "<tr>";
	for($j=0;$j<count($headerArray);$j++)
		{
		if(@$totArray[$headerArray[$j]])
			{
			@$var=$totArray[$headerArray[$j]];
				
			if($headerArray[$j]=="available_funds" AND $cash_type=="receipt"){$var=-($var);}
			
			if($var<0){$f1="<font color='red'>";$f2="</font>";}else{$f1="";$f2="";}
			if($headerArray[$j]=="budget_rate"){$v=number_format($var,3);}else{$v=numFormat($var);}
			
			echo "<td align='right'>$f1<b>$v</b>$f2</td>";
			}
			else
			{
			echo "<td></td>";
			}
		}

echo "</tr><tr>$header</tr></table></body></html>";

function numFormat($nf){
$nf=number_format($nf,2);
return $nf;}

?>



