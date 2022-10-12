<?php
//echo "hello tony<br />";
$filegroup='monthly';
//echo "<br />filegroup=$filegroup<br />";
/*
if($fyear=='1920'){$shade_1920="class=cartRow";}
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

if($fyear=='1920'){$fyear_1920_check="<img height='25' width='25' src='/budget/infotrack/icon_photos/green_checkmark1.png' alt='picture of green check mark'></img>";}
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

*/

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
if($report_type=='all')
{
$query6="select sum(disburse_amt) as 'total_expenses',sum(receipt_amt) as 'total_receipts', ROUND( (
(
SUM( receipt_amt ) / SUM( disburse_amt ) ) *100
), 0
) AS  'receipt_percent_total'
from report_budget_history_inc_stmt_by_fyear_net
where 1
and f_year='$fyear'
$where_scope";

//////////echo "<font color='brown'>query6=$query6<br /><br />Query 6 from PHP: <br /><b>inc_stmt_by_fyear_head1_net.php (Line: 111)</b></font>";	 
$result6 = mysqli_query($connection,$query6) or die ("Couldn't execute query 6.  $query6");

$num6=mysqli_num_rows($result6);	

$row6=mysqli_fetch_array($result6);
extract($row6);

$total_expenses=number_format($total_expenses,2);
$total_receipts=number_format($total_receipts,2);

}

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