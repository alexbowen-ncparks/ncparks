<?php
// ini_set('display_errors',1);
$database="pac";
include("../../../include/auth.inc"); // used to authenticate users
include("../../../include/get_parkcodes_dist.php"); // park names
// include("../../../include/iConnect.inc"); // database connection parameters
date_default_timezone_set('America/New_York');
$database="divper";
mysqli_select_db($connection,$database);

extract($_REQUEST);

// Update appointment date
$sql="UPDATE labels set pac_reappoint_date='".date("Y-m-d")."' where id='$id'";  //echo "$sql"; exit;
$result = mysqli_query($connection,$sql) or die (" Couldn't execute query. $sql");

// Update affiliation_code
$sql="UPDATE ignore labels_affiliation set affiliation_code='PAC' where person_id='$id' and affiliation_code='PAC_nomin'";  //echo "$sql"; exit;
$result = mysqli_query($connection,$sql) or die (" Couldn't execute query. $sql");


// Letter
$sql="SELECT letter_body as text from pac_letter";
$result = mysqli_query($connection,$sql) or die (" Couldn't execute query. $sql");
$row=mysqli_fetch_assoc($result); extract($row);

// Get Park Super. Info
$sql="SELECT t1.suffix as suffix_pasu, t1.Nname as Nname_pasu, t1.Fname as Fname_pasu,t1.Mname as Mname_pasu,t1.Lname as Lname_pasu,t1.email
from empinfo as t1
LEFT JOIN emplist as t2 on t1.tempID=t2.tempID
LEFT JOIN position as t3 on t2.beacon_num=t3.beacon_num
where t2.currPark='$parkcode' and t3.posTitle like 'Park Superintendent%'
order by o_chart"; //echo "$sql";exit;
$result = mysqli_query($connection,$sql) or die (" Couldn't execute query. $sql");
$num=mysqli_num_rows($result);

if($num<1){
	$parkcode=strtoupper($parkcode);
	$tempPASU=array("CACR"=>"WEWO","SARU"=>"CLNE","MOJE"=>"NERI");
	$temp_parkcode=$tempPASU[$parkcode];
	
	$sql="SELECT t1.suffix as suffix_pasu, t1.Nname as Nname_pasu, t1.Fname as Fname_pasu,t1.Mname as Mname_pasu,t1.Lname as Lname_pasu,t1.email
from empinfo as t1
LEFT JOIN emplist as t2 on t1.tempID=t2.tempID
LEFT JOIN position as t3 on t2.beacon_num=t3.beacon_num
where t2.currPark='$temp_parkcode' and t3.posTitle_reg='Park Superintendent'
order by o_chart"; //echo "$sql";exit;
$result = mysqli_query($connection,$sql) or die (" Couldn't execute query. $sql");
	
	}

$row=mysqli_fetch_assoc($result); extract($row);
//echo "<pre>"; print_r($row); echo "</pre>";  exit;

// Get Park contact Info
if(@$temp_parkcode){$pc=$temp_parkcode;}else{$pc=$parkcode;}
$sql="SELECT add1,add2,city,zip,ophone from dpr_system.dprunit where parkcode='$pc'";
$result = mysqli_query($connection,$sql) or die (" Couldn't execute query. $sql".mysqli_error());
$row=mysqli_fetch_assoc($result); extract($row);

// Get email
if(@$temp_parkcode){$pc=$temp_parkcode;}else{$pc=$parkcode;}
$sql="SELECT email from dpr_system.dprunit where parkcode='$pc'";
$result = mysqli_query($connection,$sql) or die (" Couldn't execute query. $sql".mysqli_error()); //echo "$sql";exit;
$row=mysqli_fetch_assoc($result); extract($row);


// Set the constants and variables.
define ("PAGE_WIDTH", 612); // 8.5 inches
define ("PAGE_HEIGHT",792); // 11 inches

$pdf = PDF_new(); include("/opt/library/prd/WebServer/include/pdf_key_23.php");

/*  open new PDF file; insert a file name to create the PDF on disk */
if (PDF_begin_document($pdf, "", "") == 0)
	{
		die("Error: " . PDF_get_errmsg($pdf));
	}

// Set the different PDF values.
pdf_set_info ($pdf, "Author", "Tom Howard");
pdf_set_info ($pdf, "Title", "PAC Letter");
pdf_set_info ($pdf, "Creator", "See Author");

// Set the default font from here on out.
$PATH="/opt/library/prd/WebServer/Documents/inc/fonts/";	
$times = PDF_load_font ($pdf, "Times New Roman", "winansi","");
$arial = PDF_load_font ($pdf, $PATH."Arial","winansi","");
$arialNarrow = PDF_load_font ($pdf, $PATH."Arial Narrow", "winansi","");


// Create the page.
PDF_begin_page_ext ($pdf, PAGE_WIDTH, PAGE_HEIGHT,"");

$fontSize=12;
pdf_setfont ($pdf, $times, $fontSize);

/*
// ************* DENR Logo
$im = PDF_load_image($pdf, auto, "DPRLetterhead2009_top.tiff", "");
pdf_place_image($pdf, $im, 50, 660, .70);
PDF_close_image($pdf, $im);

// ************* DPR Logo
//$im = PDF_load_image($pdf, auto, "DPR logo.tiff", "");
//pdf_place_image($pdf, $im, 464, 30, .10);
//PDF_close_image($pdf, $im);

*/

// Today's Date
date_default_timezone_set('America/New_York');
$today=date('F')." ".date('j').", ".date('Y');
pdf_show_xy($pdf, $today, 50, 608);
		


// *********** Address ****************************

// Get Person's Info
$sql="SELECT * from labels
where id='$id'";
$result1 = mysqli_query($connection,$sql) or die (" Couldn't execute query. $sql");
$personInfo=mysqli_fetch_assoc($result1);

if($personInfo['prefix']){$pi=$personInfo['prefix']." ";}

@$pi.=$personInfo['First_name'];
if($personInfo['M_initial']){$pi.=" ".$personInfo['M_initial'];}
$pi.=" ".$personInfo['Last_name'];

if($personInfo['suffix']){$pi.=", ".$personInfo['suffix'];}

$label_y=570;
pdf_show_xy($pdf, $pi, 50, $label_y);
$label_y-=14;
$add=$personInfo['address'];
$add_array=explode("\n",$add);
//echo "<pre>"; print_r($add_array); echo "</pre>";  exit;
$lines_of_address=count($add_array);
foreach($add_array as $k_add=>$v_add)
	{
	pdf_show_xy($pdf, $v_add, 50, $label_y);
	$label_y-=14;
	}
//$label_y-=14;
if($personInfo['state']=="NC"){$state="North Carolina";}
if($personInfo['state']=="SC"){$state="South Carolina";}
$add=$personInfo['city'].", ".$state." ".$personInfo['zip'];
pdf_show_xy($pdf, $add, 50, $label_y);

$label_y-=28;
$pi="Dear ".$personInfo['prefix']." ".$personInfo['Last_name'].":";
pdf_show_xy($pdf, $pi, 50, $label_y);


		
// *********** Body of Letter ****************************

// Replace type of letter

$appointType=$type;


$text=str_replace("*appointType*",$appointType,$text);

// Replace term length
$year=$personInfo['pac_term'];
$termArray=array("1"=>"one","2"=>"two","3"=>"three");
	if(array_key_exists($year,$termArray)){$year=$termArray[$year];}
$text=str_replace("*year*",$year,$text);

// Replace name of park
$park=$parkCodeName[$parkcode];
$text=str_replace("*park*",$park,$text);
if(@$temp_parkcode){
	$park1=$temp_parkcode;
	$park1=$parkCodeName[$park1];
	$text=str_replace("*park1*",$park1,$text);
	}
	else
	{$park1=$park;
	$text=str_replace("*park1*",$park1,$text);}
	
// Replace PASU full name
$fn=$Fname_pasu;
//if($Mname){$fn.=" ".$Mname[0].".";};
$fn.=" ".$Lname_pasu;
if($Nname_pasu){$fn=$Nname_pasu." ".$Lname_pasu;}
$text=str_replace("*fullname*",$fn,$text);

// Replace PASU last name
$text=str_replace("*lastname*",$Lname_pasu,$text);

// Replace park address
$pa=$add1;
if($add2){$pa.=", ".$add2;}
$pa.=", ".$city.", North Carolina, ".$zip;
$text=str_replace("*parkaddress*",$pa,$text);

// Replace office phone
$text=str_replace("*parkphone*",$ophone,$text);

// Replace email
if($email){$email=strtolower($email);}else{$email="???email???";}
$text=str_replace("*super_email*",$email,$text);

//echo "<pre>$label_y"; print_r($array); echo "</pre>";  exit;
$vs=70-(count($add_array)*12);
$verStart=$vs;
$ver=$verStart;//$modeB="left";
$widthB=500; $heightB=460; $hor=50;
$heightB=$label_y-70;
if($lines_of_address>2)
	{
	$heightB=$label_y-45;
	}
// echo "<pre>$label_y $heightB"; print_r($array); echo "</pre>";  exit;

pdf_show_boxed ($pdf, $text, $hor ,$ver,$widthB,$heightB,"left","");



// Get Director
$dir="Parks & Rec Division Dir";
//$dir="Environmental Program Supv IV";  was acting

$sql="SELECT t1.suffix,t1.Fname as Fname_dir,t1.Mname as Mname_dir,t1.Lname as Lname_dir,t1.email
from empinfo as t1
LEFT JOIN emplist as t2 on t1.tempID=t2.tempID
LEFT JOIN position as t3 on t2.beacon_num=t3.beacon_num
where  t3.beacon_num='60032778'";  //echo "$sql"; exit;
//where  t3.posTitle='$dir'";  echo "$sql"; exit;
$result = mysqli_query($connection,$sql) or die (" Couldn't execute query. $sql"); 
$row=mysqli_fetch_assoc($result); extract($row);

// $director="Carol A. Tingley";
$director=$Fname_dir." ".$Mname_dir.". ".$Lname_dir;

$new_y=270-(count($add_array)*12);

$new_y-=24;
pdf_show_xy($pdf, $director, 50, $new_y);

$add_division="Division of Parks and Recreation";
//$new_y-=14;
//pdf_show_xy($pdf, $add_division, 50, $new_y);

// $initials="CAT";
$initials=$Fname_dir[0].$Mname_dir[0].$Lname_dir[0];
$text=$initials."/ake";
pdf_show_xy($pdf, $text, 50, $new_y-26);

// Get CHOP
$sql="SELECT t1.suffix,t1.Fname as Fname_chop,t1.Mname as Mname_chop,t1.Lname as Lname_chop,t1.email, t1.Nname as Nname_chop
from empinfo as t1
LEFT JOIN emplist as t2 on t1.tempID=t2.tempID
LEFT JOIN position as t3 on t2.beacon_num=t3.beacon_num
where  t3.beacon_num='60033018'";
$result = mysqli_query($connection,$sql) or die (" Couldn't execute query. $sql"); 
if(mysqli_num_rows($result)<1)
	{
	$chop="cc:      John Fullwood, Acting Superintendent of State Parks";
	}
	else
	{
	$row=mysqli_fetch_assoc($result); 
	extract($row);
	$chop=$Nname_chop." ".$Lname_chop;
	// $chop="cc:      $chop, Chief of Operations";
	$chop="cc:      $chop, Deputy Director of Operations";
	}
pdf_show_xy($pdf, $chop, 50, $new_y-50);

$pc=strtoupper($parkcode);
if(in_array($pc,$arrayEADI)){$dist="EADI"; $district="East";}
if(in_array($pc,$arrayNODI)){$dist="NODI"; $district="North";}
if(in_array($pc,$arraySODI)){$dist="SODI"; $district="South";}
if(in_array($pc,$arrayWEDI)){$dist="WEDI"; $district="West";}
// if(in_array($pc,$arrayMORE)){$dist="MORE"; $district="Mountain";}
// if(in_array($pc,$arrayPIRE)){$dist="PIRE"; $district="Piedmont";}
// if(in_array($pc,$arrayCORE)){$dist="CORE"; $district="Coastal";}

// Get DISU
$sql="SELECT t1.suffix,t1.Fname as Fname_disu,t1.Mname as Mname_disu,t1.Lname as Lname_disu,t1.email
from empinfo as t1
LEFT JOIN emplist as t2 on t1.tempID=t2.tempID
LEFT JOIN position as t3 on t2.beacon_num=t3.beacon_num
where park='$dist' and t3.posTitle='Parks District Superintendent'"; // echo "$sql"; exit;
// where park='$dist' and t3.posTitle='Parks District Superintendent'";  echo "$sql"; exit;
$result = mysqli_query($connection,$sql) or die (" Couldn't execute query. $sql"); 
$row=mysqli_fetch_assoc($result); extract($row);

$disu=$Fname_disu." ".$Mname_disu.". ".$Lname_disu;
$disu="$disu, $district District Superintendent";
pdf_show_xy($pdf, $disu, 81, $new_y-64);


if($Nname_pasu){$Fname_pasu=$Nname_pasu;}
$super="$Fname_pasu $Lname_pasu, Superintendent, $park";
pdf_show_xy($pdf, $super, 81, $new_y-78);


/*
// ******** Footer *********
pdf_setColor($pdf, "fill", "rgb", 0, 0, 0.6,0);

$fontSize=10;
pdf_setfont ($pdf, $arialNarrow, $fontSize);

$verStart=30;
$ver=$verStart;$modeB="left";
$widthB=370; $heightB=40; $hor=65;
$text="    1615 Mail Service Center, Raleigh, North Carolina  27699-1615
Phone: 919-733-4181  |  FAX: 919-715-3085  |  Internet: ncparks.gov ";
//pdf_show_boxed ($pdf, $text, $hor ,$ver,$widthB,$heightB,"left","");


$fontSize=8;
pdf_setfont ($pdf, $arialNarrow, $fontSize);
$verStart=26;
$ver=$verStart;$modeB="left";
$widthB=370; $heightB=18; $hor=50;
$text="An Equal Opportunity | Affirmative Action Employer - 50% Recycled | 10% Post Consumer Paper";
//pdf_show_boxed ($pdf, $text, $hor ,$ver,$widthB,$heightB,"left","");
*/


// Finish the page
PDF_end_page_ext($pdf, "");

PDF_end_document($pdf, "");

// exit;

$buf = PDF_get_buffer($pdf);
$len = strlen($buf);

// Send the PDF to the browser.
$letter_title="PAC_letter_".$personInfo['Last_name'].".pdf";
header("Content-type: application/pdf");
header("Content-Length: $len");
header("Content-Disposition: inline; filename=$letter_title");
print $buf;

PDF_delete($pdf);

?>