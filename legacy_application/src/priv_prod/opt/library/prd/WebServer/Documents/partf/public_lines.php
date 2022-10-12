<?php
ini_set('display_errors',1);
date_default_timezone_set('America/New_York');

$database="partf";

include("../../include/iConnect.inc");// database connection parameters

$db = mysqli_select_db($connection,$database)
   or die ("Couldn't select database");
   
   
$sql="SELECT *
	from grants
	where `project` not like '%withdrawn%'
	order by county, sponsor, year"; //echo "$sql"; //exit;
	$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql<br /><br />$where");
	while($row=mysqli_fetch_assoc($result))
		{
		$ARRAY[]=$row;
		$array_sponsor[]=$row['sponsor'];
		$array_county[]=$row['county'];
		$array_year[]=$row['year'];
		$array_project[]=$row['project'];
		$array_grant_amount[]=$row['grant_amount'];
		@$array_county_grant_amount[$row['county']]+=$row['grant_amount'];
		$array_local_match[]=$row['local_match'];
		@$array_county_local_match[$row['county']]+=$row['local_match'];
		}

$lines_per_page=29;
$totPageNum=ceil(count($ARRAY)/$lines_per_page);

$width_array=array("sponsor","county","year","project","grant_amount","local_match");

foreach($width_array as $k=>$v)
	{
	$array=${"array_".$v};
	$y="";
	foreach($array as $index=>$value)
		{
		$x=strlen($value);
		if($x>$y)
			{
			$y=$x;
			${"str_len_".$v}=$value;
			//$str_len_sponsor=$value;
			}
		}
	}

//echo "<pre>"; print_r($str_len_sponsor); echo "</pre>"; exit;


// Set the constants and variables.
define ("PAGE_WIDTH", 792); // 11 inches
define ("PAGE_HEIGHT",612); // 8.5 inches

$pdf = PDF_new(); include("/opt/library/prd/WebServer/include/pdf_key_23.php");

/*  open new PDF file; insert a file name to create the PDF on disk */
if (PDF_begin_document($pdf, "", "") == 0)
	{
		die("Error: " . PDF_get_errmsg($pdf));
	}

// Set the different PDF values.
pdf_set_info ($pdf, "Author", "Tom Howard");
pdf_set_info ($pdf, "Title", "NC DPR PARTF Grant Recipients");
pdf_set_info ($pdf, "Creator", "See Author");


// ******************** Start Loop ***************
$start=0;
$pageNum=1;
$index=0;


	// Set the default font from here on out.
$PATH="/opt/library/prd/WebServer/Documents/inc/fonts/";
$arial = PDF_load_font($pdf, $PATH."Arial", "winansi", "");
$arial_bold = PDF_load_font($pdf, $PATH."arial_bold", "winansi", "");


$fontSize=10;
$leading=$fontSize+3;

for($p=0;$p<$totPageNum;$p++)
	{
	// Create the page.
	PDF_begin_page_ext($pdf, PAGE_WIDTH, PAGE_HEIGHT, "");


	pdf_setfont ($pdf, $arial, $fontSize);
			
	$verStart=PAGE_HEIGHT-60;
	$ver=$verStart;
	$hor=16;
	$add_hor=16;
//	$hor=$hor+$add_hor;
	$rr=0;
	
//pdf_setcolor($pdf, "both", "rgb", 0.8, 0.8, 0.8, 0.8);
//pdf_rect($pdf, $hor, $ver+23, 750, 18);
//pdf_fill_stroke($pdf);
pdf_setcolor($pdf, "both", "rgb", 0, 0, 0, 0);

pdf_setfont ($pdf, $arial_bold, 14);
$text="NC Parks and Recreation Trust Fund Local Government Grant Recipients by County";
pdf_show_xy($pdf,$text,135, 583);

pdf_setfont ($pdf, $arial_bold, 11);
$text="County";
pdf_show_xy($pdf,$text,21, 565);  
$text="Sponsor";
pdf_show_xy($pdf,$text,80, 565);  
$text="Year";
pdf_show_xy($pdf,$text,223, 565);  
$text="Project";
pdf_show_xy($pdf,$text,330, 565);  
$text="Grant Amount";
pdf_show_xy($pdf,$text,556, 565);  
$text="Local Match";
pdf_show_xy($pdf,$text,640, 565);  
$text="Total";
pdf_show_xy($pdf,$text,720, 565);  

$text="";
pdf_setfont ($pdf, $arial, $fontSize);
// *********** Start Records from Arrays ************
	
if($totPageNum>1)
	{
	if($p==0)
		{
		$end=$start+7;
		$r=0;
		}
		else
		{
		@$numLines=$numLines-$start;
		$end=$start+$numLines;
		}
	}
	else
	{
	@$end=$numLines;
	$r=0;
	}

$r=0;	
for($xx=0;$xx<$lines_per_page;$xx++)
	{
	$hor=16;
	
	@$var_1=$ARRAY[$index]['county'];
	@$var_2=$ARRAY[$index]['sponsor'];
	@$var_3=$ARRAY[$index]['year'];
	@$var_4=$ARRAY[$index]['project'];
	@$var_5=$ARRAY[$index]['grant_amount'];
	@$var_6=$ARRAY[$index]['local_match'];
	@$var_7=($ARRAY[$index]['grant_amount']+$ARRAY[$index]['local_match']);

	if(isset($var_1))
		{
		$text=$var_1;			
		pdf_show_xy($pdf,$text,$hor,$ver);
		}
	$text=$var_2;
	$hor+=pdf_stringwidth($pdf, $str_len_county, $arial, $fontSize)+2;
		pdf_show_xy($pdf,$text,$hor,$ver);
	
	$text=$var_3;
	$hor+=pdf_stringwidth($pdf, $str_len_sponsor, $arial, $fontSize)+6;
		pdf_show_xy($pdf,$text,$hor,$ver);
	
	$text=$var_4;
	$hor+=pdf_stringwidth($pdf, $str_len_year, $arial, $fontSize)+10;
		pdf_show_xy($pdf,$text,$hor,$ver);
		
	if($var_5>0)
		{ // grant amount
		$text=number_format($var_5,0);
		$sl=strlen($var_5);
		$plus=0;
		if($sl==4){$plus=21;}
		if($sl==5){$plus=15;}
		if($sl==6){$plus=9;}
		$hor+=pdf_stringwidth($pdf, $str_len_project, $arial, $fontSize)+18;
		$pass_hor_grant_amount=$hor;
		$print_hor=$hor+$plus;
			pdf_show_xy($pdf,$text,$print_hor,$ver);
		}
	
	if($var_6>0)
		{// local match
		$text=number_format($var_6,0);
		$sl=strlen($var_6);
		$plus=0;
		if($sl==4){$plus=21;}
		if($sl==5){$plus=15;}
		if($sl==6){$plus=9;}
		$hor+=pdf_stringwidth($pdf, $str_len_grant_amount, $arial, $fontSize)+27;
		$pass_hor_local_match=$hor;
		$print_hor=$hor+$plus;
			pdf_show_xy($pdf,$text,$print_hor,$ver);
		}
	
	if($var_7>0)
		{// grant total
		$text=number_format($var_7,0);
		$sl=strlen($var_7);
		$plus=0;
		if($sl==4){$plus=21;}
		if($sl==5){$plus=15;}
		if($sl==6){$plus=9;}
		$hor+=pdf_stringwidth($pdf, $str_len_local_match, $arial, $fontSize)+25;
		$pass_hor_grand=$hor;
		$print_hor=$hor+$plus;
			pdf_show_xy($pdf,$text,$print_hor,$ver);
		}	
	
	if(isset($ARRAY[$index+1]))
		{
		if($ARRAY[$index+1]['county']!=$var_1)
			{
			pdf_setcolor($pdf, "both", "rgb", 0.8, 0.8, 0.8, 0.8);
			pdf_rect($pdf, 16,$ver-16, 740, 13);
			pdf_fill_stroke($pdf);
			pdf_setcolor($pdf, "both", "rgb", 0, 0, 0, 0);
			
			$num_county++;
			$text=$var_1." Totals for $num_county grants";
			$ver=$ver-$leading;
			pdf_setfont ($pdf, $arial_bold, $fontSize);
			pdf_show_xy($pdf,$text,40,$ver);
			$text=$array_county_grant_amount[$ARRAY[$index]['county']];
			$num_county=0;
			$county_grand=$text;
			$sl=strlen($text);
			$plus=0;
			if($sl==4){$plus=21;}
			if($sl==5){$plus=15;}
			if($sl==6){$plus=9;}
			pdf_show_xy($pdf,number_format($text,0),$pass_hor_grant_amount+$plus,$ver);
			$text=$array_county_local_match[$ARRAY[$index]['county']];
				
			$sl=strlen($text);
			$plus=0;
			if($sl==4){$plus=21;}
			if($sl==5){$plus=15;}
			if($sl==6){$plus=9;}
				$county_grand+=$text;
			pdf_show_xy($pdf,number_format($text,0),$pass_hor_local_match+$plus,$ver);
				
			
			$sl=strlen($county_grand);
			$plus=0;
			if($sl==4){$plus=21;}
			if($sl==5){$plus=15;}
			if($sl==6){$plus=9;}	
			if($sl==8){$plus=-5;}	pdf_show_xy($pdf,number_format($county_grand,0),$pass_hor_grand+$plus,$ver);
				
			pdf_setfont ($pdf, $arial, $fontSize);
			$xx--;
			}
			else
			{
			@$num_county++;
			}
		}
	
	$start++;
	$index++;
	$ver=$ver-$leading;
	}// end for
	
	
	$date=date('Y-m-d');
	$text="Printed on $date";
	pdf_setfont ($pdf, $arial, 8);
	pdf_show_xy($pdf,$text,650,15);
	pdf_setfont ($pdf, $arial, $fontSize);
			
	// Finish the page
	PDF_end_page_ext($pdf, "");
	
	$pageNum++;
	
	}
PDF_end_document($pdf, "");

$buf = PDF_get_buffer($pdf);
$len = strlen($buf);

header("Content-type: application/pdf");
header("Content-Length: $len");
header("Content-Disposition: inline; filename=NC_DPR_PARTF_Grant_Recipients.pdf");
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