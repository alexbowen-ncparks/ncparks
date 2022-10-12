<?php

if(empty($_SESSION)){session_start();}
if (!$_SESSION["budget"]["tempID"]) {echo "Access denied";exit;}
//echo "<pre>";print_r($_SESSION);echo "</pre>";exit;
$active_file=$_SERVER['SCRIPT_NAME'];

$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempid=$_SESSION['budget']['tempID'];
$beacnum=$_SESSION['budget']['beacon_num'];
$concession_location=$_SESSION['budget']['select'];
$concession_center=$_SESSION['budget']['centerSess'];
$concession_center_new=$_SESSION['budget']['centerSess_new'];
$tempid1=substr($tempid,0,-2);


$database="budget";
$db="budget";
if(empty($connection))
	{
	include("/opt/library/prd/WebServer/include/iConnect.inc");
	}
// connection parameters
mysqli_select_db($connection, $database); // database
include("../../include/activity.php");


//extract($_REQUEST);



//include("~f_year.php");


$query11="SELECT filegroup
from concessions_filegroup
WHERE 1 and filename='$active_file'
";

//echo "query11=$query11<br />";
$result11=mysqli_query($connection, $query11) or die ("Couldn't execute query 11. $query11");

$row11=mysqli_fetch_array($result11);

extract($row11);
include ("menu1415_v1.php");
include_once("menus3_js_tony.php");
include ("budget_summary_division_header1.php");

if($region=='core'){$region_where=" and region='core' ";}
if($region=='pire'){$region_where=" and region='pire' ";}
if($region=='more'){$region_where=" and region='more' ";}
if($region=='stwd'){$region_where=" and region='stwd' ";}
if($region=='all'){$region_where=" and (region='core' or region='pire' or region='more' or region='stwd') "; $regionS='all';}




if($region_drill=='')
{
$sql = "select budget_group,region, sum( py1_amount + allocation_amount) as 'cy_budget', sum( cy_amount) as 'cy_posted', sum( unposted_amount) as 'cy_unposted',sum(cy_amount+unposted_amount) as 'spent', sum(py1_amount+allocation_amount-cy_amount-unposted_amount) as 'available_funds',sum(py1_amount+allocation_amount)/12 as 'monthly_budget',round((sum(cy_amount+unposted_amount)/(sum(py1_amount+allocation_amount)/12)),1) as 'months_used' from budget1_available1_test2 where 1 
and
(
budget_group='equipment' or
budget_group='opex-services' or
budget_group='opex-supplies_admin' or
budget_group='opex-supplies_facility' or
budget_group='opex-supplies_safety' or
budget_group='opex-supplies_vehicles' or
budget_group='opex-utilities' or
budget_group='payroll_temporary' 
)
$region_where
 group by budget_group,region order by budget_group,region;
";

$result = mysqli_query($connection, $sql) or die ("Couldn't execute query 4. $sql");

echo "<br />Line 70 sql=$sql<br />";

$division_access='yes';








//echo "<br />Line80: $sql<br />";
//$result = mysqli_query($connection, $sql) or die ("Couldn't execute query 4. $sql");
if($showSQL==1){echo "$sql<br /><br />";}





echo "<table border='1' align='center'>";
echo "<tr>";
echo "<th>budget_group</th>";
if($regionS=='all')
{
echo "<th>region</th>";
}
//echo "<th>region</th>";
echo "<th>budget</th>";
//echo "<th>cy_posted</th>";
//echo "<th>cy_unposted</th>";
echo "<th>spent</th>";
echo "<th>available</th>";
//echo "<th>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th><th>monthly_budget</th><th>months_used</th>";
//echo "<th>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th><th>monthly_budget</th><th>months_used</th>";
//echo "<th></th>";
echo "<th>months_used</th>";
echo "</tr>";
while($row=mysqli_fetch_array($result)){
extract($row);
if($available_funds<0){$f1="<font color='red'>";$f2="</font>";}else{$f1="<font color='green'>";$f2="</font>";}
$cy_budget=number_format($cy_budget,2);
$cy_posted=number_format($cy_posted,2);
$cy_unposted=number_format($cy_unposted,2);
$available_funds=number_format($available_funds,2);
$monthly_budget=number_format($monthly_budget,2);
$spent=number_format($spent,2);
$region=strtolower($region);


echo "<tr>";
/*
if($region_access != 'yes')
{
echo "<td align='right'><a href='/budget/a/current_year_budget.php?center=$centerS&budget_group_menu=$budget_group&submit=x'>$budget_group</a></td>";
}
*/
//if($region_access == 'yes')
{
echo "<td align='right'><a href='budget_summary_division.php?budget_group=$budget_group&region=$region&region_drill=y'>$budget_group</a></td>";
}
if($regionS=='all')
{
echo "<td>$region</td>";
}

echo "<td align='right'>$cy_budget</td>";
echo "<td align='right'>$spent</td>";
//echo "<td align='right'>$cy_posted</td>";
//echo "<td align='right'>$cy_unposted</td>";
echo "<td align='right'>$f1$available_funds$f2</td>";
//echo "<td></td><td align='right'>$monthly_budget</td><td align='right'>$months_used</td>";
//echo "<td></td>";
echo "<td align='right'>$months_used</td>";
echo "</tr>";
}
echo "</table>";
}
if($region_drill=='y')
{




//totals
$sql = "select sum( py1_amount + allocation_amount) as 'cy_budget_total', sum( cy_amount) as 'cy_posted_total', sum( unposted_amount) as 'cy_unposted_total',sum(cy_amount+unposted_amount) as 'spent_total', sum(py1_amount+allocation_amount-cy_amount-unposted_amount) as 'available_funds_total',sum(py1_amount+allocation_amount)/12 as 'monthly_budget',round((sum(cy_amount+unposted_amount)/(sum(py1_amount+allocation_amount+.0001)/12)),1) as 'months_used_total' from budget1_available1_test2 where 1 
and budget_group='$budget_group' and region='$region'
 ";

$result = mysqli_query($connection, $sql) or die ("Couldn't execute query 4. $sql");

$row=mysqli_fetch_array($result);

extract($row);
if($available_funds_total<0){$f1_total="<font color='red'>";$f2_total="</font>";}else{$f1_total="<font color='green'>";$f2_total="</font>";}

$cy_budget_total=number_format($cy_budget_total,2);
$cy_posted_total=number_format($cy_posted_total,2);
$cy_unposted_total=number_format($cy_unposted_total,2);
$spent_total=number_format($spent_total,2);
$available_funds_total=number_format($available_funds_total,2);
$months_used_total=number_format($months_used_total,1);



//echo "<br /><br />cy_budget_total=$cy_budget_total<br />cy_posted_total=$cy_posted_total<br />cy_unposted_total=$cy_unposted_total<br />spent_total=$spent_total<br />available_funds_total=$available_funds_total<br />months_used_total=$months_used_total<br /><br />";


$sql = "select budget_group,region,center,center_code,sum( py1_amount + allocation_amount) as 'cy_budget', sum( cy_amount) as 'cy_posted', sum( unposted_amount) as 'cy_unposted',sum(cy_amount+unposted_amount) as 'spent', sum(py1_amount+allocation_amount-cy_amount-unposted_amount) as 'available_funds',sum(py1_amount+allocation_amount)/12 as 'monthly_budget',round((sum(cy_amount+unposted_amount)/(sum(py1_amount+allocation_amount+.0001)/12)),1) as 'months_used' from budget1_available1_test2 where 1 
and budget_group='$budget_group' and region='$region'
 group by budget_group,region,center_code order by budget_group,region,center_code; ";

$result = mysqli_query($connection, $sql) or die ("Couldn't execute query 4. $sql");


$num_rows=mysqli_num_rows($result);


echo "num_rows=$num_rows";












//echo "<br />Line 70 sql=$sql<br />";

$division_access='yes';








//echo "<br />Line80: $sql<br />";
//$result = mysqli_query($connection, $sql) or die ("Couldn't execute query 4. $sql");
if($showSQL==1){echo "$sql<br /><br />";}





echo "<table border='1' align='center'>";
echo "<tr>

<th>park</th>
<th>center</th>
<th>budget</th>
<th>spent</th>";
//echo "<th>cy_posted</th>";
//echo "<th>cy_unposted</th>";
echo "<th>available</th>";
//echo "<th>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th><th>monthly_budget</th><th>months_used</th>";
//echo "<th>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th><th>monthly_budget</th><th>months_used</th>";
//echo "<th></th>";
echo "<th>months_used</th>";
//echo "<th>transfer_amount: <input name='sum' id='sum' type=text size='9' readonly></th>";
echo "</tr>";
while($row=mysqli_fetch_array($result)){
extract($row);
if($available_funds<0){$f1="<font color='red'>";$f2="</font>";}else{$f1="<font color='green'>";$f2="</font>";}
if($cy_budget==0){$months_used='';}
$cy_budget=number_format($cy_budget,2);
$cy_posted=number_format($cy_posted,2);
$cy_unposted=number_format($cy_unposted,2);
$available_funds=number_format($available_funds,2);
$monthly_budget=number_format($monthly_budget,2);
$spent=number_format($spent,2);
$region=strtolower($region);

echo "<form action='budget_summary_division_transfer.php' method='POST'>";
echo "<tr>";
/*
if($region_access != 'yes')
{
echo "<td align='right'><a href='/budget/a/current_year_budget.php?center=$centerS&budget_group_menu=$budget_group&submit=x'>$budget_group</a></td>";
}
*/
//if($region_access == 'yes')

echo "<td><a href='a/current_year_budget.php?budget_group_menu=$budget_group&center=$center&submit=Submit' target='_blank'>$center_code</td>";
echo "<td><input type='hidden' name='center_request[]' value='$center'>$center</td>";

echo "<td align='right'>$cy_budget</td>";
echo "<td align='right'>$spent</td>";
//echo "<td align='right'>$cy_posted</td>";
//echo "<td align='right'>$cy_unposted</td>";
echo "<td align='right'>$f1$available_funds$f2</td>";
//echo "<td></td><td align='right'>$monthly_budget</td><td align='right'>$months_used</td>";
//echo "<td></td>";
//echo "<td align='right'>$months_used</td><td align='center'><input type='text' name='transfer_request[ ]' value='$transfer_amount' size='10' onchange=add()></td>";
echo "<td align='right'>$months_used</td><td align='center'><input type='text' name='transfer_request[]'></td>";
echo "</tr>";
}
echo "<tr><td></td><td>Total</td><td>$cy_budget_total</td><td>$spent_total</td>";
echo "<td>$f1_total$available_funds_total$f2_total</td>";
echo "<td>$months_used_total</td><td><input type='submit' name='submit' value='Update'></td></tr>";
echo "<input type='hidden' name='num_rows' value='$num_rows'>";
echo "<input type='hidden' name='budget_group' value='$budget_group'>";
echo "<input type='hidden' name='fiscal_year' value='1819'>";
echo "</form>";
echo "</table>";
}




?>