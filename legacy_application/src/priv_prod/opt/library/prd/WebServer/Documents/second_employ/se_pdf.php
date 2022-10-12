<?php
//echo "<pre>"; print_r($_REQUEST); echo "</pre>"; exit;
ini_set('display_errors',1);
date_default_timezone_set('America/New_York');

include("../../include/get_parkcodes_i.php");// database connection parameters

$database="second_employ";

include("../../include/iConnect.inc");// database connection parameters
$parkCodeName['ARCH']="Archdale Administrative Center";
$parkCodeName['YORK']="Yorkshire Administrative Center";
$parkCodeName['EADI']="East District Office";
$parkCodeName['NODI']="North District Office";
$parkCodeName['SODI']="South District Office";
$parkCodeName['WEDI']="West District Office";
$parkCodeName['WARE']="Warehouse";
$database="second_employ";
$db = mysqli_select_db($connection,$database)
   or die ("Couldn't select database");
   
extract($_REQUEST);

$sql="SELECT *
	from se_list
	where `id`='$id'"; //echo "$sql"; //exit;
	$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql".mysqli_error($connection));
	$row=mysqli_fetch_assoc($result);
		extract($row);

if(empty($park_code)){echo "A 4-character park code is required."; exit;}		

// Set the constants and variables.
define ("PAGE_WIDTH", 612); // 8.5 inches
define ("PAGE_HEIGHT",792); // 11 inches

$pdf = PDF_new(); include("/opt/library/prd/WebServer/include/pdf_key_23.php");

/*  open new PDF file; insert a file name to create the PDF on disk */
if (PDF_begin_document($pdf, "", "") == 0)
	{
		die("Error: " . PDF_get_errmsg($pdf));
	}

// Set the different PDF values.
pdf_set_info ($pdf, "Author", "Tom Howard");
pdf_set_info ($pdf, "Title", "NC DPR Secondary Employment Request");
pdf_set_info ($pdf, "Creator", "See Author");


// ******************** Start Loop ***************
$start=0;
$pageNum=1;
$index=0;


	// Set the default font from here on out.
$PATH="/opt/library/prd/WebServer/Documents/inc/fonts/";
$arial = PDF_load_font($pdf, $PATH."Arial", "winansi", "");
$arial_bold = PDF_load_font($pdf, $PATH."arial_bold", "winansi", "");
$arial_italic = PDF_load_font($pdf, $PATH."Arial_Italic", "winansi", "");


$fontSize=10;
$leading=$fontSize+3;


// Create the page.
PDF_begin_page_ext($pdf, PAGE_WIDTH, PAGE_HEIGHT, "");


pdf_setfont ($pdf, $arial, $fontSize);
		
$verStart=PAGE_HEIGHT-60;
$ver=$verStart;
$hor=16;
$add_hor=16;
$page_break=PAGE_HEIGHT-5;
$rr=0;

//pdf_setcolor($pdf, "both", "rgb", 0.8, 0.8, 0.8, 0.8);
//pdf_rect($pdf, $hor, $ver+23, 750, 18);
//pdf_fill_stroke($pdf);
pdf_setcolor($pdf, "both", "rgb", 0, 0, 0, 0);

// $logo="DENR_logo.jpg";
// $img=pdf_load_image($pdf, "jpeg", $logo, "");
// pdf_fit_image($pdf, $img, 60, 743, "scale 0.6");


pdf_setfont ($pdf, $arial_bold, 12);
$text="Department of Natural and Cultural Resources";
pdf_show_xy($pdf,$text,150, 750);

pdf_setfont ($pdf, $arial_bold, 13);
$text="REQUEST FOR APPROVAL OF SUPPLEMENTARY EMPLOYMENT";
pdf_show_xy($pdf,$text,90, 730);  
pdf_setfont ($pdf, $arial_bold, 11);
$text="(Secondary)";
pdf_show_xy($pdf,$text,260, 715);  

pdf_setfont ($pdf, $arial_bold, 10);
$text="Policy";
pdf_show_xy($pdf,$text,30, 700);  

pdf_setfont ($pdf, $arial, 10);
$text="The employment responsibilities to the State are primary for any employee working full-time; any other employment in which that person chooses to engage is secondary.  An employee shall have approval from the agency head before engaging in any secondary employment.  The purpose of this approval procedure is to determine that the secondary employment does not have an adverse effect on the primary employment and does not create a conflict of interest.  These provisions for secondary employment apply to all employment not covered by the policy on Dual Employment.

Secondary employment shall not be permitted when it would:

     *	create either directly or indirectly a conflict of interest with the primary employment, or
     *	impair in any way the employee's ability to perform all expected duties, to make decisions and carry out in an 
     	 objective fashion the responsibilities of the employee's position.

Approval for secondary employment may be withdrawn at any time if it is determined that secondary employment has an adverse impact on primary employment.";

//$text="test";
$left=30;
$top=400;
$width=535;
$height=295;
pdf_show_boxed($pdf,$text,$left,$top,$width,$height,"left",""); 

pdf_setlinewidth($pdf, 0.5);
pdf_setfont ($pdf, $arial_bold, 10);
$text="Employee Information";
pdf_show_xy($pdf,$text,30, 535);

$text="Name:  ".$name;
pdf_setfont ($pdf, $arial, 10);
pdf_show_xy($pdf,$text,30, 520);
pdf_moveto($pdf, 65, 519);
pdf_lineto($pdf, 280, 519);
pdf_stroke($pdf);

$text="Division:  Parks and Recreation";
pdf_show_xy($pdf,$text,300, 520);
pdf_moveto($pdf, 343, 519);
pdf_lineto($pdf, 440, 519);
pdf_stroke($pdf);  

if($park_code=="NRRP")
	{
	$parkCodeName['NRRP']="Natural Resource Program";
	}
if(empty($parkCodeName[$park_code]))
	{
	$parkCodeName[$park_code]="not listed. Contact Tom Howard.";
	}
$text="Duty Station:  ".$park_code." - ".$parkCodeName[$park_code];
pdf_show_xy($pdf,$text,300, 505);
pdf_moveto($pdf, 360, 504);
pdf_lineto($pdf, 550, 504);
pdf_stroke($pdf);    

$text="Position Classification:  ".$position;
pdf_show_xy($pdf,$text,30, 505);
pdf_moveto($pdf, 136, 504);
pdf_lineto($pdf, 280, 504);
pdf_stroke($pdf);      

$text="Home Address: ".$address;
pdf_show_xy($pdf,$text,30, 490);
pdf_moveto($pdf, 100, 489);
pdf_lineto($pdf, 400, 489);
pdf_stroke($pdf);       
$text=$city;
pdf_show_xy($pdf,$text,240, 490);  
$text=$state;
pdf_show_xy($pdf,$text,363, 490);  
$text=$zip;
pdf_show_xy($pdf,$text,395, 490);
pdf_moveto($pdf, 343, 489);
pdf_lineto($pdf, 450, 489);
pdf_stroke($pdf);     

pdf_setfont ($pdf, $arial, 7);
$text="Street                                                  City                                                      State        Zip";
pdf_show_xy($pdf,$text,130, 480);


pdf_setfont ($pdf, $arial_bold, 10);
$text="Supplementary Employer:";
pdf_show_xy($pdf,$text,30, 468);  

pdf_setfont ($pdf, $arial, 10);
$text="Name: ".$employer;
pdf_show_xy($pdf,$text,30, 455); 
pdf_moveto($pdf, 62, 454);
pdf_lineto($pdf, 550, 454);
pdf_stroke($pdf);               
		
$text="Address: ".$employer_address."  ".$employer_city."  ".$employer_state." ".$employer_zip;
pdf_show_xy($pdf,$text,30, 440);
pdf_moveto($pdf, 72, 439);
pdf_lineto($pdf, 550, 439);
pdf_stroke($pdf);              

$text="Nature of employer's business or profession: ".$business;
pdf_show_xy($pdf,$text,30, 425);
pdf_moveto($pdf, 230, 424);
pdf_lineto($pdf, 550, 424);
pdf_stroke($pdf);            



$text="Description of duties to be performed: ".$duties;
$left=30;
$top=392;
$width=535;
$height=30;
pdf_show_boxed($pdf,$text,$left,$top,$width,$height,"left",""); 

pdf_moveto($pdf, 200, 411);
pdf_lineto($pdf, 550, 411);
pdf_stroke($pdf);          

pdf_moveto($pdf, 30, 401);
pdf_lineto($pdf, 550, 401);
pdf_stroke($pdf);          

pdf_moveto($pdf, 30, 391);
pdf_lineto($pdf, 550, 391);
pdf_stroke($pdf);          


$text="Days and hours of employment: ".$work_day;
$left=30;
$top=356;
$width=535;
$height=30;
pdf_show_boxed($pdf,$text,$left,$top,$width,$height,"left",""); 

pdf_moveto($pdf, 173, 375);
pdf_lineto($pdf, 550, 375);
pdf_stroke($pdf);          
pdf_moveto($pdf, 30, 365);
pdf_lineto($pdf, 550, 365);
pdf_stroke($pdf);        

pdf_setfont ($pdf, $arial, 10);
$text="Anticipated dates of employment: ".$dates;
pdf_show_xy($pdf,$text,30, 350); 
pdf_moveto($pdf, 180, 349);
pdf_lineto($pdf, 550, 349);
pdf_stroke($pdf);      

pdf_setfont ($pdf, $arial_bold, 10);
$text="Employee Certification:";
pdf_show_xy($pdf,$text,30, 335);  

$text="I understand:
*   The policy governing secondary employment. My secondary employment will not have any impact on and will not\n     create any possibility of conflict with my primary employment.
*   That failure to provide accurate information regarding my secondary employment approval request or to follow all\n     policies regarding secondary employment may be considered unacceptable personal conduct which could subject \n     me to discipline up to and including dismissal.
*   That secondary employment information is public and may be disclosed to third parties.";

pdf_setfont ($pdf, $arial, 10);
$left=30;
$top=80;
$width=535;
$height=250;
pdf_show_boxed($pdf,$text,$left,$top,$width,$height,"left",""); 

pdf_moveto($pdf, 30, 235);
pdf_lineto($pdf, 550, 235);
pdf_stroke($pdf);

pdf_setfont ($pdf, $arial_bold, 10);
$text="Employee Signature";
pdf_show_xy($pdf,$text,30, 224);  
$text="Date";
pdf_show_xy($pdf,$text,330, 224);  

pdf_setfont ($pdf, $arial, 9);
$text="Recommend Approval:     Yes           No";
pdf_show_xy($pdf,$text,30, 198); 
pdf_moveto($pdf, 300, 198);
pdf_lineto($pdf, 500, 198);
pdf_stroke($pdf);
$text="Immediate Supervisor                      Date";
pdf_show_xy($pdf,$text,300, 190); 
pdf_rect($pdf, 152, 198, 10, 10);
pdf_stroke($pdf);  
pdf_rect($pdf, 191, 198, 10, 10);
pdf_stroke($pdf);      

$text="Approved:                         Yes           No";
pdf_show_xy($pdf,$text,30, 164); 
pdf_moveto($pdf, 300, 164);
pdf_lineto($pdf, 500, 164);
pdf_stroke($pdf);
$text="Division Director                               Date";
pdf_show_xy($pdf,$text,300, 155); 
pdf_rect($pdf, 152, 163, 10, 10);
pdf_stroke($pdf);  
pdf_rect($pdf, 191, 163, 10, 10);
pdf_stroke($pdf);      

$text="Approved:                         Yes           No";
pdf_show_xy($pdf,$text,30, 129); 
pdf_moveto($pdf, 300, 129);
pdf_lineto($pdf, 500, 129);
pdf_stroke($pdf);
$text="HR Director or Asst. HR Director     Date";
pdf_show_xy($pdf,$text,300, 120);
pdf_setfont ($pdf, $arial_italic, 8); 
$text="  (when required)";
pdf_show_xy($pdf,$text,300, 110);  
pdf_rect($pdf, 152, 128, 10, 10);
pdf_stroke($pdf);  
pdf_rect($pdf, 191, 128, 10, 10);
pdf_stroke($pdf);    

pdf_setfont ($pdf, $arial, 9); 
$text="Approved:                         Yes           No";
pdf_show_xy($pdf,$text,30, 90); 
pdf_moveto($pdf, 300, 87);
pdf_lineto($pdf, 500, 87);
pdf_stroke($pdf);

$text="Secretary                                         Date";
pdf_show_xy($pdf,$text,300, 79);
pdf_setfont ($pdf, $arial_italic, 8); 
$text="  (when required)";
pdf_show_xy($pdf,$text,340, 79);   
pdf_rect($pdf, 152, 88, 10, 10);
pdf_stroke($pdf);  
pdf_rect($pdf, 191, 88, 10, 10);
pdf_stroke($pdf);

pdf_setfont ($pdf, $arial, 9); 
$text="Approved:                         Yes           No";
pdf_show_xy($pdf,$text,30, 56); 
pdf_moveto($pdf, 300, 56);
pdf_lineto($pdf, 500, 56);
pdf_stroke($pdf);
$text="State Personnel Director                  Date";
pdf_show_xy($pdf,$text,300, 48);
pdf_setfont ($pdf, $arial_italic, 8); 
$text="  (when required)";
pdf_show_xy($pdf,$text,300, 38);   
pdf_rect($pdf, 152, 55, 10, 10);
pdf_stroke($pdf);  
pdf_rect($pdf, 191, 55, 10, 10);
pdf_stroke($pdf);


pdf_setfont ($pdf, $arial_bold, 7); 
$text="Distribution: ";
pdf_show_xy($pdf,$text,30, 40);
pdf_setfont ($pdf, $arial, 7); 
$text="Original - Employee Personnel File";
pdf_show_xy($pdf,$text,75, 40);
$text="Copy - Supervisor for Employee & DENR HR";
pdf_show_xy($pdf,$text,75, 32);


// Last Footer
pdf_setfont ($pdf, $arial, 8);
$date=date('Y-m-d');
$text="Generated on $date";
pdf_show_xy($pdf,$text,20,15);

pdf_setfont ($pdf, $arial, 10);
$text="$se_dpr";
pdf_show_xy($pdf,$text,525,15);
pdf_setfont ($pdf, $arial, $fontSize);
		
// Finish the page
PDF_end_page_ext($pdf, "");

PDF_end_document($pdf, "");

//exit;

$buf = PDF_get_buffer($pdf);
$len = strlen($buf);

//$ran=rand(1000,9999);
$file_name="DPR_Sec_Employment.pdf";
header("Content-type: application/pdf");
header("Content-Length: $len");
header("Content-Disposition: inline; filename=$file_name");
print $buf;

PDF_delete($pdf);


//header("Location: edit.php?edit=$id&submit=edit&message=1");

/*This function is the replacement for the deprecated PDF_find_font()

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