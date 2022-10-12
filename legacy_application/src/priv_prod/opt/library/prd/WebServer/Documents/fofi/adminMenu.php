<?php
//These are placed outside of the webserver directory for security
// include("../../include/authFOFI.inc"); // used to authenticate users
include("../../include/iConnect.inc"); // database connection parameters
if($loginS!="ADMIN"){echo "Access denied.<br>Administrative Login Required.<br><a href='login_form.php'>Login</a> ";exit;}
//  ************Start Menu form*************
if(!$admin){
menuStuff();
echo "</body></html>";
exit;
}// end if !$admin
//  ************Start Update Pay Period Database************
$val = strpos($submit, "Update");
if($val > -1){  // strpos returns 0 if Update starts as first character
$yearPP=substr($ppBegin,0,4).".".str_pad($ppNum, 2, "0", STR_PAD_LEFT); 
$sql = "INSERT INTO payperiod SET `ppNum`='$ppNum',`ppBegin`='$ppBegin',`ppEnd`='$ppEnd',`yearPP`='$yearPP'";
$result = mysqli_query($connection,$sql) or die ("There was an error. $sql");
}// end $val = Update
//  ************Start Input form for Park Selection ************
if($admin=="park"){
menuStuff();if($park){$_SESSION[parkS]=$park;
echo "<font color='blue'>$park</font> has been selected.<br>You can now select desired action for this park from the left side navigation bar.<br>Latter, return to the Admin page to select a different park.";}
echo "<form method='post' action='adminMenu.php'><select name='park'>";         
        for ($n=1;$n<=$numParkCode;$n++)  
       {$scode=$parkCode[$n];if($scode==$park){$s="selected";}else{$s="value";}
		echo "<option $s='$scode'>$scode\n";
       }
echo "</select><input type='hidden' name='admin' value='park'>
<input type='submit' name='submit' value='Select Park'></form>
<hr></body></html>";exit;
}
//  ************ Show Transfered Positions ************
if($admin=="traPos"){
menuStuff();
//print_r($_REQUEST);exit;
$sql = "SELECT *
From position
WHERE markDel = 'x'";
//echo "$sql";exit;
		$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql");
		$num=mysqli_num_rows($result);
		if($num<1){echo "<br>No Positions have been transfered.<br>";exit;}
echo "<table border='1'>
		<tr><th>From This Park</th>
		<th>Number</th>
		<th>Title</th>
		<th>Hours</th>
		<th>Weeks</th>
		<th>Rate</th>
		<th>Total</th>
		<th>To This Park</th></tr>";
while ($row=mysqli_fetch_array($result)){
	extract($row);
$t=$rate*$hrs*$weeks;
$total=number_format($t, 2);
		echo "
		<tr><td align='center'>$park</td>
		<td>$posNum</td>
		<td>$posTitle</td>
		<td>$hrs</td>
		<td>$weeks</td>
		<td>$rate</td>
		<td>$$total</td>
		<td align='center'>$reason</td>
		</tr>";
		}
		echo "</table>";
exit;
}//end $submit traPos
//  ************ Show New Positions ************
if($admin=="newPos"){
menuStuff();
//print_r($_REQUEST);exit;
$sql = "SELECT *
From position
WHERE posType = 'New'";
//echo "$sql";exit;
		$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql");
		$num=mysqli_num_rows($result);
		if($num<1){echo "<br>No Positions have been added.<br>";exit;}
echo "<table border='1'>
		<tr><th>Park</th>
		<th>Number</th>
		<th>Title</th>
		<th>Hours</th>
		<th>Weeks</th>
		<th>Rate</th>
		<th>Total</th>
		<th>Date Added</th></tr>";
while ($row=mysqli_fetch_array($result)){
	extract($row);
$t=$rate*$hrs*$weeks;
$total=number_format($t, 2);
		echo "
		<tr><td align='center'>$park</td>
		<td>$posNum</td>
		<td>$posTitle</td>
		<td>$hrs</td>
		<td>$weeks</td>
		<td>$rate</td>
		<td>$$total</td>
		<td align='center'>$posMod</td>
		</tr>";
		}
		echo "</table>";
exit;
}//end $submit newPos
//  ************Process form for Employment Security Com. ************
if($admin=="esc"){
menuStuff();
if($submit=="ESC result"){
//print_r($_REQUEST);exit;
$varDate=$escEnd;
for($i=0;$i<$numWeek;$i++){
$dateE=explode("-",$varDate);
$day=$dateE[2];$month=$dateE[1];$year=$dateE[0];
$weekPrev = mktime (0,0,0,$month,$day-7,$year);
$weekBegin = mktime (0,0,0,$month,$day-6,$year);
$weekEnd = mktime (0,0,0,$month,$day,$year);
$weekPrev = date("Y-m-d",$weekPrev);
$weekBegin = date("Y-m-d",$weekBegin);
$weekEnd = date("Y-m-d",$weekEnd);
$sql = "SELECT sum(hr1311) as HR1311,sum(hr1421) as HR1421,sum(hr1311sum) as sumHR1311,sum(hr1421sum) as sumHR1421,max(rate) as rateM,rate,yearPP,park From payroll
WHERE tempID = '$tempID' and (dateWork between '$weekBegin' and '$weekEnd')
GROUP BY tempID";
//echo "$sql";exit;
		$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql");
		$num=mysqli_num_rows($result);
		if($num<1){echo "<br>No recorded hours for <font color='blue'>$tempID</font> between $weekBegin and $weekEnd.<br>";}
		while ($row=mysqli_fetch_array($result)){
		extract($row);
		$tHR=$HR1311+$HR1421;
		$sHR=$sumHR1311+$sumHR1421;
		echo "<table border='1'><tr><th colspan='4'><font color='blue'>$tempID</font></th></tr>
		<tr><th>Calendar Week Ending</th><th>Total Hours Worked</th><th>Gross Amount Earned</th><th>Max/Min Rate</th></tr>
<tr><td align='center'>
<a href='hours.php?payperiod=$yearPP&tempID=$tempID*&parkS=$park&Submit=Edit&a=1'>$varDate</a></td><td align='center'>$tHR</td><td align='center'>$$sHR</td><td align='center'>$$rateM/$$rate</td></tr></table>";
$varDate=$weekPrev;
		}
}
exit;
}//end $submit ESC result
//  ************Start Input form for Employment Security Com. ************
	if(!$tempID){
	if($submit==""){
echo "<br><font size='3' color='blue'>Enter Employee's Last Name
</font><br><form method='post' action='adminMenu.php'>
<input type='text' size='35' name='Lname' value=''>
<input type='hidden' name='admin' value='esc'>
<input type='submit' name='submit' value='Find Employee'></form>";
	exit;}//end $submit =""
		if($submit=="Find Employee"){
		$sql = "SELECT DISTINCT tempID From payroll WHERE tempID LIKE '$Lname%' ORDER by
		tempID";
		$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql");
		$num=mysqli_num_rows($result);
			if($num < 1){
			echo "No employee with a last name of <b>$Lname</b>, or beginning
				with <b>$Lname</b>, was found.<br>$sql";exit;
			} // end if $num<1
		}// end $submit=Find employee
			if($num==1){$row=mysqli_fetch_array($result);extract($row);
			$ssn4=substr($tempID,-4,4);$Lname=substr($tempID,0,-4);
			echo "<form method='post' action='adminMenu.php'>
			Employee Last Name: <font color='blue'>$Lname</font><br> Last 4 SSN digits: <font color='blue'>$ssn4</font><br>
<br>Enter in format yyyy-mm-dd <font color='red'>(Use the dash to separate year-month-day)</font><table>
<tr><td>Ending date for Last Week <input type='text' size='15' name='escEnd' value='$nextEnd'></td></tr>
<tr><td>Number of Weeks: <input type='text' size='3' name='numWeek' value=''></td></tr>
<tr><td colspan='3' align='center'>
<input type='hidden' name='tempID' value='$tempID'>
<input type='hidden' name='admin' value='esc'>
<input type='submit' name='submit' value='ESC result'>
</form></td></tr></table>";
			}//end $num=1
			if($num > 1){
			echo "<table>";
			while ($row=mysqli_fetch_array($result))
			{extract($row);
			echo "<tr><td>$tempID  <a href='adminMenu.php?admin=esc&tempID=$tempID'>Edit</a></td></tr>";
			}//end while
			echo "</table>";exit;
			}// end > 1
		}//end !tempID
exit;
}//end $admin=esc
//  ************Start Input form for Pay Period ************
if($admin=="payperiod"){
menuStuff();
$a="Begins";$b="Ends";$d="Pay Period";
echo "<form method='post' action='adminMenu.php'><table border='1'><tr><th>$d</th><th>$a</th><th>$b</th></tr>";
$sql = "SELECT * From $admin ORDER BY ppNum";
$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql");
$num=mysqli_num_rows($result);
if($num>0){
while ($row=mysqli_fetch_array($result)){
extract($row);
echo "<tr><td align='center'>$ppNum</td>
<td align='center'>$ppBegin</td><td align='center'>$ppEnd</td></tr>";
}
$day=substr($ppEnd,8,2);$month=substr($ppEnd,5,2);$year=substr($ppEnd,0,4);
$nextBegin = mktime (0,0,0,$month,$day+1,$year);
$nextEnd = mktime (0,0,0,$month,$day+14,$year);
$nextBegin = date("Y-m-d",$nextBegin);
$nextEnd = date("Y-m-d",$nextEnd);
}// end if $num
$next = $ppNum + 1;
}// end if $admin=payperiod
echo "
<tr><td align='center'><input type='text' size='4' name='ppNum' value='$next'></td>
<td align='center'><input type='text' size='15' name='ppBegin' value='$nextBegin'></td>
<td align='center'><input type='text' size='15' name='ppEnd' value='$nextEnd'></td></tr>
<tr><td colspan='3' align='center'>
<input type='hidden' name='next' value='$next'>
<input type='hidden' name='nextBegin' value='$nextBegin'>
<input type='hidden' name='admin' value='payperiod'>
<input type='submit' name='submit' value='Update'>
</form></td></tr></table>";
echo "<hr></body></html>";
// *************** Display Menu FUNCTION **************
function menuStuff(){
$align="align='center'";
echo "<html><head><title>Admin Menu</title>
<STYLE TYPE=\"text/css\">
<!--
body
{font-family:sans-serif;background:beige}
td
{font-size:90%;background:beige}
th
{font-size:95%; vertical-align: bottom}
--> 
</STYLE></head>";
echo "At this time no administrative functions have been implemented. Use links on the left.";
exit;
echo "
<body><font size='4' color='004400'>FORT FISHER SRA Permit Database</font>
<br><font size='5' color='blue'>Administrative Function Menu
</font><hr><table>
<tr><td colspan='2' width='300'><b>Choose Action:</b>
	<table>
		<tr><td width='25'></td><td $align><FORM>
<INPUT TYPE='button' value='Choose park' onClick=\"location='adminMenu.php?admin=park'\">
</FORM></td></tr>
		<tr><td width='25'></td><td $align><FORM>
<INPUT TYPE='button' value='ESC' onClick=\"location='adminMenu.php?admin=esc'\">
</FORM></td></tr>
		</table></td>
<td colspan='2' width='300'><b>&nbsp;</b>
	<table>
		<tr><td $align><FORM>
<INPUT TYPE='button' value='Show Division Positions by Park/Duty Station' onClick=\"location='form.php?admin=add'\">
</FORM></td></tr>
		<tr><td $align><FORM>
<INPUT TYPE='button' value='Show Transfered Positions' onClick=\"location='adminMenu.php?admin=traPos'\">
</FORM></td></tr>
		<tr><td $align><FORM>
<INPUT TYPE='button' value='Show New Positions' onClick=\"location='adminMenu.php?admin=newPos'\">
</FORM></td></tr>";
echo "<tr><td>&nbsp;</td></tr>
		<tr><td $align><FORM>
<INPUT TYPE='button' value='Add/Edit an Employee' onClick=\"location='payrollDiv.php?admin=payroll'\">
</FORM></td></tr>";
	echo "<tr><td>&nbsp;</td></tr>
		</table></td></tr>
</table><hr>";
}
?>