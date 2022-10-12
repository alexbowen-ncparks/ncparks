<?php 
ini_set('display_errors',1);
$database="fixed_assets";
include("../../include/iConnect.inc");// database connection parameters
mysqli_select_db($connection,$database)
       or die ("Couldn't select database $database");
date_default_timezone_set('America/New_York');
 
extract($_REQUEST);


$sql="SELECT filetype,link from photos.signature where personID='Tingley9265'"; 
$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql c=$connection");
$row=mysqli_fetch_assoc($result);
$chop_sig="/opt/library/prd/WebServer/Documents/photos/".$row['link'];
$sig_type=$row['filetype'];

$sql="SELECT * from surplus_track where location='$location'"; 
//$sql="SELECT * from surplus_track where 1"; 
$result1 = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql c=$connection");

while($row=mysqli_fetch_assoc($result1))
	{
	$ARRAY[]=$row;
	}
$num_items=count($ARRAY);
$fieldNames=array_values(array_keys($ARRAY[0]));

//echo "$sql <pre>"; print_r($ARRAY); echo "</pre>";  exit;
	
define ("PAGE_WIDTH", 612); // 8.5 inches
define ("PAGE_HEIGHT",792); // 11 inches

// Create the PDF.	
$pdf = pdf_new(); include("/opt/library/prd/WebServer/include/pdf_key_23.php");
pdf_open_file ($pdf, "");

// Set the different PDF values.
pdf_set_info ($pdf, "Author", "Tom Howard");
pdf_set_info ($pdf, "Title", "NC DPR Surplus Items");
pdf_set_info ($pdf, "Creator", "See Author");

// Create the pages.
$max_lines=17;
if($num_items<$max_lines)
	{$max_lines=$num_items;}

$num_pages=ceil($num_items/$max_lines);

		$Helvetica = PDF_load_font($pdf, "Helvetica", "winansi", "");
		$Helvetica_Bold = PDF_load_font($pdf, "Helvetica-Bold", "winansi", "");

$skip=array("id","ts","source","fn_unique","pasu_date","pasu_name","disu_name","disu_date","chop_date","chop_name","location","photo_upload","center","bo_date","comments");
$rename=array("fas_num"=>"FAS #","serial_num"=>"SERIAL #","model_num"=>"MODEL #","qty"=>"QTY","description"=>"DESCRIPTION","condition"=>"CONDITION","surplus_loc"=>"DESTINATION");
$space_array=array("fas_num"=>"7","serial_num"=>"25","model_num"=>"16","qty"=>"3","description"=>"40","condition"=>"2", "surplus_loc"=>"0");
$col_array=array("fas_num"=>"15","serial_num"=>"60","model_num"=>"170","qty"=>"270","description"=>"295","condition"=>"505","surplus_loc"=>"540");

$i=0;
$page_num=1;
foreach($ARRAY as $num=>$array)
	{
	extract($array);


	if($i==0)
		{
		pdf_begin_page ($pdf, PAGE_WIDTH, PAGE_HEIGHT);
		pdf_setfont ($pdf, $Helvetica_Bold, 10);
		$y=760;
		$text="Surplus Form for Equipment, Supplies, and/or Miscellaneous";
		pdf_show_xy ($pdf,$text,140,$y);
		$y=740;
		$text="LOCATION: ____________              CENTER CODE: ____________";
		pdf_show_xy ($pdf,$text,125,$y);
		$text=$location;
		pdf_show_xy ($pdf,$text,190,$y+1);
		$text=$center;
		pdf_show_xy ($pdf,$text,380,$y+1);
		$y=720;
		$text="";
		foreach($ARRAY[0] as $fld=>$val)
			{
			if(in_array($fld, $skip)){continue;}
			$space=str_repeat(" ",$space_array[$fld]);
			$name=$rename[$fld];
			$text.=$name.$space;
			}
		
		pdf_show_xy ($pdf,$text,15,$y);
		
		$text="Page $page_num of ".$num_pages;
		pdf_show_xy ($pdf,$text,535,750);
		
		
		$y=734;
		}
	
	pdf_setfont ($pdf, $Helvetica, 10);

$line_leading=30;
	$y=$y-$line_leading;
	
		//PDF_show_boxed ( resource $p , string $text , float $left , float $top , float $width , float $height , string $mode , string $feature )
		foreach($array as $fld=>$value)
			{
			if(in_array($fld, $skip)){continue;}
			$val_x=$col_array[$fld];
			if($fld=="fas_num")
				{
				if(strpos($value, "NA_")>-1)
					{
					$exp=explode("_",$value); 
					$value=$exp[0];
					}
					else
					{
					$value=substr($value,0,-2);
					$value=substr($value,2);
					}
				}
					pdf_moveto($pdf, 10, $y+15);
					pdf_lineto($pdf, 600, $y+15);
					pdf_stroke($pdf);
			if($fld=="description")
				{
				PDF_show_boxed ($pdf,$value,$val_x,$y-12,220,24,"left","");
				if(strlen($value)>35){$y=$y-$line_leading;}
				}
				else
				{
				if($fld=="condition" and strlen($array['description'])>35)
					{
					PDF_show_boxed ($pdf,$value,$val_x,$y+18,25,24,"left","");
					$y=$y+30;
					}
					else
					{
					if($fld=="condition")
						{PDF_show_boxed ($pdf,$value,$val_x,$y-12,25,24,"left","");}
						else
						{pdf_show_xy ($pdf,$value,$val_x,$y);}
					
					}
				}
						
			}
	
	
	// Finish the page
	if(($i+1)==$max_lines)
		{
		$j=$i+1;
		
		$chart_bottom=200;
		pdf_moveto($pdf, 10, $chart_bottom);  // line above DELIVER
		pdf_lineto($pdf, 600, $chart_bottom);
		pdf_stroke($pdf);
		
		pdf_moveto($pdf, 55, 719);  // line beteween fas and serial
		pdf_lineto($pdf, 55, $chart_bottom);
		pdf_stroke($pdf);
		pdf_moveto($pdf, 167, 719);  // line beteween serial and model
		pdf_lineto($pdf, 167, $chart_bottom);
		pdf_stroke($pdf);
		pdf_moveto($pdf, 263, 719);  // line beteween model and qty
		pdf_lineto($pdf, 263, $chart_bottom);
		pdf_stroke($pdf);
		pdf_moveto($pdf, 290, 719);  // line beteween qty and descrip
		pdf_lineto($pdf, 290, $chart_bottom);
		pdf_stroke($pdf);
		pdf_moveto($pdf, 500, 719);  // line beteween desc and condition
		pdf_lineto($pdf, 500, $chart_bottom);
		pdf_stroke($pdf);
		pdf_moveto($pdf, 535, 719);  // line beteween condition and destination
		pdf_lineto($pdf, 535, $chart_bottom);
		pdf_stroke($pdf);
		
		// CHOP sig
		$size=getimagesize($chop_sig);  //echo "$chop_sig<pre>"; print_r($size); echo "</pre>";  exit;
		if($size[0]>$size[1]){$scale= (100/$size[0]);}else{$scale= (100/$size[1]); }
		
		$exp=explode("/",$sig_type);
	//	$img_type=array_pop($exp);
		$image = PDF_load_image($pdf, $exp[1], $chop_sig, '');
		
		pdf_place_image($pdf, $image, 240, 12, $scale);
		
		if($ARRAY[0]['surplus_loc']=="onsite")
			{
			$loc_on_site="_X_";
			$loc_off_site="___";
			}
			else
			{
			$loc_off_site="_X_";
			$loc_on_site="___";
			}
		
		
		$gt="SURPLUS ON SITE: $loc_on_site (IF SURPLUSING TRUCK, MUST ALSO COMPLETE MVR-180A REGARDLESS OF AGE AND VEHICLE CONDITION WORK SHEET)
DELIVER TO STATE SURPLUS ONLY $loc_off_site (IF SURPLUSING TRUCK MUST ALSO COMPLETE MVR-180A REGARDLESS OF AGE)

(MAY ONLY BE DELIVERED TO STATE SURPLUS OR REQUESTED FOR THE PARKS WAREHOUSE TO PICK UP AFTER ALL DEPARTMENTAL AND STATE SURPLUS PAPERWORK/APPROVALS COMPLETED BY THE DPR SURPLUS COORDINATOR  AND NOTIFICATION TO PROCEED SENT BY HIM//HER)

REQUESTED BY: SUPERINTENDENT ___________________________________________  DATE:  __________________ 

APPROVED BY: DIST. SUPERINTENDENT_______________________________________   DATE:  __________________ 

FINAL APPROVAL BY: CHIEF OF OPERATIONS___________________________________ DATE: ___________________

";
		pdf_setfont ($pdf, $Helvetica_Bold, 9);
		PDF_show_boxed ($pdf,$gt,15,14,530,145,"left","");
		
		pdf_show_xy ($pdf,$pasu_name,180,70);
		pdf_show_xy ($pdf,$disu_name,200,52);
		
		pdf_show_xy ($pdf,$pasu_date,440,70);
		pdf_show_xy ($pdf,$disu_date,440,52);
		pdf_show_xy ($pdf,$chop_date,440,34);
		
		
		$i=0;
		if($num_items!=$max_lines)
			{
			pdf_end_page ($pdf);
			$page_num++;
			}
		
		}
		else
		{$i++;}
	}// end $ARRAY


	$j=count($ARRAY);
	@$gt="";
	pdf_setfont ($pdf, $Helvetica_Bold, 12);
	PDF_show_boxed ($pdf,$gt,45,$y-16,530,14,"left","");
pdf_end_page ($pdf);

// Close the PDF
pdf_close ($pdf);

//exit; 

// Send the PDF to the browser.
$buffer = pdf_get_buffer ($pdf);
header ("Content-type: application/pdf");
header ("Content-Length: " . strlen($buffer));
$filename="DPR_Surplus_Form_".$location.".pdf";
header ("Content-Disposition: inline; filename=$filename");
echo $buffer;

// Free the resources
pdf_delete ($pdf);

?>