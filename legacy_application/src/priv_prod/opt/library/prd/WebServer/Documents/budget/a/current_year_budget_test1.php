<?php

session_start();

if(!$_SESSION["budget"]["tempID"]){echo "access denied";exit;
//header("location: /login_form.php?db=budget");
}

$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
include("../../../include/authBUDGET.inc");
print_r($_REQUEST);//exit;
//echo "<pre>";print_r($_SERVER);echo "<pre>";//exit;
//echo "<pre>";print_r($_SESSION);echo "<pre>";//exit;
include("../../../include/activity.php");
extract($_REQUEST);


$sql="SELECT DISTINCT (budget_group)
FROM coa
WHERE budget_group != 'land' AND budget_group != 'buildings' AND budget_group != 'reserves' AND budget_group != 'funding_receipt' AND budget_group != 'funding_disburse' AND budget_group != 'professional_services'
ORDER BY budget_group";

$result = mysqli_query($connection, $sql) or die ("Couldn't execute query 1. $sql");
while ($row=mysqli_fetch_array($result)){$bgArray[]=$row['budget_group'];}
//$bgArray=array(" ", "equipment","grants","operating_expenses","operating_revenues","payroll_permanent","payroll_temporary","purchase4resale","reimbursements","travel");

// *********** Level > 2 ************

include_once("../menu.php");
echo "<table align='center'><form action=\"current_year_budget_test1.php\">";

// Menu 000
echo "<tr>";
echo "<td><font color='green'>Current Year budget for</font> => Budget Group: <select name=\"budget_group_menu\">"; 
for ($n=0;$n<count($bgArray);$n++){
$con=$bgArray[$n];
if($budget_group_menu==$con){$s="selected";}else{$s="value";}
		echo "<option $s='$con'>$bgArray[$n]\n";
       }
   echo "</select></td>";
echo "</tr>";
echo "<input type='hidden' name='test' value='test2'>";
echo "</form>";  
echo "</table>";

?>



