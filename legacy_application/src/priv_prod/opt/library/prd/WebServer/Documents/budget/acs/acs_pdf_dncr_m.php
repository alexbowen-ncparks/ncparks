<?php

// ini_set('display_errors',1);
// $num_lines=array_count_values($cvip_id_array);
// echo "<pre>"; print_r($cvip_invoice_array); echo "</pre>";  exit;
// echo "cvip_invoice_array<pre>"; print_r($cvip_invoice_array); echo "</pre>"; // exit;
// echo "<pre>"; print_r($num_lines); echo "</pre>"; // exit;
// echo "<pre>"; print_r($inv_ncas_invoice_number_array); echo "</pre>";  //exit;

// ******************** Start Loop ***************

// *********** Start Records from Array ************

$invoices_per_page=26;
$totPageNum=1;
$new_page=0;
$page_number=1;

// $number_of_invoices=count($inv_ncas_invoice_number_array);
// $totPageNum=ceil($number_of_invoices/$invoices_per_page);

foreach($cvip_invoice_array as $ncas_invoice_number=>$array)
	{
	$line_y=660;
	PDF_begin_page_ext($pdf, PAGE_WIDTH, PAGE_HEIGHT, "");
	
	$arial = PDF_load_font($pdf, "Arial", "winansi", "");
	$arialBold = PDF_load_font($pdf, "arialnb", "winansi", "");
	$font = PDF_load_font($pdf, "Helvetica-Bold", "winansi", "");
	
		$fontSize=12.0;
	PDF_setfont($pdf, $font, $fontSize);
	
	$font = PDF_load_font($pdf, "Arial", "winansi", "");
		$fontSize=10.0;
	PDF_setfont($pdf, $font, $fontSize);
	
// 	$text="Page 1 of Invoice Number: $ncas_invoice_number";
	$text="Page 1 of 1";
	$widthText = pdf_stringwidth ($pdf, $text, $font, $fontSize);
	$hor=(PAGE_WIDTH-$widthText-30);
	pdf_show_xy ($pdf, $text, $hor ,750);

	$grossAmt="";
	$ncas_freightAmt="";
	foreach($array as $index=>$id)
		{	
		$where=" where cid_vendor_invoice_payments.id='$id'";
		$sql = "$select
		$JOIN
		$where
		order by ncas_invoice_number";
	// echo "$sql"; exit;
		$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql");
		$result1 = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql");
		$num=mysqli_num_rows($result);
		$totPageNum=ceil($num/16);

		// get vendor number and group number
		$row1=mysqli_fetch_array($result1);
		$vendor_number=$row1['vendor_number'];
		$group_number=$row1['group_number'];
	
		include("acs_pdf_dncr_m_header.php");
	
		while($row=mysqli_fetch_array($result))
			{
			extract($row);
	
			// Invoice ncas_invoice_amount
			$text=$ncas_invoice_amount; 
			$hor=70;
			$xstart=30;
			$just=100;
			$cols=5;
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
			$hor=308;
			pdf_show_xy ($pdf, $text, $hor ,$line_y);
							
			// Center
			$text=$ncas_center; 
			$hor=545;
			pdf_show_xy ($pdf, $text, $hor ,$line_y);

			$line_y=$line_y-18;

			$grossAmt+=$ncas_invoice_amount;
			$ncas_freightAmt+=$ncas_freight;

			}

		}
		
	$hor=300;

	// Gross ncas_invoice_amount
	$text="Gross Amt = ".number_format($grossAmt,2);
	$ver= pdf_get_value($pdf, "texty", 0);
	pdf_show_xy ($pdf, $text, $hor-200 ,$ver-35);

	// Gross ncas_invoice_amount
	$text="Comment: ".$comments;
	// pdf_show_xy ($pdf, $text, $hor ,$ver-20);
	text_block($pdf,$text,50,250,$line_y-15,200,0);
	
	
	
	// end page	
		PDF_end_page_ext($pdf, "");
	}// end loop of pages

?>