<?php
echo "hello project_report1.php";
$center='4l61';
$query1 = "update partf_projects
set project_center_year_type=concat(projnum,'-',center,'-',yearfundf,'-',projcat,'-',spo_number)
where 1";
$result1 =mysqli_query($connection, $query1) or die ("Couldn't execute query 1.  $query1");
if($showSQL=="1"){echo "<br><br>$query1";}

$query2 = "truncate table cid_project_balances";
$result2 =mysqli_query($connection, $query2) or die ("Couldn't execute query 2.  $query2");
if($showSQL=="1"){echo "<br><br>$query2";}

$query3= "insert into cid_project_balances(projnum,approved,pm_allocation,expenses)
select projnum,sum(div_app_amt),'',''
from partf_projects
where 1 and center='$center'and projyn='y'
group by projnum;";
$result3 =mysqli_query($connection, $query3) or die ("Couldn't execute query 3.  $query3");
//echo "<br><br>$query";//exit;

if($showSQL=="1"){echo "<br><br>$query3";}
 $af=mysql_affected_rows();
if($af==0){echo "<br><br>No project found for $query";exit;}

$query4 = "insert into cid_project_balances(projnum,approved,pm_allocation,expenses)
select proj_num,'','',sum(amount)
from partf_payments
where 1 and center='$center'
group by proj_num";
$result4 =mysqli_query($connection, $query4) or die ("Couldn't execute query 4.  $query4");
if($showSQL=="1"){echo "<br><br>$query4";}

$query5 = "insert into cid_project_balances(projnum,approved,pm_allocation,expenses)
select projnum,'',pm_allocation,''
from pm_allocations
where 1 and center='$center'
group by projnum";
$result5 =mysqli_query($connection, $query5) or die ("Couldn't execute query 5.  $query5");
if($showSQL=="1"){echo "<br><br>$query5";}

$query6 = "select park,projname,partf_projects.project_center_year_type,sum(approved) as
'approved',sum(pm_allocation) as 'pm_allocation', sum(expenses) as 'expenses', sum(approved-expenses) as 'balancePB', statusper as 'status',manager, cid_project_balances.projnum
from cid_project_balances
left join partf_projects on cid_project_balances.projnum=partf_projects.projnum
where 1 $access
group by cid_project_balances.projnum
order by park,status desc, partf_projects.projnum asc";
$result6 =mysqli_query($connection, $query6) or die ("Couldn't execute query 6.  $query6");
if($showSQL=="1"){echo "<br><br>$query6";}

while($row6 = mysqli_fetch_array($result6)){
extract($row6);

if($balancePB>0 and $status!="FI" and $status!="CA" and $status!="TR"){$proj_bal=$balancePB;} else{$proj_bal="";}

$parkAray[]=$park;
$projnumArray[]=$projnum;
$projnameArray[]=$projname;
$project_center_year_typeArray[]=$project_center_year_type;
$approvedArray[]=$approved;
$expensesArray[]=$expenses;
$balanceArray[]=$balancePB;
$statusArray[]=$status;
$managerArray[]=$manager;

$total_approved=$total_approved+$approved;
$total_expenses=$total_expenses+$expenses;
$total_balance=$total_balance+$balance;
$total_proj_bal=$total_proj_bal+$proj_bal;

}// end while

$total_approved=number_format($total_approved,2);
$total_pm=number_format($total_pm,2);
$total_expenses=number_format($total_expenses,2);
$total_balance=number_format($total_balance,2);

if($center){

include("centerQuery.php");

//query for $row11 comes from include PHP file: centerQuery.php
$row11 = mysqli_fetch_array($result11);
 extract($row11);
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
<th>Project Balances</th><th>Available Funds</th></tr><tr>
<td>$center_desc</td><td align='center'>$funds_allocated</td><td align='center'>$payments</td><td align='center'>$balance</td><td align='center'>$total_proj_balF</td><td align='center'>$available_funds</td></tr></table>";
}

echo "<table border='1' cellpadding='3' align='center'><tr><td colspan='8' align='center'>PARTF Budget for <b><font color='red'>Center $center</font></b> using PARTF_Payments $maxDate&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type='button' value='Status Codes' onclick=\"return popitup('terminology.php')\"></td></tr><tr><th>park</th><th>projname</th><th>project_center_year_type</th><th align='right'>approved</th><th align='right'>expenses</th><th align='right'>balance</th><th>status</th><th>manager</th></tr>";

for($i=0;$i<count($project_center_year_typeArray);$i++){

$testStatus=strtoupper($statusArray[$i]);
//if(!$statusA || in_array($testStatus,$statusA)){
$a=number_format($approvedArray[$i],2);
$expense_link="<a href='prtf_center_budget.php?projnum=$projnumArray[$i]&center=$center&q=e' target='_blank'>".number_format($expensesArray[$i],2)."</a>";
$b=number_format($balanceArray[$i],2);

$status_link="<a href='park_project_balances.php?projnum=$projnumArray[$i]&status=1&cen=$center'>".$statusArray[$i]."</a>";

if($c==''){$t=" bgcolor='$table_bg2' ";$c=1;}else{$t='';$c='';}

echo "<tr$t>
<td>$parkAray[$i]</td>
<td>$projnameArray[$i]</td>
<td>$project_center_year_typeArray[$i]</td>
<td align='right'>$a</td>
<td align='right'>$expense_link</td>
<td align='right'>$b</td>
<td align='center'>$status_link</td>
<td>$managerArray[$i]</td>
</tr>";
//}
}// end if

echo "<tr>
<td colspan='4' align='right'><b>$total_approved</b></td>";
echo "<td align='right'><b>$total_expenses</b></td>

</tr></table>";

//echo "</div></body></html>";


 echo "</table></html>";

?>