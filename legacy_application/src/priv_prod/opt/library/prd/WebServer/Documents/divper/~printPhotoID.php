<?php
//ini_set('display_errors',1);
// ***********Find person form****************
//These are placed outside of the webserver directory for security
$database="divper";
include("../../include/auth.inc"); // used to authenticate users
include("../../include/iConnect.inc"); // database connection parameters
include("../../include/get_parkcodes_reg.php"); // database connection parameters

// ******** Enter your SELECT statement here **********

mysqli_select_db($connection,"photos");
foreach($_POST['passTempID'] as $k=>$v)
	{
	$sql="SELECT link
	FROM images
	WHERE personID='$v'";
	$result = mysqli_query($connection,$sql) or die ("Couldn't execute query SELECT. $sql");
	while($row=mysqli_fetch_assoc($result))
		{
		$linkArray[$v]=$row['link'];
		}
	}

// echo "<pre>"; print_r($linkArray); echo "</pre>";  exit;


mysqli_select_db($connection,$database);

// Create PDF.

// Set the constants and variables.
define ("PAGE_WIDTH", 612); // 8.5 inches
define ("PAGE_HEIGHT",792); // 11 inches

// Make the page.	
$pdf = pdf_new(); include("/opt/library/prd/WebServer/include/pdf_key_23.php");
pdf_open_file ($pdf, "");

// Set the different PDF values.
pdf_set_info ($pdf, "Author", "Tom Howard");
pdf_set_info ($pdf, "Creator", "See Author");

// Create the page.
pdf_begin_page ($pdf, PAGE_WIDTH, PAGE_HEIGHT);

$y=792;
foreach($_POST['passTempID'] as $k=>$v){

$sql="SELECT t1.tempID, t2.Fname,t2.Nname,t2.Mname,t2.Lname, (t2.emid + 10000) as Number, t3.working_title
FROM emplist as t1
LEFT JOIN empinfo as t2 on t1.tempID=t2.tempID
LEFT JOIN position as t3 on t1.beacon_num=t3.beacon_num
WHERE t1.tempID='$v'";
$result = mysqli_query($connection,$sql) or die ("Couldn't execute query SELECT. $sql ");

$arial = pdf_findfont($pdf, "Arial", "host", 1);
pdf_setfont($pdf, $arial, 10);

while($row=mysqli_fetch_assoc($result)){extract($row);}

$f=fmod($i,2);
//	$photo="http://149.168.1.195/photos/".$linkArray[$v];
//	$size=getimagesize($photo);
	
//	if($size[0]>$size[1]){$s="width";}else{$s="height"; }
	
//	$photo="7827.jpg";
	$image = pdf_open_image_file($pdf, 'jpeg', $photo);
	
	$x=$x+75;
		if($f==0){$x=75;$y=$y-100;}
	pdf_place_image($pdf, $image, $x, $y, 0.25);
	pdf_show_xy($pdf, $i+1, $x, $y);
	
/*
	echo "<td align='center'><img src='$photo' $s='140'></td><td align='center' width='225'>This is to certify that<br /><font size='0'><b>$Fname $Lname</b></font><br />whose photograph and signature appear hereon, is an employee of the North Carolina Division of Parks and Recreation, and holds the Title of:<br /><font size='0'><b>$working_title</b></font></td><td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>";
*/
$i++;
}
// Finish the page
pdf_end_page ($pdf);

// Close the PDF
pdf_close ($pdf);

// Send the PDF to the browser.
$buffer = pdf_get_buffer ($pdf);
header ("Content-type: application/pdf");
header ("Content-Length: " . strlen($buffer));
header ("Content-Disposition: inline; filename=filename.pdf");
echo $buffer;

// Free the resources
pdf_delete ($pdf);
?>