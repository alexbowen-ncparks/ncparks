<?php
//echo "<pre>";print_r($_REQUEST);echo "</pre>";//exit;
session_start();
//echo "<pre>";print_r($_SESSION);echo "</pre>";exit;
$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempid=$_SESSION['budget']['tempID'];
//echo $tempid;
extract($_REQUEST);
//echo "<pre>";print_r($_REQUEST);"</pre>"; exit;
//$start_date=str_replace("-","",$start_date);
//$end_date=str_replace("-","",$end_date);
//$today_date=date("Ymd");
//echo "start_date=$start_date";
//echo "<br />"; 
//echo "end_date=$end_date";//exit;
//echo "<br />"; 
//echo "today_date=$today_date";exit;

/*
$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
include("../../../../include/activity.php");// database connection parameters
//echo "submit1=$submit1";echo "submit2=$submit2";exit;
*/

//$start_date=str_replace("-","",$start_date);
//$end_date=str_replace("-","",$end_date);
//$today_date=date("Ymd");


//echo "<br />start_date=$start_date<br />";
//echo "<br />"; 
//echo "<br />end_date=$end_date<br />"; //exit;
$query1="delete from exp_rev_funding_by_fyear where f_year='$fiscal_year' ";
			 
mysqli_query($connection, $query1) or die ("Couldn't execute query 1.  $query1");

//echo "<br /><br />query1=$query1<br /><br />";

$query2="insert into exp_rev_funding_by_fyear(f_year,center,account_number,account_description,cash_type,naspd_funding_type,amount)
         SELECT t1.f_year,t1.center,t1.acct,t2.account_description,t2.cash_type,t2.naspd_funding_type,sum(t1.credit-t1.debit)
		 from exp_rev as t1 
		 left join bd725_dpr_accounts as t2 on t1.acct=t2.account 
		 where t2.acct_cat='fun' and t1.center not like '1280%' and t1.center not like '1680% ' and t1.f_year='$fiscal_year' 
		 group by t1.f_year,t1.center,t1.acct ";
			 
mysqli_query($connection, $query2) or die ("Couldn't execute query 2.  $query2");
//echo "<br /><br />query2=$query2<br /><br />";


$query2a="insert into exp_rev_funding_by_fyear(f_year,center,account_number,account_description,cash_type,naspd_funding_type,amount)
         select '$fiscal_year',center,'none','appropriated','receipt','approp',amount
         from appropriated_revenues_non1280
         where 1 ";
			 
mysqli_query($connection, $query2a) or die ("Couldn't execute query 2a.  $query2a");
//echo "<br /><br />query2a=$query2a<br /><br />";


$query3="delete from exp_rev_funding_by_fyear where center like '1680%'  ";
			 
mysqli_query($connection, $query3) or die ("Couldn't execute query 3.  $query3");
//echo "<br /><br />query3=$query3<br /><br />";


$query4="delete from exp_rev_funding_by_fyear where center like '1685%'  ";
			 
mysqli_query($connection, $query4) or die ("Couldn't execute query 4.  $query4");
//echo "<br /><br />query4=$query4<br /><br />";


$query5="truncate table exp_rev_funding_by_fyear_summary";
			 
mysqli_query($connection, $query5) or die ("Couldn't execute query 5.  $query5");
//echo "<br /><br />query5=$query5<br /><br />";



$query6="insert into exp_rev_funding_by_fyear_summary(center,account_number,account_description,cash_type,naspd_funding_type,fiscal_years,amount)
         select center,account_number,account_description,cash_type,naspd_funding_type,count(f_year),sum(amount)
         from exp_rev_funding_by_fyear
         group by center,account_number		 ";
			 
mysqli_query($connection, $query6) or die ("Couldn't execute query 6.  $query6");
//echo "<br /><br />query6=$query6<br /><br />";


$query7="truncate table bd725_dpr_accounts_by_center";
			 
mysqli_query($connection, $query7) or die ("Couldn't execute query 7.  $query7");
//echo "<br /><br />query7=$query7<br /><br />";

$query8="insert into bd725_dpr_accounts_by_center(center,account,account_description,cash_type,naspd_funding_type,fyear_last)
select t1.fund,t1.account,t2.account_description,t2.cash_type,t2.naspd_funding_type,max(t1.f_year)
from bd725_dpr as t1
left join bd725_dpr_accounts as t2 on t1.account=t2.account
where 1
and t1.dpr='y' and t2.acct_cat='fun' and t1.f_year != 'pre0001'
group by t1.fund,t1.account";
			 
mysqli_query($connection, $query8) or die ("Couldn't execute query 8.  $query8");
//echo "<br /><br />query8=$query8<br /><br />";





$query8a="insert into bd725_dpr_accounts_by_center(center,account,account_description,cash_type,naspd_funding_type,fyear_last,total_budget,total_actual,approp_funding)
          select t1.center,'none','appropriated','receipt','approp',max(t2.f_year),t1.amount,t1.amount,'y'
          from appropriated_revenues_non1280 as t1
          left join bd725_dpr as t2 on t1.center=t2.fund
          where t2.f_year != 'pre0001'
          group by t1.center ";

			 
mysqli_query($connection, $query8a) or die ("Couldn't execute query 8a.  $query8a");
//echo "<br /><br />query8a=$query8a<br /><br />";



$query8b="update appropriated_revenues_non1280 as t1,bd725_dpr_accounts_by_center as t2
          set t1.fyear_last=t2.fyear_last
		  where t1.center=t2.center ";
			 
mysqli_query($connection, $query8b) or die ("Couldn't execute query 8b.  $query8b");
//echo "<br /><br />query8b=$query8b<br /><br />";





$query9="update bd725_dpr_accounts_by_center as t1,bd725_dpr as t2
         set t1.total_budget=t2.total_budget,t1.total_actual=t2.ptd
		 where t1.account=t2.account
		 and t1.fyear_last=t2.f_year
		 and t1.center=t2.fund
		 and t2.dpr='y' ";
			 
mysqli_query($connection, $query9) or die ("Couldn't execute query 9.  $query9");
//echo "<br /><br />query9=$query9<br /><br />";


$query10="update bd725_dpr_accounts_by_center as t1,exp_rev_funding_by_fyear_summary as t2
         set t1.total_exp_rev=t2.amount
		 where t1.account=t2.account_number
		 and t1.center=t2.center
		 ";
			 
mysqli_query($connection, $query10) or die ("Couldn't execute query 10.  $query10");
//echo "<br /><br />query10=$query10<br /><br />";


$query10a="update bd725_dpr_accounts_by_center as t1,bd725_dpr as t2
         set t1.center_description=t2.fund_descript
		 where t1.center=t2.fund
		 and t1.fyear_last=t2.f_year ";
			 
mysqli_query($connection, $query10a) or die ("Couldn't execute query 10a.  $query10a");
//echo "<br /><br />query10a=$query10a<br /><br />";







//exit;

/*
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

{$query25="update budget.project_steps set status='complete',time_complete=unix_timestamp(now())
where project_category='$project_category' and project_name='$project_name' and step_group='$step_group' ";
		 
mysqli_query($connection, $query25) or die ("Couldn't execute query 25.  $query25");
}
////mysql_close();

if($num24==0)

{header("location: main.php?project_category=$project_category&project_name=$project_name ");}

if($num24!=0)

{header("location: step_group.php?project_category=$project_category&project_name=$project_name&step_group=$step_group&fiscal_year=$fiscal_year&start_date=$start_date&end_date=$end_date");}

*/


?>