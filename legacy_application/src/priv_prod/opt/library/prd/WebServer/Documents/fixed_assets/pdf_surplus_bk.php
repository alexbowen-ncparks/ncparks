<?php 
ini_set('display_errors',1);
$database="fixed_assets";
include("../../include/iConnect.inc");// database connection parameters
mysqli_select_db($connection,$database)
       or die ("Couldn't select database $database");
date_default_timezone_set('America/New_York');
 
extract($_REQUEST);

$sql="SELECT filetype,link from photos.signature where personID='Lambert2172'"; 
$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql c=$connection");
$row=mysqli_fetch_assoc($result);
$chop_sig="/opt/library/prd/WebServer/Documents/photos/".$row['link'];
$sig_type=$row['filetype'];

$sql="SELECT * from surplus_track where location='$location'"; 
$sql="SELECT * from surplus_track where 1"; 
$result1 = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql c=$connection");

while($row=mysqli_fetch_assoc($result1))
	{
	$ARRAY[]=$row;
	}
$num_items=count($ARRAY);
$fieldNames=array_values(array_keys($ARRAY[0]));

//echo "<pre>"; print_r($ARRAY); echo "</pre>";  exit;
	
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
$max_lines=20;
if($num_items<$max_lines)
	{$max_lines=$num_items;}

$num_pages=ceil($num_items/$max_lines);

		$Helvetica = PDF_load_font($pdf, "Helvetica", "winansi", "");
		$Helvetica_Bold = PDF_load_font($pdf, "Helvetica-Bold", "winansi", "");

$skip=array("id","ts","source","fn_unique","pasu_date","pasu_name","disu_name","disu_date","chop_date","chop_name","location","photo_upload","center","bo_date","comments");
$rename=array("fas_num"=>"FAS #","serial_num"=>"SERIAL #","model_num"=>"MODEL #","qty"=>"QTY","description"=>"DESCRIPTION","condition"=>"CONDITION");
$space_array=array("fas_num"=>"15","serial_num"=>"25","model_num"=>"17","qty"=>"3","description"=>"50","condition"=>"0");
$col_array=array("fas_num"=>"15","serial_num"=>"87","model_num"=>"200","qty"=>"300","description"=>"320","condition"=>"565");

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
				}
					pdf_moveto($pdf, 10, $y+15);
					pdf_lineto($pdf, 600, $y+15);
					pdf_stroke($pdf);
			if($fld=="description")
				{
				PDF_show_boxed ($pdf,$value,$val_x,$y-12,250,24,"left","");
				if(strlen($value)>45){$y=$y-$line_leading;}
				}
				else
				{
				if($fld=="condition" and strlen($array['description'])>45)
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
		
		pdf_moveto($pdf, 10, 119);  // line above DELIVER
		pdf_lineto($pdf, 600, 119);
		pdf_stroke($pdf);
		
		pdf_moveto($pdf, 83, 719);  // line beteween fas and serial
		pdf_lineto($pdf, 83, 119);
		pdf_stroke($pdf);
		pdf_moveto($pdf, 197, 719);  // line beteween serial and model
		pdf_lineto($pdf, 197, 119);
		pdf_stroke($pdf);
		pdf_moveto($pdf, 290, 719);  // line beteween model and qty
		pdf_lineto($pdf, 290, 119);
		pdf_stroke($pdf);
		pdf_moveto($pdf, 318, 719);  // line beteween qty and descrip
		pdf_lineto($pdf, 318, 119);
		pdf_stroke($pdf);
		pdf_moveto($pdf, 561, 719);  // line beteween desc and condition
		pdf_lineto($pdf, 561, 119);
		pdf_stroke($pdf);
		
		// CHOP sig
		$size=getimagesize($chop_sig);  //echo "$chop_sig<pre>"; print_r($size); echo "</pre>";  exit;
		if($size[0]>$size[1]){$scale= (100/$size[0]);}else{$scale= (100/$size[1]); }
		
		$exp=explode("/",$sig_type);
	//	$img_type=array_pop($exp);
		$image = PDF_load_image($pdf, $exp[1], $chop_sig, '');
		
		pdf_place_image($pdf, $image, 240, 10, $scale);
		
		$gt="DELIVER TO STATE SURPLUS ONLY 	(there could be exceptions, so call DPR Surplus Coordinator to discuss.)

(MAY ONLY BE DELIVERED TO STATE SURPLUS OR REQUESTED FOR THE PARKS WAREHOUSE TO PICK UP AFTER ALL DEPARTMENTAL AND STATE SURPLUS PAPERWORK/APPROVALS COMPLETED BY THE DPR SURPLUS COORDINATOR  AND NOTIFICATION TO PROCEED SENT BY HIM//HER)

REQUESTED BY: SUPERINTENDENT ___________________________________________  DATE:  __________________ 

APPROVED BY: DIST. SUPERINTENDENT_______________________________________   DATE:  __________________ 

FINAL APPROVAL BY: CHIEF OF OPERATIONS___________________________________ DATE: ___________________

";
		pdf_setfont ($pdf, $Helvetica_Bold, 9);
		PDF_show_boxed ($pdf,$gt,15,14,530,105,"left","");
		
		pdf_show_xy ($pdf,$pasu_name,180,56);
		pdf_show_xy ($pdf,$disu_name,200,38);
		
		pdf_show_xy ($pdf,$pasu_date,440,56);
		pdf_show_xy ($pdf,$disu_date,440,38);
		pdf_show_xy ($pdf,$chop_date,440,20);
		
		
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
header ("Content-Disposition: inline; filename=DPR_Surplus_Form.pdf");
echo $buffer;

// Free the resources
pdf_delete ($pdf);

?>