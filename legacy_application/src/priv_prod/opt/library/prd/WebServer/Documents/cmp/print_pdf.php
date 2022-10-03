<?php 
//echo "<pre>"; print_r($_POST); echo "</pre>";  exit;
ini_set('display_errors',1);
session_start();
//echo "<pre>"; print_r($_SESSION); echo "</pre>";  exit;
$database="cmp";
include("../../include/get_parkcodes_i.php");// database connection parameters

$database="cmp";
include("../../include/iConnect.inc");// database connection parameters

$database="cmp";
$db = mysqli_select_db($connection,$database)
   or die ("Couldn't select database $database");

extract($_REQUEST);
// Get data
$sql="SELECT *
FROM  form where park_code='$park_code'"; //echo "$sql"; exit;
$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql".mysqli_error($connection));

$num1=mysqli_num_rows($result);
if($num1>0)
	{
	$row=mysqli_fetch_assoc($result);
	}
$emid=$row['emid'];
if($row['update_date']=="0000-00-00")
	{
//	echo "You need to indicate your approval by submitting this form with a date. Please click your browser's back button, enter a date, and click the \"Submti\" button.";
//	exit;
	}
//echo "<pre>"; print_r($row); echo "</pre>";  exit;

//$emid=310;
// Get sig for production
$sql="SELECT t1.link as sig, t1.personID, t2.tempID
FROM photos.signature as t1
LEFT JOIN divper.empinfo as t2 on t1.personID=t2.tempID
where t2.emid='$emid'"; //echo "$sql"; exit;

// Get sig for testing
if($park_code=="MOJE")
	{
	$park_code="NERI";
	}
if($park_code=="DISW")
	{
// 	$park_code="MEMI";
	}
	
$where="where t3.currPark='$park_code' and t4.toggle='x'";
if($park_code=="WARE")
	{
//	$where="where t3.currPark='$park_code' and t3.beacon_num='60032786'";
	$where="where t3.currPark='ARCH' and t3.beacon_num='60033012'"; // Jerry Howerton override for Chuck being out
	}
if($park_code=="BUOF")
	{
	// Tammy Dodd
	$where="where t3.currPark='ARCH' and t3.beacon_num='60032781'";
	}
if($park_code=="DEDE")
	{
	// Erin Lawrence
	$where="where t3.currPark='ARCH' and t3.beacon_num='60032833'";
	}
if($park_code=="GOCR")
	{
	// John Fullwood override until new PASU appointed
	$where="where t3.currPark='EADI' and t3.beacon_num='60032912'";
	}
if($park_code=="STMO")
	{
	// Scott Robinson override until new PASU appointed
	$where="where t3.currPark='NERI' and t3.beacon_num='60033026'";
	}
if($park_code=="LANO")
	{
	// Jarid Church override until new PASU appointed
	$where="where t3.currPark='LANO' and t3.beacon_num='60032870'";
	}

$sql="SELECT t1.link as sig, t4.working_title as title
FROM photos.signature as t1
LEFT JOIN divper.empinfo as t2 on t1.personID=t2.tempID
LEFT JOIN divper.emplist as t3 on t3.tempID=t2.tempID
LEFT JOIN divper.position as t4 on t4.beacon_num=t3.beacon_num
$where
order by salary_grade
limit 1"; 
// echo "$sql"; exit;
$result_sig = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql ".mysqli_error($connection));
$row_sig=mysqli_fetch_assoc($result_sig);
$sig=$row_sig['sig'];

if(empty($sig))
	{
	echo "We do not have a signature for the supervisor at $park_code. Click your browser's back button."; 
	echo "<br /><br />$sql";
	exit;
	}
//echo "$sql<pre>"; print_r($row_sig); echo "</pre>";  exit;

$num=@count($row);
if($num<1){echo "No record was found using: <b>$park_code</b>";exit;}
include("questions.php");

$cat_array=array("q_1"=>"                    CASH MANAGEMENT OVER RECEIPTS:","q_11"=>"                    CASH MANAGEMENT OVER DISBURSEMENTS:");

define ("PAGE_WIDTH", 612); // 8.5 inches
define ("PAGE_HEIGHT",792); // 11 inches
define ("FONT_SIZE",12); 

// Create the Page.	
$pdf = pdf_new(); include("/opt/library/prd/WebServer/include/pdf_key_23.php");
pdf_open_file ($pdf, "");

// Set the different PDF values.
pdf_set_info ($pdf, "Author", "Tom Howard");
pdf_set_info ($pdf, "Title", "NC Cash Management Plan");
pdf_set_info ($pdf, "Creator", "See Author");
$path="/opt/library/prd/WebServer/Documents/inc/";

$arial = PDF_load_font ($pdf, $path."fonts/Arial", "winansi", "");
$arialBold = PDF_load_font ($pdf, $path."fonts/arial_bold", "winansi", "");
$times = PDF_load_font ($pdf, $path."fonts/Times_New_Roman", "winansi", "");
$timesBold = PDF_load_font ($pdf, $path."fonts/Times_New_Roman_Bold", "winansi", "");
	
// Create the pages.
pdf_begin_page ($pdf, PAGE_WIDTH, PAGE_HEIGHT);

//*********
// Add Header
pdf_setfont ($pdf, $timesBold, 14);
$y=750;
$text="DENR OFFICE OF CONTROLLER";
	pdf_show_xy ($pdf,$text,190,$y);
$y=732;
$text="DENR CASH MANAGEMENT PLAN";
	pdf_show_xy ($pdf,$text,183,$y);
$y=714;
$text="DIVISIONAL CMP SUPPLEMENT";
	pdf_show_xy ($pdf,$text,192,$y);
pdf_setfont ($pdf, $times, 10);
$y=765;
$text="Appendix B";
	pdf_show_xy ($pdf,$text,490,$y);
$parkCodeName['WARE']="Warehouse";	
$parkCodeName['BUOF']="Budget Office";	
$parkCodeName['DEDE']="Design & Development";	
	
$y=680;
$pn=$parkCodeName[$row['park_code']];
$text="DIVISION/OFFICE/LOCATION: Parks & Recreation - ".$pn;
	pdf_show_xy ($pdf,$text,50,$y);

$pbn=$row['prime_beacon_num'];
$ex=explode("*",$pbn);
$pcn=$ex[0]." - ".@$ex[1];
$pct=@$ex[2];
$pce=@$ex[3];

$sbn=$row['sec_beacon_num'];
$sex=explode("*",$sbn);
$scn=$sex[0]." - ".@$sex[1];
$sct=@$sex[2];
$sce=@$sex[3];

if(strpos($pbn,"\n")>-1 OR strpos($pbn,"\r"))
	{
	$pbn=str_replace("\r\n","*",$pbn);
	$pbn=str_replace("\r","*",$pbn);
	$pbn=str_replace("\n","*",$pbn);
	$new_ex=explode("*",$pbn);  
	$pcn=$new_ex[0];
	$pct=$new_ex[1];
	$pce=$new_ex[2];
	}

if(strpos($sbn,"\n")>-1 OR strpos($sbn,"\r"))
	{
	$sbn=str_replace("\r\n","*",$sbn);
	$sbn=str_replace("\r","*",$sbn);
	$sbn=str_replace("\n","*",$sbn);
	$new_sex=explode("*",$sbn);  
	$scn=$new_sex[0];
	$sct=$new_sex[1];
	$sce=$new_sex[2];
	}
$y=660;
$text="PRIMARY CONTACT NAME/TITLE: ".$pcn;
	pdf_show_xy ($pdf,$text,50,$y);

$y=648;
$text="PRIMARY CONTACT TELEPHONE NUMBER: ".$pct;
	pdf_show_xy ($pdf,$text,50,$y);

$y=636;
$text="PRIMARY CONTACT E-MAIL ADDRESS: ".$pce;
	pdf_show_xy ($pdf,$text,50,$y);


$y=620;
$text="SECONDARY CONTACT NAME/TITLE: ".$scn;
	pdf_show_xy ($pdf,$text,50,$y);

$y=608;
$text="SECONDARY CONTACT TELEPHONE NUMBER: ".$sct;
	pdf_show_xy ($pdf,$text,50,$y);

$y=596;
$text="SECONDARY CONTACT E-MAIL ADDRESS: ".$sce;
	pdf_show_xy ($pdf,$text,50,$y);
	
$y=576;
$text="Please submit this Form, along with any additional response to the DENR Controller's Office.";
	pdf_show_xy ($pdf,$text,50,$y);


$width=500;
$just="left";
$feature="blind";
$box_height=510;
$box_top=60;		
pdf_set_value($pdf,'leading',11);

$text="Instructions:   You may enter your responses in Microsoft Word using the area below each item to enter your answer.  Or, you may also provide attachments as necessary to fully answer the items as necessary.  The Primary Contact for this location should sign at the bottom of Page 5 of this form.";
pdf_show_boxed($pdf,$text,50,$box_top,$width,$box_height,$just,"");

$text="CASH MANAGEMENT OVER RECEIPTS:";
	pdf_show_xy ($pdf,$text,200,510);
	
$text="1      Daily Deposit Cutoff Times";
	pdf_show_xy ($pdf,$text,50,485);

$text="Standard daily deposit cutoff times for DENR, as listed in the DENR Cash Management Plan are as follows: 

Time Received                                          Deposit
8:00 AM to 12:00 Noon                             By 2:00 PM, but not later than 5:00 PM
12:00 Noon to 5:00 PM                             By 5:00 PM, but not later than 12 Noon the next day

If your daily deposit cutoff times differ from those accepted as the standard in the DENR Cash Management Plan, indicate your daily deposit cutoff times below for approval by the DENR Controller.";
pdf_show_boxed($pdf,$text,70,$box_top,$width,420,$just,"");
$text=$row['q_1'];
pdf_show_boxed($pdf,$text,70,$box_top,$width,420-100,$just,"");


$text="2      Safeguarding Procedures";
	pdf_show_xy ($pdf,$text,50,330);

$text="Indicate if your location receives checks or cash, and if so, describe your safeguarding procedures for checks and cash unable to be deposited and remaining in your office overnight.";
pdf_show_boxed($pdf,$text,70,$box_top,$width,260,$just,"");
$text=$row['q_2'];
pdf_show_boxed($pdf,$text,70,$box_top,$width,260-40,$just,"");

$texty = pdf_get_value($pdf, "texty", 0);
$text="3      Opening Mail and Preparing a Receipt Log of Cash Items Received";
	pdf_show_xy ($pdf,$text,50,$texty-30);

$text="Indicate if your location receives checks or cash, and if so, describe your safeguarding procedures for checks and cash unable to be deposited and remaining in your office overnight.";
pdf_show_boxed($pdf,$text,70,$box_top,$width,$texty-100,$just,"");
$text=$row['q_3'];
pdf_show_boxed($pdf,$text,70,$box_top,$width,$texty-120,$just,"");
	
pdf_end_page ($pdf);


// Create Page 2.
pdf_begin_page ($pdf, PAGE_WIDTH, PAGE_HEIGHT);

$y=725;
pdf_setfont ($pdf, $times, 10);
$text="4      Reviewing Accuracy of Mail Receipt Log";
	pdf_show_xy ($pdf,$text,50,$y);

$text="A separate employee must be assigned responsibility of reviewing and verifying accuracy of the mail receipt log once cash items are received.  This employee should sign the mail log after verifying its accuracy.  Provide the position number and job title for the primary and back-up position assigned to this responsibility.";
pdf_show_boxed($pdf,$text,70,$box_top,$width,$y-75,$just,"");
$text=$row['q_4'];
pdf_show_boxed($pdf,$text,70,$box_top,$width,$y-125,$just,"");

$y=600;
$text="5      Official Cashier";
	pdf_show_xy ($pdf,$text,50,$y);

$text="Each division and office is required to designate at least one official cashier whose duties shall be to receipt and deposit all funds daily in the form and amount received and preparation of daily cash reports.  Provide the position number and job title of all individuals in your office designated as an official cashier.";
pdf_show_boxed($pdf,$text,70,$box_top,$width,$y-70,$just,"");
$text=$row['q_5'];
pdf_show_boxed($pdf,$text,70,$box_top,$width,$y-110,$just,"");

$y=450;
$text="6      Review and Verification of Deposits and Daily Cash Reports";
	pdf_show_xy ($pdf,$text,50,$y);

$text="An individual should be responsible for independently reviewing the deposit and daily cash reports to determine that all receipts are properly deposited.  Provide the position number and job title for the primary and back-up position assigned to this responsibility.";
pdf_show_boxed($pdf,$text,70,$box_top,$width,$y-70,$just,"");
$text=$row['q_6'];
pdf_show_boxed($pdf,$text,70,$box_top,$width,$y-120,$just,"");

$y=330;
$text="7      Completing NCAS Coding Sheet (Cash Receipts Journal Voucher)";
	pdf_show_xy ($pdf,$text,50,$y);

$text="Employee(s) must be designated to complete the NCAS coding sheet (Cash Receipts Journal Voucher).  This employee must be separate from the employee who receipts the cash items and prepares the mail log.  If more than one employee prepares the coding sheet, the supplement must list the position number and the type of receipt each processes (e.g. fees, refunds, etc.).  Provide the position number and job title for the primary and back-up position assigned to this responsibility.";
pdf_show_boxed($pdf,$text,70,$box_top,$width,$y-75,$just,"");
$text=$row['q_7'];
pdf_show_boxed($pdf,$text,70,$box_top,$width,$y-125,$just,"");


$y=205;
if($park_code=="FALA"){$y=180;}
$text="8      Approval of the NCAS Coding Sheet (Cash Receipts Journal Voucher)";
	pdf_show_xy ($pdf,$text,50,$y);

$text="Employee(s) must be designated to review and approve the NCAS coding sheet (Cash Receipts Journal Voucher).  This employee must be separate from the employee who receipts the cash items and prepares the mail log, or prepares the NCAS coding sheet.  Provide the position number and job title for the primary and back-up position assigned to this responsibility.";
pdf_show_boxed($pdf,$text,70,$box_top,$width,$y-75,$just,"");
$text=$row['q_8'];
pdf_show_boxed($pdf,$text,70,$box_top,$width,$y-115,$just,"");

$text="2";
	pdf_show_xy ($pdf,$text,280,25);
pdf_end_page ($pdf);


// Create Page 3.
pdf_begin_page ($pdf, PAGE_WIDTH, PAGE_HEIGHT);

pdf_setfont ($pdf, $times, 10);

$y=725;
$text="9      Delivery of NCAS Coding Sheet (Cash Receipts Journal Voucher) and Deposit Tickets to DENR Controller's Office";
	pdf_show_xy ($pdf,$text,50,$y);

$text="An employee(s) must be assigned responsibility for coding of NCAS coding sheets and delivery of deposit tickets to Controller's Office.  Provide the position number and job title for the primary and back-up position assigned to this responsibility.";
pdf_show_boxed($pdf,$text,70,$box_top,$width,$y-75,$just,"");
$text=$row['q_9'];
pdf_show_boxed($pdf,$text,70,$box_top,$width,$y-125,$just,"");

$y=600;
$text="10    Designation of Employee Responsibility for Accounts Receivable";
	pdf_show_xy ($pdf,$text,50,$y);

$text="If your location does not have accounts receivable, you may indicate that this item is not applicable.  Otherwise, please provide answers to the questions below. 

An employee(s) must be designated to bill all accounts within 10 days after amount of incurred costs are known.

An employee(s) must be designated to send out dunning notices in accordance with policy.

An employee(s) must be designated to pursue debt collection in accordance with policy.

Indicate if your location has accounts receivable, and if so, provide the position number and job title for the primary and back-up position assigned to this responsibility.";
pdf_show_boxed($pdf,$text,70,$box_top,$width,$y-75,$just,"");
$text=$row['q_10'];
pdf_show_boxed($pdf,$text,70,$box_top,$width,$y-195,$just,"");

$y=425;
$text="CASH MANAGEMENT OVER DISBURSEMENTS:";
	pdf_show_xy ($pdf,$text,200,$y);

$y=400;
$text="11";
	pdf_show_xy ($pdf,$text,50,$y);

$text="Identify position that receives vendor invoices with supporting documentation and proceeds to desk audit the invoices for accuracy and completeness, due date discount rate, if applicable, and other pertinent information.  Provide the position number and job title for the primary and back-up position assigned to this responsibility.";
pdf_show_boxed($pdf,$text,70,$box_top,$width,$y-50,$just,"");
$text=$row['q_11'];
pdf_show_boxed($pdf,$text,70,$box_top,$width,$y-90,$just,"");

$y=310;
$text="12";
	pdf_show_xy ($pdf,$text,50,$y);

$text="Identify the positions that prepare coding or batching of invoicing.  Provide the position number and job title for the primary and back-up position assigned to this responsibility.";
pdf_show_boxed($pdf,$text,70,$box_top,$width,$y-50,$just,"");
$text=$row['q_12'];
pdf_show_boxed($pdf,$text,70,$box_top,$width,$y-90,$just,"");

$y=210;
$text="13";
	pdf_show_xy ($pdf,$text,50,$y);

$text="Identify the positions that enter into NCAS Accounts Payable the coding or the entry of invoices.  Provide the position number and job title for the primary and back-up position assigned to this responsibility.";
pdf_show_boxed($pdf,$text,70,$box_top,$width,$y-50,$just,"");
$text=$row['q_13'];
pdf_show_boxed($pdf,$text,70,$box_top,$width,$y-80,$just,"");

$y=130;
$text="14";
	pdf_show_xy ($pdf,$text,50,$y);

$text="Identify the positions which handle unique disbursement processing, i.e. the reimbursement of state level contracts, travel, and administrative contracts.  Provide the position number and job title for the primary and back-up position assigned to this responsibility.";
pdf_show_boxed($pdf,$text,70,$box_top,$width,$y-50,$just,"");
$text=$row['q_14'];
pdf_show_boxed($pdf,$text,70,$box_top,$width,$y-90,$just,"");

$text="3";
	pdf_show_xy ($pdf,$text,280,25);
pdf_end_page ($pdf);


// Create Page 4.
pdf_begin_page ($pdf, PAGE_WIDTH, PAGE_HEIGHT);
pdf_setfont ($pdf, $times, 10);

$y=725;
$text="15";
	pdf_show_xy ($pdf,$text,50,$y);

$text="Identify position that will review the Control Group Status (CGS) on NCAS daily for balanced batches to ensure invoices vs. keyed information matches.  Provide the position number and job title for the primary and back-up position assigned to this responsibility.";
pdf_show_boxed($pdf,$text,70,$box_top,$width,$y-50,$just,"");
$text=$row['q_15'];
pdf_show_boxed($pdf,$text,70,$box_top,$width,$y-90,$just,"");

$y=635;
$text="16";
	pdf_show_xy ($pdf,$text,50,$y);

$text="Identify position that is responsible for the Imprest Cash Fund.  Provide the position number and job title for the primary and back-up position assigned to this responsibility.";
pdf_show_boxed($pdf,$text,70,$box_top,$width,$y-50,$just,"");
$text=$row['q_16'];
pdf_show_boxed($pdf,$text,70,$box_top,$width,$y-80,$just,"");

$y=505;
$array_18=array("HABE","JORD","KELA");
if(in_array($park_code,$array_18)){$y=550;}
$text="17";
	pdf_show_xy ($pdf,$text,50,$y);

$text="Identify position that has responsibility for auditing the Imprest Cash Fund disbursements/reimbursements.  Provide the position number and job title for the primary and back-up position assigned to this responsibility.";
pdf_show_boxed($pdf,$text,70,$box_top,$width,$y-50,$just,"");
$text=$row['q_17'];
pdf_show_boxed($pdf,$text,70,$box_top,$width,$y-80,$just,"");

$y=415;
$array_18=array("HABE","JORD","KELA");
if(in_array($park_code,$array_18)){$y=460;}
$text="18";
	pdf_show_xy ($pdf,$text,50,$y);

$text="Identify location, amount and employee title and position number for each petty cash fund established.  Provide the position number and job title for the primary and back-up position assigned to this responsibility.";
pdf_show_boxed($pdf,$text,70,$box_top,$width,$y-50,$just,"");
$text=$row['q_18'];
pdf_show_boxed($pdf,$text,70,$box_top,$width,$y-80,$just,"");

$y=310;
if($park_code=="HARI"){$y=330;}
$text="19";
	pdf_show_xy ($pdf,$text,50,$y);

$text="Identify the position number(s) designated as custodians of each inventory stock (i.e., warehouse, pharmacy, dietary, housekeeping, medical supplies, office supplies, forms, etc.).  Provide the position number and job title for the primary and back-up position assigned to this responsibility.";
pdf_show_boxed($pdf,$text,70,$box_top,$width,$y-50,$just,"");
$text=$row['q_19'];
pdf_show_boxed($pdf,$text,70,$box_top,$width,$y-90,$just,"");

$y=200;
$text="20";
	pdf_show_xy ($pdf,$text,50,$y);

$text="Identify the position responsible for ensuring that there are sufficient funds available for a Purchase Order to be written.  Provide the position number and job title for the primary and back-up position assigned to this responsibility.";
pdf_show_boxed($pdf,$text,70,$box_top,$width,$y-50,$just,"");
$text=$row['q_20'];
pdf_show_boxed($pdf,$text,70,$box_top,$width,$y-80,$just,"");

$y=120;
$text="21";
	pdf_show_xy ($pdf,$text,50,$y);

$text="Identify the position that is responsible for the reconciliation of the FAS records to the NCAS records on a monthly basis.  Provide the position number and job title for the primary and back-up position assigned to this responsibility.";
pdf_show_boxed($pdf,$text,70,$box_top,$width,$y-50,$just,"");
$text=$row['q_21'];
pdf_show_boxed($pdf,$text,70,$box_top,$width,$y-80,$just,"");

$text="4";
	pdf_show_xy ($pdf,$text,280,25);
pdf_end_page ($pdf);

// Create Page 4.
pdf_begin_page ($pdf, PAGE_WIDTH, PAGE_HEIGHT);
pdf_setfont ($pdf, $times, 10);

$y=725;
$text="22";
	pdf_show_xy ($pdf,$text,50,$y);

$text="Identify the position that is responsible for the annual inventory of supplies.  Provide the position number and job title for the primary and back-up position assigned to this responsibility.";
pdf_show_boxed($pdf,$text,70,$box_top,$width,$y-50,$just,"");
$text=$row['q_22'];
pdf_show_boxed($pdf,$text,70,$box_top,$width,$y-80,$just,"");


$scale="";
		$formats=array("jpg"=>"jpeg","tif"=>"tiff");
			$load_image="/opt/library/prd/WebServer/Documents/photos/".$sig; 
	//		echo "l=$load_image";
			$img_size=getimagesize($load_image);
			$height=$img_size[1];
			if($height >100 and $height < 200)
				{$scale="scale 0.30";}
			if($height >199 and $height < 300)
				{$scale="scale 0.45";}
			if($height >299 and $height < 400)
				{$scale="scale 0.60";}
			if($height >401)
				{$scale="scale 0.50";}
		//	echo "$scale<pre>"; print_r($img_size); echo "</pre>";  exit;
			$var=explode("/", $sig);
			$ext=array_pop($var); 
			$var=explode(".", $ext);
			$ext=array_pop($var);
	//	echo "$load_image f1=$ext"; //exit;
			$format=$formats[$ext];
			
			
			if(@$emid=="301")  // Greg Schneider
				{$scale="scale 0.15";}
			if($format=="tiff")
				{$scale="scale 0.90";}
			
			$x_1="170";
			$y_1="445";
		$image = PDF_load_image($pdf,$format,$load_image,"");
		PDF_fit_image($pdf,$image,$x_1,$y_1,$scale);
		pdf_close_image($pdf, $image);
$y=645;

$update_date=$row['update_date'];
$auditor_date=$row['auditor_date'];
//$title=$_SESSION['cmp']['title'];
$title=$row_sig['title'];


$text="By my signature below, I attest that I have reviewed the DENR Cash Management Plan, and have noted all exceptions to the DENR Cash Management Plan within this document.





Submitted By / Title:  ______________________________________     ____".$update_date."_____




Reviewed and Approved:  ___________________________________     ____".$auditor_date."_____";


pdf_show_boxed($pdf,$text,70,$box_top,$width,$y-180,$just,"");

$text=$title;
	pdf_show_xy ($pdf,$text,190,430);
$text="Date";
	pdf_show_xy ($pdf,$text,390,430);	
	
$text="DENR Internal Auditor";
	pdf_show_xy ($pdf,$text,190,380);
$text="Date";
	pdf_show_xy ($pdf,$text,390,380);																																									                                        



		
$text="5";
	pdf_show_xy ($pdf,$text,280,25);
	
pdf_end_page ($pdf);
// Close the PDF
pdf_close ($pdf);

//exit;

// Send the PDF to the browser.
$buffer = pdf_get_buffer ($pdf);
header ("Content-type: application/pdf");
header ("Content-Length: " . strlen($buffer));
$header="Content-Disposition: inline; filename=Cash_Management_Plan_".$_POST['park_code'].".pdf";
header ($header);
echo $buffer;

// Free the resources
pdf_delete ($pdf);

?>