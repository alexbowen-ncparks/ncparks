<?php
//echo "<pre>";print_r($_REQUEST);echo "</pre>";//exit;
session_start();
//echo "<pre>";print_r($_SESSION);echo "</pre>";exit;
$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempid=$_SESSION['budget']['tempID'];
//echo $tempid;
extract($_REQUEST);
//echo "<pre>";print_r($_REQUEST);"</pre>";

/*
echo "<br />back_date_yn=$back_date_yn<br />";
echo "<br />fiscal_year=$fiscal_year<br />";
echo "<br />start_date=$start_date<br />";
echo "<br />start_date2=$start_date2<br />";
echo "<br />end_date=$end_date<br />";
echo "<br />end_date2=$end_date2<br />";
echo "<br />first_day_of_fyear=$first_day_of_fyear<br />";
echo "<br />last_day_of_fyear=$last_day_of_fyear<br />";
*/

//exit;
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



if($back_date_yn=='n')
{

	
$query0="select cy,py1,py2,py3,py4 from fiscal_year where report_year='$fiscal_year' ";

$result0 = mysqli_query($connection, $query0) or die ("Couldn't execute query 0.  $query0");

$row0=mysqli_fetch_array($result0);
extract($row0);

/*
echo "<br />fiscal_year=$fiscal_year<br />";
echo "<br />cy=$cy<br />";
echo "<br />py1=$py1<br />";
echo "<br />py2=$py2<br />";
echo "<br />py3=$py3<br />";
echo "<br />py4=$py4<br />";
*/


//echo "<br />Line 65: back_date_yn=$back_date_yn<br />";

//exit;


$query1="truncate table report_project_expenditures_detail;
";
mysqli_query($connection, $query1) or die ("Couldn't execute query 1. $query1");

$query2="insert into report_project_expenditures_detail(
center_number,
project_number,
ncas_account_number,
ncas_account_name,
ncas_vendor_number,
vendor_name,
invoice_number,
invoice_amount,
post_date,
f_year)
select
center,
proj_num,
account,'',
concat(vendornum,'-',groupnum),
vendorname,
invoice,
amount,
datenew,
f_year
from partf_payments
order by datenew desc;
";
mysqli_query($connection, $query2) or die ("Couldn't execute query 2. $query2");

$query3="update report_project_expenditures_detail,coa
set report_project_expenditures_detail.ncas_account_name=
coa.park_acct_desc
where report_project_expenditures_detail.ncas_account_number=
coa.ncasnum;
";
mysqli_query($connection, $query3) or die ("Couldn't execute query 3. $query3");

$query4="truncate table report_project_expenditures_summary;
";
mysqli_query($connection, $query4) or die ("Couldn't execute query 4. $query4");

$query5="insert into report_project_expenditures_summary(
center_number,
project_number,
cy_amount)
select
center_number,
project_number,
sum(invoice_amount)
from report_project_expenditures_detail
where f_year='$cy'
group by center_number,project_number
order by center_number,project_number;
";
mysqli_query($connection, $query5) or die ("Couldn't execute query 5. $query5");

$query6="insert into report_project_expenditures_summary(
center_number,
project_number,
py1_amount)
select
center_number,
project_number,
sum(invoice_amount)
from report_project_expenditures_detail
where f_year='$py1'
group by center_number,project_number
order by center_number,project_number;
";
mysqli_query($connection, $query6) or die ("Couldn't execute query 6. $query6");

$query7="insert into report_project_expenditures_summary(
center_number,
project_number,
py2_amount)
select
center_number,
project_number,
sum(invoice_amount)
from report_project_expenditures_detail
where f_year='$py2'
group by center_number,project_number
order by center_number,project_number;
";
mysqli_query($connection, $query7) or die ("Couldn't execute query 7. $query7");

$query8="insert into report_project_expenditures_summary(
center_number,
project_number,
py3_amount)
select
center_number,
project_number,
sum(invoice_amount)
from report_project_expenditures_detail
where f_year='$py3'
group by center_number,project_number
order by center_number,project_number;
";
mysqli_query($connection, $query8) or die ("Couldn't execute query 8. $query8");

$query9="insert into report_project_expenditures_summary(
center_number,
project_number,
py4_amount)
select
center_number,
project_number,
sum(invoice_amount)
from report_project_expenditures_detail
where f_year='$py4'
group by center_number,project_number
order by center_number,project_number;
";
mysqli_query($connection, $query9) or die ("Couldn't execute query 9. $query9");

$query10="update report_project_expenditures_summary,center
set report_project_expenditures_summary.center_year_funded=center.f_year_funded
where report_project_expenditures_summary.center_number=center.center;
";
mysqli_query($connection, $query10) or die ("Couldn't execute query 10. $query10");

$query11="update report_project_expenditures_summary,center
set report_project_expenditures_summary.center_name=center.center_desc
where report_project_expenditures_summary.center_number=center.new_center;
";
mysqli_query($connection, $query11) or die ("Couldn't execute query 11. $query11");

$query12="update report_project_expenditures_summary,partf_projects
set report_project_expenditures_summary.district=partf_projects.dist
where report_project_expenditures_summary.project_number=partf_projects.projnum;
";
mysqli_query($connection, $query12) or die ("Couldn't execute query 12. $query12");

$query13="update report_project_expenditures_summary,partf_projects
set report_project_expenditures_summary.status=partf_projects.statusper
where report_project_expenditures_summary.project_number=partf_projects.projnum;
";
mysqli_query($connection, $query13) or die ("Couldn't execute query 13. $query13");

$query14="update report_project_expenditures_summary,partf_projects
set report_project_expenditures_summary.parkcode=partf_projects.park
where report_project_expenditures_summary.project_number=partf_projects.projnum;
";
mysqli_query($connection, $query14) or die ("Couldn't execute query 14. $query14");

$query15="update report_project_expenditures_summary,partf_projects
set report_project_expenditures_summary.project_name=partf_projects.projname
where report_project_expenditures_summary.project_number=partf_projects.projnum;
";
mysqli_query($connection, $query15) or die ("Couldn't execute query 15. $query15");

$query16="update report_project_expenditures_summary,partf_projects
set report_project_expenditures_summary.project_category=partf_projects.projcat
where report_project_expenditures_summary.project_number=partf_projects.projnum;
";
mysqli_query($connection, $query16) or die ("Couldn't execute query 16. $query16");

$query17="update report_project_expenditures_summary,partf_projects
set report_project_expenditures_summary.project_manager=partf_projects.manager
where report_project_expenditures_summary.project_number=partf_projects.projnum;
";
mysqli_query($connection, $query17) or die ("Couldn't execute query 17. $query17");

$query18="update report_project_expenditures_summary
set project_manager='na'
where project_manager='';
";
mysqli_query($connection, $query18) or die ("Couldn't execute query 18. $query18");

$query19="update report_project_expenditures_summary
set project_category='na'
where project_category='';
";
mysqli_query($connection, $query19) or die ("Couldn't execute query 19. $query19");

$query19b="update report_project_expenditures_summary
set parkcode='na'
where parkcode='';
";
mysqli_query($connection, $query19b) or die ("Couldn't execute query 19b. $query19b");

$query19c="update report_project_expenditures_summary
set district='na'
where district='';
";
mysqli_query($connection, $query19c) or die ("Couldn't execute query 19c. $query19c");

$query19d="update report_project_expenditures_summary
set center_name='na'
where center_name='';
";
mysqli_query($connection, $query19d) or die ("Couldn't execute query 19d. $query19d");

$query19e="update report_project_expenditures_summary
set project_name='na'
where project_name='';
";
mysqli_query($connection, $query19e) or die ("Couldn't execute query 19e. $query19e");

$query19f="update report_project_expenditures_summary
set status='na'
where status='';
";
mysqli_query($connection, $query19f) or die ("Couldn't execute query 19f. $query19f");

$query19g="update report_project_expenditures_summary
set project_number='na'
where project_number='';
";
mysqli_query($connection, $query19g) or die ("Couldn't execute query 19g. $query19g");

$query19h="update report_project_expenditures_summary
set center_number='na'
where center_number='';
";
mysqli_query($connection, $query19h) or die ("Couldn't execute query 19h. $query19h");

$query19i="update report_project_expenditures_summary
set center_year_funded='na'
where center_year_funded='';
";
mysqli_query($connection, $query19i) or die ("Couldn't execute query 19i. $query19i");

$query19j="truncate table report_project_expenditures_summary2;
";
mysqli_query($connection, $query19j) or die ("Couldn't execute query 19j. $query19j");

$query19k="insert into report_project_expenditures_summary2(
project_category,
district,
parkcode,
project_name,
project_manager,
status,
project_number,
center_number,
center_year_funded,
center_name,
cy_amount,
py1_amount,
py2_amount,
py3_amount,
total_amount)
select
project_category,
district,
parkcode,
project_name,
project_manager,
status,
project_number,
center_number,
center_year_funded,
center_name,
sum(cy_amount),
sum(py1_amount),
sum(py2_amount),
sum(py3_amount),
sum(cy_amount+py1_amount+py2_amount+py3_amount) as 'total_amount'
from report_project_expenditures_summary
where 1
group by center_number,project_number
order by parkcode;";

mysqli_query($connection, $query19k) or die ("Couldn't execute query 19k. $query19k");


}

//if($back_date_yn=='y'){echo "<br />Line 341: back_date_yn=$back_date_yn<br />"; exit;}



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

{$query25="update budget.project_steps set status='complete' where project_category='$project_category'
         and project_name='$project_name' and step_group='$step_group' ";
mysqli_query($connection, $query25) or die ("Couldn't execute query 25.  $query25");}
////mysql_close();

if($num24==0)

{header("location: main.php?project_category=$project_category&project_name=$project_name ");}

if($num24!=0)

{header("location: step_group.php?project_category=$project_category&project_name=$project_name&step_group=$step_group&fiscal_year=$fiscal_year&start_date=$start_date&end_date=$end_date");}

*/


?>