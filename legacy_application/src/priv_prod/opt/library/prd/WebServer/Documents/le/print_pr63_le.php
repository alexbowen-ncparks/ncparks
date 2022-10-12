<?php

$level=5;
$tempID="Howard6319";

if($level<1){echo "You do not access to this database.";exit;}
extract($_REQUEST);
include("../../include/get_parkcodes.php");// database connection parameters

$database="le";
include("../../include/connectROOT.inc"); // database connection parameters
$db = mysql_select_db($database,$connection)
       or die ("Couldn't select database $database");

$_POST['id']=$id;

$sql="SELECT t1.*,t2. disposition_desc
FROM pr63 as t1
LEFT JOIN disposition as t2 on t2.disposition_code=t1.disposition
where id='$_POST[id]'";
//  echo "$sql"; exit;
$result = mysql_query($sql) or die ("Couldn't execute query. $sql c=$connection");
$row=mysql_fetch_assoc($result);
extract($row);

$sql="SELECT *
FROM attachment
where ci_num='$ci_num'";
  //echo "$sql"; exit;
$result = mysql_query($sql) or die ("Couldn't execute query. $sql c=$connection");
while($row=mysql_fetch_assoc($result))
	{
	$attachment_array[]=$row;
	}

$sql="SELECT *
FROM le_images
where pr63_id='$_POST[id]'";
  //echo "$sql"; exit;
$result = mysql_query($sql) or die ("Couldn't execute query. $sql c=$connection");
while($row=mysql_fetch_assoc($result))
	{
	$image_array[]=$row;
	}

$sql="SELECT *
FROM involved_person
where ci_id='$_POST[id]'";
  //echo "$sql"; exit;
$result = mysql_query($sql) or die ("Couldn't execute query. $sql c=$connection");
while($row=mysql_fetch_assoc($result))
	{
	$ARRAY[]=$row;
	}
// *************

$pdf = PDF_new(); include("/opt/library/prd/WebServer/include/pdf_key_23.php");

/*  open new PDF file; insert a file name to create the PDF on disk */
if (PDF_begin_document($pdf, "", "") == 0) {
    die("Error: " . PDF_get_errmsg($pdf));
}


// Set the different PDF values.
pdf_set_info ($pdf, "Author", "Tom Howard");
pdf_set_info ($pdf, "Title", "NC DPR PR-63 Database");
pdf_set_info ($pdf, "Creator", "See Author");

PDF_begin_page_ext($pdf, 595, 842, "");
	
//$arial = PDF_load_font ($pdf, $PATH."Arial","winansi","");
$arial = PDF_load_font($pdf, "Helvetica", "winansi", "");

//$arialBold = PDF_load_font ($pdf, $PATH."arial_bold","winansi","");
$arialBold = PDF_load_font($pdf, "Helvetica-Bold", "winansi", "");

//$times = PDF_load_font ($pdf, $PATH."Times_New_Roman", "winansi","");
$times = PDF_load_font ($pdf, "Times-Roman", "winansi","");

//$verdanaItalic = PDF_load_font ($pdf, $PATH."Verdana_Italic", "winansi","");
$verdanaItalic = PDF_load_font ($pdf, "Times-Italic", "winansi","");


pdf_setfont ($pdf, $arial, 14);
$y=760;
$text="NORTH CAROLINA DIVISION OF PARKS AND RECREATION";
	pdf_show_xy ($pdf,$text,110,$y);
$y=744;
pdf_setfont ($pdf, $arialBold, 14);
$text="CASE INCIDENT REPORT";
	pdf_show_xy ($pdf,$text,220,$y);
$text=$ci_num;
	pdf_show_xy ($pdf,$text,520,$y);
	

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
	pdf_show_xy ($pdf,$fld,400,$line_fld);
//$fld="How Reported:";
//	pdf_show_xy ($pdf,$fld,450,$line_fld);
	
pdf_setfont ($pdf, $arialBold, 10);
$text=$incident_code;
	pdf_show_xy ($pdf,$text,50,$line_text);
pdf_setfont ($pdf, $arial, 8);
$text=$incident_name;
	pdf_show_xy ($pdf,$text,50,$line_text-12);

pdf_setfont ($pdf, $arialBold, 10);
$text=$report_address;
	pdf_show_xy ($pdf,$text,400,$line_text-12);	
$text=$report_phone;
	pdf_show_xy ($pdf,$text,400,$line_text-24);

$text=$report_by;
	pdf_show_xy ($pdf,$text,400,$line_text);	
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

// Involved Person
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
	pdf_show_xy ($pdf,"Details of Incident:",50,$texty-25);
	foreach($attachment_array as $index=>$array)
		{
		$var=$array['link'];
		$link="http://www.dpr.ncparks.gov/le/".$var;
	$starting_xpos = 50;
	$starting_ypos = $texty-35;
//	$file=$array['title']; 
	$file=$link; 
	$len=(100+strlen($file));
	pdf_show_xy ($pdf,$file,$starting_xpos+$xx+2,$starting_ypos-7);
	$url = PDF_create_action($pdf, "URI", "url=$link"); 
  	PDF_create_annotation ($pdf, $starting_xpos+$xx, $starting_ypos, $starting_xpos+100+$xx, $starting_ypos-10, "Link", "linewidth=1 action {activate $url}"); 
	$xx=$xx+$len;

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
		$link="http://www.dpr.ncparks.gov/le/".$var;
	$starting_xpos = 50;
	$starting_ypos = $texty-35-$xx;
//	$file=$array['title']; 
	$file=$link; 
	$len=(100+strlen($file));
	pdf_show_xy ($pdf,$file,$starting_xpos,$starting_ypos-14);
	$url = PDF_create_action($pdf, "URI", "url=$link"); 
  	PDF_create_annotation ($pdf, $starting_xpos+$xx, $starting_ypos, $starting_xpos+100+$xx, $starting_ypos-10, "Link", "linewidth=1 action {activate $url}"); 
	$xx=$xx-12;

		}
	}

// Add Footer
$y=75;
	if(empty($pasu_approve)){$app="has not approved";}else{$app="has approved";}
	pdf_show_xy ($pdf,"Park Superintendent $app:",50,$y-3);
	if(empty($dist_approve)){$app="has not approved";}else{$app="has approved";}
	pdf_show_xy ($pdf,"District Superintendent $app:",340,$y-3);
	
//	pdf_show_xy ($pdf,"$pass_pasu_name",50,$y-18);
if(!empty($pass_disu_name))
	{
	pdf_show_xy ($pdf,"$pass_disu_name",340,$y-18);
	}

	$exp=explode("*",$pasu_approve);  //echo "<pre>"; print_r($exp); echo "</pre>";  exit;
		$yy=$y-15;
	foreach($exp as $k1=>$v1)
		{
		$exp1=explode("=",$v1); //echo "<pre>"; print_r($exp1); echo "</pre>";  exit;
		$p=$exp1[0];
		$d=$exp1[1];
	pdf_show_xy ($pdf,"$p $d",50,$yy);
			$yy-=12;
		}
	pdf_show_xy ($pdf,"Date: $dist_approve",340,$y-33);


PDF_end_page_ext($pdf, "");

PDF_end_document($pdf, "");

$buf = PDF_get_buffer($pdf);
$len = strlen($buf);

header("Content-type: application/pdf");
header("Content-Length: $len");
header("Content-Disposition: inline; filename=hello.pdf");
print $buf;

PDF_delete($pdf);


?>