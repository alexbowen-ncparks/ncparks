<?php
ini_set('display_errors',1);
extract($_REQUEST);
if(empty($id)){echo "No ID was given."; exit;}
$database="hr";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database 


$sql="SELECT t1.*, t2.park_name
	from hr.temp_solutions as t1
	left join dpr_system.parkcode_names as t2 on t1.division=t2.park_code 
	where t1.id = '$id'
	";
//	echo "$sql"; exit;
$result = mysqli_query($connection,$sql) or die ("Couldn't execute query 1. $sql ".mysqli_error($connection));
$row=mysqli_fetch_assoc($result);
extract($row);
//echo "<pre>"; print_r($row); echo "</pre>";  exit;

$pdf = PDF_new(); include("/opt/library/prd/WebServer/include/pdf_key_23.php");

// open new PDF file; insert a file name to create the PDF on disk

if (PDF_begin_document($pdf, "", "") == 0) {
    die("Error: " . PDF_get_errmsg($pdf));
}

PDF_set_info($pdf, "Creator", "Temp_Solutions.php");
PDF_set_info($pdf, "Author", "Tom Howard");
PDF_set_info($pdf, "Title", "Temp Solutions");

PDF_begin_page_ext($pdf, 595, 842, "");

$font = PDF_load_font($pdf, "Helvetica-Bold", "winansi", "");
PDF_setfont($pdf, $font, 12.0);

// used to convert a PDF to jpeg
/*
$img = new Imagick("MVR-180A_1.pdf"); 
	$img->setImageFormat("jpg");
//	$img->scaleImage(700, 0); 
$new_file="base.jpg";
$file_loc="/opt/library/prd/WebServer/Documents/fuel/".$new_file;
	$img->writeImage($file_loc);
	//echo "$img"; exit;   // for testing
	$img->clear();
	$img->destroy();
*/

$img=PDF_load_image($pdf, "jpeg", "/opt/library/prd/WebServer/Documents/hr/New_TS_Job_Order_Form_2.jpg", "");
PDF_fit_image ( $pdf , $img , 1 , 30 , "scale 1" );

date_default_timezone_set('America/New_York');
//PDF_set_text_pos($pdf, 490, 744); // Date
//PDF_show($pdf, date("Y-m-d"));

$x=100;
$y=662;
$text=$date_job_order;
PDF_set_text_pos($pdf, $x, $y); // date_job_order
PDF_show($pdf, $text);
$y-=20;
$text="DENR/Div. of Parks & Rec./".$park_name;
PDF_set_text_pos($pdf, $x-20, $y);
PDF_show($pdf, $text);
$y-=18;
$text=$billing_contact;
PDF_set_text_pos($pdf, $x+20, $y);
PDF_show($pdf, $text);
$text=$billing_phone;
PDF_set_text_pos($pdf, $x+320, $y);
PDF_show($pdf, $text);

$y-=18;
$text=$billing_email;
PDF_set_text_pos($pdf, $x, $y);
PDF_show($pdf, $text);
$text=$billing_fax;
PDF_set_text_pos($pdf, $x+320, $y);
PDF_show($pdf, $text);

$y-=18.5;
$text=$hr_contact;
PDF_set_text_pos($pdf, $x, $y);
PDF_show($pdf, $text);
$text=$hr_phone;
PDF_set_text_pos($pdf, $x+320, $y);
PDF_show($pdf, $text);

$y-=18.5;
$text=$hr_email;
PDF_set_text_pos($pdf, $x, $y);
PDF_show($pdf, $text);
$text=$hr_fax;
PDF_set_text_pos($pdf, $x+320, $y);
PDF_show($pdf, $text);

$y-=18.5;
$text=$supervisor;
PDF_set_text_pos($pdf, $x, $y);
PDF_show($pdf, $text);
$text=$supervisor_phone;
PDF_set_text_pos($pdf, $x+320, $y);
PDF_show($pdf, $text);

$y-=18.5;
$text=$supervisor_email;
PDF_set_text_pos($pdf, $x, $y);
PDF_show($pdf, $text);
$text=$supervisor_fax;
PDF_set_text_pos($pdf, $x+320, $y);
PDF_show($pdf, $text);

$y-=20;
$text=$address;
PDF_set_text_pos($pdf, $x, $y);
PDF_show($pdf, $text);
$y-=20;
$text=$email_account;
if($text=="Y"){$x=223;}else{$x=280;}
PDF_set_text_pos($pdf, $x, $y);
PDF_show($pdf, "X");
$y-=23;
$x=80;
$text=$start_date;
PDF_set_text_pos($pdf, $x, $y);
PDF_show($pdf, $text);
$text=$end_date;
PDF_set_text_pos($pdf, $x+170, $y);
PDF_show($pdf, $text);
$text=$work_hours;
PDF_set_text_pos($pdf, $x+330, $y);
PDF_show($pdf, $text);

$y-=18;
$x=13;
$text=$job_title;
PDF_setfont($pdf, $font, 8.0);
PDF_set_text_pos($pdf, $x, $y);
PDF_show($pdf, $text);

PDF_setfont($pdf, $font, 12.0);
$y-=10;
$x=310;
$text=$pay_grade;
PDF_set_text_pos($pdf, $x, $y);
PDF_show($pdf, $text);

$x=410;
$text=$hourly_rate;
PDF_set_text_pos($pdf, $x, $y);
PDF_show($pdf, $text);
$x=510;
$text=$billing_rate;
PDF_set_text_pos($pdf, $x, $y);
PDF_show($pdf, $text);

$x=95;
$y=415;
$text=$employee_name;
//$text="Tom Howard";
PDF_set_text_pos($pdf, $x, $y);
PDF_show($pdf, $text);
$x=312;
$y=425;
$text=$contact_info;
PDF_setfont($pdf, $font, 8.0);
PDF_set_text_pos($pdf, $x, $y);
PDF_show($pdf, $text);

$x=12;
$y=393;
$text=$job_description;
$size_8=8.0;
$size_9=9.0;
$eight_wrap=135;
$nine_wrap=122;
PDF_setfont($pdf, $font, $size_8);
$text=str_replace("\n","",$text);
	$lines = explode("\n",$text);
	pdf_set_text_pos($pdf,$x ,$y);
	foreach($lines as $line)
		{
		$foo = $line;
		$foo = wordwrap($foo,$eight_wrap,"|");
		$Arrx = explode("|",$foo);
		$i = 0;
		while (@$Arrx[$i] != "")
			{
			pdf_continue_text($pdf,$Arrx[$i]);
			$i++;
			}
	//	$textx = pdf_get_value($pdf, "textx", 0);
		$texty = pdf_get_value($pdf, "texty", 0);
		pdf_fit_textline($pdf,"\n",$x,$texty-12,"");
		} 

PDF_end_page_ext($pdf, "");

PDF_end_document($pdf, "");

$buf = PDF_get_buffer($pdf);
$len = strlen($buf);

//exit;


header("Content-type: application/pdf");
header("Content-Length: $len");
$filename="TempSolutions_jo_".$id.".pdf";
header("Content-Disposition: inline; filename=$filename");
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