<?php

session_start();

if(!$_SESSION["budget"]["tempID"]){echo "access denied";exit;
}

$database="budget";
include("../../../include/auth.inc");

include("../menu.php");
include("../~f_year.php");
$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database

//include("../../../include/activity.php");

extract($_REQUEST);
//echo "<pre>2";print_r($_SESSION);echo "<pre>"; //exit;
//print_r($_REQUEST);exit;

if(!isset($report) AND !isset($center) AND !isset($budget_group_menu))
	{$report=3;}

$centerS=$_SESSION['budget']['centerSess'];
$level=$_SESSION['budget']['level'];

// ******** CID Main Menu *************   Non-Admin  Invoices
/*
$menuArray0=array("Request Budgets"=>"/budget/a/park_budget_menu.php?center=$centerS","View Current Year Budgets"=>"/budget/a/park_budget_menu.php?report=3", "Year2Year Comparison"=>"/budget/aDiv/year2year_comparison_center.php");
*/



$menuArray0=array("View Current Year Budgets"=>"/budget/a/park_budget_menu.php?report=3", "Year2Year Comparison"=>"/budget/aDiv/year2year_comparison_center.php");


//

/*
if($level>3){
$menuArray1=array("Equipment"=>"/budget/aDiv/park_equip_request.php?center=$centerS&m=1&submit=Submit","Operating Expenses"=>"/budget/a/op_exp_approval.php?m=1","Seasonal Payroll"=>"/budget/aDiv/seasonal_payroll.php");}else{
$menuArray1=array("Equipment"=>"/budget/aDiv/park_equip_request.php?center=$centerS&m=1&submit=Submit","Operating Expenses"=>"/budget/a/op_exp_approval.php?m=1","Seasonal Payroll"=>"/budget/aDiv/seasonal_payroll.php?submit=Submit&f_year=$f_year","Purchase Approval"=>"/budget/aDiv/park_purchase_request.php?submit=Submit&f_year=$f_year");
}
*/

if($level>3){
$menuArray1=array("Equipment"=>"/budget/aDiv/park_equip_request.php?center=$centerS&m=1&submit=Submit");}else{
$menuArray1=array("Equipment"=>"/budget/aDiv/park_equip_request.php?center=$centerS&m=1&submit=Submit");
}


echo "<td><form><select name=\"ref\" onChange=\"MM_jumpMenu('parent',this,0)\"><option selected>Submenus for Park Budgets</option>";$s="value";
foreach($menuArray0 as $k => $v){
		echo "<option $s='$v'>$k\n";
       }
   echo "</select></form></td>";
   
if(@$center!="" and @$budget_group_menu==""){
echo "<td><form><select name=\"ref\" onChange=\"MM_jumpMenu('parent',this,0)\"><option selected>Requests for</option>";$s="value";
foreach($menuArray1 as $k => $v){
		echo "<option $s='$v'>$k\n";
       }
   echo "</select></form></td>";}
   

//if($report=="4"){echo "Hello";exit; include("account_deficits.php");}
   
   echo "</tr></table>";

$m=1;
if(@$report=="2"){ include("center_level_budgets.php");}
if(@$report=="3"){ include("current_year_budget.php");}
if(@$report=="5")
	{
	if($level==2)
		{
		$distCode=$_SESSION['budget']['select'];
		switch($distCode){
		case "EADI":
		$distCode="east";
		break;
		case "NODI":
		$distCode="north";
		break;
		case "SODI":
		$distCode="south";
		break;
		case "WEDI":
		$distCode="west";
		break;
		}
		include("current_year_budget_div.php");exit;
		}
	
	else{
	include("current_year_budget_div.php");}
	}// end 5

if(@$report=="6"){ include("account_deficits.php");}
?>