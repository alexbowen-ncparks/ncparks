<?php

// ******************** Header ***************
$start=0;
$ver=670;

	PDF_begin_page_ext($pdf, PAGE_WIDTH, PAGE_HEIGHT, "");
	
	$arial = PDF_load_font($pdf, "Arial", "winansi", "");
	$arialBold = PDF_load_font($pdf, "arialnb", "winansi", "");
	$font = PDF_load_font($pdf, "Helvetica-Bold", "winansi", "");
	
	$fontSize=12.0;
	PDF_setfont($pdf, $font, $fontSize);
	
	$text="Page $page_number of $totPageNum";
	$widthText = pdf_stringwidth ($pdf, $text, $font, $fontSize);
	$hor=(PAGE_WIDTH-$widthText-30);
	pdf_show_xy ($pdf, $text, $hor ,$ver+80);
	
	$text="Division: Parks & Recreation";
	$widthText = pdf_stringwidth ($pdf, $text, $font, $fontSize);
	$hor=15; $ver=$ver+80;
	pdf_show_xy ($pdf, $text, $hor ,$ver);	
	
	
	$text="Vendor Number:    ".$vendor_number;
	$widthText = pdf_stringwidth ($pdf, $text, $font, $fontSize);
	$hor=15; $ver=$ver-20;
	pdf_show_xy ($pdf, $text, $hor ,$ver);

	
	$hor=12+$widthText; 
	$text="Group Letter: ".$group_number;
	$widthText = pdf_stringwidth ($pdf, $text, $font, $fontSize);
	$hor=$hor+$widthText+45; $ver=$ver;
	pdf_show_xy ($pdf, $text, 248 ,$ver);
	
	
	// Header Box
	pdf_setlinewidth($pdf, 1);
	pdf_rect($pdf, 30, 680, 570, 30); //draw the rectangle 
	pdf_stroke($pdf);
	
	
	$cols=5;
	$ver=700;
	$hor=5; 
	$just_left=0; //left
	$just=50;// center
	
	$text="Amount";
	$xstart=120;
	text_block($pdf,$text,$cols,$hor+15,$ver-5,$xstart,$just);
	
	$text="Cr    ";
	$hor+=50; 
	$xstart=120;
	text_block($pdf,$text,$cols,$hor+10,$ver-5,$xstart,$just);
	
	$text="Budget Code";
	$hor+=30; 
	$xstart=120;
	text_block($pdf,$text,$cols,$hor+10,$ver-5,$xstart,$just);
	
	$text="Company";
	$hor+=60; 
	$xstart=120;
	text_block($pdf,$text,$cols,$hor+6,$ver-5,$xstart,$just);
	
	$text="Account";
	$hor+=70; 
	$xstart=120;
	text_block($pdf,$text,$cols,$hor,$ver-5,$xstart,$just);
	
	$text="Account Description";
	$hor+=90; 
	$xstart=220;
	text_block($pdf,$text,20,$hor,$ver-5,$xstart,$just);
	
	$text="Center";
	$hor+=198; 
	$xstart=120;
	text_block($pdf,$text,$cols,$hor,$ver-5,$xstart,$just);



?>