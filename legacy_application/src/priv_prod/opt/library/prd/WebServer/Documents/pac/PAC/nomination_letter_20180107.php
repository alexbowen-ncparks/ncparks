<?php
ini_set('display_errors',1);
$database="pac";
include("../../../include/get_parkcodes_reg.php");

include("../../../include/auth.inc"); // used to authenticate users
include("../../../include/iConnect.inc"); 
mysqli_select_db($connection,'divper'); // database

extract($_REQUEST);

// Get CHOP
$sql="SELECT t1.suffix,t1.Fname as Fname_chop,t1.Mname as Mname_chop,t1.Lname as Lname_chop,t1.email
from empinfo as t1
LEFT JOIN emplist as t2 on t1.tempID=t2.tempID
LEFT JOIN position as t3 on t2.beacon_num=t3.beacon_num
where  t3.posTitle='Chief of Operations'";
// echo "$sql";
$result = mysqli_query($connection,$sql) or die (" Couldn't execute query. $sql".mysqli_error($connection)); 
$row=mysqli_fetch_assoc($result); extract($row);

$chop=$Fname_chop." ".$Mname_chop.". ".$Lname_chop;
$chop="$chop, Chief of Operations";


$pc=strtoupper($parkcode);
if(in_array($pc,$arrayCORE)){$reg="CORE"; $region="Coastal";}
if(in_array($pc,$arrayPIRE)){$reg="PIRE"; $region="Piedmont";}
if(in_array($pc,$arrayMORE)){$reg="MORE"; $region="Mountain";}

// Get DISU
$sql="SELECT t1.suffix,t1.Fname as Fname_disu,t1.Mname as Mname_disu,t1.Lname as Lname_disu,t1.email
from empinfo as t1
LEFT JOIN emplist as t2 on t1.tempID=t2.tempID
LEFT JOIN position as t3 on t2.beacon_num=t3.beacon_num
where park_reg='$reg' and t3.posTitle_reg='Parks Region Superintendent'";
// echo "$sql";
$result = mysqli_query($connection,$sql) or die (" Couldn't execute query. $sql".mysqli_error($connection)); 
$row=mysqli_fetch_assoc($result); extract($row);

$resu=$Fname_disu." ".$Mname_disu.". ".$Lname_disu;
$disu="$resu, $region Region Superintendent";

// Get Park Super. Info
$sql="SELECT t1.suffix,t1.Fname,t1.Mname,t1.Lname,t1.email,t2.currPark as parkcode
from empinfo as t1
LEFT JOIN emplist as t2 on t1.tempID=t2.tempID
LEFT JOIN position as t3 on t2.beacon_num=t3.beacon_num
where t2.currPark='$parkcode' and t3.posTitle_reg='Park Superintendent'
order by o_chart";
// echo "$sql";
$result = mysqli_query($connection,$sql) or die (" Couldn't execute query. $sql".mysqli_error($connection)); 
$num=mysqli_num_rows($result);

if($num<1 AND $parkcode=="SARU")
	{
	$sql="SELECT t1.suffix,t1.Fname,t1.Mname,t1.Lname,t1.email,t2.currPark as parkcode
from empinfo as t1
LEFT JOIN emplist as t2 on t1.tempID=t2.tempID
LEFT JOIN position as t3 on t2.beacon_num=t3.beacon_num
where t2.currPark='CLNE' and t3.posTitle='Park Superintendent'
order by o_chart";
$result = mysqli_query($connection,$sql) or die (" Couldn't execute query. $sql".mysqli_error($connection)); 
}
$row=mysqli_fetch_assoc($result); extract($row);

$super="$Fname $Mname. $Lname, $parkcode Park Superintendent";

// Get Park contact Info
$sql="SELECT add1,add2,city,zip,ophone,email from dpr_system.dprunit where parkcode='$parkcode'";
// echo "$sql";
$result = mysqli_query($connection,$sql) or die (" Couldn't execute query. ");
$row=mysqli_fetch_assoc($result); extract($row);

// Get email
// $sql="SELECT add1,add2,city,zip,ophone from dpr_system.dprunit where parkcode='$parkcode'";
// $result = mysqli_query($connection,$sql) or die (" Couldn't execute query. $sql");
// $row=mysqli_fetch_assoc($result); extract($row);


// Set the constants and variables.
define ("PAGE_WIDTH", 612); // 8.5 inches
define ("PAGE_HEIGHT",792); // 11 inches

// Make the invoice.	
$pdf = pdf_new(); include("/opt/library/prd/WebServer/include/pdf_key_23.php");
pdf_open_file ($pdf, "");

// Set the different PDF values.
pdf_set_info ($pdf, "Author", "Tom Howard");
pdf_set_info ($pdf, "Title", "Labels for DPR Steward");
pdf_set_info ($pdf, "Creator", "See Author");


// Create the page.
pdf_begin_page ($pdf, PAGE_WIDTH, PAGE_HEIGHT);

		// Set the default font from here on out.
$PATH="/opt/library/prd/WebServer/Documents/inc/fonts/";
$times = PDF_load_font ($pdf, "Times New Roman", "winansi","");

$fontSize=12;
pdf_setfont ($pdf, $times, $fontSize);

date_default_timezone_set('America/New_York');

// Division
$text="DIVISION OF PARKS AND RECREATION";
pdf_show_xy($pdf, $text, 210, 750);
		
// Today's Date
$today=date('F')." ".date('d').", ".date('Y');
pdf_show_xy($pdf, $today, 267, 725);
		

// MEMORANDUM
pdf_set_parameter($pdf,"underline","true");
$text="E-MEMORANDUM"; $y=680;
pdf_show_xy($pdf, $text, 50, $y);
pdf_set_parameter($pdf,"underline","false");
		
// TO CHOP
$text="TO:"; $y=640;
pdf_show_xy($pdf, $text, 50, $y);
$text=$chop;
pdf_show_xy($pdf, $text, 140, $y);
		
// THROUGH DISU
$text="THROUGH:"; $y-=20;
pdf_show_xy($pdf, $text, 50, $y);
$text=$disu;
pdf_show_xy($pdf, $text, 140, $y);
		
// FROM PASU
$text="FROM:"; $y-=20;
pdf_show_xy($pdf, $text, 50, $y);
$text=$super;
pdf_show_xy($pdf, $text, 140, $y);
		
// SUBJECT
$text="SUBJECT:"; $y-=20;
pdf_show_xy($pdf, $text, 50, $y);
$text=$parkcode." Park Advisory Committee Nomination";
pdf_show_xy($pdf, $text, 140, $y);

// INTRO
$sql="SELECT pac_comments from labels where id='$id'";
$result = mysqli_query($connection,$sql) or die (" Couldn't execute query. $sql ".mysqli_error($connection)); 
$row=mysqli_fetch_assoc($result); extract($row);

$text=$pac_comments;

$fontSize=11;
pdf_setfont ($pdf, $times, $fontSize);

$line_width = 500.0;
$line_height = (3*$fontSize);
$x = 50.0;
$y = 530.0;
$nr = pdf_show_boxed($pdf, $text, $x, $y, $line_width, $line_height, "left","");

$y = $y - $line_height;

while($nr > 0){
$nr = pdf_show_boxed($pdf, substr($text, -$nr), $x, $y, $line_width , $line_height, "left","");
$y = $y - $line_height;
}
// *********** Nominee Info ****************************
$sql="SELECT * from labels where id='$id'";
$result = mysqli_query($connection,$sql) or die (" Couldn't execute query. $sql ".mysqli_error($connection)); 
$row=mysqli_fetch_assoc($result); extract($row);

$y=$y + $fontSize;

$line_spacing=$fontSize+2;
// Interest Represented
$text="Interest Represented:";  $y;
// pass top of second column
$top2col=$y;
pdf_show_xy($pdf, $text, 50,   $y);
$text=$interest_group;
pdf_show_xy($pdf, $text, 160,   $y);

// Person Replaced
$text="Person Replaced:";   $y-=$line_spacing;
pdf_show_xy($pdf, $text, 50,   $y);
$text=$pac_replacement;
pdf_show_xy($pdf, $text, 160,   $y);

// Expiration Date
$text="Expiration Date:";   $y-=$line_spacing;
pdf_show_xy($pdf, $text, 50,   $y);
$text=$pac_terminates;
pdf_show_xy($pdf, $text, 160,   $y);

// Term
$text="Term:";   $y-=$line_spacing;
pdf_show_xy($pdf, $text, 50,   $y);
if($pac_term=="two"||$pac_term=="three"){$term="years";}else{$term="year";}
$text=$pac_term." ".$term;
pdf_show_xy($pdf, $text, 160,   $y);

// Nominee
// Reset to next column
$y=$top2col;
$x2=260;
$text="Nominee:"; 
pdf_show_xy($pdf, $text, $x2,   $y);
$text=$First_name." ".$Last_name;
pdf_show_xy($pdf, $text, $x2+55,   $y);

// Address
$text="Address:";   $y-=$line_spacing;
pdf_show_xy($pdf, $text, $x2,   $y);
$text=$address; $text=str_replace("\r\n",", ",$text);
pdf_show_xy($pdf, $text, $x2+55,   $y);
   $y-=$line_spacing;
$text=$city.", " .$state." ".$zip;
pdf_show_xy($pdf, $text, $x2+55,   $y);

// Telephone Number
$text="Telephone:";   $y-=$line_spacing;
pdf_show_xy($pdf, $text, $x2,   $y);
$text=$phone;
pdf_show_xy($pdf, $text, $x2+55,   $y);

// Email
$text="Email:";   $y-=$line_spacing;
pdf_show_xy($pdf, $text, $x2,   $y);
$text=$email;
pdf_show_xy($pdf, $text, $x2+55,   $y);

// Employer
$text="Employer:";   $y-=$line_spacing;
pdf_show_xy($pdf, $text, $x2,   $y);
$text=$employer;
pdf_show_xy($pdf, $text, $x2+55,   $y);


		
// *********** Body of Letter ****************************

$text=$pac_nomination;
$line_width = 500.0;

$x = 50.0;

$box_height=650-$y-$fontSize;
while (pdf_show_boxed($pdf, $text, $x, $box_height, $line_width , $box_height, "left","blind")>0){
$box_height += $fontSize;
}

$boxLowY=$y-$box_height-(2*$fontSize);
pdf_show_boxed($pdf, $text, $x, $boxLowY, $line_width , $box_height, "left","");

$i=0;
$members="";

$sql="SELECT * from labels
LEFT JOIN labels_affiliation on labels_affiliation.person_id=labels.id
where labels.park='$parkcode' and labels_affiliation.affiliation_code='PAC' order by pac_ex_officio, last_name";
$result = mysqli_query($connection,$sql) or die (" Couldn't execute query. $sql ".mysqli_error($connection)); 
// echo "$sql"; exit;
	while($row=mysqli_fetch_assoc($result))
		{
		$i++;
		extract($row);
		
		if(!empty($pac_ex_officio))
			{$members.="      $i. ".$First_name." ".$Last_name." - ".$interest_group." -  EX OFFICIO "."\n";}
			ELSE
			{$members.="      $i. ".$First_name." ".$Last_name." - ".$interest_group." - ".$pac_term." year term ends ".$pac_terminates."\n";}
		}

$text="Current list of PAC membership:
";
$text.=$members;

$box_height=$fontSize;
while (pdf_show_boxed($pdf, $text, $x, $box_height, $line_width , $box_height, "left","blind")>0){
$box_height += $fontSize;
}

$boxLowY=$boxLowY-$box_height+(2*$fontSize);
pdf_show_boxed($pdf, $text, $x, $boxLowY, $line_width , $box_height, "left","");


$fontSize=9;
pdf_setfont ($pdf, $times, $fontSize);

$text="A signed copy of this e-memorandum retained on permanent file at $park by $super.";
pdf_show_xy($pdf, $text, '50', '25');

// Finish the page
pdf_end_page ($pdf);


// Close the PDF
pdf_close ($pdf);

// exit;

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