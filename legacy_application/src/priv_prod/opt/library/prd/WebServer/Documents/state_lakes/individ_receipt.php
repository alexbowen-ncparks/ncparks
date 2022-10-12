<?php 
//echo "<pre>"; print_r($_REQUEST); echo "</pre>";  exit;
extract($_REQUEST);
if($_REQUEST['id']==""){ECHO "You must designate a person";exit;}
date_default_timezone_set('America/New_York');
//ini_set('display_errors',1);

$database="state_lakes";
include("../../include/connectROOT.inc");// database connection parameters
$db = mysql_select_db($database,$connection)
       or die ("Couldn't select database $database");

	
//echo "<pre>"; print_r($footer); echo "</pre>";  exit;
// Get data
$field_list_1="t1.id,t1.park,
group_concat(distinct concat(t2.pier_number,'*', t2.fee) order by t2.pier_number) as pier_number,
group_concat(distinct t3.seawall_id) as seawall,
group_concat(distinct concat(t4.ramp_id,'*', t4.fee)) as ramp,
group_concat(distinct t5.buoy_id) as buoy_id,
group_concat(distinct t6.swim_line_id) as swim_line_id,
t1.entity,t1.billing_title,t1.prefix,t1.billing_first_name,t1.billing_last_name,t1.suffix,t1.billing_add_1,t1.billing_add_2,t1.billing_city,t1.billing_state,t1.billing_zip,t1.email,t1.phone,t1.cell_phone,t1.fax,t1.comment,t1.lake_address,t1.lake_city,t1.lake_state,t1.lake_zip";


$cy=$_REQUEST['year'];
$sql="SELECT $field_list_1
FROM  contacts as t1
LEFT JOIN piers as t2 on (t1.id=t2.contacts_id  and t2.year='$cy')
LEFT JOIN seawall as t3 on (t1.id=t3.contacts_id  and t3.year='$cy')
LEFT JOIN ramp as t4 on (t1.id=t4.contacts_id  and t4.year='$cy')
LEFT JOIN buoy as t5 on (t1.id=t5.contacts_id  and t5.year='$cy')
LEFT JOIN swim_line as t6 on (t1.id=t6.contacts_id  and t6.year='$cy')
where 1 
and (t2.pier_number is not NULL OR t3.seawall_id is not NULL OR t4.ramp_id is not NULL OR t5.buoy_id is not NULL OR t6.swim_line_id is not NULL)
and t1.id=$id
group by t1.id
order by t1.billing_last_name,t1.billing_first_name
"; 
//echo "$sql"; exit;
$result1 = mysql_query($sql) or die ("Couldn't execute query. $sql c=$connection");

//echo "$sql<br />";
 
$num1=mysql_num_rows($result1);
if($num1>0)
	{
	while($row=mysql_fetch_assoc($result1))
		{
			$ARRAY[]=$row;
			$contact_id_array[]=$row['id'];	
		}
	}

//echo "<pre>"; print_r($ARRAY); echo "</pre>";  exit;

$num=count($ARRAY);
if($num<1){echo "No record was found using: <b>$clause</b>";exit;}

$fieldNames=array_values(array_keys($ARRAY[0]));
		
define ("PAGE_WIDTH", 612); // 8.5 inches
define ("PAGE_HEIGHT",792); // 11 inches

// Create the Page.	
$pdf = pdf_new(); include("/opt/library/prd/WebServer/include/pdf_key_23.php");
pdf_open_file ($pdf, "");

// Set the different PDF values.
pdf_set_info ($pdf, "Author", "Tom Howard");
pdf_set_info ($pdf, "Title", "NC State Lakes Database");
pdf_set_info ($pdf, "Creator", "See Author");

// Create the pages.

foreach($ARRAY as $num=>$array){
extract($array);

pdf_begin_page ($pdf, PAGE_WIDTH, PAGE_HEIGHT);


		// Set the fonts
/*		
		$timesItalic = pdf_findfont ($pdf, "fonts/Times_New_Roman_Italic", "winansi");
		$timesBoldItalic = pdf_findfont ($pdf, "fonts/Times_New_Roman_Bold_Italic", "winansi");
		$timesBold = pdf_findfont ($pdf, "fonts/Times_New_Roman_Bold", "winansi");
*/
		$helvetica = PDF_load_font ($pdf, "Helvetica", "winansi","");
		$helveticalBold = PDF_load_font ($pdf, "Helvetica-Bold", "winansi","");
		$times = PDF_load_font ($pdf, "Times-Roman", "winansi","");	
		
//*********
// Add Header
pdf_setfont ($pdf, $helvetica, 14);
$y=740;
$text="STATE OF NORTH CAROLINA";
	pdf_show_xy ($pdf,$text,210,$y);
$y=724;
$text="DEPARTMENT OF ENVIRONMENT AND NATURAL RESOURCES";
	pdf_show_xy ($pdf,$text,110,$y);
$y=700;
$text="DIVISION OF PARKS AND RECREATION";
	pdf_show_xy ($pdf,$text,180,$y);
$y=684;
$receipt_date=date("l, F jS, Y");
pdf_setfont ($pdf, $helveticalBold, 14);
$text=strtoupper($_POST['notify'])." Receipt Date: $receipt_date";
	pdf_show_xy ($pdf,$text,190,$y-25);
		

pdf_setfont ($pdf, $helvetica, 12);
	
pdf_set_value($pdf,"leading",14);

// Mailing Address
$y=550; $text="";
if($billing_title){$text=$billing_title;}
if($billing_first_name)
	{
	if($prefix){$billing_first_name=$prefix." ".$billing_first_name;}
	$text.="\n".$billing_first_name;
	}
if($billing_last_name)
	{
	if($suffix){$billing_last_name.=", ".$suffix;}
	$text.=" ".$billing_last_name;
	}
if($billing_add_1){$text.="\n".$billing_add_1;}
if($billing_add_2){$text.="\n".$billing_add_2;}
if($billing_city){$text.="\n".$billing_city.", ".$billing_state." ".$billing_zip;}
//PDF_show_boxed ( resource $p , string $text , float $left , float $top , float $width , float $height , string $mode , string $feature )
	PDF_show_boxed ($pdf,$text,53,$y-12,500,100,"left","");

// Structure listing
$y=590; $text=""; $cost="";$total_fee="";$pc="";$sc="";$rc="";$bc="";
	if($pier_number)
		{
		$np=explode(",",$pier_number);
		$num_piers=count($np);
		$text="Pier #: "; 
		foreach($np as $k=>$v)
			{
			$nf=explode("*",$v);
			$text.=$nf[0].", ";
			$pc+=$nf[1];
			}
			$text=rtrim($text,", ")." = $$pc";
		}
	if($seawall)
		{
		$np=explode(",",$seawall);
		$num_seawall=count($np);
		$np=count($np);
		if($np==1)
		{$text.="\nSeawall: ";}
		if($np>1)
		{$text.="\nSeawalls: ";}
			if($np>1){$b="seawalls";}else{$b="seawall";}
			$text.="$np $b = no charge";
		}
	if($ramp)
		{
		$np=explode(",",$ramp);
		$num_ramp=count($np);
		$text.="\nRamp #: ";
		foreach($np as $k=>$v)
			{
			$nf=explode("*",$v);
			$text.=$nf[0].", ";
			$rc+=$nf[1];
			}
			$text=rtrim($text,", ")." = $$rc";
		}
	if($buoy_id)
		{
		$np=explode(",",$buoy_id);
		$num_buoy=count($np);
		$np=count($np);
		if($np==1)
		{$text.="\nBuoy: ";}
		if($np>1)
		{$text.="\nBuoys: ";}
			$bc=($np*15);
			if($np>1){$b="buoys";}else{$b="buoy";}
			$amt="$15*$np $b = $".$bc;
			$text.=$amt;
		}
	if($swim_line_id)
		{
		$np=explode(",",$swim_line_id);
		$num_swim=count($np);
		$text.="\nSwim Line: ";
	//	foreach($np as $k=>$v)
			//{
			//$text.=$v.", ";
			//}
			$text.="$30"; $slc=30;
		}
	PDF_show_boxed ($pdf,$text,383,$y-25,480,80,"left","");

if(!isset($slc)){$slc="";}
$total_fee="$".number_format(($bc+$rc+$sc+$pc+$slc),2);


$total_structure=@$num_piers+@$num_buoy+@$num_ramp+@$num_swim+@$num_seawall;
if($total_structure>1){$structure="s";}else{$structure="";}

pdf_setfont ($pdf, $helveticalBold, 12);
$y=250;
$text=@$footer['contents'];
$text=str_replace("xxx",$park_name[$passPark],$text);
$text=str_replace("(s)",$structure,$text);

$text="Total: ".$total_fee;
$dd=@$footer['due_date']." ".date('Y');
$text=str_replace("yyy",$dd,$text);
//PDF_show_boxed ( resource $p , string $text , float $left , float $top , float $width , float $height , string $mode , string $feature )
	PDF_show_boxed ($pdf,$text,353,$y-75,500,300,"left","");
		


$text="Entered by: ";
$yy=350;
pdf_setfont ($pdf, $helvetica, 12);
	pdf_show_xy ($pdf,$text,210,$yy);
	pdf_moveto($pdf, 275,$yy);
	pdf_lineto($pdf, 475,$yy);
	pdf_stroke($pdf);
	
$image=pdf_load_image($pdf,'jpeg','dprgray.jpg','');
PDF_place_image($pdf,$image,240,150,.75);
		
// Finish the page
pdf_end_page ($pdf);

}// Finish the multi_page PDF


// Close the PDF
pdf_close ($pdf);

// Send the PDF to the browser.
$buffer = pdf_get_buffer ($pdf);
header ("Content-type: application/pdf");
header ("Content-Length: " . strlen($buffer));
header ("Content-Disposition: inline; filename=letter.pdf");
echo $buffer;

// Free the resources
pdf_delete ($pdf);


?>