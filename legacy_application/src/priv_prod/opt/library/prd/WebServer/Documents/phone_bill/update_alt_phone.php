<?php 
//echo "<pre>"; print_r($_POST); echo "</pre>";  exit;
ini_set('display_errors',1);
extract($_REQUEST);	

	$database="phone_bill";
	include("../../include/connectROOT.inc"); //echo "c=$connection";
	mysql_select_db($database,$connection);
	
IF(@$submit=="Update")
	{
	extract($_REQUEST);
//	echo "<pre>"; print_r($_REQUEST); echo "</pre>";
			$sql="UPDATE alt_lines set location='$location' WHERE alt_lines='$alt_lines'"; 
		//	echo "$sql"; exit;
			 $result = MYSQL_QUERY($sql,$connection);
	
	header("Location: https://10.35.152.9/phone_bill/add_alt_phone.php?park=$park");
	header("Location: https://10.35.152.9/phone_bill/add_alt_phone.php?park=$park");
	exit;
	}

$sql="SELECT * from alt_lines where alt_lines='$pn'";
$result = MYSQL_QUERY($sql,$connection);

echo "<form method='POST'><table>";
while($row=mysql_fetch_assoc($result))
	{
	extract($row);
	echo "<tr>
	<td>phone number: <b>$alt_lines</b></td></tr>
	<tr><td>location: <input type='text' name='location' value='$location' size='45'></td>
	</tr>";
	}
echo "<tr>
<td><input type='hidden' name='alt_lines' value='$alt_lines'></td>
<td><input type='hidden' name='park' value='$park'></td>
<td><input type='submit' name='submit' value='Update'></td>
</tr>";
echo "</table>";
?>