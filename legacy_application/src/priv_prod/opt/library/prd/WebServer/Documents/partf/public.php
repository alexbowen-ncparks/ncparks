<?php
ini_set('display_errors',1);
date_default_timezone_set('America/New_York');

$database="partf";

include("../../include/iConnect.inc");// database connection parameters

$db = mysqli_select_db($connection,$database)
   or die ("Couldn't select database");
   
   
$sql="SELECT *
	from grants
	where 1
	order by county, sponsor, year"; //echo "$sql"; //exit;
	$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql<br /><br />$where");
	while($row=mysqli_fetch_assoc($result))
		{
		$ARRAY[]=$row;
		$array_id[]=$row['id'];
		$array_sponsor[]=$row['sponsor'];
		$array_county[]=$row['county'];
		$array_year[]=$row['year'];
		$array_project[]=$row['project'];
		$array_grant_amount[]=$row['grant_amount'];
		@$array_county_grant_amount[$row['county']]+=$row['grant_amount'];
		$array_local_match[]=$row['local_match'];
		@$array_county_local_match[$row['county']]+=$row['local_match'];
		if($row['grant_status']=="Withdrawn")
			{
			@$withdrawn_total++;
			@$array_grant_amount_withdrawn+=$row['grant_amount'];
			@$array_local_match_withdrawn+=$row['local_match'];
			}
		}
		
$sql="SELECT year, count(`year`) as year_num, sum(grant_amount) as year_sum_grant, sum(local_match) as year_sum_local
	from grants
	where 1
	group by year
	order by  year"; //echo "$sql"; //exit;
	$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql<br /><br />$where");
	while($row=mysqli_fetch_assoc($result))
		{
		$ARRAY_year_sum[]=$row;
		}
//		echo "<pre>";print_r($ARRAY_year_sum); echo"</pre>"; exit;
		
$last_record=array_pop($array_id);
$num_records=count($ARRAY);

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

//echo "<pre>"; print_r($array_county); echo "</pre>"; exit;
//str_len_sponsor

// Set the constants and variables.
define ("PAGE_WIDTH", 822); // 11 inches
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

for($count_records=0;$count_records<$num_records;$count_records++)
	{
	// Create the page.
	PDF_begin_page_ext($pdf, PAGE_WIDTH, PAGE_HEIGHT, "");


	pdf_setfont ($pdf, $arial, $fontSize);
			
	$verStart=PAGE_HEIGHT-60;
	$ver=$verStart;
	$hor=16;
	$add_hor=16;
	$page_break=PAGE_HEIGHT-5;
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
pdf_show_xy($pdf,$text,228, 565);  
$text="Project";
pdf_show_xy($pdf,$text,330, 565);  
$text="Grant Amount";
pdf_show_xy($pdf,$text,588, 565);  
$text="Local Match";
pdf_show_xy($pdf,$text,675, 565);  
$text="Total";
pdf_show_xy($pdf,$text,757, 565);  

$text="";
pdf_setfont ($pdf, $arial, $fontSize);
// *********** Start Records from Arrays ************

$r=0;	
	for($start=$page_break;$start>250;$start-=$fontSize)
		{
		$hor=16;
		
		$count_records++;
				
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
		$hor+=pdf_stringwidth($pdf, $str_len_county, $arial, $fontSize)+8;
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
				// gray rect
				pdf_setcolor($pdf, "both", "rgb", 0.8, 0.8, 0.8, 0.8);
				pdf_rect($pdf, 16,$ver-16, 772, 13);
				pdf_fill_stroke($pdf);
				pdf_setcolor($pdf, "both", "rgb", 0, 0, 0, 0);
				
				$num_county++;
				if($num_county>1){$g="grants";}else{$g="grant";}
				$text=$var_1." Totals for $num_county $g";
				$ver=$ver-$leading;
				pdf_setfont ($pdf, $arial_bold, $fontSize);
				$page_break-=$fontSize;
				pdf_show_xy($pdf,$text,140,$ver);
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
				
				$start-=$fontSize;
				$count_records--;
				
				pdf_setfont ($pdf, $arial, $fontSize);
				}
				else
				{
				@$num_county++;
				}
			}
		
		// end of PDF
		if($ARRAY[$index]['id']==$last_record)
			{
			
			// last summary
			pdf_setcolor($pdf, "both", "rgb", 0.8, 0.8, 0.8, 0.8);
			pdf_rect($pdf, 16,$ver-16, 740, 13);
			pdf_fill_stroke($pdf);
			pdf_setcolor($pdf, "both", "rgb", 0, 0, 0, 0);
			
			$num_county++;
				if($num_county>1){$g="grants";}else{$g="grant";}
			$text=$var_1." Totals for $num_county $g";
			$ver=$ver-$leading;
			pdf_setfont ($pdf, $arial_bold, $fontSize);
			$page_break-=$fontSize;
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
			
			// Grand Totals
			$date=date('Y-m-d');
			$text=$num_records." grants have been awarded as of $date";
			pdf_show_xy($pdf,$text,250,$ver-18);
			pdf_show_xy($pdf,"Grand Totals:",500,$ver-18);
			
			$grand_grant=array_sum($array_grant_amount);			pdf_show_xy($pdf,number_format($grand_grant,0),$pass_hor_grant_amount-10,$ver-18);
			
			$grand_local=array_sum($array_local_match);			pdf_show_xy($pdf,number_format($grand_local,0),$pass_hor_local_match-10,$ver-18);
			
			$grand_total=$grand_grant+$grand_local;			pdf_show_xy($pdf,number_format($grand_total,0),$pass_hor_grand-10,$ver-18);
			
			// grant amount withdrawn
			$ver=$ver-18;
			pdf_show_xy($pdf,$withdrawn_total." Grants Withdrawn:",461,$ver-18);		
			pdf_show_xy($pdf,"(".number_format($array_grant_amount_withdrawn,0).")",$pass_hor_grant_amount-5,$ver-18);
			pdf_show_xy($pdf,"(".number_format($array_local_match_withdrawn,0).")",$pass_hor_local_match-10,$ver-18);
			
			$withdrawn_text=$array_grant_amount_withdrawn+$array_local_match_withdrawn;
			pdf_show_xy($pdf,"(".number_format($withdrawn_text,0).")",$pass_hor_grand-9,$ver-18);
			
			// Modified totals
			$ver=$ver-18;
			pdf_show_xy($pdf,"Grant Totals:",502,$ver-18);		
			
			$text=($grand_grant-$array_grant_amount_withdrawn);			pdf_show_xy($pdf,number_format($text,0),$pass_hor_grant_amount-10,$ver-18);
			
			$text=($grand_local-$array_local_match_withdrawn);			pdf_show_xy($pdf,number_format($text,0),$pass_hor_local_match-9,$ver-18);
			
			$text=($grand_total-$withdrawn_text);			pdf_show_xy($pdf,number_format($text,0),$pass_hor_grand-9,$ver-18);
			
			pdf_setfont ($pdf, $arial, 8);
			$date=date('Y-m-d');
			$text="Generated on $date";
			pdf_show_xy($pdf,$text,20,15);
			$text="Page $pageNum";
			pdf_show_xy($pdf,$text,730,15);
			
			// Finish the page
			PDF_end_page_ext($pdf, "");
			
	PDF_begin_page_ext($pdf, PAGE_WIDTH, PAGE_HEIGHT, "");

	// Yearly totals
			
			//print_r($ARRAY_year_sum); exit;
			$year_ver=550;
			$pageNum++;
			pdf_setfont ($pdf, $arial_bold, $fontSize);
			pdf_show_xy($pdf,"Totals by year (includes withdrawn projects):",50,$year_ver+30);
			pdf_show_xy($pdf,"Grant Amount",163,$year_ver+15);
			pdf_show_xy($pdf,"Local Match",240,$year_ver+15);
			pdf_show_xy($pdf,"Total",330,$year_ver+15);
			foreach($ARRAY_year_sum as $y_index=>$y_array)
				{
				$plus="";
				$yx=160;
				$v0=$y_array['year_num'];
				$sl0=strlen($v0);
				if($sl0==1){$plus=5;}	
				pdf_show_xy($pdf,$v0." grants in",($yx-70)+$plus,$year_ver);
				
				$v1=$y_array['year'];
				pdf_show_xy($pdf,$v1,$yx-10,$year_ver);
				
				$v2=number_format($y_array['year_sum_grant'],0);
				$sl2=strlen($y_array['year_sum_grant']);
				if($sl2==5){$plus=35;}	
				if($sl2==6){$plus=33;}	
				if($sl2==7){$plus=25;}	
				if($sl2==8){$plus=20;}	
				pdf_show_xy($pdf,$v2,$yx+$plus,$year_ver);
				
				$v3=number_format($y_array['year_sum_local'],0);
				$sl3=strlen($y_array['year_sum_local']);
				if($sl3==5){$plus=95;}	
				if($sl3==6){$plus=93;}	
				if($sl3==7){$plus=85;}	
				if($sl3==8){$plus=80;}	
				pdf_show_xy($pdf,$v3,$yx+$plus,$year_ver);
				$v4=number_format($y_array['year_sum_grant']+$y_array['year_sum_local'],0);				$sl4=strlen($y_array['year_sum_grant']+$y_array['year_sum_local']);
				
				if($sl4==5){$plus=160;}	
				if($sl4==6){$plus=158;}	
				if($sl4==7){$plus=150;}	
				if($sl4==8){$plus=145;}	
			
				pdf_show_xy($pdf,$v4,$yx+$plus,$year_ver);
				$year_ver-=18;
				}

	pdf_setfont ($pdf, $arial, $fontSize);
			
			// Last Footer
			pdf_setfont ($pdf, $arial, 8);
			$date=date('Y-m-d');
			$text="Generated on $date";
			pdf_show_xy($pdf,$text,20,15);
			$text="Page $pageNum";
			pdf_show_xy($pdf,$text,730,15);
			pdf_setfont ($pdf, $arial, $fontSize);
					
			// Finish the page
			PDF_end_page_ext($pdf, "");
			
			PDF_end_document($pdf, "");
			
			$buf = PDF_get_buffer($pdf);
			$len = strlen($buf);
			
			header("Content-type: application/pdf");
			header("Content-Length: $len");
			header("Content-Disposition: inline; filename=NC_DPR_PARTF_Grant_Recipients.pdf");
			print $buf;
			
			PDF_delete($pdf);
			exit;
			}
		$start++;
		$index++;
		$ver=$ver-$leading;
		}// end for
	
	
		// Normal Footer
			pdf_setfont ($pdf, $arial, 8);
			$date=date('Y-m-d');
			$text="Generated on $date";
			pdf_show_xy($pdf,$text,20,15);
			$text="NC Division of Parks and Recreation PARTF Recipients";
			pdf_show_xy($pdf,$text,300,15);
			$text="Page $pageNum";
			pdf_show_xy($pdf,$text,730,15);
			pdf_setfont ($pdf, $arial, $fontSize);
				
		// Finish the page
		PDF_end_page_ext($pdf, "");
		
		$pageNum++;
		
	}

/*This function is the replacement for the deprecated PDF_find_font()

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