<?php

session_start();

if(!$_SESSION["budget"]["tempID"]){echo "access denied";exit;
//header("location: https://10.35.152.9/login_form.php?db=budget");
}

$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
include("../../../include/authBUDGET.inc");
//print_r($_REQUEST);//exit;
//echo "<pre>";print_r($_SERVER);echo "<pre>";//exit;
//echo "<pre>";print_r($_SESSION);echo "<pre>";//exit;
include("../../../include/activity.php");
extract($_REQUEST);

if(@$f_year==""){include("../~f_year.php");}

$sql="Select date_format(max(acctdate),'%m/%d/%Y') as maxDate from exp_rev where 1";
 $result = @mysqli_query($connection, $sql,$connection);
$row=mysqli_fetch_array($result); extract($row);
//echo "menu=$menu";
if(@$menu=="mmc") {include("../menus4.php");}

else

{
if(@$rep=="")
	{
	if(!isset($budget_group_menu)){$budget_group_menu="";}
	if($budget_group_menu!=""){include("park_budget_menu.php");}
	}
	
}


//print_r($_REQUEST);
//echo "<pre>"; print_r($_SESSION); echo "</pre>"; // exit;

if(!isset($center)){$center="";}
$checkCenter=strpos($center,"-");
if($checkCenter>0){
$parse=explode("-",$center);
$center=$parse[2];}

// Construct Query to be passed to Excel Export
if(!isset($acct_cat_menu)){$acct_cat_menu="";}
if(!isset($track_rcc_menu)){$track_rcc_menu="";}
$budget_group_menuEncode=urlencode($budget_group_menu);
$varQuery="submit=Submit&center=$center&track_rcc_menu=$track_rcc_menu&acct_cat_menu=$acct_cat_menu&budget_group_menu=$budget_group_menuEncode&f_year=$f_year";

if(@$rep=="excel"){header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment; filename=curren_year_budget.xls');
}

// Get menu values for Budget Group
if($level==1){$bgArray[]="";}
$sql="SELECT DISTINCT (budget_group)
FROM coa
WHERE budget_group != 'land' AND budget_group != 'buildings' AND budget_group != 'reserves' AND budget_group != 'funding_receipt' AND budget_group != 'funding_disburse' AND budget_group != 'professional_services'
ORDER BY budget_group";

$result = mysqli_query($connection, $sql) or die ("Couldn't execute query 1. $sql");
while ($row=mysqli_fetch_array($result)){$bgArray[]=$row['budget_group'];}
//$bgArray=array(" ", "equipment","grants","operating_expenses","operating_revenues","payroll_permanent","payroll_temporary","purchase4resale","reimbursements","travel");

// *********** Level > 2 ************
if($_SESSION['budget']['level']>2){//print_r($_REQUEST);EXIT;


if(@$rep==""){
include_once("../menu.php");
echo "<table align='center'><form action=\"current_year_budget_test2.php\">";

// Menu 000
echo "<td><font color='green'>Current Year budget for</font> => Budget Group: <select name=\"budget_group_menu\">"; 
for ($n=0;$n<count($bgArray);$n++){
$con=$bgArray[$n];
if($budget_group_menu==$con){$s="selected";}else{$s="value";}
		echo "<option $s='$con'>$bgArray[$n]\n";
       }
   echo "</select></td>";
   
   
$sql="SELECT section,parkcode,center as varCenter from center where fund='1280' order by section,parkcode,center";
$result = mysqli_query($connection, $sql) or die ("Couldn't execute query 1. $sql");
while ($row=mysqli_fetch_array($result)){
extract($row);$pc[]=$parkcode;$c[]=$varCenter;$sec[]=$section;}

if(!isset($lev1)){$lev1="";}
if(!isset($lev2)){$lev2="";}
echo "<td>$lev1 $lev2<select name=\"center\"><option selected>Select Center</option>";
for ($n=0;$n<count($c);$n++)
	{
	if(@$center==$c[$n])
		{$s="selected";$passParkcode=$pc[$n];}else{$s="value";}
	$con=$c[$n];
			echo "<option $s='$con'>$sec[$n]-$pc[$n]-$c[$n]</option>\n";
		   }
   echo "</select></td>";
   
         
  if($budget_group_menu=="equipment"){echo "<td>View Approved  <a href='/budget/aDiv/equipment_division.php?passParkcode=$passParkcode&passLevel=1&pay_center=$center&f_year=$f_year&division_approved=y&submit=Submit'>Equipment Items</a></td>";}
  
echo "<td><input type='submit' name='submit' value='Submit'></form></td>";

if(@$submit)
	{
	if(!isset($link_parkcode)){$link_parkcode="";}
	echo "<td>Excel <a href='current_year_budget.php?$varQuery&rep=excel'>export</a></td>";
	echo "<td>View <a href='/budget/aDiv/seasonal_payroll_payments.php?parkcode=$link_parkcode&center=$center&submit=Submit&f_year=$f_year' target='_blank'>Payments</a> for Temporary Payroll</td>";
	}

echo "</tr></table>";
}
if(@$center==""){exit;}
}// end Level > 2



?>



