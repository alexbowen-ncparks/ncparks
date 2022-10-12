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

//echo "hello";

extract($_REQUEST);

//echo "$report_date<br />";exit;


//echo $concession_location;
/*
if($level=='5' and $tempID !='Dodd3454')
{
//echo "<pre>";print_r($_SERVER);"</pre>";//exit;
echo "<pre>";print_r($_SESSION);"</pre>";//exit;
//echo "<pre>";print_r($_REQUEST);"</pre>";exit;
}
*/
//echo "<pre>";print_r($_REQUEST);"</pre>";//exit;
//echo "<pre>";print_r($_SESSION);"</pre>";//exit;

$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
include("../../../include/activity.php");// database connection parameters
//include("../budget/~f_year.php");
include("../../budget/~f_year.php");
//echo "f_year=$f_year<br />";
if($fyearS==''){$fyearS=$f_year;}
if($scope==''){$scope='park';}
if($report_type==''){$report_type='all';}
//if($beacnum !="60032793" and $beacnum != '60033162'){echo "<font color='red' size='5'>Message:"; print_r($_SESSION['budget']['tempID']);echo " does not have access to this report</font>";exit;}
/*
if($level=='5' and $tempID !='Dodd3454')
{

echo "beacon_number:$beacnum";
echo "<br />";
echo "concession_location:$concession_location";
echo "<br />";
echo "concession_center:$concession_center";
echo "<br />";
}
*/
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

//echo "query11=$query11<br />";
$result11=mysqli_query($connection, $query11) or die ("Couldn't execute query 11. $query11");

$row11=mysqli_fetch_array($result11);

extract($row11);
//echo "<br />";
//echo $filegroup;

/*
echo "<html>";
echo "<head>
<title>Concessions</title>";
*/
//include ("test_style.php");
//include ("test_style.php");

//echo "</head>";

//include("../../../budget/menus2.php");
//include("menu1314_cash_receipts.php");
//include("../../../budget/menu1314.php");
include ("../../budget/menu1415_v1.php");


 
 
 if($report_type=='pfr')
{
if($scope=='park'){$where_scope=" and scope='park' ";}



//if($level>1)

{

//$query5="SELECT * FROM `report_budget_history` WHERE `f_year`='$fyearS' AND `center`='$centerS' and (budget_group='pfr_revenues' or budget_group='pfr_expenses')";
$query5="SELECT * FROM `report_budget_history` WHERE `f_year`='$fyearS' AND `parkcode`='$parkcodeS' and (budget_group='pfr_revenues' or budget_group='pfr_expenses') and account != '533900004' ";

}

//echo "<font color='brown'>query5=$query5<br /><br />Query 5 from PHP: <br /><b>park_inc_stmts_by_fyear_v2.php (Line: 381)</b></font>";	 

echo "Line 139: query5=$query5";
$result5 = mysqli_query($connection, $query5) or die ("Couldn't execute query 5.  $query5");
$num5=mysqli_num_rows($result5);
$median_record=round($num5/2,0);


	
//echo "<br >Line 151: total_receipts=$total_receipts<br />";

echo "<br /><br />";

if($scope=='park'){$check_park="<img height='25' width='25' src='/budget/infotrack/icon_photos/green_checkmark1.png' alt='picture of green check mark'></img>$num5";}

if($scope=='all'){$check_all="<img height='25' width='25' src='/budget/infotrack/icon_photos/green_checkmark1.png' alt='picture of green check mark'></img>$num5";}

if($report_type=='all'){$report_all="<img height='25' width='25' src='/budget/infotrack/icon_photos/green_checkmark1.png' alt='picture of green check mark'></img>";}

if($report_type=='pfr'){$report_pfr="<img height='25' width='25' src='/budget/infotrack/icon_photos/green_checkmark1.png' alt='picture of green check mark'></img>";}

if($report_type=='receipt_detail'){$report_receipt_detail="<img height='25' width='25' src='/budget/infotrack/icon_photos/green_checkmark1.png' alt='picture of green check mark'></img>";}
/*
echo "<table border='1' align='center'><tr><th>Park Receipts and Expenditures by Fiscal Year<br /></th><th><a href='park_inc_stmts_by_fyear_v2.php?fyear=$fyear&report_type=$report_type&scope=park'>Park<br />Centers</a><br />$check_park</th><th><a href='park_inc_stmts_by_fyear_v2.php?fyear=$fyear&report_type=$report_type&scope=all'>All<br />Centers</a> <br />$check_all</th></tr></table>";
*/
//echo "<table border='1' align='center'><tr><th>Park Retail Receipts and Expenditures by Fiscal Year-NCAS Account</th></tr></table>";

//echo "<br />";
/*
echo "<br /><table border='1' align='center'><tr><th>Report Type</th><th><a href='park_inc_stmts_by_fyear_v2.php?fyear=$fyear&scope=$scope&report_type=all'>ALL</a><br />$report_all</th><th><a href='park_inc_stmts_by_fyear_v2.php?fyear=$fyear&scope=$scope&report_type=pfr'>PFR</a> <br />$report_pfr</th><th><a href='park_inc_stmts_by_fyear_v2.php?fyear=$fyear&scope=$scope&report_type=receipt_detail'>Receipts</a> <br />$report_receipt_detail</th></tr></table>";
*/


echo "<br /><table border='1' align='center'><tr><th>Report Type</th><th>Retail<img height='25' width='25' src='/budget/infotrack/icon_photos/green_checkmark1.png' alt='picture of green check mark'></img></th></tr></table>";




if($report_type=='pfr'){echo "<table align='center'><tr><th><img height='200' width='200' src='/budget/infotrack/icon_photos/mission_icon_photos_265.jpg' alt='cabe marina store'></img></th></tr></table>";}












//include ("inc_stmt_by_fyear_head1_pfr.php");
include ("pfr_drilldown_fyear_head1_v2.php");

echo "<table border=1 align='center'>";

echo 

"<tr>"; 
       //echo "<th align=left><font color=brown>Category</font></th>";
  echo "<th align=left><font color=brown>Parkcode</font></th>
        <th align=left><font color=brown>Center</font></th>
       <th align=left><font color=brown>Cash Type</font></th>
	   <th align=left><font color=brown>Account</font></th>
	   <th align=left><font color=brown>Account Desciption</font></th>
        <th align=left><font color=brown>Actual Amount</font></th>
       
       ";
       	   
	   
	   
	   
       
   //echo"<th align=left><font color=brown>Fees</font></th>";
       
              
echo "</tr>";


while ($row=mysqli_fetch_array($result5)){


extract($row);

if($cash_type=='disburse'){$cash_type='expense';}

//if($cash_type='receipt'){$amount=number_format($amount,2);}
if($cash_type=='receipt'){$amount2=number_format($amount,2);}
if($cash_type=='expense'){$amount2=number_format(-$amount,2);}



//if($c==''){$t=" bgcolor='#B4CDCD'";$c=1;}else{$t='';$c='';}
if($c==''){$t=" bgcolor='$table_bg2'";$c=1;}else{$t='';$c='';}

echo 

"<tr$t>";

       //echo "<td>$category</td>";
	   
 	   
	   
  
    
     echo "<td>$parkcodeS</td>";		   
     echo "<td>$center</td>";	
	 echo "<td>$cash_type</td>";
     echo "<td>$account</td>";           
	 echo "<td>$account_description</td>";
	 if($fyearS >= '1415')
	 {
     echo "<td><a href='../../budget/c/tunnel_cy_actual.php?f_year=$fyearS&center=$center&acct=$account&cy_actual=$amount' target='_blank'>$amount2</a></td>";
	 }	 
 
    if($fyearS < '1415')
	 {
     echo "<td>$amount2</td>";
	 }	 



 
           
echo "</tr>";




}

$var_park_average=$var_total_receipt/$num5;
$var_park_average2=number_format($var_park_average,0);

if($c==''){$t=" bgcolor='$table_bg2' ";$c=1;}else{$t='';$c='';}

//$query6="select sum(amount) as 'total_receipts' from report_budget_history where f_year='$fyearS' and center='$centerS' and budget_group='pfr_revenues' ";
$query6="select sum(amount) as 'total_receipts' from report_budget_history where f_year='$fyearS' and parkcode='$parkcodeS' and budget_group='pfr_revenues' ";

//echo "<br />Line 145: query6=$query6<br />";		 
$result6 = mysqli_query($connection, $query6) or die ("Couldn't execute query 6.  $query6");
$row6=mysqli_fetch_array($result6);

extract($row6);
//$num6=mysqli_num_rows($result6);


//$query6a="select -sum(amount) as 'total_expenditures' from report_budget_history where f_year='$fyearS' and center='$centerS' and budget_group='pfr_expenses' ";
$query6a="select -sum(amount) as 'total_expenditures' from report_budget_history where f_year='$fyearS' and parkcode='$parkcodeS' and budget_group='pfr_expenses' and account != '533900004' ";

//echo "<br />Line 145: query6a=$query6a<br />";		 
$result6a = mysqli_query($connection, $query6a) or die ("Couldn't execute query 6a.  $query6a");
$row6a=mysqli_fetch_array($result6a);

extract($row6a);

$receipt_to_expenditure=number_format($total_receipts/$total_expenditures,2);

$total_receipts2=number_format($total_receipts,2);
$total_expenditures2=number_format($total_expenditures,2);

$earned_profit=$total_receipts-$total_expenditures;
$earned_profit2=number_format($earned_profit,2);

//$query6b="select disburse_target as 'disburse_target_total',receipt_target as 'receipt_target_total' from report_budget_history_inc_stmt_by_fyear_pfr where f_year='$fyearS' and center='$centerS' ";
$query6b="select disburse_target as 'disburse_target_total',receipt_target as 'receipt_target_total' from report_budget_history_inc_stmt_by_fyear_pfr where f_year='$fyearS' and parkcode='$parkcodeS' ";

//echo "<br />Line 145: query6b=$query6b<br />";		 
$result6b = mysqli_query($connection, $query6b) or die ("Couldn't execute query 6b.  $query6b");
$row6b=mysqli_fetch_array($result6b);

extract($row6b);

$receipt_target_to_expenditure_target=number_format($receipt_target_total/$disburse_target_total,2);

$receipt_target_total2=number_format($receipt_target_total,2);
$disburse_target_total2=number_format($disburse_target_total,2);


if($fyearS < '1819')
{
$receipt_target_to_expenditure_target='not_available';
$receipt_target_total2='not_available';
$disburse_target_total2='not_available';

}

echo "<tr$t><td></td><td></td><td></td><td></td><td>Total Receipts</td><td>$total_receipts2</td></tr>";
echo "<tr$t><td></td><td></td><td></td><td></td><td>Total Expenses</td><td>$total_expenditures2</td></tr>";
echo "<tr$t><td></td><td></td><td></td><td></td><td>Earned Profit</td><td>$earned_profit2</td></tr>";




//}
//}

 echo "</table>";
 // echo "<h3><A href='webpage_add.php?&add_your_own=y&project_category=$project_category'>ADD</A></h3>";
 }
 
 

 
 
 
 echo "</body></html>";


 






?>