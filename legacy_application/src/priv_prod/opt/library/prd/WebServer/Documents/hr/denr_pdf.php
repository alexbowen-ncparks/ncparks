<?php
extract($_POST);

$pdf = PDF_new(); include("/opt/library/prd/WebServer/include/pdf_key_23.php");

/*  open new PDF file; insert a file name to create the PDF on disk */
if (PDF_begin_document($pdf, "", "") == 0) {
    die("Error: " . PDF_get_errmsg($pdf));
}

PDF_set_info($pdf, "Creator", "denr.php");
PDF_set_info($pdf, "Author", "Tom Howard");
PDF_set_info($pdf, "Title", "DENR - Personnel/Position Request Form");

PDF_begin_page_ext($pdf, 595, 842, "");

$helvetica_bold = PDF_load_font($pdf, "Helvetica-Bold", "winansi", "");
$helvetica = PDF_load_font($pdf, "Helvetica", "winansi", "");
$helvetica_italic = PDF_load_font($pdf, "Helvetica-Oblique", "winansi", "");

$image = PDF_load_image($pdf,"jpeg","image005.jpg","");
 PDF_fit_image($pdf,$image,40,770,"");
 PDF_close_image($pdf,$image);


PDF_setfont($pdf, $helvetica, 8.0);
PDF_set_text_pos($pdf, 500, 820);
PDF_show($pdf, "Log No. ________");

PDF_setfont($pdf, $helvetica, 13.0);
PDF_set_text_pos($pdf, 170, 800);
PDF_show($pdf, "Department of Environment & Natural Resources");
PDF_continue_text($pdf, "              Division of Human Resources");
PDF_continue_text($pdf, "           Personnel/Position Request Form");

pdf_setgray_fill($pdf, 0);

// set to a gray fill if other than black
//pdf_setgray_fill($pdf, 0.9);
// draw a rectangle
pdf_rect($pdf, 30, 750, 540, 12);
pdf_fill_stroke($pdf);
//pdf_setgray_fill($pdf, 0);   // set back to black

pdf_setgray_fill($pdf, 1);  // white

PDF_setfont($pdf, $helvetica_bold, 9.0);

PDF_set_text_pos($pdf, 250, 753);
$text="EMPLOYEE INFORMATION";
PDF_show($pdf, $text);

pdf_setgray_fill($pdf, 0);  // black

PDF_setfont($pdf, $helvetica, 9.0);
PDF_set_text_pos($pdf, 50, 735);
$text="Employee Name:  ____________________________________                   BEACON ID #: ________________________";
PDF_show($pdf, $text);

PDF_set_text_pos($pdf, 125, 735);
$text=$name;
PDF_show($pdf, $text);

PDF_set_text_pos($pdf, 413, 735);
$text=$beaconID;
PDF_show($pdf, $text);

PDF_set_text_pos($pdf, 85, 715);
$text="Division:  ____________________________________                   Date Effective: ________________________";
PDF_show($pdf, $text);

PDF_set_text_pos($pdf, 125, 715);
$text=$division;
PDF_show($pdf, $text);

PDF_set_text_pos($pdf, 414, 715);
$text=$effective_date;
PDF_show($pdf, $text);



PDF_setfont($pdf, $helvetica_bold, 9.0);
pdf_rect($pdf, 30, 690, 540, 12);
pdf_fill_stroke($pdf);
pdf_setgray_fill($pdf, 1);  // white
PDF_set_text_pos($pdf, 230, 693);
$text="EMPLOYMENT / POSITION CHANGES";
PDF_show($pdf, $text);

pdf_setgray_fill($pdf, 0);  // black

PDF_setfont($pdf, $helvetica, 9.0);

PDF_set_text_pos($pdf, 45, 678);
PDF_show($pdf, "            Choose from");
PDF_continue_text($pdf, "       dropdown menu");
PDF_continue_text($pdf, "      BEACON Action:");

PDF_continue_text($pdf, "            Choose from");
PDF_continue_text($pdf, " dropdown menu PA");
PDF_continue_text($pdf, "                      Action:");


PDF_setfont($pdf, $helvetica_bold, 9.0);
PDF_set_text_pos($pdf, 63, 620);
$text=$beacon_action;
PDF_show($pdf, $text);

//PDF_continue_text($pdf, "            Choose from");
//PDF_continue_text($pdf, "dropdown menu Re-");
//PDF_continue_text($pdf, "             instatement:");

PDF_setfont($pdf, $helvetica, 9.0);

PDF_set_text_pos($pdf, 165, 660);
$text="Classification: __________________________________";
PDF_show($pdf, $text);
PDF_set_text_pos($pdf, 224, 660);
$text=$classification;
PDF_show($pdf, $text);

PDF_set_text_pos($pdf, 420, 660);
$text="Position Number: _________";
PDF_show($pdf, $text);
PDF_set_text_pos($pdf, 494, 660);
$text=$beacon_num;
PDF_show($pdf, $text);

PDF_set_text_pos($pdf, 165, 640);
$text=" Working Title";
PDF_show($pdf, $text);
$text="   (if different): __________________________________";
PDF_continue_text($pdf, $text);
PDF_set_text_pos($pdf, 224, 631);
$text=$position_title;
PDF_show($pdf, $text);

PDF_set_text_pos($pdf, 426, 640);
$text="Salary Grade or";
PDF_show($pdf, $text);
$text="    Competency: ___";
PDF_continue_text($pdf, $text);
PDF_set_text_pos($pdf, 494, 631);
$text=$pay_grade;
PDF_show($pdf, $text);

PDF_set_text_pos($pdf, 146, 600);
$text="Requested Salary: _____";
PDF_show($pdf, $text);
PDF_set_text_pos($pdf, 224, 600);
$text=$pay_rate;
PDF_show($pdf, $text);

PDF_set_text_pos($pdf, 290, 610);
$text="Budgeted";
PDF_show($pdf, $text);
PDF_set_text_pos($pdf, 296, 600);
$text="Amount: __________";
PDF_show($pdf, $text);
PDF_set_text_pos($pdf, 333, 600);
$text="$".$budgeted_amount;
PDF_show($pdf, $text);

PDF_set_text_pos($pdf, 423, 600);
$text="Funding Source: ________";
PDF_show($pdf, $text);
PDF_set_text_pos($pdf, 491, 600);
$text=$center;
PDF_show($pdf, $text);

PDF_set_text_pos($pdf, 144, 575);
$text="BEACON Deadline";
PDF_show($pdf, $text);
PDF_set_text_pos($pdf, 198, 565);
$text="Date: _________";
PDF_show($pdf, $text);
PDF_set_text_pos($pdf, 223, 565);
$text=$deadline_date;
PDF_show($pdf, $text);

PDF_set_text_pos($pdf, 268, 575);
$text="Salary Reserve";
PDF_show($pdf, $text);
PDF_set_text_pos($pdf, 295, 565);
$text="Created: ____";
PDF_show($pdf, $text);
PDF_set_text_pos($pdf, 333, 565);
$text=$salary_reserve_c;
PDF_show($pdf, $text);

PDF_set_text_pos($pdf, 427, 575);
$text="Salary Reserve";
PDF_show($pdf, $text);
PDF_set_text_pos($pdf, 455, 565);
$text="Needed: ____";
PDF_show($pdf, $text);
PDF_set_text_pos($pdf, 492, 565);
$text=$salary_reserve_n;
PDF_show($pdf, $text);


pdf_rect($pdf, 30, 545, 540, 12);
pdf_stroke($pdf);

PDF_set_text_pos($pdf, 50, 548.3);
$text="Complete the following information only for movement of permanent state employee (i.e. promotion, transfer, etc.)";
PDF_show($pdf, $text);


PDF_set_text_pos($pdf, 165, 530);
$text="         Current";
PDF_show($pdf, $text);
$text="Classification: __________________________________";
PDF_continue_text($pdf, $text);

PDF_set_text_pos($pdf, 414, 530);
$text="          Current";
PDF_show($pdf, $text);
$text="Dept/Division: ___________________";
PDF_continue_text($pdf, $text);


PDF_set_text_pos($pdf, 143, 505);
$text="Salary Grade or";
PDF_show($pdf, $text);
$text="Competency Level: ___________";
PDF_continue_text($pdf, $text);

PDF_set_text_pos($pdf, 280, 496);
$text="Current Salary: __________";
PDF_show($pdf, $text);

PDF_set_text_pos($pdf, 432, 505);
$text="% Salary";
PDF_show($pdf, $text);
$text="Increase: ___________________";
PDF_continue_text($pdf, $text);

pdf_rect($pdf, 30, 470, 540, 12);
pdf_fill_stroke($pdf);

pdf_setgray_fill($pdf, 1);  // white
PDF_setfont($pdf, $helvetica_bold, 9.0);

PDF_set_text_pos($pdf, 260, 473);
$text="JUSTIFICATION";
PDF_show($pdf, $text);
pdf_setgray_fill($pdf, 0);  // black



pdf_rect($pdf, 30, 400, 540, 12);
pdf_fill_stroke($pdf);
pdf_setgray_fill($pdf, 1);  // white
PDF_setfont($pdf, $helvetica_bold, 9.0);

PDF_set_text_pos($pdf, 270, 403);
$text="APPROVALS";
PDF_show($pdf, $text);
pdf_setgray_fill($pdf, 0);  // black


PDF_set_text_pos($pdf, 50, 455);
$text="Justification/Comments: $justification";
PDF_show($pdf, $text);

PDF_setfont($pdf, $helvetica, 9.0);

PDF_set_text_pos($pdf, 70, 435);
$text="Submitted by";
PDF_show($pdf, $text);
$text="HR Manager   Signature: __________________________________                         Date: ________________________";
PDF_continue_text($pdf, $text);

PDF_set_text_pos($pdf, 70, 375);
$text="Division Director   Name: __________________________________     Title (if designee): ________________________";
PDF_show($pdf, $text);

PDF_set_text_pos($pdf, 70, 350);
$text="                        Signature: __________________________________                         Date: ________________________";
PDF_show($pdf, $text);

PDF_set_text_pos($pdf, 53, 315);
$text="DENR HR Director Signature: __________________________________                         Date: ________________________";
PDF_show($pdf, $text);


PDF_set_text_pos($pdf, 53, 280);
$text="Returned to Division for:";
PDF_show($pdf, $text);

PDF_set_text_pos($pdf, 53, 250);
$text="Comments:";
PDF_show($pdf, $text);


PDF_setfont($pdf, $helvetica_italic, 8.0);
PDF_set_text_pos($pdf, 260, 20);
$text="Form Update 5/6/13";
PDF_show($pdf, $text);



PDF_end_page_ext($pdf, "");
PDF_end_document($pdf, "");

//exit;
$buf = PDF_get_buffer($pdf);
$len = strlen($buf);

header("Content-type: application/pdf");
header("Content-Length: $len");
header("Content-Disposition: inline; filename=DENR-DPR_request_form.pdf");
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