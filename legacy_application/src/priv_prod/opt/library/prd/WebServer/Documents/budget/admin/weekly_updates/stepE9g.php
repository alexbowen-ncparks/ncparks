<?php

//echo "<pre>";print_r($_REQUEST);echo "</pre>";//exit;
session_start();
//echo "<pre>";print_r($_SESSION);echo "</pre>";exit;
$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempid=$_SESSION['budget']['tempID'];
//echo $tempid;
extract($_REQUEST);
$end_date=str_replace("-","",$end_date);

//echo "<pre>";print_r($_REQUEST);echo "</pre>";exit;
//echo "end_date=$end_date"; //exit;
//Tables used:
//budget.cab_dpr,budget.coa,budget.authorized_budget,budget.valid_fund_accounts,
//budget.project_steps_detail,budget.project_steps


$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
include("../../../../include/activity.php");// database connection parameters

if($submit1=="Execute")

{

$query1="SELECT paydate FROM beacon_paydates where 1 ";
$result1 = mysqli_query($connection, $query1) or die ("Couldn't execute query 1.  $query1");
$row1=mysqli_fetch_array($result1);
extract($row1);
//echo "paydate=$paydate";exit;


$query2="truncate table temporary_payroll_reconcilement;
";
			 
mysqli_query($connection, $query2) or die ("Couldn't execute query 2.  $query2");

$query3="insert into temporary_payroll_reconcilement(center,center_code,beacon_amount)
select beacon_payments_ws.center,center.parkcode,sum(amount)
from beacon_payments_ws
left join center on beacon_payments_ws.center=center.center
where 1
and valid_entry='y'
and f_year=
'$fiscal_year'
group by beacon_payments_ws.center
order by parkcode;
";
			 
mysqli_query($connection, $query3) or die ("Couldn't execute query 3.  $query3");

$query4="insert into temporary_payroll_reconcilement(center,center_code,exprev_amount)

select exp_rev_ws.center,center.parkcode,sum(debit-credit)
from exp_rev_ws
left join center on exp_rev_ws.center=center.center
left join coa on exp_rev_ws.acct=coa.ncasnum
where f_year=
'$fiscal_year'
and acctdate <=
'$paydate'
and (coa.budget_group='payroll_temporary'
or coa.budget_group='payroll_temporary_receipt')
group by exp_rev_ws.center
order by center.parkcode;
";
			 
mysqli_query($connection, $query4) or die ("Couldn't execute query 4.  $query4");

$query5="select
center,
center_code,
sum(beacon_amount) as 'beacon_amt',
sum(exprev_amount) as 'exprev_amt',
sum(beacon_amount-exprev_amount) as 'oob'
from temporary_payroll_reconcilement
group by center,center_code
order by center_code;
";
			 
$result5 = mysqli_query($connection, $query5) or die ("Couldn't execute query 5.  $query5");

echo "query3=$query3";echo "<br />";
echo "query4=$query4";echo "<br />";
echo "query5=$query5";echo "<br />";


echo "<html>";
echo "<head>
<style>
body { background-color: #FFF8DC; }
table { background-color: white; font-color: blue; font-size: 15;}
TH{font-family: Arial; font-size: 15pt;}
TD{font-family: Arial; font-size: 15pt;}

</style>
	


</head>";







echo "<table border=1>";
 
echo "<tr>"; 
        
echo "<th>Center</th><th>CenterCode</th><th>beacon_amt</th><th>exprev_amt</th><th>OOB</th>";
     
echo "</tr>";

while ($row5=mysqli_fetch_array($result5)){

extract($row5);

//if($status=='complete'){$t=" bgcolor='yellow'";}else{$t=" bgcolor='#B4CDCD'";}
//if($status=='complete'){$fcolor1='red';}else{$fcolor1='black';}	

echo 
	
"<tr>	
  
	   <td>$center</td>
	   <td>$center_code</td>
	   <td>$beacon_amt</td>
	   <td>$exprev_amt</td>
	   <td>$oob</td>
	  
	   
 	
	      
</tr>";



}

echo "</table>";

echo "<form method=post action=stepE9g.php>";
echo "<input type='hidden' name='project_category' value='$project_category'>";	
echo "<input type='hidden' name='project_name' value='$project_name'>";	
echo "<input type='hidden' name='step_group' value='$step_group'>";	   
echo "<input type='hidden' name='step_num' value='$step_num'>";	
echo "<input type='hidden' name='step_name' value='$step_name'>";	
echo "<input type='hidden' name='fiscal_year' value='$fiscal_year'>";	
echo "<input type='hidden' name='start_date' value='$start_date'>";	
echo "<input type='hidden' name='end_date' value='$end_date'>";	

echo "<td><input type=submit name=submit2 value=Execute></td>";
echo "</form>";

echo "</body></html>"; }

if($submit2=="Execute")

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




















