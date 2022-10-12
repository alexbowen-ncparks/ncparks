<?php

//echo "$sql<pre>";print_r($arraystatusDesign);print_r($arraystatusConstruct);echo "</pre>";
//echo "n=$num";exit;

// **************** Begin PDF ****************
// Set the constants and variables.
		define ("PAGE_WIDTH", 1008); // 14 inches
		define ("PAGE_HEIGHT", 612); // 8.5 inches
$x=60; // left margin
$y=562;// top margin
$a=$x-10;// start of horizontal lines

$gap=2.5;// set space between lines in report
$linewidth=.2;// width of line between lines in report

$num=count($arrayprojName);
$k=1;// page numbering starts at 2
$aPage=PAGE_HEIGHT/12; // 10 = apx. height of each line
$pages=ceil($num/($aPage));// gets total number of pages


//echo "p=$pages a=$aPage n=$num";exit;
// $num is number of lines of data
// page # is result of font size 8 and page height
// +1 accounts for page 1 

// These values control position of column headers and row cells
$col1=$x; // FISCAL YR FUND
$col2=50+$col1;// PARK
$col3=110+$col2;// PARK DIST, COUNTY
$col4=150+$col3;// PROJECT NAME
$col5=200+$col4;// EXPENSES CURRENT MONTH
$col6=70+$col5;// POSTED FUNDS
$col7=60+$col6;// POSTED EXPENSES
$col8=75+$col7;// BALANCE
$col9=60+$col8;// EST START

// 5.3 is used to convert strlen into a rough PDF Upper Case width
// 4.3 is used to convert strlen into a rough PDF lower Case width
// They are purely arbitrary numbers for this font/size.
$col10=(2.6*$Parkwidth)+$col9;// EST END
$col11=(1.5*$DCwidth)+$col10;// PHASE
//$col11=(5.6*$PNwidth)+$col10;// FUNDS CURRENT MONTH
//$col12=(5.0*$Creditwidth)+$col11;// EXPENSES CURRENT MONTH

//$col13=(6.1*$Expensewidth)+$col12;// POSTED FUNDS

//$col14=(5.1*$PFwidth)+$col13;// POSTED EXPENSES

//$col15=50+$col14;// BALANCE
//$col16=8+$col15;// EST START
//$col17=35+$col16;// EST END
//$col18=30+$col17;// PHASE
//$col19=40+$col18;// STATUS

		// Make the PDF.	
		$pdf = pdf_new(); include("/opt/library/prd/WebServer/include/pdf_key_23.php");pdf_open_file ($pdf, "");
	
		// Set the different PDF values.
		pdf_set_info ($pdf, "Author", "Tom Howard");
		pdf_set_info ($pdf, "Title", "NC Park Authority Project Status Report Posted Thru" . $thruDate);
		pdf_set_info ($pdf, "Creator", "NC DPR Budget Website");

		// Create the page.
		pdf_begin_page ($pdf, PAGE_WIDTH, PAGE_HEIGHT);

		// Set the default font from here on out.
		
		$font_path="/opt/library/prd/WebServer/Documents/inc/fonts/";
		$arial = PDF_load_font ($pdf, $font_path."Arial", "winansi","");
		$arialBold = PDF_load_font ($pdf, $font_path."arialnb", "winansi","");
		
	
	
headerStuff1($pdf);

function headerStuff1($pdf){
global $y,$arial,$col1,$col2,$col3,$col4,$col5,$col6,$col7,$col8,$col9,$col10,$col11,$col12,$col13,$col14,$col15,$col16,$col17,$col18,$col19,$thruDate,$month,$year;
// Header Stuff
$linewidth=.2;// width of the black line between lines in report
	$fontSize=10;
$arialBold = PDF_load_font ($pdf, "arialnb", "winansi","");
		pdf_setfont ($pdf, $arialBold, $fontSize);
$text="NC PARK AUTHORITY PROJECT STATUS REPORT POSTED THRU $thruDate";
$widthTitle = pdf_stringwidth ($pdf, $text,$arialBold,$fontSize);// Width of Title
$middleofpage=PAGE_WIDTH/2;$middleofTitle=$widthTitle/2;
		pdf_setcolor ($pdf, 'both', 'rgb', 0, 0, 0, 0);
		$lr=$middleofpage - $middleofTitle;
		$lr=$middleofpage - $middleofTitle;
		pdf_show_xy ($pdf, $text, $lr, $y+10);
		
$leading=10;// add some more space after Title
	$y=$y-$fontSize-$leading;
//$arialBold = PDF_load_font ($pdf, "arialnb", "winansi","");

	$fontSize=7;
pdf_setfont ($pdf, $arialBold, $fontSize);
/*
$text="PROJ";pdf_show_xy ($pdf, $text, $col1-2, $y+$fontSize);
$text="NUM";pdf_show_xy ($pdf, $text, $col1, $y);

$text="CALENDAR";pdf_show_xy ($pdf, $text, $col2-11, $y+(2*$fontSize));
$text="YR OF";pdf_show_xy ($pdf, $text, $col2-2, $y+$fontSize);
$text="FUNDING";pdf_show_xy ($pdf, $text, $col2-7, $y);

$text="CRTN";pdf_show_xy ($pdf, $text, $col3-3, $y+$fontSize);
$text="CNTR";pdf_show_xy ($pdf, $text, $col3-3, $y);

$text="CODE";pdf_show_xy ($pdf, $text, $col4-2, $y);

$text="COMP";pdf_show_xy ($pdf, $text, $col5-2, $y);

$text="MGR";pdf_show_xy ($pdf, $text, $col6-2, $y);
*/

$text="FISCAL YEAR";pdf_show_xy ($pdf, $text, $col1-5, $y+(2*$fontSize));
$text=" OF";pdf_show_xy ($pdf, $text, $col1+7, $y+$fontSize);
$text="FUND";pdf_show_xy ($pdf, $text, $col1+4, $y);

$text="PARK";pdf_show_xy ($pdf, $text, $col2+15, $y);

$text="PARK DIST, COUNTY";pdf_show_xy ($pdf, $text, $col3, $y);

$text="PROJECT NAME";pdf_show_xy ($pdf, $text, $col4, $y);

//$shortMonth=date("M", mktime(0,0,0,$month,1,$year));
//$shortYear=date("y", mktime(0,0,0,$month,1,$year));
$longMonth=strtoupper(date("F", mktime(0,0,0,$month,1,$year)));

// BAD SCRIPTING ****** I USED COL5 FOR BOTH FUNDS AND EXPENSES *****
// Just added or sub from it
//$text="CURRENT";pdf_show_xy ($pdf, $text, $col5-30, $y+(2*$fontSize));
$text="EXPENSES";pdf_show_xy ($pdf, $text, $col5-28, $y+$fontSize);
// JANUARY   $col5-26
$text=$longMonth;pdf_show_xy ($pdf, $text, $col5-26, $y);

$text="TOTAL";pdf_show_xy ($pdf, $text, $col5+45, $y+$fontSize);
$text="FUNDS";pdf_show_xy ($pdf, $text, $col5+44, $y);

$text="TOTAL";pdf_show_xy ($pdf, $text, $col6+34, $y+$fontSize);
$text="EXPENSES";pdf_show_xy ($pdf, $text, $col6+28, $y);

//$text="POSTED";pdf_show_xy ($pdf, $text, $col7+45, $y+$fontSize);
$text="BALANCE";pdf_show_xy ($pdf, $text, $col7+45, $y);

$text="Construction";pdf_show_xy ($pdf, $text, $col8+20, $y+$fontSize);
$text="Start";pdf_show_xy ($pdf, $text, $col8+30, $y);

$text="Construction";pdf_show_xy ($pdf, $text, $col9+20, $y+$fontSize);
$text="End";pdf_show_xy ($pdf, $text, $col9+30, $y);

$text="% COMPLETE";pdf_show_xy ($pdf, $text, $col11-12,$y+(2*$fontSize));
$text="D=DESIGN";pdf_show_xy ($pdf, $text, $col11-8,$y+$fontSize);
$text="C=CONST";pdf_show_xy ($pdf, $text, $col11-8, $y);

//$text="Status";pdf_show_xy ($pdf, $text, $col19-8, $y);
$y=$y-$linewidth;
}


$b=PAGE_WIDTH-60;// end of horizontal lines
pdf_setlinewidth($pdf,$linewidth);
$z=$y-$gap;
makeLine($pdf,$a,$b,$z);
$y=$y-$linewidth;


// Data Stuff
$fontSize=7; // page 1
pdf_setfont ($pdf, $arial, $fontSize);
$text=date("n/d/Y g:i A");
pdf_show_xy ($pdf, $text, PAGE_WIDTH-950, PAGE_HEIGHT-600);

$text="Page: ".$k." of ".$pages;pdf_show_xy ($pdf, $text, PAGE_WIDTH-75, PAGE_HEIGHT-600);
$k++;

//echo "<pre>";print_r($arrayAllCredits);echo "</pre>";exit;

while(list($key,$val)=each($arrayAllCredits))
{// move thru the array extracting values
$projNum=$key;

$cumAmount=@$arrayAllPayments[$projNum];
$credit=@$arrayAllCredits[$projNum];
$amt=@$arraySomePayments[$projNum];
//$cumAmountTot=$cumAmountTot+$cumAmount;
//$creditTot=$creditTot+$credit;
//$amtTot=$amtTot+$amt;

$credit=@$arrayAllCredits[$projNum];
$YearFundC=@$arrayYearFundC[$projNum];
$Center=strtoupper($arrayCenter[$projNum]);
$budgCode=$arraybudgCode[$projNum];
$comp=$arraycomp[$projNum];
$proj_man=$arrayproj_man[$projNum];
$YearFundF=$arrayYearFundF[$projNum];
$fullname=$arraypark[$projNum];
$dist=$arraydist[$projNum];
$county=$arraycounty[$projNum];
$projName=$arrayprojName[$projNum];
$startDate=$arraystartDate[$projNum];
$endDate=$arrayendDate[$projNum];

$design1=$arraystatusDesign[$projNum];
$construct1=$arraystatusConstruct[$projNum];

$construct1=$construct1+0;$design1=$design1+0;
if($construct1==""){
$statusDC="D-".$design1;}
else
{
$statusDC="C-".$construct1;}

/* // old
if($construct1==""){
$design1=$design1+0;
$statusDC="D-".$design1;}
else
{
$construct1=$construct1+0;
$statusDC="C-".$construct1;}
*/


$statusPer=$arraystatusPer[$projNum];
switch ($statusPer) {
		case "NS":
			$status = "NOT STARTED";
			break;	
		case "IP":
			$status = "IN PROGRESS";
			break;	
		case "OH":
			$status = "ON HOLD";
			break;	
		case "FI":
			$status = "FINISHED";
			break;	
	}

$dif=($credit-$cumAmount);
$difTot=@$difTot+$dif;

$dif=formatMoney($dif);
if($dif==0){$dif="-    ";}

$cumAmount=formatMoney($cumAmount);
if($cumAmount==0){$cumAmount="-    ";}

$ceTot=@$ceTot+$amt;
if($amt<0){$amt="(".formatMoney($amt).")";}else{$amt=formatMoney($amt);}

if($amt==0){$amt="-    ";}

if(@$projFundOut[$projNum])
	{$fundOut=$projFundOut[$projNum];}else{$fundOut="";}
if(@$projFundIn[$projNum])
	{$fundIn=$projFundIn[$projNum];}else{$fundIn="";}
if(@$projFundOut[$projNum] || @$projFundIn[$projNum])
	{
$fundInOut=formatMoney($fundIn-$fundOut);}else{$fundInOut="-    ";}

$credit=formatMoney($credit,2);

$y=($y-$fontSize)-$gap-$linewidth;
@$lineCount++;


// ******* Page Break **********
if($y<25){
pdf_end_page($pdf);
pdf_begin_page ($pdf, PAGE_WIDTH, PAGE_HEIGHT);

$arialBold = PDF_load_font ($pdf, "arialnb", "winansi","");
$fontSize=7;
pdf_setfont ($pdf, $arialBold, $fontSize);
$x=30; // left margin
$y=562;// top margin
// Header Stuff

headerStuff1($pdf,$fontSize,$y);

pdf_setfont ($pdf, $arial, $fontSize);
$z=$y-2;pdf_setlinewidth($pdf,$linewidth);
makeLine($pdf,$a,$b,$z);

$leading=$fontSize;  // add a little extra space after header
$y=$z-$leading-$linewidth;

$text=date("n/d/Y g:i A");
pdf_show_xy ($pdf, $text, PAGE_WIDTH-950, PAGE_HEIGHT-600);

$text="Page: ".$k." of ".$pages;pdf_show_xy ($pdf, $text, PAGE_WIDTH-75, PAGE_HEIGHT-600);

$j=0;$k++;
}
// ******* End Page Break **********

$fontSize=7; // > Page 1
pdf_setfont ($pdf, $arial, $fontSize);

//$text=$projNum;pdf_show_xy ($pdf, $text, $col1, $y);
//$text=$YearFundC;pdf_show_xy ($pdf, $text, $col2-4, $y);
//$text=$Center;pdf_show_xy ($pdf, $text, $col3-5, $y);
//$text=$budgCode;pdf_show_xy ($pdf, $text, $col4-2, $y);
//$text=$comp;pdf_show_xy ($pdf, $text, $col5, $y);
//$text=$proj_man;pdf_show_xy ($pdf, $text, $col6, $y);
$text=$YearFundF;pdf_show_xy ($pdf, $text, $col1+3, $y);
$text=strtoupper($fullname);pdf_show_xy ($pdf, $text, $col2-4, $y);
$dc=strtoupper($dist.", ".$county);
$text=$dc;pdf_show_xy ($pdf, $text, $col3, $y);

$text=strtoupper($projName);pdf_show_xy ($pdf, $text, $col4, $y);

//$widthfundInOut = pdf_stringwidth ($pdf, $fundInOut,$arial,$fontSize);// Current Funds
	//	$pos=($col5)-$widthfundInOut;
//$text=$fundInOut;pdf_show_xy ($pdf, $text, $pos, $y);

$widthAmt = pdf_stringwidth ($pdf, $amt,$arial,$fontSize);// Current Expenses
		$pos=($col5)-$widthAmt;
$text=$amt;pdf_show_xy ($pdf, $text, $pos, $y);

$widthCredit = pdf_stringwidth ($pdf, $credit,$arial,$fontSize);// Posted Funds
		$pos=($col6)-$widthCredit;
$text=$credit;pdf_show_xy ($pdf, $text, $pos, $y);

$widthcumAmount = pdf_stringwidth ($pdf, $cumAmount,$arial,$fontSize);// Posted Expenses
		$pos=($col7)-$widthcumAmount;
$text=$cumAmount;pdf_show_xy ($pdf, $text, $pos, $y);

$widthdif = pdf_stringwidth ($pdf, $dif,$arial,$fontSize);// Posted Balance
		$pos=($col8)-$widthdif;
$text=$dif;pdf_show_xy ($pdf, $text, $pos, $y);
//$text=$credit;pdf_show_xy ($pdf, $text, $pos, $y);

if($startDate=="na"||$startDate=="NA"||$startDate==""){}else
{$startDate=substr($startDate,4,2)."/".substr($startDate,6,2)."/".substr($startDate,2,2);
$endDate=substr($endDate,4,2)."/".substr($endDate,6,2)."/".substr($endDate,2,2);}
$text=$startDate;pdf_show_xy ($pdf, $text, $col8+25, $y);
$text=$endDate;pdf_show_xy ($pdf, $text, $col9+25, $y);

$text=$statusDC;pdf_show_xy ($pdf, $text, $col11, $y);

switch ($statusPer) {
		case "NS":
			//$status = "NOT STARTED";
			$status = "NS";
			break;	
		case "IP":
			//$status = "IN PROGRESS";
			$status = "IP";
			break;	
		case "OH":
			//$status = "ON HOLD";
			$status = "OH";
			break;	
		case "FI":
			//$status = "FINISHED";
			$status = "FIN";
			break;
		case "Finish":
			//$status = "FINISHED";
			$status = "FIN";
			break;
		case "In Pro":
			//$status = "IN PROGRESS";
			$status = "IP";
			break;	
		default:
			$status = $statusPer;
			break;	
	}
//$text=$status;pdf_show_xy ($pdf, $text, $col19-3, $y);
@$j++;

$z=$y-$gap;
pdf_setlinewidth($pdf,.3);

$r=fmod($j,2);
if($r!=0){pdf_setcolor ($pdf, 'both', 'rgb', .5, .5, .5, 0);
pdf_setlinewidth($pdf,.2);}

makeLine($pdf,$a,$b,$z);
pdf_setcolor ($pdf, 'both', 'rgb', 0, 0, 0, 0);

} // for loop

		
		// Finish the page.
		pdf_end_page($pdf);
		
		// Close the PDF.
		pdf_close($pdf);
		
		// Send the PDF to the browser.
$fileName="DPR Monthly Report-".$thruDate;
		$buffer = pdf_get_buffer ($pdf);
		header ("Content-type: application/pdf");
		header ("Content-Length: " . strlen($buffer));
		header ("Content-Disposition: inline; filename=" . $fileName . ".pdf");
		echo $buffer;

		// Free the resources
		pdf_delete ($pdf);

exit;
// ************* FUNCTIONS ********

function makeLine($pdf,$a,$b,$z){
pdf_moveto($pdf,$a,$z);
pdf_lineto($pdf,$b,$z);pdf_stroke($pdf);
}


function formatMoney($n){
$n=number_format($n,2);
return $n;
}

/*
function headerStuff1($m) {
global $parkS;
echo "<html><head><title>Hours Worked</title>
<STYLE TYPE=\"text/css\">
<!--
body
{font-family:sans-serif;background:beige}
td
{font-size:90%;background:beige;}
th
{font-size:95%; vertical-align: bottom;color:#660033}
--> 
</STYLE></head>
<body><font size='4' color='004400'>DENR/DPR Monthly Report</font>
<br><font size='5' color='blue'>DENR/DPR Monthly Report
</font><br>
<font color='red'>$m</font><hr><form name='hoursWorked' method='post' action='payrollPDF.php'>";
}
*/
?>