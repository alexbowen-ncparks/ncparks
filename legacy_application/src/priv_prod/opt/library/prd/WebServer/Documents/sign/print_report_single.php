<?php 
//echo "<pre>"; print_r($_POST); echo "</pre>";  exit;
ini_set('display_errors',1);
include("../../include/get_parkcodes_i.php");// database connection parameters

extract($_REQUEST);
include("../../include/iConnect.inc");// database connection parameters
$database="sign";
$db = mysqli_select_db($connection,$database)
       or die ("Couldn't select database $database");

// Get data

$sql="SELECT *
FROM  category where 1"; //echo "$sql";
$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql ");
 while($row=mysqli_fetch_assoc($result))
 {
 $cat_array[$row['id']]=$row['name'];
 }
//print_r($cat_array); exit;

$sql="SELECT *
FROM  sign_list_1 where id=$id"; //echo "$sql";
$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql ");
 
$row=mysqli_fetch_assoc($result);

//echo "<pre>"; print_r($row);  print_r($cat_array); echo "</pre>";  exit;

extract($row);

define ("PAGE_WIDTH", 612); // 8.5 inches
define ("PAGE_HEIGHT",792); // 11 inches
define ("FONT_SIZE",12); 

// Create the Page.	
$pdf = pdf_new(); include("/opt/library/prd/WebServer/include/pdf_key_23.php");
pdf_open_file ($pdf, "");

// Set the different PDF values.
pdf_set_info ($pdf, "Author", "Tom Howard");
pdf_set_info ($pdf, "Title", "NC Sign Database");
pdf_set_info ($pdf, "Creator", "See Author");

// Set the fonts
$path="/opt/library/prd/WebServer/Documents/inc/fonts";
$times = PDF_load_font ($pdf, $path."/Times_New_Roman", "winansi","");
$verdanaItalic = PDF_load_font ($pdf, $path."/Verdana_Italic", "winansi","");
$arial = PDF_load_font ($pdf, $path."/Arial", "winansi","");
$arialBold = PDF_load_font ($pdf, $path."/arial_bold", "winansi","");

// Create the pages.
	pdf_begin_page ($pdf, PAGE_WIDTH, PAGE_HEIGHT);
	

$skip=array("id","register","other_file_1","other_file_2","response","cr_form","PASU_approv","date_of_request","approv_BPA","staff_notify");


	//*********
	// Add Header
	pdf_setfont ($pdf, $arial, 14);
	$x=53;
	$y=750;
	$text="NC DIVISION OF PARKS AND RECREATION ";
		pdf_show_xy ($pdf,$text,190,$y);
	$y=730;
	$park=strtoupper($location);
	$text="Sign Request for ".$parkCodeName[$park];
		pdf_show_xy ($pdf,$text,$x,$y);
		
	$text="District: ".$district;
		pdf_show_xy ($pdf,$text,480,$y);
	pdf_setfont ($pdf, $times, 12);
	$y=714;
	$text="Submitted on ".$date_of_request;
		pdf_show_xy ($pdf,$text,$x,$y);
	
	
	$text="";
	
	$field_array=array("dpr"=>"Sign Request Number","status"=>"Status","location"=>"Park Code","district"=>"District","email"=>"
	Contact Info","delivery_address"=>"Delivery Address","date_needed"=>"Date Needed","category"=>"Category","new_replace"=>"New or Replacement","quantity"=>"Quantity","sign_size"=>"Size of Sign","background_color"=>"Background Color","letter_color"=>"Letter Color","letter_size"=>"Letter Size","sign_type"=>"Sign Type","purpose"=>"Description of Sign","approv_DISU"=>"DISU approved","approv_PIO"=>"PIO Approved","approv_CHOP_DIR"=>"CHOP and Director Approved","comments"=>"Comments");
	
	$category_array=array("1"=>"Park Entrance Sign","2"=>"Non-standard Sign","3"=>"Standard Sign");
	
		pdf_setfont ($pdf, $times, 12);
	$y=714;
	$text=$dpr;
		pdf_show_xy ($pdf,$text,500,$y+55);
	
	if(!isset($delivery_address)){$delivery_address="";}
	$text="Delivery Address: ".$delivery_address;
		pdf_show_xy ($pdf,$text,200,$y);
	
	$y-=16;
	$text="Contact Info: ".$email;
	pdf_show_xy ($pdf,$text,$x,$y);
	
	$text="Type of Sign: ".$sign_type;
	pdf_show_xy ($pdf,$text,$x+325,$y);
	
	$y-=16;
	$text="Date Needed: ".$date_needed;
	pdf_show_xy ($pdf,$text,$x,$y);
	
	$y-=16;
	if(is_integer(($category*1)))
		{
		$text="Category: ".$cat_array[$category];
		}
		else
		{
		$new_cat=str_replace("3.","Standard Sign (no approval required) ==> ",$category);
		$text="Category: ".$new_cat;
		}	
	pdf_show_xy ($pdf,$text,$x,$y);
	
	$y-=16;
	$text="New or Replacement: ".$new_replace;
	pdf_show_xy ($pdf,$text,$x,$y);
	
	
	$y-=16;
	$text="Size: ".$sign_size;
	pdf_show_xy ($pdf,$text,$x,$y);
	
	$text="Quantity: ".$quantity;
	pdf_show_xy ($pdf,$text,$x+400,$y-50);
	
	$y-=16;
	$text="Background Color: ".$background_color;
	pdf_show_xy ($pdf,$text,$x,$y);
	
	$y-=16;
	$text="Letter Color: ".$letter_color;
	pdf_show_xy ($pdf,$text,$x,$y);
	
	$y-=16;
	$text="Source: ".$source;
	pdf_show_xy ($pdf,$text,$x,$y);
	
// Justification	
	$text="Justification: ".$outside_vendor_details;
	$width=500;
		$just="left";
		$feature="blind";
		$box_height=520;
		$box_top=60;
		
		pdf_setfont ($pdf, $times, 12);
		pdf_set_value($pdf,"leading",14);
	$test=pdf_show_boxed($pdf,$text,53,$box_top,$width,$box_height,$just,$feature);
	if($test<1)
		{
		pdf_show_boxed($pdf,$text,53,$box_top,$width,$box_height,$just,"");
		}
	
// Purpose	
	$text="Sign Text:\n".$purpose;
	$width=500;
		$just="left";
		$feature="blind";
		$box_height=470;
		$box_top=10;
		
		pdf_setfont ($pdf, $times, 12);
	//	pdf_set_value($pdf,leading,14);
	$test=pdf_show_boxed($pdf,$text,53,$box_top,$width,$box_height,$just,$feature);
	if($test<1)
		{
		pdf_show_boxed($pdf,$text,53,$box_top,$width,$box_height,$just,"");
		}

// Comments	
	$text="Comments - ".$comments;
	if(!empty($approv_DISU)){$text.="\nDISU: ".$approv_DISU;}ELSE{$text.="\nDISU: no approval date";}
	if(!empty($approv_PIO)){$text.="\nPIO: ".$approv_PIO;}else{$text.="\nPIO: no approval date";}
	$width=500;
		$just="left";
		$feature="blind";
		$box_height=300;
		$box_top=5;
		
		$font=12;
		pdf_setfont ($pdf, $times, $font);
		pdf_set_value($pdf,"leading",($font+2));
	$test=pdf_show_boxed($pdf,$text,53,$box_top,$width,$box_height,$just,$feature);
	while($test> 0)
		{
		$i++;
		pdf_setfont ($pdf, $times, $font-$i);
		pdf_set_value($pdf,leading,($font+2)-$i);
		$test=pdf_show_boxed($pdf,$text,53,$box_top,$width,$box_height,$just,$feature);
		}
	pdf_show_boxed($pdf,$text,53,$box_top,$width,$box_height,$just,"");
	

$font=10;
pdf_setfont ($pdf, $arialBold, $font);

	for($i=0;$i<70;$i++)
		{@$line.=" - ";}
	pdf_show_xy ($pdf,$line,5,30);
	
	$text=$parkCodeName[$park];
	pdf_show_xy ($pdf,$text,$x,15);

	pdf_show_xy ($pdf,$email,300,15);
	
	pdf_show_xy ($pdf,$dpr,500,15);
	
	// Finish the page 1
	pdf_end_page ($pdf);


// Close the PDF
pdf_close ($pdf);

// Send the PDF to the browser.
$buffer = pdf_get_buffer ($pdf);
header ("Content-type: application/pdf");
header ("Content-Length: " . strlen($buffer));
$header="Content-Disposition: inline; filename=".$park."_".$dpr."_Sign_Request.pdf";
header ($header);
echo $buffer;

// Free the resources
pdf_delete ($pdf);

?>