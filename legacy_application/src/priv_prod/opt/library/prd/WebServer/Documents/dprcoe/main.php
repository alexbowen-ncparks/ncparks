<?php
//ini_set('display_errors',1);
extract($_REQUEST);
session_start(); //print_r($_SESSION);exit;
if(@$_SESSION['loginS'] == 'OKed' || @$_SESSION['loginS'] == 'PARK')
	{
	$park = $_SESSION['parkS'];
	header("Location: event.php?park=$park");exit;
	}
?>
<html>
<head>
<title>NC State Parks System - COE</title>
<script language="JavaScript">
	
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
</script>
</head>

<body bgcolor="beige">
<h2 align="center"><font face="Verdana, Arial, Helvetica, sans-serif">Welcome 
  to the North Carolina Division of Parks and Recreation<br>
  </font><font face="Verdana, Arial, Helvetica, sans-serif">Calendar of Events</font></h2>
<hr><table><tr><td>
You can use this website to view events that were entered before September 8, 2015 when the new public website went online. After that date, all events MUST be entered into the public website (ncparks.gov). 
</body>
</html>
