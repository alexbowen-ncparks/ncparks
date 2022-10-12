<?php
//session_start();
//echo "<pre>"; print_r($_SESSION); echo "</pre>";  //exit;

ini_set('display_errors',1);
date_default_timezone_set('America/New_York');

$database="state_lakes";
include("../../include/auth.inc");// access check

$level=$_SESSION['state_lakes']['level'];
$tempID=$_SESSION['state_lakes']['tempID'];

if($level<3)
	{
	$pass_park=$_SESSION['state_lakes']['select'];
	}
if($level<1){echo "You do not have access to this database."; exit;}

extract($_REQUEST);

echo "<html><head>
<link rel=\"stylesheet\" type=\"text/css\" media=\"all\" href=\"../jscalendar/calendar-brown.css\" title=\"calendar-brown.css\" />
  <!-- main calendar program -->
  <script type=\"text/javascript\" src=\"../jscalendar/calendar.js\"></script>
  <!-- language for the calendar -->
  <script type=\"text/javascript\" src=\"../jscalendar/lang/calendar-en.js\"></script>
  <!-- the following script defines the Calendar.setup helper function, which makes adding a calendar a matter of 1 or 2 lines of code. -->
  <script type=\"text/javascript\" src=\"../jscalendar/calendar-setup.js\"></script>
  
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

function toggleDisplay_single(objectID) {
	var object = document.getElementById(objectID);
	state = object.style.display;
	if (state == 'none')
		object.style.display = 'block';
	else if (state != 'none')
		object.style.display = 'none'; 
}

function toggleDisplay(objectID) {
	var inputs=document.getElementsByTagName('div');
		for(i = 0; i < inputs.length; i++) {
		
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

function valFrm() { 
		 if (!checkRadio(\"frm1\",\"matrix1_content[0]\")) 
  		alert(\"Please select a value for row 1\"); 
		 if (!checkRadio(\"frm1\",\"matrix1_content[1]\")) 
  		alert(\"Please select a value for row 2\"); 
		 if (!checkRadio(\"frm1\",\"matrix1_content[2]\")) 
  		alert(\"Please select a value for row 3\"); 
} 
//-->

</script>
</head>";

if(!isset($tab)){$tab="Welcome";}
echo "<title>$tab - State Lakes</title>";
include("../inc/css/TDnull.inc");
	
//	echo "<pre>"; print_r($_SERVER); echo "</pre>"; // exit;
echo "<body><div align='center'>";

if($_SERVER['PHP_SELF']=="/state_lakes/menu.php")
	{
	echo "<img src='lawa_pier.jpg'>";
	}
$menu_array=array("Owners/Agents"=>"display.php","Piers"=>"piers.php","Buoys"=>"buoy.php","Seawalls"=>"seawall.php","Ramps"=>"ramp.php","Swim Lines"=>"swim_line.php");

$color_array=array("Owners/Agents"=>"lightgreen","Piers"=>"#C6E2FF","Buoys"=>"yellow","Seawalls"=>"#FFE4C4","Ramps"=>"#DDA0DD","Swim Lines"=>"#FFB6C1");

$menu_array['Payments']="payment_form.php";

$menu_array['Receipts']="receipts.php";
$menu_array['Fee Letters']="prepare_letter_park.php";

if($level>0)
	{
	$menu_array['Reports']="report.php";
	$menu_array['Revenue']="revenue.php";
	}
$menu_array['Forms']="state_lake_forms.php";

echo "<table><tr><td align='center' colspan='10'><font color='brown'>Welcome to the<br />NC DPR State Lakes Website</font></td></tr><tr>";
foreach($menu_array as $k=>$v)
	{
		$color=@$color_array[$k];
		echo "<td><form action='$v'><input type='submit' name='submit' value='$k'  style=\"background-color:$color\"></form></td>";
	}
echo "</tr></table>";

?>