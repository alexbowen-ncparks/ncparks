<?php
ini_set('display_errors',1);
$database="mar";
include("../../include/auth.inc"); // used to authenticate users
date_default_timezone_set('America/New_York');
//echo "<pre>"; print_r($_SESSION); echo "</pre>"; // exit;
?>

<html>
<head>
<title>SPAN database</title>
</head>
<body><div align="center">


<table width='50%'>
<tr>
<td align='center'><H3>The WAR has been retired and replaced with SPAN<br /><font color='red'>S</font>tate <font color='red'>P</font>ark <font color='red'>A</font>ctivities and <font color='red'>N</font>ews</H3></td>
<tr><td align='center'><a href='war2.php'>SPAN</a></td></tr>
<tr><td align='center'></td></tr>";

<?php
if($_SESSION['mar']['level']==2)
	{
	$d_dist=$_SESSION['mar']['select'];
	echo  "<tr><td align='center'><a href='d_district.php'>$d_dist DASHBOARD</a></td></tr>";
	}




?>
</tr></table>

</body>
</html>
