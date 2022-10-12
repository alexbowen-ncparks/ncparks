<?php
include("menu.php");
extract($_REQUEST);
$max_no_file=1;  // Maximum number of files value to be set here
echo "<form method='POST' action='add_agreement_file.php' enctype='multipart/form-data'>";
echo "<table border='0' width='400' cellspacing='0' cellpadding='0' align=center>";

$u = (isset($name) ? @$name : @$park_code);

echo "<tr><td colspan=2>PDF scan of Electronic Device Employee Acknowledgement<br />for <b>$u</b></td></tr>";

for($i=1; $i<=$max_no_file; $i++)
	{
	echo "<tr><td>Upload File $i</td><td>
		<input type='file' name='files[]' class='bginput'></td></tr>";
	}

if(isset($emid))
	{
	echo "<tr><td colspan=2 align=center>
	<input type='hidden' name='tempID' value='$tempID'>
	<input type='hidden' name='emid' value='$emid'>
	<input type=submit value='Upload Signed Scan of Agreement'>
	</td></tr>"; 
	}
	
if(isset($id))
	{
	echo "<tr><td colspan=2 align=center>
	<input type='hidden' name='park_code' value='$park_code'>
	<input type='hidden' name='id' value='$id'>
	<input type=submit value='Upload Signed Scan of Agreement'>
	</td></tr>"; 
	}
echo "</form> </table>";

?>

</body>

</html>
