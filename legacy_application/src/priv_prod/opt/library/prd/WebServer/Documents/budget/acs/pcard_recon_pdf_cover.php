<?php 

while($row=mysqli_fetch_assoc($result)){
	$array[]=$row;
	$pcard_array[]=$row['pcard_num'];
}
	$count_records=count($array);
	$pcard_num_array=array_count_values($pcard_array);
//echo "<pre>"; print_r($pcard_num_array); echo "</pre>";  exit;

define ("PAGE_WIDTH", 612); // 8.5 inches
define ("PAGE_HEIGHT", 792); // 11 inches

// Make the invoice.	
$pdf = pdf_new(); include("/opt/library/prd/WebServer/include/pdf_key_23.php");
pdf_open_file ($pdf, "");

// Set the different PDF values.
pdf_set_info ($pdf, "Author", "Tom Howard");
pdf_set_info ($pdf, "Title", "Invoice for " . $vendor_name);
pdf_set_info ($pdf, "Creator", "See Author");

// ******************** Start Loop ***************

$header_array=array("vendor_name","transdate","transid","item_purchased","company","ncasnum","center","code_1099","amount");

$cut=12;

// Create the page.
pdf_begin_page ($pdf, PAGE_WIDTH, PAGE_HEIGHT);
$new_page=1;

foreach($array as $num=>$value_array){
	
	$pcard_num=$array[$num]['pcard_num'];
	$transid=$array[$num]['transid'];
	$prev_transid=$array[$num-1]['transid'];
	$last_name=$array[$num]['last_name'];
	$first_name=$array[$num]['first_name'];
	
	$num_pages=ceil($pcard_num_array[$pcard_num]/($cut));
	if($num_pages==1){$single=1;}
	if($pageNum>=$num_pages){$pageNum=0;}
	
		// Set the default font from here on out.		
//		$arial = pdf_findfont ($pdf, "Arial", "winansi");
//		$arialBold = pdf_findfont ($pdf, "arialnb", "winansi");
//		$arialItalic = pdf_findfont ($pdf, "Arial_Italic", "winansi");
		$times = pdf_findfont ($pdf, "Times_New_Roman", "winansi");
		$timesBold = pdf_findfont ($pdf, "Times_New_Roman_Bold", "winansi");
if(($pcard_num!=$prev_pcard_num AND $num!=0) OR $cutRow>=$cut)
		{
	
		pdf_end_page ($pdf);
		
			pdf_begin_page ($pdf, PAGE_WIDTH, PAGE_HEIGHT);
			$new_page=1;
			$cutRow=1;
		}

if($new_page==1){
			$pageNum++;
$ver=PAGE_HEIGHT-61;

$fontSize=23;
pdf_setfont ($pdf, $timesBold, $fontSize);
$text="DPR";
pdf_show_xy ($pdf, $text, 52 ,$ver-11);

$text=strtoupper($last_name.", ".$first_name); // last_name, first_name
pdf_show_xy ($pdf, $text, 143 ,$ver-11);

pdf_setlinewidth($pdf,4);
pdf_rect($pdf, 45, $ver-18, 63, 28); // division
  pdf_stroke($pdf);
pdf_rect($pdf, 135, $ver-18, 400, 28); // name
  pdf_stroke($pdf);

$fontSize=7;
pdf_setfont ($pdf, $times, $fontSize);
$text="DIVISION";
pdf_show_xy ($pdf, $text, 67 ,$ver-28);
// last_name, first_name
$text="CARDHOLDER NAME (LAST, FIRST)";
pdf_show_xy ($pdf, $text, 190 ,$ver-28);


$fontSize=14;
pdf_setfont ($pdf, $timesBold, $fontSize);
$text="PURCHASING CARD RECONCILIATION FORM";
pdf_show_xy ($pdf, $text, 160 ,$ver-47);

pdf_setlinewidth($pdf,0.5);

pdf_rect($pdf, 25, $ver-454, 565, 420); // page rect
  pdf_stroke($pdf);

pdf_moveto($pdf, 25, PAGE_HEIGHT-112);
		pdf_lineto($pdf, 590, PAGE_HEIGHT-112);
		pdf_stroke($pdf);

pdf_moveto($pdf, 25, PAGE_HEIGHT-172); //abover Headers
		pdf_lineto($pdf, 590, PAGE_HEIGHT-172);
		pdf_stroke($pdf);

$fontSize=11;
pdf_setfont ($pdf, $timesBold, $fontSize);
$pcard=$array[$num]['pcard_num'];
	$new_pcard=substr($pcard,0,4)." ".substr($pcard,4,4)." ".substr($pcard,8,4)." ".substr($pcard,12,4);
	
$text="(1) PCARD #:";
pdf_show_xy ($pdf, $text, 70 ,$ver-75);
					pdf_moveto($pdf, 153, $ver-76);
					pdf_lineto($pdf, 250, $ver-76);
					pdf_stroke($pdf);
$text=$pcard;
pdf_show_xy ($pdf, $text, 155 ,$ver-75);

pdf_setfont ($pdf, $timesBold, $fontSize);
$text="(2) DIV CONTACT NAME:   EVA ENNIS";
pdf_show_xy ($pdf, $text, 290 ,$ver-75);
					pdf_moveto($pdf, 432, $ver-76);
					pdf_lineto($pdf, 491, $ver-76);
					pdf_stroke($pdf);

$text="(3) PHONE #:";
pdf_show_xy ($pdf, $text, 70 ,$ver-100);
$text="919-715-8706";
pdf_show_xy ($pdf, $text, 155 ,$ver-100);
					pdf_moveto($pdf, 153, $ver-102);
					pdf_lineto($pdf, 220, $ver-102);
					pdf_stroke($pdf);

pdf_setfont ($pdf, $timesBold, $fontSize);
$text="(4) LOCATION:   ".$report_type."          (5) ADM:   ".$array[$num]['admin_num'];
pdf_show_xy ($pdf, $text, 290 ,$ver-100);
					pdf_moveto($pdf, 378, $ver-102);
					pdf_lineto($pdf, 400, $ver-102);
					pdf_stroke($pdf);
					
					pdf_moveto($pdf, 482, $ver-102);
					pdf_lineto($pdf, 511, $ver-102);
					pdf_stroke($pdf);

$fontSize=9;
pdf_setfont ($pdf, $timesBold, $fontSize);
$hor=27; $ver=$ver-120;
$text="(6) ITEM PURCHASED:";
pdf_show_xy ($pdf, $text, $hor ,$ver);
$hor=180;  $transdate_hor=$hor;
$text="(7) COMPANY";
pdf_show_xy ($pdf, $text, $hor ,$ver);
$hor=255; 
$text="*(8) ACCOUNT NO.";
pdf_show_xy ($pdf, $text, $hor ,$ver);
$hor=350; 
$text="*(9) CENTER";
pdf_show_xy ($pdf, $text, $hor ,$ver);
$hor=420; 
$text="(10) 1099 CODE";
pdf_show_xy ($pdf, $text, $hor ,$ver);
$hor=495; 
$text="(11) Receipt Amount";
pdf_show_xy ($pdf, $text, $hor ,$ver);
$ver=$ver+15;
}// end header

$body_array=array("transdate"=>"187","transid"=>"255","vendor_name"=>"20","amount"=>"720","item_purchased"=>"320","company"=>"475","ncasnum"=>"513","center"=>"576");

$hor=1;
$fontSize=11;
pdf_setfont ($pdf, $timesBold, $fontSize);
  
	$count_array=range(1,22);
	$line_y=620;
	foreach($count_array as $key=>$value)
		{
		pdf_moveto($pdf, 25, $line_y-=14);
		pdf_lineto($pdf, 590, $line_y);
		pdf_stroke($pdf);
		}
	
	$count_array=array(175,250,348,417,493);
	foreach($count_array as $key=>$value)
		{
		pdf_moveto($pdf, $value, PAGE_HEIGHT-172);
		pdf_lineto($pdf, $value, PAGE_HEIGHT-486);
		pdf_stroke($pdf);
		}

$fontSize=9;
pdf_setfont ($pdf, $times, $fontSize);
			//PDF_show_boxed ( $pdf , string $text , float $left , float $top , float $width , float $height , string $mode , string $feature )
			$text="*Do Not Use this form to reconcile purchases to Account Number 532711 - 532729 and 532930. A valid, approved Travel Reimbursement form should be used for these types fo reconciliations.*";
				pdf_show_boxed ($pdf, $text, 150,255,400,20,"left","");
				
				$x=40; $y=230;$text="Justification:";
					pdf_show_xy ($pdf, $text, $x ,$y);
					pdf_rect($pdf, 100, 200, 450, 40); // rect.
 					 pdf_stroke($pdf);
					
				$x=40; $y=180;$text="Supervisor Signature";
					pdf_show_xy ($pdf, $text, $x ,$y);
					pdf_moveto($pdf, 130, $y);
					pdf_lineto($pdf, 265, $y);
					pdf_stroke($pdf);
		
				$text="Date";
					pdf_show_xy ($pdf, $text, 274 ,$y);
					pdf_moveto($pdf, 300, $y);
					pdf_lineto($pdf, 370, $y);
					pdf_stroke($pdf);
			
			//PDF_show_boxed ( $pdf , string $text , float $left , float $top , float $width , float $height , string $mode , string $feature )
			$text="(Cardholders cannot Approve their own Pcard forms.)";
			
$fontSize=8;
pdf_setfont ($pdf, $times, $fontSize);
					pdf_show_xy ($pdf, $text, 105 ,$y-10);

$fontSize=9;
pdf_setfont ($pdf, $times, $fontSize);					
			$text="All purchases made with the State Purchasing Card are Sales Tax Exempt. If additional lines are needed, use another Pcard Reconciling Form to continue listing purchases.  Complete and submit this form along with the receipts within 5 - 7 business days from the date of purchase.";
				pdf_show_boxed ($pdf, $text, 100 ,130,450,30,"left","");
			
			$text="Sales/Order forms/Packing slips are not required for reconciling and CANNOT be used in place of the receipt.";	
	pdf_setfont ($pdf, $timesBold, $fontSize);
				pdf_show_boxed ($pdf, $text, 100 ,95,450,20,"left","");
				
			$text="Please remember that use of the procurement card is a privilege.";	
				
			$text.="  The same purchasing laws, rules and policies still apply. The use of term contracts is mandatory by state law. State purchasing procedures and guidelines may not be circumvented by the use of the Purchasing Card. Anyone found in violation of these policies will be subject to having his/her card revoked and/or disciplinary action will be taken which could include termination.";	
	pdf_show_boxed ($pdf, $text, 100 ,50,450,40,"left","");		
	$prev_pcard_num=$pcard_num;
	$new_page="";
	
$cutRow++;
	
}// end loop of thru $array
	
					
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