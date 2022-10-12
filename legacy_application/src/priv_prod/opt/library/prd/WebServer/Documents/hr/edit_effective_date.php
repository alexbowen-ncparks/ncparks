<?php
ini_set('display_errors',1);
$database="hr";
include("../../include/connectROOT.inc"); // database connection parameters
extract($_REQUEST);
mysql_select_db($database,$connection);
if(@$submit=="Update")
	{
	$skip=array("Lname","id","submit");
		foreach($_POST as $k=>$v){
			if(in_array($k,$skip)){continue;}
			$string.="$k='".mysql_real_escape_string($v)."', ";
			}
		
	//	echo "<pre>"; print_r($_POST); echo "</pre>";  exit;
		$string=rtrim($string,", ");
		
		$query="UPDATE employ_position SET $string WHERE id='$id'";
	//		echo "$query";exit;
				$result = mysql_query($query) or die ("Couldn't execute query Update. $query");
				header("Location: new_hire.php?Lname=$Lname&submit=Find");
				
			exit;
	}



include("../css/TDnull.php");

echo "<html><head></head><body>";
echo "<form method='POST'><table align='center' border='1' cellpadding='5'>";

$edit=array("effective_date");
$passVar=array("tempID","beacon_num");

$sql="Select t1.*, t2.effective_date
From `sea_employee` as t1
LEFT JOIN employ_position as t2 on t2.tempID=t1.tempID
where t2.id='$id'";
 $result = @MYSQL_QUERY($sql,$connection);
		// echo "$sql";
$row=mysql_fetch_assoc($result); 
foreach($row as $k=>$v){
//		if(in_array($k,$passVar)){${$k};}
	if(in_array($k,$edit))
		{
		$v="<input type='text' name='$k' value='$v'>";
		}
		if($k=="effective_date"){$k="start_date";}
	echo "<tr><td align='right'>$k</td><td>$v</td></tr>";
	}

$Lname=$row['Lname'];
echo "<tr><td align='right'>Start Date =></td><td align='center'>
<input type='hidden' name='Lname' value=\"$Lname\">
<input type='hidden' name='id' value='$id'>
";
echo "<input type='submit' name='submit' value='Update'></td></tr></form>";

echo "</table></form></body></html>";
?>
