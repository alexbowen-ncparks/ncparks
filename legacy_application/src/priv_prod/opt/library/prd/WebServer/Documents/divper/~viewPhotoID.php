<?php
ini_set('display_errors',1);
//These are placed outside of the webserver directory for security
$database="divper";
include("../../include/auth.inc"); // used to authenticate users
$database="photos";
include("../../include/iConnect.inc"); // database connection parameters
mysqli_select_db($connection,$database);
// extract($_REQUEST);

//echo "<pre>"; print_r($_SESSION); echo "</pre>"; // exit;
// ******** Enter your SELECT statement here **********
if($tempID=="Kendrick3113")
	{$tempID="Bouknight3113";}
$sql="SELECT link as photo
FROM images
WHERE personID='$tempID' and mark='' and cat not like '%facility%'";

//echo "$sql"; exit;
$result = mysqli_query($connection,$sql) or die ("Couldn't execute query SELECT. $sql ");
if(mysqli_num_rows($result)<1){echo "No photo for $tempID was found.<br /><br />$sql";exit;}
while($row=mysqli_fetch_assoc($result))
{extract($row);}

$sql="SELECT link as sig
FROM signature
WHERE personID='$tempID'";
$result = mysqli_query($connection,$sql) or die ("Couldn't execute query SELECT. $sql ");
while($row=mysqli_fetch_assoc($result)){extract($row);}

echo "<html><body><table border='1' cellpadding='2'>";

echo "<tr><td>Photo: $photo</td>
<td><img src='/photos/$photo' width='340'></td></tr>";
<td><img src='/photos/$photo' width='340'></td></tr>";

if(@$sig)
	{
		$ext=explode(".",$sig);
		if($ext[1]=="tif"){
	$SIG="<a href='/photos/sips_format.php?sig=$sig'>$sig</a>";}
	$SIG="<a href='/photos/sips_format.php?sig=$sig'>$sig</a>";}
		else{$SIG=$sig;}
	
	echo "<tr><td>Signature: $SIG</td>";
	if(file_exists("/photos/$sig"))
	if(file_exists("/photos/$sig"))
		{
		echo "<td><img src='/photos/$sig' width='340'></td></tr>";
		echo "<td><img src='/photos/$sig' width='340'></td></tr>";
		}
		else
		{
		echo "<td><img src='/divper/$sig' width='340'></td></tr>";
		echo "<td><img src='/divper/$sig' width='340'></td></tr>";
		}
		
	
	}
	else
	{
	echo "<tr><td>Signature: </td>
	<td>No signature uploaded.</td></tr>";
	}
echo "</table></form></body></html>";
?>