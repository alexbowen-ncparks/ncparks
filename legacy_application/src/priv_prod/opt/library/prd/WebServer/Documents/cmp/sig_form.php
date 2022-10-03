<?php
ini_set('display_errors',1);
//echo "<pre>"; print_r($_REQUEST); echo "</pre>"; EXIT;
if(empty($_SESSION)){session_start();}

date_default_timezone_set('America/New_York');

$db="cmp";
include("../../include/iConnect.inc");// database connection parameters
extract($_POST);
		$parkCodeName['BUOF']="Budget Office";
		$parkCodeName['DEDE']="Design and Development";
		$parkCodeName['DIRO']="Director's Office";
		$parkCodeName['LAND']="Land";
		$parkCodeName['NARA']="Natural Resource & Planning";
		$parkCodeName['OPS1']="Chief of Operations";
		$parkCodeName['OPS2']="Facility Maintenance Manager";
		$parkCodeName['PAR3']="Grants Program Manager";
		$parkCodeName['PACR']="Park Chief Ranger";
		$parkCodeName['REMA']="Resource Management";
		$parkCodeName['TRAI']="Trails Program";

include("../../include/get_parkcodes_reg.php");
				
$park_name=$parkCodeName[$park_code];
$db = mysqli_select_db($connection,$database)
       or die ("Couldn't select database $database");

if(!empty($active_date))
	{
	$sql = "UPDATE sig
	set `active_date`='$active_date'
	WHERE  park_code='$park_code' 
	";  //echo "$sql"; exit;
	$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql");
	}

$sql = "SELECT * FROM sig as t1 
	WHERE  park_code='$park_code' 
	";  //echo "$sql"; exit;
	$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql".mysqli_error($connection));
	
	if(mysqli_num_rows($result)>0)
		{
		$row=mysqli_fetch_assoc($result);
		extract($row);
		$beacon_num_1=$row['prime_beacon_num'];
		$exp=explode("[",$beacon_num_1);
		$exp1=explode("]",$exp[1]);
		$beacon_number_1=$exp1[0];  //echo "b=$bn"; exit;
		
		$beacon_num_2=$row['sec_beacon_num'];
		$exp=explode("[",$beacon_num_2);
		$exp1=explode("]",$exp[1]);
		$beacon_number_2=$exp1[0];  //echo "b=$bn"; exit;
		}

$budget_officer="60032781";

// check line 438 for Director or Acting Div. Director
$div_director="60032778";  // Director

//$div_director="60033202"; // Deputy Director

$db = mysqli_select_db($connection,"divper")
       or die ("Couldn't select database $database");

$sql = "SELECT concat(t2.Fname, ' ', t2.Mname, '. ', t2.Lname) as director 
FROM emplist as t1
LEFT JOIN empinfo as t2 on t2.emid=t1.emid
WHERE  t1.beacon_num='$div_director' 
";  //echo "$sql"; exit;
	$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql ");
$row=mysqli_fetch_assoc($result);
		extract($row);	
if(empty($director))
	{echo "<br /><br />The db is unable to find a name associated with the Div. Director."; exit;}
$db = mysqli_select_db($connection,"divper")
       or die ("Couldn't select database $database");

$sql = "SELECT t3.link as sig_link
FROM divper.position as t1
left join divper.emplist as t2 on t1.beacon_num=t2.beacon_num
left join photos.signature as t3 on t2.tempID=t3.personID
WHERE  t1.beacon_num='$beacon_number_1' 
";  //echo "$sql"; exit;
$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql ");
$row=mysqli_fetch_assoc($result);
$approver_1=$row['sig_link'];
if(empty($approver_1))
	{
	echo "The database could NOT find a signature for Primary beacon position number: $beacon_number_1. Ask Denise or Tom to check the Photo ID database for signatures for $park_code."; exit;
	}

if(!empty($beacon_number_2))
	{
	$sql = "SELECT t3.link as sig_link
	FROM divper.position as t1
	left join divper.emplist as t2 on t1.beacon_num=t2.beacon_num
	left join photos.signature as t3 on t2.tempID=t3.personID
	WHERE  t1.beacon_num='$beacon_number_2' 
	";  //echo "$sql"; exit;
	$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql ");
	$row=mysqli_fetch_assoc($result);
	$approver_2=$row['sig_link'];
	if(empty($approver_2))
		{
		echo "The database could NOT find a signature for Secondary beacon position number: $beacon_number_2. Ask Denise or Tom to check the Photo ID database for signatures for $park_code."; exit;
		}
	}

$pdf = PDF_new(); include("/opt/library/prd/WebServer/include/pdf_key_23.php");

/*  open new PDF file; insert a file name to create the PDF on disk */
if (PDF_begin_document($pdf, "", "") == 0)
	{
		die("Error: " . PDF_get_errmsg($pdf));
	}

PDF_set_info($pdf, "Creator", "hello.php");
PDF_set_info($pdf, "Author", "Tom Howard");
PDF_set_info($pdf, "Title", "DPR Sig. Auth. Form");

PDF_begin_page_ext($pdf, 792, 612, "");

pdf_rect($pdf, 20, 15, 750, 585);
pdf_stroke($pdf);

$fontHelveticaBold = PDF_load_font($pdf, "Helvetica-Bold", "winansi", "");
$fontHelvetica = PDF_load_font($pdf, "Helvetica", "winansi", "");

PDF_setfont($pdf, $fontHelvetica, 8.0);
$x1=35;
PDF_set_text_pos($pdf, 25, 18);
PDF_show($pdf, "DENR-OC15");
$x1=35;
PDF_set_text_pos($pdf, 710, 18);
PDF_show($pdf, "Revised 2-24-10");

// horiz. lines
$x1line=20; $y1line=130;
$x2line=770; $y2line=130;
pdf_setlinewidth($pdf, 0.5);
pdf_moveto($pdf, $x1line, $y1line);
pdf_lineto($pdf, $x2line, $y2line);
pdf_stroke($pdf);

$x1line=20; $y1line=230;
$x2line=770; $y2line=230;
pdf_moveto($pdf, $x1line, $y1line);
pdf_lineto($pdf, $x2line, $y2line);
pdf_stroke($pdf);

$x1line=20; $y1line=335;
$x2line=770; $y2line=335;
pdf_moveto($pdf, $x1line, $y1line);
pdf_lineto($pdf, $x2line, $y2line);
pdf_stroke($pdf);


$x1line=600; $y1line=67;   // Date
$x2line=750; $y2line=67;
pdf_moveto($pdf, $x1line, $y1line);
pdf_lineto($pdf, $x2line, $y2line);
pdf_stroke($pdf);

// dashed lines
pdf_save($pdf);        
pdf_setdash($pdf,3,1);      //7,3 units of black, white
pdf_moveto($pdf,35,310);   //move the pointer here    name 1
pdf_lineto($pdf,200,310);      //draw a line
pdf_stroke($pdf);  //show the line

pdf_moveto($pdf,35,255);
pdf_lineto($pdf,200,255);
pdf_stroke($pdf);

pdf_moveto($pdf,35,207);
pdf_lineto($pdf,200,207);
pdf_stroke($pdf);

pdf_moveto($pdf,35,150);
pdf_lineto($pdf,200,150);
pdf_stroke($pdf);

pdf_moveto($pdf,97,447); // Divison
pdf_lineto($pdf,125,447);
pdf_stroke($pdf);

pdf_moveto($pdf,35,375); // Park
pdf_lineto($pdf,200,375);
pdf_stroke($pdf);
pdf_restore($pdf);

// vert. lines
	$x1line=210; $y1line=130;
	$x2line=210; $y2line=600;
for($i=0;$i<19;$i++)
	{
	pdf_setlinewidth($pdf, 0.5);
	pdf_moveto($pdf, $x1line, $y1line);
	pdf_lineto($pdf, $x2line, $y2line);
	pdf_stroke($pdf);
	$x1line+=30;
	$x2line+=30;
	}

// Pattern fill
// hash lines
$user=$_SESSION['cmp']['beacon'];
if($user!=$budget_officer)
	{
		$x1line=390; $y1line=335; // Employee moving
		$x2line=420; $y2line=315;
		pdf_moveto($pdf, 420, 325); // partial line
		pdf_lineto($pdf, 405, 335);
		pdf_stroke($pdf);
	for($i=0;$i<19;$i++)
		{
		pdf_moveto($pdf, $x1line, $y1line);
		pdf_lineto($pdf, $x2line, $y2line);
		pdf_stroke($pdf);
		$y1line-=10;
		$y2line-=10;
		}
		pdf_moveto($pdf, $x1line, $y1line); // partial line
		pdf_lineto($pdf, $x2line-8, $y2line+5);
		pdf_stroke($pdf);
	
		$x1line=420; $y1line=335; // Budget transfer
		$x2line=450; $y2line=315;
		pdf_moveto($pdf, 450, 325); // partial line
		pdf_lineto($pdf, 435, 335);
	for($i=0;$i<19;$i++)
		{
		pdf_moveto($pdf, $x1line, $y1line);
		pdf_lineto($pdf, $x2line, $y2line);
		pdf_stroke($pdf);
		$y1line-=10;
		$y2line-=10;
		}
		pdf_moveto($pdf, $x1line, $y1line); // partial line
		pdf_lineto($pdf, $x2line-8, $y2line+5);
		pdf_stroke($pdf);
	}
if($user!=$div_director)
	{
		$x1line=570; $y1line=335; // Inventory verification
		$x2line=600; $y2line=315;
		pdf_moveto($pdf, 600, 325); // partial line
		pdf_lineto($pdf, 585, 335);
	for($i=0;$i<19;$i++)
		{
		pdf_moveto($pdf, $x1line, $y1line);
		pdf_lineto($pdf, $x2line, $y2line);
		pdf_stroke($pdf);
		$y1line-=10;
		$y2line-=10;
		}
		pdf_moveto($pdf, $x1line, $y1line); // partial line
		pdf_lineto($pdf, $x2line-8, $y2line+5);
		pdf_stroke($pdf);
	
		$x1line=600; $y1line=335; // Missing asset
		$x2line=630; $y2line=315;
		pdf_moveto($pdf, 630, 325); // partial line
		pdf_lineto($pdf, 615, 335);
	for($i=0;$i<19;$i++)
		{
		pdf_moveto($pdf, $x1line, $y1line);
		pdf_lineto($pdf, $x2line, $y2line);
		pdf_stroke($pdf);
		$y1line-=10;
		$y2line-=10;
		}
		pdf_moveto($pdf, 600, $y1line); // partial line
		pdf_lineto($pdf, $x2line-8, $y2line+5);
		pdf_stroke($pdf);
	}

if($user!=$budget_officer)
	{
	$x1line=630; $y1line=335; // Journal voucher
	$x2line=660; $y2line=315;
	pdf_moveto($pdf, 660, 325); // partial line
	pdf_lineto($pdf, 645, 335);
for($i=0;$i<19;$i++)
	{
	pdf_moveto($pdf, $x1line, $y1line);
	pdf_lineto($pdf, $x2line, $y2line);
	pdf_stroke($pdf);
	$y1line-=10;
	$y2line-=10;
	}
	pdf_moveto($pdf, $x1line, $y1line); // partial line
	pdf_lineto($pdf, $x2line-8, $y2line+5);
	pdf_stroke($pdf);

	$x1line=660; $y1line=335; // New account
	$x2line=690; $y2line=315;
	pdf_moveto($pdf, 690, 325); // partial line
	pdf_lineto($pdf, 675, 335);
for($i=0;$i<19;$i++)
	{
	pdf_moveto($pdf, $x1line, $y1line);
	pdf_lineto($pdf, $x2line, $y2line);
	pdf_stroke($pdf);
	$y1line-=10;
	$y2line-=10;
	}
	pdf_moveto($pdf, $x1line, $y1line); // partial line
	pdf_lineto($pdf, $x2line-8, $y2line+5);
	pdf_stroke($pdf);
}

PDF_setfont($pdf, $fontHelveticaBold, 18.0);
$x1=35;
PDF_set_text_pos($pdf, $x1+35, 570);
PDF_show($pdf, "NCDENR");

PDF_setfont($pdf, $fontHelvetica, 12.0);

//PDF_continue_text($pdf, "(says PHP using PDFlib on zLinux!)");
$text="Office of the Controller";
PDF_set_text_pos($pdf, $x1+15, 535);
PDF_show($pdf, $text);

$text="Signature Authorization Form";
PDF_set_text_pos($pdf, $x1, 490);
PDF_show($pdf, $text);

$text="Division of: DPR";
PDF_set_text_pos($pdf, $x1, 450);
PDF_show($pdf, $text);

$text="Park/Section: ".$park_code;
PDF_set_text_pos($pdf, $x1, 400);
PDF_show($pdf, $text);
$text=$park_name;
PDF_set_text_pos($pdf, $x1, 380);
PDF_show($pdf, $text);

$text="Authorized Approver";
PDF_setfont($pdf, $fontHelveticaBold, 14.0);
PDF_set_text_pos($pdf, $x1-10, 340);
PDF_show($pdf, $text);

$scale="";
		$formats=array("jpg"=>"jpeg","tif"=>"tiff");
			$load_image="/opt/library/prd/WebServer/Documents/photos/".$approver_1; 
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
			$var=explode("/", $approver_1);
			$ext=array_pop($var); 
			$var=explode(".", $ext);
			$ext=array_pop($var);
	//	echo "$load_image f1=$ext"; //exit;
			$format=$formats[$ext];
			
			
			if($beacon_number_1=="60032839")  // Greg Schneider
				{$scale="scale 0.10";}
			if($format=="tiff")
				{$scale="scale 0.90";}
			
			$x_1="50";
			$y_1="252";
		$image = PDF_load_image($pdf,$format,$load_image,"");
		PDF_fit_image($pdf,$image,$x_1,$y_1,$scale);
		pdf_close_image($pdf, $image);

$x2=$x1+30;
$text="Print name of Approver";
PDF_setfont($pdf, $fontHelvetica, 10.0);
PDF_set_text_pos($pdf, $x2, 300);
PDF_show($pdf, $text);
$text=$prime_beacon_num;
PDF_setfont($pdf, $fontHelvetica, 8.0);
PDF_set_text_pos($pdf, $x2-30, 312);
PDF_show($pdf, $text);

//ini_set('display_errors',1);
			$load_image="/opt/library/prd/WebServer/Documents/photos/".$approver_2;
			$height=$img_size[1];
			if($height >100 and $height < 200)
				{$scale="scale 0.30";}
			if($height >199 and $height < 300)
				{$scale="scale 0.45";}
			if($height >299 and $height < 400)
				{$scale="scale 0.60";}
		//	echo "$scale<pre>"; print_r($img_size); echo "</pre>";  exit;
			$var=explode("/", $approver_2);
			$ext=array_pop($var); 
			$var=explode(".", $ext);
			$ext=array_pop($var);
	//	echo "<br />$load_image f2=$ext"; exit;
			$format=$formats[$ext];
			$scale="scale 0.60";
			if($format=="tiff")
				{$scale="scale 0.90";}
	//		if($beacon_number_2=="60032779")  // Don Reuter
	//			{$scale="scale 0.10";}
			
			$x_1="50";
			$y_1="150";
		$image = PDF_load_image($pdf,$format,$load_image,"");
		PDF_fit_image($pdf,$image,$x_1,$y_1,$scale);
		pdf_close_image($pdf, $image);
		
PDF_setfont($pdf, $fontHelvetica, 10.0);

$text="Signature of Approver";
PDF_set_text_pos($pdf, $x2, 240);
PDF_show($pdf, $text);

$text="Print name of Approver";
PDF_set_text_pos($pdf, $x2, 195);
PDF_show($pdf, $text);
$text=$sec_beacon_num;
PDF_setfont($pdf, $fontHelvetica, 8.0);
PDF_set_text_pos($pdf, $x2-30, 210);
PDF_show($pdf, $text);

PDF_setfont($pdf, $fontHelvetica, 10.0);
$text="Signature of Approver";
PDF_set_text_pos($pdf, $x2, 140);
PDF_show($pdf, $text);

//$load_image="/opt/library/prd/WebServer/Documents/photos/signature/Tingley9265.jpg";
$load_image="/opt/library/prd/WebServer/Documents/photos/signature/Murphy6857.jpg";
$scale="scale 0.80";
$format="jpeg";
			$x_1="250";
			$y_1="42";
		$image = PDF_load_image($pdf,$format,$load_image,"");
		PDF_fit_image($pdf,$image,$x_1,$y_1,$scale);
		pdf_close_image($pdf, $image);
		
$text="Division Director:";
//$text="Acting Division Director:";
PDF_setfont($pdf, $fontHelveticaBold, 12.0);
//PDF_set_text_pos($pdf, $x2+50, 70);
PDF_set_text_pos($pdf, $x2+13, 70);
PDF_show($pdf, $text);
$text=$director;
//$text="Carol A. Tingley";
PDF_set_text_pos($pdf, $x2+170, 45);
pdf_show($pdf, $text);

$x1line=220; $y1line=67;   // Director
$x2line=450; $y2line=67;
pdf_moveto($pdf, $x1line, $y1line);
pdf_lineto($pdf, $x2line, $y2line);
pdf_stroke($pdf);
		
$text="Date:";
PDF_setfont($pdf, $fontHelveticaBold, 12.0);
PDF_set_text_pos($pdf, $x2+500, 70);
PDF_show($pdf, $text);
//$text=date("Y-m-d");
$text=$active_date;
PDF_set_text_pos($pdf, $x2+560, 70);
PDF_show($pdf, $text);

// Rotated text
PDF_setfont($pdf, $fontHelvetica, 10.0);
pdf_rotate($pdf, 90); /* rotate coordinates */;

$y1=-225;
$x2=340;
$text="Cash Disbursement Code Sheet (including phone,";
PDF_set_text_pos($pdf, $x2, $y1);
pdf_show($pdf, $text);
$y1 -=10;
$text="computer and motor fleet management)";
PDF_set_text_pos($pdf, $x2, $y1);
pdf_show($pdf, $text);
$text=$s1_1;
PDF_set_text_pos($pdf, $x2-40, $y1+5);
pdf_show($pdf, $text);
$text=$s2_1;
PDF_set_text_pos($pdf, $x2-150, $y1+5);
pdf_show($pdf, $text);

$y1-=25;
$text="Purchasing Card Reconciliations";
PDF_set_text_pos($pdf, $x2, $y1);
pdf_show($pdf, $text);
$text=$s1_2;
PDF_set_text_pos($pdf, $x2-40, $y1+5);
pdf_show($pdf, $text);
$text=$s2_2;
PDF_set_text_pos($pdf, $x2-150, $y1+5);
pdf_show($pdf, $text);

$y1-=25;
$text="Expense Accounts/Travel Reimbursement Forms";
PDF_set_text_pos($pdf, $x2, $y1);
pdf_show($pdf, $text);
$text=$s1_3;
PDF_set_text_pos($pdf, $x2-40, $y1+5);
pdf_show($pdf, $text);
$text=$s2_3;
PDF_set_text_pos($pdf, $x2-150, $y1+5);
pdf_show($pdf, $text);

$y1-=30;
$text="Private Vehicle Uses (OC 12)/Travel (Motor Fleet) Logs";
PDF_set_text_pos($pdf, $x2, $y1);
pdf_show($pdf, $text);
$text=$s1_4;
PDF_set_text_pos($pdf, $x2-40, $y1+5);
pdf_show($pdf, $text);
$text=$s2_4;
PDF_set_text_pos($pdf, $x2-150, $y1+5);
pdf_show($pdf, $text);

$y1-=35;
$text="Travel Advance Requests";
PDF_set_text_pos($pdf, $x2, $y1);
pdf_show($pdf, $text);
$text=$s1_5;
PDF_set_text_pos($pdf, $x2-40, $y1+5);
pdf_show($pdf, $text);
$text=$s2_5;
PDF_set_text_pos($pdf, $x2-150, $y1+5);
pdf_show($pdf, $text);

$y1-=30;
$text="Travel Authorization";
PDF_set_text_pos($pdf, $x2, $y1);
pdf_show($pdf, $text);
$text=$s1_6;
PDF_set_text_pos($pdf, $x2-40, $y1+5);
pdf_show($pdf, $text);
$text=$s2_6;
PDF_set_text_pos($pdf, $x2-150, $y1+5);
pdf_show($pdf, $text);

$y1-=30;
$text="Employee Moving Request (DPR Budget Officer Only)";
PDF_set_text_pos($pdf, $x2, $y1);
pdf_show($pdf, $text);
$text=$s1_7;
PDF_set_text_pos($pdf, $x2-40, $y1+5);
pdf_show($pdf, $text);
$text=$s2_7;
PDF_set_text_pos($pdf, $x2-150, $y1+5);
pdf_show($pdf, $text);

$y1-=30;
$text="Budget Transfers (DPR Budget Officer Only)";
PDF_set_text_pos($pdf, $x2, $y1);
pdf_show($pdf, $text);
$text=$s1_8;
PDF_set_text_pos($pdf, $x2-40, $y1+5);
pdf_show($pdf, $text);
$text=$s2_8;
PDF_set_text_pos($pdf, $x2-150, $y1+5);
pdf_show($pdf, $text);

$y1-=30;
$text="Capital Improvement Payments";
PDF_set_text_pos($pdf, $x2, $y1);
pdf_show($pdf, $text);
$text=$s1_9;
PDF_set_text_pos($pdf, $x2-40, $y1+5);
pdf_show($pdf, $text);
$text=$s2_9;
PDF_set_text_pos($pdf, $x2-150, $y1+5);
pdf_show($pdf, $text);

$y1-=30;
$text="Cash Receipts Journal Voucher/Deposit Form";
PDF_set_text_pos($pdf, $x2, $y1);
pdf_show($pdf, $text);
$text=$s1_10;
PDF_set_text_pos($pdf, $x2-40, $y1+5);
pdf_show($pdf, $text);
$text=$s2_10;
PDF_set_text_pos($pdf, $x2-150, $y1+5);
pdf_show($pdf, $text);

$y1-=25;
$text="Fixed Asses Forms (Fixed Asset Input, Asset Retirement,";
PDF_set_text_pos($pdf, $x2, $y1);
pdf_show($pdf, $text);
$y1-=10;
$text="Change of Location, etc.)";
PDF_set_text_pos($pdf, $x2, $y1);
pdf_show($pdf, $text);
$text=$s1_11;
PDF_set_text_pos($pdf, $x2-40, $y1+5);
pdf_show($pdf, $text);
$text=$s2_11;
PDF_set_text_pos($pdf, $x2-150, $y1+5);
pdf_show($pdf, $text);

$y1-=25;
$text="Surplus Property Disposal Form";
PDF_set_text_pos($pdf, $x2, $y1);
pdf_show($pdf, $text);
$text=$s1_12;
PDF_set_text_pos($pdf, $x2-40, $y1+5);
pdf_show($pdf, $text);
$text=$s2_12;
PDF_set_text_pos($pdf, $x2-150, $y1+5);
pdf_show($pdf, $text);

$y1-=25;
$text="Inventory Verification-OC30 (Physical Inventory Form)";
PDF_set_text_pos($pdf, $x2, $y1);
pdf_show($pdf, $text);
$y1-=10;
$text="DIVISION DIRECTOR ONLY";
PDF_set_text_pos($pdf, $x2, $y1);
pdf_show($pdf, $text);
$text=$s1_13;
PDF_set_text_pos($pdf, $x2-40, $y1+5);
pdf_show($pdf, $text);
$text=$s2_13;
PDF_set_text_pos($pdf, $x2-150, $y1+5);
pdf_show($pdf, $text);

$y1-=20;
$text="Missing Assest";
PDF_set_text_pos($pdf, $x2, $y1);
pdf_show($pdf, $text);
$y1-=10;
$text="DIVISION DIRECTOR ONLY";
PDF_set_text_pos($pdf, $x2, $y1);
pdf_show($pdf, $text);
$text=$s1_14;
PDF_set_text_pos($pdf, $x2-40, $y1+5);
pdf_show($pdf, $text);
$text=$s2_14;
PDF_set_text_pos($pdf, $x2-150, $y1+5);
pdf_show($pdf, $text);

$y1-=25;
$text="Journal Voucher (DPR Budget Officer Only)";
PDF_set_text_pos($pdf, $x2, $y1);
pdf_show($pdf, $text);
$text=$s1_15;
PDF_set_text_pos($pdf, $x2-40, $y1+5);
pdf_show($pdf, $text);
$text=$s2_15;
PDF_set_text_pos($pdf, $x2-150, $y1+5);
pdf_show($pdf, $text);

$y1-=25;
$text="New Acct. Center Combination/Validation form";
PDF_set_text_pos($pdf, $x2, $y1);
pdf_show($pdf, $text);
$y1-=10;
$text="(DPR Budget Officer Only)";
PDF_set_text_pos($pdf, $x2, $y1);
pdf_show($pdf, $text);
$text=$s1_16;
PDF_set_text_pos($pdf, $x2-40, $y1+5);
pdf_show($pdf, $text);
$text=$s2_16;
PDF_set_text_pos($pdf, $x2-150, $y1+5);
pdf_show($pdf, $text);

$y1-=25;
$text="Overtime Pay, Holiday Pay, etc.";
PDF_set_text_pos($pdf, $x2, $y1);
pdf_show($pdf, $text);
$text=$s1_17;
PDF_set_text_pos($pdf, $x2-40, $y1+5);
pdf_show($pdf, $text);
$text=$s2_17;
PDF_set_text_pos($pdf, $x2-150, $y1+5);
pdf_show($pdf, $text);

$y1-=30;
$text="Temporary Payroll";
PDF_set_text_pos($pdf, $x2, $y1);
pdf_show($pdf, $text);
$text=$s1_18;
PDF_set_text_pos($pdf, $x2-40, $y1+5);
pdf_show($pdf, $text);
$text=$s2_18;
PDF_set_text_pos($pdf, $x2-150, $y1+5);
pdf_show($pdf, $text);

pdf_rotate($pdf, -90); /* de-rotate coordinates */;

PDF_end_page_ext($pdf, "");

PDF_end_document($pdf, "");

//exit; 

$buf = PDF_get_buffer($pdf);
$len = strlen($buf);

header("Content-type: application/pdf");
header("Content-Length: $len");
header("Content-Disposition: inline; filename=sig_auth_form.pdf");
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
?>