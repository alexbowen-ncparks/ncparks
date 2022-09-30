<?php 
echo "print_report.php<pre>"; print_r($_POST); echo "</pre>";  exit;

include("../../include/parkcodesDiv.inc");// database connection parameters

extract($_REQUEST);
$database="annual_report";
include("../../include/iConnect.inc");// database connection parameters
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

$field_array=array("budget"=>"Budget","personnel"=>"Personnel","training_admin"=>"Administrative Training","visitation"=>"Visitation","revenue"=>"Revenue Generation","pac"=>"Park Advisory Committee","other_cat_1"=>"Other Park Admin.","object_1"=>"Objectives/Needs-PA","facility"=>"Operation of Facilities","maintenance"=>"Maintenance","major_main"=>"Major Maintenance","cip"=>"CIP","volunteer"=>"Volunteers","work_program"=>"Work Programs","sustain"=>"Sustainability","other_cat_2"=>"Other Park Operations","object_2"=>"Objectives/Needs-PO","land_protect"=>"Land Protection","threat"=>"Threats to park's natural resources","invasive"=>"Invasive species management","fire"=>"Prescribed fire/wildland fire control","boundary"=>"Boundary Management","other_cat_3"=>"Other Natural Resources","object_3"=>"Objectives/Needs-NR","exhibit"=>"Exhibits","programs"=>"Programs","outreach"=>"Outreach","training_ie"=>"Training","other_cat_4"=>'Other Interpretation & Education',"object_4"=>"Objectives/Needs-IE","le"=>"Law Enforcement Program","safety"=>"Safety Program","sar"=>"SAR","ems"=>"EMS/Accidents","other_cat_5"=>"Other Protection & Safety","object_5"=>"Objectives/Needs-PS");

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

		$arial = pdf_findfont ($pdf, "fonts/Arial.1", "winansi");
		$arialBold = pdf_findfont ($pdf, "fonts/Arial_Bold", "winansi");
		$times = pdf_findfont ($pdf, "fonts/Times_New_Roman", "winansi");
		$verdanaItalic = pdf_findfont ($pdf, "fonts/Verdana_Italic", "winansi");
		
// Create the pages.

$skip=array("id","park_code","pasu","f_year");
foreach($ARRAY as $num=>$array)
	{
	
	pdf_begin_page ($pdf, PAGE_WIDTH, PAGE_HEIGHT);
	
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
	
		
	pdf_set_value($pdf,leading,14);
	
	$text="";
		$box_height=14;
		$box_top=580;
		$texty=580;
		$i=0;
	foreach($array as $k=>$v)
		{
		if(in_array($k,$skip)){continue;}
		$i++;
		$j++;
		$field=$k;
		$k=strtoupper($field_array[$k]);
		
		$text=$k."\n".$v."\n\n";
		$width=500;
		$just="left";$feature="blind";
		$box_height=14;
		$bottom=$texty;
	pdf_set_value($pdf,leading,14);
	while (pdf_show_boxed($pdf,$text,53,$box_top,$width,$box_height,$just,$feature)>0)
		{
		$box_height+=14;
		
			}
	
			if($box_height>$bottom)
				{
			pdf_end_page ($pdf);
			pdf_begin_page ($pdf, PAGE_WIDTH, PAGE_HEIGHT);
			
			pdf_setfont ($pdf, $times, 12);
			pdf_set_value($pdf,leading,14);
			
			$box_height=14;
			$box_top=465;
			$texty=465;
			$i=1;
		
	//	$text=$k." $texty $box_height $bottom\n".$v."\n\n";
			if(array_key_exists($field,$cat_array))
				{
				$k=$cat_array[$field]."\n".$k;
				$j=1;
				}
			$text=$k."\n".$v."\n\n";
	
		$text="\n".$text;
			while (pdf_show_boxed($pdf,$text,53,$box_top,$width,$box_height,$just,$feature)>0)
				{
				$box_height+=14;		
				}
	pdf_show_boxed($pdf,$text,53,$box_top,$width,$box_height,$just,"");
	$texty = pdf_get_value($pdf, "texty", 0);
	
}
else
{
			if($i>1)
				{
				$box_top-=$box_height;
				}
//	$text=$k." $texty $box_height $bottom\n".$v."\n\n";
	
	if(array_key_exists($field,$cat_array))
		{
		$k=$cat_array[$field]."\n".$k;
		$j=1;
		}
	$text=$k."\n".$v."\n\n";
	
		$text="\n".$text;
	pdf_show_boxed($pdf,$text,53,$box_top,$width,$box_height,$just,"");
	$texty = pdf_get_value($pdf, "texty", 0);
	
	if($texty<130)
			{
			pdf_end_page ($pdf);
			pdf_begin_page ($pdf, PAGE_WIDTH, PAGE_HEIGHT);
			
			pdf_setfont ($pdf, $times, 12);
			pdf_set_value($pdf,leading,14);
			
	$text="";
		$box_height=14;
		$box_top=750;
		$texty=750;
		$i=1;
			}
		}
	}
	
	
	}// Finish the multi_page PDF

	// Finish the page
	pdf_end_page ($pdf);
	

// Close the PDF
pdf_close ($pdf);

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