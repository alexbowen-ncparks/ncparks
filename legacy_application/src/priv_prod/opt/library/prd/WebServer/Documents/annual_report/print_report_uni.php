<?php 

define ("PAGE_WIDTH", 612); // 8.5 inches
define ("PAGE_HEIGHT",792); // 11 inches
define ("FONT_SIZE",12); 


// Create the pages.
// create first file
$filepdf = pdf_new();
pdf_open_file($filepdf, "firstfile.pdf");
pdf_begin_page($filepdf, 500, 700);

// Set the different PDF values.
pdf_set_info ($filepdf, "Author", "Tom Howard");
pdf_set_info ($filepdf, "Title", "NC State Lakes Database");
pdf_set_info ($filepdf, "Creator", "See Author");

		$arial = pdf_findfont ($filepdf, "fonts/Arial.1", "winansi");
		$arialBold = pdf_findfont ($filepdf, "fonts/Arial_Bold", "winansi");
		$times = pdf_findfont ($filepdf, "fonts/Times_New_Roman", "winansi");
		$verdanaItalic = pdf_findfont ($filepdf, "fonts/Verdana_Italic", "winansi");
		

// create shape in first file
pdf_moveto($filepdf, 125, 175);
pdf_lineto($filepdf, 375, 175);
pdf_lineto($filepdf, 375, 525);
pdf_lineto($filepdf, 125, 525);
pdf_stroke($filepdf);

	pdf_end_page ($filepdf);

// Close the PDF
pdf_close ($filepdf);

// Send the PDF to the browser.
$buffer = pdf_get_buffer ($filepdf);
header ("Content-type: application/pdf");
header ("Content-Length: " . strlen($buffer));
$header="Content-Disposition: inline; filename=firstfile.pdf";
header ($header);
echo $buffer;

// Free the resources
pdf_delete ($filepdf);

?>