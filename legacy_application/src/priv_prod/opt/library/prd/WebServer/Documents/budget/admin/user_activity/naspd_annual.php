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
//include ("vm_report_menu_v2.php");
//include ("vm_widget2_v2.php");
//include("park_posted_transactions_report_menu.php");
//include("widget1.php");
$query3="select py2 from fiscal_year where report_year='$f_year' ";

$result3 = mysqli_query($connection, $query3) or die ("Couldn't execute query 3.  $query3");

$row3=mysqli_fetch_array($result3);
extract($row3);//brings back max (start_date) as $start_date

//echo "<H1 ALIGN=left><font color=brown><i>$myusername-Articles</i></font></H1>";

//echo "<br />";

$query5a1="select sum(debit-credit) as 'amount1'
from exp_rev
left join coa on exp_rev.acct=coa.ncasnum
where exp_rev.fund='1280'
and exp_rev.f_year='$py2'
and coa.cash_type='disburse';";
		 
$result5a1 = mysqli_query($connection, $query5a1) or die ("Couldn't execute query 5a1.  $query5a1");
$row5a1=mysqli_fetch_array($result5a1);
extract($row5a1);

$query5a2="select sum(credit-debit) as 'amount2'
from exp_rev
left join coa on exp_rev.acct=coa.ncasnum
where exp_rev.fund='1280'
and exp_rev.f_year='$py2'
and coa.cash_type='receipt'
and coa.budget_group != 'par3';";
		 
$result5a2 = mysqli_query($connection, $query5a2) or die ("Couldn't execute query 5a2.  $query5a2");
$row5a2=mysqli_fetch_array($result5a2);
extract($row5a2);

$query5a3="select sum(debit-credit) as 'amount3'
from exp_rev
where exp_rev.fund='1280'
and exp_rev.f_year='$py2';";
		 
$result5a3 = mysqli_query($connection, $query5a3) or die ("Couldn't execute query 5a3.  $query5a3");
$row5a3=mysqli_fetch_array($result5a3);
extract($row5a3);

$query5a4="select sum(credit-debit) as 'amount4'
from exp_rev
left join coa on exp_rev.acct=coa.ncasnum
where exp_rev.fund='1280'
and exp_rev.f_year='$py2'
and coa.budget_group='par3';";
		 
$result5a4 = mysqli_query($connection, $query5a4) or die ("Couldn't execute query 5a4.  $query5a4");
$row5a4=mysqli_fetch_array($result5a4);
extract($row5a4);



echo "<br />";


echo "<table border=1>";

echo 

"<tr>"; 
       
  echo "<th>Line Item</th><th>Amount</font></th> ";
    
echo "</tr>";

$amount1=number_format($amount1,2);
$amount2=number_format($amount2,2);
$amount3=number_format($amount3,2);
$amount4=number_format($amount4,2);

if($c==''){$t=" bgcolor='$table_bg2'";$c=1;}else{$t='';$c='';}
$amount5=$amount2+$amount3+$amount4;
$amount5=number_format($amount5,2);


echo "<tr><td>5a1 operating expenditures</td><td>$amount1</td></tr>";		   
echo "<tr><td>5a2 park generated revenues</td><td>$amount2</td></tr>";		   
echo "<tr><td>5a2 general fund</td><td>$amount3</td></tr>";		   
echo "<tr><td>5a2 other sources</td><td>$amount4</td></tr>";		   
echo "<tr><td>5a2 total funds</td><td>$amount5</td></tr>";		   
     	   
          



echo "</table>";
//if($level>1)
//{



?>


 


























	














