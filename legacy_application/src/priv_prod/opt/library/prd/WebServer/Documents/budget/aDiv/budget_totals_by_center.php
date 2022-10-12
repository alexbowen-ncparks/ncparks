<?php

session_start();
$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempid=$_SESSION['budget']['tempID'];
extract($_REQUEST);
echo "<pre>";print_r($_REQUEST);echo "</pre>";//exit;

$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
include("../../../include/activity.php");// database connection parameters

if($submit=="")

{

echo "<html>";
echo "<head>";
echo "<title> Project Copy </title>";

echo "<style type='text/css'>

body { background-color: cornsilk; }
table { background-color: cornsilk; font-color: blue; font-size: 10;}
TH{font-family: Arial; font-size: 15pt;}
TD{font-family: Arial; font-size: 15pt;}
</style>";

echo "</head>";
echo "<body bgcolor=#FFF8DC>";
echo "<H1 ALIGN=LEFT > <font color=brown><i>Budget Group Totals by Fiscal Year</i> </font></H1>";

echo
"<form method=post action=budget_totals_by_center.php>";
echo "<font size=5>"; 
echo "Fiscal Year <input name='fiscal_year' type='text' id='fiscal_year'>";

//echo "<br /><br />";


echo "<input type=submit name=submit value=VIEW>";
echo "</form>";



echo "</body>";
echo "</html>";
}

if($submit=="VIEW")
{
$query1="truncate table report_budget_history_budget_group"; 
mysqli_query($connection, $query1) or die ("Couldn't execute query 1. $query1");
echo "Query1 $query1 ran successfully <br /><br />";


$query2="insert into report_budget_history_budget_group (f_year,parkcode,center,section,budget_group,cash_type,amount) 
select f_year,parkcode,center,section,budget_group,cash_type,-sum(amount) 
from report_budget_history 
where 1 and cash_type='disburse' and f_year='$fiscal_year' group by f_year,center,budget_group";

mysqli_query($connection, $query2) or die ("Couldn't execute query 2. $query2");
echo "Query2 $query2 ran successfully <br /><br />";


$query3="insert into report_budget_history_budget_group (f_year,parkcode,center,section,budget_group,cash_type,amount) 
select f_year,parkcode,center,section,budget_group,cash_type,sum(amount) 
from report_budget_history 
where 1 and cash_type='receipt' and f_year='$fiscal_year' group by f_year,center,budget_group";

mysqli_query($connection, $query3) or die ("Couldn't execute query 3. $query3");
echo "Query3 $query3 ran successfully <br /><br />";



$query4="truncate table report_budget_history_budget_group2";
mysqli_query($connection, $query4) or die ("Couldn't execute query 4. $query4");
echo "Query4 $query4 ran successfully <br /><br />";


$query5="insert into report_budget_history_budget_group2 (center) 
select distinct center from report_budget_history_budget_group 
where f_year='$fiscal_year'  order by parkcode";

mysqli_query($connection, $query5) or die ("Couldn't execute query 5. $query5");
echo "Query5 $query5 ran successfully <br /><br />";

$query6="update report_budget_history_budget_group2
         set f_year='$fiscal_year' where 1 ";

mysqli_query($connection, $query6) or die ("Couldn't execute query 6. $query6");
echo "Query6 $query6 ran successfully <br /><br />";

$query7="update report_budget_history_budget_group2,center
         set report_budget_history_budget_group2.park=center.parkcode,
		 report_budget_history_budget_group2.section=center.section
		 where report_budget_history_budget_group2.center=center.center ";

mysqli_query($connection, $query7) or die ("Couldn't execute query 7. $query7");
echo "Query7 $query7 ran successfully <br /><br />";


$query8="update report_budget_history_budget_group2,report_budget_history_budget_group 
set report_budget_history_budget_group2.operating_revenues= report_budget_history_budget_group.amount 
where report_budget_history_budget_group2.park= report_budget_history_budget_group.parkcode 
and report_budget_history_budget_group.budget_group='operating_revenues' 
and report_budget_history_budget_group.f_year='$fiscal_year'; ";

mysqli_query($connection, $query8) or die ("Couldn't execute query 8. $query8");
echo "Query8 $query8 ran successfully <br /><br />";


$query9="update report_budget_history_budget_group2,report_budget_history_budget_group 
set report_budget_history_budget_group2.pfr_revenues= 
report_budget_history_budget_group.amount 
where report_budget_history_budget_group2.park= report_budget_history_budget_group.parkcode 
and report_budget_history_budget_group.budget_group='purchase4resale_revenues' 
and report_budget_history_budget_group.f_year='$fiscal_year'; ";
mysqli_query($connection, $query9) or die ("Couldn't execute query 9. $query9");
echo "Query9 $query9 ran successfully <br /><br />";

$query10="update report_budget_history_budget_group2,report_budget_history_budget_group 
set report_budget_history_budget_group2.reimbursements= 
report_budget_history_budget_group.amount 
where report_budget_history_budget_group2.park= report_budget_history_budget_group.parkcode 
and report_budget_history_budget_group.budget_group='reimbursements' 
and report_budget_history_budget_group.f_year='$fiscal_year'; ";
mysqli_query($connection, $query10) or die ("Couldn't execute query 10. $query10");
echo "Query10 $query10 ran successfully <br /><br />";

$query11="update report_budget_history_budget_group2,report_budget_history_budget_group 
set report_budget_history_budget_group2.operating_expenses= 
report_budget_history_budget_group.amount 
where report_budget_history_budget_group2.park= report_budget_history_budget_group.parkcode 
and report_budget_history_budget_group.budget_group='operating_expenses' 
and report_budget_history_budget_group.f_year='$fiscal_year'; ";
mysqli_query($connection, $query11) or die ("Couldn't execute query 11. $query11");
echo "Query11 $query11 ran successfully <br /><br />";

$query12="update report_budget_history_budget_group2,report_budget_history_budget_group 
set report_budget_history_budget_group2.pfr_expenses= 
report_budget_history_budget_group.amount 
where report_budget_history_budget_group2.park= report_budget_history_budget_group.parkcode 
and report_budget_history_budget_group.budget_group='purchase4resale_expenses' 
and report_budget_history_budget_group.f_year='$fiscal_year'; ";
mysqli_query($connection, $query12) or die ("Couldn't execute query 12. $query12");
echo "Query12 $query12 ran successfully <br /><br />";

$query13="update report_budget_history_budget_group2,report_budget_history_budget_group 
set report_budget_history_budget_group2.equipment= 
report_budget_history_budget_group.amount 
where report_budget_history_budget_group2.park= report_budget_history_budget_group.parkcode 
and report_budget_history_budget_group.budget_group='equipment' 
and report_budget_history_budget_group.f_year='$fiscal_year'; ";
mysqli_query($connection, $query13) or die ("Couldn't execute query 13. $query13");
echo "Query13 $query13 ran successfully <br /><br />";

$query14="update report_budget_history_budget_group2,report_budget_history_budget_group 
set report_budget_history_budget_group2.payroll_temporary= 
report_budget_history_budget_group.amount 
where report_budget_history_budget_group2.park= report_budget_history_budget_group.parkcode 
and report_budget_history_budget_group.budget_group='payroll_temporary' 
and report_budget_history_budget_group.f_year='$fiscal_year'; ";
mysqli_query($connection, $query14) or die ("Couldn't execute query 14. $query14");
echo "Query14 $query14 ran successfully <br /><br />";

$query15="update report_budget_history_budget_group2,report_budget_history_budget_group 
set report_budget_history_budget_group2.payroll_temporary_receipt= 
report_budget_history_budget_group.amount 
where report_budget_history_budget_group2.park= report_budget_history_budget_group.parkcode 
and report_budget_history_budget_group.budget_group='payroll_temporary_receipt' 
and report_budget_history_budget_group.f_year='$fiscal_year'; ";
mysqli_query($connection, $query15) or die ("Couldn't execute query 15. $query15");
echo "Query15 $query15 ran successfully <br /><br />";

$query16="update report_budget_history_budget_group2,report_budget_history_budget_group 
set report_budget_history_budget_group2.payroll_permanent= 
report_budget_history_budget_group.amount 
where report_budget_history_budget_group2.park= report_budget_history_budget_group.parkcode 
and report_budget_history_budget_group.budget_group='payroll_permanent' 
and report_budget_history_budget_group.f_year='$fiscal_year'; ";
mysqli_query($connection, $query16) or die ("Couldn't execute query 16. $query16");
echo "Query16 $query16 ran successfully <br /><br />";

$query17="update report_budget_history_budget_group2,report_budget_history_budget_group 
set report_budget_history_budget_group2.travel= 
report_budget_history_budget_group.amount 
where report_budget_history_budget_group2.park= report_budget_history_budget_group.parkcode 
and report_budget_history_budget_group.budget_group='travel' 
and report_budget_history_budget_group.f_year='$fiscal_year'; ";
mysqli_query($connection, $query17) or die ("Couldn't execute query 17. $query17");
echo "Query17 $query17 ran successfully <br /><br />";

$query18="update report_budget_history_budget_group2,report_budget_history_budget_group 
set report_budget_history_budget_group2.other_expenses= 
report_budget_history_budget_group.amount 
where report_budget_history_budget_group2.park= report_budget_history_budget_group.parkcode 
and report_budget_history_budget_group.budget_group='other_expenses' 
and report_budget_history_budget_group.f_year='$fiscal_year'; ";
mysqli_query($connection, $query18) or die ("Couldn't execute query 18. $query18");
echo "Query18 $query18 ran successfully <br /><br />";

$query19="update report_budget_history_budget_group2,report_budget_history_budget_group 
set report_budget_history_budget_group2.aid= 
report_budget_history_budget_group.amount 
where report_budget_history_budget_group2.park= report_budget_history_budget_group.parkcode 
and report_budget_history_budget_group.budget_group='aid' 
and report_budget_history_budget_group.f_year='$fiscal_year'; ";
mysqli_query($connection, $query19) or die ("Couldn't execute query 19. $query19");
echo "Query19 $query19 ran successfully <br /><br />";

$query19a="update report_budget_history_budget_group2,report_budget_history_budget_group 
set report_budget_history_budget_group2.buildings= 
report_budget_history_budget_group.amount 
where report_budget_history_budget_group2.park= report_budget_history_budget_group.parkcode 
and report_budget_history_budget_group.budget_group='buildings' 
and report_budget_history_budget_group.f_year='$fiscal_year'; ";
mysqli_query($connection, $query19a) or die ("Couldn't execute query 19a. $query19a");
echo "Query19a $query19a ran successfully <br /><br />";



$query20="update report_budget_history_budget_group2,report_budget_history_budget_group 
set report_budget_history_budget_group2.funding_receipt= 
report_budget_history_budget_group.amount 
where report_budget_history_budget_group2.park= report_budget_history_budget_group.parkcode 
and report_budget_history_budget_group.budget_group='funding_receipt' 
and report_budget_history_budget_group.f_year='$fiscal_year'; ";
mysqli_query($connection, $query20) or die ("Couldn't execute query 20. $query20");
echo "Query20 $query20 ran successfully <br /><br />";

}
/*

 echo "OK";
 */
 
 ?>








