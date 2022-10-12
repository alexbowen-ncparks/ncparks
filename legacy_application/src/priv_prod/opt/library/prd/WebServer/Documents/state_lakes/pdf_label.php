<?php
// $num obtained from calling page

$totPageNum=ceil($num/30);

//$affPrint=array("PAC","RRS","CWMTF","PARTF","NHTF","FSP");


//echo "$num  $totPageNum <pre>";print_r($pier_number);echo "</pre>";  exit;

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
pdf_set_info ($pdf, "Title", "Labels for DPR");
pdf_set_info ($pdf, "Creator", "See Author");


// ******************** Start Loop ***************
$start=0;
$pageNum=1;
$index=0;


	// Set the default font from here on out.
$PATH="/opt/library/prd/WebServer/Documents/inc/fonts/";
$arial = PDF_load_font($pdf, $PATH."Arial", "winansi", "");


for($p=0;$p<$totPageNum;$p++)
	{
	// Create the page.
	PDF_begin_page_ext($pdf, PAGE_WIDTH, PAGE_HEIGHT, "");
	
	$fontSize=10;
	$lead=$fontSize+3;
	pdf_setfont ($pdf, $arial, $fontSize);
			
	$verStart=PAGE_HEIGHT-60;
	$ver=$verStart;
	$hor=3;
	$add_hor=16;
	$hor=$hor+$add_hor;
	$rr=0;

// *********** Start Records from Arrays ************
	
if($totPageNum>1)
	{
	if($p==0)
		{
		$end=$start+7;
		$r=0;
		}
		else
		{
		@$numLines=$numLines-$start;
		$end=$start+$numLines;
		}
	}
	else
	{
	@$end=$numLines;
	$r=0;
	}

$r=0;	
	for($xx=0;$xx<30;$xx++)
		{
		
		if($rr<10)
			{
			$hor=3;
			$hor=$add_hor;
			}
		
		if($rr==10){$ver=$verStart;}
			if($rr>9 and $rr<20)
				{
				$hor=199;
				$hor=$hor+$add_hor;
				}
		
		if($rr==20){$ver=$verStart;}
			if($rr>19)
				{
				$hor=399;
				$hor=$hor+$add_hor;
				}
		
		@$var_pn=$ARRAY[$index]['object_number'];
		@$var_park=$ARRAY[$index]['park'];
		@$var_fname=$ARRAY[$index]['First_name'];
		@$var_lname=$ARRAY[$index]['Last_name'];
		
		if(isset($var_pn))
		{
		// Make Label
			$text="$object #: ".$var_pn."     ".$var_park;
		pdf_show_xy($pdf,$text,$hor,$ver);
			$text=$var_lname.", ".$var_fname;
		pdf_show_xy($pdf,$text,$hor,$ver-12);
		}
	
		
		$start++;
		$r++;
		$rr++;
		$index++;
		$ver=$ver-72;
		}// end for
	
	
	// Finish the page
	PDF_end_page_ext($pdf, "");
	
	$pageNum++;
	
	}
PDF_end_document($pdf, "");

$buf = PDF_get_buffer($pdf);
$len = strlen($buf);

header("Content-type: application/pdf");
header("Content-Length: $len");
header("Content-Disposition: inline; filename=hello.pdf");
print $buf;

PDF_delete($pdf);

/*This function is the replacement for the depracated PDF_find_font()

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