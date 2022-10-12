<?php
$database="system_plan";
//include("../../include/authAny.inc"); // includes session_start
// include("../css/TDnull.inc");
if(empty($_SESSION))
	{
	session_start();
// 	$level=$_SESSION['system_plan']['level'];
	}

	$level=$_SESSION['system_plan']['level'];
// echo "<pre>"; print_r($_SESSION); echo "</pre>"; // exit;

echo "<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Strict//EN'
'http://www.w3.org/TR/XHTML1/DTD/XHTML1-strict.dtd'>
<html xmlns='http://www.w3.org/1999/xhtml' lang='en' xml:lang='en'>
<head>
<public:component>
  <public:attach event=\"onmouseover\" onevent=\"doOver()\" />
  <public:attach event=\"onmouseout\" onevent=\"doOut()\" />

<style>
.center{
	margin-left: auto;
	margin-right: auto;
}

.form_button_edit{
    background-color: #0039e6;
    color: white;
}
.form_button_add{
    background-color: #e67300;
    color: white;
}
#acreage {
    font-family: \"Trebuchet MS\", Arial, Helvetica, sans-serif;
    border-collapse: collapse;
    width: 100%;
}

#acreage td, #acreage th {
    border: 1px solid #ddd;
    padding: 8px;
}

#acreage tr:nth-child(even){background-color: #f2f2f2;}

#acreage tr:hover {background-color: #ddd;}

#acreage th {
    padding-top: 12px;
    padding-bottom: 12px;
    text-align: left;
    background-color: #4CAF50;
    color: white;
}

#acreage_add {
    font-family: \"Trebuchet MS\", Arial, Helvetica, sans-serif;
    border-collapse: collapse;
}

#acreage_add th {
    padding-top: 12px;
    padding-bottom: 12px;
    text-align: center;
    background-color: #e67300;
    color: white;
}

#acreage_edit {
    font-family: \"Trebuchet MS\", Arial, Helvetica, sans-serif;
    border-collapse: collapse;
}

#acreage_edit th {
    padding-top: 12px;
    padding-bottom: 12px;
    text-align: center;
    background-color: #0039e6;
    color: white;
}
#acreage_edit td, #acreage_edit th {
    border: 1px solid #ddd;
    padding: 8px;
}

#acreage_edit tr:nth-child(even){background-color: #f2f2f2;}

#acreage_edit tr:hover {background-color: #ddd;}
</style>

<script language='JavaScript'>

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
function CheckAll_1()
{
count = document.form_1.elements.length;
    for (i=0; i < count; i++) 
	{
    if(document.form_1.elements[i].checked == 1)
    	{document.form_1.elements[i].checked = 0; }
    else {document.form_1.elements[i].checked = 1;}
	}
}
function UncheckAll_1(){
count = document.form_1.elements.length;
    for (i=0; i < count; i++) 
	{
    if(document.form_1.elements[i].checked == 1)
    	{document.form_1.elements[i].checked = 0; }
    else {document.form_1.elements[i].checked = 1;}
	}
}

function CheckAll_2()
{
count = document.form_2.elements.length;
    for (i=0; i < count; i++) 
	{
    if(document.form_2.elements[i].checked == 1)
    	{document.form_2.elements[i].checked = 1; }
    else {document.form_2.elements[i].checked = 1;}
	}
}
function UncheckAll_2(){
count = document.form_2.elements.length;
    for (i=0; i < count; i++) 
	{
    if(document.form_2.elements[i].checked == 1)
    	{document.form_2.elements[i].checked = 0; }
    else {document.form_2.elements[i].checked = 0;}
	}
}
function doOver() {
     var OVER_CLASS = \"mouseover\";
     var cells = this.getElementsByTagName(\"TD\");
     for (var i=0;cells[i];i++) {
       cells[i].className = OVER_CLASS;
     }
    }
 function doOut() {
     var OUT_CLASS = \"\";
     var cells = this.getElementsByTagName(\"TD\");
     for (var i=0;cells[i];i++) {
       cells[i].className = OUT_CLASS;
     }
    }   
//-->

</script>
</public:component>
</head>
<title>NC DPR Systemwide Plan Website</title>";

echo "<body>";

echo "<div align='center'>
<table border='1' cellpadding='5'><tr><td align='center'><b>NC DPR Systemwide Plan<br />Park Profile</b></td></tr>
<tr>";


// ******** Menu 0 *************   
//$menuArray0=array("Park Profile - html"=>"facility_form.php","Individual Park Profile - pdf"=>"summary_display.php","Print Park Profiles - pdf"=>"summary_print.php","- - - - - - - - "=>"","Interpretive Themes - html"=>"ie_themes.php","Interpretive Themes - pdf"=>"ie_themes.php?rep=1"," - - - - - - - - "=>"","Acreage"=>"https://www.ncstateparks.net/divper/land_acres_report.php","Facility Summary"=>"facility_form_system_plan.php");

$menuArray0=array("FY 1920 DNCR Request"=>"/dpr_system/dncr_request.php", "Print Park Profiles - pdf"=>"summary_print.php", "Print Park Profiles w/Work Load - pdf"=>"summary_print_work_load.php","Sys_Plan Comments Form"=>"/summit/sys_plan_comment.php","Review Sys_Plan Comments"=>"/summit/sys_plan.php","- - - - - - - - "=>"","Interpretive Themes - html"=>"ie_themes.php","Interpretive Themes - pdf"=>"ie_themes.php?rep=1"," - - - - - - - - "=>"","Facility Summary"=>"facility_form_system_plan.php","Designate Visitor Facility Type"=>"facility_form_visitor.php");
$menuArray0=array("FY 1920 DNCR Request"=>"/dpr_system/dncr_request.php", "Print Park Profiles - pdf"=>"summary_print.php", "Print Park Profiles w/Work Load - pdf"=>"summary_print_work_load.php","Sys_Plan Comments Form"=>"/summit/sys_plan_comment.php","Review Sys_Plan Comments"=>"/summit/sys_plan.php","- - - - - - - - "=>"","Interpretive Themes - html"=>"ie_themes.php","Interpretive Themes - pdf"=>"ie_themes.php?rep=1"," - - - - - - - - "=>"","Facility Summary"=>"facility_form_system_plan.php","Designate Visitor Facility Type"=>"facility_form_visitor.php");

$menuArray0['System Acreage']="acreage.php";

$skip=array("summary_print.php", "summary_print_work_load.php","/summit/sys_plan_comment.php", "/summit/sys_plan_comment.php" ,"/summit/sys_plan.php", "ie_themes.php?rep=1", "sys_acreage.php");
$skip=array("summary_print.php", "summary_print_work_load.php","/summit/sys_plan_comment.php", "/summit/sys_plan_comment.php" ,"/summit/sys_plan.php", "ie_themes.php?rep=1", "sys_acreage.php");
if($level>4)
	{
	$menuArray0['Old System Acreage']="sys_acreage.php";
	}
// echo "<pre>"; print_r($menuArray0); echo "</pre>"; // exit;
echo "<td align='center'><form><select name=\"select\" onChange=\"MM_jumpMenu('parent',this,0)\"><option selected>Select...</option>";
foreach($menuArray0 as $k => $v)
	{
	if(in_array($v, $skip)){continue;}
	echo "<option value='$v'>$k\n";
	}
   echo "</select></form></td>";

echo "</tr>";
// echo "<pre>"; print_r($_SERVER); echo "</pre>"; // exit;
if($_SERVER['PHP_SELF']=="/system_plan/acreage.php" or $_SERVER['PHP_SELF']=="/system_plan/acreage_year.php")
	{
	echo "<tr>";
	echo "<th><a href='system_summary.php'>System Summary</a></th>";
	echo "<td><a href='acreage_semi_annual_update.php'>Semiannual Update</a></td>";
	echo "</tr>";
	}

echo "</table></div>";

?>