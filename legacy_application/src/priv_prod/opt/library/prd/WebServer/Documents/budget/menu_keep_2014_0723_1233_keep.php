<?php
//ini_set('display_errors',1);
//@session_start();

//echo "<pre>";print_r($_SESSION);echo "<pre>";exit;
if(empty($_SESSION)){session_start();}

if(!$_SESSION["budget"]["tempID"]){echo "access denied";exit;
//header("location: /login_form.php?db=budget");
//header("location: /login_form.php?db=budget");
}


$database="budget";
include("/opt/library/prd/WebServer/include/auth.inc");

$level=$_SESSION[$database]['level'];
ini_set('date.timezone', 'America/New_York');

$db="budget";
include("/opt/library/prd/WebServer/include/connectROOT.inc"); // connection parameters
mysql_select_db($database, $connection); // database 
//print_r($_REQUEST);//exit;
//echo "<pre>";print_r($_SERVER);echo "<pre>";//exit;
//echo "<pre>";print_r($_SESSION);echo "<pre>";//exit;
//include("../../include/activity.php");

extract($_REQUEST);

echo "<html><head><script language='JavaScript'>

function MM_jumpMenu(targ,selObj,restore){ //v3.0
  eval(targ+\".location='\"+selObj.options[selObj.selectedIndex].value+\"'\");
  if (restore) selObj.selectedIndex=0;
}
function confirmLink()
{
 bConfirm=confirm('Are you sure you want to delete this record?')
 return (bConfirm);
}

function toggleDisplay(objectID) {
	var object = document.getElementById(objectID);
	state = object.style.display;
	if (state == 'none')
		object.style.display = 'block';
	else if (state != 'none')
		object.style.display = 'none'; 
}
function add() {
var test = \"transfer\";
var sum = 0;
var valid = true;
var inputs = document.getElementsByTagName( 'input');
for(i =0; i < inputs.length; i++) {
if(inputs[i].name.substr(0,8)==test) {
var str_rep=inputs[i].value.replace(/,/, \"\");
sum += parseFloat(str_rep);}
}

if(valid) {
document.getElementById( 'sum').value = Math.round(sum*100)/100;
}
else{
var a1=sum+test;
alert(a1);
}
}
";

echo " 
function smo_selectRadioValues(value,theElements) {
     var formElements = theElements.split(',');
	 for(var z=0; z<formElements.length;z++){
	  theItem = document.getElementById(formElements[z]);
	  if(theItem){
	  theInputs = theItem.getElementsByTagName('input');
	  for(var y=0; y<theInputs.length; y++){
	   if(theInputs[y].type == 'radio'){
         theName = theInputs[y].name;
         if(theInputs[y].value==value){
		   theInputs[y].checked='checked';
		 }
	    }
	  }
	  }
     }
    }

function popitup(url)
{   newwindow=window.open(url,'name','resizable=1,scrollbars=1,height=800,width=800,menubar=1,toolbar=1');
        if (window.focus) {newwindow.focus()}
        return false;
}
function calc_add() { 
var inp = document.getElementById(\"equip_request_2\").unit_quantity.value 
var func = document.getElementById(\"equip_request_2\").unit_cost.value 
var outp = 0 

outp = (inp - 0)*(func-0) 

document.equip_request_2.requested_amount.value = outp 
}

function CheckAll()
{
count = document.frm.elements.length;
    for (i=0; i < count; i++) 
	{
    if(document.frm.elements[i].checked == 1)
    	{document.frm.elements[i].checked = 1; }
    else {document.frm.elements[i].checked = 1;}
	}
}
function UncheckAll(){
count = document.frm.elements.length;
    for (i=0; i < count; i++) 
	{
    if(document.frm.elements[i].checked == 1)
    	{document.frm.elements[i].checked = 0; }
    else {document.frm.elements[i].checked = 0;}
	}
}
function CheckAll_0()
{
count = document.frm_0.elements.length;
    for (i=0; i < count; i++) 
	{
    if(document.frm_0.elements[i].checked == 1)
    	{document.frm_0.elements[i].checked = 1; }
    else {document.frm_0.elements[i].checked = 1;}
	}
}
function UncheckAll_0(){
count = document.frm_0.elements.length;
    for (i=0; i < count; i++) 
	{
    if(document.frm_0.elements[i].checked == 1)
    	{document.frm_0.elements[i].checked = 0; }
    else {document.frm_0.elements[i].checked = 0;}
	}
}
";
/*
*/
echo "//-->
</script>";

include("css/TDnull.inc");

echo "<title>MoneyCounts</title><body>";
echo "<div align='center'><table border='1' cellpadding='5'><tr>";

if($_SESSION['budget']['level'] < 3)
	{
	$centerS=$_SESSION['budget']['centerSess'];
	}

if(@$forum)
	{
	$p=strtoupper($_SESSION['budget']['select']);
	include("../../include/get_parkcodes.php");
	if(!isset($centerS)){$centerS="";}
	$pc="<br /><font color='brown'>".$parkCodeName[$p]." - $centerS</font>";
	echo "<td colspan='8' align='center'><font size='+1'><b>NC State Parks MoneyCounts</b>$pc</font></td></tr><tr>";
	mysql_select_db($database,$connection);
	}


if($_SESSION['budget']['level'] > 3)
	{// add 2 for production server
	
	if(!$db){include("../../../include/connectBUDGET.inc");}
	//echo "h=$host d=$database db=$db";exit;
	
	// ******** Menu 1 Ginsu Knives *************   Admin
	/*
	$menuArray1=array("Center","&form=12","&form=14","&form=2","&form=11","&form=3","&form=4", "&form=5", "&form=6","warehouse_billings&form=8","travel&form=9","&form=10");
	
	$menuArray2=array("Budget-operating expenses planning","Budget-operating expenses detail","Center Level Budgets","Budget-operating expenses total","Budget-operating expenses division","Budget-Equipment expenses detail", "Budget-Equipment expenses division", "Budget-Purchase4resale detail", "Budget-Revenues detail", "Warehouse Charges","Travel Expenses","Project Numbers");
	
	echo "<td><form><select name=\"ginsu\" onChange=\"MM_jumpMenu('parent',this,0)\"><option selected>Ginsu Knives</option>";$s="value";
	for ($n=0;$n<count($menuArray1);$n++){
	//$con=urlencode($menuArray1[$n]);
	$con=($menuArray1[$n]);
			echo "<option $s='/budget/portalReport.php?dbReport=$con'>$menuArray2[$n]\n";
		   }
	   echo "</select></form></td>";
	*/   
	
	unset($menuArray1);unset($menuArray2);
	// Menu 3
	$sql="select * from table_menu order by table_name";
	$result = mysql_query($sql) or die ("Couldn't execute query 1. $sql c=$connection d=$db $database");
	while ($row=mysql_fetch_array($result))
		{
		$menuArray1[]=$row['menu_name'];
		$menuArray2[]=$row['table_name'];
		}
	
	echo "<td align='center'><a href='/abstract/abstract.php' target='_blank'>xcel2sql</a>
	<form><select name=\"dbTable\" onChange=\"MM_jumpMenu('parent',this,0)\"><option selected>Select Table</option>";
	for ($n=0;$n<count($menuArray2);$n++)
		{
		if(@$dbTable==$menuArray2[$n]){$s="selected";}else{$s="value";}
		$con=urlencode($menuArray2[$n]);
				echo "<option $s='/budget/portal.php?dbTable=$con'>$menuArray1[$n]\n";
			   }
	   echo "</select></form></td>";
	
	
	// ******** Menu 3 *************   Admin
	//$menuContract=array("DPR_Contract_Balances","DPR_Contract_Transactions","DPR_Contract_Payments");
	$menuContract=array("DPR_Contract_Balances","Edit Contract Vitals","Edit Contract Transactions");
	
	$menuContract_1=array("DPR_Contract_Balances","contract_vital.php?dbTable=cid_contract_vitals","contract_transactions.php?dbTable=cid_contract_transactions");
	echo "<td><form><select name=\"contract\" onChange=\"MM_jumpMenu('parent',this,0)\"><option selected>Contracts</option>";$s="value";
	for ($n=0;$n<count($menuContract);$n++){
	$con="/budget/c/".$menuContract_1[$n];
			echo "<option $s='$con'>$menuContract[$n]\n";
		   }
	   echo "</select></form></td>";
	
	
	// ******** Menu 4 *************   Admin
	$menuPARTF=array("/budget/partf_payments.php","/budget/partf.php?l=p","/budget/editFunds.php");
	$PARTF=array("PARTF-Payments","PARTF-Park","PARTF-Funds");
	echo "<td><form><select name=\"contract\" onChange=\"MM_jumpMenu('parent',this,0)\"><option selected>Select PARTF Level</option>";$s="value";
	for ($n=0;$n<count($menuPARTF);$n++){
	$con=$menuPARTF[$n];
			echo "<option $s='$con'>$PARTF[$n]\n";
		   }
	   echo "</select></form></td>";
	
	
	// ******** Menu 5 *************   Admin
	$menuFund=array("/budget/c/XTND_po_encumbrances.php");
	$XTND=array("XTND_PO_encumbrances");
	echo "<td><form><select name=\"xtnd\" onChange=\"MM_jumpMenu('parent',this,0)\"><option selected>XTND Report</option>";$s="value";
	for ($n=0;$n<count($menuFund);$n++){
	$con=$menuFund[$n];
			echo "<option $s='$con'>$XTND[$n]\n";
		   }
	   echo "</select></form></td>";
	
	
	// ******** Menu 6 *************   Admin References
	$menuArray1=array(
	"/budget/coa.php",
	"/budget/forum.php",
	"/budget/purchasing_rules_menu.php",
	"/budget/assets_menu.php",
	"/budget/b/prtf_lookup_project.php",
	"/budget/b/prtf_center_budget.php",
	"/budget/b/park_project_balances.php",
	"/budget/b/project_funding_by_source.php",
	"/budget/d/campsite.php",
	"/budget/d/report_year.php",
	"/budget/menu.php?m=1");
	
	$menuArray2=array(
	"Chart of Accounts",
	"Budget Forum",
	"DENR Purchasing Rules",
	"DPR Assets",
	"PARTF_Budget_lookup_payments_by_Proj_Num",
	"PARTF_Center_Level_Budgets",
	"Park Project Balances",
	"Project_funding_by_source",
	"Facilities_usage_campsites(0506)",
	"Report_Year",
	"Park Level Menu"
	);
	
	echo "<td><form><select name=\"ref\" onChange=\"MM_jumpMenu('parent',this,0)\"><option selected>References</option>";$s="value";
	for ($n=0;$n<count($menuArray1);$n++){
	$con=urlencode($menuArray1[$n]);
	$con=$menuArray1[$n];
			echo "<option $s='$con'>$menuArray2[$n]\n";
		   }
	   echo "</select></form></td>";
	
	echo "<td><font face='Verdana, Arial, Helvetica, sans-serif' color='green'><a href='/budget/admin.php'>Admin</a></font>
	</td>
	
	<td><font face='Verdana, Arial, Helvetica, sans-serif' color='green'><a href='/budget/logout.php'>Logout</a></font></td></tr>";
	//echo "</table></div>";
	}

include_once("menuSelections.php");
?>