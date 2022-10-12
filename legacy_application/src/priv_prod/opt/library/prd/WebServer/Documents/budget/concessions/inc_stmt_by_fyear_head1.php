<?php

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

$query6="select sum(disburse_amt) as 'total_exp_1415',sum(receipt_amt) as 'total_rec_1415', ROUND( (
(
SUM( receipt_amt ) / SUM( disburse_amt ) ) *100
), 0
) AS  'receipt_percent_total_1415'
from report_budget_history_inc_stmt_by_fyear
where 1
and f_year='1415'
$where_scope";

		 
$result6 = mysqli_query($connection, $query6) or die ("Couldn't execute query 6.  $query6");

$num6=mysqli_num_rows($result6);	

$row6=mysqli_fetch_array($result6);
extract($row6);

$total_exp_1415=number_format($total_exp_1415,2);
$total_rec_1415=number_format($total_rec_1415,2);

//1314 totals
$query6a="select sum(disburse_amt) as 'total_exp_1314',sum(receipt_amt) as 'total_rec_1314', ROUND( (
(
SUM( receipt_amt ) / SUM( disburse_amt ) ) *100
), 0
) AS  'receipt_percent_total_1314'
from report_budget_history_inc_stmt_by_fyear
where 1
and f_year='1314'
$where_scope";

		 
$result6a = mysqli_query($connection, $query6a) or die ("Couldn't execute query 6a.  $query6a");

$num6a=mysqli_num_rows($result6a);	

$row6a=mysqli_fetch_array($result6a);
extract($row6a);

$total_exp_1314=number_format($total_exp_1314,2);
$total_rec_1314=number_format($total_rec_1314,2);


//1213 totals
$query6b="select sum(disburse_amt) as 'total_exp_1213',sum(receipt_amt) as 'total_rec_1213', ROUND( (
(
SUM( receipt_amt ) / SUM( disburse_amt ) ) *100
), 0
) AS  'receipt_percent_total_1213'
from report_budget_history_inc_stmt_by_fyear
where 1
and f_year='1213'
$where_scope";

		 
$result6b = mysqli_query($connection, $query6b) or die ("Couldn't execute query 6b.  $query6b");

$num6b=mysqli_num_rows($result6b);	

$row6b=mysqli_fetch_array($result6b);
extract($row6b);

$total_exp_1213=number_format($total_exp_1213,2);
$total_rec_1213=number_format($total_rec_1213,2);



//1112 totals
$query6c="select sum(disburse_amt) as 'total_exp_1112',sum(receipt_amt) as 'total_rec_1112', ROUND( (
(
SUM( receipt_amt ) / SUM( disburse_amt ) ) *100
), 0
) AS  'receipt_percent_total_1112'
from report_budget_history_inc_stmt_by_fyear
where 1
and f_year='1112'
$where_scope";

		 
$result6c = mysqli_query($connection, $query6c) or die ("Couldn't execute query 6c.  $query6c");

$num6c=mysqli_num_rows($result6c);	

$row6c=mysqli_fetch_array($result6c);
extract($row6c);

$total_exp_1112=number_format($total_exp_1112,2);
$total_rec_1112=number_format($total_rec_1112,2);




//1011 totals
$query6d="select sum(disburse_amt) as 'total_exp_1011',sum(receipt_amt) as 'total_rec_1011', ROUND( (
(
SUM( receipt_amt ) / SUM( disburse_amt ) ) *100
), 0
) AS  'receipt_percent_total_1011'
from report_budget_history_inc_stmt_by_fyear
where 1
and f_year='1011'
$where_scope";

		 
$result6d = mysqli_query($connection, $query6d) or die ("Couldn't execute query 6d.  $query6d");

$num6d=mysqli_num_rows($result6d);	

$row6d=mysqli_fetch_array($result6d);
extract($row6d);

$total_exp_1011=number_format($total_exp_1011,2);
$total_rec_1011=number_format($total_rec_1011,2);




//0910 totals
$query6e="select sum(disburse_amt) as 'total_exp_0910',sum(receipt_amt) as 'total_rec_0910', ROUND( (
(
SUM( receipt_amt ) / SUM( disburse_amt ) ) *100
), 0
) AS  'receipt_percent_total_0910'
from report_budget_history_inc_stmt_by_fyear
where 1
and f_year='0910'
$where_scope";

		 
$result6e = mysqli_query($connection, $query6e) or die ("Couldn't execute query 6e.  $query6e");

$num6e=mysqli_num_rows($result6e);	

$row6e=mysqli_fetch_array($result6e);
extract($row6e);

$total_exp_0910=number_format($total_exp_0910,2);
$total_rec_0910=number_format($total_rec_0910,2);

//if($header_show=='y')
//{

echo "<table border='5' cellspacing='5' align='center'>";
echo "<tr>";








echo "<td align='left'><a href='park_inc_stmts_by_fyear.php?scope=$scope&report_type=$report_type&fyear=1415'><font  $shade_1415>1415 $fyear_1415_check</font></a> (**thru $report_date**)";
//if($fyear=='1415')
{
//echo "<br /><br />**thru $report_date**";
echo "<br /><br /><table><tr><td><font color='red'>EXP $total_exp_1415</font></td></tr><tr><td><font color='green'>REC $total_rec_1415</font></td></tr><tr><td><font color='green'>REC%  $receipt_percent_total_1415</font></td></tr></table>";
}
echo "</td>";


echo "<td align='left'><a href='park_inc_stmts_by_fyear.php?scope=$scope&report_type=$report_type&fyear=1314'><font  $shade_1314>1314 $fyear_1314_check</font></a>";
//if($fyear=='1314')
{
echo "<br /><br /><table><tr><td><font color='red'>EXP $total_exp_1314</font></td></tr><tr><td><font color='green'>REC $total_rec_1314</font></td></tr><tr><td><font color='green'>REC%  $receipt_percent_total_1314</font></td></tr></table>";
}
echo "</td>";


echo "<td align='left'><a href='park_inc_stmts_by_fyear.php?scope=$scope&report_type=$report_type&fyear=1213'><font  $shade_1213>1213 $fyear_1213_check</font></a>";
//if($fyear=='1213')
{
echo "<br /><br /><table><tr><td><font color='red'>EXP $total_exp_1213</font></td></tr><tr><td><font color='green'>REC $total_rec_1213</font></td></tr><tr><td><font color='green'>REC%  $receipt_percent_total_1213</font></td></tr></table>";
}
echo "</td>";


echo "<td align='left'><a href='park_inc_stmts_by_fyear.php?scope=$scope&report_type=$report_type&fyear=1112'><font  $shade_1112 >1112 $fyear_1112_check</font></a>";
//if($fyear=='1112')
{
echo "<br /><br /><table><tr><td><font color='red'>EXP $total_exp_1112</font></td></tr><tr><td><font color='green'>REC $total_rec_1112</font></td></tr><tr><td><font color='green'>REC%  $receipt_percent_total_1112</font></td></tr></table>";
}
echo "</td>";


echo "<td align='left'><a href='park_inc_stmts_by_fyear.php?scope=$scope&report_type=$report_type&fyear=1011'><font  $shade_1011>1011 $fyear_1011_check</font></a>";
//if($fyear=='1011')
{
echo "<br /><br /><table><tr><td><font color='red'>EXP $total_exp_1011</font></td></tr><tr><td><font color='green'>REC $total_rec_1011</font></td></tr><tr><td><font color='green'>REC%  $receipt_percent_total_1011</font></td></tr></table>";
}
echo "</td>";



echo "<td align='left'><a href='park_inc_stmts_by_fyear.php?scope=$scope&report_type=$report_type&fyear=0910'><font  $shade_0910>0910 $fyear_0910_check</font></a>";
//if($fyear=='0910')
{
echo "<br /><br /><table><tr><td><font color='red'>EXP $total_exp_0910</font></td></tr><tr><td><font color='green'>REC $total_rec_0910</font></td></tr><tr><td><font color='green'>REC%  $receipt_percent_total_0910</font></td></tr></table>";
}
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







