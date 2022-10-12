<?php
//echo "hello tony<br />";
$filegroup='monthly';
if($fyear=='1819'){$shade_1819="class=cartRow";}
if($fyear=='1718'){$shade_1718="class=cartRow";}
if($fyear=='1617'){$shade_1617="class=cartRow";}

if($fyear=='1516'){$shade_1516="class=cartRow";}

if($fyear=='1415'){$shade_1415="class=cartRow";}

if($fyear=='1314'){$shade_1314="class=cartRow";}

if($fyear=='1213'){$shade_1213="class=cartRow";}

if($fyear=='1112'){$shade_1112="class=cartRow";}

if($fyear=='1011'){$shade_1011="class=cartRow";}
if($fyear=='0910'){$shade_0910="class=cartRow";}
if($fyear=='0809'){$shade_0809="class=cartRow";}
if($fyear=='0708'){$shade_0708="class=cartRow";}
if($fyear=='0607'){$shade_0607="class=cartRow";}
if($fyear=='0506'){$shade_0506="class=cartRow";}
if($fyear=='0405'){$shade_0405="class=cartRow";}

if($fyear=='1819'){$fyear_1819_check="<img height='25' width='25' src='/budget/infotrack/icon_photos/green_checkmark1.png' alt='picture of green check mark'></img>";}
if($fyear=='1718'){$fyear_1718_check="<img height='25' width='25' src='/budget/infotrack/icon_photos/green_checkmark1.png' alt='picture of green check mark'></img>";}
if($fyear=='1617'){$fyear_1617_check="<img height='25' width='25' src='/budget/infotrack/icon_photos/green_checkmark1.png' alt='picture of green check mark'></img>";}
if($fyear=='1516'){$fyear_1516_check="<img height='25' width='25' src='/budget/infotrack/icon_photos/green_checkmark1.png' alt='picture of green check mark'></img>";}
if($fyear=='1415'){$fyear_1415_check="<img height='25' width='25' src='/budget/infotrack/icon_photos/green_checkmark1.png' alt='picture of green check mark'></img>";}
if($fyear=='1314'){$fyear_1314_check="<img height='25' width='25' src='/budget/infotrack/icon_photos/green_checkmark1.png' alt='picture of green check mark'></img>";}
if($fyear=='1213'){$fyear_1213_check="<img height='25' width='25' src='/budget/infotrack/icon_photos/green_checkmark1.png' alt='picture of green check mark'></img>";}
if($fyear=='1112'){$fyear_1112_check="<img height='25' width='25' src='/budget/infotrack/icon_photos/green_checkmark1.png' alt='picture of green check mark'></img>";}
if($fyear=='1011'){$fyear_1011_check="<img height='25' width='25' src='/budget/infotrack/icon_photos/green_checkmark1.png' alt='picture of green check mark'></img>";}
if($fyear=='0910'){$fyear_0910_check="<img height='25' width='25' src='/budget/infotrack/icon_photos/green_checkmark1.png' alt='picture of green check mark'></img>";}










echo "<br />";
/*
echo "<style>

td {
    text-align: left;
}
</style>";

*/


$query1="select report_date
         from report_budget_history_dates
		 where 1";		 

$result1 = mysqli_query($connection, $query1) or die ("Couldn't execute query 1.  $query1");
$row1=mysqli_fetch_array($result1);
extract($row1);
echo "<br />Line 65: report_date=$report_date<br />";
$report_date2=str_replace('-','',$report_date);
echo "<br />Line 67: report_date2=$report_date2<br />";
//echo "<table border='5' cellspacing='5'>";
//echo "<tr>";

//echo "<tr>";
//echo "<td><font size='4'  class=cartRow><b>CRJ-Park Posted</a></b></font></td>";

//echo "tempID=$tempID";

//cho "<td><font size='4'  class=cartRow><b>CRJ-Park Posted</a></b></font></td>";

//echo "<td><font size='4'  class=cartRow><b><A href='park_posted_deposits.php' >CRJ-Park Posted</a></b></font></td>";


/*

if($filegroup=='yearly')

{echo "<td><font size=4 class=cartRow><b><A href='park_posted_deposits_v2.php' >Yearly</A></b></font></td>";}



if($filegroup!='yearly') 

{echo "<td><font size=4 ><b><A href='park_posted_deposits_v2.php' >Yearly</A></b></font></td>";}
*/
if($filegroup=='monthly')

{
//echo "<td><font size=4 class=cartRow><b><A href='park_posted_deposits_monthly_v2.php' >Monthly</A></b></font></td>";

//1415 totals
/*
if($report_type=='all')
{
$query6="select sum(disburse_amt) as 'total_expenses',sum(receipt_amt) as 'total_receipts', ROUND( (
(
SUM( receipt_amt ) / SUM( disburse_amt ) ) *100
), 0
) AS  'receipt_percent_total'
from report_budget_history_inc_stmt_by_fyear
where 1
and f_year='$fyear'
$where_scope";

echo "query6=$query6<br /><br /><font color='brown'>Query 6 from PHP: <br /><b>inc_stmt_by_fyear_head1_v2.php (Line: 111)</b></font>";

$result6 = mysqli_query($connection, $query6) or die ("Couldn't execute query 6.  $query6");

$num6=mysqli_num_rows($result6);	

$row6=mysqli_fetch_array($result6);
extract($row6);

$total_expenses=number_format($total_expenses,2);
$total_receipts=number_format($total_receipts,2);

}
*/

if($report_type=='pfr')
{
if($beacnum=='60032912'){$district_where=" and district='east' ";}	
	
$query6="select sum(disburse_amt) as 'total_expenses',sum(receipt_amt) as 'total_receipts',sum(disburse_target) as 'disburse_total',sum(receipt_target) as 'receipt_total',ROUND( (
(
SUM( receipt_amt ) / SUM( disburse_amt ) ) *100
), 0
) AS  'receipt_percent_total'
from report_budget_history_inc_stmt_by_fyear_pfr
where 1
and f_year='$fyear'
$where_scope
$district_where";

//echo "<font color='brown'>query6=$query6<br /><br />Query 6 from PHP: <br /><b>inc_stmt_by_fyear_head1_v2.php (Line: 139)</b></font>";
$result6 = mysqli_query($connection, $query6) or die ("Couldn't execute query 6.  $query6");

$num6=mysqli_num_rows($result6);	

$row6=mysqli_fetch_array($result6);
extract($row6);

$receipt_to_expenditures_total_actual=$total_receipts/$total_expenses;
$receipt_to_expenditures_total_actual=number_format($receipt_to_expenditures_total_actual,2);


$receipt_to_expenditures_total_target=$receipt_total/$disburse_total;
$receipt_to_expenditures_total_target=number_format($receipt_to_expenditures_total_target,2);


$disburse_total2=number_format($disburse_total/2,2);
$receipt_total2=number_format($receipt_total/2,2);
$profit_target_total=($receipt_total-$disburse_total)/2;
$profit_target_total2=number_format($profit_target_total,2);

$total_expenses2=number_format($total_expenses,2);
$total_receipts2=number_format($total_receipts,2);
$profit_actual_total=($total_receipts-$total_expenses);
$profit_actual_total2=number_format($profit_actual_total,2);

$profit_remaining_total=$profit_target_total-$profit_actual_total;
$profit_remaining_total2=number_format($profit_remaining_total,2);

}



echo "<table border='5' cellspacing='5' align='center'>";
echo "<tr>";


echo "<td align='left'><a href='park_inc_stmts_by_fyear_v2.php?scope=$scope&report_type=$report_type&fyear=1819'><font  $shade_1819>1819 $fyear_1819_check</font></a><br />(**thru $report_date**)";
echo "</td>";

echo "<td align='left'><a href='park_inc_stmts_by_fyear_v2.php?scope=$scope&report_type=$report_type&fyear=1718'><font  $shade_1718>1718 $fyear_1718_check</font></a>";
echo "</td>";

echo "<td align='left'><a href='park_inc_stmts_by_fyear_v2.php?scope=$scope&report_type=$report_type&fyear=1617'><font  $shade_1617>1617 $fyear_1617_check</font></a>";
echo "</td>";

echo "<td align='left'><a href='park_inc_stmts_by_fyear_v2.php?scope=$scope&report_type=$report_type&fyear=1516'><font  $shade_1516>1516 $fyear_1516_check</font></a>";
echo "</td>";


echo "<td align='left'><a href='park_inc_stmts_by_fyear_v2.php?scope=$scope&report_type=$report_type&fyear=1415'><font  $shade_1415>1415 $fyear_1415_check</font></a>";
echo "</td>";


echo "<td align='left'><a href='park_inc_stmts_by_fyear_v2.php?scope=$scope&report_type=$report_type&fyear=1314'><font  $shade_1314>1314 $fyear_1314_check</font></a>";
echo "</td>";


echo "<td align='left'><a href='park_inc_stmts_by_fyear_v2.php?scope=$scope&report_type=$report_type&fyear=1213'><font  $shade_1213>1213 $fyear_1213_check</font></a>";
echo "</td>";


echo "<td align='left'><a href='park_inc_stmts_by_fyear_v2.php?scope=$scope&report_type=$report_type&fyear=1112'><font  $shade_1112 >1112 $fyear_1112_check</font></a>";
echo "</td>";


echo "<td align='left'><a href='park_inc_stmts_by_fyear_v2.php?scope=$scope&report_type=$report_type&fyear=1011'><font  $shade_1011>1011 $fyear_1011_check</font></a>";
echo "</td>";



echo "<td align='left'><a href='park_inc_stmts_by_fyear_v2.php?scope=$scope&report_type=$report_type&fyear=0910'><font  $shade_0910>0910 $fyear_0910_check</font></a>";
echo "</td>";





//}



if($filegroup!='monthly') 

{echo "<td><font size=4 ><b><A href='park_posted_deposits_monthly_v2.php' >Monthly</A></b></font></td>";}
/*




if($filegroup=='customize')

{echo "<td><font size=4 class=cartRow><b><A href='home_page_custom.php' >Customize</A></b></font></td>";}



if($filegroup!='customize') 

{echo "<td><font size=4 ><b><A href='home_page_custom.php' >Customize</A></b></font></td>";}

*/

echo "</tr>";

echo "</table>";
echo "<br />";


}



?>