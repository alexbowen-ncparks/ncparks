<?php
extract($_REQUEST);

ini_set('display_errors',1);
$database="hr";
include("../../include/iConnect.inc"); // database connection parameters
mysqli_select_db($connection,$database);

// ********** Set Variables *********
session_start();
//echo "<pre>"; print_r($_SESSION); echo "</pre>"; // exit;
// echo "<pre>"; print_r($_SERVER); echo "</pre>"; // exit;
// $test=$_SERVER['HTTP_REFERER']; $test=explode("/",$test);
//echo "<pre>"; print_r($test); echo "</pre>"; // exit;


$level=$_SESSION['hr']['level'];

  
include("../css/TDnull.php");


// *********** Display ***********

//$form_date=$passYear."0000000000";
$form_date="0000000000";
$sql="Select *  From `hr_forms` 
where parkcode='$parkcode' AND tempID='$tempID' AND beacon_num='$beacon_num' AND upload_date>'$form_date'";
 $result = @mysqli_QUERY($connection,$sql);
 $numFields=mysqli_num_rows($result);
 
echo "<table align='center'><tr><td colspan='$numFields' align='center'><h2><font color='purple'>Seasonal Employment Forms</font></h2></td></tr>
		</table>
		
<table><tr><td>Last Name: $Lname</td><td>BEACON Position: $beacon_num</td></tr>";

while($row=mysqli_fetch_assoc($result))
	{
	extract($row);
	echo "<tr><td>$form_name</td><td><a href='$file_link'>link</a></td></tr>";
	}
	
$sql="Select *  From `hr_letter` 
where parkcode='$parkcode' AND tempID='$tempID' AND beacon_num='$beacon_num'";
$result = @mysqli_QUERY($connection,$sql);
//echo "$sql";

while($row=mysqli_fetch_assoc($result))
	{
	extract($row);
	echo "<tr><td>Separation Letter for $tempID at $parkcode for position $beacon_num</td><td><a href='$file_link'>link</a></td></tr>";
	}
echo "</table>";
	
$sql="Select Lname, Fname  From `sea_employee` 
where  tempID='$tempID'";
$result = @mysqli_QUERY($connection,$sql);
$row=mysqli_fetch_assoc($result);
	extract($row);

echo "<hr /><table border='1'>";
echo "<tr><td colspan='2'>All Separation Letters for $Fname $Lname - $tempID</td></tr>";
$sql="Select *  From `employ_separate` 
where tempID='$tempID'
order by date_separated desc";
$result = @mysqli_QUERY($connection,$sql);
//echo "$sql";

while($row=mysqli_fetch_assoc($result))
	{
	extract($row);
	$var=explode("-",$date_separated);

$path="/opt/library/prd/WebServer/Documents/hr194/";	$file_link="letter_upload/".$parkcode."_".$var[0]."/".$var[1]."/".$Lname.$Fname.$beacon_num."Separation_Letter.pdf";
$file=$path.$file_link;

$link="<a href='$file_link'>link to letter</a>";
if(!file_exists($file))
{$link="Could not find that separation letter. Contact Tom Howard to see if it can be located.";}

echo "<tr><td>Separation Letter for $parkcode for position $beacon_num separated on $date_separated</td><td align='center'>$link</td><td>$reason</td></tr>";
	}
echo "</table>";


echo "</html>";
?>