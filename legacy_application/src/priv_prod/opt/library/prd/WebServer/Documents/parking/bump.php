<?php
$database="parking"; 
$dbName="parking";
include("../../include/auth.inc");
include("../../include/iConnect.inc");
extract($_REQUEST);
$var=explode(" ",$name);
mysqli_select_db($connection,"divper");
$sql = "SELECT emplist.currPark,t2.working_title,  IF(t3.Nname!='',t3.Nname,t3.Fname) as Fname, t3.Lname, t3.email, t3.phone, t3.work_cell,t3.Mphone
FROM emplist 
LEFT JOIN position as t2 on t2.beacon_num=emplist.beacon_num
LEFT JOIN empinfo as t3 on t3.tempID=emplist.tempID
WHERE t3.Lname = '$var[1]' AND (t3.Fname='$var[0]' OR t3.Nname='$var[0]')";
$result = @mysqli_query($connection,$sql) or die("$sql Error 1#". mysqli_errno($connection) . ": " . mysqli_error($connection));

$bump_message="NOTICE:  Due to unforeseen circumstances, the Director’s office procured your parking reservation at the Edenton Street Church Parking Lot for urgent Division business.  Please park at the NRC visitor parking lot and use your purchasing card when you exit or pay cash.  Follow normal accounting procedures to prepare p-card reconcile or employee reimbursement forms at your home base.  Thank You";
while($row=mysqli_fetch_assoc($result))
{
$ARRAY[]=$row;
}
echo "<table border='1' cellpadding='5'>";
foreach($ARRAY AS $index=>$array)
	{
	if($index==0)
	{
	echo "<tr>";
	foreach($array as $fld=>$value)
		{
		echo "<th>$fld</th>";
		}
	echo "</tr>";
	}
	echo "<tr>";
	foreach($array as $fld=>$value)
		{
		if($fld=="email"){$value="<a href=\"mailto:$value?Subject=Your Raleigh Parking Lot reservation for space $space on $date has been rescinded.&body=$bump_message\">
Send Email</a> to $value";}
		echo "<td>$value</td>";
		}
	echo "</tr>";
	}
echo "<tr><td colspan='8'><font color='red'>Send this person a message indicating that their reservation for Space: $space on $date has been revoked.</font></tr>";
echo "<tr><td colspan='8'>$bump_message</tr>";
echo "</table>";

?>