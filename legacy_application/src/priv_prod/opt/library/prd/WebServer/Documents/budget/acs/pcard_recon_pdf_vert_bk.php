<?php
//ini_set('display_errors',1);
while($row=mysqli_fetch_assoc($result)){
	$array[]=$row;
	$pcard_array[]=$row['pcard_num'];
}
	$count_records=count($array);
	$pcard_num_array=array_count_values($pcard_array);
//echo "<pre>"; print_r($array); echo "</pre>";  exit;

//include("pcard_recon_pdf_cover.php");



// Make the invoice.	
$pdf = pdf_new(); include("/opt/library/prd/WebServer/include/pdf_key_23.php");
pdf_open_file ($pdf, "");

// Set the different PDF values.
pdf_set_info ($pdf, "Author", "Tom Howard");
pdf_set_info ($pdf, "Title", "Invoice for " . $array[0]['admin_num']);
pdf_set_info ($pdf, "Creator", "See Author");

// ******************** Start Loop ***************

// original header array
//$header_array=array("vendor_name","transdate","transid","item_purchased","company","ncasnum","center","code_1099","amount");

$header_array=array("item_purchased","company","ncasnum","center","code_1099","amount");

$cut=10;

// Create the page.
define ("PAGE_WIDTH", 612); // 8.5 inches
define ("PAGE_HEIGHT", 792); // 11 inches
pdf_begin_page ($pdf, PAGE_WIDTH, PAGE_HEIGHT);
$new_page=1;
	
		$arial = PDF_load_font ($pdf, "Arial", "winansi","");
		$arialBold = PDF_load_font ($pdf, "arialnb", "winansi","");
		$arialItalic = PDF_load_font ($pdf, "Arial_Italic", "winansi","");
		$times = PDF_load_font ($pdf, "Times_New_Roman", "winansi","");
		$timesBold = PDF_load_font ($pdf, "Times_New_Roman_Bold", "winansi","");

foreach($array as $num=>$value_array){
	
	$pcard_num=$array[$num]['pcard_num'];
	$transid=$array[$num]['transid'];
	@$prev_transid=@$array[$num-1]['transid'];
	$last_name=$array[$num]['last_name'];
	$first_name=$array[$num]['first_name'];
	
	$num_pages=ceil($pcard_num_array[$pcard_num]/($cut));
	if($num_pages==1){$single=1;}
	if(@$pageNum>=$num_pages){$pageNum=0;}
	
	if(($pcard_num!=@$prev_pcard_num AND $num!=0) OR @$cutRow>=$cut)
		{
	
			$fontSize=9;
	pdf_setfont ($pdf, $times, $fontSize);
			//PDF_show_boxed ( $pdf , string $text , float $left , float $top , float $width , float $height , string $mode , string $feature )
			$text="*Do Not Use this form to reconcile purchases to Account Number 532711 - 532729 and 532930. A valid, approved Travel Reimbursement form should be used for these types of reconciliations.*";
				pdf_show_boxed ($pdf, $text, 150,255,400,20,"left","");
				
				$x=40; $y=230;$text="Justification:";
					pdf_show_xy ($pdf, $text, $x ,$y);
					$date=$array[$num]['report_date'];
					$text="Report date: Week ending $date";
					pdf_show_xy ($pdf, $text, $x+65 ,$y);
					$text="Reconciler Signature ______________________________ Date ___________";
					pdf_show_xy ($pdf, $text, $x+220 ,$y);
					
					pdf_rect($pdf, 100, 200, 450, 45); // rect.
 					 pdf_stroke($pdf);
					
					
				$x=40; $y=180;$text="Authorized Signature";
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
	
		pdf_end_page ($pdf);
		
			pdf_begin_page ($pdf, PAGE_WIDTH, PAGE_HEIGHT);
			$new_page=1;
			$cutRow=1;
		}
		// Set the default font from here on out.		
		$arial = PDF_load_font ($pdf, "Arial", "winansi","");
		$arialBold = PDF_load_font ($pdf, "arialnb", "winansi","");
		$arialItalic = PDF_load_font ($pdf, "Arial_Italic", "winansi","");
		$times = PDF_load_font ($pdf, "Times_New_Roman", "winansi","");
		$timesBold = PDF_load_font ($pdf, "Times_New_Roman_Bold", "winansi","");


$body_array=array("item_purchased"=>"30","company"=>"195","ncasnum"=>"280","center"=>"356","code_1099"=>"435","amount"=>"510");

if($new_page==1)
	{
				@$pageNum++;
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
						pdf_moveto($pdf, 153, $ver-78);
						pdf_lineto($pdf, 250, $ver-78);
						pdf_stroke($pdf);
	$text=$pcard;
	pdf_show_xy ($pdf, $text, 155 ,$ver-75);
	
	pdf_setfont ($pdf, $timesBold, $fontSize);
	$text="(2) DIV CONTACT NAME:   TAMMY DODD";
	pdf_show_xy ($pdf, $text, 290 ,$ver-75);
						pdf_moveto($pdf, 432, $ver-78);
						pdf_lineto($pdf, 491, $ver-78);
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
	
	pdf_setgray_fill($pdf, 0.9);
		pdf_rect($pdf, 25.5, 607.5, 564, 12);
		pdf_fill($pdf);
	pdf_setgray_fill($pdf, 0);
	
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
	$hor=430; 
	$text="(10) 1099 CODE";
	pdf_show_xy ($pdf, $text, $hor ,$ver);
	$hor=505; 
	$text="(11) Receipt Amount";
	pdf_show_xy ($pdf, $text, $hor ,$ver);
	
			
	// Draw horiz line
	pdf_moveto($pdf, 25, $ver-3);
			pdf_lineto($pdf, 590, $ver-4);
			pdf_stroke($pdf);
	}// end header

$hor=1;
$ver=$ver-13;

			$fontSize=10;
			pdf_setfont ($pdf, $arial, $fontSize);
		
	// display each value for a given row
	foreach($value_array as $key=>$value)
		{	
		if(!in_array($key,$header_array)){continue;}
			$text=trim($value);
			$width=$body_array[$key];
			$hor=$width;


			$str_length=round(pdf_stringwidth($pdf,$text,$arial,$fontSize));
					//$text=$str_length.$text; // 152 for item
				
				$item_lines=ceil($str_length/153); //$text=$item_lines.$text;
				if($item_lines<1){$item_lines=1;}
				if($item_lines>1)
					{//PDF_show_boxed ( $pdf , string $text , float $left , float $top , float $width , float $height , string $mode , string $feature )
					$var_height=($item_lines)*13;
					pdf_show_boxed ($pdf, $text, $hor,$ver-($var_height-11),150,$var_height,"left","");
					$ver=$ver-20;		
					
					}
					else
					{
					pdf_show_xy ($pdf, $text, $hor ,$ver);
					}
							
				
		// Draw vert line
		if($key=="amount" and $item_lines>1)
				{$var_height=0;$var_bottom=25;}else{$var_height=10;$var_bottom=3;}
				
			pdf_moveto($pdf,$width-5,$ver+$var_height);
				pdf_lineto($pdf,$width-5,$ver-$var_bottom);
					pdf_stroke($pdf);
				if($key=="amount")
					{
						$amount=$array[$num]['amount'];
						@$prev_amount=$array[$num-1]['amount'];
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
				if(@$split)
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

// Draw horiz line
pdf_moveto($pdf, 25, $ver-3);
		pdf_lineto($pdf, 590, $ver-3);
		pdf_stroke($pdf);
	
	
	$prev_pcard_num=$pcard_num;
	$new_page="";
	
@$cutRow++;

}// end loop of thru $array

	if($single==1)
			{
			$fontSize=9;
	pdf_setfont ($pdf, $times, $fontSize);
			//PDF_show_boxed ( $pdf , string $text , float $left , float $top , float $width , float $height , string $mode , string $feature )
			$text="*Do Not Use this form to reconcile purchases to Account Number 532711 - 532729 and 532930. A valid, approved Travel Reimbursement form should be used for these types of reconciliations.*";
				pdf_show_boxed ($pdf, $text, 150,255,400,20,"left","");
				
				$x=40; $y=230;$text="Justification:";
					pdf_show_xy ($pdf, $text, $x ,$y);
					$date=$array[$num]['report_date'];
					$text="Report date: Week ending $date";
					pdf_show_xy ($pdf, $text, $x+65 ,$y);
					$text="Reconciler Signature ______________________________ Date ___________";
					pdf_show_xy ($pdf, $text, $x+220 ,$y);
					
					pdf_rect($pdf, 100, 200, 450, 45); // rect.
 					 pdf_stroke($pdf);
					
				$x=40; $y=180;$text="Authorized Signature";
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