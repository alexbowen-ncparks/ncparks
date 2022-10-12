<?php

//print_r($_REQUEST);EXIT;

//ini_set('display_errors,',1);

$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database 
extract($_REQUEST);
// echo "<pre>"; print_r($_REQUEST); echo "</pre>"; exit;
if(isset($vendor_number))
	{
	$vendor_number=trim($vendor_number);
	$select="SELECT * From cid_vendor_invoice_payments ";
	$where="where cid_vendor_invoice_payments.vendor_number='$vendor_number' AND due_date='$due_date'";
	}
else{

if($prepared_by=="Barbara Adams"||$prepared_by=="Pamela Laurence"){
$pb="(prepared_by='Barbara Adams' OR prepared_by='Pamela Laurence')";}
else
{$pb="prepared_by='$prepared_by'";}

$vendor_name=urldecode($vendor_name);
$vendor_name=addslashes($vendor_name);  // necessary since vendor_name was sent urlencoded and not escaped in no_inject.php
$select="SELECT cid_vendor_invoice_payments.*,coa.park_acct_desc
From cid_vendor_invoice_payments ";
$where="where vendor_name='$vendor_name' AND due_date='$due_date' AND $pb";}


$JOIN="LEFT JOIN coa on cid_vendor_invoice_payments.ncas_account = coa.ncasnum";

$sql = "$select
$JOIN
$where
order by ncas_invoice_number,po_line1";


//echo "$sql"; exit;

$result = mysqli_query($connection, $sql) or die ("Couldn't execute query. $sql");

$num=mysqli_num_rows($result);
$totPageNum=ceil($num/16);

// Initialize some variables
$ncas_freightAmt="";
$grossAmt="";
$testText6a="";
$testText4="";
$comPrevious="";

while($row=mysqli_fetch_array($result))
	{
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
	$inv_energy[]=$energy_group;
	$inv_cdcs[]=$cdcs_uom;
	$inv_energy_quantity[]=$energy_quantity;
	$inv_re_number[]=$re_number;
	$inv_pa_number[]=$pa_number;
	
	// Set new variables so any one record with values gets printed
	// otherwise ONLY values, if any, from the last record would print
	if(isset($new_vendor)){$nv=$new_vendor;}else{$nv="";}
	if($ncas_county_code){$cc=$ncas_county_code;}else{$cc="";}
	if($ncas_remit_code){$rc=$ncas_remit_code;}
	if(!empty($ncas_remit_park)){$rp=$ncas_remit_park;}
	if($comPrevious!=$comments)
		{
		if($comments){@$cf=$comments." ";}
		}
	$comPrevious=$comments;
	if($fas_num){@$cf.="^".$fas_num;}
	if($ncas_buy_entity){$be=$ncas_buy_entity;}else{$be="";}
	if($ncas_po_number){$po=$ncas_po_number;}
	if($part_pay){$pp=$part_pay;}else{$pp="";}
	if($project_number){$pn=$project_number;}
	if($group_number){$vg=$group_number;}
	if($sheet){$sh=$sheet;}
	
	
	if(isset($fy)){$po_fy=$fy;}else{$po_fy="";}
	if(isset($po_line1)){$po1=$po_line1;}
	if(isset($po_line2)){$po2=$po_line2;}
	if(isset($po_line3)){$po3=$po_line3;}
	if($amt1){$po_amt1=$amt1;}
	if($amt2){$po_amt2=$amt2;}
	if($amt3){$po_amt3=$amt3;}
	
	}

// Set the constants and variables.
define ("PAGE_WIDTH", 792); // 11 inches landscape
define ("PAGE_HEIGHT",612); // 8.5 inches
$pdf = PDF_new(); include("/opt/library/prd/WebServer/include/pdf_key_23.php");

/*  open new PDF file; insert a file name to create the PDF on disk */
if (PDF_begin_document($pdf, "", "") == 0) {
    die("Error: " . PDF_get_errmsg($pdf));
}

PDF_set_info($pdf, "Creator", "acs_pdf.php");
PDF_set_info($pdf, "Author", "Tom Howard");
PDF_set_info($pdf, "Title", "MoneyCounts - CDCS");

// ******************** Start Loop ***************
$start=0;
$pageNum=1;

for($p=0;$p<$totPageNum;$p++)
	{
	PDF_begin_page_ext($pdf, PAGE_WIDTH, PAGE_HEIGHT, "");
	
	$arial = PDF_load_font($pdf, "Arial", "winansi", "");
	$arialBold = PDF_load_font($pdf, "arialnb", "winansi", "");
	$font = PDF_load_font($pdf, "Helvetica-Bold", "winansi", "");
	
		$fontSize=12.0;
	PDF_setfont($pdf, $font, $fontSize);
	
		$text="DEPARTMENT OF NATURAL AND CULTURAL RESOURCES";
		$widthText = pdf_stringwidth ($pdf, $text, $font, $fontSize);// Width of Title
		$hor=(PAGE_WIDTH-$widthText)/2;
		$ver=PAGE_HEIGHT-25;
	PDF_set_text_pos($pdf, $hor, $ver);
	PDF_show($pdf, $text);
	
	
	$font = PDF_load_font($pdf, "Arial", "winansi", "");
		$fontSize=10.0;
	PDF_setfont($pdf, $font, $fontSize);
	
	$text="Page $pageNum of $totPageNum";
	$widthText = pdf_stringwidth ($pdf, $text, $font, $fontSize);
	$hor=(PAGE_WIDTH-$widthText-30);
	pdf_show_xy ($pdf, $text, $hor ,$ver);
	
		$text="CASH DISBURSEMENTS CODE SHEET";
		$widthText = pdf_stringwidth ($pdf, $text, $font, $fontSize);// Width of Title
		$hor=(PAGE_WIDTH-$widthText)/2;
		$ver=$ver-2;
	PDF_set_text_pos($pdf, $hor, $ver);
	PDF_continue_text($pdf, $text);
	
		$text="Division: Parks & Recreation";
		$widthText = pdf_stringwidth ($pdf, $text, $font, $fontSize);
		$hor=15;
		$ver=$ver-12;
	PDF_set_text_pos($pdf, $hor, $ver);
	PDF_continue_text($pdf, $text);
	
	
	pdf_setlinewidth($pdf, 1);
	pdf_setcolor($pdf, 'both','rgb',0.0,0.0,0.0,0.0);
	pdf_moveto($pdf,56,$ver-12);
	pdf_lineto($pdf,142,$ver-12);
	pdf_stroke($pdf);
	
	$text="Vendor Number:    ".$vendor_number;
	$widthText = pdf_stringwidth ($pdf, $text, $font, $fontSize);
	$hor=15; $ver=$ver-30;
	pdf_show_xy ($pdf, $text, $hor ,$ver);
	
	
	$hor=12+$widthText; 
	$text="Grp. Letter       ".$vg;
	$widthText = pdf_stringwidth ($pdf, $text, $font, $fontSize);
	$hor=$hor+$widthText+45; $ver=$ver;
	pdf_show_xy ($pdf, $text, 248 ,$ver);
	
	$hor=$hor+$widthText;
	$text="New Vendor   ".$nv;
	$widthText = pdf_stringwidth ($pdf, $text, $font, $fontSize);
	$hor=$hor+$widthText+104; $ver=$ver;
	pdf_show_xy ($pdf, $text, 390 ,$ver);
	
	//(right to left, up and down, width, height)
	// Box 0 Vendor Num.
	pdf_setlinewidth($pdf, 1);
	pdf_rect($pdf, 94, 539, 88, 14); //draw the rectangle 
	pdf_stroke($pdf);
	
	// Box 1 Group No.
	pdf_setlinewidth($pdf, 1);
	pdf_rect($pdf, 300, 539, 38, 14); //draw the rectangle 
	pdf_stroke($pdf);
	
	// Box 2 New Vendor
	pdf_setlinewidth($pdf, 1);
	pdf_rect($pdf, 450, 536, 13, 20); //draw the rectangle 
	pdf_stroke($pdf);
	
	// Box 3 Matching Invoices
	pdf_setlinewidth($pdf, 1);
	
	// Surrounding box
	pdf_rect($pdf, 475, 510, 293, 55); //draw the rectangle 
	pdf_stroke($pdf);
	//pdf_setcolor($pdf, 'fill','rgb',0.9,0.9,0.9);
	
	//pdf_rect($pdf, 400, 505, 374, 60); //draw the rectangle 
	//pdf_fill_stroke($pdf);
	
	// PO Number box
	pdf_rect($pdf, 530, 517, 135, 14); //draw the rectangle 
	pdf_stroke($pdf);
	
	// Partial Pay box
	pdf_rect($pdf, 750, 517, 12, 14); 
	pdf_stroke($pdf);
	
	$fontSize=8; pdf_setfont ($pdf, $font, $fontSize);
	$text="Matching Invoices Only";
	//(right to left, up and down, width, height)
	$hor=575;
	pdf_show_xy ($pdf, $text, $hor ,555);
	
	$text="Buy Entity:";
	$hor=480;
	pdf_show_xy ($pdf, $text, $hor ,540);
	
	
	$text="FY:   ".$po_fy;
	$hor=700;
	pdf_show_xy ($pdf, $text, $hor ,540);
	pdf_moveto($pdf,715,539);
	pdf_lineto($pdf,762,539);
	pdf_stroke($pdf);
	
	// Buy Entity
	$fontSize=10; pdf_setfont ($pdf, $font, $fontSize);
	//$text="16E";
	$text=$be;
		$hor=536;
		pdf_show_xy ($pdf, $text, $hor ,539);
	
	$fontSize=8; pdf_setfont ($pdf, $font, $fontSize);
	$text="PO Number:";
	$hor=480;
	pdf_show_xy ($pdf, $text, $hor ,521);
	$text="$po";
	$hor=535;
	pdf_show_xy ($pdf, $text, $hor ,521);
	$text="Partial Pmt.";
	$hor=700;
	pdf_show_xy ($pdf, $text, $hor ,521);
	$text="$pp";
	$hor=759;
	pdf_show_xy ($pdf, $text, $hor ,521);
	
	// Buy goods
	$text="G = Buying Goods";
	$hor=600;
	pdf_show_xy ($pdf, $text, $hor ,543);
	$text="S = Buying Services";
	$hor=600;
	pdf_show_xy ($pdf, $text, $hor ,535);
	
	//(right to left, up and down, width, height)
	// Buy entity box
	pdf_setlinewidth($pdf, 1);
	pdf_rect($pdf, 530, 535, 49, 16); //draw the rectangle 
	pdf_stroke($pdf);
	
	
	$fontSize=10;
	pdf_setfont ($pdf, $font, $fontSize);
	$text="Vendor Name:    ".$vendor_name;
	pdf_setlinewidth($pdf, 0.5);
	$widthText = pdf_stringwidth ($pdf, $text, $font, $fontSize);
	$hor=15; $ver=$ver-20;
	pdf_show_xy ($pdf, $text, $hor ,$ver);
	pdf_moveto($pdf,90,$ver-1);
	pdf_lineto($pdf,380,$ver-1);
	pdf_stroke($pdf);
	
	
//$vendor_address=str_replace("\\r\\n","\n",$vendor_address);
	$va=nl2br($vendor_address);
	$va=explode("<br />",$va);
	
	$text="Vendor Address: ";
	$widthText = pdf_stringwidth ($pdf, $text, $font, $fontSize);
	$hor=15; $ver=$ver-15;
	pdf_show_xy ($pdf, $text, $hor ,$ver);
	
	for($j=0;$j<count($va);$j++){
	$text=trim($va[$j]);
	if($text){
	$hor=92; 
	pdf_show_xy ($pdf, $text, $hor ,$ver);
	
	pdf_moveto($pdf,90,$ver-2); // draw underline
	pdf_lineto($pdf,380,$ver-2);
	pdf_stroke($pdf);}
	$ver=$ver-12;
	}

	// Remit code
	$font_size=12;  //font size, used to space lines on y axis
	$tmplines = explode("\n",$rc);
	$temp_var=array_unique($tmplines);
	$tmplines=$temp_var;
// 	echo "rc = $rc<pre>"; print_r($ARRAY); echo "</pre>";  exit;
	$cols=100;
	$xcrd=130; $ycrd=446;
	$text="Remit Code / Message: Account #";
	pdf_show_xy ($pdf, $text, $xcrd-113 ,$ycrd);
// 	echo "<pre>"; print_r($tmplines); echo "</pre>";  exit;
// 	for($j=0;$j<count($tmplines);$j++)
	foreach($tmplines as $index_1=>$value_1)
		{
		if($index_1>0){continue;}
// 		$tmptxt = explode(" ",$tmplines[$j]);
		$tmptxt = explode(" ",$value_1);

// 		echo "<pre>"; print_r($tmptxt); echo "</pre>"; // exit;
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
// 	exit;
	pdf_set_value($pdf,"leading",10);
	$text="County Code:";
	$widthText = pdf_stringwidth ($pdf, $text, $font, $fontSize);
	$hor=540; $ver=485;
	pdf_show_xy ($pdf, $text, $hor ,$ver);
	
	$text=$cc;
	$hor=610; 
	pdf_show_xy ($pdf, $text, $hor ,$ver);
	
	// Box 4 County Code
	pdf_setlinewidth($pdf, 1);
	pdf_rect($pdf, 605, 481, 28, 14); //draw the rectangle 
	pdf_stroke($pdf);
	
	$text="Budget Code:";
	$widthText = pdf_stringwidth ($pdf, $text, $font, $fontSize);
	$hor=660; $ver=485;
	pdf_show_xy ($pdf, $text, $hor ,$ver);
	$text=$ncas_budget_code;
	$hor=730;
	pdf_show_xy ($pdf, $text, $hor ,485);
	
	// Box 6 Budget Code
	pdf_setlinewidth($pdf, 1);
	pdf_rect($pdf, 724, 481, 40, 14); //draw the rectangle 
	pdf_stroke($pdf);
	
	
	// Header Box
	pdf_setlinewidth($pdf, 1);
	pdf_rect($pdf, 30, 408, 740, 30); //draw the rectangle 
	pdf_stroke($pdf);
	
	
	$cols=5;
	$ver=425;
	$hor=75; 
	$just_left=0; //left
	$just=50;// center
//	$just=100;// right
	
	$text="Invoice Number";
	$xstart=47;
	text_block($pdf,$text,$cols,$hor,$ver,$xstart,$just);
	
	$text="Invoice Date";
	$hor+=63; 
	$xstart=80;
	text_block($pdf,$text,$cols,$hor+15,$ver,$xstart,$just);
	
	$text="PO line #";
	$hor+=30; 
	$xstart=100;
	text_block($pdf,$text,$cols,$hor+23,$ver,$xstart,$just);
	
	$text="Amount";
	$hor+=50; 
	$xstart=120;
	text_block($pdf,$text,$cols,$hor+15,$ver-5,$xstart,$just);
	
	$text="Cr    ";
	$hor+=50; 
	$xstart=120;
	text_block($pdf,$text,$cols,$hor+10,$ver-5,$xstart,$just);
	
	$text="Company";
	$hor+=40; 
	$xstart=120;
	text_block($pdf,$text,$cols,$hor+6,$ver-5,$xstart,$just);
	
	$text="Account";
	$hor+=60; 
	$xstart=120;
	text_block($pdf,$text,$cols,$hor,$ver-5,$xstart,$just);
	
	$text="Account Description";
	$hor+=98; 
	$xstart=120;
	text_block($pdf,$text,$cols,$hor,$ver,$xstart,$just);
	
	$text="Center";
	$hor+=88; 
	$xstart=120;
	text_block($pdf,$text,$cols,$hor,$ver-5,$xstart,$just);
	
	$text="1099 Code";
	$hor+=42; 
	$xstart=120;
	text_block($pdf,$text,$cols,$hor,$ver,$xstart,$just);
	
	$text="Accrual Code";
	$hor+=37; 
	$xstart=120;
	text_block($pdf,$text,$cols,$hor,$ver,$xstart,$just);
	
	$text="Energy";
	$hor+=47; 
	$xstart=120;
	text_block($pdf,$text,$cols,$hor,$ver-5,$xstart,$just);

// *********** Start Records from Arrays ************
$ver=$ver-30;
pdf_setlinewidth($pdf, 0.5);
$numLines=count($inv_num);

if($totPageNum>1)
	{
	if($p==0){$end=16;$r=0;}
	else
		{
		$numLines=$numLines-$start;
		$end=$start+$numLines;$end=$start+16;
		}
	}
	else
	{
	$end=$numLines;$r=0;
	}

 // for left
//PDF_fit_textline($pdf, $text, 60, 350, "boxsize {500 140} position {0 50}");
// for center
//PDF_fit_textline($pdf, $text, 60, 350, "boxsize {500 140} position {50 50}");  // for right
//PDF_fit_textline($pdf, $text, 60, 350, "boxsize {500 140} position {100 50}");

$testText0="";$testText1="";$testText5="";$testText6="";$testText7="";

for($xx=$start;$xx<$end;$xx++)
	{
	
	if($inv_num[$r])
		{
		$text=$r+1;
		$hor=18;
		$verNum=$ver+2;
		pdf_show_xy ($pdf, $text, $hor ,$verNum);
		
		// Invoice Num
		if($testText0==$inv_num[$r])
			{
			$text="      \"";
			$just="center";
			}
			else
			{
			$text=$inv_num[$r]; 
			$testText0=$text; 
			$just="center";
			}
		$hor=33; 
		$xstart=158;
		$cols=20;  // width of block
		text_block($pdf,$text,$cols,$hor,$ver,$xstart,$just_left);
		
		// Invoice Date
		if($testText1==$inv_date[$r])
			{$text="\"";}
			else
			{
			$text=$inv_date[$r]; 
			$testText1=$text;
			}
		$hor=180;
		$xstart=30;
		$cols=strlen($text)-1;
		text_block($pdf,$text,$cols,$hor,$ver,$xstart,$just);
		
		// Invoice po_line1
		$text=$inv_po_line1[$r]; //$testText8=$text; 
		$hor=230;
		$xstart=30;
		$cols=strlen($text)-1;
		text_block($pdf,$text,$cols,$hor,$ver,$xstart,$just);
		
		// Invoice ncas_invoice_amount
		$text=$inv_amt[$r]; $testText2=$text;
		$hor=287;
		$xstart=30;
		$just=100;
		text_block($pdf,$text,$cols,$hor,$ver,$xstart,$just);
		$just=50;
		
		// CR ncas_credit
		$text=$inv_ncas_credit[$r];
		$hor=310;
		$xstart=30;
		$cols=strlen($text)-1;
		text_block($pdf,$text,$cols,$hor,$ver,$xstart,$just);
		
		// ncas_freight ncas_invoice_amount
		if($testText4!=$inv_ncas_freight[$r])
		{
		$text4=$inv_ncas_freight[$r]; $testText4=$text;
		}
		
		// Company
		if($testText5==$inv_com[$r]){$text="\"";}else{
		$text=$inv_com[$r]; $testText5=$text;}
		$hor=350;
		$xstart=30;
		$cols=strlen($text)-1;
		text_block($pdf,$text,$cols,$hor,$ver,$xstart,$just);
		
		// Account
		if($testText6==$inv_account[$r]){$text="\"";}else{
		$text=$inv_account[$r]; $testText6=$text;}
		$hor=412;
		$xstart=30;
		$cols=strlen($text)-1;
		text_block($pdf,$text,$cols,$hor,$ver,$xstart,$just);
		
		// Account Description
		if($testText6a==$inv_acct_desc[$r]){$text="          \"";}else{
		$text=$inv_acct_desc[$r]; $testText6a=$text; }
		$hor=510;
		$text=substr($text,0,26);
		$xstart=30;
		$cols=strlen($text)-1;
		text_block($pdf,$text,$cols,$hor,$ver,$xstart,$just);
		
		// Center
		if($testText7==$inv_center[$r]){$text="       \"";}else{
		$text=$inv_center[$r]; $testText7=$text;}	
		$hor=600;
		$xstart=30;
		$cols=strlen($text)-1;
		text_block($pdf,$text,$cols,$hor,$ver,$xstart,$just);
		
				
		// ncas_accrual_code
		$text=$inv_ncas_accrual_code[$r];
		$hor=680;
		$xstart=30;
		$cols=strlen($text)-1;
		text_block($pdf,$text,$cols,$hor,$ver,$xstart,$just);
		
		// energy
		$fontSize=8; 
		PDF_setfont($pdf, $font, $fontSize);
			if($inv_cdcs[$r]){
				$text=$inv_cdcs[$r]." ".$inv_energy_quantity[$r];}
				else
				{$text=$inv_energy_quantity[$r];}
	
		$hor=716;
		$cols=strlen($text)-1;
		$just=0;
		text_block($pdf,$text,$cols,$hor,$ver,$xstart,$just);
		$just=50;
		
		$fontSize=10; 
		PDF_setfont($pdf, $font, $fontSize);
		if(!$inv_ncas_credit[$r])
			{
			$grossAmt=$grossAmt+$inv_amt[$r];
			}
			else
			{
			$grossAmt=$grossAmt+$inv_amt[$r];
			}
		$ncas_freightAmt+=$inv_ncas_freight[$r];
		
		// Horizontal lines
		$verLine=$ver;
		pdf_moveto($pdf,30,$verLine);
		pdf_lineto($pdf,770,$verLine);
		pdf_stroke($pdf);
		
		$start++;
		$r++;
		$ver=$ver-16;
		
		}// if
	}

// *************  Header Box Vertical lines
// inv number
pdf_setlinewidth($pdf, 1);
$top=410;$bottom=$verLine;
pdf_moveto($pdf,30,$top);
pdf_lineto($pdf,30,$bottom);
pdf_stroke($pdf);

//inv date start
$top=438;$bottom=$verLine;
pdf_moveto($pdf,165,$top);
pdf_lineto($pdf,165,$bottom);
pdf_stroke($pdf);

//po_line start
pdf_moveto($pdf,225,$top);
pdf_lineto($pdf,225,$bottom);
pdf_stroke($pdf);

//amt start
pdf_moveto($pdf,260,$top);
pdf_lineto($pdf,260,$bottom);
pdf_stroke($pdf);

// cr
pdf_moveto($pdf,320,$top);
pdf_lineto($pdf,320,$bottom);
pdf_stroke($pdf);

pdf_moveto($pdf,345,$top);
pdf_lineto($pdf,345,$bottom);
pdf_stroke($pdf);

// Company
pdf_moveto($pdf,400,$top);
pdf_lineto($pdf,400,$bottom);
pdf_stroke($pdf);

// Account
pdf_moveto($pdf,455,$top);
pdf_lineto($pdf,455,$bottom);
pdf_stroke($pdf);

// Description
pdf_moveto($pdf,590,$top);
pdf_lineto($pdf,590,$bottom);
pdf_stroke($pdf);

pdf_moveto($pdf,640,$top);
pdf_lineto($pdf,640,$bottom);
pdf_stroke($pdf);

// Accrual
pdf_moveto($pdf,673,$top);
pdf_lineto($pdf,673,$bottom);
pdf_stroke($pdf);

//Left of Energy
pdf_moveto($pdf,713,$top);
pdf_lineto($pdf,713,$bottom);
pdf_stroke($pdf);

//Right of Energy
pdf_moveto($pdf,770,$top);
pdf_lineto($pdf,770,$bottom);
pdf_stroke($pdf);


if($pageNum!=$totPageNum)
	{// more than 1 page
	$textF="Freight Subtotal";
	$textA="ncas_invoice_amount Subtotal";
	}
	else
	{
	$textF="Freight Amt";
	$textA="Gross Amt";
	}
// ncas_freight ncas_invoice_amount
$text=number_format($ncas_freightAmt,2);
$hor=287;
		$cols=strlen($text)-1;
		$just=100;
		text_block($pdf,$text,$cols,$hor,$ver,$xstart,$just);
	//	$just=50;
		
// Gross ncas_invoice_amount
$text=number_format($grossAmt,2);
$ver-=14;
$cols=strlen($text)-1;
		$just=100;
		text_block($pdf,$text,$cols,$hor,$ver,$xstart,$just);
	//	$just=50;

$font = PDF_load_font($pdf, "arialnb", "winansi", "");
$fontSize=7;
PDF_setfont($pdf, $font, $fontSize);

$hor=322; $hei=$ver+16;
pdf_show_xy ($pdf, $textF, $hor ,$hei);
$hor=322; $hei=$ver+2;
pdf_show_xy ($pdf, $textA, $hor ,$hei);


// Comments
$hor=440;
$fontSize=9;
pdf_setfont ($pdf, $arial, $fontSize);
$comFas=explode("^",$cf);
$text="Comments: $comFas[0]";
$com_len=strlen($text);

$incre=75;
if($com_len>$incre)
	{
	$com_exp=explode(" ",$text);
	foreach($com_exp as $var_1=>$var_2)
		{
		@$new_str.=" ".$var_2;
		if(strlen($new_str)>$incre)
			{
			$new_str.="\n";
			$incre+=$incre;
			}
		}	
	$text=$new_str;
	}
	
	if($inv_re_number){
		foreach($inv_re_number as $kre=>$vre){
			if($vre!=""){$text.=" (RE#=$vre)";}
			}
		}
	if($inv_pa_number){
		foreach($inv_pa_number as $kpa=>$vpa){
			if($vpa!=""){$text.=" (PA#=$vpa)";}
			}
		}
$cols=strlen($text)-1;
		$just=10;
		text_block($pdf,$text,$cols,$hor,$ver+18,$xstart,$just);


$fas=trim($comFas[1]);
if($fas)
	{
	$text="FAS Number: $fas";
	$verF=$verC+5;
	pdf_show_xy ($pdf, $text, $hor ,$verF);
	}

//Project Number 
if(isset($pn))
	{
	$text="project_number: ".$pn;
	$hor=150;
	pdf_show_xy ($pdf, $text, $hor ,85);
	}

//Park ACS # 
if(isset($sh))
	{
	$text="PARK#: ".$sh;
	$hor=150;
	pdf_show_xy ($pdf, $text, $hor ,65);
	}

// ********* Footer Stuff *************

// Pay Entity
// Box 
//(right to left, up and down, width, height)
$fontSize=10;
pdf_setfont ($pdf, $arial, $fontSize);
pdf_setlinewidth($pdf, 1);
pdf_rect($pdf, 74, 81, 40, 14); //draw the rectangle 
pdf_stroke($pdf);
$text="Pay entity:   $pay_entity";
$hor=73;
$ver=83;
$cols=strlen($text)-1;
		$just=100;
		text_block($pdf,$text,$cols,$hor,$ver,$xstart,$just);
		
$fontSize=8;
pdf_setfont ($pdf, $arial, $fontSize);
$hor=38; 
$text="*(PC = Contract Vendors -                                                )*";
pdf_show_xy ($pdf, $text, $hor ,20);
pdf_setfont ($pdf, $arialBold, $fontSize);
$text="Use Contract Expenditure Report";
pdf_show_xy ($pdf, $text, 134 ,20);

pdf_arrow ($pdf, 15, 45, 35, 45, 0);

pdf_setfont ($pdf, $arial, $fontSize);
$peText="PT = Trade Vendors*PE = Employee Vendors*PN = Non-Trade Vendors*PC - Do Not Use this form for PC payments";
$peText=explode("*",$peText);

for($j=0;$j<count($peText);$j++)
	{
	$text=$peText[$j];
	$hor=38; 
	$ver=$ver-10;
	if($j==3)
		{
		pdf_setfont ($pdf, $arialBold, $fontSize);
		}
	pdf_show_xy ($pdf, $text, $hor ,$ver);
	}

pdf_setfont ($pdf, $arial, $fontSize);
// Controller's Box 
pdf_setlinewidth($pdf, 1);
pdf_rect($pdf, 275, 25, 115, 74); //draw the rectangle 
pdf_stroke($pdf);

$text="Controller's Office Use Only:";
$hor=277;$ver=90;
pdf_show_xy ($pdf, $text, $hor ,$ver);

$text="Control #";
$hor=285;$ver=67;
pdf_show_xy ($pdf, $text, $hor ,$ver);
pdf_setlinewidth($pdf, 1);
pdf_rect($pdf, 325, 63, 55, 14); //draw the rectangle 
pdf_stroke($pdf);

$text="Date";
$hor=285;$ver=44;
pdf_show_xy ($pdf, $text, $hor ,$ver);
pdf_setlinewidth($pdf, 1);
pdf_rect($pdf, 305, 40, 75, 15); //draw the rectangle 
pdf_stroke($pdf);

// Received by
$text="Received By:";
	$hor=420;$ver=93;
	pdf_show_xy ($pdf, $text, $hor ,$ver);
$text=$received_by;
	$hor=472;$ver=93;
	pdf_show_xy ($pdf, $text, $hor ,$ver);
	
// Prepared by
$text="**Prepared By:";
	$hor=413;$ver=75;
	pdf_show_xy ($pdf, $text, $hor ,$ver);
$text=$prepared_by;
	$hor=472;$ver=75;
	pdf_show_xy ($pdf, $text, $hor ,$ver);
	
$text="**Approved By:";
	$hor=413;$ver=55;
	pdf_show_xy ($pdf, $text, $hor ,$ver);
$text=$approved_by;
	$hor=472;$ver=55;
	pdf_show_xy ($pdf, $text, $hor ,$ver);
$text="Entered By:";
	$hor=420;$ver=35;
	pdf_show_xy ($pdf, $text, $hor ,$ver);
	

pdf_setlinewidth($pdf, 0.5);
pdf_moveto($pdf,470,92);
pdf_lineto($pdf,690,92);
pdf_stroke($pdf);

pdf_moveto($pdf,470,74);
pdf_lineto($pdf,690,74);
pdf_stroke($pdf);

pdf_moveto($pdf,470,54);
pdf_lineto($pdf,690,54);
pdf_stroke($pdf);

pdf_moveto($pdf,470,34);
pdf_lineto($pdf,690,34);
pdf_stroke($pdf);

// Dates
$text="Date:";
	$hor=700;$ver=93;
//	pdf_show_xy ($pdf, $text, $hor ,$ver);
$text=@$prepared_date;
	$hor=723;$ver=75;
	pdf_show_xy ($pdf, $text, $hor ,$ver);
$text="Date:";
	$hor=700;$ver=75;
	pdf_show_xy ($pdf, $text, $hor ,$ver);
$text=@$received_date;
	$hor=723;$ver=93;
//	pdf_show_xy ($pdf, $text, $hor ,$ver);
$text="Date:";
	$hor=700;$ver=55;
	pdf_show_xy ($pdf, $text, $hor ,$ver);
$text=@$approved_date;
	$hor=723;$ver=55;
	pdf_show_xy ($pdf, $text, $hor ,$ver);
$text="Date:";
	$hor=700;$ver=35;
	pdf_show_xy ($pdf, $text, $hor ,$ver);
	
	
$text="Please use yellow paper.";
	$hor=670;$ver=15;
	pdf_show_xy ($pdf, $text, $hor ,$ver);
	
	
pdf_setfont ($pdf, $arialBold, $fontSize);
$text="**Full signature required.";
	$hor=415;$ver=15;
	pdf_show_xy ($pdf, $text, $hor ,$ver);

// underline for received_date
//pdf_moveto($pdf,693,92);
//pdf_lineto($pdf,760,92);
//pdf_stroke($pdf);

// underline for prepared_date
pdf_moveto($pdf,720,74);
pdf_lineto($pdf,765,74);
pdf_stroke($pdf);

pdf_moveto($pdf,720,54);
pdf_lineto($pdf,765,54);
pdf_stroke($pdf);

pdf_moveto($pdf,720,34);
pdf_lineto($pdf,765,34);
pdf_stroke($pdf);


// end page	
	PDF_end_page_ext($pdf, "");
	
	$pageNum++;
	
	}// end loop of pages

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
	
 function pdf_arrow ($pdfobj, $x1, $y1, $x2, $y2, $dashed) {
 // This function will draw, stroke, and fill a line
 // from (x1,y1) to (x2,y2) with an arrowhead defined
 // by $headangle (in degrees) and $arrowlength.
 // If $dashed is nonzero, a dashed line is drawn.
 // REQUIRES: find_angle
 	 $headangle = 45;
 	 $arrowlength = 10;

 	 list ($angle, $slope) = find_angle($x1, $y1, $x2, $y2);

 	 pdf_moveto($pdfobj, $x2, $y2);

 	 // Find the two other points of the arrowhead
 	 // using $headangle and $arrowlength.
 	 $xarrow1 = $x2+cos(deg2rad(180+$angle+$headangle/2))*$arrowlength;
 	 $yarrow1 = $y2+sin(deg2rad(180+$angle+$headangle/2))*$arrowlength;
 	 $xarrow2 = $x2+cos(deg2rad(180+$angle-$headangle/2))*$arrowlength;
 	 $yarrow2 = $y2+sin(deg2rad(180+$angle-$headangle/2))*$arrowlength;
 	 // Draw two legs of the arrowhead, close and fill
 	 pdf_lineto($pdfobj, $xarrow1, $yarrow1);
 	 pdf_lineto($pdfobj, $xarrow2, $yarrow2);
 	 pdf_closepath($pdfobj);
 	 pdf_fill($pdfobj);

 	 // Find the point bisecting the short side
 	 // of the arrowhead. This is necessary so
 	 // the end of the line doesn't poke out the
 	 // beyond the arrow point.
 	 $x2line = ($xarrow1+$xarrow2)/2;
 	 $y2line = ($yarrow1+$yarrow2)/2;

 	 // Now draw the "body" line of the arrow
 	 if ($dashed != 0) {
 	 pdf_setdash($pdfobj,5,5);
 	 }
 	 pdf_moveto($pdfobj, $x1, $y1);
 	 pdf_lineto($pdfobj, $x2line, $y2line);
 	 pdf_stroke($pdfobj);
 } 
 function find_angle ($x1, $y1, $x2, $y2) {
 // by rod-php at thecomplex dot com
 // This function takes two points (x1,y1) and (x2,y2)
 // as inputs and finds the slope and angle of a line
 // between those two points. It returns the angle
 // and slope in an array. I can't figure out how to
 // return a NULL value, so if the two input points
 // are in a vertical line, the function returns
 // $angle = 90 and $slope = 0. I know this is wrong.
 	if (($x2-$x1) != 0) {
 			 $slope = ($y2-$y1)/($x2-$x1);
 			 // Get rotation angle by finding the arctangent of the slope
 			 $angle = rad2deg(atan($slope));
 			 if ($x1 > $x2) {
 				 	 $angle = 180+$angle;
 			 } elseif ($y1 > $y2) {
 				 	 $angle = 360+$angle;
 			 }
 	} else {
 			 // Vertical line has no slope, 90deg angle
 			 $angle = 90;
 #			 unset ($slope);
 			 $slope = 0;
 	}
 	return array ($angle, $slope);
 } 
?>