<?php
//echo "<pre>"; print_r($_REQUEST); echo "</pre>";  exit;
//These are placed outside of the webserver directory for security
ini_set('display_errors',1);
$database="pac";
include("../../../include/auth.inc"); // used to authenticate users
include("../../../include/connectROOT.inc"); // database connection parameters
include("../../../include/get_parkcodes.php"); // park names

date_default_timezone_set('America/New_York');

$title="PAC"; 
include("/opt/library/prd/WebServer/Documents/_base_top_pac.php");
echo "<body>";
echo "<table><tr><td><font color='green'>Click your browser's back button to return to list to return to PAC form.</font></td><td><form action='home.php?submit_label=Home+Page'>
		<input type='submit' name='submit' value='Home'  style=\"background-color:#E9967A\"></form></td></tr></table><hr />";
		
$database="divper";
mysql_select_db($database,$connection);
extract($_REQUEST);
if(!@$submit){
		echo "<form method='POST'><table>";
		
		echo "<tr><td<font color='red'>Complete the information necessary for printing a PAC meeting agenda.</font>
		</td></tr>";
		
		echo "<tr><td>
		Date: (Thursday, May 22, 2009) <input type='text' name='passDate' value='' size='35'>
		</td></tr>";
		
		echo "<tr><td>
		Time: (7:00 p.m.) <input type='text' name='passTime' value=''>
		</td></tr>";
		
		echo "<tr><td>
		Location: (the Park Office)<input type='text' name='passLocation' value='' size='45'>
		</td></tr>";
		
		echo "<tr><td>
		Optional Paragraph:<br /><textarea name='passOption' rows='10' cols='80'></textarea>
		</td></tr>";
		
		echo "<tr><td>
		Proposed Agenda: add agenda items from the Director/CHOP/DISU/PASU<br /><textarea name='passAgenda' rows='10' cols='80'></textarea>
		</td></tr>";
		
		echo "<tr><td>
		<input type='hidden' name='parkcode' value='$parkcode'>
		<input type='submit' name='submit' value='Submit'>
		</td></tr></table></form>";
		if($_SESSION['pac']['level']>4){
			include("pac_letters.php");
			}
		exit;
		}

if(!$passDate.!$passTime.!$passLocation.!$passAgenda){
		echo "One of these items was not entered:
			Date, Time, Location, and/or Proposed Agenda<br /><br />
			Click your browser's BACK button.";
			exit;
		}

// Letter
$sql="SELECT agenda_body from pac_letter";
$result = mysql_query($sql) or die ("c=$connection Couldn't execute query. $sql");
$row=mysql_fetch_assoc($result); extract($row);

// Get Park Super. Info
$sql="SELECT t1.suffix,t1.Fname,t1.Mname,t1.Lname,t1.email,t1.Nname
from empinfo as t1
LEFT JOIN emplist as t2 on t1.tempID=t2.tempID
LEFT JOIN position as t3 on t2.beacon_num=t3.beacon_num
where t2.currPark='$parkcode' and t3.posTitle='Park Superintendent'
order by o_chart";
$result = mysql_query($sql) or die ("c=$connection Couldn't execute query. $sql");  
$row=mysql_fetch_assoc($result); extract($row);

// Get Park contact Info
$sql="SELECT add1,add2,city, zip,ophone,email from dpr_system.dprunit where parkcode='$parkcode'";
$result = mysql_query($sql) or die ("c=$connection Couldn't execute query. $sql ".mysql_error());
$row=mysql_fetch_assoc($result);
extract($row);
$passAdd=$add1; 
if(@$add){$passAdd.=", ".$add2;}

$state="NC";
if($state=="NC"){$state="North Carolina";}
if($state=="SC"){$state="South Carolina";}
$passCSZ=$city.", ".$state."  ".$zip;

// Get email
$sql="SELECT add1,add2,city,zip,ophone from dpr_system.dprunit where parkcode='$parkcode'";
$result = mysql_query($sql) or die ("c=$connection Couldn't execute query. $sql");
$row=mysql_fetch_assoc($result); extract($row);


// Set the constants and variables.
define ("PAGE_WIDTH", 612); // 8.5 inches
define ("PAGE_HEIGHT",792); // 11 inches

// Make the invoice.	
$pdf = pdf_new(); include("/opt/library/prd/WebServer/include/pdf_key_23.php");
pdf_open_file ($pdf, "");

// Set the different PDF values.
pdf_set_info ($pdf, "Author", "Tom Howard");
pdf_set_info ($pdf, "Title", "PAC Agenda Letter");
pdf_set_info ($pdf, "Creator", "See Author");


// *******  Multi Page

// Get People
$sql="SELECT id from labels
LEFT JOIN labels_affiliation as t2 on t2.person_id=labels.id
where park='$parkcode' and t2.affiliation_code='PAC'";
$result1 = mysql_query($sql) or die ("c=$connection Couldn't execute query. $sql");

while($row=mysql_fetch_assoc($result1))
	{
	$people_array[]=$row['id'];
	}

//echo "<pre>"; print_r($people_array); echo "</pre>";  exit;

// Set the default font from here on out.
$PATH="/opt/library/prd/WebServer/Documents/inc/fonts/";	
$times = PDF_load_font ($pdf, "Times New Roman", "winansi","");
$arial = PDF_load_font ($pdf, $PATH."Arial","winansi","");
$arialNarrow = PDF_load_font ($pdf, $PATH."Arial Narrow", "winansi","");

foreach($people_array as $k=>$id){
// Create the page.
pdf_begin_page ($pdf, PAGE_WIDTH, PAGE_HEIGHT);

$fontSize=12;
pdf_setfont ($pdf, $times, $fontSize);


// ************* DENR Logo
$im = PDF_load_image($pdf, "auto", "DPRLetterhead2009_top.tiff", "");
pdf_place_image($pdf, $im, 72, 657, .65);
PDF_close_image($pdf, $im);

// ************* DPR Logo
$im = PDF_load_image($pdf, "auto", "DPR logo.tiff", "");
pdf_place_image($pdf, $im, 464, 30, .10);
PDF_close_image($pdf, $im);


// Today's Date
$today=date('F')." ".date('d').", ".date('Y');
pdf_show_xy($pdf, $today, 50, 645);

// *********** Address ****************************

// Get Person's Info
$sql="SELECT * from labels
LEFT JOIN labels_affiliation as t2 on t2.person_id=labels.id
where labels.id='$id'";
$result1 = mysql_query($sql) or die ("c=$connection Couldn't execute query. $sql");
$personInfo=mysql_fetch_assoc($result1);
		$piY=620;
if($personInfo['prefix']){$pi=$personInfo['prefix']." ";}
$pi=$personInfo['First_name'];
if($personInfo['M_initial']){$pi.=" ".$personInfo['M_initial'];}
$pi.=" ".$personInfo['Last_name'];
pdf_show_xy($pdf, $pi, 50, $piY);

$add=$personInfo['address'];
pdf_show_xy($pdf, $add, 50, $piY-14);

$add=$personInfo['city'].", North Carolina ".$personInfo['zip'];
pdf_show_xy($pdf, $add, 50, $piY-28);


$pi="Dear ".$personInfo['prefix']." ".$personInfo['Last_name'].":";
pdf_show_xy($pdf, $pi, 50, $piY-60);


// *********** Body of Letter ****************************

// Replace name of park
$park=$parkCodeName[$parkcode];
$agenda_body=str_replace("*park*",$park,$agenda_body);

// Replace full name
$fn=$Fname;
if($Mname){$fn.=" ".$Mname[0].".";};
$fn.=" ".$Lname;
$agenda_body=str_replace("*fullname*",$fn,$agenda_body);

// Replace last name
$agenda_body=str_replace("*lastname*",$Lname,$agenda_body);

// Replace park address
$pa=$add1;
if($add2){$pa.=" ".$add2;}
$pa.=", ".$city.", North Carolina, ".$zip;
$agenda_body=str_replace("*parkaddress*",$pa,$agenda_body);

// Replace office phone
$agenda_body=str_replace("*parkphone*",$ophone,$agenda_body);

// Replace email
if($email){$email="<".strtolower($email).">";}else{$email="???email???";}
$agenda_body=str_replace("*super_email*",$email,$agenda_body);

// Replace date
$agenda_body=str_replace("*date*",$passDate,$agenda_body);

// Replace time
$agenda_body=str_replace("*time*",$passTime,$agenda_body);

// Replace location
$agenda_body=str_replace("*location*",$passLocation,$agenda_body);

if($passOption){
	$agenda_body=str_replace("*optional_paragraph*",$passOption,$agenda_body);
			}else{				$agenda_body=str_replace("*optional_paragraph*","\r\r",$agenda_body);
			$agenda_body=str_replace("\n\r\n\r\r\r","",$agenda_body);
			}
			
if($passAgenda){
	$agenda_body=str_replace("*agenda_items*",$passAgenda,$agenda_body);
			}
if($Nname){$Fname=$Nname;}
$super="$Fname $Lname, Superintendent, $park";
	$agenda_body=str_replace("*super*",$super,$agenda_body);
	$agenda_body=str_replace("*address*",$passAdd,$agenda_body);
	$agenda_body=str_replace("*citystatezip*",$passCSZ,$agenda_body);
	
$verStart=50;
$ver=$verStart;$modeB="left";
$widthB=500;
$heightB=500;
$hor=50;
pdf_show_boxed ($pdf, $agenda_body, $hor ,$ver,$widthB,$heightB,"left","");


// ******** Footer *********
pdf_setColor($pdf, "fill", "rgb", 0, 0, 0.6,0);

$fontSize=10;
pdf_setfont ($pdf, $arialNarrow, $fontSize);

$verStart=30;
$ver=$verStart;$modeB="left";
$widthB=370; $heightB=40; $hor=65;
$text="    1615 Mail Service Center, Raleigh, North Carolina  27699-1615
Phone: 919-733-4181    FAX: 919-715-3085    Internet: ncparks.gov ";
pdf_show_boxed ($pdf, $text, $hor ,$ver,$widthB,$heightB,"left","");


$fontSize=8;
pdf_setfont ($pdf, $arialNarrow, $fontSize);
$verStart=26;
$ver=$verStart;$modeB="left";
$widthB=370; $heightB=18; $hor=50;
$text="An Equal Opportunity  Affirmative Action Employer - 50% Recycled  10% Post Consumer Paper";
pdf_show_boxed ($pdf, $text, $hor ,$ver,$widthB,$heightB,"left","");


// Finish the page
pdf_end_page ($pdf);

}// end foreach

// Close the PDF
pdf_close ($pdf);

//exit;
// Send the PDF to the browser.
$buffer = pdf_get_buffer ($pdf);
$letter_title="PAC_letter_".$personInfo['Last_name'].".pdf";
header ("Content-type: application/pdf");
header ("Content-Length: " . strlen($buffer));
header ("Content-Disposition: inline; filename=$letter_title");
echo $buffer;

// Free the resources
pdf_delete ($pdf);

?>