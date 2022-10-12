<?php

if(!isset($connection))
	{
	$database="second_employ";
	include("../../include/iConnect.inc");// database connection parameters
	extract($_REQUEST);
	}
//echo "<pre>"; print_r($_POST); echo "</pre>"; // exit;
date_default_timezone_set('America/New_York');
$year=date("Y");
if(empty($var_status))
	{$var_status="Pending";}
$db = mysqli_select_db($connection,$database)
       or die ("Couldn't select database $database");
$sql = "SELECT id, se_dpr, park_code, name, position, supervisor_approval, PASU_approval, DISU_approval, CHOP_approval, HR_approval, Director_approval, status
FROM se_list 
where 1 and id='$edit'
";
$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql");
if(mysqli_num_rows($result)<1){echo "No secodary employment requests for $year with a status of $var_status."; exit;}
$row=mysqli_fetch_assoc($result);
extract($row);


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
pdf_set_info ($pdf, "Title", "NC DPR Secondary Employment Request");
pdf_set_info ($pdf, "Creator", "See Author");


// ******************** Start Loop ***************
$start=0;
$pageNum=1;
$index=0;


	// Set the default font from here on out.
$PATH="/opt/library/prd/WebServer/Documents/inc/fonts/";
$arial = PDF_load_font($pdf, $PATH."Arial", "winansi", "");
$arial_bold = PDF_load_font($pdf, $PATH."arial_bold", "winansi", "");
$arial_italic = PDF_load_font($pdf, $PATH."Arial_Italic", "winansi", "");


$fontSize=10;
$leading=$fontSize+3;


// Create the page.
PDF_begin_page_ext($pdf, PAGE_WIDTH, PAGE_HEIGHT, "");


pdf_setfont ($pdf, $arial, $fontSize);
		
$verStart=PAGE_HEIGHT-60;
$ver=$verStart;
$hor=16;
$add_hor=16;
$page_break=PAGE_HEIGHT-5;
$rr=0;

//pdf_setcolor($pdf, "both", "rgb", 0.8, 0.8, 0.8, 0.8);
//pdf_rect($pdf, $hor, $ver+23, 750, 18);
//pdf_fill_stroke($pdf);
pdf_setcolor($pdf, "both", "rgb", 0, 0, 0, 0);

$y=750;
$text="Department of Natural and Cultural Resources";
pdf_show_xy($pdf,$text,30, $y);

$y-=20;
$text="Division of Parks and Recreation";
pdf_show_xy($pdf,$text,30, $y);

$y-=20;
$text="Name:  ".$name;
pdf_show_xy($pdf,$text,45, $y);

$y-=20;
$text="Position:  ".$position;
pdf_show_xy($pdf,$text,45, $y);

$y-=20;
$text="Supervisor Approval:  ".$supervisor_approval;
pdf_show_xy($pdf,$text,45, $y);

$y-=20;
$text="Park Superintendent Approval:  ".$PASU_approval;
pdf_show_xy($pdf,$text,45, $y);

$y-=20;
$text="District Superintendent Approval:  ".$DISU_approval;
pdf_show_xy($pdf,$text,45, $y);

$y-=20;
$text="Chief of Operations Approval:  ".$CHOP_approval;
pdf_show_xy($pdf,$text,45, $y);

$y-=20;
$text="Human Resources Approval:  ".$HR_approval;
pdf_show_xy($pdf,$text,45, $y);

$y-=20;
$text="Director Approval:  ".$Director_approval;
pdf_show_xy($pdf,$text,45, $y);





// pdf_moveto($pdf, 65, 519);
// pdf_lineto($pdf, 280, 519);
// pdf_stroke($pdf);


		
// Finish the page
PDF_end_page_ext($pdf, "");

PDF_end_document($pdf, "");

//exit;

$buf = PDF_get_buffer($pdf);
$len = strlen($buf);

//$ran=rand(1000,9999);
$file_name="DPR_Sec_Employment.pdf";
header("Content-type: application/pdf");
header("Content-Length: $len");
header("Content-Disposition: inline; filename=$file_name");
print $buf;

PDF_delete($pdf);


//header("Location: edit.php?edit=$id&submit=edit&message=1");

/*This function is the replacement for the deprecated PDF_find_font()

And also here is the 'core font' list, for PDF files, these do not need to be embeded:
- Courier
- Courier-Bold
- Courier-Oblique
- Courier-BoldOblique
- Helvetica
- Helvetica-Bold
- Helvetica-Oblique
- Helvetica-BoldOblique
- Times-Roman
- Times-Bold
- Times-Italic
- Times-BoldItalic
- Symbol
- ZapfDingbats
*/
?>