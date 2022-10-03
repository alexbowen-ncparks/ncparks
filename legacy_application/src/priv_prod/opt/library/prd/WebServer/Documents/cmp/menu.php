<?php
ini_set('display_errors',1);
//echo "<pre>"; print_r($_SERVER); echo "</pre>";  exit;
session_start();
include("../../include/auth.inc");// database connection parameters
@extract($_REQUEST);
$level=$_SESSION['cmp']['level'];
$ck_park=$_SESSION['cmp']['select'];
if($level<1){exit;}
//echo "<pre>"; print_r($_SESSION); echo "</pre>";  //exit;

echo "<html><head>";

echo "<link rel=\"stylesheet\" type=\"text/css\" media=\"all\" href=\"../../jscalendar/calendar-brown.css\" title=\"calendar-brown.css\" />
	  <!-- main calendar program -->
	  <script type=\"text/javascript\" src=\"../../jscalendar/calendar.js\"></script>
	  <!-- language for the calendar -->
	  <script type=\"text/javascript\" src=\"../../jscalendar/lang/calendar-en.js\"></script>
	  <!-- the following script defines the Calendar.setup helper function, which makes adding a calendar a matter of 1 or 2 lines of code. -->
	  <script type=\"text/javascript\" src=\"../../jscalendar/calendar-setup.js\"></script>  ";
	  
echo "  <script language='JavaScript'>

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

function toggleDisplay(objectID)
	{
	var inputs=document.getElementsByTagName('div');
		for(i = 0; i < inputs.length; i++)
		{
		
		var object = inputs[i];
		state = object.style.display;
			if (state == 'block')
		object.style.display = 'none';	
		}
		
	var object = document.getElementById(objectID);
	state = object.style.display;
	if (state == 'none')
		object.style.display = 'block';
	else if (state != 'none')
		object.style.display = 'none'; 
	}

function toggleDiv(objectID)
	{	
	var object = document.getElementById(objectID);
	state = object.style.display;
	if (state == 'none')
		object.style.display = 'block';
	else if (state != 'none')
		object.style.display = 'none'; 
	}
function popitup(url) {
        newwindow=window.open(url,'name','resizable=1,scrollbars=1,height=800,width=950');
        if (window.focus) {newwindow.focus()}
        return false;
}

function checkRadio (frmName, rbGroupName) { 
 var radios = document[frmName].elements[rbGroupName]; 
 for (var i=0; i <radios.length; i++) { 
  if (radios[i].checked) { 
   return true; 
  } 
 } 
 return false; 
} 

//-->
</script>
</head>";


echo "<title>Cash Management Plan</title>";
@include("../css/TDnull.inc");
	
//	echo "<pre>"; print_r($_SERVER); echo "</pre>"; // exit;
echo "<body><div align='center'>";

if($_SERVER['PHP_SELF']=="/cmp/menu.php")
	{
	echo "<img src='test6.jpg'><br /><font color='brown'>Cash Management Plan</font>";
	}

$color_array=array("Cash Management Plan"=>"lightgreen","Instructions"=>"#C6E2FF","Position Numbers"=>"#FFE4C4","Signature Authorization Form"=>"#FFFF00");

$path="/cmp/";

$menu_array['Cash Management Plan']=$path."form.php";
$menu_array['Position Numbers']=$path."positions.php";
$menu_array['Signature Authorization Form']=$path."sig.php";
//$menu_array['Instructions']=$path."instructions.php";

	
echo "<table><tr>";
foreach($menu_array as $k=>$v)
	{
	if(!isset($park_code)){$park_code="";}
	$color=$color_array[$k];
	if($k=="Position Numbers"||$k=="Instructions")
		{$target=" target='_blank'";}else{$target="";}
	echo "<td><form action='$v' $target>
	<input type='hidden' name='database' value='cmp'>
	<input type='hidden' name='park_code' value='$park_code'>
	<input type='submit' name='submit' value='$k'  style=\"background-color:$color\"></form></td>";
	}

echo "<td>Toggle <a onclick=\"toggleDiv('cmp_instruct');\" href=\"javascript:void('')\">
CMP Instructions</a><br />
<div id=\"cmp_instruct\" style=\"display: none\"><br />
1. Only Superintendents have access to the CMP database.
 <br /><br />
2. Please use the space provided to complete your answers.
  <br /><br />
3. Each park, district office and Raleigh Office sections is expected to fill out the CMP Supplement.
  <br /><br />
4. Each question should have an answer. If a particular question does not relate to your operation, N/A is an acceptable answer.
 <br /><br /> 
5. When a question asks you for a position# and job title you can click on the Position Numbers tab, find the pertinent info, copy and then paste back into the answer block.
 <br /><br /> 
6. Once you have completed answering all the questions, click submit. You will then need to go and print out your document for your records.   
 <br /><br />
7. This must be completed by April 30th. 
 <br /><br />
 Tammy
         </div></td>";

echo "<td><a href='Signature_Authorizations_Instructions.pdf' target='_blank'>
Signature Auth. Instructions</a></td>";

if($level>3){echo "<td>Sig <a href='sig_check.php'>Check</a></td>";}

$script=array("/cmp/form.php","/cmp/sig.php");
IF(in_array($_SERVER['SCRIPT_NAME'],$script))
	{
	$ss="Submit";
	}
	else
	{
	$ss="Update";
	}
echo "</tr>";

if(@$text!="y")
	{
	echo "<tr><td align='center' colspan='4'><font color='red'>==></font> <font color='brown'>You must click the $ss button at the bottom of the page in order to save your information.</font> <font color='red'><==</font></td></tr>";
	}
echo "</table>";

?>