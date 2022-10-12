<?php
//These are placed outside of the webserver directory for security
include("../../include/auth_i.inc"); // used to authenticate users
include("../../include/iConnect.inc"); // database connection parameters
include("../../include/get_parkcodes_i.php");
// include("../../include/dist.inc");
//print_r($_REQUEST); EXIT;
if($parkS){
$_SESSION[parkS]=$parkS;
$datetime=date ("l dS of F Y h:i:s A");
//  ************Start input form*************
$align="align='center'";
echo "<html><head><title>Report Menu</title>
<STYLE TYPE=\"text/css\">
<!--
body
{font-family:sans-serif}
td
{font-size:90%}
th
{font-size:95%; vertical-align: bottom}
--> 
</STYLE>
<SCRIPT TYPE='text/javascript'>
<!--
function popup(mylink, windowname)
{
if (! window.focus)return true;
var href;
if (typeof(mylink) == 'string')
href=mylink;
else
href=mylink.href;
window.open(href, windowname, 'width=500,height=300,scrollbars=yes');
return false;
}
function printWindow(){
   bV = parseInt(navigator.appVersion)
   if (bV >= 4) window.print()
}
//-->
</SCRIPT>
</head>
<body><font size='4'>NC State Parks System Temporary Payroll</font>
<br>
<font size='2'>Report for $datetime</font><hr>";
if($level=="div") {$w=" LEFT JOIN emplist on emplist.tempID=empinfo.tempID
WHERE emplist.currPark!=''";}else {
$w=" LEFT JOIN emplist on emplist.tempID=empinfo.tempID
WHERE emplist.currPark='$parkS'";
}
if($rep1){
if($rep1=="sex"){$a="f";$b="Female";$c="Male";$d="Sex";}
if($rep1=="over40"){$a="n";$b="40 or Under";$c="Over 40";$d="Age";}
if($rep1=="milser"){$a="n";$b="No Military Service";$c="Served in the Military";$d="Military Service";}
echo "<table border='1'><tr><th colspan='2'>$d</th></tr>";
$sql = "SELECT $rep1,COUNT(DISTINCT emplist.tempID) as s
From empinfo
$w
 GROUP BY $rep1";
$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql");
while ($row=mysqli_fetch_array($result)){
extract($row);if($$rep1==$a){$x=$b;}else{$x=$c;}
echo "<tr><td>$x</td><td align='right'>$s</td></tr>";
}
if($loginS == "ADMIN"){
if($q1!="Div"){$v1="checked";$v2="";}else{$v2="checked";$v1="";}
echo "<tr><td align='center'>
<FORM>
<input type='radio' name='q1' onClick=\"location='printReport.php?rep1=$rep1&q1=Park'\" $v1> $parkS
&nbsp;</FORM></td>
<td><FORM>
<input type='radio' name='q1' onClick=\"location='printReport.php?level=div&rep1=$rep1&q1=Div'\" $v2> Division
 &nbsp;</FORM></td></tr>";}
echo "</table>";
}// end if $rep1
if($rep2){
if($rep2=="se"){$d="<font color='brown'>Starting and Ending Dates</font>";}
echo "<table border='1'><tr><th colspan='7'>$d</th></tr>
<tr><th>Pay Period</th><th>Employee ID</th><th>Position</th><th>Start</th><th>End</th><th>Reason</th><th>Explanation</th></tr>";
$sql = "SELECT * From startend
LEFT JOIN empinfo on startend.tempID=empinfo.tempID
WHERE park='$parkS' ORDER BY yearPP DESC,startend.tempID,startend.posNum";
$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql");
while ($row=mysqli_fetch_array($result)){
extract($row);$ID=$tempID."*".$Fname."*".$Lname;
$link="<a href='hours.php?Submit=Edit&parkS=$parkS&payperiod=$yearPP&tempID=$ID'>$yearPP";
echo "<tr><td align='center'>$link</td><td>$tempID</td><td>$posnum</td><td>$startDate</td><td>$endDate</td><td>$reason</td><td>$why</td></tr>";
}
}// end if $rep2
if($rep3){
if($rep3=="race"){$d="<font color='brown'>Race</font>";}
echo "<table border='1'><tr><th colspan='2'>$d</th></tr>";
$sql = "SELECT $rep3,COUNT(DISTINCT emplist.tempID) as s
From empinfo
$w
 GROUP BY $rep3";
$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql");
while ($row=mysqli_fetch_array($result)){
extract($row);
switch ($race) {
		case "1":
			$r = "White ";
			break;	
		case "2":
			$r = "African American ";
			break;	
		case "3":
			$r = "Hispanic ";
			break;	
		case "4":
			$r = "Asian ";
			break;	
		case "5":
			$r = "Native American ";
			break;	
	}
echo "<tr><td>$r</td><td align='right'>$s</td></tr>";
}
if($loginS == "ADMIN"){
if($q1!="Div"){$v1="checked";$v2="";}else{$v2="checked";$v1="";}
echo "<tr><td align='center'>
<FORM>
<input type='radio' name='q1' onClick=\"location='printReport.php?rep3=race&q1=Park'\" $v1> $parkS
&nbsp;</FORM></td>
<td><FORM>
<input type='radio' name='q1' onClick=\"location='printReport.php?level=div&rep3=race&q1=Div'\" $v2> Division
 &nbsp;</FORM></td></tr>";}
 }// end if $rep3
echo "</table>
<hr><table><tr><td> <a href='javascript:window.close()'>Close Window</a></td></tr>
<tr><td>
 <a href='javascript:printWindow()'>Print</a>
 </td></tr></table>
</body></html>";
}// end if parkS
?>