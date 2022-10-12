<?php
function vert_line($pdf,$transdate_hor,$lines)
	{
	pdf_setlinewidth($pdf,"0.5");
	$start=492;
	$end=490-($lines*25.6);
		// Transdate before and after
	pdf_moveto($pdf,$transdate_hor-16,$start);
		pdf_lineto($pdf,$transdate_hor-16,$end);
		pdf_stroke($pdf);
		$transdate_hor+=58;
	pdf_moveto($pdf,$transdate_hor-7,$start);
		pdf_lineto($pdf,$transdate_hor-7,$end);
		pdf_stroke($pdf);
		// TransID
		$transdate_hor+=60;
	pdf_moveto($pdf,$transdate_hor,$start);
		pdf_lineto($pdf,$transdate_hor,$end);
		pdf_stroke($pdf);
		// Company
		$transdate_hor+=153;
	pdf_moveto($pdf,$transdate_hor,$start);
		pdf_lineto($pdf,$transdate_hor,$end);
		pdf_stroke($pdf);
		$transdate_hor+=37;
	pdf_moveto($pdf,$transdate_hor-2,$start);
		pdf_lineto($pdf,$transdate_hor-2,$end);
		pdf_stroke($pdf);
		// Center
		$transdate_hor+=63;
	pdf_moveto($pdf,$transdate_hor+2,$start);
		pdf_lineto($pdf,$transdate_hor+2,$end);
		pdf_stroke($pdf);
		$transdate_hor+=63;
	pdf_moveto($pdf,$transdate_hor,$start);
		pdf_lineto($pdf,$transdate_hor,$end);
		pdf_stroke($pdf);
		//Receipt
		$transdate_hor+=70;
	pdf_moveto($pdf,$transdate_hor,$start);
		pdf_lineto($pdf,$transdate_hor,$end);
		pdf_stroke($pdf);
	}


while($row=mysqli_fetch_assoc($result)){
	$array[]=$row;
	$pcard_array[]=$row['pcard_num'];
}
	$count_records=count($array);
	$pcard_num_array=array_count_values($pcard_array);
//echo "<pre>"; print_r($pcard_num_array); echo "</pre>";  exit;

//include("pcard_recon_pdf_cover.php");



// Make the invoice.	
$pdf = pdf_new(); include("/opt/library/prd/WebServer/include/pdf_key_23.php");
pdf_open_file ($pdf, "");

// Set the different PDF values.
pdf_set_info ($pdf, "Author", "Tom Howard");
pdf_set_info ($pdf, "Title", "Invoice for " . $array[0]['admin_num']);
pdf_set_info ($pdf, "Creator", "See Author");

// ******************** Start Loop ***************

$header_array=array("vendor_name","transdate","transid","item_purchased","company","ncasnum","center","code_1099","amount");

$cut=12;

// Create the page.
define ("PAGE_WIDTH", 792); // 11 inches
define ("PAGE_HEIGHT",612); // 8.5 inches
pdf_begin_page ($pdf, PAGE_WIDTH, PAGE_HEIGHT);
$new_page=1;

foreach($array as $num=>$value_array){
	
	$pcard_num=$array[$num]['pcard_num'];
	$transid=$array[$num]['transid'];
	$prev_transid=$array[$num-1]['transid'];
	$last_name=$array[$num]['last_name'];
	$first_name=$array[$num]['first_name'];
	
	$num_pages=ceil($pcard_num_array[$pcard_num]/($cut));
	$num_pages=2;
	if($num_pages==1){$single=1;}
	if($pageNum>=$num_pages){$pageNum=0;}
	
	if(($pcard_num!=$prev_pcard_num AND $num!=0) OR $cutRow>=$cut)
		{
			// Draw verticle lines
			$lines=$cutRow; if($cutRow==1){$lines=2;}
			vert_line($pdf,$transdate_hor,$lines-1);
	
				// first page
				$x=40; $y=150;$text="Reconciler Signature";
					pdf_show_xy ($pdf, $text, $x ,$y);
					pdf_moveto($pdf, 155, $y);
					pdf_lineto($pdf, 265, $y);
					pdf_stroke($pdf);
		
				$text="Date";
					pdf_show_xy ($pdf, $text, 274 ,$y);
					pdf_moveto($pdf, 300, $y);
					pdf_lineto($pdf, 370, $y);
					pdf_stroke($pdf);
		
				$text="Approver Signature";
					pdf_show_xy ($pdf, $text, 390 ,$y);
					pdf_moveto($pdf, 495, $y);
					pdf_lineto($pdf, 620, $y);
					pdf_stroke($pdf);
		
				$text="Date";
					pdf_show_xy ($pdf, $text, 630 ,$y);
					pdf_moveto($pdf, 660, $y);
					pdf_lineto($pdf, 720, $y);
					pdf_stroke($pdf);
		
$fontSize=9;
pdf_setfont ($pdf, $arial, $fontSize);
			//PDF_show_boxed ( $pdf , string $text , float $left , float $top , float $width , float $height , string $mode , string $feature )
			$text="(Cardholders cannot Approve their own Pcard forms.)";
				pdf_show_boxed ($pdf, $text, 450,125,700,20,"left","");
			$text="All purchases made with the State Purchasing Card are Sales Tax Exempt. If additional lines are needed, use another Pcard Reconciling Form to continue listing purchases.";
				pdf_show_boxed ($pdf, $text, 35 ,110,700,20,"left","");
			$text="Complete and submit this form along with the receipts within 5 - 7 business days from the date of purchase.";
				pdf_show_boxed ($pdf, $text, 50 ,90,700,20,"left","");
			$text="Sales/Order forms/Packing slips are not required for reconciling and CANNOT be used in place of the receipt.";	
	pdf_setfont ($pdf, $arialBold, $fontSize);
				pdf_show_boxed ($pdf, $text, 35 ,70,700,20,"left","");
			$text="Please remember that use of the procurement card is a privilege.";	
	pdf_show_boxed ($pdf, $text, 35 ,55,700,20,"left","");
				
			$text="The same purchasing laws, rules and policies still apply. The use of term contracts is mandatory by state law. State purchasing procedures and guidelines may not be circumvented by the use of the Purchasing Card. Anyone found in violation of these policies will be subject to having his/her card revoked and/or disciplinary action will be taken which could include termination.";	
	pdf_show_boxed ($pdf, $text, 35 ,35,700,20,"left","");
	
		pdf_end_page ($pdf);
		
			pdf_begin_page ($pdf, PAGE_WIDTH, PAGE_HEIGHT);
			$new_page=1;
			$cutRow=1;
		}
		// Set the default font from here on out.		
		$arial = pdf_findfont ($pdf, "Arial", "winansi");
		$arialBold = pdf_findfont ($pdf, "arialnb", "winansi");
		$arialItalic = pdf_findfont ($pdf, "Arial_Italic", "winansi");


if($new_page==1){
			$pageNum++;
$fontSize=8;
pdf_setfont ($pdf, $arial, $fontSize);
	$date=$array[$num]['report_date'];
$text="Report Date: Week Ending $date";
$widthText = pdf_stringwidth ($pdf, $text);// Width of Title
$ver=PAGE_HEIGHT-25;
pdf_show_xy ($pdf, $text, 15 ,$ver+2);

$fontSize=24;
pdf_setfont ($pdf, $arialBold, $fontSize);
$text="DPR";
pdf_show_xy ($pdf, $text, 200 ,$ver-11);
// last_name, first_name
$text=strtoupper($last_name.", ".$first_name);
pdf_show_xy ($pdf, $text, 300 ,$ver-11);


$fontSize=7;
pdf_setfont ($pdf, $arial, $fontSize);
$text="DIVISION";
pdf_show_xy ($pdf, $text, 205 ,$ver-21);
// last_name, first_name
$text="CARDHOLDER NAME (LAST, FIRST)";
pdf_show_xy ($pdf, $text, 320 ,$ver-21);

$fontSize=11;
pdf_setfont ($pdf, $arialBold, $fontSize);
$text="Page $pageNum of ".$num_pages;
pdf_show_xy ($pdf, $text, 710 ,$ver-21);

$fontSize=11;
pdf_setfont ($pdf, $arialBold, $fontSize);
$text="PURCHASING CARD RECONCILIATION FORM";
pdf_show_xy ($pdf, $text, 280 ,$ver-36);

pdf_setlinewidth($pdf,0.3);
pdf_moveto($pdf, 15, PAGE_HEIGHT-50);
		pdf_lineto($pdf, 770, PAGE_HEIGHT-50);
		pdf_stroke($pdf);
pdf_moveto($pdf, 15, PAGE_HEIGHT-65);
		pdf_lineto($pdf, 770, PAGE_HEIGHT-65);
		pdf_stroke($pdf);
pdf_moveto($pdf, 15, PAGE_HEIGHT-95);
		pdf_lineto($pdf, 770, PAGE_HEIGHT-95);
		pdf_stroke($pdf);


$fontSize=15;
pdf_setfont ($pdf, $arialBold, $fontSize);
$pcard=$array[$num]['pcard_num'];
	$new_pcard=substr($pcard,0,4)." ".substr($pcard,4,4)." ".substr($pcard,8,4)." ".substr($pcard,12,4);
	
$text="(1) PCARD #:  ".$new_pcard;
pdf_show_xy ($pdf, $text, 30 ,$ver-60);

$fontSize=10;
pdf_setfont ($pdf, $arialBold, $fontSize);
$text="(2) DIV CONTACT NAME:   RACHEL GOODING";
pdf_show_xy ($pdf, $text, 250 ,$ver-50);
$text="(3) PHONE #:     919-715-8706";
pdf_show_xy ($pdf, $text, 460 ,$ver-50);
$fontSize=12;
pdf_setfont ($pdf, $arialBold, $fontSize);
$text="(4) LOCATION:   ".$report_type."        (5) ADM: ".$array[$num]['admin_num'];
pdf_show_xy ($pdf, $text, 250 ,$ver-65);

$fontSize=10;
pdf_setfont ($pdf, $arialBold, $fontSize);
$hor=45; $ver=$ver-85;
$text="Vendor Name";
pdf_show_xy ($pdf, $text, $hor ,$ver);
$hor=200;  $transdate_hor=$hor;
$text="Transdate";
pdf_show_xy ($pdf, $text, $hor ,$ver);
$hor=270; 
$text="TransID";
pdf_show_xy ($pdf, $text, $hor ,$ver);
$hor=320; 
$text="(6) Item Purchased";
pdf_show_xy ($pdf, $text, $hor ,$ver);
$hor=450; 
$text="(7) Company";
pdf_show_xy ($pdf, $text, $hor ,$ver);
$hor=505; 
$text="(8) Account No.";
pdf_show_xy ($pdf, $text, $hor ,$ver);
$hor=577; 
$text="(9) Center";
pdf_show_xy ($pdf, $text, $hor ,$ver);
$hor=620; 
$text="(10) 1099 CODE";
pdf_show_xy ($pdf, $text, $hor ,$ver);
$hor=685;
$text="(11) Receipt Amount";
pdf_show_xy ($pdf, $text, $hor ,$ver);
$ver=$ver+15;
}// end header

$body_array=array("transdate"=>"187","transid"=>"255","vendor_name"=>"20","amount"=>"720","item_purchased"=>"320","company"=>"475","ncasnum"=>"513","center"=>"576");

$hor=1;
$fontSize=11;
pdf_setfont ($pdf, $arialBold, $fontSize);

$ver=$ver-26;
// Draw rectangle around each line
pdf_rect($pdf, 18, $ver-25.5, 750, 26);
  pdf_stroke($pdf);
  
	// display each value for a given row
	foreach($value_array as $key=>$value)
		{	
		if(!in_array($key,$header_array)){continue;}
			$text=trim($value);
			$width=$body_array[$key];
			$hor=$width;
			if($key==pa_number OR $key==re_number){
					$fontSize=11;
					pdf_setfont ($pdf, $arialBold, $fontSize);}
					else{
					$fontSize=12;
					$lead=$fontSize+2;
			//		pdf_setfont ($pdf, $arialBold, $fontSize);
					pdf_setfont ($pdf, $arial, $fontSize);
					}
			if($key=="vendor_name" OR $key=="ncas_description" OR $key=="item_purchased")
			{
			//PDF_show_boxed ( $pdf , string $text , float $left , float $top , float $width , float $height , string $mode , string $feature )
				pdf_show_boxed ($pdf, $text, $hor ,$ver-23,155,24,"left","");
			}
			else
			{
			//	if($key=="center" AND strlen($value_array['ncasnum'])>6){$hor+=0;}
				
				if($key=="ncasnum"){$hor-=3;}
				pdf_show_xy ($pdf, $text, $hor ,$ver-12);
				
				if($key=="amount")
					{
						$amount=$array[$num]['amount'];
						$prev_amount=$array[$num-1]['amount'];
					}
				if($key=="amount" AND $prev_transid==$transid)
					{
						if($xx==""){$total=$amount+$prev_amount;}
						else
						{$total+=$amount;}
						$xx=1;
					if($transid!=$array[$num+1]['transid']){$split=1;}
				}
			}
			
		}
				if($split)
					{
					pdf_setgray_fill($pdf, 0.9);
					pdf_rect($pdf, 350, $ver-37, 418, 11);
					pdf_fill($pdf);
 				
					pdf_setgray_fill($pdf, 0);
					$total=number_format($total,2);
					$text="TransID   $transid";				
					pdf_show_xy ($pdf, $text,350 ,$ver-36);
					$text="Total = ".$total;				
					pdf_show_xy ($pdf, $text,670 ,$ver-36);
					$cutRow=$cutRow+1.6; $total="";$xx="";
					$ver=$ver-14; $split="";
					
					}
	
	
	$prev_pcard_num=$pcard_num;
	$new_page="";
	
$cutRow++;
	
}// end loop of thru $array
		if($single==1){  // last page
		
				// Draw verticle lines
				vert_line($pdf,$transdate_hor,$cutRow-1);
	
				$x=40; $y=150;$text="Reconciler Signature";
					pdf_show_xy ($pdf, $text, $x ,$y);
					pdf_moveto($pdf, 155, $y);
					pdf_lineto($pdf, 265, $y);
					pdf_stroke($pdf);
		
				$text="Date";
					pdf_show_xy ($pdf, $text, 274 ,$y);
					pdf_moveto($pdf, 300, $y);
					pdf_lineto($pdf, 370, $y);
					pdf_stroke($pdf);
		
				$text="Approver Signature";
					pdf_show_xy ($pdf, $text, 390 ,$y);
					pdf_moveto($pdf, 495, $y);
					pdf_lineto($pdf, 620, $y);
					pdf_stroke($pdf);
		
				$text="Date";
					pdf_show_xy ($pdf, $text, 630 ,$y);
					pdf_moveto($pdf, 660, $y);
					pdf_lineto($pdf, 720, $y);
					pdf_stroke($pdf);
			
$fontSize=9;
pdf_setfont ($pdf, $arial, $fontSize);
			//PDF_show_boxed ( $pdf , string $text , float $left , float $top , float $width , float $height , string $mode , string $feature )
			$text="(Cardholders cannot Approve their own Pcard forms.)";
				pdf_show_boxed ($pdf, $text, 450,125,700,20,"left","");
			$text="All purchases made with the State Purchasing Card are Sales Tax Exempt. If additional lines are needed, use another Pcard Reconciling Form to continue listing purchases.";
				pdf_show_boxed ($pdf, $text, 35 ,110,700,20,"left","");
			$text="Complete and submit this form along with the receipts within 5 - 7 business days from the date of purchase.";
				pdf_show_boxed ($pdf, $text, 50 ,90,700,20,"left","");
			$text="Sales/Order forms/Packing slips are not required for reconciling and CANNOT be used in place of the receipt.";	
	pdf_setfont ($pdf, $arialBold, $fontSize);
				pdf_show_boxed ($pdf, $text, 35 ,70,700,20,"left","");
			$text="Please remember that use of the procurement card is a privilege.";	
	pdf_show_boxed ($pdf, $text, 35 ,55,700,20,"left","");
				
			$text="The same purchasing laws, rules and policies still apply. The use of term contracts is mandatory by state law. State purchasing procedures and guidelines may not be circumvented by the use of the Purchasing Card. Anyone found in violation of these policies will be subject to having his/her card revoked and/or disciplinary action will be taken which could include termination.";	
	pdf_show_boxed ($pdf, $text, 35 ,35,700,20,"left","");
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
