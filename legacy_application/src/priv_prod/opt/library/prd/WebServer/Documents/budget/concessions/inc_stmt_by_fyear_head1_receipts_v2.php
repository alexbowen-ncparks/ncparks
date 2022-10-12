<?php
//echo "hello tony<br />";
$filegroup='monthly';
//echo "hello";
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



$query1="select report_date
         from report_budget_history_dates
		 where 1";		 

$result1 = mysqli_query($connection,$query1) or die ("Couldn't execute query 1.  $query1");
$row1=mysqli_fetch_array($result1);
extract($row1);



if($filegroup=='monthly')

{
//echo "<td><font size=4 class=cartRow><b><A href='park_posted_deposits_monthly_v2.php' >Monthly</A></b></font></td>";

//1415 totals



if($report_type=='receipt_detail')
{
$query6="select sum(disburse_amt) as 'total_expenses',sum(receipt_amt) as 'total_receipts', ROUND( (
(
SUM( receipt_amt ) / SUM( disburse_amt ) ) *100
), 0
) AS  'receipt_percent_total'
from report_budget_history_inc_stmt_by_fyear_pfr
where 1
and f_year='$fyear'
$where_scope";

//echo "query6=$query6<br />";	 
$result6 = mysqli_query($connection,$query6) or die ("Couldn't execute query 6.  $query6");

$num6=mysqli_num_rows($result6);	

$row6=mysqli_fetch_array($result6);
extract($row6);

$total_expenses=number_format($total_expenses,2);
$total_receipts=number_format($total_receipts,2);

}


echo "<table border='5' cellspacing='5' align='center'>";
echo "<tr>";


echo "<td align='left'><a href='park_inc_stmts_by_fyear_v2.php?scope=$scope&report_type=$report_type&fyear=1718'><font  $shade_1718>1718 $fyear_1718_check</font></a><br />(**thru $report_date**)";
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


echo "</tr>";

echo "</table>";
echo "<br />";


}



?>