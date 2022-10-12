<?php
include("~f_year.php");
if(!isset($showSQL)){$showSQL="";}
//echo "<br />concession_location=$concession_location<br />";
$sql = "CREATE temporary TABLE `budget1_unposted1` ( `center` varchar( 15 ) NOT NULL default '', `account` varchar( 15 ) NOT NULL default '', `vendor_name` varchar( 50 ) NOT NULL default '', `transaction_date` date NOT NULL default '0000-00-00', `transaction_number` varchar( 30 ) NOT NULL default '', `transaction_amount` decimal( 12, 2 ) NOT NULL default '0.00', `transaction_type` varchar( 30 ) NOT NULL default '', `source_table` varchar( 30 ) NOT NULL default '', `source_id` varchar( 10 ) NOT NULL default '0', `post2ncas` char( 1 ) NOT NULL default 'n', `system_entry_date` date NOT NULL default '0000-00-00', `id` int( 10 ) unsigned NOT NULL AUTO_INCREMENT , PRIMARY KEY ( `id` ) ) ENGINE = MyISAM ;
";//echo "$sql";
$result = mysqli_query($connection, $sql) or die ("Couldn't execute query 4. $sql");
if($showSQL==1){echo "$sql<br /><br />";}

$sql = "insert into budget1_unposted1( center, account, vendor_name, transaction_date, transaction_number, transaction_amount, transaction_type, source_table, source_id ) select ncas_center, ncas_account, vendor_name, datesql, ncas_invoice_number, ncas_invoice_amount,'cdcs','cid_vendor_invoice_payments', id from cid_vendor_invoice_payments where 1 and post2ncas != 'y' and ncas_credit != 'x' group by id;
";//echo "$sql";
$result = mysqli_query($connection, $sql) or die ("Couldn't execute query 4. $sql");
if($showSQL==1){echo "$sql<br /><br />";}

$sql = "insert into budget1_unposted1( center, account, vendor_name, transaction_date, transaction_number, transaction_amount, transaction_type, source_table, source_id ) select ncas_center, ncas_account, vendor_name, datesql, ncas_invoice_number, -ncas_invoice_amount,'cdcs','cid_vendor_invoice_payments', id from cid_vendor_invoice_payments where 1 and post2ncas != 'y' and ncas_credit = 'x' group by id;
";//echo "$sql";
$result = mysqli_query($connection, $sql) or die ("Couldn't execute query 4. $sql");
if($showSQL==1){echo "$sql<br /><br />";}

$sql = "insert into budget1_unposted1( center, account, vendor_name, transaction_date, transaction_number, transaction_amount, transaction_type, source_table, source_id ) select center, ncasnum, concat('pcard','-',cardholder,'-',vendor_name,'-',trans_date), transdate_new, transid_new, sum(amount),'pcard','pcard_unreconciled', id from pcard_unreconciled where 1 and ncas_yn != 'y' group by id;
";//echo "$sql";
$result = mysqli_query($connection, $sql) or die ("Couldn't execute query 4. $sql");
if($showSQL==1){echo "$sql<br /><br />";}

$sql = "insert into budget1_unposted1( center, account, vendor_name, transaction_date, transaction_number, transaction_amount, transaction_type, source_table, source_id ) select center, ncasnum, concat(postitle,'-',posnum,'-',tempid), datework,'na', sum(rate*hr1311),'seapay','seapay_unposted', prid from seapay_unposted where 1 group by prid;
";//echo "$sql";
$result = mysqli_query($connection, $sql) or die ("Couldn't execute query 4. $sql");
if($showSQL==1){echo "$sql<br /><br />";}

$sql = "CREATE temporary TABLE `po_encumbrance_totals1` ( `view` char( 3 ) NOT NULL default 'all', `center` varchar( 15 ) NOT NULL default '', `account` varchar( 15 ) NOT NULL default '', `xtnd_balance` decimal( 12, 2 ) NOT NULL default '0.00', `id` int( 10 ) unsigned NOT NULL AUTO_INCREMENT , PRIMARY KEY ( `id` ) ) ENGINE = MyISAM ;
";//echo "$sql";
$result = mysqli_query($connection, $sql) or die ("Couldn't execute query 4. $sql");
if($showSQL==1){echo "$sql<br /><br />";}

$sql = "insert into po_encumbrance_totals1 (center,account,xtnd_balance) select center,acct,sum(po_remaining_encumbrance) from xtnd_po_encumbrances where 1 group by center,acct;
";//echo "$sql";
$result = mysqli_query($connection, $sql) or die ("Couldn't execute query 4. $sql");
if($showSQL==1){echo "$sql<br /><br />";}

$sql = "CREATE temporary TABLE `budget1_available1` ( `center` varchar( 15 ) NOT NULL default '',`center_description` varchar( 75 ) NOT NULL default '',`center_code` varchar( 4 ) NOT NULL default '', `region` varchar( 15 ) NOT NULL default '', `district` varchar( 15 ) NOT NULL default '',`account` varchar( 15 ) NOT NULL default '', `account_description` varchar( 50 ) NOT NULL default '',`py1_amount` decimal( 12, 2 ) NOT NULL default '0.00', `allocation_amount` decimal( 12, 2 ) NOT NULL default '0.00', `cy_amount` decimal( 12, 2 ) NOT NULL default '0.00', `unposted_amount` decimal( 12, 2 ) NOT NULL default '0.00', `source` varchar( 30 ) NOT NULL default '0.00', `budget_group` varchar( 30 ) NOT NULL default '', `encumbered_funds` decimal( 12, 2 ) NOT NULL default '0.00', `id` int( 10 ) unsigned NOT NULL AUTO_INCREMENT , PRIMARY KEY ( `id` ) ) ENGINE = MyISAM ;
";//echo "$sql";
$result = mysqli_query($connection, $sql) or die ("Couldn't execute query 4. $sql");
if($showSQL==1){echo "$sql<br /><br />";}

$sql = "insert into budget1_available1( center, account, py1_amount, allocation_amount, cy_amount, unposted_amount, source ) select center, ncasnum, sum(amount_py1), '', sum(amount_cy),'','act3' from act3 where 1 group by center,ncasnum;
";//echo "$sql";
$result = mysqli_query($connection, $sql) or die ("Couldn't execute query 4. $sql");
if($showSQL==1){echo "$sql<br /><br />";}

$sql = "insert into budget1_available1(center,account,py1_amount,allocation_amount,cy_amount,unposted_amount,source) select center,ncas_acct,'',sum(allocation_amount),'','','budget_center_allocations' from budget_center_allocations where 1 and fy_req='$f_year' group by center,ncas_acct;
";//echo "$sql";
$result = mysqli_query($connection, $sql) or die ("Couldn't execute query 4. $sql");
if($showSQL==1){echo "$sql<br /><br />";}

$sql = "insert into budget1_available1(center,account,encumbered_funds,source) select center,account,sum(xtnd_balance),'po_encumbrance_totals1' from po_encumbrance_totals1 where 1 group by center,account;
";//echo "$sql";
$result = mysqli_query($connection, $sql) or die ("Couldn't execute query 4. $sql");
if($showSQL==1){echo "$sql<br /><br />";}

$sql = "insert into budget1_available1( center, account, py1_amount, allocation_amount, cy_amount, unposted_amount, source ) select center, account,'','','', sum(transaction_amount),'budget1_unposted1' from budget1_unposted1 where 1 and post2ncas != 'y' group by center,account;
";//echo "$sql";
$result = mysqli_query($connection, $sql) or die ("Couldn't execute query 4. $sql");
if($showSQL==1){echo "$sql<br /><br />";}


$sql = "update budget1_available1,coa
        set budget1_available1.budget_group=coa.budget_group,budget1_available1.account_description=coa.park_acct_desc
		where budget1_available1.account=coa.ncasnum;
";//echo "$sql";
$result = mysqli_query($connection, $sql) or die ("Couldn't execute query 4. $sql");


$sql = "update budget1_available1,center
        set budget1_available1.region=center.region,budget1_available1.center_description=center.center_desc,budget1_available1.center_code=center.parkcode
		where budget1_available1.center=center.new_center
		and budget1_available1.center like '1680%'
";//echo "$sql";
$result = mysqli_query($connection, $sql) or die ("Couldn't execute query 4. $sql");


$sql = "update budget1_available1,center
        set budget1_available1.district=center.dist
		where budget1_available1.center=center.new_center
		and budget1_available1.center like '1680%'
";//echo "$sql";
$result = mysqli_query($connection, $sql) or die ("Couldn't execute query 4. $sql");







$sql = "truncate table budget1_available1_test2 ";
$result = mysqli_query($connection, $sql) or die ("Couldn't execute query 4. $sql");

$sql = "insert into budget1_available1_test2
        select * from budget1_available1 ";
$result = mysqli_query($connection, $sql) or die ("Couldn't execute query 4. $sql");
/*
$sql = "delete from budget1_available1_test2
        where (py1_amount='0.00' and allocation_amount='0.00' and cy_amount='0.00' and unposted_amount='0.00' and encumbered_funds='0.00') ";
		
$result = mysqli_query($connection, $sql) or die ("Couldn't execute query 4. $sql");
*/

$sql = "delete from budget1_available1_test2
        where center not like '1680%' ";
		
$result = mysqli_query($connection, $sql) or die ("Couldn't execute query 4. $sql");

$sql = "truncate table budget1_available1_test3 ";
$result = mysqli_query($connection, $sql) or die ("Couldn't execute query 4. $sql");

$sql = "insert into budget1_available1_test3(center,center_code,region,budget_group,py1_amount,allocation_amount,cy_amount,unposted_amount)
        select center,center_code,region,budget_group,sum(py1_amount),sum(allocation_amount),sum(cy_amount),sum(unposted_amount)
        from budget1_available1_test2 where 1 group by center,budget_group		";

$result = mysqli_query($connection, $sql) or die ("Couldn't execute query 4. $sql");


$sql = "update budget1_available1_test3
        set budget_amount=py1_amount+allocation_amount,spent_amount=cy_amount+unposted_amount
		where 1";

$result = mysqli_query($connection, $sql) or die ("Couldn't execute query 4. $sql");

$sql = "update budget1_available1_test3
        set available_amount=budget_amount-spent_amount
		where 1";

$result = mysqli_query($connection, $sql) or die ("Couldn't execute query 4. $sql");


$sql = "update budget1_available1_test3
        set months_used=spent_amount/(budget_amount/12)
		where 1";

$result = mysqli_query($connection, $sql) or die ("Couldn't execute query 4. $sql");


$sql = "update budget1_available1_test3 as t1,center as t2
        set t1.district=t2.dist
		where t1.center=t2.new_center
		and t2.new_center like '1680%' ";

$result = mysqli_query($connection, $sql) or die ("Couldn't execute query 4. $sql");






$sql = "truncate table budget1_available1_test4 ";
$result = mysqli_query($connection, $sql) or die ("Couldn't execute query 4. $sql");

$sql = "insert into budget1_available1_test4(region,budget_group,py1_amount,allocation_amount,budget_amount,cy_amount,unposted_amount,spent_amount,available_amount)
        select region,budget_group,sum(py1_amount),sum(allocation_amount),sum(budget_amount),sum(cy_amount),sum(unposted_amount),sum(spent_amount),sum(available_amount)
        from budget1_available1_test3 where 1 group by region,budget_group		";

$result = mysqli_query($connection, $sql) or die ("Couldn't execute query 4. $sql");

$sql = "update budget1_available1_test4
        set months_used=spent_amount/(budget_amount/12)
		where 1";

$result = mysqli_query($connection, $sql) or die ("Couldn't execute query 4. $sql");











$query1="SELECT new_center from center where parkcode='$concession_location'  ";

$result1 = mysqli_query($connection, $query1) or die ("Couldn't execute query 1.  $query1");

$row1=mysqli_fetch_array($result1);
extract($row1);//brings back max (end_date) as $end_date

//Park Managers and Park Cashiers Query
if($level==1)
{
$park_access='yes';	

$sql = "select budget1_available1.budget_group, sum( py1_amount + allocation_amount) as 'cy_budget', sum( cy_amount) as 'cy_posted', sum( unposted_amount) as 'cy_unposted', sum(py1_amount+allocation_amount-cy_amount-unposted_amount) as 'available_funds',sum(py1_amount+allocation_amount)/12 as 'monthly_budget',round((sum(cy_amount+unposted_amount)/(sum(py1_amount+allocation_amount)/12)),1) as 'months_used' from budget1_available1  left join coa on budget1_available1.account=coa.ncasnum where 1 and budget1_available1.center='$new_center'
and
(
budget1_available1.budget_group='equipment' or
budget1_available1.budget_group='opex-outside_vendor_repairs' or
budget1_available1.budget_group='opex-other_services' or
budget1_available1.budget_group='opex-utilities' or
budget1_available1.budget_group='opex-supplies_purchased_by_dpr' or
budget1_available1.budget_group='payroll_temporary' or
budget1_available1.budget_group='payroll_temporary_receipt' 

)
 group by budget1_available1.budget_group order by budget1_available1.budget_group;
";



$result = mysqli_query($connection, $sql) or die ("Couldn't execute query 4. $sql");




//if($showSQL==1){echo "$sql<br /><br />";}
echo "<table align='center'><tr><td><font color='brown' size='5'>EXPENDITURE Budgets-Fiscal Year 2223</font></td></tr></table>";	
echo "<table border='1' align='center'>";
echo "<tr>
<th>budget_group</th>
<th>cy_budget</th>
<th>cy_posted</th>
<th>cy_unposted</th>
<th>available_funds</th>";
echo "<th></th><th>months_used</th>";
echo "</tr>";
while($row=mysqli_fetch_array($result)){
extract($row);
if($available_funds<0){$f1="<font color='red'>";$f2="</font>";}else{$f1="<font color='green'>";$f2="</font>";}
$cy_budget=number_format($cy_budget,2);
$cy_posted=number_format($cy_posted,2);
$cy_unposted=number_format($cy_unposted,2);
$available_funds=number_format($available_funds,2);
$monthly_budget=number_format($monthly_budget,2);
echo "<tr>";
//if($region_access != 'yes')
{
echo "<td align='right'><a href='/budget/a/current_year_budget.php?center=$centerS&budget_group_menu=$budget_group&submit=x'>$budget_group</a></td>";
}

echo "<td align='right'>$cy_budget</td>
<td align='right'>$cy_posted</td>
<td align='right'>$cy_unposted</td>
<td align='right'>$f1$available_funds$f2</td>";
echo "<td></td><td align='right'>$months_used</td>";
echo "</tr>";
}
echo "</table>";


}

if($beacnum=='60032912' or $beacnum=='60032892'){$regionS='core'; $region_access='yes'; $section='operations'; $district='east';} //core mgr and core oa  (fullwood,quinn)
if($beacnum=='60033019' or $beacnum=='60033093'){$regionS='pire'; $region_access='yes'; $section='operations'; $district='south';} //pire mgr and pire oa (greenwood,mitchener)
if($beacnum=='60032913' or $beacnum=='60032931'){$regionS='more'; $region_access='yes'; $section='operations'; $district='west';} //more mgr and more oa (mcelhone,bunn)
if($beacnum=='65030652'){$region_access='yes'; $section='operations'; $district='north';} //more mgr and more oa (mcelhone,bunn)


if($region_access=='yes')
{
	
//11/24/19	
/*
$sql = "SELECT budget_group as 'budget_group_flag',count(budget_group) as 'budget_group_flags' FROM `budget1_available1_test3` WHERE `region`='$regionS' and ( budget_group='equipment' or budget_group='opex-repairs_building' or budget_group='opex-repairs_equipment' or budget_group='opex-repairs_vehicles' or budget_group='opex-services' or budget_group='opex-supplies_admin' or budget_group='opex-supplies_facility' or budget_group='opex-supplies_safety' or budget_group='opex-supplies_vehicles' or budget_group='opex-utilities' or budget_group='payroll_temporary' or budget_group='payroll_temporary_receipt' ) and available_amount < '0.00' group by budget_group ORDER BY `budget1_available1_test3`.`budget_group` ASC";
*/


//11/24/19
//$sql = "SELECT budget_group as 'budget_group_flag',count(budget_group) as 'budget_group_flags' FROM `budget1_available1_test3` WHERE `region`='$regionS' and ( budget_group='equipment' or budget_group='opex_outside_vendor_repairs' or budget_group='opex-other_services' or budget_group='opex-utilities' or budget_group='opex-supplies_purchased_by_dpr' or budget_group='payroll_temporary' or budget_group='payroll_temporary_receipt' ) and available_amount < '0.00' group by budget_group ORDER BY `budget1_available1_test3`.`budget_group` ASC";
$sql = "SELECT budget_group as 'budget_group_flag',count(budget_group) as 'budget_group_flags' FROM `budget1_available1_test3` WHERE `district`='$district' and ( budget_group='equipment' or budget_group='opex-outside_vendor_repairs' or budget_group='opex-other_services' or budget_group='opex-utilities' or budget_group='opex-supplies_purchased_by_dpr' or budget_group='payroll_temporary' or budget_group='payroll_temporary_receipt' ) and available_amount < '0.00' group by budget_group ORDER BY `budget1_available1_test3`.`budget_group` ASC";

//echo "<br />Line 242: sql=$sql<br />";


$result = mysqli_query($connection, $sql) or die ("Couldn't execute query 4. $sql");

//$row=mysqli_fetch_array($result);
//extract($row);//brings back max (end_date) as $end_date
//echo "<br />Line 214: sql=$sql<br />";
//echo "<table align='center' border='1'>";
//echo "<tr>";
while($row=mysqli_fetch_array($result)){
extract($row);


//echo "<br />$budget_group_flag: $budget_group_flags<br />";
if($budget_group_flag=='equipment'){$equipment_flags=$budget_group_flags;}
if($budget_group_flag=='opex-outside_vendor_repairs'){$opex_outside_vendor_repairs_flags=$budget_group_flags;}
if($budget_group_flag=='opex-other_services'){$opex_other_services_flags=$budget_group_flags;}
if($budget_group_flag=='opex-utilities'){$opex_utilities_flags=$budget_group_flags;}
if($budget_group_flag=='opex-supplies_purchased_by_dpr'){$opex_supplies_purchased_by_dpr_flags=$budget_group_flags;}
if($budget_group_flag=='payroll_temporary'){$payroll_temporary_flags=$budget_group_flags;}
if($budget_group_flag=='payroll_temporary_receipt'){$payroll_temporary_receipt_flags=$budget_group_flags;}
//echo "<br />equipment_flags: $equipment_flags<br />";
//echo "<br />opex-supplies_admin_flags: $opex_supplies_admin_flags<br />";
//echo "<br />opex-supplies_vehicles_flags: $opex_supplies_vehicles_flags<br />";
}

/*
$sql = "select budget1_available1.budget_group, sum( py1_amount + allocation_amount) as 'cy_budget', sum( cy_amount) as 'cy_posted', sum( unposted_amount) as 'cy_unposted', sum(py1_amount+allocation_amount-cy_amount-unposted_amount) as 'available_funds',sum(py1_amount+allocation_amount)/12 as 'monthly_budget',round((sum(cy_amount+unposted_amount)/(sum(py1_amount+allocation_amount)/12)),1) as 'months_used' from budget1_available1  left join coa on budget1_available1.account=coa.ncasnum where 1 and budget1_available1.region='$regionS'
and
(
budget1_available1.budget_group='equipment' or
budget1_available1.budget_group='opex-outside_vendor_repairs' or
budget1_available1.budget_group='opex-other_services' or
budget1_available1.budget_group='opex-utilities' or
budget1_available1.budget_group='opex-supplies_purchased_by_dpr' or
budget1_available1.budget_group='payroll_temporary' or
budget1_available1.budget_group='payroll_temporary_receipt' )
group by budget1_available1.budget_group order by budget1_available1.budget_group;
";
*/


$sql = "select budget1_available1.budget_group, sum( py1_amount + allocation_amount) as 'cy_budget', sum( cy_amount) as 'cy_posted', sum( unposted_amount) as 'cy_unposted', sum(py1_amount+allocation_amount-cy_amount-unposted_amount) as 'available_funds',sum(py1_amount+allocation_amount)/12 as 'monthly_budget',round((sum(cy_amount+unposted_amount)/(sum(py1_amount+allocation_amount)/12)),1) as 'months_used' from budget1_available1  left join coa on budget1_available1.account=coa.ncasnum where 1 and budget1_available1.district='$district'
and
(
budget1_available1.budget_group='equipment' or
budget1_available1.budget_group='opex-outside_vendor_repairs' or
budget1_available1.budget_group='opex-other_services' or
budget1_available1.budget_group='opex-utilities' or
budget1_available1.budget_group='opex-supplies_purchased_by_dpr' or
budget1_available1.budget_group='payroll_temporary' or
budget1_available1.budget_group='payroll_temporary_receipt' )
group by budget1_available1.budget_group order by budget1_available1.budget_group;
";






















//echo "<br />Line 296: sql=$sql<br />";


$result = mysqli_query($connection, $sql) or die ("Couldn't execute query 4. $sql");	
	
echo "<table align='center'><tr><td><font color='brown' size='5'>EXPENDITURE Budgets-Fiscal Year 2223</font></td></tr></table>";	
if($showSQL==1){echo "$sql<br /><br />";}
echo "<table border='1' align='center'>";

echo "<tr>";
echo "<th>Budget<br />Group</th><th>Available<br />Balance</th><th>Months<br />Used</th><th>Parks <br />Overdrawn</th>";
echo "</tr>";
while($row=mysqli_fetch_array($result)){
extract($row);
if($available_funds<0){$f1="<font color='red'>";$f2="</font>";}else{$f1="<font color='green'>";$f2="</font>";}
$cy_budget=number_format($cy_budget,2);
$cy_posted=number_format($cy_posted,2);
$cy_unposted=number_format($cy_unposted,2);
$available_funds=number_format($available_funds,2);
$monthly_budget=number_format($monthly_budget,2);


//if($region_access == 'yes')
//{
echo "<tr>";	


//if($beacnum=='60032912' or $beacnum=='60033019' or $beacnum=='60032913') //testing for john fullwood, jay greenwood, sean mcelhone ONLY
{
echo "<td align='right'><a href='/budget/a/op_exp_transfer_dist.php?budget_group_menu=$budget_group&section=$section&dist=$district&submit=Submit'>$budget_group</a></td>";
}
/*
if($beacnum!='60032912' and $beacnum!='60033019' and $beacnum!='60032913')
{
echo "<td align='right'><a href='/budget/budget_summary_division.php?budget_group=$budget_group&region=$regionS&region_drill=y'>$budget_group</a></td>";	
}
*/

echo "<td align='center'>$f1$available_funds$f2</td>";
echo "<td align='center'>$months_used</td>";
echo "<td align='center'>";
if($budget_group=='equipment' and $equipment_flags > 0) {echo "<font color='red'>$equipment_flags</font>";}
if($budget_group=='opex-outside_vendor_repairs' and $opex_outside_vendor_repairs_flags > 0) {echo "<font color='red'>$opex_outside_vendor_repairs_flags</font>";}
if($budget_group=='opex-other_services' and $opex_other_services_flags > 0) {echo "<font color='red'>$opex_other_services_flags</font>";}
if($budget_group=='opex-utilities' and $opex_utilities_flags > 0) {echo "<font color='red'>$opex_utilities_flags</font>";}
if($budget_group=='opex-supplies_purchased_by_dpr' and $opex_supplies_purchased_by_dpr_flags > 0) {echo "<font color='red'>$opex_supplies_purchased_by_dpr_flags</font>";}
if($budget_group=='payroll_temporary' and $payroll_temporary_flags > 0) {echo "<font color='red'>$payroll_temporary_flags</font>";}
if($budget_group=='payroll_temporary_receipt' and $payroll_temporary_receipt_flags > 0) {echo "<font color='red'>$payroll_temporary_receipt_flags</font>";}
echo "</td>";
echo "</tr>";
//}


//echo "</tr>";
}
//echo "</tr>";
echo "</table>";	
	
}  


//Budget Officer (Dodd), CHOP (O'Neil)


if($beacnum=='60032781' or $beacnum=='60033018'){$regionS='pire'; $division_access='yes'; $section='operations'; $district='south';} 

if($division_access=='yes')
{

// 11/24/19	
/*	
$sql = "SELECT budget_group as 'budget_group_flag',count(budget_group) as 'budget_group_flags' FROM `budget1_available1_test4` WHERE 1 and ( budget_group='equipment' or budget_group='opex-repairs_building' or budget_group='opex-repairs_equipment' or budget_group='opex-repairs_vehicles' or budget_group='opex-services' or budget_group='opex-supplies_admin' or budget_group='opex-supplies_facility' or budget_group='opex-supplies_safety' or budget_group='opex-supplies_vehicles' or budget_group='opex-utilities' or budget_group='payroll_temporary' or budget_group='payroll_temporary_receipt' ) and available_amount < '0.00' group by budget_group ORDER BY `budget1_available1_test4`.`budget_group` ASC";
*/

//11/24/19

// determines the number of "Flags" for each Budget Group  (this is the number of regions-core,pire,more,stwd that are overdrawn/available balance <0) for each budget group). ie. if 2 regions are overdrawn in their
//.... equipment_budget this query would bring back a value of 2 for budget_group=equipment
$sql = "SELECT budget_group as 'budget_group_flag',count(budget_group) as 'budget_group_flags' FROM `budget1_available1_test4` WHERE 1 and ( budget_group='equipment' or budget_group='opex_outside_vendor_repairs' or budget_group='opex-other_services' or budget_group='opex-utilities' or budget_group='opex-supplies_purchased_by_dpr' or budget_group='payroll_temporary' or budget_group='payroll_temporary_receipt' ) and available_amount < '0.00' group by budget_group ORDER BY `budget1_available1_test4`.`budget_group` ASC";



$result = mysqli_query($connection, $sql) or die ("Couldn't execute query 4. $sql");

//$row=mysqli_fetch_array($result);
//extract($row);//brings back max (end_date) as $end_date
//echo "<br />Line 343: sql=$sql<br />";
//echo "<table align='center' border='1'>";
//echo "<tr>";
while($row=mysqli_fetch_array($result)){
extract($row);


//echo "<br />$budget_group_flag: $budget_group_flags<br />";
//11/24/19
/*
if($budget_group_flag=='equipment'){$equipment_flags=$budget_group_flags;}
if($budget_group_flag=='opex-repairs_building'){$opex_repairs_building_flags=$budget_group_flags;}
if($budget_group_flag=='opex-repairs_equipment'){$opex_repairs_equipment_flags=$budget_group_flags;}
if($budget_group_flag=='opex-repairs_vehicles'){$opex_repairs_vehicles_flags=$budget_group_flags;}
if($budget_group_flag=='opex-services'){$opex_services_flags=$budget_group_flags;}
if($budget_group_flag=='opex-supplies_admin'){$opex_supplies_admin_flags=$budget_group_flags;}
if($budget_group_flag=='opex-supplies_facility'){$opex_supplies_facility_flags=$budget_group_flags;}
if($budget_group_flag=='opex-supplies_safety'){$opex_supplies_safety_flags=$budget_group_flags;}
if($budget_group_flag=='opex-supplies_vehicles'){$opex_supplies_vehicles_flags=$budget_group_flags;}
if($budget_group_flag=='opex-utilities'){$opex_utilities_flags=$budget_group_flags;}
if($budget_group_flag=='payroll_temporary'){$payroll_temporary_flags=$budget_group_flags;}
if($budget_group_flag=='payroll_temporary_receipt'){$payroll_temporary_receipt_flags=$budget_group_flags;}
*/


//11/24/19
if($budget_group_flag=='equipment'){$equipment_flags=$budget_group_flags;}
if($budget_group_flag=='opex-outside_vendor_repairs'){$opex_outside_vendor_repairs_flags=$budget_group_flags;}
if($budget_group_flag=='opex-other_services'){$opex_other_services_flags=$budget_group_flags;}
if($budget_group_flag=='opex-utilities'){$opex_utilities_flags=$budget_group_flags;}
if($budget_group_flag=='opex-supplies_purchased_by_dpr'){$opex_supplies_purchased_by_dpr_flags=$budget_group_flags;}
if($budget_group_flag=='payroll_temporary'){$payroll_temporary_flags=$budget_group_flags;}
if($budget_group_flag=='payroll_temporary_receipt'){$payroll_temporary_receipt_flags=$budget_group_flags;}



//echo "<br />equipment_flags: $equipment_flags<br />";
//echo "<br />opex-supplies_admin_flags: $opex_supplies_admin_flags<br />";
//echo "<br />opex-supplies_vehicles_flags: $opex_supplies_vehicles_flags<br />";
}
/*
$sql = "select budget1_available1.budget_group, sum( py1_amount + allocation_amount) as 'cy_budget', sum( cy_amount) as 'cy_posted', sum( unposted_amount) as 'cy_unposted', sum(py1_amount+allocation_amount-cy_amount-unposted_amount) as 'available_funds',sum(py1_amount+allocation_amount)/12 as 'monthly_budget',round((sum(cy_amount+unposted_amount)/(sum(py1_amount+allocation_amount)/12)),1) as 'months_used' from budget1_available1  left join coa on budget1_available1.account=coa.ncasnum where 1
and
(
budget1_available1.budget_group='equipment' or
budget1_available1.budget_group='opex-repairs_building' or
budget1_available1.budget_group='opex-repairs_equipment' or
budget1_available1.budget_group='opex-repairs_vehicles' or
budget1_available1.budget_group='opex-services' or
budget1_available1.budget_group='opex-supplies_admin' or
budget1_available1.budget_group='opex-supplies_facility' or
budget1_available1.budget_group='opex-supplies_safety' or
budget1_available1.budget_group='opex-supplies_vehicles' or
budget1_available1.budget_group='opex-utilities' or
budget1_available1.budget_group='payroll_temporary' or
budget1_available1.budget_group='payroll_temporary_receipt' 
)
 group by budget1_available1.budget_group order by budget1_available1.budget_group;
";
*/
//11/24/19
/*
$sql = "SELECT budget_group,sum( py1_amount + allocation_amount) as 'cy_budget',sum(`cy_amount`) as 'cy_posted', sum(`unposted_amount`) as 'cy_unposted',
sum(py1_amount+allocation_amount-cy_amount-unposted_amount) as 'available_funds',sum(py1_amount+allocation_amount)/12 as 'monthly_budget',round((sum(cy_amount+unposted_amount)/(sum(py1_amount+allocation_amount)/12)),1) as 'months_used'
FROM `budget1_available1_test4` WHERE 1 
and
(
budget_group='equipment' or
budget_group='opex-repairs_building' or
budget_group='opex-repairs_equipment' or
budget_group='opex-repairs_vehicles' or
budget_group='opex-services' or
budget_group='opex-supplies_admin' or
budget_group='opex-supplies_facility' or
budget_group='opex-supplies_safety' or
budget_group='opex-supplies_vehicles' or
budget_group='opex-utilities' or
budget_group='payroll_temporary' or
budget_group='payroll_temporary_receipt' 
)
group by budget_group order by budget_group";
*/

//11/24/19

$sql = "SELECT budget_group,sum( py1_amount + allocation_amount) as 'cy_budget',sum(`cy_amount`) as 'cy_posted', sum(`unposted_amount`) as 'cy_unposted',
sum(py1_amount+allocation_amount-cy_amount-unposted_amount) as 'available_funds',sum(py1_amount+allocation_amount)/12 as 'monthly_budget',round((sum(cy_amount+unposted_amount)/(sum(py1_amount+allocation_amount)/12)),1) as 'months_used'
FROM `budget1_available1_test4` WHERE 1 
and
(
budget_group='equipment' or
budget_group='opex-outside_vendor_repairs' or
budget_group='opex-other_services' or
budget_group='opex-utilities' or
budget_group='opex-supplies_purchased_by_dpr' or
budget_group='payroll_temporary' or
budget_group='payroll_temporary_receipt' 
)
group by budget_group order by budget_group";











$result = mysqli_query($connection, $sql) or die ("Couldn't execute query 4. $sql");	
	
echo "<table align='center'><tr><td><font color='brown' size='5'>EXPENDITURE Budgets-Fiscal Year 2223</font></td></tr></table>";	
if($showSQL==1){echo "$sql<br /><br />";}
echo "<table border='1' align='center'>";

echo "<tr>";
echo "<th>Budget<br />Group</th><th>Available<br />Balance</th><th>Months<br />Used</th><th>Regions <br />Overdrawn</th>";
echo "</tr>";
while($row=mysqli_fetch_array($result)){
extract($row);
if($available_funds<0){$f1="<font color='red'>";$f2="</font>";}else{$f1="<font color='green'>";$f2="</font>";}
$cy_budget=number_format($cy_budget,2);
$cy_posted=number_format($cy_posted,2);
$cy_unposted=number_format($cy_unposted,2);
$available_funds=number_format($available_funds,2);
$monthly_budget=number_format($monthly_budget,2);


//if($region_access == 'yes')
//{
echo "<tr>";	


//if($beacnum=='60032912' or $beacnum=='60033019' or $beacnum=='60032913') //testing for john fullwood, jay greenwood, sean mcelhone ONLY
{
echo "<td align='right'><a href='/budget/a/op_exp_transfer_region.php?budget_group_menu=$budget_group&submit=Submit'>$budget_group</a></td>";
}






/*
if($beacnum!='60032912' and $beacnum!='60033019' and $beacnum!='60032913')
{
echo "<td align='right'><a href='/budget/budget_summary_division.php?budget_group=$budget_group&region=$regionS&region_drill=y'>$budget_group</a></td>";	
}
*/

echo "<td align='center'>$f1$available_funds$f2</td>";
echo "<td align='center'>$months_used</td>";
//11/24/19
/*
echo "<td align='center'>";
if($budget_group=='equipment' and $equipment_flags > 0) {echo "<font color='red'>$equipment_flags</font>";}
if($budget_group=='opex-repairs_building' and $opex_repairs_building_flags > 0) {echo "<font color='red'>$opex_repairs_building_flags</font>";}
if($budget_group=='opex-repairs_equipment' and $opex_repairs_equipment_flags > 0) {echo "<font color='red'>$opex_repairs_equipment_flags</font>";}
if($budget_group=='opex-repairs_vehicles' and $opex_repairs_vehicles_flags > 0) {echo "<font color='red'>$opex_repairs_vehicles_flags</font>";}
if($budget_group=='opex-services' and $opex_services_flags > 0) {echo "<font color='red'>$opex_services_flags</font>";}
if($budget_group=='opex-supplies_admin' and $opex_supplies_admin_flags > 0) {echo "<font color='red'>$opex_supplies_admin_flags</font>";}
if($budget_group=='opex-supplies_facility' and $opex_supplies_facility_flags > 0) {echo "<font color='red'>$opex_supplies_facility_flags</font>";}
if($budget_group=='opex-supplies_safety' and $opex_supplies_safety_flags > 0) {echo "<font color='red'>$opex_supplies_safety_flags</font>";}
if($budget_group=='opex-supplies_vehicles' and $opex_supplies_vehicles_flags > 0) {echo "<font color='red'>$opex_supplies_vehicles_flags</font>";}
if($budget_group=='opex-utilities' and $opex_utilities_flags > 0) {echo "<font color='red'>$opex_utilities_flags</font>";}
if($budget_group=='payroll_temporary' and $payroll_temporary_flags > 0) {echo "<font color='red'>$payroll_temporary_flags</font>";}
if($budget_group=='payroll_temporary_receipt' and $payroll_temporary_receipt_flags > 0) {echo "<font color='red'>$payroll_temporary_receipt_flags</font>";}
echo "</td>";
*/

//11/24/19
echo "<td align='center'>";
if($budget_group=='equipment' and $equipment_flags > 0) {echo "<font color='red'>$equipment_flags</font>";}
if($budget_group=='opex-outside_vendor_repairs' and $opex_outside_vendor_repairs_flags > 0) {echo "<font color='red'>$opex_outside_vendor_repairs_flags</font>";}
if($budget_group=='opex-other_services' and $opex_other_services_flags > 0) {echo "<font color='red'>$opex_other_services_flags</font>";}
if($budget_group=='opex-utilities' and $opex_utilities_flags > 0) {echo "<font color='red'>$opex_utilities_flags</font>";}
if($budget_group=='opex-supplies_purchased_by_dpr' and $opex_supplies_purchased_by_dpr_flags > 0) {echo "<font color='red'>$opex_supplies_purchased_by_dpr_flags</font>";}
if($budget_group=='payroll_temporary' and $payroll_temporary_flags > 0) {echo "<font color='red'>$payroll_temporary_flags</font>";}
if($budget_group=='payroll_temporary_receipt' and $payroll_temporary_receipt_flags > 0) {echo "<font color='red'>$payroll_temporary_receipt_flags</font>";}
echo "</td>";

echo "</tr>";
//}


//echo "</tr>";
}
//echo "</tr>";
echo "</table>";	
	
}  //CHOP and Budget Officer

//echo "<br />Line80: $sql<br />";
//$result = mysqli_query($connection, $sql) or die ("Couldn't execute query 4. $sql");

//Park Managers and Park Cashiers Budget Summary

?>