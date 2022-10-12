<?php
$test=$_SERVER['QUERY_STRING'];
IF(strpos($test,"../")>-1)
	{
	header("Location: http://www.fbi.gov");
	exit;
	}
	
extract($_REQUEST);
if($logout){echo "Logout successful."; exit;}
session_start();
if($_SESSION['loginS'] == 'OKed'){
// $park = $_SESSION['parkS'];
echo "<html>
<head>
<title>NC State Parks System - Fort Fisher SRA Permit Website</title>
<meta http-equiv='Content-Type' content='text/html; charset=iso-8859-1'>
</head>
<body bgcolor='beige'>
<h2 align='center'><font face='Verdana, Arial, Helvetica, sans-serif'>Welcome 
  to the North Carolina Division of Parks and Recreation<br>
  </font><font face='Verdana, Arial, Helvetica, sans-serif'>Fort Fisher SRA Permit</font></h2>
<hr><table><tr><td width='20%'><font size='+1'>Using this website you can:</font></td><td></td></tr>
<tr><td></td><td>1. Enter/Edit permit holder information</td></tr>
<tr><td width='50%'><font size='+1'>Select action from navigation bar on the left side of screen.</font></td><td></td></tr>
</table><hr><div align='center'><font size='-1'>
If you have questions, problems and/or suggestions for improvement, please send an email
to <a href='mailto:tom.howard@ncmail.net'>tom.howard@ncmail.net</a>
</font></div>
</body>
</html>";
exit;
   }
?>
<html>
<head>
<title>NC State Parks System - Fort Fisher SRA Permit Website</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>
<body bgcolor="beige">
<h2 align="center"><font face="Verdana, Arial, Helvetica, sans-serif">Welcome 
  to the North Carolina Division of Parks and Recreation<br>
  </font><font face="Verdana, Arial, Helvetica, sans-serif">Fort Fisher SRA Permit Website</font></h2>
<hr><table><tr><td width='20%'><font size="+1">Using this website you can:</font></td><td></td></tr>
<tr><td></td><td>ENTER/EDIT Permit holder information</td></tr>
<tr><td width='20%'><font size="+1">Instructions:</font></td><td></td></tr>
<tr><td></td><td>1. Click on the Login link in the navigation bar.</td></tr>
</table><hr><div align="center"><font size="-1">
If you have questions, problems and/or suggestions for improvement, please send an email
to <a href="mailto:tom.howard@ncmail.net">tom.howard@ncmail.net</a>
</font></div>
</body>
</html>
