<?php


session_start();
//echo "<pre>";print_r($_SESSION);echo "</pre>";  //exit;

echo "<pre>";print_r($_REQUEST);echo "</pre>"; exit;
$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempid=$_SESSION['budget']['tempID'];
//echo $tempid;
extract($_REQUEST);
$system_entry_date=date("Ymd");
//echo "<pre>";print_r($_REQUEST);"</pre>"; //exit;
//$start_date=str_replace("-","",$start_date);
//$end_date=str_replace("-","",$end_date);
//echo "start_date=$start_date";
//echo "<br />"; 
//echo "end_date=$end_date";exit;
$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
include("../../../include/activity.php");// database c

$start_date=str_replace("-","",$start_date);
$end_date=str_replace("-","",$end_date);


$query1a="select py1 as 'fiscal_year_py1' from fiscal_year where report_year='$fyear' ";
		 
//echo "query1a=$query1a<br />";		 

$result1a = mysqli_query($connection, $query1a) or die ("Couldn't execute query 1a.  $query1a");

$row1a=mysqli_fetch_array($result1a);
extract($row1a);

//echo "<br />fiscal_year_py1=$fiscal_year_py1<br />";

//exit;


$query1b="truncate table pfr_ws1 ";
		 
$result1b = mysqli_query($connection, $query1b) or die ("Couldn't execute query 1b.  $query1b");

$query1c="insert into pfr_ws1(center,f_year,gas_receipts)
          select center,'$fiscal_year_py1',sum(credit-debit) as 'gas_receipts' FROM `exp_rev` WHERE `acct` LIKE '434140003' AND `f_year`='$fiscal_year_py1' and center like '1680%' group by center";
		  
//echo "<br />query1c=$query1c<br />";		  

//exit;       
		 
$result1c = mysqli_query($connection, $query1c) or die ("Couldn't execute query 1c.  $query1c");


$query1d="insert into pfr_ws1(center,f_year,gas_expenses)
          select center,'$fiscal_year_py1',sum(debit-credit) as 'gas_expenses' FROM `exp_rev` WHERE `acct` LIKE '533800019' AND `f_year`='$fiscal_year_py1' and center like '1680%' group by center";

//echo "<br />query1d=$query1d<br />";		  

      
		 
$result1d = mysqli_query($connection, $query1d) or die ("Couldn't execute query 1d.  $query1d");


$query1e="insert into pfr_ws1(center,f_year,other_receipts)
          select center,'$fiscal_year_py1',sum(credit-debit) as 'other_receipts'
		  FROM `exp_rev` 
		  left join coa on exp_rev.acct=coa.ncasnum
		  WHERE coa.budget_group='pfr_revenues' and `acct` != '434140003' AND `f_year`='$fiscal_year_py1' and center like '1680%' group by center";

//echo "<br />query1e=$query1e<br />";		  

      
		 
$result1e = mysqli_query($connection, $query1e) or die ("Couldn't execute query 1e.  $query1e");


$query1f="insert into pfr_ws1(center,f_year,other_expenses)
          select center,'$fiscal_year_py1',sum(debit-credit) as 'other_expenses'
		  FROM `exp_rev` 
		  left join coa on exp_rev.acct=coa.ncasnum
		  WHERE coa.budget_group='pfr_expenses' and `acct` != '533800019' AND `f_year`='$fiscal_year_py1' and center like '1680%' group by center";

//echo "<br />query1f=$query1f<br />";		  

      
		 
$result1f = mysqli_query($connection, $query1f) or die ("Couldn't execute query 1f.  $query1f");







$query1g="truncate table pfr_ws2 ";
		 
$result1g = mysqli_query($connection, $query1g) or die ("Couldn't execute query 1g.  $query1g");

$query1h="insert into pfr_ws2(center,f_year,gas_receipts_py,other_receipts_py)
          select center,$fyear,sum(gas_receipts),sum(other_receipts)
		  from pfr_ws1 where 1
		  group by center";
		  
//echo "<br />query1h=$query1h<br />";		  

//exit;       
		 
$result1h = mysqli_query($connection, $query1h) or die ("Couldn't execute query 1h.  $query1h");


$query1h1="update pfr_ws2,center set pfr_ws2.parkcode=center.parkcode where pfr_ws2.center=center.new_center ";
		  
//echo "<br />query1h1=$query1h1<br />";		  

//exit;       
		 
$result1h1 = mysqli_query($connection, $query1h1) or die ("Couldn't execute query 1h1.  $query1h1");



$query1h2="update pfr_ws2,center set pfr_ws2.scope='park' where pfr_ws2.center=center.new_center and center.stateparkyn='y' ";
		  
//echo "<br />query1h2=$query1h2<br />";		  

//exit;       
		 
$result1h2 = mysqli_query($connection, $query1h2) or die ("Couldn't execute query 1h2.  $query1h2");


$query1h3="update pfr_ws2,center set pfr_ws2.pfr_center=center.pfr where pfr_ws2.center=center.new_center ";
		  
//echo "<br />query1h3=$query1h3<br />";		  

//exit;       
		 
$result1h3 = mysqli_query($connection, $query1h3) or die ("Couldn't execute query 1h3.  $query1h3");



$query1j="update pfr_ws2 set gas_receipts_target=gas_receipts_py,other_receipts_target=other_receipts_py where 1 and pfr_center='y' ";
		  
//echo "<br />query1j=$query1j<br />";		  

//exit;       
		 
$result1j = mysqli_query($connection, $query1j) or die ("Couldn't execute query 1j.  $query1j");


$query1j1="update pfr_ws2 set other_receipts_target='1000.00' where other_receipts_target < '1000.00' and pfr_center='y' ";
		  
//echo "<br />query1j1=$query1j1<br />";

$result1j1 = mysqli_query($connection, $query1j1) or die ("Couldn't execute query 1j1.  $query1j1");




$query1k="update pfr_ws2,pfr_target_markups
          set pfr_ws2.gas_markup=pfr_target_markups.gas_markup,pfr_ws2.other_markup=pfr_target_markups.other_markup 
		  where pfr_ws2.center=pfr_target_markups.center
		    ";
		  
//echo "<br />query1k=$query1k<br />";		  

//exit;       
		 
$result1k = mysqli_query($connection, $query1k) or die ("Couldn't execute query 1k.  $query1k");


$query1n="update pfr_ws2
          set gas_disburse_target=(gas_receipts_target)/(1+(gas_markup/100)),
		      other_disburse_target=(other_receipts_target)/(1+(other_markup/100))
		      where 1 and pfr_center='y' ";
		  
//echo "<br />query1n=$query1n<br />";		  

//exit;       
		 
$result1n = mysqli_query($connection, $query1n) or die ("Couldn't execute query 1n.  $query1n");


$query1p="update pfr_ws2
          set total_receipts_target=gas_receipts_target+other_receipts_target,
		      total_disburse_target=gas_disburse_target+other_disburse_target
			  where 1 and pfr_center='y' ";
		  
//echo "<br />query1p=$query1p<br />";		  

//exit;       
		 
$result1p = mysqli_query($connection, $query1p) or die ("Couldn't execute query 1p.  $query1p");


$query1r="update pfr_ws2
          set total_markup=((total_receipts_target/total_disburse_target)-1)*(100) where 1 and pfr_center='y' ";
		  
//echo "<br />query1r=$query1r<br />";		  

//exit;       
		 
$result1r = mysqli_query($connection, $query1r) or die ("Couldn't execute query 1r.  $query1r");


$query1s="delete from pfr_budgets where f_year='$fyear' ";
		  
//echo "<br />query1s=$query1s<br />";		  
//echo "<br />Line 208<br />";
//exit;       
		 
$result1s = mysqli_query($connection, $query1s) or die ("Couldn't execute query 1s.  $query1s");


$query1t="insert into pfr_budgets(`center`, `parkcode`, `scope`, `pfr_center`, `f_year`, `gas_receipts_py`, `gas_receipts_target`, `gas_markup`, `gas_disburse_target`, `other_receipts_py`, `other_receipts_target`, `other_markup`, `other_disburse_target`, `total_receipts_target`, `total_disburse_target`, `total_markup`, `total_receipts_target2`, `total_disburse_target2`, `total_markup2`, `last_update`, `update_by`) 
select `center`, `parkcode`, `scope`, `pfr_center`, `f_year`, `gas_receipts_py`, `gas_receipts_target`, `gas_markup`, `gas_disburse_target`, `other_receipts_py`, `other_receipts_target`, `other_markup`, `other_disburse_target`, `total_receipts_target`, `total_disburse_target`,`total_markup`,`total_receipts_target`,`total_disburse_target`, `total_markup`,'$system_entry_date','$tempid' from pfr_ws2 where 1 
order by `center` desc ";
		  
//echo "<br />query1t=$query1t<br />";		  
      
 
$result1t = mysqli_query($connection, $query1t) or die ("Couldn't execute query 1t.  $query1t");

//echo "<br />Line 223<br />"; exit;	

$query1u="update report_budget_history_inc_stmt_by_fyear_pfr as t1 ,pfr_budgets as t2 
          set t1.receipt_target=t2.total_receipts_target2,t1.disburse_target=t2.total_disburse_target2,t1.total_markup2=t2.total_markup2,t1.last_update=t2.last_update,t1.update_by=t2.update_by
		  where t1.center=t2.center and t1.f_year='$fyear' and t2.f_year='$fyear' ";
		  
//echo "<br />query1u=$query1u<br />";  exit;


mysqli_query($connection, $query1u) or die ("Couldn't execute query 1u. $query1u");




/*
$query1j="update pfr_ws2 set total_receipts_py=gas_receipts_py+other_receipts_py where 1";
		  
echo "<br />query1j=$query1j<br />";		  

//exit;       
		 
$result1j = mysqli_query($connection, $query1j) or die ("Couldn't execute query 1j.  $query1j");

$query1k="update pfr_ws2 set total_receipts_py=gas_receipts_py+other_receipts_py where 1";
		  
echo "<br />query1k=$query1k<br />";		  

//exit;       
		 
$result1k = mysqli_query($connection, $query1k) or die ("Couldn't execute query 1k.  $query1k");


$query1m="update pfr_ws2 set gas_perc=gas_receipts_py/total_receipts_py,other_perc=other_receipts_py/total_receipts_py where 1";
		  
echo "<br />query1m=$query1m<br />";		  

//exit;       
		 
$result1m = mysqli_query($connection, $query1m) or die ("Couldn't execute query 1m.  $query1m");


$query1n="update pfr_ws2,pfr_target_markups 
          set pfr_ws2.gas_markup=pfr_target_markups.gas_markup,pfr_ws2.other_markup=pfr_target_markups.other_markup
		  where pfr_ws2.center=pfr_target_markups.center and pfr_ws2.f_year=pfr_target_markups.f_year
		  and pfr_ws2.f_year='$fyear' and pfr_target_markups.f_year='$fyear' ";
		  
echo "<br />query1n=$query1n<br />";		  

//exit;       
		 
$result1n = mysqli_query($connection, $query1n) or die ("Couldn't execute query 1n.  $query1n");


$query1p="update pfr_ws2 set average_markup=(other_markup*other_perc+gas_markup*gas_perc) ";
		  
echo "<br />query1p=$query1p<br />";		  

//exit;       
		 
$result1p = mysqli_query($connection, $query1p) or die ("Couldn't execute query 1p.  $query1p");


$query1r="update pfr_ws2,center set pfr_ws2.parkcode=center.parkcode where pfr_ws2.center=center.new_center ";
		  
echo "<br />query1r=$query1r<br />";		  

//exit;       
		 
$result1r = mysqli_query($connection, $query1r) or die ("Couldn't execute query 1r.  $query1r");



$query1s="update pfr_ws2,center set pfr_ws2.scope='park' where pfr_ws2.center=center.new_center and center.stateparkyn='y' ";
		  
echo "<br />query1s=$query1s<br />";		  

//exit;       
		 
$result1s = mysqli_query($connection, $query1s) or die ("Couldn't execute query 1s.  $query1s");


$query1s1="update pfr_ws2,center set pfr_ws2.pfr_center=center.pfr where pfr_ws2.center=center.new_center ";
		  
echo "<br />query1s1=$query1s1<br />";		  

//exit;       
		 
$result1s1 = mysqli_query($connection, $query1s1) or die ("Couldn't execute query 1s1.  $query1s1");



$query1t="update pfr_ws2 set receipt_target=total_receipts_py where 1 and pfr_center='y' ";
		  
echo "<br />query1t=$query1t<br />";		  

//exit;       
		 
$result1t = mysqli_query($connection, $query1t) or die ("Couldn't execute query 1t.  $query1t");



$query1u="update pfr_ws2 set receipt_target='1000.00' where receipt_target < '1000.00' and pfr_center='y' ";
		  
echo "<br />query1u=$query1u<br />";		  

//exit;       
		 
$result1u = mysqli_query($connection, $query1u) or die ("Couldn't execute query 1u.  $query1u");



$query1v="update pfr_ws2 set disburse_target=(receipt_target)/(1+(average_markup/100)) where 1 and pfr_center='y' ";
		  
echo "<br />query1v=$query1v<br />";		  

//exit;       
		 
$result1v = mysqli_query($connection, $query1v) or die ("Couldn't execute query 1v.  $query1v");

*/










/*
$query7b="update report_budget_history_inc_stmt_by_fyear_pfr,pfr_ws2
set report_budget_history_inc_stmt_by_fyear_pfr.disburse_target=pfr_ws2.,
report_budget_history_inc_stmt_by_fyear_pfr.receipt_target=report_budget_history_inc_stmt_by_fyear_pfr_1819_budget_v4.total_revenue
where report_budget_history_inc_stmt_by_fyear_pfr.parkcode=report_budget_history_inc_stmt_by_fyear_pfr_1819_budget_v4.parkcode
and report_budget_history_inc_stmt_by_fyear_pfr_1819_budget_v4.f_year='1819'; ";

mysqli_query($connection, $query7b) or die ("Couldn't execute query 7b. $query7b");
*/







/*
$query8="";

mysqli_query($connection, $query8) or die ("Couldn't execute query 8. $query8");

$query9="";

mysqli_query($connection, $query9) or die ("Couldn't execute query 9. $query9");

$query10="";

mysqli_query($connection, $query10) or die ("Couldn't execute query 10. $query10");
*/



/* 
$query23a="update budget.project_steps_detail set status='complete' where project_category='$project_category' and project_name='$project_name' and step_group='$step_group' and step_num='$step_num' ";
			 
mysqli_query($connection, $query23a) or die ("Couldn't execute query 23a.  $query23a");

$query24="select * from budget.project_steps_detail
         where project_category='$project_category' and project_name='$project_name'
		 and step_group='$step_group'  and status='pending' "; 

$result24=mysqli_query($connection, $query24) or die ("Couldn't execute query 24.  $query24");

$num24=mysqli_num_rows($result24);

//echo "pending_items=$num4";exit;

//if($num4==0){echo "done"}; if ($num4!=0){echo "$num4 pending items"}; exit;
if($num24==0)

{$query25="update budget.project_steps set status='complete' where project_category='$project_category' and project_name='$project_name' and step_group='$step_group' ";
mysqli_query($connection, $query25) or die ("Couldn't execute query 25.  $query25");}

////mysql_close();

if($num24==0)

{header("location: main.php?project_category=$project_category&project_name=$project_name ");}

if($num24!=0)

{header("location: step_group.php?project_category=$project_category&project_name=$project_name&step_group=$step_group&fiscal_year=$fiscal_year&start_date=$start_date&end_date=$end_date");}
*/ 
//exit; 
{header("location: park_inc_stmts_by_fyear_v2.php?fyear=$fyear&scope=$scope&report_type=$report_type&tent_update=y");}




?>