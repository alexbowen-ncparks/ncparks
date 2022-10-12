<?php


echo "<br />";


//$report_date represents most recent NCAS date in MoneyCounts.  A value of 20191125 indicates that the last "posted transaction date" in TABLE=exp_rev is 20191125  (bass 12/9/19)
$query1="select report_date from report_budget_history_dates where 1";
$result1 = mysqli_query($connection,$query1) or die ("Couldn't execute query 1.  $query1");
$row1=mysqli_fetch_array($result1);
extract($row1);

//brings back current "active" Fiscal Year as 'report_year'
$query0="select report_year from fiscal_year where active_year='y' ";
$result0 = mysqli_query($connection,$query0) or die ("Couldn't execute query 0.  $query0");
$row0=mysqli_fetch_array($result0);
extract($row0);


//inside brackets below is needed to determine percentage of fiscal year that has passed  (Report Date-Fiscal year start date as days elapsed)/(365)    November 25 2019 calc would be:  148/365=41% of fiscal year has passed 
// bass 12/9/19
{

//echo "<br />Line 65: report_date=$report_date<br />";
$report_date2=str_replace('-','',$report_date);
//echo "<br />Line 67: report_date2=$report_date2<br />";



$query1a="select start_date,end_date
         from fiscal_year
		 where active_year='y'";	

		 
//echo "<br /><font color=red>query1a=$query1a</font><br />";
$result1a = mysqli_query($connection,$query1a) or die ("Couldn't execute query 1a.  $query1a");
$row1a=mysqli_fetch_array($result1a);
extract($row1a);

//echo "<br />Line 83: start_date=$start_date<br />end_date=$end_date";
$start_date2=str_replace('-','',$start_date);
$end_date2=str_replace('-','',$end_date);
//echo "<br />Line 86: start_date2=$start_date2<br />end_date2=$end_date2";

$start_date_unix=strtotime($start_date2);
//echo "<br />Line 89: start_date_unix=$start_date_unix<br />";

$end_date_unix=strtotime($end_date2);
//echo "<br />Line 92: end_date_unix=$end_date_unix<br />";


$report_date_unix=strtotime($report_date2);
//echo "<br />Line 96: report_date_unix=$report_date_unix<br />";

$datediff = 1+(($report_date_unix - $start_date_unix)/(60 * 60 * 24));
//echo "<br />Line 99: datediff=$datediff<br />";

$fiscal_year_perc_complete=round($datediff/365*100);
//echo "<br />Line 102: fiscal_year_perc_complete=$fiscal_year_perc_complete<br />";

$fiscal_year_perc_complete2=$fiscal_year_perc_complete."% of year elapsed";
//echo "<br />Line 107: fiscal_year_perc_complete2=$fiscal_year_perc_complete2<br />";

}





///// 12/9/19   if($filegroup=='monthly')

{
//echo "<td><font size=4 class=cartRow><b><A href='park_posted_deposits_monthly_v2.php' >Monthly</A></b></font></td>";



if($report_type=='pfr')
{
if($beacnum=='60032912'){$district_where=" and district='east' ";}	
// Totals at bottom of Report  Bass 12/9/19	
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
$result6 = mysqli_query($connection,$query6) or die ("Couldn't execute query 6.  $query6");

$num6=mysqli_num_rows($result6);	

$row6=mysqli_fetch_array($result6);
extract($row6);

$receipt_to_expenditures_total_actual=$total_receipts/$total_expenses;
$receipt_to_expenditures_total_actual=number_format($receipt_to_expenditures_total_actual,2);


$receipt_to_expenditures_total_target=$receipt_total/$disburse_total;
$receipt_to_expenditures_total_target=number_format($receipt_to_expenditures_total_target,2);


//$disburse_total2=number_format($disburse_total/2,2);
$disburse_total2=number_format($disburse_total,2);
//$disburse_total2=number_format($disburse_total/2,2);
$disburse_total2=number_format($disburse_total,2);
//$receipt_total2=number_format($receipt_total/2,2);
$receipt_total2=number_format($receipt_total,2);
//$profit_target_total=($receipt_total-$disburse_total)/2;
$profit_target_total=($receipt_total-$disburse_total);
$profit_target_total2=number_format($profit_target_total,2);

$total_expenses2=number_format($total_expenses,2);
$total_receipts2=number_format($total_receipts,2);
$profit_actual_total=($total_receipts-$total_expenses);
$profit_actual_total2=number_format($profit_actual_total,2);

$profit_remaining_total=$profit_target_total-$profit_actual_total;
$profit_remaining_total2=number_format($profit_remaining_total,2);

$profit_progress_total_percent=$profit_actual_total/$profit_target_total;
$profit_progress_total_percent2=number_format($profit_progress_total_percent*100,0);
$profit_progress_total_percent3=$profit_progress_total_percent2.'%';

}
//Replace static Fiscal year Menu Bar with "dynamically produced menu".  This will automatically change in the NEW Fiscal year when MoneyCounts Administrator changes the "active_year" in TABLE=fiscal_year (bass 12/9/19)
$query5b="select cy,py1,py2,py3,py4,py5,py6,py7,py8,py9,py10 from fiscal_year where active_year='y' ";
//echo "<br />query5b=$query5b<br />";

$result5b = mysqli_query($connection,$query5b) or die ("Couldn't execute query 5b.  $query5b");
$num5b=mysqli_num_rows($result5b);

echo "<table border='5' cellspacing='5' align='center'>";
while ($row5b=mysqli_fetch_array($result5b)){
echo "<tr>";

$checkmark_image="<img height='25' width='25' src='/budget/infotrack/icon_photos/green_checkmark1.png' alt='picture of green check mark'></img>";

extract($row5b);

if($cy==$fyear){$cy_td="<td><a href='park_inc_stmts_by_fyear_v2.php?scope=$scope&report_type=$report_type&fyear=$cy'><font class=cartRow>$cy $checkmark_image</font></a><br />(**thru $report_date**)<br />$fiscal_year_perc_complete2</td>";}
if($cy!=$fyear){$cy_td="<td><a href='park_inc_stmts_by_fyear_v2.php?scope=$scope&report_type=$report_type&fyear=$cy'>$cy</a><br />(**thru $report_date**)<br />$fiscal_year_perc_complete2</td>";}

if($py1==$fyear){$py1_td="<td><a href='park_inc_stmts_by_fyear_v2.php?scope=$scope&report_type=$report_type&fyear=$py1'><font class=cartRow>$py1 $checkmark_image</font></a></td>";}
//if($py1==$fyear){$py1_td="<td><a href='park_inc_stmts_by_fyear_v2.php?scope=$scope&report_type=$report_type&fyear=$py1'>$py1</a></td>";}
if($py1!=$fyear){$py1_td="<td><a href='park_inc_stmts_by_fyear_v2.php?scope=$scope&report_type=$report_type&fyear=$py1'>$py1</a></td>";}

if($py2==$fyear){$py2_td="<td><a href='park_inc_stmts_by_fyear_v2.php?scope=$scope&report_type=$report_type&fyear=$py2'><font class=cartRow>$py2 $checkmark_image</font></a></td>";}
//if($py1==$fyear){$py1_td="<td><a href='park_inc_stmts_by_fyear_v2.php?scope=$scope&report_type=$report_type&fyear=$py1'>$py1</a></td>";}
if($py2!=$fyear){$py2_td="<td><a href='park_inc_stmts_by_fyear_v2.php?scope=$scope&report_type=$report_type&fyear=$py2'>$py2</a></td>";}

if($py3==$fyear){$py3_td="<td><a href='park_inc_stmts_by_fyear_v2.php?scope=$scope&report_type=$report_type&fyear=$py3'><font class=cartRow>$py3 $checkmark_image</font></a></td>";}
//if($py1==$fyear){$py1_td="<td><a href='park_inc_stmts_by_fyear_v2.php?scope=$scope&report_type=$report_type&fyear=$py1'>$py1</a></td>";}
if($py3!=$fyear){$py3_td="<td><a href='park_inc_stmts_by_fyear_v2.php?scope=$scope&report_type=$report_type&fyear=$py3'>$py3</a></td>";}

if($py4==$fyear){$py4_td="<td><a href='park_inc_stmts_by_fyear_v2.php?scope=$scope&report_type=$report_type&fyear=$py4'><font class=cartRow>$py4 $checkmark_image</font></a></td>";}
//if($py1==$fyear){$py1_td="<td><a href='park_inc_stmts_by_fyear_v2.php?scope=$scope&report_type=$report_type&fyear=$py1'>$py1</a></td>";}
if($py4!=$fyear){$py4_td="<td><a href='park_inc_stmts_by_fyear_v2.php?scope=$scope&report_type=$report_type&fyear=$py4'>$py4</a></td>";}

if($py5==$fyear){$py5_td="<td><a href='park_inc_stmts_by_fyear_v2.php?scope=$scope&report_type=$report_type&fyear=$py5'><font class=cartRow>$py5 $checkmark_image</font></a></td>";}
//if($py1==$fyear){$py1_td="<td><a href='park_inc_stmts_by_fyear_v2.php?scope=$scope&report_type=$report_type&fyear=$py1'>$py1</a></td>";}
if($py5!=$fyear){$py5_td="<td><a href='park_inc_stmts_by_fyear_v2.php?scope=$scope&report_type=$report_type&fyear=$py5'>$py5</a></td>";}

if($py6==$fyear){$py6_td="<td><a href='park_inc_stmts_by_fyear_v2.php?scope=$scope&report_type=$report_type&fyear=$py6'><font class=cartRow>$py6 $checkmark_image</font></a></td>";}
//if($py1==$fyear){$py1_td="<td><a href='park_inc_stmts_by_fyear_v2.php?scope=$scope&report_type=$report_type&fyear=$py1'>$py1</a></td>";}
if($py6!=$fyear){$py6_td="<td><a href='park_inc_stmts_by_fyear_v2.php?scope=$scope&report_type=$report_type&fyear=$py6'>$py6</a></td>";}

if($py7==$fyear){$py7_td="<td><a href='park_inc_stmts_by_fyear_v2.php?scope=$scope&report_type=$report_type&fyear=$py7'><font class=cartRow>$py7 $checkmark_image</font></a></td>";}
//if($py1==$fyear){$py1_td="<td><a href='park_inc_stmts_by_fyear_v2.php?scope=$scope&report_type=$report_type&fyear=$py1'>$py1</a></td>";}
if($py7!=$fyear){$py7_td="<td><a href='park_inc_stmts_by_fyear_v2.php?scope=$scope&report_type=$report_type&fyear=$py7'>$py7</a></td>";}

if($py8==$fyear){$py8_td="<td><a href='park_inc_stmts_by_fyear_v2.php?scope=$scope&report_type=$report_type&fyear=$py8'><font class=cartRow>$py8 $checkmark_image</font></a></td>";}
//if($py1==$fyear){$py1_td="<td><a href='park_inc_stmts_by_fyear_v2.php?scope=$scope&report_type=$report_type&fyear=$py1'>$py1</a></td>";}
if($py8!=$fyear){$py8_td="<td><a href='park_inc_stmts_by_fyear_v2.php?scope=$scope&report_type=$report_type&fyear=$py8'>$py8</a></td>";}


if($py9==$fyear){$py9_td="<td><a href='park_inc_stmts_by_fyear_v2.php?scope=$scope&report_type=$report_type&fyear=$py9'><font class=cartRow>$py9 $checkmark_image</font></a></td>";}
//if($py1==$fyear){$py1_td="<td><a href='park_inc_stmts_by_fyear_v2.php?scope=$scope&report_type=$report_type&fyear=$py1'>$py1</a></td>";}
if($py9!=$fyear){$py9_td="<td><a href='park_inc_stmts_by_fyear_v2.php?scope=$scope&report_type=$report_type&fyear=$py9'>$py9</a></td>";}


if($py10==$fyear){$py10_td="<td><a href='park_inc_stmts_by_fyear_v2.php?scope=$scope&report_type=$report_type&fyear=$py10'><font class=cartRow>$py10 $checkmark_image</font></a></td>";}
//if($py1==$fyear){$py1_td="<td><a href='park_inc_stmts_by_fyear_v2.php?scope=$scope&report_type=$report_type&fyear=$py1'>$py1</a></td>";}
if($py10!=$fyear){$py10_td="<td><a href='park_inc_stmts_by_fyear_v2.php?scope=$scope&report_type=$report_type&fyear=$py10'>$py10</a></td>";}






echo "$cy_td";
echo "$py1_td";
echo "$py2_td";
echo "$py3_td";
echo "$py4_td";
echo "$py5_td";
echo "$py6_td";
echo "$py7_td";
echo "$py8_td";
echo "$py9_td";
echo "$py10_td";


echo "</tr>";

}
echo "</table>";




}



?>