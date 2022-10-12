<?php
extract($_REQUEST);

//ini_set('display_errors,',1);
// echo "<pre>";print_r($_REQUEST);"</pre>"; exit;
$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database 

if(isset($vendor_number))
	{
	$vendor_number=trim($vendor_number);
	$select="SELECT * From cid_vendor_invoice_payments ";
	$where="where cid_vendor_invoice_payments.vendor_number='$vendor_number' AND due_date='$due_date'";
	}
else
	{	
	if($prepared_by=="Barbara Adams"||$prepared_by=="Pamela Laurence")
		{
		$pb="(prepared_by='Barbara Adams' OR prepared_by='Pamela Laurence')";
		}
	else
		{
		$pb="prepared_by='$prepared_by'";
		}
	
	$vendor_name=urldecode($vendor_name);
	$vendor_name=addslashes($vendor_name);
	$select="SELECT cid_vendor_invoice_payments.*,coa.park_acct_desc
	From cid_vendor_invoice_payments ";
	$where="where vendor_name='$vendor_name' AND due_date='$due_date' AND $pb";}


$JOIN="LEFT JOIN coa on cid_vendor_invoice_payments.ncas_account = coa.ncasnum";

$sql = "$select
$JOIN
$where
order by ncas_invoice_number, (po_line1+0)";

//   echo "$sql"; exit;

$result = mysqli_query($connection, $sql) or die ("Couldn't execute query. $sql");

$num=mysqli_num_rows($result);

// Max number of rows per page
$maxRowNum=20;
$totPageNum=ceil($num/$maxRowNum);

while($row=mysqli_fetch_array($result)){
extract($row);
if($project_number){$ncas_rcc="";}//PARTF Center just equals Fund
$inv_num[]=$ncas_invoice_number;
$inv_date[]=$ncas_invoice_date;
$inv_amt[]=$invoice_total;
$inv_com[]=$ncas_company;
$inv_ncas_freight[]=$ncas_freight;
$inv_account[]=$prefix.$ncas_number;
$inv_center[]=$ncas_fund.$ncas_rcc;
$inv_accrual[]=$ncas_accrual_code;
$inv_ncas_accrual_code[]=$ncas_accrual_code;
$inv_ncas_credit[]=$ncas_credit;
$inv_po_line1[]=$po_line1;
$inv_acct_desc[]=$park_acct_desc;

// Set new variables so any one record with values gets printed
// otherwise ONLY values, if any, from the last record would print
if($new_vendor){$nv=$new_vendor;}else{$nv="";}
if($ncas_county_code){$cc=$ncas_county_code;}
if($ncas_remit_code){$rc=$ncas_remit_code;}
	if(!empty($ncas_remit_park)){$rp=$ncas_remit_park;}
	
if(@$comPrevious!=$comments){
if($comments){@$cf.=$comments." ";}}
$comPrevious=$comments;
if($fas_num){$cf.="^".$fas_num;}
if($ncas_buy_entity){$be=$ncas_buy_entity;}else{$be="";}
if($ncas_po_number){$po=$ncas_po_number;}
if($part_pay){$pp=$part_pay;}
if($project_number){$pn=$project_number;}
if($group_number){$vg=$group_number;}
if($sheet){$sh=$sheet;}


if(@$fy){$po_fy=$fy;}
if(@$po_line1){$po1=$po_line1;}
if(@$po_line2){$po2=$po_line2;}
if(@$po_line3){$po3=$po_line3;}
if(@$amt1){$po_amt1=$amt1;}
if(@$amt2){$po_amt2=$amt2;}
if(@$amt3){$po_amt3=$amt3;}

}
//echo "<pre>";print_r($inv_center);"</pre>"; exit;
//if(in_array("4S62",$inv_center)){$land_message="Land=yes"; echo $land_message; exit;} 
if(in_array("4S62",$inv_center)){$land_message_line1="***MUST BE A HARD CHECK (NO ELECTRONIC PAYMENTS)";} 
if(in_array("4S62",$inv_center)){$land_message_line2="***NO CHECKS MAILED DIRECTLY TO VENDOR, THEY GO TO STATE PROPERTY OFFICE";} 
if(in_array("4S62",$inv_center)){$land_message_line3="***MUST USE STATE PROPERTY FILE# (DO NOT USE BACK UP INVOICE#'S)";} 
if(in_array("4S62",$inv_center)){$land_message_line4="***ONLY ONE INVOICE PER CHECK REGARDLESS IF SEVERAL GOING TO SAME VENDOR";} 
if(in_array("4S62",$inv_center)){$land_message_line5="***F1=FORCE PAY ONLY ONE CHECK";} 
if(in_array("4S62",$inv_center)){$land_message_line6="***NET=NET ALL PAYMENTS";} 
if(in_array("4S62",$inv_center)){$land_message_line7="***E-PAY=NO ELECTRONIC PAYMENTS FOR THIS INVOICE";} 
// Set the constants and variables.
define ("PAGE_WIDTH", 612); // 11 inches portrait
define ("PAGE_HEIGHT",792); // 8.5 inches

// Make the invoice.	
$pdf = pdf_new(); include("/opt/library/prd/WebServer/include/pdf_key_23.php");
pdf_open_file ($pdf, "");

// Set the different PDF values.
pdf_set_info ($pdf, "Author", "Tom Howard");
pdf_set_info ($pdf, "Title", "Invoice for " . $vendor_name);
pdf_set_info ($pdf, "Creator", "See Author");

// ******************** Start Loop ***************
$start=0;
$pageNum=1;

for($p=0;$p<$totPageNum;$p++)
	{
	// Create the page.
	pdf_begin_page ($pdf, PAGE_WIDTH, PAGE_HEIGHT);
	
			// Set the default font from here on out.		
			
	$arial = PDF_load_font($pdf, "Arial", "winansi", "");
	$arialBold = PDF_load_font($pdf, "arialnb", "winansi", "");
	$font = PDF_load_font($pdf, "Helvetica-Bold", "winansi", "");
	
	$fontSize=12;
	$lead=$fontSize+3;
	pdf_setfont ($pdf, $arialBold, $fontSize);
				
	$text="DEPARTMENT OF NATURAL AND CULTURAL RESOURCES";
	$widthText = pdf_stringwidth ($pdf, $text, $arialBold, $fontSize);// Width of Title
	$hor=(PAGE_WIDTH-$widthText)/2;
	$ver=PAGE_HEIGHT-25;
	pdf_show_xy ($pdf, $text, $hor ,$ver);
	
	$fontSize=10;
	pdf_setfont ($pdf, $arial, $fontSize);
	$text="Page $pageNum of $totPageNum";
	$widthText = pdf_stringwidth ($pdf, $text, $arialBold, $fontSize);// Width of Title
	$hor=(PAGE_WIDTH-$widthText-20);
	pdf_show_xy ($pdf, $text, $hor ,$ver);
	
	$fontSize=12;
	pdf_setfont ($pdf, $arialBold, $fontSize);
	$text="Capital Improvements";
	$widthText = pdf_stringwidth ($pdf, $text, $arialBold, $fontSize);// Width of Title
	$hor=(PAGE_WIDTH-$widthText)/2;
	$ver=$ver-$lead+2;
	pdf_show_xy ($pdf, $text, $hor ,$ver);
	
	//$fontSize=10;
	$text="CASH DISBURSEMENTS CODE SHEET";
	$widthText = pdf_stringwidth ($pdf, $text, $arialBold, $fontSize);
	$hor=(PAGE_WIDTH-$widthText)/2;
	$ver=$ver-$lead+2;
	pdf_show_xy ($pdf, $text, $hor ,$ver);
	
	$fontSize=10; pdf_setfont ($pdf, $arial, $fontSize);
	$text="Division: Parks & Recreation";
	$widthText = pdf_stringwidth ($pdf, $text, $font, $fontSize);
	$hor=15;$ver=$ver-$lead;
	pdf_show_xy ($pdf, $text, $hor ,$ver);
	
	pdf_setlinewidth($pdf, 1);
	pdf_setcolor($pdf, 'both','rgb',0.0,0.0,0.0,0.0);
	pdf_moveto($pdf,56,$ver-2);
	pdf_lineto($pdf,142,$ver-2);
	pdf_stroke($pdf);
	
	$text="Vendor Number:    ".$vendor_number;
	$widthText = pdf_stringwidth ($pdf, $text, $font, $fontSize);
	$hor=15; $ver=$ver-$lead;
	pdf_show_xy ($pdf, $text, $hor ,$ver-1);
	//pdf_moveto($pdf,90,$ver-2);
	//pdf_lineto($pdf,150,$ver-2);
	//pdf_stroke($pdf);
	
	$hor=12+$widthText; 
	$text="Group:     ".$vg;
	$widthText = pdf_stringwidth ($pdf, $text, $font, $fontSize);
	$hor=$hor+$widthText+45; 
	pdf_show_xy ($pdf, $text, 268 ,$ver);
	
	$hor=$hor+$widthText;
	$text="New Vendor   ".$nv;
	$widthText = pdf_stringwidth ($pdf, $text, $font, $fontSize);
	$hor=$hor+$widthText+104; 
	pdf_show_xy ($pdf, $text, 390 ,$ver);
	
	//(right to left, up and down, width, height)
	// Box 0 Vendor Num.
	pdf_setlinewidth($pdf, 1);$ver=$ver;
	pdf_rect($pdf, 94, 707, 88, 14); //draw the rectangle 
	pdf_stroke($pdf);
	
	// Box 1 Group No.
	pdf_setlinewidth($pdf, 1);
	pdf_rect($pdf, 300, 707, 38, 14); //draw the rectangle 
	pdf_stroke($pdf);
	
	// Box 2 New Vendor
	pdf_setlinewidth($pdf, 1);
	pdf_rect($pdf, 450, 707, 13, 20); //draw the rectangle 
	pdf_stroke($pdf);
	
	
	// Box 3 Matching Invoices
	pdf_setlinewidth($pdf, 1);
	
	//pdf_setcolor($pdf, 'fill','rgb',0.0,0.0,0.0);
	$fontSize=14; pdf_setfont ($pdf, $arial, $fontSize);
	$text="Matching Invoices";
	//(right to left, up and down, width, height)
	$hor=233;
	pdf_show_xy ($pdf, $text, $hor ,273);
	
	/*
	$text="FY:   ".$po_fy;
	$hor=205;
	pdf_show_xy ($pdf, $text, $hor ,540);
	pdf_moveto($pdf,720,539);
	pdf_lineto($pdf,767,539);
	pdf_stroke($pdf);
	*/
	
	// Buy Entity
	$fontSize=12; pdf_setfont ($pdf, $arial, $fontSize);
	$text="Buy Entity:";
	$hor=250;
	pdf_show_xy ($pdf, $text, $hor ,257);
	
	//$fontSize=10; pdf_setfont ($pdf, $arial, $fontSize);
	$be=substr($be,2,6);
	$text="46   ".$be;
		$hor=236;
		pdf_show_xy ($pdf, $text, $hor ,242);
	
	//(right to left, up and down, width, height)
	// Buy entity box
	pdf_rect($pdf, 255, 239, 45, 14); //draw the rectangle 
	pdf_stroke($pdf);
		
	$text="Purchase Order Number:";
	$hor=220;
	//$fontSize=12; pdf_setfont ($pdf, $arial, $fontSize);
	pdf_show_xy ($pdf, $text, $hor ,226);
	$text="$po";
	$hor=245;
	pdf_show_xy ($pdf, $text, $hor ,210);
	
	pdf_setlinewidth($pdf, 1);
	pdf_rect($pdf, 233, 206, 85, 16); //draw the rectangle 
	pdf_stroke($pdf);
	
	
	$fontSize=10; pdf_setfont ($pdf, $arial, $fontSize);
	$text="Vendor Name:    ".$vendor_name;
	pdf_setlinewidth($pdf, 0.5);
	$widthText = pdf_stringwidth ($pdf, $text, $font, $fontSize);
	$hor=15; $ver=$ver-$lead-3;
	pdf_show_xy ($pdf, $text, $hor ,$ver);
	pdf_moveto($pdf,90,$ver-1);
	pdf_lineto($pdf,380,$ver-1);
	pdf_stroke($pdf);
	
	$va=nl2br($vendor_address);
// 	echo "$va"; exit;
	$va=explode("<br />",$va);
	$text="Vendor Address: $va[0]";
// 	echo "$text"; exit;
	$widthText = pdf_stringwidth ($pdf, $text, $font, $fontSize);
	$hor=15; $ver=$ver-$lead-1;
	pdf_show_xy ($pdf, $text, $hor ,$ver);
	pdf_moveto($pdf,90,$ver-1);
	pdf_lineto($pdf,380,$ver-1);
	pdf_stroke($pdf);
	
	for($j=1;$j<count($va);$j++){
	$text=trim($va[$j]);
	if($text){
	$hor=92; $ver=$ver-$lead+2;
	pdf_show_xy ($pdf, $text, $hor ,$ver);
	
	pdf_moveto($pdf,90,$ver-1);
	pdf_lineto($pdf,380,$ver-1);
	pdf_stroke($pdf);}
	}
	
	// Remit code
	$font_size=12;  //font size, used to space lines on y axis
	$tmplines = explode("\n",$rc);
	$cols=100;
	$xcrd=130; $ycrd=640;
	$text="Remit Code / Message:";
	pdf_show_xy ($pdf, $text, $xcrd-113 ,$ycrd);
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
				pdf_fit_textline($pdf,$str,$xcrd,$ycrd,"");
				$str="";
				$ycrd-=$font_size;
				}
			}
		if(!empty($rp))
				{$str.=" (".$rp.")";}
			
		pdf_fit_textline($pdf,$str,$xcrd+42,$ycrd,"");
		//	$line_len=strlen($str);
			pdf_moveto($pdf,$xcrd-6,$ycrd-2); // draw underline
			pdf_lineto($pdf,520,$ycrd-2);
			pdf_stroke($pdf);
		$ycrd-=$font_size;
		}
	

	pdf_set_value($pdf,"leading",10);
	
//	$text=$cc;$hor=610; 
//	pdf_show_xy ($pdf, $text, $hor ,$ver);
	
	$text=$land_message_line1;
	$widthText = pdf_stringwidth ($pdf, $text, $font, $fontSize);
	$hor=35; $ver=430;
	$fontSize=12;
	pdf_setfont ($pdf, $arial, $fontSize);
	pdf_show_xy ($pdf, $text, $hor ,$ver);
	
	$text=$land_message_line2;
	$widthText = pdf_stringwidth ($pdf, $text, $font, $fontSize);
	$hor=35; $ver=415;
	$fontSize=12;
	pdf_setfont ($pdf, $arial, $fontSize);
	pdf_show_xy ($pdf, $text, $hor ,$ver);
	
	
	$text=$land_message_line3;
	$widthText = pdf_stringwidth ($pdf, $text, $font, $fontSize);
	$hor=35; $ver=400;
	$fontSize=12;
	pdf_setfont ($pdf, $arial, $fontSize);
	pdf_show_xy ($pdf, $text, $hor ,$ver);
	
	
	$text=$land_message_line4;
	$widthText = pdf_stringwidth ($pdf, $text, $font, $fontSize);
	$hor=35; $ver=385;
	$fontSize=12;
	pdf_setfont ($pdf, $arial, $fontSize);
	pdf_show_xy ($pdf, $text, $hor ,$ver);
	
	$text=$land_message_line5;
	$widthText = pdf_stringwidth ($pdf, $text, $font, $fontSize);
	$hor=35; $ver=370;
	$fontSize=12;
	pdf_setfont ($pdf, $arial, $fontSize);
	pdf_show_xy ($pdf, $text, $hor ,$ver);
	
	$text=$land_message_line6;
	$widthText = pdf_stringwidth ($pdf, $text, $font, $fontSize);
	$hor=35; $ver=355;
	$fontSize=12;
	pdf_setfont ($pdf, $arial, $fontSize);
	pdf_show_xy ($pdf, $text, $hor ,$ver);
	
	
	$text=$land_message_line7;
	$widthText = pdf_stringwidth ($pdf, $text, $font, $fontSize);
	$hor=35; $ver=340;
	$fontSize=12;
	pdf_setfont ($pdf, $arial, $fontSize);
	pdf_show_xy ($pdf, $text, $hor ,$ver);
	

	
	$text="Budget Code:";
	$widthText = pdf_stringwidth ($pdf, $text, $font, $fontSize);
	$hor=35; $ver=265;
	$fontSize=12;
	pdf_setfont ($pdf, $arial, $fontSize);
	pdf_show_xy ($pdf, $text, $hor ,$ver);
	$text=$ncas_budget_code;
	$hor=135;
	$fontSize=10;
	pdf_setfont ($pdf, $arial, $fontSize);
	pdf_show_xy ($pdf, $text, $hor ,265);
	
	// Box 6
	pdf_setlinewidth($pdf, 1);
	pdf_rect($pdf, 125, 261, 50, 14); //draw the rectangle 
	pdf_stroke($pdf);
	
	// Header Box
	pdf_setlinewidth($pdf, 1);
	pdf_rect($pdf, 30, 600, 543, 30); //draw the rectangle 
	pdf_stroke($pdf);
	
	$ver=616;
	$hor=75; 
//	$just=0; //left
	$just=50;// center
//	$just=100;// right

	$text="Invoice Number";
	$xstart=50;
	$cols=strlen($text)-1;
	text_block($pdf,$text,$cols,$hor,$ver,$xstart,$just);
	
	$cols=5;
	$text="Invoice Date";
	$hor=177; 
	$xstart=50;
	text_block($pdf,$text,$cols,$hor,$ver,$xstart,$just);
	
	$text="PO Line #";
	$hor=245; 
	$xstart=50;
	text_block($pdf,$text,$cols,$hor,$ver,$xstart,$just);
	
	$text="Company";
	$hor=300; 
	$xstart=50;
	text_block($pdf,$text,$cols,$hor,$ver,$xstart,$just);
	
	$text="Account";
	$hor=363; 
	$xstart=50;
	text_block($pdf,$text,$cols,$hor,$ver,$xstart,$just);
	
	$text="Center";
	$hor=430; 
	$xstart=50;
	text_block($pdf,$text,$cols,$hor,$ver,$xstart,$just);
	
	$text="Amount";
	$hor=505; 
	$xstart=50;
	text_block($pdf,$text,$cols,$hor,$ver,$xstart,$just);
	
	// **************************************************
	// *********** Start Records from Arrays ************
	$ver=$ver-38;
	pdf_setlinewidth($pdf, 0.5);
	$numLines=count($inv_num);
	
	if($totPageNum>1){
	if($p==0){$end=$maxRowNum;$r=0;}else{
	$numLines=$numLines-$start;
	$end=$start+$numLines;$end=$start+$maxRowNum;
	}
	}else{$end=$numLines;$r=0;}
	
	
	unset($testText0,$testText1,$testText5,$testText6,$testText7);
	
	for($xx=$start;$xx<$end;$xx++)
		{		
		if($inv_num[$r])
			{
			$text=$r+1;
			$hor=18;
			$verNum=$ver+10;
			pdf_show_xy ($pdf, $text, $hor ,$verNum);
			
			$ver_block=$ver+9;
			// Invoice Num
			if(@$testText0==$inv_num[$r]){$text="      \"";}else{
			$text=$inv_num[$r]; $testText0=$text; }
			$hor=85; 
			$xstart=50;
			$just=100;
			$cols=strlen($text)-1;
			text_block($pdf,$text,$cols,$hor,$ver_block,$xstart,$just);
			
			// Invoice Date
			if(@$testText1==$inv_date[$r]){$text="\"";}else{
			$text=$inv_date[$r]; $testText1=$text; }
			$hor=177;
			$xstart=50;
			$cols=strlen($text)-1;
			$just=50;
			text_block($pdf,$text,$cols,$hor,$ver_block,$xstart,$just);
			
			// PO Line #
			if(@$testText1==$inv_po_line1[$r]){$text="\"";}else{
			$text=$inv_po_line1[$r]; $testText1=$text; }
			$hor=245;
			$xstart=50;
			$cols=strlen($text)-1;
			$just=50;
			text_block($pdf,$text,$cols,$hor,$ver_block,$xstart,$just);
			
			// Company
			if(@$testText5==$inv_com[$r]){$text="\"";}else{
			$text=$inv_com[$r]; $testText5=$text; }
			$hor=300;
			$xstart=50;
			$cols=strlen($text)-1;
			text_block($pdf,$text,$cols,$hor,$ver_block,$xstart,$just);
			
			// Account
			if(@$testText6==$inv_account[$r]){$text="\"";}else{
			$text=$inv_account[$r]; $testText6=$text; }
			$hor=370;
			$xstart=50;
			$cols=strlen($text)-1;
			text_block($pdf,$text,$cols,$hor,$ver_block,$xstart,$just);
			
			// Center
			if(@$testText7==$inv_center[$r]){$text="    \"";}else{
			$text=$inv_center[$r]; $testText7=$text; }
			//$hor=530;
			$hor=437;
			$xstart=50;
			$cols=strlen($text)-1;
			text_block($pdf,$text,$cols,$hor,$ver_block,$xstart,$just);
			
			// Invoice ncas_invoice_amount
			if(!$inv_ncas_credit[$r]){$text=$inv_amt[$r];}else{$text="-".$inv_amt[$r];}
			//$text=$inv_amt[$r]; 
			$testText2=$text; $modeB="right";
			$hor=500;
			$xstart=50;
			$cols=strlen($text)-1;
			$just=100;
			text_block($pdf,$text,$cols,$hor,$ver_block,$xstart,$just);
			if(!$inv_ncas_credit[$r])
				{@$grossAmt=$grossAmt+$inv_amt[$r];}
				else
				{@$grossAmt=$grossAmt-$inv_amt[$r];}
			@$ncas_freightAmt=$ncas_freightAmt+$inv_ncas_freight[$r];
			
			// Horizontal lines
			$verLine=$ver+6;
			pdf_moveto($pdf,30,$verLine);
			pdf_lineto($pdf,573,$verLine);
			pdf_stroke($pdf);
			
			$start++;
			$r++;
			$ver=$ver-16;
			
			}// if
		}// end for
	
	// *************  Header Box Vertical lines
	pdf_setlinewidth($pdf, 1);
	$top=600;$bottom=$verLine;
	pdf_moveto($pdf,30,$top);
	pdf_lineto($pdf,30,$bottom);
	pdf_stroke($pdf);
	
	//inv date start
	pdf_moveto($pdf,170,$top);
	pdf_lineto($pdf,170,$bottom);
	pdf_stroke($pdf);
	
	//PO Line #
	pdf_moveto($pdf,240,$top);
	pdf_lineto($pdf,240,$bottom);
	pdf_stroke($pdf);
	
	// Company
	pdf_moveto($pdf,300,$top);
	pdf_lineto($pdf,300,$bottom);
	pdf_stroke($pdf);
	
	// Account
	pdf_moveto($pdf,350,$top);
	pdf_lineto($pdf,350,$bottom);
	pdf_stroke($pdf);
	
	// Center
	pdf_moveto($pdf,420,$top);
	pdf_lineto($pdf,420,$bottom);
	pdf_stroke($pdf);
	
	// Amount
	pdf_moveto($pdf,485,$top);
	pdf_lineto($pdf,485,$bottom);
	pdf_stroke($pdf);
	
	// Right end
	pdf_moveto($pdf,573,$top);
	pdf_lineto($pdf,573,$bottom);
	pdf_stroke($pdf);
	
	if($pageNum!=$totPageNum){// more than 1 page
	$textF="Freight Subtotal";
	$textA="Subtotal";
	}else
	{$textF="Freight";
	$textA="Total";}
	// ncas_freight ncas_invoice_amount
	$hor=500;
	$text=number_format($ncas_freightAmt,2);
			$xstart=50;
			$cols=strlen($text)-1;
			$just=100;
			text_block($pdf,$text,$cols,$hor,$ver+6,$xstart,$just);
			
	// Gross ncas_invoice_amount
	$text=number_format($grossAmt,2);
	$hor=500;
			$xstart=50;
			$cols=strlen($text)-1;
			$just=100;
			text_block($pdf,$text,$cols,$hor,$ver-5,$xstart,$just);
			
	$fontSize=7;
	pdf_setfont ($pdf, $arialBold, $fontSize);
	
	$hor=458; $hei=$ver+9;
	pdf_show_xy ($pdf, $textF, $hor ,$hei);
	$hor=464; $hei=$ver-3;
	pdf_show_xy ($pdf, $textA, $hor ,$hei);
	
	// Comments
	
	$hor=122;$verC=145;
	$widthB=420; $heightB=55;
	$fontSize=9;
	pdf_setfont ($pdf, $arial, $fontSize);
	$comFas=explode("^",$cf);
	$text="Comments: $comFas[0]";
	pdf_set_value($pdf,"leading",10);
	pdf_show_boxed ($pdf, $text, $hor-80 ,$verC,$widthB,$heightB,"left","");
	$fas=trim(@$comFas[1]);
	if($fas){
	$text="FAS Number: $fas";
	$verF=$verC+5;
	pdf_show_xy ($pdf, $text, $hor ,$verF);}
	
	//Project Number 
	if($pn){
	$text="project_number: ".$pn;
	$hor=450;
	pdf_show_xy ($pdf, $text, $hor ,145);}
	
	/*
	//Park ACS # 
	if($sh){
	$text="PARK#: ".$sh;
	$hor=150;
	pdf_show_xy ($pdf, $text, $hor ,65);}
	*/
	
	// ********* Footer Stuff *************
	
	// Pay Entity
	// Box 
	//(right to left, up and down, width, height)
	$fontSize=12;
	pdf_setfont ($pdf, $arial, $fontSize);
	$pay_entity=substr($pay_entity,2,2);
	$text="Pay entity:    46      $pay_entity";
	$hor=35;$ver=230;
	$widthB=200; $heightB=20; $modeB="left";
	pdf_show_boxed ($pdf, $text, $hor ,$ver,$widthB,$heightB,$modeB,"");

	$modeB="right";
	pdf_setlinewidth($pdf, 1);
	pdf_rect($pdf, 131, 233, 31, 17); //draw the rectangle 
	pdf_stroke($pdf);
	
	$fontSize=10;
	pdf_setfont ($pdf, $arial, $fontSize);
	$peText="PC = Contracts*PT = Trade Vendors";
	$peText=explode("*",$peText);
	$ver=$ver+6;
	for($j=0;$j<count($peText);$j++){
	$text=$peText[$j];
	$hor=38; $ver=$ver-10;
	if($j==3){
	pdf_setfont ($pdf, $arialBold, $fontSize);}
	pdf_show_xy ($pdf, $text, $hor ,$ver);}
	
	// Controller's Box 
	pdf_setlinewidth($pdf, 2);
	pdf_rect($pdf, 155, 45, 305, 44); //draw the rectangle 
	pdf_stroke($pdf);
	
	
	$fontSize=12;
	pdf_setfont ($pdf, $arialBold, $fontSize);
	$text="Controller's Office Use Only";
	$hor=240;$ver=75;
	pdf_show_xy ($pdf, $text, $hor ,$ver);
	
	$fontSize=8;
	pdf_setfont ($pdf, $arial, $fontSize);
	$text="Entered:";
	$hor=170;$ver=55;
	pdf_show_xy ($pdf, $text, $hor ,$ver);
	pdf_setlinewidth($pdf, 0.5);
	pdf_moveto($pdf,205,55);
	pdf_lineto($pdf,300,55);
	pdf_stroke($pdf);
	
	$text="Control #:";
	$hor=315;$ver=55;
	pdf_show_xy ($pdf, $text, $hor ,$ver);
	pdf_moveto($pdf,355,55);
	pdf_lineto($pdf,455,55);
	pdf_stroke($pdf);
	
	// Prepared by
	$text="Prepared By:";
		$hor=120;$ver=153;
		pdf_show_xy ($pdf, $text, $hor ,$ver);
	$text=$prepared_by;
		$hor=175;$ver=153;
		pdf_show_xy ($pdf, $text, $hor ,$ver);
		
	$text="Received By:";
		$hor=120;$ver=135;
		pdf_show_xy ($pdf, $text, $hor ,$ver);
	$text=$received_by;
		$hor=175;$ver=135;
		pdf_show_xy ($pdf, $text, $hor ,$ver);
		
	$text="Approved By:";
		$hor=120;$ver=115;
		pdf_show_xy ($pdf, $text, $hor ,$ver);
	$text=$approved_by;
		$hor=175;$ver=115;
	//	pdf_show_xy ($pdf, $text, $hor ,$ver);
		/*
	$text="Entered By:";
		$hor=120;$ver=35;
		pdf_show_xy ($pdf, $text, $hor ,$ver);
	
	pdf_setlinewidth($pdf, 0.5);
	pdf_moveto($pdf,470,92);
	pdf_lineto($pdf,650,92);
	pdf_stroke($pdf);
	
	pdf_moveto($pdf,470,74);
	pdf_lineto($pdf,650,74);
	pdf_stroke($pdf);
	
	pdf_moveto($pdf,470,54);
	pdf_lineto($pdf,650,54);
	pdf_stroke($pdf);
	
	pdf_moveto($pdf,470,34);
	pdf_lineto($pdf,650,34);
	pdf_stroke($pdf);
	*/	
	// Dates
	pdf_setlinewidth($pdf, 1);
	$text="Date:";
		$hor=270;$ver=153;
		pdf_show_xy ($pdf, $text, $hor ,$ver);
	$text=$prepared_date;
		$hor=300;$ver=153;
		pdf_show_xy ($pdf, $text, $hor ,$ver);
	$text="Date:";
		$hor=270;$ver=135;
		pdf_show_xy ($pdf, $text, $hor ,$ver);
	$text=@$received_date;
		$hor=300;$ver=135;
		pdf_show_xy ($pdf, $text, $hor ,$ver);
	$text="Date:";
		$hor=270;$ver=115;
		pdf_show_xy ($pdf, $text, $hor ,$ver);
	$text=$approved_date;
		$hor=300;$ver=115;
		pdf_show_xy ($pdf, $text, $hor ,$ver);
		/*
	$text="Date:";
		$hor=270;$ver=135;
		pdf_show_xy ($pdf, $text, $hor ,$ver);
		*/
	
	
	$fontSize=8;
	pdf_setfont ($pdf, $arial, $fontSize);
	$hor=38; 
	$text="Capital Improvement Payment";
	pdf_show_xy ($pdf, $text, $hor ,15);
	
	$text="Please use WHITE paper.";
		$hor=470;$ver=15;
		pdf_show_xy ($pdf, $text, $hor ,15);
	
	pdf_moveto($pdf,293,152);
	pdf_lineto($pdf,360,152);
	pdf_stroke($pdf);
	
	// underline for received_date
	pdf_moveto($pdf,293,134);
	pdf_lineto($pdf,360,134);
	pdf_stroke($pdf);
	
	pdf_moveto($pdf,293,114);
	pdf_lineto($pdf,360,114);
	pdf_stroke($pdf);
	
	/*
	pdf_moveto($pdf,293,134);
	pdf_lineto($pdf,360,134);
	pdf_stroke($pdf);
	*/
	
	// Finish the page
	pdf_end_page ($pdf);
	
	$pageNum++;
	
	}// end loop of pages

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
  
function text_block($pdf,$text,$cols,$xcrd,$ycrd,$xstart,$just)
	{
	$font_size=12;  //font size, used to space lines on y axis
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