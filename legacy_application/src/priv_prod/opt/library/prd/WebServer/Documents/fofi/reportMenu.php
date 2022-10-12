<?php
include("menu.php");

include("/opt/library/prd/WebServer/include/connectROOT.inc"); // connection parameters
mysql_select_db("fofi", $connection); // database 

extract($_REQUEST);

echo "<font size='4' color='004400'>Fort Fisher SRA Permit Database</font>
<br><font size='5' color='blue'>Report Menu
</font><hr>
<table>
<tr>
<td colspan='4' width='200'><b>Demographic Reports</b></td></tr>
<tr><td width='25'></td><td>
<FORM method='POST' action='reportMenu.php'>
<INPUT TYPE='hidden' name='r' value='1'>
<INPUT TYPE='hidden' name='rep' value='zip'>
<INPUT TYPE='submit' name='submit' value='Zip Code'>
</FORM></td>
<td>
<FORM method='POST' action='reportMenu.php'>
<INPUT TYPE='hidden' name='r' value='1'>
<INPUT TYPE='hidden' name='rep' value='city'>
<INPUT TYPE='submit' name='submit' value='Cities'>
</FORM></td>
<td>
<FORM method='POST' action='reportMenu.php'>
<INPUT TYPE='hidden' name='r' value='2'>
<INPUT TYPE='hidden' name='rep' value='cityzip'>
<INPUT TYPE='submit' name='submit' value='City/Zip'>
</FORM></td>
<td>
<FORM method='POST' action='reportMenu.php'>
<INPUT TYPE='hidden' name='r' value='1'>
<INPUT TYPE='hidden' name='rep' value='state'>
<INPUT TYPE='submit' name='submit' value='States'>
</FORM></td>";
/*
echo "<td>
<FORM method='POST' action='reportMenu.php'>
<INPUT TYPE='hidden' name='r' value='3'>
<INPUT TYPE='hidden' name='rep' value='stateyear'>
<INPUT TYPE='submit' name='submit' value='States by Year'>
</FORM></td>";
*/

echo "</tr>
</table>
<hr>";

if(!isset($r)){exit;}

if($r==1)
	{
	if($rep=="zip")
		{
		$d="<font color='brown'>Permits by Zip Code</font>";
		$field="zip";
		}
	if($rep=="city")
		{
		$d="<font color='brown'>Permits by Cities</font>";
		$field="city";
		}
	if($rep=="state")
		{
		$d="<font color='brown'>Permits by States</font>";
		$field="state";
		}
	
	if(!isset($w)){$w="";}
	echo "<table border='1'><tr><th colspan='3'>$d</th></tr>";
	$sql = "SELECT $field as gA, COUNT($field) as gS, city,state
	From permit
	$w
	 GROUP BY $field";
	 echo "$sql<br />";
	$tot0="";
	$tot1="";
	$result = mysql_query($sql) or die ("Couldn't execute query. $sql");
	while ($row=mysql_fetch_array($result))
		{
		extract($row);
		if($rep=="zip")
			{
			$link="
			<FORM method='POST' action='search.php'>
			<INPUT TYPE='hidden' name='zip' value='$gA'>
			<INPUT TYPE='submit' name='Submit' value='Search'>
			</FORM>";
			echo "<tr><td>$link</td><td>$gA</td><td> $city, $state</td><td align='right'>$gS</td></tr>";
			}
		if($rep=="city")
			{
			$link="
			<FORM method='POST' action='search.php'>
			<INPUT TYPE='hidden' name='city' value='$gA'>
			<INPUT TYPE='submit' name='Submit' value='Search'>
			</FORM>";
			echo "<tr><td>$link</td><td> $city, $state</td><td align='right'>$gS</td></tr>";
			}
		if($rep=="state")
			{
			$link="
			<FORM method='POST' action='search.php'>
			<INPUT TYPE='hidden' name='state' value='$gA'>
			<INPUT TYPE='submit' name='Submit' value='Search'>
			</FORM>";
			echo "<tr><td>$link</td><td>$state</td><td align='right'>$gS</td></tr>";
			}
		$tot0+=$gS;
		$tot1++;
		}
	}
	
if($r=="2")
	{
	$d="<font color='brown'>Permits by City/Zip</font>";
		$field="DISTINCT CONCAT(`city` ,'\, ',`state`,' ',`zip`) as gA, COUNT(CONCAT(`city` ,'\, ',`state`,' ',`zip`)) as gS, city, zip ";
	
	if(!isset($w)){$w="";}
	echo "<table border='1'><tr><th colspan='3'>$d</th></tr>";
	$sql = "SELECT $field 
	From permit
	$w
	GROUP BY gA
	 ORDER BY gA";
	$tot0="";
	$tot1="";
	$result = mysql_query($sql) or die ("Couldn't execute query. $sql");
	while ($row=mysql_fetch_array($result))
		{
		extract($row);
		$link="
		<FORM method='POST' action='search.php'>
		<INPUT TYPE='hidden' name='city' value='$city'>
		<INPUT TYPE='hidden' name='zip' value='$zip'>
		<INPUT TYPE='submit' name='Submit' value='Search'>
		</FORM>";
		echo "<tr><td>$gA</td><td align='right'>$gS</td><td>$link</td></tr>";
		$tot0+=$gS;
		$tot1++;
		}
	}// end !=$rep3 else

if($r=="3") // not implemented because table has no "year" field
	{
	$d="<font color='brown'>Permits by State by Year</font>";
		$field="DISTINCT CONCAT(`city` ,'\, ',`state`,' ',`year`) as gA, COUNT(CONCAT(`city` ,'\, ',`state`,' ',`zip`)) as gS, city, zip ";
	
	
	echo "<table border='1'><tr><th colspan='3'>$d</th></tr>";
	$sql = "SELECT $field 
	From permit
	$w
	GROUP BY gA
	 ORDER BY gA";
	$tot0="";
	$tot1="";
	$result = mysql_query($sql) or die ("Couldn't execute query. $sql");
	while ($row=mysql_fetch_array($result))
		{
		extract($row);
		$link="
		<FORM method='POST' action='search.php'>
		<INPUT TYPE='hidden' name='city' value='$city'>
		<INPUT TYPE='hidden' name='zip' value='$zip'>
		<INPUT TYPE='submit' name='Submit' value='Search'>
		</FORM>";
		echo "<tr><td>$gA</td><td align='right'>$gS</td><td>$link</td></tr>";
		$tot0+=$gS;
		$tot1++;
		}
	}
 
echo "<tr><td align='center'>$tot1</td><td colspan='3' align='right'>$tot0</td></tr></table></body></html>";

?>
