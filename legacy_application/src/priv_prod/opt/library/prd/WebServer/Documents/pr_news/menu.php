<?php
if(!isset($_SESSION)){session_start();}
$database="pr_news";
@$level=$_SESSION[$database]['level'];
//print_r($_SESSION);exit;
//print_r($_REQUEST);//exit;
//echo "<pre>";print_r($_SERVER);echo "<pre>";//exit;
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
 bConfirm=confirm('Are you sure you want to delete this item?')
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

//-->

</script>";

include("css/TDnull.inc");

echo "<title>NC Parks and Recreation News</title>";

echo "<body>";

echo "<div align='left'>
<table align='center' border='1' cellpadding='3'><tr><td colspan='4' align='center'><b>NC Parks and Recreation News</b></td></tr>
<tr>";

echo "<tr>";

if(!isset($serarchterm)){$searchterm="";}
echo "<td>View All <a href='display_item.php'> entries</a></td>
<form action='search.php'><td>Enter search term: 
<input type='text' name='searchterm' value='$searchterm'>
<input type='submit' name='submit' value='Search'></form></td>";

//<td><font size='-2'>RSS <a href='feed://portal.ncdenr.org/group/opa/newsclips-rss'>feed</a></font></td>";

if($level>3){echo "<td>Add an <a href='add_item.php'>item</a></td>";}
else{echo "<td><a href='https://10.35.152.9/login_form.php?db=pr_news'>login</a></td>";}
else{echo "<td><a href='https://10.35.152.9/login_form.php?db=pr_news'>login</a></td>";}
echo "</tr></table></div>";


?>