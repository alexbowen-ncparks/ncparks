<?php
//ini_set('display_errors',1);
$database="divper";
//include("../../include/auth.inc"); // used to authenticate users
include("../../include/iConnect.inc"); 
mysqli_select_db($connection,'divper'); // database

//echo "<pre>test"; print_r($_REQUEST); echo "</pre>";  exit;
// extract($_REQUEST);

if(@$type=="Print Custom")
	{
	$select="SELECT * From labels where custom='x' order by Last_name";
	$message="No labels were selected for \"Custom Printing\"";
	//$limit="limit 90";
	}
else
	{	
	$select = "SELECT t2.affiliation_code, t1.* from labels as t1
	LEFT JOIN labels_affiliation as t2 on t1.id=t2.person_id
	$where";
	$message="No labels were found.";
	}

@$sql = "$select $limit";

//echo "$sql";exit;
$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql");

$num=mysqli_num_rows($result);
if($num<1){echo "$message";}

$totPageNum=ceil($num/30);

//$affPrint=array("PAC","RRS","CWMTF","PARTF","NHTF","FSP");
$affPrint=array();

$i=1;
while($row=mysqli_fetch_array($result))
	{
	extract($row);
	if(@$test_combo[$i-1]==$First_name.$Last_name.$city){continue;}
	@$lab_nick[]=strtoupper($Nickname);
	$lab_first[]=strtoupper($First_name);
	@$lab_mid[]=strtoupper($M_initial);
	$lab_last[]=strtoupper($Last_name);
	@$lab_title[]=strtoupper($title);
	$lab_add[]=strtoupper($address);
	$lab_city[]=strtoupper($city);
	$lab_state[]=strtoupper($state);
	$lab_zip[]=strtoupper($zip);
	@$lab_comments[]=strtoupper($comments);
	@$lab_park[]=strtoupper($park);
	if(in_array($affiliation_code,$affPrint))
		{
		$lab_affcode[]=strtoupper($affiliation_code);
		}
	else
		{
		$lab_affcode[]="";
		}
	
	@$lab_affname[]=$affiliation_name;
	
	$test_combo[$i]=$First_name.$Last_name.$city;
	$i++;
	}

//echo "<pre>"; print_r($lab_last); echo "</pre>";  exit;

// Set the constants and variables.
define ("PAGE_WIDTH", 612); // 8.5 inches
define ("PAGE_HEIGHT",792); // 11 inches

$pdf = PDF_new(); include("/opt/library/prd/WebServer/include/pdf_key_23.php");

//  open new PDF file; insert a file name to create the PDF on disk
if (PDF_begin_document($pdf, "", "") == 0)
	{
		die("Error: " . PDF_get_errmsg($pdf));
	}

// Set the different PDF values.
pdf_set_info ($pdf, "Author", "Tom Howard");
pdf_set_info ($pdf, "Title", "Labels for DPR Steward");
pdf_set_info ($pdf, "Creator", "See Author");

// ******************** Start Loop ***************
$start=0;
$pageNum=1;

	$just=0; //left
//	$just=50;// center
//	$just=100;// right

	$r=0;
for($p=0;$p<$totPageNum;$p++)
	{
	// Create the page.
	PDF_begin_page_ext($pdf, PAGE_WIDTH, PAGE_HEIGHT, "");
	
			// Set the default font from here on out.	
		$arial = PDF_load_font($pdf, "Arial", "winansi", "");
		$arialBold = PDF_load_font($pdf, "arialnb", "winansi", "");
	
	$fontSize=10;
	$lead=$fontSize+3;
	pdf_setfont ($pdf, $arial, $fontSize);
			
	$verStart=PAGE_HEIGHT-50;
	$ver=$verStart;
	$hor=3;
	$add_hor=16;
	$hor=$hor+$add_hor;
	$rr=0;
	// **************************************************
	// *********** Start Records from Arrays ************
	
	$numLines="";
	if($totPageNum>1)
		{
		if($p==0)
			{
			$end=$start+7;//$r=0;
			}
		else
			{
			$numLines=$numLines-$start;
			$end=$start+$numLines;
			}
		}
		else
		{
		$end=$numLines;//$r=0;
		}
	
	for($xx=1;$xx<31;$xx++) //31 for 30 labels   
		{
			if($rr<10)
				{
				$hor=3;
				$hor=$add_hor;
				}
		
		if($rr==10){$ver=$verStart;}
			if($rr>9 and $rr<20)
				{
				$hor=201;
				$hor=$hor+$add_hor;
				}
		
		if($rr==20){$ver=$verStart;}
			if($rr>19)
				{
				$hor=401;
				$hor=$hor+$add_hor;
				}
		
		
		// Make Label
		if($lab_first[$r])
			{
			$text=$lab_first[$r]." ".$lab_last[$r];$modeB="left";
			}
			else
			{
			$text=$lab_last[$r];$modeB="left";
			}
		
	
		if($lab_affcode[$r])
			{
			if($lab_affcode[$r]=="PAC")
				{$text.="\n".$lab_park[$r]." - ".$lab_affcode[$r];}
				else
				{$text.="\n".$lab_affcode[$r];}
			}
		
		
		$text.="\n".$lab_add[$r]."\n".$lab_city[$r]." ".$lab_state[$r]." ".$lab_zip[$r];
		
		$widthB=188; $heightB=72; 
	//	$hor=12;
			$xstart=30;
		//	$cols=strlen($text)-1;
			$cols=30;
//		pdf_show_xy ($pdf, $text, 390 ,300);
			//	PDF_fit_textline($pdf, $text, $hor, 300, '');
				text_block($pdf,$text,$cols,$hor,$ver,$xstart,$just);
	//		pdf_show_boxed ($pdf, $text, $hor ,$ver,$widthB,$heightB,$modeB,"");
		
		$start++;
		$r++;
		$rr++;
		$ver=$ver-74;
		}// end for
	
	
	// Finish the page
	PDF_end_page_ext($pdf, "");
	
	$pageNum++;
	
	}// end loop of pages

// Close the PDF

PDF_end_document($pdf, "");

$buf = PDF_get_buffer($pdf);
$len = strlen($buf);

header("Content-type: application/pdf");
header("Content-Length: $len");
header("Content-Disposition: inline; filename=labels.pdf");
print $buf;

PDF_delete($pdf);

if($type=="Print Custom"){
$sql="UPDATE labels set custom=''";
$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql");
}

function text_block($pdf,$text,$cols,$xcrd,$ycrd,$xstart,$just)
	{
	$font_size=12;  //font size, used to space lines on y axis
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
	
?>