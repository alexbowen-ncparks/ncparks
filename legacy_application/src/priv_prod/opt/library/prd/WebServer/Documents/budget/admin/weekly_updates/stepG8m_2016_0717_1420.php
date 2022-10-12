<?php

//echo "<pre>";print_r($_REQUEST);echo "</pre>";//exit;
session_start();
$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempid=$_SESSION['budget']['tempID'];
extract($_REQUEST);
//echo "<pre>";print_r($_REQUEST);echo "</pre>";//exit;
//$start_date=str_replace("-","",$start_date);
//$end_date=str_replace("-","",$end_date);
//echo "start_date=$start_date";
//echo "<br />"; 
//echo "end_date=$end_date";exit;
$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/connectROOT.inc"); // connection parameters
mysql_select_db($database, $connection); // database
include("../../../../include/activity.php");// database connection parameters

$start_date=str_replace("-","",$start_date);
$end_date=str_replace("-","",$end_date);


if($submit1=="Execute")

{

$query1="select count(whid) as 'exprev_count',sum(debit-credit) as 'exprev_amount'
from exp_rev_ws
where f_year=
'$fiscal_year'
and acctdate <=
'$end_date'
and (description like '%procurementcard%' or description like '%purchasingcard%' or description like '%bank of america%'  ) and description != 'itseprocurement'
and acct != '535675';
";

$result1 = mysql_query($query1) or die ("Couldn't execute query 1.  $query1");
$row1=mysql_fetch_array($result1);
extract($row1);
//echo "charge_amount='$charge_amount'"; //exit;

$query2="select count(id)as 'pce_count',sum(debit-credit)as 'pce_amount'
from pcard_extract
where 1
and f_year=
'$fiscal_year'
;
";

$result2 = mysql_query($query2) or die ("Couldn't execute query 2.  $query2");
$row2=mysql_fetch_array($result2);
extract($row2);


$exprev_count=number_format($exprev_count,2);
$exprev_amount=number_format($exprev_amount,2);
$pce_count=number_format($pce_count,2);
$pce_amount=number_format($pce_amount,2);




//$ware_total=($charge_amount+$credit_amount);
//$ware_total_new=number_format($ware_total,2);
//echo "ware_total=$ware_total<br />";//exit;
//echo "ware_total_new=$ware_total_new";exit;
//$charge_amount=number_format($charge_amount,2); 
//$credit_amount=number_format($credit_amount,2); 



//$net_amount=round($net_amount,2);
//$ware_total=number_format($net_amount,2);
//echo "charge_amount=$charge_amount<br />";//exit;
//echo "credit_amount=$credit_amount<br />";//exit;
//echo "ware_total=$ware_total";exit;

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
echo "<H1 ALIGN=LEFT > <font color=brown><i>$project_name-$step_group$step_num</font></i></H1>";
echo "<H2 ALIGN=center><font size=4><b><A href=/budget/admin/weekly_updates/main.php?project_category=fms&project_name=weekly_updates> Return Weekly Updates-HOME </A></font></H2>";
echo "<br />";
echo "<H3 ALIGN=LEFT > <font color=brown><i>$step_name</font></i></H3>";

echo "<form method=post action=stepG8m.php>";
echo "<table border=1>";
echo "<tr>";
echo "<th>exprev_amount</th><th>pce_amount</th><th>variancel</th><th>exprev_count</th><th>pce_count</th><th>variance2</th>";
echo "</tr>";
//if($ware_total_new=='0'){echo "<tr bgcolor='yellow'>";} else {echo "<tr bgcolor='red'>";}
echo "<tr>";
echo "<td>$exprev_amount</td><td>$pce_amount</td><td></td><td>$exprev_count</td><td>$pce_count</td><td></td>";
echo "</tr>";
//if($ware_total_new=='0'){echo "<td>Balanced</td>";} else {echo "<td font color='red'>Error</td>"; }

echo "<input type='hidden' name='project_category' value='$project_category'>";	
echo "<input type='hidden' name='project_name' value='$project_name'>";	
echo "<input type='hidden' name='step_group' value='$step_group'>";	   
echo "<input type='hidden' name='step_num' value='$step_num'>";	
echo "<input type='hidden' name='step_name' value='$step_name'>";	
echo "<input type='hidden' name='fiscal_year' value='$fiscal_year'>";	
echo "<input type='hidden' name='start_date' value='$start_date'>";	
echo "<input type='hidden' name='end_date' value='$end_date'>";	

echo "<td><input type=submit name=submit2 value=Update></td>";
echo "</tr>";
echo "</table>";


echo "<br /><br />";

echo "</form>";
echo "</html>"; }

if($submit2=="Update")
 //echo project_category='$project_category';
// echo project_name='$project_name';
 //echo step_group='$step_group';
// echo step_num='$step_num';exit;
 
 
 { //update weekly_updates_steps for date fields and status field
 $query23a="update budget.project_steps_detail set status='complete' where project_category='$project_category'
         and project_name='$project_name' and step_group='$step_group' and step_num='$step_num' ";
			 
mysql_query($query23a) or die ("Couldn't execute query 23a.  $query23a");

$query24="select * from budget.project_steps_detail
         where project_category='$project_category' and project_name='$project_name'
		 and step_group='$step_group'  and status='pending' "; 

$result24=mysql_query($query24) or die ("Couldn't execute query 24.  $query24");

$num24=mysql_num_rows($result24);

//echo "pending_items=$num4";exit;

//if($num4==0){echo "done"}; if ($num4!=0){echo "$num4 pending items"}; exit;



if($num24==0)

{$query25="update budget.project_steps set status='complete' where project_category='$project_category'
         and project_name='$project_name' and step_group='$step_group' ";
mysql_query($query25) or die ("Couldn't execute query 25.  $query25");}
mysql_close();

if($num24==0)

{header("location: main.php?project_category=$project_category&project_name=$project_name ");}

if($num24!=0)

{header("location: step_group.php?project_category=$project_category&project_name=$project_name&step_group=$step_group&fiscal_year=$fiscal_year&start_date=$start_date&end_date=$end_date");}

}
 
 
 ?>




























