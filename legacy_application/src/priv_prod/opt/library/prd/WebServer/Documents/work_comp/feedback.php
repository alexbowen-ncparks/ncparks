<?php
$database="work_comp";
$title="Worker's Comp";
include("../_base_top.php");

if($level<1)
	{exit;}
	
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database 

if(!empty($_POST))
	{
	$tempID=$_SESSION['work_comp']['tempID'];
	extract($_POST);
	$sql="INSERT into feedback set survey='$survey', `comments`='$comments', tempID='$tempID'";
	$request=mysqli_query($connection, $sql);
	echo "Thanks for taking the time to comment on the application. It will help us determine its usefullness.";
	exit;
	}

echo "<form action='feedback.php' method='POST'><table>";

echo "<tr>
<td colspan='2'>Does this database application 
<input type='radio' name='survey' value='Works OK'>Work OK <input type='radio' name='survey' value='Need Improvement'>Need Improvement</td>
</tr>";

echo "<tr>
<td>If you responded \"Need Improvement\", please let us know how you think it can be improved. Thanks!</td></tr>
<tr><td><textarea name='comments' cols='80' rows='3'></textarea></td>
</tr>";

echo "<tr>
<td><input type='submit' name='submit' value='Submit'></td>
</tr>";
echo "</table></form></body></html>";
?>