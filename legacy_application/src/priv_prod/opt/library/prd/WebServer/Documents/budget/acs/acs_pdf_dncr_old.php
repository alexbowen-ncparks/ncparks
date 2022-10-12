<?php

//print_r($_REQUEST);EXIT;

//ini_set('display_errors,',1);

$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection,$database); // database 

//echo "<pre>"; print_r($_REQUEST); echo "</pre>"; // exit;
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
$where="where vendor_name='$vendor_name' AND due_date='$due_date' AND $pb";
}
$JOIN="LEFT JOIN coa on cid_vendor_invoice_payments.ncas_account = coa.ncasnum";

$sql = "$select
$JOIN
$where
order by ncas_invoice_number";
// echo "$sql"; exit;

$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql");

while($row=mysqli_fetch_array($result))
	{
	$inv_id_array[]=$row['id'];
	}
$number_of_invoices=mysqli_num_rows($result);
	
// echo "<pre>"; print_r($inv_id_array); echo "</pre>";  exit;

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

// ******************** Start Loop ***************
$start=0;
$pageNum=1;

// echo "<pre>"; print_r($inv_id); echo "</pre>";  exit;

foreach($inv_id_array as $index=>$inv_id)
	{
	
	$where="where id='$inv_id'";
	$sql = "$select
	$JOIN
	$where
	order by ncas_invoice_number";
	$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql");

	// if($index>0){echo "$sql"; exit;}

	$num=mysqli_num_rows($result);
	$totPageNum=ceil($num/16);
	// unset($inv_num,$inv_date,$inv_amt,$inv_com,$inv_ncas_freight,$inv_account,$inv_center,$inv_ncas_credit,$inv_acct_desc);
	while($row=mysqli_fetch_array($result))
		{
		extract($row);
		if($project_number){$ncas_rcc="";}//PARTF Center just equals Fund
		$inv_num[$inv_id]=$ncas_invoice_number;
		$inv_date[$inv_id]=$ncas_invoice_date;
		$inv_amt[$inv_id]=$invoice_total;
		$inv_com[$inv_id]=$ncas_company;
		$inv_ncas_freight[$inv_id]=$ncas_freight;
		$inv_account[$inv_id]=$prefix.$ncas_number;
		$inv_center[$inv_id]=$ncas_fund.$ncas_rcc;

		$inv_ncas_credit[$inv_id]=$ncas_credit;

		$inv_acct_desc[$inv_id]=$park_acct_desc;

		if($group_number){$vg=$group_number;}
		
		if($comPrevious!=$comments)
			{
			if($comments){@$cf=$comments." ";}
			}
		$comPrevious=$comments;
		}

	PDF_begin_page_ext($pdf, PAGE_WIDTH, PAGE_HEIGHT, "");
	
	$arial = PDF_load_font($pdf, "Arial", "winansi", "");
	$arialBold = PDF_load_font($pdf, "arialnb", "winansi", "");
	$font = PDF_load_font($pdf, "Helvetica-Bold", "winansi", "");
	
		$fontSize=12.0;
	PDF_setfont($pdf, $font, $fontSize);
	
// 		$text="DEPARTMENT OF NATURAL AND CULTURAL RESOURCES";
// 		$widthText = pdf_stringwidth ($pdf, $text, $font, $fontSize);// Width of Title
		$hor=(PAGE_WIDTH-$widthText)/2;
		$ver=PAGE_HEIGHT-25;
// 	PDF_set_text_pos($pdf, $hor, $ver);
// 	PDF_show($pdf, $text);
	
	
	$font = PDF_load_font($pdf, "Arial", "winansi", "");
		$fontSize=10.0;
	PDF_setfont($pdf, $font, $fontSize);
	
// 	$text="Page $pageNum of $totPageNum";
	$text="Page 1 of $totPageNum";
	$widthText = pdf_stringwidth ($pdf, $text, $font, $fontSize);
	$hor=(PAGE_WIDTH-$widthText-30);
	pdf_show_xy ($pdf, $text, $hor ,$ver);

	
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
	$text="Group Letter: ".$vg;
	$widthText = pdf_stringwidth ($pdf, $text, $font, $fontSize);
	$hor=$hor+$widthText+45; $ver=$ver;
	pdf_show_xy ($pdf, $text, 248 ,$ver);
	
	// Header Box
	pdf_setlinewidth($pdf, 1);
	pdf_rect($pdf, 30, 508, 570, 30); //draw the rectangle 
	pdf_stroke($pdf);
	
	
	$cols=5;
	$ver=525;
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


// *********** Start Records from Arrays ************
$ver=$ver-30;
pdf_setlinewidth($pdf, 0.5);
$numLines=count($inv_num);

if($totPageNum>1)  // line 87
	{
	if($p==0)
		{
		$end=16;
		$r=0;
		}
	else
		{
		$numLines=$numLines-$start;
		$end=$start+$numLines;$end=$start+16;
		}
	}
	else
	{
	$end=$numLines;
	$r=0;
	}

 // for left
//PDF_fit_textline($pdf, $text, 60, 350, "boxsize {500 140} position {0 50}");
// for center
//PDF_fit_textline($pdf, $text, 60, 350, "boxsize {500 140} position {50 50}");  // for right
//PDF_fit_textline($pdf, $text, 60, 350, "boxsize {500 140} position {100 50}");

$testText0="";$testText1="";$testText2="";$testText3="";$testText4="";$testText5="";$testText6="";$testText7="";

for($xx=$start;$xx<$end;$xx++)
	{
$r=$inv_id;
	if($inv_num[$r])
		{
		
		// Invoice ncas_invoice_amount
		$text=$inv_amt[$r]; $testText2=$text;
		$hor=70;
		$xstart=30;
		$just=100;
		text_block($pdf,$text,$cols,$hor,$ver,$xstart,$just);
		$just=50;
		
		// CR ncas_credit
		$text=$inv_ncas_credit[$r];
		$hor+=10;
		$xstart=30;
		$cols=strlen($text)-1;
		text_block($pdf,$text,$cols,105,$ver,$xstart,$just);
		
		// ncas_freight ncas_invoice_amount
		if($testText4!=$inv_ncas_freight[$r])
		{
		$text4=$inv_ncas_freight[$r]; $testText4=$text;
		}

		// Budget Code
	$text=$ncas_budget_code;
		$hor+=55;
		$xstart=30;
		$cols=strlen($text)-1;
		text_block($pdf,$text,$cols,$hor,$ver,$xstart,$just);
		
		// Company
// 		if($testText5==$inv_com[$r]){$text="\"";}else{
		
		$text=$inv_com[$r]; $testText5=$text;
// 		}
		$hor+=55;
		$xstart=30;
		$cols=strlen($text)-1;
		text_block($pdf,$text,$cols,$hor,$ver,$xstart,$just);
		
		// Account
// 		if($testText6==$inv_account[$r]){$text="\"";}else{
		
		$text=$inv_account[$r]; $testText6=$text;
// 		}
		$hor+=65;
		$xstart=30;
		$cols=strlen($text)-1;
		text_block($pdf,$text,$cols,$hor,$ver,$xstart,$just);
		
		// Account Description
// 		if($testText6a==$inv_acct_desc[$r]){$text="          \"";}else{
		
		$text=$inv_acct_desc[$r]; $testText6a=$text; 
// 		}
		$hor+=110;
		$text=substr($text,0,26);
		$xstart=30;
		$cols=strlen($text)-1;
		text_block($pdf,$text,$cols,$hor,$ver,$xstart,$just);
		
		// Center
// 		if($testText7==$inv_center[$r]){$text="       \"";}else{
		
		$text=$inv_center[$r]; $testText7=$text;
// 		}	
		$hor+=190;
		$xstart=30;
		$cols=strlen($text)-1;
		text_block($pdf,$text,$cols,$hor,$ver,$xstart,$just);
		
		$fontSize=10; 
		PDF_setfont($pdf, $font, $fontSize);
// 		if(!$inv_ncas_credit[$r])
// 			{
// 			$grossAmt=$grossAmt+$inv_amt[$r];
// 			}
// 			else
// 			{
// 			$grossAmt=$grossAmt+$inv_amt[$r];
// 			}
		$grossAmt=$inv_amt[$r];
		$ncas_freightAmt+=$inv_ncas_freight[$r];
		
		// Horizontal lines
		$verLine=$ver;
		pdf_moveto($pdf,30,$verLine);
		pdf_lineto($pdf,600,$verLine);
		pdf_stroke($pdf);
		
		$start++;
		$r++;
		$ver=$ver-16;
		
		}// if
	}

// *************  Header Box Vertical lines
// before Amount
pdf_setlinewidth($pdf, 1);
$top=510;$bottom=$verLine;
pdf_moveto($pdf,30,$top);
pdf_lineto($pdf,30,$bottom);
pdf_stroke($pdf);

//before Cr
$top=538;$bottom=$verLine;
pdf_moveto($pdf,111,$top);
pdf_lineto($pdf,111,$bottom);
pdf_stroke($pdf);

//before Budge Code
pdf_moveto($pdf,130,$top);
pdf_lineto($pdf,130,$bottom);
pdf_stroke($pdf);

// before Company
pdf_moveto($pdf,180,$top);
pdf_lineto($pdf,180,$bottom);
pdf_stroke($pdf);

// before Account
pdf_moveto($pdf,238,$top);
pdf_lineto($pdf,238,$bottom);
pdf_stroke($pdf);

// before Account Desc.
pdf_moveto($pdf,311,$top);
pdf_lineto($pdf,311,$bottom);
pdf_stroke($pdf);

// Account
pdf_moveto($pdf,530,$top);
pdf_lineto($pdf,530,$bottom);
pdf_stroke($pdf);

// Description
pdf_moveto($pdf,600,$top);
pdf_lineto($pdf,600,$bottom);
pdf_stroke($pdf);

if($pageNum!=$totPageNum)
	{// more than 1 page
// 	$textF="Freight Subtotal";
// 	$textA="ncas_invoice_amount Subtotal";
	$textF="Freight Amt";
	$textA="Gross Amt";
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
$new_str="";
if($com_len>$incre)
	{
	$com_exp=explode(" ",$text);
	foreach($com_exp as $var_1=>$var_2)
		{
		$new_str.=" ".$var_2;
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
	

?>