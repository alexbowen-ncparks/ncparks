<?php
ini_set('display_errors', 1);
if(!isset($_SESSION)){session_start();}

//echo "<pre>";print_r($_SERVER);echo "</pre>";
//if ($_SESSION['nrid']['level']<1){header("Location: index.html");exit();}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

<meta http-equiv="expires" content="0">
<meta http-equiv="expires" content="Tue, 14 Mar 2000 12:45:26 GMT">

	<meta name="keywords" content="nc state park, field trips, education, course of study">
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<link rel="stylesheet" href="/css/style.css" type="text/css" />
 <STYLE type="text/css">
#toggle{font-size:50%;}
a.button {
    -webkit-appearance: button;
    -moz-appearance: button;
    appearance: button;

    text-decoration: none;
    color: initial;
}

</STYLE>
<link type="text/css" href="../css/ui-lightness/jquery-ui-1.8.23.custom.css" rel="Stylesheet" />    
<script type="text/javascript" src="../js/jquery-1.8.0.min.js"></script>
<script type="text/javascript" src="../js/jquery-ui-1.8.23.custom.min.js"></script>

<script type="text/javascript" src="../js/form_validate.js"></script>

<?php
echo "<link rel=\"stylesheet\" type=\"text/css\" media=\"all\" href=\"../jscalendar/calendar-brown.css\" title=\"calendar-brown.css\" />
  <!-- main calendar program -->
  <script type=\"text/javascript\" src=\"../jscalendar/calendar.js\"></script>
  <!-- language for the calendar -->
  <script type=\"text/javascript\" src=\"../jscalendar/lang/calendar-en.js\"></script>
  <!-- the following script defines the Calendar.setup helper function, which makes adding a calendar a matter of 1 or 2 lines of code. -->
  <script type=\"text/javascript\" src=\"../jscalendar/calendar-setup.js\"></script>";
?>
<script>
    $(function() {
        $( "#datepicker1" ).datepicker({
		changeMonth: true,
		changeYear: true, 
		dateFormat: 'yy-mm-dd',
		yearRange: "-50yy:+0yy",
		maxDate: "+0yy" });
        $( "#datepicker2" ).datepicker({
		changeMonth: true,
		changeYear: true, 
		dateFormat: 'yy-mm-dd',
		yearRange: "-50yy:+0yy",
		maxDate: "+0yy" });
    });
</script>
<style>
.ui-datepicker {
  font-size: 80%;
}
</style>

<script type="text/javascript">

<!--
function MM_jumpMenu(targ,selObj,restore){ //v3.0
  eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
  if (restore) selObj.selectedIndex=0;
}

function JumpTo(theMenu){
                var theDestination = theMenu.options[theMenu.selectedIndex].value;
                var temp=document.location.href;
                if (temp.indexOf(theDestination) == -1) {
                        href = window.open(theDestination);
                        }
        }
        
function toggleDisplay(objectID) {
	var object = document.getElementById(objectID);
	state = object.style.display;
	if (state == 'none')
		object.style.display = 'block';
	else if (state != 'none')
		object.style.display = 'none'; 
}

function popitup(url)
{   newwindow=window.open(url,"name","resizable=1,scrollbars=1,height=1024,width=1024,menubar=1,toolbar=1");
        if (window.focus) {newwindow.focus()}
        return false;
}        
function confirmLink()
{
 bConfirm=confirm('Are you sure you want to delete this record?')
 return (bConfirm);
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
// -->
</script>
<style>
div.floating-menu {position:fixed;width:130px;z-index:100;}
div.floating-menu a {display:block;margin:0 0.0em;}
</style>
	
	<title>NC State Park Programs Database</title>
</head>

<?php
echo "<body>";
?>

<div align="center"><table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
  <td align="center" valign="top" style="width:1024px;height:58px;" class="titletext" bgcolor='#006699'>
     North Carolina State Parks<br />Programs Database (IEPD)
    </td>
  </tr>
  <tr>
  <td bgcolor='#800080' style="height:4px;" ></td>
  </tr>
  
  <tr>
  <td bgcolor='#800080' style="height:2px;" ></td>
  </tr>
 
</table>

				</div>
		
		
	<div id="page" align="left">
		<div id="content" align="left">
			<div id="menu" align="left">
				
				<div id="linksmenu" align="center">
					
<?php

$u_agent=$_SERVER['HTTP_USER_AGENT'];
if(strpos($u_agent,"MSIE")>0 OR strpos($u_agent,"Windows")>0 OR strpos($u_agent,"Mobile")>0)
	{echo "<div>";}
	else
	{
//	echo "<div>";
	echo "<div class='floating-menu'>";
	}

include("menu_programs_database.php");
echo "</div>";
?>
			</div>
				<div align="left" style="width:140px; height:8px;"></div>
			</div>
<div id="contenttext">
			<div class="bodytext" style="padding:12px;">