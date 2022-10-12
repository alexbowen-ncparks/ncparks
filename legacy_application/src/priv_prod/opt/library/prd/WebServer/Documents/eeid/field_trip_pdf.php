<?php

ini_set('display_errors',1);
extract($_REQUEST);
include("../../include/get_parkcodes_dist.php");

$database="eeid";
if(empty($connection))
	{
include("../../include/iConnect.inc"); // database connection parameters
}

mysqli_select_db($connection,$database)       or die ("Couldn't select database");

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
	
$times = PDF_load_font($pdf, "Times-Roman", "winansi", "");
//$font_nw = PDF_load_font($pdf, "Naturally_Wonderful", "winansi", "");
$verdana = PDF_load_font($pdf, "Verdana.1", "winansi", "");
$verdana_bold = PDF_load_font($pdf, "Verdana_Bold", "winansi", "");

//PDF_setfont($pdf, $font_nw, 22.0);
//pdf_show_xy($pdf, "Field Trips in North Carolina State Parks", 45, 800);

//PDF_setfont($pdf, $font, 16.0);


$skip=array("id","photo_link","park_id");
$rename=array("park_code"=>"State Park: ","grades"=>"Grades:","program_title"=>"Program Title:","program_description"=>"Program Description:","length"=>"Program Length:","class_size"=>"Class Size:","times_available"=>"Times Available:","required_dress"=>"Required Dress:","scheduling_information"=>"Scheduling Information:","other_information"=>"Other Information:");
$text="";
foreach($details as $k=>$v)
	{
	if(in_array($k,$skip)){continue;}
	$fld=$rename[$k];
	if($k=="program_title")
		{
		$program_title=$v;
		}
	if($k=="park_code")
		{
		$park_code=$v;
		$v=$parkCodeName[$v];
		$park_name=$v;
		}
	if(empty($v)){continue;}
	$text.="\n$fld ".$v;
	}
//echo "<pre>"; print_r($text); echo "</pre>";  exit;

$x=40;
$y=695;

	$lines = explode("\n",$text);
	pdf_set_text_pos($pdf,$x ,$y);
	foreach($lines as $line)
		{
		
		$foo = $line;
		$var=strpos($foo,"Program Description");
		$var1=strpos($foo,"Program Title");
		$var2=strpos($foo,"State Park:");
		PDF_setfont($pdf, $verdana, 12.0);
		if($var>-1)
			{
			$foo = wordwrap($foo,38,"|");
			}
			else
			{
			$foo = wordwrap($foo,80,"|");
			}
		
		if($var1>-1)
			{
			PDF_setfont($pdf, $verdana_bold, 14.0);
			$title_len=strlen($foo); //echo "$title_len"; exit;
			}
			
		if($var2>-1)
			{
			$foo=str_replace("State Park:  ","",$foo);
			PDF_setfont($pdf, $verdana_bold, 24.0);
			if($foo=="Weymouth Woods-Sandhills Nature Preserve")
				{PDF_setfont($pdf, $verdana_bold, 19.0);}
			}
			
			
		$Arrx = explode("|",$foo);
		$i = 0;
		
		while (@$Arrx[$i] != "")
			{
			pdf_set_value($pdf,"leading",17);
			pdf_continue_text($pdf,$Arrx[$i]);
			$i++;
			}
	//	$textx = pdf_get_value($pdf, "textx", 0);
		$texty = pdf_get_value($pdf, "texty", 0);
		pdf_fit_textline($pdf,"\n",$x,$texty-14,"");
		} 
	

//exit;
//echo "$photo_link"; exit;
if(!empty($photo_link))
	{
	//	$texty = pdf_get_value($pdf, "texty", 0);
	$pl=str_replace("http://www.dpr.ncparks.gov/","/opt/library/prd/WebServer/Documents/",$photo_link);
	$image = PDF_load_image($pdf,"jpeg",$pl,"");

//echo "$title_len"; exit;
	if($title_len>=36)
		{PDF_fit_image($pdf,$image,310,365,"boxsize {280 200} fitmethod meet");}
		else
		{PDF_fit_image($pdf,$image,310,445,"boxsize {280 200} fitmethod meet");}
	
//	PDF_fit_image($pdf,$image,330,400,"scale 0.10");
	}
 
PDF_setfont($pdf, $times, 14.0);
$text="For Curriculum Standards and more visit www.ncparks.gov";
pdf_setcolor($pdf, "fill", "rgb",0, 0, 1,0);
pdf_show_xy($pdf, $text, 45, 50);
//exit;
//$image = PDF_load_image($pdf,"png","2013-dpr_green.png","");
$image = PDF_load_image($pdf,"jpeg","2013-DPR-logo-tiny_BW.jpg","");

$scale="0.30";
if($texty<111){$scale="0.25";}
PDF_fit_image($pdf,$image,430,25,"scale $scale");


PDF_end_page_ext($pdf, "");

PDF_end_document($pdf, "");

// exit;

$buf = PDF_get_buffer($pdf);
$len = strlen($buf);
header("Content-type: application/pdf");
header("Content-Length: $len");
$title=$park_code."-".$program_title.".pdf";
header("Content-Disposition: inline; filename=\"$title\"");
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