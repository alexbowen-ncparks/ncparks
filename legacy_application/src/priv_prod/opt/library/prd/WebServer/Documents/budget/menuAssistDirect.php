<?php

include("../../include/authBUDGET.inc");

echo "<html><head><script language='JavaScript'>

<!--
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
";

echo "//-->
</script><title>NC DPR Budget Tracking System</title>";
include("css/TDnull.inc");
include("~f_year.php");

echo "<body>";
echo "<div align='center'><table border='1' cellpadding='5'><tr>";
echo "<td>NC DPR Budget Tracking System</td></tr><tr>";
$menuArray0['DENR Report']="/budget/aDiv/denr_report.php";
//$menuArray0['Project_Budget_History']="/budget/aProj/dede_reports.php";
//$menuArray0['Project Reports-Matrix']="/budget/projects/project_reports_matrix2.php?report=project";
$menuArray0['Budget History-Matrix']="/budget/concessions/reports_all_centers_summary_by_division.php?report=cent&accounts=all&section=all&history=3yr&period=fyear";
$menuArray0['Concessions']="/budget/concessions/reports_all_centers_summary_by_division.php?report=cent&accounts=gmp&section=all&history=3yr&period=fyear";
$menuArray0['Pre-approval for purchases']="/budget/aDiv/park_purchase_request_menu.php?submit=Submit";
$menuArray0['UserActivity_Report']="/budget/admin/user_activity/user_activity_matrix.php?period=range&report=user&user_level=all&section=all";



echo "<td align='center'><form><select name=\"ref\" onChange=\"MM_jumpMenu('parent',this,0)\"><option selected>Division Reports</option>";$s="value";
foreach($menuArray0 as $k => $v){
		echo "<option $s='$v'>$k\n";
       }
   echo "</select></form></td></tr></table></body></html>";
  
?>