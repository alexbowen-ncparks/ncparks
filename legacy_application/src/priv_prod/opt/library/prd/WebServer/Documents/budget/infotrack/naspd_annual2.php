<?php

session_start();
if(!$_SESSION["budget"]["tempID"]){echo "access denied";exit;
//header("location: /login_form.php?db=budget");
}

$active_file=$_SERVER['SCRIPT_NAME'];

$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempID=$_SESSION['budget']['tempID'];
$beacnum=$_SESSION['budget']['beacon_num'];
$concession_location=$_SESSION['budget']['select'];
$concession_center=$_SESSION['budget']['centerSess'];

extract($_REQUEST);


//echo "<pre>";print_r($_SERVER);"</pre>";//exit;
//echo "<pre>";print_r($_SESSION);"</pre>";//exit;
//echo "<pre>";print_r($_REQUEST);"</pre>";//exit;

$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
include("../../../include/activity.php");// database connection parameters
//include("../budget/~f_year.php");
include("../../budget/~f_year.php");


$table="rbh_multiyear_concession_fees3";

$query10="SELECT body_bgcolor,table_bgcolor,table_bgcolor2
from concessions_customformat
WHERE 1 
";
//echo "query10=$query10<br />";
$result10=mysqli_query($connection, $query10) or die ("Couldn't execute query 10. $query10");

$row10=mysqli_fetch_array($result10);

extract($row10);

$body_bg=$body_bgcolor;
$table_bg=$table_bgcolor;
$table_bg2=$table_bgcolor2;

//echo "body_bg:$body_bg";
//echo "<br />";
//echo "table_bg:$table_bg";
//echo "<br />";
//echo "table_bg2:$table_bg2";

$query11="SELECT filegroup
from concessions_filegroup
WHERE 1 and filename='$active_file'
";

$result11=mysqli_query($connection, $query11) or die ("Couldn't execute query 11. $query11");

$row11=mysqli_fetch_array($result11);

extract($row11);

//include("../../../budget/menus2.php");
//include("menu1314_cash_receipts.php");
include("../../budget/menu1314.php");
include ("naspd_annual_widget1.php");
include ("naspd_annual_widget2.php");
//include ("vm_report_menu_v2.php");
//include ("vm_widget2_v2.php");
//include("park_posted_transactions_report_menu.php");
//include("widget1.php");
/*
$query3="select f_year,py3 from fiscal_year where report_year='$f_year' ";

$result3 = mysqli_query($connection, $query3) or die ("Couldn't execute query 3.  $query3");

$row3=mysqli_fetch_array($result3);
extract($row3);//brings back max (start_date) as $start_date
*/

//echo "<H1 ALIGN=left><font color=brown><i>$myusername-Articles</i></font></H1>";

//echo "<br />";



$query5e7="select coa.naspd_funding_source,coa.naspd_revenue_type,
coa.park_acct_desc as 'account_description',
exp_rev.acct,
sum(exp_rev.credit-exp_rev.debit) as 'amount'
from exp_rev
left join coa on exp_rev.acct=coa.ncasnum
where 1
and exp_rev.fund='1280'
and exp_rev.f_year='$f_year'
and coa.naspd_funding_source != ''
and coa.naspd_revenue_type != ''
group by account_description,exp_rev.acct
order by account_description,account_description; ";
		 
$result5e7 = mysqli_query($connection, $query5e7) or die ("Couldn't execute query 5e7.  $query5e7");
$num5e7=mysqli_num_rows($result5e7);
$row5e7=mysqli_fetch_array($result5e7);
//extract($row5e7);


echo "<table><tr><td bgcolor='#FFE4E1'>DPR (Fund 1280) Receipts by NCAS Account (INTERNAL Use ONLY)</td></tr></table>";

echo "<br />";
echo "<table><tr><th>$num5e7 Records </th></tr></table>";
echo "<br />";
echo "<table border=1>";

echo 

"<tr>"; 
       
  echo "<th>NCAS Account Description</th><th>NCAS Account#</th><th>Amount</th><th>NASPD Funding Source</th><th>NASPD Revenue Type</th>";
    
echo "</tr>";






while ($row5e7=mysqli_fetch_array($result5e7)){


extract($row5e7);
//$park_acct_desc=strtolower($park_acct_desc);
//$park_acct_desc=str_replace('_',' ',$park_acct_desc);
//$naspd_funding_source=str_replace('_',' ',$naspd_funding_source);
//$naspd_revenue_type=str_replace('_',' ',$naspd_revenue_type);
$amount=number_format($amount,2);
//$py_actual=number_format($py_actual,2);
//$difference=number_format($difference,2);

if($c==''){$t=" bgcolor='$table_bg2' ";$c=1;}else{$t='';$c='';}

echo 

"<tr$t>"; 


echo "<td>$account_description</td>";  
echo "<td>$acct</td>"; 
echo "<td>$amount</td>"; 
echo "<td>$naspd_funding_source</td>";
echo "<td>$naspd_revenue_type</td>";

          
echo "</tr>";

}
$query5e8="select sum(exp_rev.credit-exp_rev.debit) as 'total_amount'
from exp_rev
left join coa on exp_rev.acct=coa.ncasnum
where 1
and exp_rev.fund='1280'
and exp_rev.f_year='$f_year'
and coa.naspd_revenue_type != '';";
		 
$result5e8 = mysqli_query($connection, $query5e8) or die ("Couldn't execute query 5e8.  $query5e8");
$row5e8=mysqli_fetch_array($result5e8);
extract($row5e8);
$total_amount=number_format($total_amount,2);
echo "<tr><td>Total</td><td>$total_amount</td></tr>";


 echo "</table>";



?>


 


























	














