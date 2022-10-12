<?php
session_start();
if($_SESSION['donation']['level']<4){echo "Login required";exit;}
ini_set('display_errors',1);
extract ($_REQUEST);
date_default_timezone_set('America/New_York');

if(empty($connection))
	{
	$db="divper";
	include("../../include/iConnect.inc"); // database connection parameters
	}

// Set the constants and variables.

define ("PAGE_WIDTH", 792); // 11 inches
define ("PAGE_HEIGHT",612); // 8.5 inches

// Create the Page.	
$pdf = pdf_new(); include("/opt/library/prd/WebServer/include/pdf_key_23.php");
pdf_open_file ($pdf, "");

// Set the different PDF values.
pdf_set_info ($pdf, "Author", "Tom Howard");
pdf_set_info ($pdf, "Title", "NC DPR Donation Database");
pdf_set_info ($pdf, "Creator", "See Author");

// Create the page.
PDF_begin_page_ext ($pdf, PAGE_WIDTH, PAGE_HEIGHT,"");

		// Set the fonts
		$helveticaBold = PDF_load_font($pdf, "Helvetica-Bold", "winansi", "");
		$helveticaItalic = PDF_load_font($pdf, "Helvetica-Oblique", "winansi", "");
		$helvetica = PDF_load_font($pdf, "Helvetica", "winansi", "");
		$times = PDF_load_font($pdf, "Times", "winansi", "");
		$timesItalic = PDF_load_font($pdf, "Times-Italic", "winansi", "");
		$timesBoldItalic = PDF_load_font($pdf, "Times-BoldItalic", "winansi", "");
	
	
		
	// $file and $donation_type sent from Reports page
	$pdf_file=$file."_pdf.php";
	if(empty($donation_type)){echo "No donation type specified."; exit;}
	include($pdf_file);




// Add Footer

	pdf_setfont ($pdf, $times, 10);
	$y=20;

if(@$no_date=="")
	{
	$today=getdate();
	$wd=$today['weekday'];
	$d=$today['mday'];
	$m=$today['month'];
	$yr=$today['year'];
	$h=$today['hours'];
	$min=$today['minutes'];
	$s=$today['seconds'];
	$s=str_pad($s, 2, "0", STR_PAD_LEFT);
	$min=str_pad($min, 2, "0", STR_PAD_LEFT);
	$h=str_pad($h, 2, "0", STR_PAD_LEFT);
	$local=localtime();
	$st=$local['8'];
	if($st==0){$st="EST";}else{$st="EDST";}
	$text="Created on ".$wd.", ".$d." ".$m." ".$yr." @ ".$h.":".$min.":".$s." ".$st;
	pdf_show_xy ($pdf,$text,260,$y);
	}
	
$text="NC State Parks System";
	//	pdf_show_xy ($pdf,$text,250,$y);
		pdf_show_xy ($pdf,$text,50,$y);
$file=$_SERVER['PHP_SELF'];
$text="https://10.35.152.9".$file;
$text="https://10.35.152.9".$file;
		pdf_show_xy ($pdf,$text,510,$y);

//exit;

// Finish the page
pdf_end_page ($pdf);

// Close the PDF
pdf_close ($pdf);

//echo "This exit is used to find any PHP warnings that prevents a successful PDF.  If all errors/warnings are fixed the PDF should be created."; exit;

// Send the PDF to the browser.
$buffer = pdf_get_buffer ($pdf);
$filename=$donation_type."_by_donor_type.pdf";
header ("Content-type: application/pdf");
header ("Content-Length: " . strlen($buffer));
header ("Content-Disposition: inline; filename=$filename");
echo $buffer;

// Free the resources
pdf_delete ($pdf);

mysqli_close($connection);
?>