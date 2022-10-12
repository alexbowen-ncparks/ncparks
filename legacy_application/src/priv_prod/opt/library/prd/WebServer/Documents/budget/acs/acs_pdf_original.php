<?php # create_pdf.php 
extract($_REQUEST);
//print_r($_REQUEST);EXIT;
include("../../../include/connectBUDGET.inc");// database connection parameters

if($vendor_number){
$vendor_number=trim($vendor_number);
$select="SELECT * From cid_vendor_invoice_payments ";
$where="where cid_vendor_invoice_payments.vendor_number='$vendor_number' AND due_date='$due_date'";}
else{

if($prepared_by=="Barbara Adams"||$prepared_by=="Pamela Laurence"){
$pb="(prepared_by='Barbara Adams' OR prepared_by='Pamela Laurence')";}
else
{$pb="prepared_by='$prepared_by'";}

$vendor_name=urldecode($vendor_name);
$vendor_name=addslashes($vendor_name);
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
$inv_energy[]=$energy_group;
$inv_cdcs[]=$cdcs_uom;
$inv_energy_quantity[]=$energy_quantity;
$inv_re_number[]=$re_number;
$inv_pa_number[]=$pa_number;

// Set new variables so any one record with values gets printed
// otherwise ONLY values, if any, from the last record would print
if($new_vendor){$nv=$new_vendor;}
if($ncas_county_code){$cc=$ncas_county_code;}
if($ncas_remit_code){$rc=$ncas_remit_code;}
if($comPrevious!=$comments){
if($comments){$cf.=$comments." ";}}
$comPrevious=$comments;
if($fas_num){$cf.="*".$fas_num;}
if($ncas_buy_entity){$be=$ncas_buy_entity;}
if($ncas_po_number){$po=$ncas_po_number;}
if($part_pay){$pp=$part_pay;}
if($project_number){$pn=$project_number;}
if($group_number){$vg=$group_number;}
if($sheet){$sh=$sheet;}


if($fy){$po_fy=$fy;}
if($po_line1){$po1=$po_line1;}
if($po_line2){$po2=$po_line2;}
if($po_line3){$po3=$po_line3;}
if($amt1){$po_amt1=$amt1;}
if($amt2){$po_amt2=$amt2;}
if($amt3){$po_amt3=$amt3;}

}

// Set the constants and variables.
define ("PAGE_WIDTH", 792); // 11 inches
define ("PAGE_HEIGHT",612); // 8.5 inches

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

for($p=0;$p<$totPageNum;$p++){
// Create the page.
pdf_begin_page ($pdf, PAGE_WIDTH, PAGE_HEIGHT);

		// Set the default font from here on out.		
		$arial = pdf_findfont ($pdf, "Arial", "winansi");
		$arialBold = pdf_findfont ($pdf, "arialnb", "winansi");
		$arialItalic = pdf_findfont ($pdf, "Arial_Italic", "winansi");

$fontSize=12;
$lead=$fontSize+3;
pdf_setfont ($pdf, $arialBold, $fontSize);
			
$text="DEPARTMENT OF ENVIRONMENT AND NATURAL RESOURCES";
$widthText = pdf_stringwidth ($pdf, $text);// Width of Title
$hor=(PAGE_WIDTH-$widthText)/2;
$ver=PAGE_HEIGHT-25;
pdf_show_xy ($pdf, $text, $hor ,$ver);

$fontSize=10;
pdf_setfont ($pdf, $arial, $fontSize);
$text="Page $pageNum of $totPageNum";
$widthText = pdf_stringwidth ($pdf, $text);// Width of Title
$hor=(PAGE_WIDTH-$widthText-20);
pdf_show_xy ($pdf, $text, $hor ,$ver);

$fontSize=10;
pdf_setfont ($pdf, $arialBold, $fontSize);
$text="CASH DISBURSEMENTS CODE SHEET";
$widthText = pdf_stringwidth ($pdf, $text);
$hor=(PAGE_WIDTH-$widthText)/2;
$ver=$ver-$lead;
pdf_show_xy ($pdf, $text, $hor ,$ver);

$fontSize=10; pdf_setfont ($pdf, $arial, $fontSize);
$text="Division: Parks & Recreation";
$widthText = pdf_stringwidth ($pdf, $text);
$hor=15;$ver=$ver-$lead;
pdf_show_xy ($pdf, $text, $hor ,$ver);

pdf_setlinewidth($pdf, 1);
pdf_setcolor($pdf, 'both','rgb',0.0,0.0,0.0);
pdf_moveto($pdf,56,$ver-2);
pdf_lineto($pdf,142,$ver-2);
pdf_stroke($pdf);

$text="Vendor Number:    ".$vendor_number;
$widthText = pdf_stringwidth ($pdf, $text);
$hor=15; $ver=$ver-$lead;
pdf_show_xy ($pdf, $text, $hor ,$ver);
//pdf_moveto($pdf,90,$ver-2);
//pdf_lineto($pdf,150,$ver-2);
//pdf_stroke($pdf);

$hor=12+$widthText; 
$text="Grp. Letter       ".$vg;
$widthText = pdf_stringwidth ($pdf, $text);
$hor=$hor+widthText+45; $ver=$ver;
pdf_show_xy ($pdf, $text, 248 ,$ver);

$hor=$hor+widthText;
$text="New Vendor   ".$nv;
$widthText = pdf_stringwidth ($pdf, $text);
$hor=$hor+widthText+104; $ver=$ver;
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

pdf_rect($pdf, 475, 510, 298, 55); //draw the rectangle 
pdf_stroke($pdf);
//pdf_setcolor($pdf, 'fill','rgb',0.9,0.9,0.9);

//pdf_rect($pdf, 400, 505, 374, 60); //draw the rectangle 
//pdf_fill_stroke($pdf);

// PO Number box
pdf_rect($pdf, 530, 517, 135, 14); //draw the rectangle 
pdf_stroke($pdf);

// Partial Pay box
pdf_rect($pdf, 755, 517, 12, 14); 
pdf_stroke($pdf);

//pdf_setcolor($pdf, 'fill','rgb',0.0,0.0,0.0);
$fontSize=8; pdf_setfont ($pdf, $arial, $fontSize);
$text="Matching Invoices Only";
//(right to left, up and down, width, height)
$hor=575;
pdf_show_xy ($pdf, $text, $hor ,555);

$text="Buy Entity:";
$hor=480;
pdf_show_xy ($pdf, $text, $hor ,540);

/* vert dash inside buy entity box
pdf_setdash($pdf,1,1);
pdf_moveto($pdf,561,550);
pdf_lineto($pdf,561,535);
pdf_stroke($pdf);
pdf_setdash($pdf,1,0);
*/

$text="FY:   ".$po_fy;
$hor=705;
pdf_show_xy ($pdf, $text, $hor ,540);
pdf_moveto($pdf,720,539);
pdf_lineto($pdf,767,539);
pdf_stroke($pdf);

// Buy Entity
$fontSize=10; pdf_setfont ($pdf, $arial, $fontSize);
//$text="16E";
$text=$be;
	$hor=536;
	pdf_show_xy ($pdf, $text, $hor ,539);
	/*
$text=$be[0];
	$hor=567;
	pdf_show_xy ($pdf, $text, $hor ,539);
	*/
	
$fontSize=8; pdf_setfont ($pdf, $arial, $fontSize);
$text="PO Number:";
$hor=480;
pdf_show_xy ($pdf, $text, $hor ,521);
$text="$po";
$hor=535;
pdf_show_xy ($pdf, $text, $hor ,521);
$text="Partial Pmt.";
$hor=705;
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


$fontSize=10; pdf_setfont ($pdf, $arial, $fontSize);
$text="Vendor Name:    ".$vendor_name;
pdf_setlinewidth($pdf, 0.5);
$widthText = pdf_stringwidth ($pdf, $text);
$hor=15; $ver=$ver-$lead-3;
pdf_show_xy ($pdf, $text, $hor ,$ver);
pdf_moveto($pdf,90,$ver-1);
pdf_lineto($pdf,380,$ver-1);
pdf_stroke($pdf);

$va=nl2br($vendor_address);
$va=explode("<br />",$va);
$text="Vendor Address: $va[0]";
$widthText = pdf_stringwidth ($pdf, $text);
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

$rc=nl2br($rc);
$rcRC=explode("<br />",$rc);
$text="Remit Code / Message:    $rcRC[0]";
$widthText = pdf_stringwidth ($pdf, $text);
$hor=20;$verRC=434;
$widthB=450; $heightB=45; $modeB="left";
pdf_set_value($pdf,"leading",12);
pdf_show_boxed ($pdf, $text, $hor, $verRC ,$widthB,$heightB,$modeB);
pdf_moveto($pdf,130,466);
pdf_lineto($pdf,465,466);
pdf_stroke($pdf);

$text=trim($rcRC[1]);
if($text){$hor=30;
pdf_show_xy ($pdf, $text, $hor ,450);

pdf_moveto($pdf,29,449);
pdf_lineto($pdf,520,449);
pdf_stroke($pdf);
}

pdf_set_value($pdf,"leading",10);
$text="County Code:";
$widthText = pdf_stringwidth ($pdf, $text);
$hor=540; $ver=485;
pdf_show_xy ($pdf, $text, $hor ,$ver);

$text=$cc;$hor=610; 
pdf_show_xy ($pdf, $text, $hor ,$ver);

// Box 4 Budget Code
pdf_setlinewidth($pdf, 1);
pdf_rect($pdf, 605, 481, 28, 14); //draw the rectangle 
pdf_stroke($pdf);

$text="Budget Code:";
$widthText = pdf_stringwidth ($pdf, $text);
$hor=660; $ver=485;
pdf_show_xy ($pdf, $text, $hor ,$ver);
$text=$ncas_budget_code;
$hor=735;
pdf_show_xy ($pdf, $text, $hor ,485);

// Box 6 County Code
pdf_setlinewidth($pdf, 1);
pdf_rect($pdf, 724, 481, 50, 14); //draw the rectangle 
pdf_stroke($pdf);

// Header Box
pdf_setlinewidth($pdf, 1);
pdf_rect($pdf, 30, 408, 754.9, 30); //draw the rectangle 
pdf_stroke($pdf);

$text="Invoice Number";
$hor=75; $ver=415;
$widthB=50; $heightB=20; $modeB="center";
pdf_show_boxed ($pdf, $text, $hor ,$ver,$widthB,$heightB,$modeB);

$text="Invoice Date";
$hor=170; $ver=$ver;
$widthB=50; $heightB=20; $modeB="center";
pdf_show_boxed ($pdf, $text, $hor ,$ver,$widthB,$heightB,$modeB);

$text="PO line #";
$hor=220; $ver=$ver;
$widthB=30; $heightB=20; $modeB="center";
pdf_show_boxed ($pdf, $text, $hor ,$ver,$widthB,$heightB,$modeB);

$text="Amount";
$hor=268; $ver=$ver-5;
$widthB=50; $heightB=20; $modeB="center";
pdf_show_boxed ($pdf, $text, $hor ,$ver,$widthB,$heightB,$modeB);

$text="Cr";
$hor=325; $ver=$ver;
$widthB=50; $heightB=20; $modeB="center";
pdf_show_boxed ($pdf, $text, $hor ,$ver,$widthB,$heightB,$modeB);

$text="Company";
$hor=365; $ver=$ver;
$widthB=50; $heightB=20; $modeB="center";
pdf_show_boxed ($pdf, $text, $hor ,$ver,$widthB,$heightB,$modeB);

$text="Account";
$hor=428; $ver=$ver;
$widthB=50; $heightB=20; $modeB="center";
pdf_show_boxed ($pdf, $text, $hor ,$ver,$widthB,$heightB,$modeB);

$text="Account Description";
$hor=518; $ver=$ver+5;
$widthB=75; $heightB=20; $modeB="center";
pdf_show_boxed ($pdf, $text, $hor ,$ver,$widthB,$heightB,$modeB);

$text="Center";
$hor=620; $ver=$ver-5;
$widthB=50; $heightB=20; $modeB="center";
pdf_show_boxed ($pdf, $text, $hor ,$ver,$widthB,$heightB,$modeB);

$text="1099 Code";
$hor=675; $ver=$ver+5;
$widthB=30; $heightB=20; $modeB="center";
pdf_show_boxed ($pdf, $text, $hor ,$ver,$widthB,$heightB,$modeB);

$text="Accrual Code";
$hor=700; $ver=$ver;
$widthB=50; $heightB=20; $modeB="center";
pdf_show_boxed ($pdf, $text, $hor ,$ver,$widthB,$heightB,$modeB);

$text="Energy";
$hor=739; $ver=$ver;
$widthB=50; $heightB=20; $modeB="center";
pdf_show_boxed ($pdf, $text, $hor ,$ver,$widthB,$heightB,$modeB);
// **************************************************
// *********** Start Records from Arrays ************
$ver=$ver-34;
pdf_setlinewidth($pdf, 0.5);
$numLines=count($inv_num);

if($totPageNum>1){
if($p==0){$end=16;$r=0;}else{
$numLines=$numLines-$start;
$end=$start+$numLines;$end=$start+16;
}
}else{$end=$numLines;$r=0;}


unset($testText0,$testText1,$testText5,$testText6,$testText7);

for($xx=$start;$xx<$end;$xx++){

if($inv_num[$r]){
$text=$r+1;
$hor=18;
$verNum=$ver+10;
pdf_show_xy ($pdf, $text, $hor ,$verNum);

// Invoice Num
if($testText0==$inv_num[$r]){$text="      \"";$modeB="left";}else{
$text=$inv_num[$r]; $testText0=$text; $modeB="left";}
$hor=38; 
$widthB=160; $heightB=20; 
pdf_show_boxed ($pdf, $text, $hor ,$ver,$widthB,$heightB,$modeB);

// Invoice Date
if($testText1==$inv_date[$r]){$text="\"";$modeB="center";}else{
$text=$inv_date[$r]; $testText1=$text; $modeB="center";}
$hor=162;
$widthB=65; $heightB=20; 
pdf_show_boxed ($pdf, $text, $hor ,$ver,$widthB,$heightB,$modeB);

// Invoice po_line1
$text=$inv_po_line1[$r]; //$testText8=$text; 
$hor=173;$modeB="right";
$widthB=75; $heightB=20; 
pdf_show_boxed ($pdf, $text, $hor ,$ver,$widthB,$heightB,$modeB);

// Invoice ncas_invoice_amount
$text=$inv_amt[$r]; $testText2=$text; $modeB="right";
$hor=252;
$widthB=75; $heightB=20; 
pdf_show_boxed ($pdf, number_format($text,2), $hor ,$ver,$widthB,$heightB,$modeB);

// ncas_freight ncas_invoice_amount
if($testText4!=$inv_ncas_freight[$r]){$text4=$inv_ncas_freight[$r]; $testText4=$text;}

// Company
if($testText5==$inv_com[$r]){$text="\"";$modeB="center";}else{
$text=$inv_com[$r]; $testText5=$text; $modeB="center";}
$hor=350;
$widthB=75; $heightB=20; 
pdf_show_boxed ($pdf, $text, $hor ,$ver,$widthB,$heightB,$modeB);

// Account
if($testText6==$inv_account[$r]){$text="\"";$modeB="center";}else{
$text=$inv_account[$r]; $testText6=$text; $modeB="center";}
$hor=412;
$widthB=75; $heightB=20; 
pdf_show_boxed ($pdf, $text, $hor ,$ver,$widthB,$heightB,$modeB);

// Account Description
if($testText6a==$inv_acct_desc[$r]){$text="          \"";$modeB="center";}else{
$text=$inv_acct_desc[$r]; $testText6a=$text; $modeB="center";}
$hor=488;
$widthB=100; $heightB=20; 
$text=substr($text,0,26);
//pdf_show_boxed ($pdf, $text, $hor ,$ver,$widthB,$heightB,$modeB);
pdf_show_xy ($pdf, $text, $hor ,$verNum);

// Center
if($testText7==$inv_center[$r]){$text="       \"";$modeB="left";}else{
$text=$inv_center[$r]; $testText7=$text; $modeB="left";}
//$hor=530;
$hor=624;
$widthB=75; $heightB=20; 
pdf_show_boxed ($pdf, $text, $hor ,$ver,$widthB,$heightB,$modeB);

// CR ncas_credit
$text=$inv_ncas_credit[$r];$modeB="center";
$hor=312;
$widthB=75; $heightB=20; 
pdf_show_boxed ($pdf, $text, $hor ,$ver,$widthB,$heightB,$modeB);


// ncas_accrual_code
$text=$inv_ncas_accrual_code[$r];$modeB="center";
$hor=708;
$widthB=35; $heightB=20; 
pdf_show_boxed ($pdf, $text, $hor ,$ver,$widthB,$heightB,$modeB);

// energy
$fontSize=8; pdf_setfont ($pdf, $arial, $fontSize);
	if($inv_cdcs[$r]){
		$text=$inv_cdcs[$r]."\r".$inv_energy_quantity[$r];}
		else
		{$text=$inv_energy_quantity[$r];}
$modeB="center";
$hor=742;
$widthB=45; $heightB=23; 
pdf_show_boxed ($pdf, $text, $hor ,$ver,$widthB,$heightB,$modeB);


$fontSize=10; pdf_setfont ($pdf, $arial, $fontSize);
if(!$inv_ncas_credit[$r]){$grossAmt=$grossAmt+$inv_amt[$r];}else{$grossAmt=$grossAmt-$inv_amt[$r];}
$ncas_freightAmt=$ncas_freightAmt+$inv_ncas_freight[$r];

// Horizontal lines
$verLine=$ver+6;
pdf_moveto($pdf,30,$verLine);
pdf_lineto($pdf,785,$verLine);
pdf_stroke($pdf);

$start++;
$r++;
$ver=$ver-16;

}// if
}// end for

//$end=$end+16;
//echo "start= $start  end= $end t =$totPageNum  n= $numLines xx=$xx";exit;

// *************  Header Box Vertical lines
pdf_setlinewidth($pdf, 1);
$top=410;$bottom=$verLine;
pdf_moveto($pdf,30,$top);
pdf_lineto($pdf,30,$bottom);
pdf_stroke($pdf);

//inv date start
$top=438;$bottom=$verLine;
pdf_moveto($pdf,170,$top);
pdf_lineto($pdf,170,$bottom);
pdf_stroke($pdf);

//po_line start
pdf_moveto($pdf,220,$top);
pdf_lineto($pdf,220,$bottom);
pdf_stroke($pdf);

//amt start
pdf_moveto($pdf,250,$top);
pdf_lineto($pdf,250,$bottom);
pdf_stroke($pdf);

pdf_moveto($pdf,335,$top);
pdf_lineto($pdf,335,$bottom);
pdf_stroke($pdf);

pdf_moveto($pdf,365,$top);
pdf_lineto($pdf,365,$bottom);
pdf_stroke($pdf);

// Company
pdf_moveto($pdf,416,$top);
pdf_lineto($pdf,416,$bottom);
pdf_stroke($pdf);

// Account
pdf_moveto($pdf,485,$top);
pdf_lineto($pdf,485,$bottom);
pdf_stroke($pdf);

// Description
pdf_moveto($pdf,620,$top);
pdf_lineto($pdf,620,$bottom);
pdf_stroke($pdf);

pdf_moveto($pdf,675,$top);
pdf_lineto($pdf,675,$bottom);
pdf_stroke($pdf);

// Accrual
pdf_moveto($pdf,706,$top);
pdf_lineto($pdf,706,$bottom);
pdf_stroke($pdf);

//Left of Energy
pdf_moveto($pdf,744,$top);
pdf_lineto($pdf,744,$bottom);
pdf_stroke($pdf);

//Right of Energy
pdf_moveto($pdf,785,$top);
pdf_lineto($pdf,785,$bottom);
pdf_stroke($pdf);

if($pageNum!=$totPageNum){// more than 1 page
$textF="Freight Subtotal";
$textA="ncas_invoice_amount Subtotal";
}else
{$textF="Freight Amt";
$textA="Gross Amt";}
// ncas_freight ncas_invoice_amount
$modeB="right";
$hor=252;$ver=$ver;
$widthB=75; $heightB=20; 
pdf_show_boxed ($pdf, number_format($ncas_freightAmt,2), $hor ,$ver,$widthB,$heightB,$modeB);
// Gross ncas_invoice_amount
$modeB="right";
$hor=252;$ver=$ver-14;
$widthB=75; $heightB=20; 
pdf_show_boxed ($pdf, number_format($grossAmt,2), $hor ,$ver,$widthB,$heightB,$modeB);
$fontSize=7;
pdf_setfont ($pdf, $arialBold, $fontSize);

$hor=334; $hei=$ver+24;
pdf_show_xy ($pdf, $textF, $hor ,$hei);
$hor=334; $hei=$ver+10;
pdf_show_xy ($pdf, $textA, $hor ,$hei);

// Comments
$modeB="left";
$hor=420;$verC=$hei-31;
$widthB=320; $heightB=55;
$fontSize=9;
pdf_setfont ($pdf, $arial, $fontSize);
$comFas=explode("*",$cf);
$text="Comments: $comFas[0]";
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
pdf_set_value($pdf,"leading",10);
pdf_show_boxed ($pdf, $text, $hor ,$verC,$widthB,$heightB,$modeB);
$fas=trim($comFas[1]);
if($fas){
$text="FAS Number: $fas";
$verF=$verC+5;
pdf_show_xy ($pdf, $text, $hor ,$verF);}

//Project Number 
if($pn){
$text="project_number: ".$pn;
$hor=150;
pdf_show_xy ($pdf, $text, $hor ,85);}

//Park ACS # 
if($sh){
$text="PARK#: ".$sh;
$hor=150;
pdf_show_xy ($pdf, $text, $hor ,65);}

// ********* Footer Stuff *************

// Pay Entity
// Box 
//(right to left, up and down, width, height)
$fontSize=10;
pdf_setfont ($pdf, $arial, $fontSize);
pdf_setlinewidth($pdf, 1);
pdf_rect($pdf, 73, 81, 40, 14); //draw the rectangle 
pdf_stroke($pdf);
$text="Pay entity:  $pay_entity";
$hor=24;$ver=75;$modeB="left";
$widthB=100; $heightB=20; 
pdf_show_boxed ($pdf, $text, $hor ,$ver,$widthB,$heightB,$modeB);

$fontSize=8;
pdf_setfont ($pdf, $arial, $fontSize);
$hor=38; 
$text="*(PC = Contract Vendors -                                                )*";
pdf_show_xy ($pdf, $text, $hor ,20);
pdf_setfont ($pdf, $arialBold, $fontSize);
$text="Use Contract Expenditure Report";
pdf_show_xy ($pdf, $text, 134 ,20);

//pdf_arrow ($pdfobj, $x1, $y1, $x2, $y2, $dashed)

pdf_arrow ($pdf, 15, 44, 35, 44, 0);

pdf_setfont ($pdf, $arial, $fontSize);
$peText="PT = Trade Vendors*PE = Employee Vendors*PN = Non-Trade Vendors*PC - Do Not Use this form for PC payments";
$peText=explode("*",$peText);
$ver=$ver+6;
for($j=0;$j<count($peText);$j++){
$text=$peText[$j];
$hor=38; $ver=$ver-10;
if($j==3){
pdf_setfont ($pdf, $arialBold, $fontSize);}
pdf_show_xy ($pdf, $text, $hor ,$ver);}

pdf_setfont ($pdf, $arial, $fontSize);
// Controller's Box 
pdf_setlinewidth($pdf, 1);
pdf_rect($pdf, 275, 25, 115, 74); //draw the rectangle 
pdf_stroke($pdf);

/*
pdf_setcolor($pdf, 'fill','rgb',0.9,0.9,0.9);
pdf_rect($pdf, 200, 35, 150, 44); //fill the rectangle
pdf_fill_stroke($pdf);
*/

//pdf_setcolor($pdf, 'both','rgb',0.0,0.0,0.0);
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

// Prepared by
$text="Prepared By:";
	$hor=420;$ver=93;
	pdf_show_xy ($pdf, $text, $hor ,$ver);
$text=$prepared_by;
	$hor=475;$ver=93;
	pdf_show_xy ($pdf, $text, $hor ,$ver);
	
$text="Received By:";
	$hor=420;$ver=75;
	pdf_show_xy ($pdf, $text, $hor ,$ver);
$text=$received_by;
	$hor=475;$ver=75;
	pdf_show_xy ($pdf, $text, $hor ,$ver);
	
$text="Approved By:";
	$hor=420;$ver=55;
	pdf_show_xy ($pdf, $text, $hor ,$ver);
$text=$approved_by;
	$hor=475;$ver=55;
//	pdf_show_xy ($pdf, $text, $hor ,$ver);
$text="Entered By:";
	$hor=420;$ver=35;
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

// Dates
$text="Date:";
	$hor=670;$ver=93;
	pdf_show_xy ($pdf, $text, $hor ,$ver);
$text=$prepared_date;
	$hor=700;$ver=93;
	pdf_show_xy ($pdf, $text, $hor ,$ver);
$text="Date:";
	$hor=670;$ver=75;
//	pdf_show_xy ($pdf, $text, $hor ,$ver);
$text=$received_date;
	$hor=700;$ver=75;
//	pdf_show_xy ($pdf, $text, $hor ,$ver);
$text="Date:";
	$hor=670;$ver=55;
	pdf_show_xy ($pdf, $text, $hor ,$ver);
$text=$approved_date;
	$hor=700;$ver=55;
	pdf_show_xy ($pdf, $text, $hor ,$ver);
$text="Date:";
	$hor=670;$ver=35;
	pdf_show_xy ($pdf, $text, $hor ,$ver);
	
/*  // not needed according to Eva Ennis
$text=$ncas_date_entered;
	$hor=700;$ver=35;
	pdf_show_xy ($pdf, $text, $hor ,$ver);
*/
$text="Please use yellow paper.";
	$hor=670;$ver=15;
	pdf_show_xy ($pdf, $text, $hor ,$ver);

pdf_moveto($pdf,693,92);
pdf_lineto($pdf,760,92);
pdf_stroke($pdf);

// underline for received_date
//pdf_moveto($pdf,693,74);
//pdf_lineto($pdf,760,74);
//pdf_stroke($pdf);

pdf_moveto($pdf,693,54);
pdf_lineto($pdf,760,54);
pdf_stroke($pdf);

pdf_moveto($pdf,693,34);
pdf_lineto($pdf,760,34);
pdf_stroke($pdf);


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