<?php
if(!isset($_SESSION)){session_start();}

$level=@$_SESSION[$database]['level'];

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link type="text/css" href="../css/ui-lightness/jquery-ui-1.8.23.custom.css" rel="Stylesheet" />    
<script type="text/javascript" src="../js/jquery-1.8.0.min.js"></script>
<script type="text/javascript" src="../js/jquery-ui-1.8.23.custom.min.js"></script>

<STYLE>
button{
    font-size: 90%;
    color: white;
}
</STYLE>

<?php

$ss_link="<link rel=\"stylesheet\" href=\"/css/style_mar.css\" type=\"text/css\" />";

echo "$ss_link";


$calendar_array=array("mar");
	if(in_array($database,$calendar_array))
		{
		echo "
		<link rel=\"stylesheet\" type=\"text/css\" media=\"all\" href=\"/jscalendar/calendar-brown.css\" title=\"calendar-brown.css\" />
		  <!-- main calendar program -->
		  <script type=\"text/javascript\" src=\"/jscalendar/calendar.js\"></script>
		  <!-- language for the calendar -->
		  <script type=\"text/javascript\" src=\"/jscalendar/lang/calendar-en.js\"></script>
		  <!-- the following script defines the Calendar.setup helper function, which makes adding a calendar a matter of 1 or 2 lines of code. -->
		  <script type=\"text/javascript\" src=\"/jscalendar/calendar-setup.js\"></script>
		";
		}
?>

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

function validate() {
if (document.mainform.cat[0].checked == true) {
alert('Photo was NOT entered. All plant and animal photos must first have an entry in NRID.');
event.returnValue=false;
	}
}

function toggle(){
	var div1 = document.getElementById('div1')
	if (div1.style.display == 'none') {
		div1.style.display = 'block'
	} else {
		div1.style.display = 'none'
	}
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
function checkform ( form )
{
  if (form.park.value == "") {
    alert( "Please enter your email address." );
    form.park.focus();
    return false ;
  }
  return true ;
}
// another function named toggleDisplay was removed - see below   
function toggleDisplay(objectID) {
	var inputs=document.getElementsByTagName('div');
		for(i = 0; i < inputs.length; i++) {
		
	var object1 = inputs[i];
		state = object1.style.display;
			if (state == 'block')
		object1.style.display = 'none';		
		}
		
	var object = document.getElementById(objectID);
	state = object.style.display;
	if (state == 'none')
		object.style.display = 'block';
	else if (state != 'none')
		object.style.display = 'none'; 
}

    $(function() {
        $( "#datepicker1" ).datepicker({
		changeMonth: true,
		changeYear: true, 
		dateFormat: 'yy-mm-dd',
		yearRange: "-2yy:+0yy",
		maxDate: "+0yy" });
    });

// -->
</script>

<style>
.ui-datepicker {
  font-size: 80%;
}
</style>
<?php
/*
function toggleDisplay(objectID) {
	var object = document.getElementById(objectID);
	state = object.style.display;
	if (state == 'none')
		object.style.display = 'block';
	else if (state != 'none')
		object.style.display = 'none'; 
}
*/

$title="NC Monthly Activity Report";
if(!isset($title)){$title="";}
	echo "<title>$title</title>";
?>

</head>
<body bgcolor="white"  align="center">
	<div align="center"><table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
  <td align="center" valign="top">

<?php
if(empty($_REQUEST['id']))
	{
	echo "<a href='http://ncparks.gov' target='_blank'><img src=\"/inc/css/images/dpr_1.jpg\"></a>";
	}
?>
    </td>
  </tr>
  
  <tr bgcolor='purple' height='9'><td> </td></tr>
</table>
				</div>
		
<div id="contenttext">
			<div class="bodytext" style="padding:12px;">