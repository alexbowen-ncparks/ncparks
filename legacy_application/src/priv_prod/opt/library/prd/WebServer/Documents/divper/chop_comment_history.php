<?php
$database="divper";
include("../../include/auth.inc"); // used to authenticate users
include("../../include/iConnect.inc"); 
mysqli_select_db($connection,'divper'); // database


$level=$_SESSION['divper']['level'];


$sql = "SELECT * From vacant_chop_comments WHERE beacon_num='$bn' and date_vacant='$dv' order by id desc";
$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql");


// *************Entry Form 
echo "<html><head><title>Vacancy Tracking Comments</title>
<STYLE TYPE=\"text/css\">
<!--
body
{font-family:sans-serif;background:beige}
td
{font-size:90%;background:beige}
th
{font-size:95%;vertical-align:bottom}
--> 
</STYLE>
</head>
<body><font size='4' color='004400'>NC State Parks System Permanent Payroll</font>";


echo "<div align='center'>
<table><tr><td><font size='3' color='blue'>CHOP Comment History - Vacancy Tracking</font><font color='purple'> $posNum $posTitle
</font></td></tr><tr><td>$m</td></tr>
</table>
<table border='1'><tr><th>BEACON<br>Number</th><th>Date<br>Vacant</th><th>CHOP Comments</th></tr>";
while($row=mysqli_fetch_array($result)){
extract($row); $tracked=nl2br($tracked);
echo "<tr>
<td>$beacon_num</td>
<td>$date_vacant</td>
<td>$tracked</td>
</tr>";
}
echo "</table></div></body></html>";

?>