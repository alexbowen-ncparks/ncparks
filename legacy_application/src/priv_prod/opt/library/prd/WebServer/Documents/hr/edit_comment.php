<?php
ini_set('display_errors',1);
$database="hr";
include("../../include/connectROOT.inc"); // database connection parameters
mysql_select_db($database,$connection);

extract($_REQUEST);

if(@$submit=="Update")
	{
	
	//$comments=mysql_real_escape_string($comments);
	$query="UPDATE employ_position SET comments='$comments' WHERE id='$id'";
		//	echo "$query";exit;
	$result = mysql_query($query) or die ("Couldn't execute query Update. $query");
	
	if(@$source=="hire")
		{
		header("Location: new_hire.php?id=$empID&tempID=$tempID&beacon_num=$beacon_num&&varSep=toSeparate&submit=Find");		
		exit;
		}
		
	header("Location: separation.php?id=$empID&tempID=$tempID&beacon_num=$beacon_num&submit=Find");		
			exit;
	}



include("../css/TDnull.php");

echo "<html><head></head><body>";
echo "<form method='POST'><table align='center' border='1'>";

$edit=array("comments");
$setVar=array("empID","tempID","beacon_num");


$sql="Select  t1.tempID, t2.id as empID, t2.beaconID, t1.parkcode, t2.Fname, t2.Lname, t1.beacon_num, t1.position_title, t1.comments
From `employ_position` as t1
LEFT JOIN `sea_employee` AS t2 on t2.tempID=t1.tempID
where t1.id='$id'";

 $result = @MYSQL_QUERY($sql,$connection);
// echo "$sql";
$row=mysql_fetch_assoc($result); 
if(is_array($row))
	{
	foreach($row as $k=>$v)
		{
		if(in_array($k,$edit)){
			$v="<textarea name='$k' rows='15' cols='20'>$v</textarea>";
			}
			if(in_array($k,$setVar)){
					${$k}=$v;
					}
		//	if($k=="beacon_num"){$beacon_num=$v;}
		echo "<tr><td><b>$k</b><br />$v</td></tr";
		}
	}

echo "<tr><td>
<input type='hidden' name='id' value='$id'>
<input type='hidden' name='empID' value='$empID'>
<input type='hidden' name='tempID' value='$tempID'>
<input type='hidden' name='beacon_num' value='$beacon_num'>
";
echo "<input type='submit' name='submit' value='Update'></td></tr>";
echo "</table></form></body></html>";
?>
