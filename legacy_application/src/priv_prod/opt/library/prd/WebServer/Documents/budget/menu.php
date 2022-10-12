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
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database 
//print_r($_REQUEST);//exit;
//echo "<pre>";print_r($_SERVER);echo "<pre>";//exit;
if($_SESSION['budget']['beacon_num'] == 60032910)
{
//echo "<pre>";print_r($_SESSION);echo "<pre>";//exit;
}
//include("../../include/activity.php");

extract($_REQUEST);

echo "<html><head>";
include("menu_js.php");
/*
echo "<script language='JavaScript'>

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

echo "//-->
</script>";
*/
include("css/TDnull.inc");

echo "<title>MoneyCounts</title><body>";
echo "<div align='center'><table border='1' cellpadding='5'><tr>";

if($_SESSION['budget']['level'] < 3)
	{
	$centerS=$_SESSION['budget']['centerSess_new'];
	}

if(@$forum)
	{
	$p=strtoupper($_SESSION['budget']['select']);
	include("../../include/get_parkcodes.php");
	if(!isset($centerS)){$centerS="";}
	$pc="<br /><font color='brown'>".$parkCodeName[$p]." - $centerS</font>";
	echo "<td colspan='8' align='center'><font size='+1'><b>NC State Parks MoneyCounts</b>$pc</font></td></tr><tr>";
	mysqli_select_db($connection, $database);
	}

// echo "<pre>"; print_r($_REQUEST); echo "</pre>"; // exit;
include_once("menuSelections.php");
?>