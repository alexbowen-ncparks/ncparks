<?php

$pdf = PDF_new(); include("/opt/library/prd/WebServer/include/pdf_key_23.php");

/*  open new PDF file; insert a file name to create the PDF on disk */
if (PDF_begin_document($pdf, "", "") == 0) {
    die("Error: " . PDF_get_errmsg($pdf));
}

PDF_set_info($pdf, "Creator", "hello.php");
PDF_set_info($pdf, "Author", "Tom Howard");
PDF_set_info($pdf, "Title", "Hello world (PHP)!");

PDF_begin_page_ext($pdf, 595, 842, "");

$font = PDF_load_font($pdf, "Helvetica-Bold", "winansi", "");
PDF_setfont($pdf, $font, 24.0);

PDF_set_text_pos($pdf, 50, 700);
PDF_show($pdf, "Hello world!");

$font = PDF_load_font($pdf, "Helvetica", "winansi", "");
PDF_setfont($pdf, $font, 12.0);

PDF_continue_text($pdf, "(says PHP using PDFlib)");
PDF_end_page_ext($pdf, "");

PDF_end_document($pdf, "");

$buf = PDF_get_buffer($pdf);
$len = strlen($buf);

header("Content-type: application/pdf");
header("Content-Length: $len");
header("Content-Disposition: inline; filename=hello.pdf");
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