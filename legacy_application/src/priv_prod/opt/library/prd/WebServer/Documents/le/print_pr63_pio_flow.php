<?php 
//echo "<pre>"; print_r($_POST); echo "</pre>";  exit;
ini_set('display_errors',1);

//echo "<pre>"; print_r($_SESSION); echo "</pre>";  //exit;

//$level=$_SESSION['le']['level'];
//$tempID=$_SESSION['le']['tempID'];
//if($level<1){echo "You do not access to this database.";exit;}
extract($_POST);
include("../../include/get_parkcodes_dist.php");// database connection parameters

$database="le";
// include("../../include/connectROOT.inc"); // database connection parameters
mysqli_select_db($connection,$database)
       or die ("Couldn't select database $database");

$sql="SELECT t1.*,t2. disposition_desc
FROM pr63_pio as t1
LEFT JOIN disposition as t2 on t2.disposition_code=t1.disposition
where id='$_POST[id]'";
//   echo "$sql"; exit;
$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql");
$row=mysqli_fetch_assoc($result);
extract($row);

$sql="SELECT *
FROM attachment_pio
where ci_num='$ci_num'";
  //echo "$sql"; exit;
$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql");
while($row=mysqli_fetch_assoc($result))
	{
	$attachment_array[]=$row;
	}

$sql="SELECT *
FROM le_images_pio
where pr63_id='$_POST[id]'";
  //echo "$sql"; exit;
$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql");
while($row=mysqli_fetch_assoc($result))
	{
	$image_array[]=$row;
	}

$sql="SELECT *
FROM involved_person_pio
where ci_id='$_POST[id]'";
  //echo "$sql"; exit;
$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql");
while($row=mysqli_fetch_assoc($result))
	{
	$ARRAY[]=$row;
	}
//echo "<pre>"; print_r($ARRAY); echo "</pre>";  exit;
		
		
define ("PAGE_WIDTH", 612); // 8.5 inches
define ("PAGE_HEIGHT",792); // 11 inches

// Create the Page.	
$pdf = pdf_new(); include("/opt/library/prd/WebServer/include/pdf_key_23.php");
pdf_open_file ($pdf, "");

// Set the different PDF values.
pdf_set_info ($pdf, "Author", "Tom Howard");
pdf_set_info ($pdf, "Title", "NC DPR PR-63 Database");
pdf_set_info ($pdf, "Creator", "See Author");

// Create the page.

pdf_begin_page ($pdf, PAGE_WIDTH, PAGE_HEIGHT);


		// Set the fonts
$PATH="/opt/library/prd/WebServer/Documents/inc/fonts/";
		
$arial = PDF_load_font ($pdf, $PATH."Arial","winansi","");
$arialBold = PDF_load_font ($pdf, $PATH."arial_bold","winansi","");
$times = PDF_load_font ($pdf, $PATH."Times_New_Roman", "winansi","");
$verdanaItalic = PDF_load_font ($pdf, $PATH."Verdana_Italic", "winansi","");
		
//*********
// Add Header
pdf_setfont ($pdf, $arial, 14);
$y=760;
$text="NORTH CAROLINA DIVISION OF PARKS AND RECREATION";
	pdf_show_xy ($pdf,$text,110,$y);
$y=744;
pdf_setfont ($pdf, $arialBold, 14);
$text="CASE INCIDENT REPORT";
	pdf_show_xy ($pdf,$text,220,$y);
	
$text=$ci_num;
	pdf_show_xy ($pdf,$text,480,$y-12);
	
$text="Case Incident Number";
pdf_setfont ($pdf, $arial, 14);
	pdf_show_xy ($pdf,$text,440,$y);


//  744-18=  726

// Line 1
$y=720;
$line_fld=$y;
$line_text=$y-12;

pdf_setfont ($pdf, $arial, 10);
//$fld="CI Number:";
//	pdf_show_xy ($pdf,$fld,50,$line_fld);
$fld="Park Code:";
	pdf_show_xy ($pdf,$fld,50,$line_fld);	
$fld="Incident Date & Time:";
	pdf_show_xy ($pdf,$fld,113,$line_fld);
$fld="Call Out:";
	pdf_show_xy ($pdf,$fld,250,$line_fld);
$fld="Incident Location:";
	pdf_show_xy ($pdf,$fld,300,$line_fld);	
	
pdf_setfont ($pdf, $arialBold, 10);
$text=$parkcode;
	pdf_show_xy ($pdf,$text,50,$line_text);
$text=$day_week.", ".$date_occur." @ ".$time_occur;
	pdf_show_xy ($pdf,$text,113,$line_text);
if(empty($call_out))
	{
	$text="No";
	}
	else
	{
	$text="Yes";
	}
	pdf_show_xy ($pdf,$text,270,$line_text);

$text=$location_code." - ".$loc_name;
	pdf_show_xy ($pdf,$text,300,$line_text);
	
// Line 2
$y=670;
$line_fld=$y;
$line_text=$y-12;
pdf_setfont ($pdf, $arial, 10);
$fld="Incident Code:";
	pdf_show_xy ($pdf,$fld,50,$line_fld);
$fld="Reported by:";
	pdf_show_xy ($pdf,$fld,400,$line_fld+22);
$texty=PDF_get_value($pdf,"texty",0);

pdf_setfont ($pdf, $arialBold, 10);
$text=$incident_code;
	pdf_show_xy ($pdf,$text,50,$line_text);
pdf_setfont ($pdf, $arial, 8);
$text=$incident_name;
	pdf_show_xy ($pdf,$text,50,$line_text-12);

pdf_setfont ($pdf, $arialBold, 10);
$text=$report_by;
	pdf_show_xy ($pdf,$text,400,$texty-13);
	
$texty=PDF_get_value($pdf,"texty",0);
$text=$report_address;
//	pdf_show_xy ($pdf,$text,400,$line_text-12);
	PDF_show_boxed ($pdf,$text,400,$texty-155,160,155,"left","");

$texty=pdf_get_value($pdf,"texty",0);	
$text=$report_phone;
	pdf_show_xy ($pdf,$text,400,$texty-12);

//$text=$report_how;
//	pdf_show_xy ($pdf,$text,450,$line_text);		

// Line 3
$y=610;
$line_fld=$y;
$line_text=$y-12;
pdf_setfont ($pdf, $arial, 10);
$fld="Received by:";
	pdf_show_xy ($pdf,$fld,50,$line_fld);
$fld="Received on:";
	pdf_show_xy ($pdf,$fld,170,$line_fld);
$fld="Completed on:";
	pdf_show_xy ($pdf,$fld,270,$line_fld);
$fld="Completed by:";
	pdf_show_xy ($pdf,$fld,370,$line_fld);
	
pdf_setfont ($pdf, $arialBold, 10);
$text=$report_receive;
	pdf_show_xy ($pdf,$text,50,$line_text);
$text=$report_receive_date." @ ".$report_receive_time;
	pdf_show_xy ($pdf,$text,170,$line_text);
$text=$report_investigate_date." @ ".$report_investigate_time;
	pdf_show_xy ($pdf,$text,270,$line_text);	
$text=$investigate_by;
	//if($badge_num){$text.=" - Badge No.: ".$badge_num;}
	pdf_show_xy ($pdf,$text,370,$line_text);	

// Line 4
$y=560;
$line_fld=$y;
$line_text=$y-12;
pdf_setfont ($pdf, $arial, 10);
$fld="Weather:";
	pdf_show_xy ($pdf,$fld,50,$line_fld);
$fld="Cleared date & time:";
	pdf_show_xy ($pdf,$fld,170,$line_fld);
$fld="Disposition:";
	pdf_show_xy ($pdf,$fld,270,$line_fld);
	
pdf_setfont ($pdf, $arialBold, 10);
$text=$weather;
	pdf_show_xy ($pdf,$text,50,$line_text);
$text=$clear_date." @ ".$clear_time;
	pdf_show_xy ($pdf,$text,170,$line_text);		
$text=$disposition." - ".$disposition_desc;
	pdf_show_xy ($pdf,$text,270,$line_text);

// Involved Person
	
$text="Involved Person(s)";
	pdf_show_xy ($pdf,$text,50,510);
if(isset($ARRAY))
	{
	$skip=array("id","ci_id","row_num");
	$space=array("Name"=>"130","Address"=>"195","Phone"=>"75","Sex"=>"26","Race"=>"40","Age"=>"65","DOB"=>"55");
	$space_2=array("Name"=>"50","Address"=>"175","Phone"=>"370","Sex"=>"450","Race"=>"478","Age"=>"570","DOB"=>"508");
	
	$y=520;
	foreach($ARRAY AS $num=>$array)
		{
		if(!isset($array)){continue;}
		$line_x=50;
		$line_v=50;
		$y-=28;
			if($num==0)
				{
				// Header
				foreach($array AS $header=>$var)
					{
					if(in_array($header,$skip)){continue;}
					$text=$header;
					pdf_show_xy ($pdf,$text,$line_x,$y);	
					if($space[$header]>0)
						{
						$line_x+=$space[$header];}
					else{$line_x+=75;}
					}
				$line_x=50; $y-=28;
				}
		foreach($array as $fld=>$val)
			{
			// Values
			if(in_array($fld,$skip)){continue;}
			$text=$val;
			If($text==""){continue;}
			$add=0;
			if($fld=="Name"){$add=75;}
			if($fld=="Phone"){$line_x=75;}
			if($fld=="Race" || $fld=="Sex"){$text="  ".$text;}
			if($fld=="Age"){$text=" ".$text;}
			$line_v=$space_2[$fld];
			PDF_show_boxed ($pdf,$text,$line_v,$y,$line_x+$add,28,"left","");
			$line_x+=$space[$fld];
			}
		}
	}

pdf_setfont ($pdf, $arial, 10);	
$texty = pdf_get_value($pdf, "texty", 0);

//PDF_show_boxed ( resource $p , string $text , float $left , float $top , float $width , float $height , string $mode , string $feature )

if(!empty($attachment_array))
	{
	$xx=0;
	$yy=0;
	pdf_show_xy ($pdf,"Details of Incident:",50,$texty-25);
	foreach($attachment_array as $index=>$array)
		{
		$var=$array['link'];
		$link="http://www.dpr.ncparks.gov/le/".$var;
	$starting_xpos = 50;
	$starting_ypos = $texty-35-$yy;
//	$file=$array['title']; 
	$file=$link; 
	$len=(100+strlen($file));
	pdf_show_xy ($pdf,$file,$starting_xpos,$starting_ypos-7);
	$url = PDF_create_action($pdf, "URI", "url=$link"); 
  	PDF_create_annotation ($pdf, $starting_xpos, $starting_ypos, $starting_xpos+100, $starting_ypos-10, "Link", "linewidth=1 action {activate $url}"); 
	$xx=$xx+$len;
	$yy+=12;
		}
	}

$texty = pdf_get_value($pdf, "texty", 0);

$text="\n".$details;
//PDF_show_boxed ($pdf,$text,50,$texty-350,500,300,"left","");
$n=PDF_show_boxed ($pdf,$text,50,$texty-375,500,350,"left","blind");
if($n>1)
{echo "$n Your detail is too large to print on this page. Please reduce the size of the detail section and attach a file with the complete details to the Case Incident Report.";exit;}
		else
		{PDF_show_boxed ($pdf,$text,50,$texty-375,500,350,"left","");}		


$texty = pdf_get_value($pdf, "texty", 0);
if(!empty($image_array))
	{
	$xx=0;
	pdf_show_xy ($pdf,"Images:",50,$texty-25);
	foreach($image_array as $index=>$array)
		{
		$var=$array['link'];
		$link="https://10.35.152.9/le/".$var;
		$link="https://10.35.152.9/le/".$var;
	$starting_xpos = 80;
	$mod_y=(count($image_array)+1)*12;
	$starting_ypos = $texty-$mod_y-$xx;
//	$file=$array['title']; 
	$file=$link; 
	$len=(100+strlen($file));
	pdf_show_xy ($pdf,$file,$starting_xpos,$starting_ypos-14);
	$url = PDF_create_action($pdf, "URI", "url=$link"); 
  	PDF_create_annotation ($pdf, $starting_xpos, $starting_ypos-5, $starting_xpos+100+$xx, $starting_ypos-15, "Link", "linewidth=1 action {activate $url}"); 
	$xx=$xx-12;

		}
	}

// Add Footer
pdf_setfont ($pdf, $arial, 8);	
$y=75;
	if(empty($pasu_approve)){$app="has not approved";}else{$app="has approved";}
	pdf_show_xy ($pdf,"Park Superintendent $app:",50,$y-3);
	if(empty($dist_approve)){$app="has not approved";}else{$app="has approved";}
	pdf_show_xy ($pdf,"District Superintendent $app:",300,$y-3);
	
//	pdf_show_xy ($pdf,"$pass_pasu_name",50,$y-18);
	pdf_show_xy ($pdf,"$pass_disu_name",300,$y-18);

	$exp=explode("*",$pasu_approve);  
// 	echo "pasu_approve<pre>"; print_r($exp); echo "</pre>";  exit;
		$yy=$y-15;
	foreach($exp as $k1=>$v1)
		{
		$exp1=explode("=",$v1); 
// 		echo "exp1<pre>"; print_r($exp1); echo "</pre>";  exit;
		if(empty($exp1[0]))
			{$p="PASU vacant";}
			else
			{$p=$exp1[0];}
		
		if(empty($exp1[1]))
			{$d="vacant";}
			else
			{$d=$exp1[1];}
		
	pdf_show_xy ($pdf,"$p $d",50,$yy);
			$yy-=12;
		}
	pdf_show_xy ($pdf,"Date: $dist_approve",300,$y-33);

	pdf_show_xy ($pdf,"Raleigh Office Review: $le_approve",480,$y-3);
	if(empty($le_approve)){$app="not yet reviewed";}else{$app="reviewed";}
	pdf_show_xy ($pdf,$app,480,$y-23);
// Finish the page
pdf_end_page ($pdf);


// ***************************************
pdf_begin_page ($pdf, PAGE_WIDTH, PAGE_HEIGHT);

		// Set the fonts
$PATH="/opt/library/prd/WebServer/Documents/inc/fonts/";
		
$arial = PDF_load_font ($pdf, $PATH."Arial","winansi","");
$arialBold = PDF_load_font ($pdf, $PATH."arial_bold","winansi","");
$times = PDF_load_font ($pdf, $PATH."Times_New_Roman", "winansi","");
$verdanaItalic = PDF_load_font ($pdf, $PATH."Verdana_Italic", "winansi","");
		
//*********
// Add Header
pdf_setfont ($pdf, $times, 10);

$y=750;
$line_fld=$y;
$line_text=$y-12;

$fld="PIO Printout $ci_num";
	pdf_show_xy ($pdf,$fld,50,$line_fld+12);	
$line_text=$y-12;
	
$fld="Park Code:";
	pdf_show_xy ($pdf,$fld,50,$line_fld);	
$text=$parkcode;
	pdf_show_xy ($pdf,$text,50,$line_text);

$fld="Incident Date & Time:";
	pdf_show_xy ($pdf,$fld,108,$line_fld);
$text=$day_week.", ".$date_occur." @ ".$time_occur;
	pdf_show_xy ($pdf,$text,108,$line_text);

$fld="Arrest Date & Time:";
	pdf_show_xy ($pdf,$fld,230,$line_fld);

$text=$time_pio_date." @ ".$time_pio_incident;
	pdf_show_xy ($pdf,$text,230,$line_text);
$fld="Incident Location:";
	pdf_show_xy ($pdf,$fld,320,$line_fld);
$text=$location_code." - ".$loc_name;
	pdf_show_xy ($pdf,$text,320,$line_text);
	


$cols=115;
$xcrd=50;
$texty=round(PDF_get_value($pdf,"texty",0),0);
$ycrd=$texty-24;
$xstart=50;
$just="left";

$text="Nature of Incident: ".$nature_of_incident;
text_block($pdf,$text,$cols,$xcrd,$ycrd,$xstart,$just);

$texty=round(PDF_get_value($pdf,"texty",0),0);
$ycrd=$texty-24;
$text="Circumstances surrounding arrest: ".$text_arrest;
text_block($pdf,$text,$cols,$xcrd,$ycrd,$xstart,$just);


$texty=round(PDF_get_value($pdf,"texty",0),0);
$ycrd=$texty-24;
$text="Resistance: ";
$resistance=="Yes"?$text.="Yes\n".$text_resistance:$text.="No";
text_block($pdf,$text,$cols,$xcrd,$ycrd,$xstart,$just);

$texty=round(PDF_get_value($pdf,"texty",0),0);
$ycrd=$texty-24;
$text="Weapon Possession: ";
$weapon_possession=="Yes"?$text.="Yes\n".$text_weapon_possession:$text.="No";
text_block($pdf,$text,$cols,$xcrd,$ycrd,$xstart,$just);

$texty=round(PDF_get_value($pdf,"texty",0),0);

$ycrd=$texty-24;
$text="Weapon Use: ";
$weapon_use=="Yes"?$text.="Yes\n".$text_weapon_possession:$text.="No";
text_block($pdf,$text,$cols,$xcrd,$ycrd,$xstart,$just);

$texty=round(PDF_get_value($pdf,"texty",0),0);
$ycrd=$texty-24;
$text="Pursuit: ";
$pursuit=="Yes"?$text.="Yes\n".$text_pursuit:$text.="No";
text_block($pdf,$text,$cols,$xcrd,$ycrd,$xstart,$just);

$texty=round(PDF_get_value($pdf,"texty",0),0);
if($texty<200)
	{
	pdf_end_page ($pdf);
	pdf_begin_page ($pdf, PAGE_WIDTH, PAGE_HEIGHT);

		// Set the fonts
	$PATH="/opt/library/prd/WebServer/Documents/inc/fonts/";

	$arial = PDF_load_font ($pdf, $PATH."Arial","winansi","");
	$arialBold = PDF_load_font ($pdf, $PATH."arial_bold","winansi","");
	$times = PDF_load_font ($pdf, $PATH."Times_New_Roman", "winansi","");
	$verdanaItalic = PDF_load_font ($pdf, $PATH."Verdana_Italic", "winansi","");

	//*********
	// Add Header
	pdf_setfont ($pdf, $times, 10);

$fld="PIO Printout $ci_num";
	pdf_show_xy ($pdf,$fld,50,780);	
	$cols=115;
	$xcrd=50;
	$ycrd=750;
	$xstart=50;
	$just="left";
	$texty=780;
}


$ycrd=$texty-24;
$text="Description of any items seized in connection with the arrest: ";

// 	pdf_show_xy ($pdf,$text,300,$ycrd);
!empty($text_items)?$text.="\n".$text_items:$text.="None";
text_block($pdf,$text,$cols,$xcrd,$ycrd,$xstart,$just);




function text_block($pdf,$text,$cols,$xcrd,$ycrd,$xstart,$just)
	{
	$font_size=12;  //font size, used to space lines on y axis for Header row
	$tmplines = explode("\n",$text);
	for($j=0;$j<count($tmplines);$j++)
		{
		$tmptxt = explode(" ",$tmplines[$j]);
		$str="";
		for($i=0;$i<count($tmptxt);$i++)
			{
			if($str=="")
				{
				$str=sprintf("%s",$tmptxt[$i]);
				}
				else
				{
				$str=sprintf("%s %s",$str,$tmptxt[$i]);
				}
			if(isset($tmptxt[$i+1]) AND (strlen($str) + strlen($tmptxt[$i+1])) > $cols)
				{
				$ss=10;
				pdf_fit_textline($pdf,$str,$xcrd,$ycrd,"boxsize {".$xstart." $ss} position {".$just." 50}"); // for center
				$str="";
				$ycrd-=$font_size;
				}
			}
		$ss=10;
		pdf_fit_textline($pdf,$str,$xcrd,$ycrd,"boxsize {".$xstart." $ss} position {".$just." 50}");
		$ycrd-=$font_size;
		}
	return $ycrd;
	}
	
pdf_end_page ($pdf);
// Close the PDF
pdf_close ($pdf);
// exit;
// Send the PDF to the browser.
$buffer = pdf_get_buffer ($pdf);
header ("Content-type: application/pdf");
header ("Content-Length: " . strlen($buffer));
header ("Content-Disposition: inline; filename=PR-63.pdf");
echo $buffer;

// Free the resources
pdf_delete ($pdf);

?>