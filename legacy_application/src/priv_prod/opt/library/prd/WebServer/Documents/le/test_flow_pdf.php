<?php
ini_set('display_errors',1);
$outfilename = "";
$tf = 0;
$llx1= 50; $lly1=50; $urx1=560; $ury1=800;

$optlist0 = "fontname=Helvetica-Bold fontsize=10 encoding=unicode " ;
$optlist1 = "fontname=Helvetica fontsize=8 encoding=unicode " ;
$optlist2 = "fontname=Helvetica-Oblique fontsize=8 encoding=unicode ";
define ("PAGE_WIDTH", 612); // 8.5 inches
define ("PAGE_HEIGHT",820); // 11 inches

session_start();
if(empty($db)){$db="le";}
$level=@$_SESSION[$db]['level'];
include("../../include/iConnect.inc"); // database connection parameters
mysqli_select_db($connection,$database)       or die ("Couldn't select database1");

date_default_timezone_set('America/New_York');
$date=date("Y-m-d");
	
// $majorGroup="Spiders";
// $majorGroupPrint = "Arachnids";
// 
// $version=": 1st Approximation";
// $footer_text="NC Biodiversity Project: $majorGroupPrint of North Carolina ($date)                             nc-biodiversity.com";

$id="16748";
$sql = "SELECT *
FROM pr63_pio
where id='$id'
";
$result = @mysqli_query($connection, $sql) or die("$sql Error #3". mysqli_error($connection));
while($row=mysqli_fetch_assoc($result))
	{
	$ARRAY_pr63[]=$row;
	}
$text="";
foreach($ARRAY_pr63 as $index=>$array)
	{
	extract($array);
	if(!empty($quick_link)){$ql="\n".$quick_link;}else{$ql="";}
	$text.=$time_pio_incident." ".$time_pio_date." ".$time_pio_location." ".$nature_of_incident." ".$text_arrest."\n\n";
	}
// echo "<pre>"; print_r($ARRAY_pr63); echo "</pre>";  exit;
// $text= implode("\n\n",$ARRAY_ref);

$skip=array("id","majorGroup","dateM");

$pdf = PDF_new(); include("/opt/library/prd/WebServer/include/pdf_key_23.php");

if (PDF_begin_document($pdf,  "", "") == 0) {
    die("Error: " . PDF_get_errmsg($pdf));
}

   pdf_set_info ($pdf, "Authors", "NC DPR");
pdf_set_info ($pdf, "Title", "PR-63");
pdf_set_info ($pdf, "Creator", "See Author");

    /* Create some amount of dummy text and feed it to a Textflow
     * object with alternating options. 
     */
$tf = pdf_create_textflow($pdf,"","");
PDF_add_textflow($pdf, $tf, "References\n\n", $optlist0);
   foreach($ARRAY_pr63 as $index=>$array)
	{
	foreach($array as $fld=>$val)
		{
		if(in_array($fld, $skip)){continue;}
		$text=$fld.": ".$val."\n";
		if($fld=="quick_link" and !empty($val))
			{$text="\n".$val;}
		if($fld=="title")
			{
			PDF_add_textflow($pdf, $tf, $text, $optlist2);
			}
			else
			{
			PDF_add_textflow($pdf, $tf, $text, $optlist1);
			}
		}
// 	$tf = $p->add_textflow($tf, "\n\n", $optlist1);
			PDF_add_textflow($pdf, $tf, "\n\n", $optlist1);


    }

    /* Loop until all of the text is placed; create new pages
     * as long as more text needs to be placed. 
     */
    do {
	/* Add "showborder to visualize the fitbox borders */
	$optlist = "verticalalign=justify linespreadlimit=120% ";
	$optlist="showborder";

// 	$p->begin_page_ext(0, 0, "width=a4.width height=a4.height");
	PDF_begin_page_ext ($pdf, PAGE_WIDTH, PAGE_HEIGHT,"");

	/* Fill the page */
// 	$result = $p->fit_textflow($tf, $llx1, $lly1, $urx1, $ury1, $optlist);
	$result = PDF_fit_textflow($pdf, $tf,  $llx1, $lly1, $urx1, $ury1,'');


// 	$p->end_page_ext("");
	PDF_end_page_ext ($pdf, "");
	
	/* "_boxfull" means we must continue because there is more text;
	 * "_nextpage" is interpreted as "start new column"
	 */
    } while ($result == "_boxfull" || $result == "_nextpage");

    /* Check for errors */
    if (!$result == "_stop") {
	/* "_boxempty" happens if the box is very small and doesn't
	 * hold any text at all.
	 */
	if ($result == "_boxempty") {
	    die("Error: Textflow box too small");
	} else {
	    /* Any other return value is a user exit caused by
	     * the "return" option; this requires dedicated code to
	     * deal with.
	     */
	    die("User return '" . $result . "' found in Textflow");
	}
    }

//     $p->delete_textflow($tf);
PDF_delete_textflow($pdf, $tf);

//     $p->end_document("");
    PDF_end_document($pdf,"");

//     $buf = $p->get_buffer();
    $buf=PDF_get_buffer($pdf);
    $len = strlen($buf);
// exit;
    header("Content-type: application/pdf");
    header("Content-Length: $len");
    header("Content-Disposition: inline; filename=starter_textflow.pdf");
    echo $buf;

mysqli_close($connection);

?>