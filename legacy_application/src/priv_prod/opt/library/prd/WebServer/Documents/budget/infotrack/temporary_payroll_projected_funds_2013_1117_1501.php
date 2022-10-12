<?php

session_start();

if(!$_SESSION["budget"]["tempID"]){echo "access denied";exit;
//header("location: https://10.35.152.9/login_form.php?db=budget");
}

//$file = "articles_menu.php";
//$lines = count(file($file));


//$table="infotrack_projects";
//echo "<pre>";print_r($_REQUEST);"</pre>";//exit;

$active_file=$_SERVER['SCRIPT_NAME'];
$active_file_request=$_SERVER['REQUEST_URI'];

$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempID=$_SESSION['budget']['tempID'];
$beacnum=$_SESSION['budget']['beacon_num'];
$infotrack_location=$_SESSION['budget']['select'];
$infotrack_center=$_SESSION['budget']['centerSess'];
$pcode=$_SESSION['budget']['select'];



//echo "<pre>";print_r($_SERVER);"</pre>";

//echo "active_file=$active_file<br />";
//echo "active_file_request=$active_file_request<br />";


extract($_REQUEST);
//echo "<pre>";print_r($_SERVER);"</pre>";//exit;
//if($level=='5' and $tempID !='Dodd3454')
//echo "pcode=$pcode";
//echo "<pre>";print_r($_SESSION);"</pre>";//exit;
//echo "<pre>";print_r($_REQUEST);"</pre>";exit;


//include("../../../include/connectBUDGET.inc");// database connection parameters
//include("../../../include/activity.php");// database connection parameters
//include("../budget/~f_year.php");
//include("../../budget/~f_year.php");
include("../../budget/~f_year.php");
//echo "f_year=$f_year";
$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/connectROOT.inc"); // connection parameters
mysql_select_db($database, $connection); // database 
//echo "f_year=$f_year";

$query10="SELECT body_bgcolor,table_bgcolor,table_bgcolor2
from concessions_customformat
WHERE 1 ";

//echo "query10=$query10";
$result10=mysql_query($query10) or die ("Couldn't execute query 10. $query10");

$row10=mysql_fetch_array($result10);

extract($row10);

$body_bg=$body_bgcolor;
$table_bg=$table_bgcolor;
$table_bg2=$table_bgcolor2;

$query11="SELECT filegroup,report_name
from infotrack_filegroup
WHERE 1 and filename='$active_file'
";

$result11=mysql_query($query11) or die ("Couldn't execute query 11. $query11");

$row11=mysql_fetch_array($result11);

extract($row11);


echo"
<html>
<head>
<title>MC Procedures</title>";
echo "</head>";
//include("../../budget/menu1314_procedures.php");
include("../../budget/menu1314.php");

/*
$query3="select py1 from fiscal_year where report_year='$f_year' ";

$result3 = mysql_query($query3) or die ("Couldn't execute query 3.  $query3");

$row3=mysql_fetch_array($result3);
extract($row3);
*/

//$f_year='1213';





$query3a="select max(acctdate) as 'report_date'
from exp_rev
where 1 ;";
		 
$result3a = mysql_query($query3a) or die ("Couldn't execute query 3a.  $query3a");
$row3a=mysql_fetch_array($result3a);
extract($row3a);



$query3b="select x.account,coa.park_acct_desc as 'account_description',coa.cash_type,sum(z.authorized) as 'authorized',sum(y.cy_earned_spent) as 'cy_earned_spent' from
f1280_accounts as x
left join
(

select exp_rev.fund,exp_rev.acct,coa.park_acct_desc as 'account_description',sum(exp_rev.debit-exp_rev.credit) as 'cy_earned_spent',exp_rev.f_year,coa.cash_type
from exp_rev 
left join coa on exp_rev.acct=coa.ncasnum
where exp_rev.f_year='$f_year' and exp_rev.fund='1280' and coa.cash_type='disburse'
group by exp_rev.fund,exp_rev.acct

union

select exp_rev.fund,exp_rev.acct,coa.park_acct_desc as 'account_description',sum(exp_rev.credit-exp_rev.debit) as 'cy_earned_spent',exp_rev.f_year,coa.cash_type
from exp_rev 
left join coa on exp_rev.acct=coa.ncasnum
where exp_rev.f_year='$f_year' and exp_rev.fund='1280' and coa.cash_type='receipt'
group by exp_rev.fund,exp_rev.acct

) as y
on x.account=y.acct
left join coa on x.account=coa.ncasnum
left join cab_dpr as z on x.account=z.acct
and z.fund='1280' and z.f_year='$f_year'
where 1
and (coa.ncasnum='531311' or coa.ncasnum='531312')
group by x.account;";	

//echo "$query3b"; 
$result3b = mysql_query($query3b) or die ("Couldn't execute query 3b.  $query3b");
$num3b=mysql_num_rows($result3b);



echo "<br />";

$report_date2=date("F j, Y", strtotime($report_date));

if($projected_date==''){$projected_date=$report_date;}

echo "<table><tr><td>
Fiscal Year $f_year</td></tr><tr><td>Temporary Payroll</td></tr>
</table>";
echo "<br /><br />";
echo"<table>";
echo "<form method='post' action='temporary_payroll_projected_funds.php'>";
echo "<tr><th>Projected Funds as of </th><td><input type='text' name='projected_date' value='$projected_date'><input type='submit' name='submit1' value='Execute'></td></tr>";
echo "</form>";
echo "</table>";


echo "<br />";
//echo "<table><th>CY Authorized versus PY Actual</th></table>";
echo "<br />";
//echo "<table><th>$num4 Records</th></table>";

echo "<table border=1>";

echo "<tr>";
echo "<th>NCAS <br />account</th><th>NCAS<br /> account description</th><th>NCAS <br />authorized</th><th>NCAS<br />spent thru<br />$report_date2</th><th>NCAS<br />available</th>
";


echo "</tr>";


while ($row3b=mysql_fetch_array($result3b)){


extract($row3b);

if($cash_type=='disburse')
{
$available_funds=$authorized-$cy_earned_spent; //calculation must take place before formatting
}
else
{
$available_funds=$cy_earned_spent-$authorized; //calculation must take place before formatting
}


$authorized=number_format($authorized,2);
$cy_earned_spent=number_format($cy_earned_spent,2);
$available_funds=number_format($available_funds,2);

$account_description=str_replace('_',' ',$account_description);
$account_description=strtolower($account_description);
if($c==''){$t=" bgcolor='$table_bg2' ";$c=1;}else{$t='';$c='';}

echo 

"<tr$t>"; 


echo "<td>$account</td>";
echo "<td>$account_description</td>";  
echo "<td>$authorized</td>"; 
echo "<td>$cy_earned_spent</td>"; 
echo "<td>$available_funds</td>"; 


          
echo "</tr>";

}

 echo "</table>";
 echo "</body>";
 echo "</html>";
 
 
 ?>
 