<?php 
//echo "<pre>"; print_r($_POST); echo "</pre>";  exit;
ini_set('display_errors',1);

$database="annual_report";
extract($_REQUEST);
include("../../include/get_parkcodes_reg.php");// database connection parameters
// include("../../include/iConnect.inc");// database connection parameters

mysqli_select_db($connection,$database)
       or die ("Couldn't select database $database");

// Get boilerplate
$sql="SELECT *
FROM  task where id=$id"; //echo "$sql";
$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql");
 
$num1=mysqli_num_rows($result);
if($num1>0)
	{
	while($row=mysqli_fetch_assoc($result))
		{
			$ARRAY[]=$row;
		}
	}

//echo "<pre>"; print_r($ARRAY); echo "</pre>";  exit;

$num=count($ARRAY);
if($num<1){echo "No record was found using: <b>$clause</b>";exit;}

$field_array=array("budget"=>"Budget","personnel"=>"Personnel","training_admin"=>"Administrative Training","visitation"=>"Visitation","donation_money"=>"Donations Collected in Collection Boxes or at Events in the Park","donation_items"=>"Donated Items, Equipment, Supplies, or Services to the Park","revenue"=>"Revenue Generation","pac"=>"Park Advisory Committee","other_cat_1"=>"Other Park Admin.","object_1"=>"Objectives/Needs-PA","facility"=>"Operation of Facilities","maintenance"=>"Maintenance","major_main"=>"Major Maintenance","cip"=>"CIP","volunteer"=>"Volunteers","work_program"=>"Work Programs","sustain"=>"Sustainability","other_cat_2"=>"Other Park Operations","object_2"=>"Objectives/Needs-PO","land_protect"=>"Land Protection","threat"=>"Threats to park's natural resources","invasive"=>"Invasive species management","fire"=>"Prescribed fire/wildland fire control","boundary"=>"Boundary Management","other_cat_3"=>"Other Natural Resources","object_3"=>"Objectives/Needs-NR","exhibit"=>"Exhibits","programs"=>"Programs","outreach"=>"Outreach","training_ie"=>"Training","other_cat_4"=>'Other Interpretation & Education',"object_4"=>"Objectives/Needs-IE","le"=>"Law Enforcement Program","safety"=>"Safety Program","sar"=>"SAR","ems"=>"EMS/Accidents","other_cat_5"=>"Other Protection & Safety","object_5"=>"Objectives/Needs-PS");

$cat_array=array("budget"=>"                    ***CATEGORY 1: PARK ADMINISTRATION***","facility"=>"                    ***CATEGORY 2: PARK OPERATIONS***","land_protect"=>"                    ***CATEGORY 3: NATURAL RESOURCES***","exhibit"=>"                    ***CATEGORY 4: INTERPRETATION AND EDUCATION***","le"=>"                    ***CATEGORY 5: PROTECTION AND SAFETY***");

define ("PAGE_WIDTH", 612); // 8.5 inches
define ("PAGE_HEIGHT",792); // 11 inches
define ("FONT_SIZE",12); 

// Create the Page.	
$pdf = pdf_new(); include("/opt/library/prd/WebServer/include/pdf_key_23.php");
pdf_open_file ($pdf, "");

// Set the different PDF values.
pdf_set_info ($pdf, "Author", "Tom Howard");
pdf_set_info ($pdf, "Title", "NC State Lakes Database");
pdf_set_info ($pdf, "Creator", "See Author");
$path="/opt/library/prd/WebServer/Documents/inc/";

$arial = PDF_load_font ($pdf, $path."fonts/Arial", "winansi", "");
$arialBold = PDF_load_font ($pdf, $path."fonts/arial_bold", "winansi", "");
$times = PDF_load_font ($pdf, $path."fonts/Times_New_Roman", "winansi", "");
$verdanaItalic = PDF_load_font ($pdf, $path."fonts/Verdana_Italic", "winansi", "");
		
// Create the pages.
	pdf_begin_page ($pdf, PAGE_WIDTH, PAGE_HEIGHT);
	
// echo "<pre>"; print_r($ARRAY); echo "</pre>";  exit;
$skip=array("id","park_code","pasu","f_year");
foreach($ARRAY as $num=>$array)
	{
	//*********
	// Add Header
	pdf_setfont ($pdf, $arial, 14);
	$y=750;
	$text="NC DIVISION OF PARKS AND RECREATION ";
		pdf_show_xy ($pdf,$text,190,$y);
	$y=730;
	$text=$ARRAY[$num]['f_year']." Annual Report for ".$ARRAY[$num]['park_code'];
		pdf_show_xy ($pdf,$text,220,$y);
	pdf_setfont ($pdf, $times, 12);
	$y=714;
	$text="Submitted by ".$ARRAY[$num]['pasu'];
		pdf_show_xy ($pdf,$text,53,$y);
	
	
	$text="";
		
	foreach($array as $k=>$v)
		{
		if(in_array($k,$skip)){continue;}
		$field=$k;
		@$k=@$cat_array[$field]."\n".strtoupper($field_array[$k]);
		
		$text.=$k."\n".$v."\n\n";
		}
		
		$width=500;
		$just="left";
		$feature="blind";
		$box_height=640;
		$box_top=60;
		
		pdf_setfont ($pdf, $times, 12);
		pdf_set_value($pdf,'leading',14);
	
// 	$len=strlen($text);  echo "L=$lenz<br />$text"; exit;
	$test=pdf_show_boxed($pdf,$text,53,$box_top,$width,$box_height,$just,$feature);
// 	echo "t=$test"; exit;
	if($test>0)
		{
		$new_text="";
		while(pdf_show_boxed($pdf,$new_text,53,$box_top,$width,$box_height,$just,$feature)<$test)
			{
			foreach($array as $k=>$v)
				{
				if(in_array($k,$skip)){continue;}
				$field=$k;
				@$k=@$cat_array[$field]."\n".strtoupper($field_array[$k]);
				if($v==""){$v=" - nothing to report.";}
				
				$new_text.=$k."\n".$v."\n\n";
				}
			
			}
		}
	
	pdf_show_boxed($pdf,$new_text,53,$box_top,$width,$box_height,$just,"");
	
	// Finish the page 1
	pdf_end_page ($pdf);
	
	$new_text=substr($text,-$test);

	pdf_begin_page ($pdf, PAGE_WIDTH, PAGE_HEIGHT);

$arial = PDF_load_font ($pdf, $path."fonts/Arial", "winansi", "");
$arialBold = PDF_load_font ($pdf, $path."fonts/arial_bold", "winansi", "");
$times = PDF_load_font ($pdf, $path."fonts/Times_New_Roman", "winansi", "");
$verdanaItalic = PDF_load_font ($pdf, $path."fonts/Verdana_Italic", "winansi", "");
	
		pdf_setfont ($pdf, $times, 12);
		pdf_set_value($pdf,'leading',14);
		
		$box_height=720;
		$box_top=60;
		
$test=pdf_show_boxed($pdf,$new_text,53,$box_top,$width,$box_height,$just,$feature);

//	pdf_show_xy($pdf,$test,553,300);
while(pdf_show_boxed($pdf,$new_text,53,$box_top,$width,$box_height,$just,$feature)<$test)
			{
			foreach($array as $k=>$v)
				{
				if(in_array($k,$skip)){continue;}
				$field=$k;
				$k=strtoupper($field_array[$k]);
				
			//	$new_text.=$k."\n".$v."\n\n";
				}
			
			}

	pdf_show_boxed($pdf,$new_text,53,$box_top,$width,$box_height,$just,"");
	
// Finish the page 2
	pdf_end_page ($pdf);

	$new_text=substr($text,-$test);
//	if($new_text==0){break;}
	
	pdf_begin_page ($pdf, PAGE_WIDTH, PAGE_HEIGHT);

$arial = PDF_load_font ($pdf, $path."fonts/Arial", "winansi", "");
$arialBold = PDF_load_font ($pdf, $path."fonts/arial_bold", "winansi", "");
$times = PDF_load_font ($pdf, $path."fonts/Times_New_Roman", "winansi", "");
$verdanaItalic = PDF_load_font ($pdf, $path."fonts/Verdana_Italic", "winansi", "");
	
		pdf_setfont ($pdf, $times, 12);
		pdf_set_value($pdf,'leading',14);
		
		$box_height=720;
		$box_top=60;
		
$test=pdf_show_boxed($pdf,$new_text,53,$box_top,$width,$box_height,$just,$feature);

//	pdf_show_xy($pdf,$test,553,300);
while(pdf_show_boxed($pdf,$new_text,53,$box_top,$width,$box_height,$just,$feature)<$test)
			{
			foreach($array as $k=>$v)
				{
				if(in_array($k,$skip)){continue;}
				$field=$k;
				$k=strtoupper($field_array[$k]);
				
				$new_text.=$k."\n".$v."\n\n";
				}
			
			}

	pdf_show_boxed($pdf,$new_text,53,$box_top,$width,$box_height,$just,"");
	
// Finish the page 3
	pdf_end_page ($pdf);
		
	$new_text=substr($text,-$test);
	if(strpos($new_text,"CATEGORY 1")>0){break;}

	pdf_begin_page ($pdf, PAGE_WIDTH, PAGE_HEIGHT);

$arial = PDF_load_font ($pdf, $path."fonts/Arial", "winansi", "");
$arialBold = PDF_load_font ($pdf, $path."fonts/arial_bold", "winansi", "");
$times = PDF_load_font ($pdf, $path."fonts/Times_New_Roman", "winansi", "");
$verdanaItalic = PDF_load_font ($pdf, $path."fonts/Verdana_Italic", "winansi", "");
			
		pdf_setfont ($pdf, $times, 12);
		pdf_set_value($pdf,'leading',14);
		
		$box_height=720;
		$box_top=60;
		
$test=pdf_show_boxed($pdf,$new_text,53,$box_top,$width,$box_height,$just,$feature);

//	pdf_show_xy($pdf,$test,553,300);
while(pdf_show_boxed($pdf,$new_text,53,$box_top,$width,$box_height,$just,$feature)<$test)
			{
			foreach($array as $k=>$v)
				{
				if(in_array($k,$skip)){continue;}
				$field=$k;
				$k=strtoupper($field_array[$k]);
				
				$new_text.=$k."\n".$v."\n\n";
				}
			
			}

	pdf_show_boxed($pdf,$new_text,53,$box_top,$width,$box_height,$just,"");
	
// Finish the page 4
	pdf_end_page ($pdf);
	
	$new_text=substr($text,-$test);
	if(strpos($new_text,"CATEGORY 1")>0){break;}

	pdf_begin_page ($pdf, PAGE_WIDTH, PAGE_HEIGHT);
	
$arial = PDF_load_font ($pdf, $path."fonts/Arial", "winansi", "");
$arialBold = PDF_load_font ($pdf, $path."fonts/arial_bold", "winansi", "");
$times = PDF_load_font ($pdf, $path."fonts/Times_New_Roman", "winansi", "");
$verdanaItalic = PDF_load_font ($pdf, $path."fonts/Verdana_Italic", "winansi", "");

		pdf_setfont ($pdf, $times, 12);
		pdf_set_value($pdf,'leading',14);
		
		$box_height=720;
		$box_top=60;
		
$test=pdf_show_boxed($pdf,$new_text,53,$box_top,$width,$box_height,$just,$feature);

//	pdf_show_xy($pdf,$test,553,300);
while(pdf_show_boxed($pdf,$new_text,53,$box_top,$width,$box_height,$just,$feature)<$test)
			{
			foreach($array as $k=>$v)
				{
				if(in_array($k,$skip)){continue;}
				$field=$k;
				$k=strtoupper($field_array[$k]);
				
				$new_text.=$k."\n".$v."\n\n";
				}
			
			}

	pdf_show_boxed($pdf,$new_text,53,$box_top,$width,$box_height,$just,"");
	
// Finish the page 5
	pdf_end_page ($pdf);			

	$new_text=substr($text,-$test);
	if(strpos($new_text,"CATEGORY 1")>0){break;}

	pdf_begin_page ($pdf, PAGE_WIDTH, PAGE_HEIGHT);
	
	
$arial = PDF_load_font ($pdf, $path."fonts/Arial", "winansi", "");
$arialBold = PDF_load_font ($pdf, $path."fonts/arial_bold", "winansi", "");
$times = PDF_load_font ($pdf, $path."fonts/Times_New_Roman", "winansi", "");
$verdanaItalic = PDF_load_font ($pdf, $path."fonts/Verdana_Italic", "winansi", "");
		
		pdf_setfont ($pdf, $times, 12);
		pdf_set_value($pdf,'leading',14);
		
		$box_height=720;
		$box_top=60;
		
$test=pdf_show_boxed($pdf,$new_text,53,$box_top,$width,$box_height,$just,$feature);

//	pdf_show_xy($pdf,$test,553,300);
while(pdf_show_boxed($pdf,$new_text,53,$box_top,$width,$box_height,$just,$feature)<$test)
			{
			foreach($array as $k=>$v)
				{
				if(in_array($k,$skip)){continue;}
				$field=$k;
				$k=strtoupper($field_array[$k]);
				
				$new_text.=$k."\n".$v."\n\n";
				}
			
			}

	pdf_show_boxed($pdf,$new_text,53,$box_top,$width,$box_height,$just,"");
	
// Finish the page 6
	pdf_end_page ($pdf);
		

	
	$new_text=substr($text,-$test);
	if(strpos($new_text,"CATEGORY 1")>0){break;}

	pdf_begin_page ($pdf, PAGE_WIDTH, PAGE_HEIGHT);
	
$arial = PDF_load_font ($pdf, $path."fonts/Arial", "winansi", "");
$arialBold = PDF_load_font ($pdf, $path."fonts/arial_bold", "winansi", "");
$times = PDF_load_font ($pdf, $path."fonts/Times_New_Roman", "winansi", "");
$verdanaItalic = PDF_load_font ($pdf, $path."fonts/Verdana_Italic", "winansi", "");
		
		pdf_setfont ($pdf, $times, 12);
		pdf_set_value($pdf,'leading',14);
		
		$box_height=720;
		$box_top=60;
		
$test=pdf_show_boxed($pdf,$new_text,53,$box_top,$width,$box_height,$just,$feature);

//	pdf_show_xy($pdf,$test,553,300);
while(pdf_show_boxed($pdf,$new_text,53,$box_top,$width,$box_height,$just,$feature)<$test)
			{
			foreach($array as $k=>$v)
				{
				if(in_array($k,$skip)){continue;}
				$field=$k;
				$k=strtoupper($field_array[$k]);
				
				$new_text.=$k."\n".$v."\n\n";
				}
			
			}

	pdf_show_boxed($pdf,$new_text,53,$box_top,$width,$box_height,$just,"");
	
// Finish the page 7
	pdf_end_page ($pdf);
	

	$new_text=substr($text,-$test);
	if(strpos($new_text,"CATEGORY 1")>0){break;}

	pdf_begin_page ($pdf, PAGE_WIDTH, PAGE_HEIGHT);
	
	
$arial = PDF_load_font ($pdf, $path."fonts/Arial", "winansi", "");
$arialBold = PDF_load_font ($pdf, $path."fonts/arial_bold", "winansi", "");
$times = PDF_load_font ($pdf, $path."fonts/Times_New_Roman", "winansi", "");
$verdanaItalic = PDF_load_font ($pdf, $path."fonts/Verdana_Italic", "winansi", "");
		pdf_setfont ($pdf, $times, 12);
		pdf_set_value($pdf,'leading',14);
		
		$box_height=720;
		$box_top=60;
		
$test=pdf_show_boxed($pdf,$new_text,53,$box_top,$width,$box_height,$just,$feature);

//	pdf_show_xy($pdf,$test,553,300);
while(pdf_show_boxed($pdf,$new_text,53,$box_top,$width,$box_height,$just,$feature)<$test)
			{
			foreach($array as $k=>$v)
				{
				if(in_array($k,$skip)){continue;}
				$field=$k;
				$k=strtoupper($field_array[$k]);
				
				$new_text.=$k."\n".$v."\n\n";
				}
			
			}

	pdf_show_boxed($pdf,$new_text,53,$box_top,$width,$box_height,$just,"");
	
// Finish the page 8
	pdf_end_page ($pdf);
		

	$new_text=substr($text,-$test);
	if(strpos($new_text,"CATEGORY 1")>0){break;}

	pdf_begin_page ($pdf, PAGE_WIDTH, PAGE_HEIGHT);
	
$arial = PDF_load_font ($pdf, $path."fonts/Arial", "winansi", "");
$arialBold = PDF_load_font ($pdf, $path."fonts/arial_bold", "winansi", "");
$times = PDF_load_font ($pdf, $path."fonts/Times_New_Roman", "winansi", "");
$verdanaItalic = PDF_load_font ($pdf, $path."fonts/Verdana_Italic", "winansi", "");
		
		pdf_setfont ($pdf, $times, 12);
		pdf_set_value($pdf,'leading',14);
		
		$box_height=720;
		$box_top=60;
		
$test=pdf_show_boxed($pdf,$new_text,53,$box_top,$width,$box_height,$just,$feature);

//	pdf_show_xy($pdf,$test,553,300);
while(pdf_show_boxed($pdf,$new_text,53,$box_top,$width,$box_height,$just,$feature)<$test)
			{
			foreach($array as $k=>$v)
				{
				if(in_array($k,$skip)){continue;}
				$field=$k;
				$k=strtoupper($field_array[$k]);
				
				$new_text.=$k."\n".$v."\n\n";
				}
			
			}

	pdf_show_boxed($pdf,$new_text,53,$box_top,$width,$box_height,$just,"");
	
// Finish the page 9
	pdf_end_page ($pdf);
	
	$new_text=substr($text,-$test);
	if(strpos($new_text,"CATEGORY 1")>0){break;}

	pdf_begin_page ($pdf, PAGE_WIDTH, PAGE_HEIGHT);
	

$arial = PDF_load_font ($pdf, $path."fonts/Arial", "winansi", "");
$arialBold = PDF_load_font ($pdf, $path."fonts/arial_bold", "winansi", "");
$times = PDF_load_font ($pdf, $path."fonts/Times_New_Roman", "winansi", "");
$verdanaItalic = PDF_load_font ($pdf, $path."fonts/Verdana_Italic", "winansi", "");
	
		pdf_setfont ($pdf, $times, 12);
		pdf_set_value($pdf,'leading',14);
		
		$box_height=720;
		$box_top=60;
		
$test=pdf_show_boxed($pdf,$new_text,53,$box_top,$width,$box_height,$just,$feature);

//	pdf_show_xy($pdf,$test,553,300);
while(pdf_show_boxed($pdf,$new_text,53,$box_top,$width,$box_height,$just,$feature)<$test)
			{
			foreach($array as $k=>$v)
				{
				if(in_array($k,$skip)){continue;}
				$field=$k;
				$k=strtoupper($field_array[$k]);
				
				$new_text.=$k."\n".$v."\n\n";
				}
			
			}

	pdf_show_boxed($pdf,$new_text,53,$box_top,$width,$box_height,$just,"");
	
// Finish the page 10
	pdf_end_page ($pdf);
	
	$new_text=substr($text,-$test);
	if(strpos($new_text,"CATEGORY 1")>0){break;}

	pdf_begin_page ($pdf, PAGE_WIDTH, PAGE_HEIGHT);
	
$arial = PDF_load_font ($pdf, $path."fonts/Arial", "winansi", "");
$arialBold = PDF_load_font ($pdf, $path."fonts/arial_bold", "winansi", "");
$times = PDF_load_font ($pdf, $path."fonts/Times_New_Roman", "winansi", "");
$verdanaItalic = PDF_load_font ($pdf, $path."fonts/Verdana_Italic", "winansi", "");
		
		pdf_setfont ($pdf, $times, 12);
		pdf_set_value($pdf,'leading',14);
		
		$box_height=720;
		$box_top=60;
		
$test=pdf_show_boxed($pdf,$new_text,53,$box_top,$width,$box_height,$just,$feature);

//	pdf_show_xy($pdf,$test,553,300);
while(pdf_show_boxed($pdf,$new_text,53,$box_top,$width,$box_height,$just,$feature)<$test)
			{
			foreach($array as $k=>$v)
				{
				if(in_array($k,$skip)){continue;}
				$field=$k;
				$k=strtoupper($field_array[$k]);
				
				$new_text.=$k."\n".$v."\n\n";
				}
			
			}

	pdf_show_boxed($pdf,$new_text,53,$box_top,$width,$box_height,$just,"");
	
// Finish the page 11
	pdf_end_page ($pdf);
	
	$new_text=substr($text,-$test);
	if(strpos($new_text,"CATEGORY 1")>0){break;}

	pdf_begin_page ($pdf, PAGE_WIDTH, PAGE_HEIGHT);
	
		
$arial = PDF_load_font ($pdf, $path."fonts/Arial", "winansi", "");
$arialBold = PDF_load_font ($pdf, $path."fonts/arial_bold", "winansi", "");
$times = PDF_load_font ($pdf, $path."fonts/Times_New_Roman", "winansi", "");
$verdanaItalic = PDF_load_font ($pdf, $path."fonts/Verdana_Italic", "winansi", "");
		
		pdf_setfont ($pdf, $times, 12);
		pdf_set_value($pdf,'leading',14);
		
		$box_height=720;
		$box_top=60;
		
$test=pdf_show_boxed($pdf,$new_text,53,$box_top,$width,$box_height,$just,$feature);

//	pdf_show_xy($pdf,$test,553,300);
while(pdf_show_boxed($pdf,$new_text,53,$box_top,$width,$box_height,$just,$feature)<$test)
			{
			foreach($array as $k=>$v)
				{
				if(in_array($k,$skip)){continue;}
				$field=$k;
				$k=strtoupper($field_array[$k]);
				
				$new_text.=$k."\n".$v."\n\n";
				}
			
			}

	pdf_show_boxed($pdf,$new_text,53,$box_top,$width,$box_height,$just,"");
	
// Finish the page 12
	pdf_end_page ($pdf);
	}// Finish the multi_page PDF

	

// Close the PDF
pdf_close ($pdf);

// exit;

// Send the PDF to the browser.
$buffer = pdf_get_buffer ($pdf);
header ("Content-type: application/pdf");
header ("Content-Length: " . strlen($buffer));
$header="Content-Disposition: inline; filename=".$ARRAY[0]['f_year']."_annual_report_".$ARRAY[0]['park_code'].".pdf";
header ($header);
echo $buffer;

// Free the resources
pdf_delete ($pdf);

?>