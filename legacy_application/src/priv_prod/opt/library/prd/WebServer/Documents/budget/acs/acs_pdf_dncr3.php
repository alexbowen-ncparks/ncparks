<?php

// Initialize some variables
$ncas_freightAmt="";
$grossAmt="";
$testText6a="";
$testText4="";
$comPrevious="";

// Set the constants and variables.
define ("PAGE_WIDTH", 792); // 11 inches landscape
define ("PAGE_HEIGHT",612); // 8.5 inches
$pdf = PDF_new(); include("/opt/library/prd/WebServer/include/pdf_key_23.php");

/*  open new PDF file; insert a file name to create the PDF on disk */
if (PDF_begin_document($pdf, "", "") == 0) {
    die("Error: " . PDF_get_errmsg($pdf));
}

PDF_set_info($pdf, "Creator", "DPR");
PDF_set_info($pdf, "Author", "Tom Howard");
PDF_set_info($pdf, "Title", "DNCR Invoice");


// *********** Start Records from Array ************
$line_y=492;
$fontSize=12.0;
$invoices_per_page=26;
$totPageNum=1;
$new_page=0;
$page_number=1;
$check_invoice_number="";

$number_of_invoices=mysqli_num_rows($result);
$totPageNum=ceil($number_of_invoices/$invoices_per_page);

// echo "$sql <pre>"; print_r($ARRAY); echo "</pre>";  exit;
foreach($ARRAY as $ncas_invoice_number=>$array1)
	{
	foreach($array1 as $index=>$array2)
		{
		// Counter
		$text=$index+1; 
		$counter=$text;
		if($new_page==0)
			{
			$vendor_number=$array2['vendor_number'];
			$group_number=$array2['group_number'];
			include("acs_pdf_dncr_header.php");
			PDF_setfont($pdf, $arial, $fontSize);
			}
		$new_page=1;
		extract($array2);
	
		
		$hor=70;
		$text=$counter;
		pdf_show_xy ($pdf, $text, $hor-40 ,$line_y);
	

		// Invoice ncas_invoice_amount
		$text=$ncas_invoice_amount; 
		$hor=70;
		$xstart=30;
		$just=100;
		text_block($pdf,$text,$cols,$hor,$line_y,$xstart,$just);
	
		// Invoice ncas_credit
		$text=$ncas_credit; 
		$hor=91;
		$xstart=30;
		$just=100;
		text_block($pdf,$text,$cols,$hor,$line_y,$xstart,$just);		
	
		// Invoice ncas_budget_code
		$text=$ncas_budget_code; 
		$hor=142;
		$xstart=30;
		$just=100;
		text_block($pdf,$text,$cols,$hor,$line_y,$xstart,$just);				
	
		// Invoice ncas_company
		$text=$ncas_company; 
		$hor=200;
		$xstart=30;
		$just=100;
		text_block($pdf,$text,$cols,$hor,$line_y,$xstart,$just);						
	
		// Invoice ncas_account
		$text=$ncas_account; 
		$hor=268;
		$xstart=30;
		$just=100;
		text_block($pdf,$text,$cols,$hor,$line_y,$xstart,$just);								
	
		// Invoice park_acct_desc
		$text=$park_acct_desc; 
		$hor=328;
		pdf_show_xy ($pdf, $text, $hor ,$line_y);
								
		// Center
		$text=$ncas_center." ".$ncas_invoice_number; 
		$hor=545;
		pdf_show_xy ($pdf, $text, $hor ,$line_y);
	
		$line_y=$line_y-18;
	
		$grossAmt+=$ncas_invoice_amount;
		$ncas_freightAmt+=$ncas_freight;
		
		$page_break=fmod(($index+1),$invoices_per_page);
		
		if($array1[$index]['ncas_invoice_number']!=$array1[$index+1]['ncas_invoice_number'])
			{
// 			echo "<pre>"; print_r($array1); echo "</pre>";  exit;
// 			echo $index." - ".$ARRAY[$ncas_invoice_number][$index]['ncas_invoice_number']." 2 ".$ARRAY[$ncas_invoice_number][$index-1]['ncas_invoice_number']; exit;
			}
		if(($page_break==0 and $totPageNum!=1) )
			{		
			PDF_end_page_ext($pdf, "");
			$line_y=492;
			$fontSize=12.0;
			$new_page=0;
			$page_number++;
			}
	
		}// end loop of pages
		
		$check_counter=$counter;
	} // end loop of ncas_invoice_number
$hor=300;
// ncas_freight ncas_invoice_amount
$text="Freight Amt = ".number_format($ncas_freightAmt,2);
$ver= pdf_get_value($pdf, "texty", 0);
pdf_show_xy ($pdf, $text, $hor-200 ,$ver-20);

// Gross ncas_invoice_amount
$text="Gross Amt = ".number_format($grossAmt,2);
pdf_show_xy ($pdf, $text, $hor-200 ,$ver-35);


// Gross ncas_invoice_amount
$text="Comment: ".$comments." ".$ncas_invoice_number;
pdf_show_xy ($pdf, $text, $hor ,$ver-20);

PDF_end_page_ext($pdf, "");	
PDF_end_document($pdf, "");

$buf = PDF_get_buffer($pdf);
$len = strlen($buf);

header("Content-type: application/pdf");
header("Content-Length: $len");
header("Content-Disposition: inline; filename=acs.pdf");
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

function text_block($pdf,$text,$cols,$xcrd,$ycrd,$xstart,$just)
	{
	$font_size=12;  //font size, used to space lines on y axis for Header row
	$tmplines = explode("\n",$text);
	for($j=0;$j<count($tmplines);$j++)
		{
		$tmptxt = explode(" ",$tmplines[$j]);
		$str="";
		for($i=0;$i<count($tmptxt);$i++)
			{
			if($str=="")
				{
				$str=sprintf("%s",$tmptxt[$i]);
				}
				else
				{
				$str=sprintf("%s %s",$str,$tmptxt[$i]);
				}
			if(isset($tmptxt[$i+1]) AND (strlen($str) + strlen($tmptxt[$i+1])) > $cols)
				{
				$ss=10;
				pdf_fit_textline($pdf,$str,$xcrd,$ycrd,"boxsize {".$xstart." $ss} position {".$just." 50}"); // for center
				$str="";
				$ycrd-=$font_size;
				}
			}
		$ss=10;
		pdf_fit_textline($pdf,$str,$xcrd,$ycrd,"boxsize {".$xstart." $ss} position {".$just." 50}");
		$ycrd-=$font_size;
		}
	return $ycrd;
	}
	

?>