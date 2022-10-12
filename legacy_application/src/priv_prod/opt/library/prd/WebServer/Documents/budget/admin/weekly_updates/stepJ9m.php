<?php
//echo "<pre>";print_r($_REQUEST);echo "</pre>";//exit;
session_start();
//echo "<pre>";print_r($_SESSION);echo "</pre>";exit;
$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempid=$_SESSION['budget']['tempID'];
//echo $tempid;
extract($_REQUEST);
//echo "<pre>";print_r($_REQUEST);"</pre>";//exit;
//$start_date=str_replace("-","",$start_date);
//$end_date=str_replace("-","",$end_date);
//$today_date=date("Ymd");
//echo "start_date=$start_date";
//echo "<br />"; 
//echo "end_date=$end_date";//exit;
//echo "<br />"; 
//echo "today_date=$today_date";exit;

$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
include("../../../../include/activity.php");// database connection parameters
//echo "submit1=$submit1";echo "submit2=$submit2";exit;

$start_date=str_replace("-","",$start_date);
$end_date=str_replace("-","",$end_date);
$today_date=date("Ymd");










$query1="truncate table reconcilement_non1280;
";
mysqli_query($connection, $query1) or die ("Couldn't execute query 1. $query1");

echo "<br />query1=$query1<br />";

$query2="insert into reconcilement_non1280(center,CID_partf_fund_trans_Funds_In_Amount,
CID_partf_fund_trans_Funds_Out_Amount,CID_partf_payments_amount)
SELECT new_fund_in as 'center', sum( amount ) AS 'CID_partf_fund_trans_Funds_In_Amount','','' frOM `partf_fund_trans` WHERE 1 and new_fund_in != '' and datenew <= '$end_date' and partf_fund_trans.trans_manual != 'y'
GROUP BY new_fund_in; 
";
mysqli_query($connection, $query2) or die ("Couldn't execute query 2. $query2");

echo "<br />query2=$query2<br />";

$query3="insert into reconcilement_non1280(center,CID_partf_fund_trans_Funds_In_Amount,
CID_partf_fund_trans_Funds_Out_Amount,CID_partf_payments_amount)
SELECT new_fund_out as 'center','', sum( amount ) AS 'CID_partf_fund_trans_Funds_Out_Amount','' FROM `partf_fund_trans` WHERE 1 and new_fund_out != '' and datenew <= '$end_date' and partf_fund_trans.trans_manual != 'y'
GROUP BY new_fund_out; 
";
mysqli_query($connection, $query3) or die ("Couldn't execute query 3. $query3");

echo "<br />query3=$query3<br />";


$query4="insert into reconcilement_non1280(center,CID_partf_fund_trans_Funds_In_Amount,
CID_partf_fund_trans_Funds_Out_Amount,CID_partf_payments_amount)
SELECT new_center,'','',sum( amount ) AS 'CID_partf_payments_Amount' FROM partf_payments WHERE 1 and datenew <= '$end_date' GROUP BY new_center; 
";
mysqli_query($connection, $query4) or die ("Couldn't execute query 4. $query4");

echo "<br />query4=$query4<br />";



$query5="insert into reconcilement_non1280(center,cid_partf_fund_trans_funds_in_amount,
cid_partf_fund_trans_funds_out_amount,cid_partf_payments_amount,xtnd_revenues,xtnd_expenditures,
internet_balances,xtnd_funding_receipt,xtnd_funding_disburse)
select fund,'','','',sum(revenues) as 'xtnd_revenues','','','',''
from xtnd_ci_monthly
where 1
and bc != '49814'
group by fund;
";
mysqli_query($connection, $query5) or die ("Couldn't execute query 5. $query5");

echo "<br />query5=$query5<br />";



$query6="insert into reconcilement_non1280(center,cid_partf_fund_trans_funds_in_amount,
cid_partf_fund_trans_funds_out_amount,cid_partf_payments_amount,xtnd_revenues,xtnd_expenditures,
internet_balances,xtnd_funding_receipt,xtnd_funding_disburse)
select fund,'','','','',sum(expenditures) as 'xtnd_expenditures','','',''
from xtnd_ci_monthly
where 1
and bc != '49814'
group by fund;
";
mysqli_query($connection, $query6) or die ("Couldn't execute query 6. $query6");

echo "<br />query6=$query6<br />";


$query7="insert into reconcilement_non1280(center,cid_partf_fund_trans_funds_in_amount,
cid_partf_fund_trans_funds_out_amount,cid_partf_payments_amount,xtnd_revenues,xtnd_expenditures,
internet_balances,xtnd_funding_receipt,xtnd_funding_disburse)
select fund,'','','','','','',sum(funding_receipt)as 'xtnd_funding_receipt',''
from xtnd_ci_monthly
where 1
and bc != '49814'
group by fund;
";
mysqli_query($connection, $query7) or die ("Couldn't execute query 7. $query7");

echo "<br />query7=$query7<br />";

$query8="insert into reconcilement_non1280(center,cid_partf_fund_trans_funds_in_amount,
cid_partf_fund_trans_funds_out_amount,cid_partf_payments_amount,xtnd_revenues,xtnd_expenditures,
internet_balances,xtnd_funding_receipt,xtnd_funding_disburse)
select fund,'','','','','','','',sum(funding_disburse)as 'xtnd_funding_disburse'
from xtnd_ci_monthly
where 1
and bc != '49814'
group by fund;
";
mysqli_query($connection, $query8) or die ("Couldn't execute query 8. $query8");

echo "<br />query8=$query8<br />";


/*the purpose of these queries is to populate temporary table="cid_charg_project_balances" with 
balances in the same way that the "DPR internet report" works. Instead of totalling "center 
transactions" directly, the following Queries "sum transactions" by PROJECT "first"
and then get the "Center Values" from the "Current Center associated with each PROJECT" 
from the PARTF_projects table*/

$query9="truncate table cid_charg_project_balances;
";
mysqli_query($connection, $query9) or die ("Couldn't execute query 9. $query9");

$query10="insert into cid_charg_project_balances(project,center,fundsin,fundsout,payments)
SELECT proj_in as 'project', partf_projects.new_center, sum( amount ) AS 'fundsin','','' FROM partf_fund_trans LEFT JOIN partf_projects ON partf_fund_trans.proj_in = partf_projects.projnum WHERE partf_projects.reportdisplay = 'y' and datenew <= '$end_date' and partf_fund_trans.trans_manual != 'y' GROUP BY partf_projects.projnum ORDER BY partf_projects.new_center; 
";
mysqli_query($connection, $query10) or die ("Couldn't execute query 10. $query10");

echo "<br />query10=$query10<br />";



$query11="insert into cid_charg_project_balances(project,center,fundsin,fundsout,payments)
SELECT proj_out AS 'project', partf_projects.new_center, '',sum( amount ) AS 'fundsout','' FROM partf_fund_trans LEFT JOIN partf_projects ON partf_fund_trans.proj_out = partf_projects.projnum WHERE partf_projects.reportdisplay = 'y' and datenew <= '$end_date' and partf_fund_trans.trans_manual != 'y' GROUP BY partf_projects.projnum ORDER BY partf_projects.new_center; 
";
mysqli_query($connection, $query11) or die ("Couldn't execute query 11. $query11");

echo "<br />query11=$query11<br />";


$query12="insert into cid_charg_project_balances(project,center,fundsin,fundsout,payments)
SELECT charg_proj_num AS 'project', partf_projects.new_center, '','',sum( amount ) AS 'payments' FROM partf_payments LEFT JOIN partf_projects ON partf_payments.charg_proj_num = partf_projects.projnum WHERE partf_projects.reportdisplay = 'y' and datenew <= '$end_date' GROUP BY partf_projects.projnum ORDER BY partf_projects.new_center;
";
mysqli_query($connection, $query12) or die ("Couldn't execute query 12. $query12");

echo "<br />query12=$query12<br />";


$query13="insert into reconcilement_non1280(center,cid_partf_fund_trans_funds_in_amount,cid_partf_fund_trans_funds_out_amount,cid_partf_payments_amount,xtnd_revenues,xtnd_expenditures,internet_balances)
select center,'','','','','',sum(fundsin-fundsout-payments) as 'internet_balances'
from cid_charg_project_balances
group by center
order by center;
";
mysqli_query($connection, $query13) or die ("Couldn't execute query 13. $query13");

echo "<br />query13=$query13<br />";


$query14=" truncate table report_project_status_oob; 
";
mysqli_query($connection, $query14) or die ("Couldn't execute query 14. $query14");

echo "<br />query14=$query14<br />";


$query15=" insert into report_project_status_oob(view,center,cid_balance,xtnd_balance,out_of_balance) 
SELECT 'all',center, sum( cid_partf_fund_trans_funds_in_amount - cid_partf_fund_trans_funds_out_amount - cid_partf_payments_amount ) AS 'cid_balance', sum( xtnd_revenues - xtnd_expenditures+xtnd_funding_receipt-xtnd_funding_disburse ) AS 'xtnd_balance', sum( cid_partf_fund_trans_funds_in_amount - cid_partf_fund_trans_funds_out_amount - cid_partf_payments_amount - xtnd_revenues + xtnd_expenditures-xtnd_funding_receipt+xtnd_funding_disburse ) AS 'out_of_balance' FROM reconcilement_non1280 WHERE 1 GROUP BY center;
";
mysqli_query($connection, $query15) or die ("Couldn't execute query 15. $query15");

echo "<br />query15=$query15<br />";

echo "<html>";
echo "<head>
<style>
body { background-color: #FFF8DC; }
table { background-color: white; font-color: blue; font-size: 15;}
TH{font-family: Arial; font-size: 15pt;}
TD{font-family: Arial; font-size: 15pt;}

</style>
	


</head>";

//echo "<body bgcolor=>";

//echo "<H3 ALIGN=CENTER > <A href=welcome.php> Return HOME </A></H3>";
echo "<H1 ALIGN=LEFT > <font color=brown><i>$project_name-StepGroup $step_group-$step</font></i></H1>";
echo "<H3 ALIGN=LEFT > <font color=blue>StepName-$step_name</font></H3>";
echo "<H2 ALIGN=center><font size=4><b><A href=/budget/admin/weekly_updates/step_group.php?project_category=$project_category&project_name=$project_name&step_group=$step_group&fiscal_year=$fiscal_year&start_date=$start_date&end_date=$end_date> Return StepJ </A></font></H2>";


echo "<br />";

$query15a="truncate table report_project_status_oob2;";
mysqli_query($connection, $query15a) or die ("Couldn't execute query 15a. $query15a");

echo "<br />query15a=$query15a<br />";

$query16="insert into report_project_status_oob2(center,cid_balance,xtnd_balance,out_of_balance)
SELECT center,sum(cid_balance)as 'cid_balance',sum(xtnd_balance)as 'xtnd_balance',sum(out_of_balance)as 'out_of_balance' FROM report_project_status_oob WHERE 1 GROUP BY center; 
";
mysqli_query($connection, $query16) or die ("Couldn't execute query 16. $query16");

echo "<br />query16=$query16<br />";

$query17="select center,sum(cid_balance)as 'cid_balance',sum(xtnd_balance)as 'xtnd_balance',sum(out_of_balance)as 'out_of_balance'
          from report_project_status_oob2
		  where 1 and out_of_balance != '0'
		  group by center; ";


$result17 = mysqli_query($connection, $query17) or die ("Couldn't execute query 17.  $query17");

echo "<br />query17=$query17<br />";

$num17=mysqli_num_rows($result17);
//echo $num10;exit;
//////mysql_close();
echo "Records: $num17";
echo "<table border=1>";
 
echo "<tr>"; 
    
 echo " <th><font color=blue>center</font></th>";
 echo " <th><font color=blue>cid_balance</font></th>";
 echo " <th><font color=blue>xtnd_balance</font></th>";
 echo " <th><font color=blue>out_of_balance</font></th>";
 
 

echo "</tr>";
echo  "<form method='post' action='stepJ9m_update.php'>";
//exit;
// The while statement steps through the $result variable one row ($row, which is an array created by mysqli_fetch_array) at a time
//$row3=mysqli_fetch_array($result3);
//extract($row3);$companyarray[]=$company;$acctarray[]=$acct;$centerarray[]=$center;
//$calendar_acctdatearray[]=$calendar_acctdate;$amountarray[]=$amount;$signarray[]=$sign;
//$pcard_trans_idarray[]=$pcard_trans_id;$transid_verifiedarray[]=$transid_verified;
//$idarray[]=$id;}
// The extract function automatically creates individual variables from the array $row
//These individual variables are the names of the fields queried from MySQL
//extract($row3);$idarray[]=$id;$pcard_trans_idarray[]=$pcard_trans_id;$transid_verifiedarray[]=$transid_verified;
//extract($row3);

//if($c==''){$t=" bgcolor='#B4CDCD'";$c=1;}else{$t='';$c='';}
if($status=='complete'){$t=" bgcolor='#B4CDCD'";}else{$t=" bgcolor='yellow'";}
if($status=='complete'){$fcolor1='red';}else{$fcolor1='black';}	
//if($status=='complete'){$bgc='yellow'";}else{$bgc='#B4CDCD';}
//while ($row3=mysqli_fetch_array($result3)){

// The extract function automatically creates individual variables from the array $row
//These individual variables are the names of the fields queried from MySQL
//extract($row3);
while ($row17=mysqli_fetch_array($result17)){

// The extract function automatically creates individual variables from the array $row
//These individual variables are the names of the fields queried from MySQL
extract($row17);


//echo "<pre>";print_r($row3);echo "</pre>";//exit;
echo "<tr$t>";	      
//echo "<form method=post action=stepJ9_update.php>";	   
echo  "<td><input type='text' size='20 readonly='readonly' name='center' value='$center'</td>";
echo  "<td><input type='text' size='20' readonly='readonly' name='cid_balance' value='$cid_balance'</td>";
echo  "<td><input type='text' size='20' readonly='readonly' name='xtnd_balance' value='$xtnd_balance'</td>";
echo  "<td><input type='text' size='20' readonly='readonly' name='out_of_balance' value='$out_of_balance'</td>";

 echo "</tr>";     

}


echo "<tr><td colspan='15' align='right'><input type='submit' name='submit2' value='Update'></td></tr>";
echo "<input type='hidden' name='fiscal_year' value='$fiscal_year'>	   
	   <input type='hidden' name='project_category' value='$project_category'>	   
	   <input type='hidden' name='project_name' value='$project_name'>	   
	   <input type='hidden' name='start_date' value='$start_date'>	   
	   <input type='hidden' name='end_date' value='$end_date'>	   
	   <input type='hidden' name='step_group' value='$step_group'>	   
	   <input type='hidden' name='step_num' value='$step_num'>	   
	   <input type='hidden' name='step' value='$step'>	   
	   <input type='hidden' name='step_name' value='$step_name'>
	   <input type='hidden' name='num10' value='$num10'>";
echo "</form>";


echo "<form method='post' action='stepJ9m.php'>";		   
echo  "<tr><td colspan='15' align='right'><input type='submit' name='submit2' value='Mark_Complete'></tr>";
echo "<input type='hidden' name='fiscal_year' value='$fiscal_year'>	   
	   <input type='hidden' name='project_category' value='$project_category'>	   
	   <input type='hidden' name='project_name' value='$project_name'>	   
	   <input type='hidden' name='start_date' value='$start_date'>	   
	   <input type='hidden' name='end_date' value='$end_date'>	   
	   <input type='hidden' name='step_group' value='$step_group'>	   
	   <input type='hidden' name='step_num' value='$step_num'>	   
	   <input type='hidden' name='step' value='$step'>	   
	   <input type='hidden' name='step_name' value='$step_name'>
	   <input type='hidden' name='num10' value='$num10'>"; 
 echo   "</form>";	


echo "</table>";
	

echo "</html>";

if($submit2=="Mark_Complete")
{
$query23a="update budget.project_steps_detail set status='complete' where project_category='$project_category'
         and project_name='$project_name' and step_group='$step_group' and step_num='$step_num' ";
			 
mysqli_query($connection, $query23a) or die ("Couldn't execute query 23a.  $query23a");

$query24="select * from budget.project_steps_detail
         where project_category='$project_category' and project_name='$project_name'
		 and step_group='$step_group'  and status='pending' "; 

$result24=mysqli_query($connection, $query24) or die ("Couldn't execute query 24.  $query24");

$num24=mysqli_num_rows($result24);

//echo "pending_items=$num4";exit;

//if($num4==0){echo "done"}; if ($num4!=0){echo "$num4 pending items"}; exit;
if($num24==0)

{$query25="update budget.project_steps set status='complete' where project_category='$project_category'
         and project_name='$project_name' and step_group='$step_group' ";
mysqli_query($connection, $query25) or die ("Couldn't execute query 25.  $query25");}
////mysql_close();

if($num24==0)

{header("location: main.php?project_category=$project_category&project_name=$project_name ");}

if($num24!=0)

{header("location: step_group.php?project_category=$project_category&project_name=$project_name&step_group=$step_group&fiscal_year=$fiscal_year&start_date=$start_date&end_date=$end_date");}
}



?>