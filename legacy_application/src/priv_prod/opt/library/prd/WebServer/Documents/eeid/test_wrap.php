<?php

ini_set('display_errors',1);
extract($_REQUEST);
include("../../include/get_parkcodes.php");

$db="eeid";
include("../../include/connect_i_ROOT.inc"); // database connection parameters
$db = mysqli_select_db($connection,$database)       or die ("Couldn't select database");

$sql="SELECT t1.*, concat(park_code,id) as park_id 
FROM `field_trip` as t1
where 1 and id='$edit'";  //echo "$sql";
$result = mysqli_query($connection,$sql);
while($row=mysqli_fetch_assoc($result))
		{
	extract($row);
	$details=$row;
		
		$sql="SELECT t1.* , t2.nc_standard, t2.description
		FROM `field_trip_scos` as t1
		LEFT JOIN scos as t2 on t1.correlation=t2.id
		where 1 and park_id='$park_id'
		order by t2.grade, t2.id";  //echo "$sql";
		$result1 = mysqli_query($connection,$sql);
		while($row1=mysqli_fetch_assoc($result1))
			{
			$correlation_array[$park_id][$row1['nc_standard']]=$row1['description'];
			}
		}

$pdf = PDF_new(); include("/opt/library/prd/WebServer/include/pdf_key_23.php");

/*  open new PDF file; insert a file name to create the PDF on disk */
if (PDF_begin_document($pdf, "", "") == 0) {
    die("Error: " . PDF_get_errmsg($pdf));
}

PDF_set_info($pdf, "Creator", "ft.php");
PDF_set_info($pdf, "Author", "Tom Howard");
PDF_set_info($pdf, "Title", "NC State Parks Field Trips");

PDF_begin_page_ext($pdf, 595, 842, "");

$pl="field-trip.jpg";
$image = PDF_load_image($pdf,"jpeg",$pl,"");
	PDF_fit_image($pdf,$image,40,690,"scale 0.22");
	
$font = PDF_load_font($pdf, "Times-Roman", "winansi", "");
$font_nw = PDF_load_font($pdf, "Naturally_Wonderful", "winansi", "");
$verdana = PDF_load_font($pdf, "Verdana.1", "winansi", "");

//PDF_setfont($pdf, $font_nw, 22.0);
//pdf_show_xy($pdf, "Field Trips in North Carolina State Parks", 45, 800);

//PDF_setfont($pdf, $font, 16.0);


$skip=array("id","photo_link","park_id");
$rename=array("park_code"=>"State Park: ","grades"=>"Grades: ","program_title"=>"Program Title: ","program_description"=>"Program Description: ","length"=>"Program Length: ","class_size"=>"Class Size: ","times_available"=>"Times Available: ","required_dress"=>"Required Dress: ","scheduling_information"=>"Scheduling Information: ","other_information"=>"Other Information: ");
$text="";

$s=12;
foreach($details as $k=>$v)
	{
	if(in_array($k,$skip)){continue;}
	$fld=$rename[$k];
	if($k=="park_code"){$v=$parkCodeName[$v];}
	if(empty($v)){continue;}
	$text.="\n$fld ".$v;
	}

$x=40;
$y=670;
$lines = explode("\n",$text);
$lead=12;
//pdf_set_text_pos($pdf,$x ,$y);
foreach($lines as $line)
	{
     //   $c = $db->row['content'];
	$c=$line;
 //   $color = convert_hexcolor_rgbdec($color_hex);
   // pdf_setcolor($pdf, 'both', 'rgb', $color['r'], $color['g'], $color['b']);

    pdf_setfont($pdf, $verdana, $s);

    $par1 = stripslashes($c);

    $j = 0;
    $n = 0;
    $pw=20;
    while($j < $pw && $c != "") {
           $f = substr($par1, $n, 1);
           $fWidth = pdf_stringwidth($pdf, "$f", 1, $s);
           $j = $j + $fWidth;
           $fWidth = 0;
           $n++;
      }
    $wrap = $n;
   
    $lead = $s + 2;
    @$paragraph = wordwrap($paragraph, $wrap, "***");
    $parArr = explode("***", $paragraph);
echo "<pre>"; print_r($parArr); echo "</pre>";  exit;

    pdf_show_xy($pdf, "$parArr[0]", $x, $y);
    pdf_set_value($pdf, "leading", 12);

    $i = 1;
    while($parArr[$i]) {
        pdf_continue_text($pdf, "$parArr[$i]");
        $i++;
    }
}
?>