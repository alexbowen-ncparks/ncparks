<?php
//echo "<pre>"; print_r($_REQUEST); echo "</pre>";
//These are placed outside of the webserver directory for security
//ini_set('display_errors',1);
// ***********Find person form****************
//These are placed outside of the webserver directory for security
$database="divper";
include("../../include/auth.inc"); // used to authenticate users
// include("../../include/iConnect.inc"); // database connection parameters
include("../../include/get_parkcodes_dist.php"); // database connection parameters

$database="divper";
mysqli_select_db($connection,$database);
include("menu.php");

extract($_REQUEST);

$level=$_SESSION['divper']['level'];
echo "<table align='center'>";

// Menu 1
if(!isset($Lname)){$Lname="";}
echo "<tr><td><form method='POST'><input type='text' name='Lname' value='$Lname'>
<input type='submit' name='submit' value='Find'></form></td></tr></table>";

if(empty($_POST['Lname'])){exit;}

$tempID_emplist_array=array();
$sql="select tempID from emplist where tempID like '$Lname%' order by tempID";
$result = mysqli_query($connection,$sql) or die ("Couldn't execute query 1. $sql<br>c to $db");
while ($row=mysqli_fetch_array($result))
	{$tempID_emplist_array[]=$row['tempID'];}
$sql="select tempID, Fname, Mname, Lname, city from empinfo where tempID like '$Lname%' order by tempID";
$result = mysqli_query($connection,$sql) or die ("Couldn't execute query 1. $sql<br> to $db");
while ($row=mysqli_fetch_array($result))
	{
	if(in_array($row['tempID'],$tempID_emplist_array)){continue;}
	$tempID_empinfo_array[$row['tempID']]=$row['Fname']." ".$row['Mname']." ".$row['Lname']." ".$row['city'];
	}
echo "<form method='POST'><table>";
if(!empty($tempID_empinfo_array))
	{
	foreach($tempID_empinfo_array as $tempID=>$name)
		{
		echo "<tr><td><input type='checkbox' name='tempID[]' value='$tempID'>$tempID</td><td>$name</td></tr>";
		}
		echo "<tr><td>
		<input type='hidden' name='Lname' value='$Lname'>
<input type='submit' name='submit' value='Add'></form></td></tr></table>";
	}
	else
	{echo "<tr><td>No retired person with a last name of $Lname was found.</td></tr>";}
	
echo "</table>";

if(empty($_POST['tempID'])){exit;}

//echo "<pre>"; print_r($_POST); echo "</pre>";  //exit;

$where="1 and (";
$where2="1 and (";
foreach($_POST['tempID'] as $index=>$tempID)
	{
	$where.="tempID='".$tempID."' OR ";
	$where2.="personID='".$tempID."' OR ";
	}

$where=rtrim($where," OR ").")";
// ******** Enter your SELECT statement here **********

$sql="SELECT t2.tempID, t2.Lname,t2.Fname,t2.Mname, (t2.emid + 10000) as Number, 'Law Enforcement Specialist' as working_title
FROM  empinfo as t2
WHERE $where";
//echo "$sql<BR />"; //exit;
$result = mysqli_query($connection,$sql) or die ("Couldn't execute query SELECT. $sql ".mysqli_error($connection));
while($row=mysqli_fetch_assoc($result))
	{
	$ARRAY[]=$row;
	$their_name=$row['Fname'];
	if(!empty($row['Mname'])){$their_name.=" ".$row['Mname'];}
	$their_name.=" ".$row['Lname'];
	}

//echo "<pre>"; print_r($ARRAY); echo "</pre>";  //exit;

$where2=rtrim($where2," OR ").")";
$sql="SELECT t1.personID as tempID, t1.link as photo_link
FROM photos.images as t1
WHERE $where2 and mark=''";
// echo "$sql ";
$result = mysqli_query($connection,$sql) or die ("Couldn't execute query SELECT. $sql");
if(mysqli_num_rows($result)>0)
	{
	while($row=mysqli_fetch_assoc($result))
		{
		$PHOTO_ARRAY[$row['tempID']]=$row['photo_link'];
		$img=$row['photo_link'];
		}
	}
if(empty($PHOTO_ARRAY)){echo "$sql No photo was found.<br />$sql"; exit;}
else
{
$photo_link="/photos/$img";
echo "Photo: <img src=$photo_link><br />";
}


$sql="SELECT t1.personID as tempID, t1.link as sig_link
FROM photos.signature as t1
WHERE $where2";
//echo "$sql";
$result = mysqli_query($connection,$sql) or die ("Couldn't execute query SELECT. $sql ");
if(mysqli_num_rows($result)>0)
	{
	while($row=mysqli_fetch_assoc($result))
		{
		$SIG_ARRAY[$row['tempID']]=$row['sig_link'];
		$sig=$row['sig_link'];
		}
	
$sig_link="/photos/$sig";
	}
if(empty($SIG_ARRAY))
	{
	echo "$sql  No signature was found. $tempID<br />"; 
	
	if ($tempID)
		{
		$name=explode(" ",$their_name);
		$fullName=$name[0]." ".$name[1];
		if(!empty($name[2])){$fullName.=" ".$name[2];}
		echo "<hr>

		<form method='post' action='/photos/addSig.php' enctype='multipart/form-data'>";

		echo "Name of Employee: <input type='text' name='fullName' value='$fullName' size='75'><br><br>

		<hr>
		Make sure the Signature file is a <font color='red'>JPEG</font>.<br />
		<INPUT TYPE='hidden' name='MAX_FILE_SIZE' value='30000000'>
		<br>1. Click the BROWSE (or Choose File) button and select your signature.<br>
		<input type='file' name='sig'>
		<input type='hidden' name='file_source' value='retired_id'>
		<input type='hidden' name='tempID' value='$tempID'>
		<p>2. Then click this button. <input type='submit' name='submit' value='Add Signature'>
		</form>";

		echo "</BODY></HTML>";
		}
	exit;
	}

//echo "<pre>"; print_r($ARRAY); print_r($PHOTO_ARRAY); print_r($SIG_ARRAY); echo "</pre>";	exit;
$fieldNames=array_values(array_keys($ARRAY[0]));
$fieldNames[]="Signature";
$num=count($fieldNames);

$page="/IDcard/printPhotoID_retired.php";
$page="/IDcard/printPhotoID_retired.php";

	
echo "<table border='1' cellpadding='2'><tr><td colspan='$num' align='center'><font color='red'>$num records</font></td></tr>";

foreach($SIG_ARRAY as $tempID=>$sig_link)
	{
// 	$photo_link="http://www.dpr.ncparks.gov/photos/".$PHOTO_ARRAY[$tempID];
// 	$sig_link="http://www.dpr.ncparks.gov/photos/".$sig_link;
	

	echo "photo_link = $photo_link<br />"; //exit;

	echo "Sig link = $sig_link<br />"; //exit;

	
	echo "<tr>
	<td><img src='$photo_link' width='640'></td>
	<td><img src='$sig_link'><br />";
	if(!empty($photo_link) and !empty($sig_link))
		{
		echo "<form method='POST' action='$page' target='_blank'>
		Title:<br />
		State Park Ranger <input type='radio' name='pass_title' value='State Park Ranger'><br />
		Park Superintendent <input type='radio' name='pass_title' value='Park Superintendent'><br />
		District Superintendent <input type='radio' name='pass_title' value='District Superintendent'><br />
		Parks Chief Ranger <input type='radio' name='pass_title' value='Parks Chief Ranger'><br />
		Law Enforcement Specialist <input type='radio' name='pass_title' value='Law Enforcement Specialist'><br />
		Chief of Operations <input type='radio' name='pass_title' value='Chief of Operations'><br />
		Director <input type='radio' name='pass_title' value='Director'><br />
		Retired On: <input type='text' name='retired_on' value=''>mm/dd/yyyy<br />
		Signer: <input type='radio' name='signer' value='director' checked> Director
		<input type='radio' name='signer' value='pcr'> Parks Chief Ranger
		<input type='hidden' name='passTempID' value='$tempID'>
		<input type='submit' name='submit' value='Print'></form>";
		}
	echo "</td>
	</tr>";
	}
echo "</table>";

echo "</body></html>";

?>