<?php
//echo "<pre>";print_r($_REQUEST);echo "</pre>";//exit;
session_start();
//echo "<pre>";print_r($_SESSION);echo "</pre>";exit;
$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempid=$_SESSION['budget']['tempID'];
//echo $tempid;
extract($_REQUEST);
//echo "<pre>";print_r($_REQUEST);"</pre>"; //exit;
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

//echo "<br />Line 38: fiscal_year=$fiscal_year<br />";
//echo "<br />Line 39: back_date_yn=$back_date_yn<br />";
//exit;


if($back_date_yn=='n')
{
$query1="truncate table bd725_dpr_funding ";
			 
mysqli_query($connection, $query1) or die ("Couldn't execute query 1.  $query1");
//echo "<br /><br />query1=$query1<br /><br />";

$query2="insert into bd725_dpr_funding(fund,fund_descript,funding_total,funding_total_ptd)
SELECT fund,fund_descript,sum(total_budget),sum(ptd) FROM `bd725_dpr` where 1 and cash_type='receipt' and f_year='$fiscal_year' and dpr='y' group by fund ";
			 
mysqli_query($connection, $query2) or die ("Couldn't execute query 2.  $query2");
//echo "<br /><br />query2=$query2<br /><br />";

$query3="truncate table partf_dpr_funding ";
			 
mysqli_query($connection, $query3) or die ("Couldn't execute query 3.  $query3");
//echo "<br /><br />query3=$query3<br /><br />";

$query4="insert into partf_dpr_funding(fund,in_amount)
select fund_in,sum(amount)
from partf_fund_trans
where fund_in != ''
group by fund_in ";
			 
mysqli_query($connection, $query4) or die ("Couldn't execute query 4.  $query4");
//echo "<br /><br />query4=$query4<br /><br />";

$query5="insert into partf_dpr_funding(fund,out_amount)
select fund_out,sum(amount)
from partf_fund_trans
where fund_out != ''
group by fund_out ";
			 
mysqli_query($connection, $query5) or die ("Couldn't execute query 5.  $query5");
//echo "<br /><br />query5=$query5<br /><br />";

$query6="truncate table partf_dpr_funding2 ";
			 
mysqli_query($connection, $query6) or die ("Couldn't execute query 6.  $query6");
//echo "<br /><br />query6=$query6<br /><br />";

$query7="insert into partf_dpr_funding2(fund,amount)
select fund,sum(in_amount-out_amount)
from partf_dpr_funding
where 1
group by fund ";
			 
mysqli_query($connection, $query7) or die ("Couldn't execute query 7.  $query7");
//echo "<br /><br />query7=$query7<br /><br />";

$query8="update bd725_dpr_funding,partf_dpr_funding2
set bd725_dpr_funding.pft_table_amount=partf_dpr_funding2.amount
where bd725_dpr_funding.fund=partf_dpr_funding2.fund ";
			 
mysqli_query($connection, $query8) or die ("Couldn't execute query 8.  $query8");
//echo "<br /><br />query8=$query8<br /><br />";

$query9="update bd725_dpr,coa
set bd725_dpr.acct_cat=coa.acct_cat
where bd725_dpr.account=coa.ncasnum
and bd725_dpr.f_year='$fiscal_year'
and bd725_dpr.dpr='y' ";
			 
mysqli_query($connection, $query9) or die ("Couldn't execute query 9.  $query9");
//echo "<br /><br />query9=$query9<br /><br />";

$query10="truncate table bd725_dpr_funding_out_adjust ";
			 
mysqli_query($connection, $query10) or die ("Couldn't execute query 10.  $query10");
//echo "<br /><br />query10=$query10<br /><br />";

$query11="insert into bd725_dpr_funding_out_adjust(center,out_adjust,out_adjust_ptd)
select fund,sum(total_budget),sum(ptd)
from bd725_dpr
where dpr='y'
and f_year='$fiscal_year'
and cash_type='disburse'
and acct_cat='fun'
group by fund ";
			 
mysqli_query($connection, $query11) or die ("Couldn't execute query 11.  $query11");
//echo "<br /><br />query11=$query11<br /><br />";

$query12="update bd725_dpr_funding,bd725_dpr_funding_out_adjust
set bd725_dpr_funding.funding_out_adjust=bd725_dpr_funding_out_adjust.out_adjust,bd725_dpr_funding.funding_out_adjust_ptd=bd725_dpr_funding_out_adjust.out_adjust_ptd
where bd725_dpr_funding.fund=bd725_dpr_funding_out_adjust.center ";
			 
mysqli_query($connection, $query12) or die ("Couldn't execute query 12.  $query12");
//echo "<br /><br />query12=$query12<br /><br />";

$query13="update bd725_dpr_funding
set funding_net=funding_total-funding_out_adjust
where 1 ";
			 
mysqli_query($connection, $query13) or die ("Couldn't execute query 13.  $query13");
//echo "<br /><br />query13=$query13<br /><br />";


$query13a="update bd725_dpr_funding
set funding_net_ptd=funding_total_ptd-funding_out_adjust_ptd
where 1 ";
			 
mysqli_query($connection, $query13a) or die ("Couldn't execute query 13a.  $query13a");
//echo "<br /><br />query13a=$query13a<br /><br />";


$query13b="update bd725_dpr_funding
set funding_net_yes=funding_net
where funding_net >= funding_net_ptd ";
			 
mysqli_query($connection, $query13b) or die ("Couldn't execute query 13b.  $query13b");
//echo "<br /><br />query13b=$query13b<br /><br />";


$query13c="update bd725_dpr_funding
set funding_net_yes=funding_net_ptd
where funding_net_ptd >= funding_net ";
			 
mysqli_query($connection, $query13c) or die ("Couldn't execute query 13c.  $query13c");
//echo "<br /><br />query13c=$query13c<br /><br />";



$query14="update bd725_dpr_funding
set pft_table_adj=funding_net_yes-pft_table_amount
where 1 ";
			 
mysqli_query($connection, $query14) or die ("Couldn't execute query 14.  $query14");
//echo "<br /><br />query14=$query14<br /><br />";


$query15="update bd725_dpr_funding
set funding_type='fund_in'
where pft_table_adj > '0.00' ";
			 
mysqli_query($connection, $query15) or die ("Couldn't execute query 15.  $query15");
//echo "<br /><br />query15=$query15<br /><br />";

$query16="update bd725_dpr_funding
set funding_type='fund_out'
where pft_table_adj < '0.00' ";
			 
mysqli_query($connection, $query16) or die ("Couldn't execute query 16.  $query16");
//echo "<br /><br />query16=$query16<br /><br />";

$query17="update bd725_dpr_funding
set funding_amount=pft_table_adj
where funding_type='fund_in' ";
			 
mysqli_query($connection, $query17) or die ("Couldn't execute query 17.  $query17");
//echo "<br /><br />query17=$query17<br /><br />";

$query18="update bd725_dpr_funding
set funding_amount=-pft_table_adj
where funding_type='fund_out' ";
			 
mysqli_query($connection, $query18) or die ("Couldn't execute query 18.  $query18");
//echo "<br /><br />query18=$query18<br /><br />";

$query19="truncate table bd725_dpr_projcount ";
			 
mysqli_query($connection, $query19) or die ("Couldn't execute query 19.  $query19");
//echo "<br /><br />query19=$query19<br /><br />";


$query20="insert into bd725_dpr_projcount(fund,projcount)
select center,count(partfid)
from partf_projects
where reportdisplay='y'
group by center ";
			 
mysqli_query($connection, $query20) or die ("Couldn't execute query 20.  $query20");
//echo "<br /><br />query20=$query20<br /><br />";


$query21="update bd725_dpr_projcount,partf_projects
set bd725_dpr_projcount.projnum=partf_projects.projnum
where bd725_dpr_projcount.fund=partf_projects.center
and bd725_dpr_projcount.projcount='1'
and partf_projects.reportdisplay='y' ";
			 
mysqli_query($connection, $query21) or die ("Couldn't execute query 21.  $query21");
//echo "<br /><br />query21=$query21<br /><br />";

$query22="update bd725_dpr_funding,bd725_dpr_projcount
set bd725_dpr_funding.funding_projnum=bd725_dpr_projcount.projnum
where bd725_dpr_funding.fund=bd725_dpr_projcount.fund
and bd725_dpr_projcount.projcount='1' ";
			 
mysqli_query($connection, $query22) or die ("Couldn't execute query 22.  $query22");
//echo "<br /><br />query22=$query22<br /><br />";

$query22a="update bd725_dpr_funding,bd725_dpr_projcount
set bd725_dpr_funding.funding_projcount=bd725_dpr_projcount.projcount
where bd725_dpr_funding.fund=bd725_dpr_projcount.fund ";
			 
mysqli_query($connection, $query22a) or die ("Couldn't execute query 22a.  $query22a");
//echo "<br /><br />query22a=$query22a<br /><br />";

$query22b="update bd725_dpr_funding,center
set bd725_dpr_funding.center_table='y'
where bd725_dpr_funding.fund=center.new_center ";
			 
mysqli_query($connection, $query22b) or die ("Couldn't execute query 22b.  $query22b");
//echo "<br /><br />query22b=$query22b<br /><br />";

$query22c="update bd725_dpr_funding,partf_projects
           set bd725_dpr_funding.funding_projnum=partf_projects.projnum
           where bd725_dpr_funding.funding_projcount != '1' and bd725_dpr_funding.funding_projnum=''
		   and bd725_dpr_funding.fund=partf_projects.center
		   and partf_projects.reportdisplay='y'
           and partf_projects.funding_default_project='y'   ";
			 
mysqli_query($connection, $query22c) or die ("Couldn't execute query 22c.  $query22c");
//echo "<br /><br />query22c=$query22c<br /><br />";

$query22d="update bd725_dpr_funding set record_complete='n' where funding_type != '' and funding_projnum = ''   ";
			 
mysqli_query($connection, $query22d) or die ("Couldn't execute query 22d.  $query22d");
//echo "<br /><br />query22d=$query22d<br /><br />";

}


//echo "<br /><br />Line 213<br /><br />";
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