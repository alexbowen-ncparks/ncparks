<?php 
//echo "<pre>"; print_r($_POST); echo "</pre>";  //exit;
// ini_set('display_errors', 1); //exit;
date_default_timezone_set('America/New_York');

if($_POST['park']=="" AND $_POST['prepare_letter_php']=="" AND $_POST['payment_form_php']=="")
	{ECHO "You must designate a park";exit;}

include("/opt/library/prd/WebServer/include/connectROOT.inc"); // connection parameters

$database="dpr_system";
mysql_select_db($database, $connection); // database 

$sql="SELECT *
FROM  parkcode_names"; //echo "$sql";
$result = mysql_query($sql) or die ("Couldn't execute query. $sql c=$connection");
while($row=mysql_fetch_assoc($result))
	{
	@$parkCodeName[$row['park_code']]=strtoupper($row['park_name']);
	}

//include("../../include/connectDIVPER.62.inc");// database connection parameters

$database="state_lakes";
//extract($_REQUEST);
mysql_select_db($database, $connection); // database 

$year=$_POST['year']; 
$due_date=$_POST['due_date']; 
$park=$_POST['park']; $passPark=$park;

$park_name=array("WHLA"=>"White Lake State Park","BATR"=>"Bay Tree State Park","LAWA"=>"Lake Waccamaw State Park","PETT"=>"Pettigrew State Park");

$change_park=array("WHLA"=>"SILA","BATR"=>"SILA");
	if(array_key_exists($park,$change_park))
		{
		$park=$change_park[$park];
		}
$full_park_name=$parkCodeName[$park];

mysql_select_db("divper",$connection);
$sql="SELECT concat(t3.Fname,' ', if((length(t3.Mname)>0 and length(t3.Mname)<2),concat(t3.Mname,'.'),t3.Mname),' ',t3.Lname) as full_name, t4.add1,t4.add2,t4.city,t4.zip,t4.email as park_email,t4.ophone as park_phone,t4.fax as park_fax
FROM  position as t1
LEFT JOIN emplist as t2 on t1.beacon_num=t2.beacon_num
LEFT JOIN empinfo as t3 on t2.tempID=t3.tempID
LEFT JOIN dpr_system.dprunit as t4 on t1.park=t4.parkcode
where t1.park='$park' and t1.working_title='Park Superintendent'
";  //echo "$sql"; exit;
$result = mysql_query($sql) or die ("Couldn't execute query. $sql c=$connection");
$name_result=mysql_fetch_assoc($result);
extract($name_result);

mysql_select_db($database,$connection);
// Get boilerplate
$sql="SELECT *
FROM  fee_letter as t1"; //echo "$sql";
$result = mysql_query($sql) or die ("Couldn't execute query. $sql c=$connection");

$footer=mysql_fetch_assoc($result);
	
//echo "<pre>"; print_r($footer); echo "</pre>";  exit;
// Get data
$field_list_1="t1.id,t1.park,
group_concat(distinct concat(t2.pier_number,'*', t2.fee) order by t2.pier_number) as pier_number,
if(group_concat(distinct t2.delinq_yrs)=',','',group_concat(distinct t2.delinq_yrs)) as pier_delinq,
if(group_concat(distinct t5.delinq_yrs)=',','',group_concat(distinct t5.delinq_yrs)) as buoy_delinq,
group_concat(distinct t3.seawall_id) as seawall,
group_concat(distinct concat(t4.ramp_id,'*', t4.fee)) as ramp,
if(group_concat(distinct t4.delinq_yrs)=',','',group_concat(distinct t4.delinq_yrs)) as ramp_delinq,
group_concat(distinct t5.buoy_id) as buoy_id,
group_concat(distinct t6.swim_line_id) as swim_line_id,
if(group_concat(distinct t6.delinq_yrs)=',','',group_concat(distinct t6.delinq_yrs)) as swim_line_delinq,
t1.entity,t1.billing_title,t1.prefix,t1.billing_first_name,t1.billing_last_name,t1.suffix,t1.billing_add_1,t1.billing_add_2,t1.billing_city,t1.billing_state,t1.billing_zip,t1.email,t1.phone,t1.cell_phone,t1.fax,t1.comment,t1.lake_address,t1.lake_city,t1.lake_state,t1.lake_zip";

$clause="and t1.park like '$_POST[park]%'";

if($_POST['billing_last_name']){$clause.=" and t1.billing_last_name like '$_POST[billing_last_name]%'";}

if($_POST['notify']=="final")
{
$clause.=" and (t2.pier_payment='' OR t5.buoy_receipt='' OR t4.ramp_receipt='' OR t6.swim_line_receipt='')";
}

if($_POST['limit']){$limit="limit $_POST[limit]";}
if(!isset($limit)){$limit="";}

//$year="2011";
$sql="SELECT $field_list_1
FROM  contacts as t1
LEFT JOIN piers as t2 on (t1.id=t2.contacts_id and t2.year='$year')
LEFT JOIN seawall as t3 on (t1.id=t3.contacts_id and t3.year='$year')
LEFT JOIN ramp as t4 on (t1.id=t4.contacts_id and t4.year='$year')
LEFT JOIN buoy as t5 on (t1.id=t5.contacts_id and t5.year='$year')
LEFT JOIN swim_line as t6 on (t1.id=t6.contacts_id and t6.year='$year')
where 1 
and (t2.pier_number is not NULL OR t3.seawall_id is not NULL OR t4.ramp_id is not NULL OR t5.buoy_id is not NULL OR t6.swim_line_id is not NULL)
$clause
group by t1.id
order by t1.billing_last_name,t1.billing_first_name
$limit"; 
//echo "$sql"; exit;
$result1 = mysql_query($sql) or die ("Couldn't execute query. $sql c=$connection");

//echo "$sql<br />"; exit;
 
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

@$num=count($ARRAY);
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

foreach($ARRAY as $num=>$array)
	{
	extract($array);
	
	pdf_begin_page ($pdf, PAGE_WIDTH, PAGE_HEIGHT);
/*	
			$arial = PDF_load_font ($pdf, "fonts/Arial.1", "winansi","");
			$arialBold = PDF_load_font ($pdf, "fonts/Arial_Bold", "winansi","");
			$times = PDF_load_font ($pdf, "fonts/Times_New_Roman", "winansi","");
			$verdanaItalic = PDF_load_font ($pdf, "fonts/Verdana_Italic", "winansi","");
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
	pdf_setfont ($pdf, $helveticalBold, 14);
	if($_POST['notify']=="annual")
		{
		$text="ANNUAL FEE NOTIFICATION";
		}
	else
		{
		$text="FINAL FEE NOTIFICATION";
		}
		pdf_show_xy ($pdf,$text,220,$y);
			
	
	pdf_setfont ($pdf, $helvetica, 12);
	
	
	$text=date("l, F jS").", ".$year;
	if($_POST['date_sent']!="")
		{
		$text=$_POST['date_sent'];
		}
		pdf_show_xy ($pdf,$text,50,$y-30);
		
	pdf_set_value($pdf, "leading",14);
	
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
	$y=590; $text=""; $cost="";$total_fee="";
	$pc="";$sc="";$rc="";$bc="";$slc="";$pd="";
	$pier_delinq_amt="";$buoy_delinq_amt="";$ramp_delinq_amt=""; $swim_line_delinq_amt="";
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
				$pass_pier_fee=$nf[1];
				}
				$text=rtrim($text,", ")." = $$pc";
			}
			
		if($pier_delinq)
			{
			$nf=explode(",",$pier_delinq);
			$temp="";
			$yrs_delinq=count($nf);
				$pier_delinq_amt=$yrs_delinq*$pass_pier_fee;
			if($yrs_delinq==1)
			{
			$text.="\nYear Delinquent Pier: $pier_delinq $$pier_delinq_amt";
			}
			
			if($yrs_delinq>1)
				{
				$text.="\nYears Delinquent Pier: $$pier_delinq_amt\n";
				foreach($nf as $k=>$v)
					{
					$v=trim($v);
					$temp.=$v.", ";
					if($k!=0 AND fmod($k,5)==0){$temp.="\n";}
					}
				$temp=rtrim($temp,", ");
				$text.=$temp;
				}
			}
	//	echo "$text<br />$yrs_delinq"; exit;
		
		if($ramp)
			{
			$np=explode(",",$ramp);
			$num_ramp=count($np);
			$text.="\nRamp: ";
			foreach($np as $k=>$v)
				{
				$nf=explode("*",$v);
			//	$text.=$nf[0].", ";
				$rc+=$nf[1];
				}
				$text=rtrim($text,", ")." = $$rc";
			}
			
		if($ramp_delinq)
			{
			$nf=explode(",",$ramp_delinq);
			$temp="";
			$yrs_delinq=count($nf);
				$ramp_delinq_amt=$yrs_delinq*15;
			if($yrs_delinq==1)
			{$text.="\nYear Delinquent Ramp: $ramp_delinq $$ramp_delinq_amt";}
			if($yrs_delinq>1)
				{
				$text.="\nYears Delinquent Ramp: $$ramp_delinq_amt\n";
				foreach($nf as $k=>$v)
					{
					$v=trim($v);
					$temp.=$v.", ";
					if($k!=0 AND fmod($k,5)==0){$temp.="\n";}
					}
				$temp=rtrim($temp,", ");
				$text.=$temp;
				}
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
			
		if($buoy_delinq)
			{
			$nf=explode(",",$buoy_delinq);
			$temp="";
			$yrs_delinq=count($nf);
				$buoy_delinq_amt=$yrs_delinq*15;
			if($yrs_delinq==1)
			{$text.="\nYear Delinquent Buoy: $buoy_delinq $$buoy_delinq_amt";}
			if($yrs_delinq>1)
				{
				$text.="\nYears Delinquent Buoy: $$buoy_delinq_amt\n";
				foreach($nf as $k=>$v)
					{
					$v=trim($v);
					$temp.=$v.", ";
					if($k!=0 AND fmod($k,5)==0){$temp.="\n";}
					}
				$temp=rtrim($temp,", ");
				$text.=$temp;
				}
			}
			
		if($swim_line_id)
			{
			$np=explode(",",$swim_line_id);
			$num_swim=count($np);
			$text.="\nSwim Line: ";
				$text.="$35"; $slc=35;
			}
		
		if($swim_line_delinq)
			{
			$nf=explode(",",$swim_line_delinq);
			$temp="";
			$yrs_delinq=count($nf);
				$swim_line_delinq_amt=$yrs_delinq*35;
			if($yrs_delinq==1)
				{
				$text.="\nYear Delinquent Swim Line: $swim_line_delinq $$swim_line_delinq_amt";
				}
			if($yrs_delinq>1)
				{
				$text.="\nYears Delinquent Swim Line: $$swim_line_delinq_amt\n";
				foreach($nf as $k=>$v)
					{
					$v=trim($v);
					$temp.=$v.", ";
					if($k!=0 AND fmod($k,5)==0){$temp.="\n";}
					}
				$temp=rtrim($temp,", ");
				$text.=$temp;
				}
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
			
		//	echo "$text";exit;
	//PDF_show_boxed ( resource $p , string $text , float $left , float $top , float $width , float $height , string $mode , string $feature )
		PDF_show_boxed ($pdf,$text,383,$y-105,480,180,"left","");
	
	$total_fee="$".number_format(($bc+$rc+$sc+$pc+$slc+$pier_delinq_amt+$buoy_delinq_amt+$ramp_delinq_amt+$swim_line_delinq_amt),2);
	
	@$total_structure=$num_piers+$num_buoy+$num_ramp+$num_swim+$num_seawall;
	if($total_structure>1){$structure="s";}else{$structure="";}
	
	pdf_setfont ($pdf, $times, 12);
	$y=250;
	$text=$footer['contents'];
	$text=str_replace("xxx",$park_name[$passPark],$text);
	$text=str_replace("(s)",$structure,$text);
	
	$text=str_replace("total_cost",$total_fee,$text);
	//$dd=$footer['due_date']." ".date(Y);
	$dd=$due_date.", ".$year;
	$text=str_replace("yyy",$dd,$text);
	$text=str_replace("xx_current_year",$year,$text);
	//PDF_show_boxed ( resource $p , string $text , float $left , float $top , float $width , float $height , string $mode , string $feature )
		PDF_show_boxed ($pdf,$text,53,$y,500,300,"left","");
			
	if(!isset($city)){$city="";}
	if(!isset($full_name)){$full_name="";}
	if(!isset($add1)){$add1="";}
	if(!isset($zip)){$zip="";}
	if(!isset($full_park_name)){$full_park_name="";}	
	$text="Sincerely,\n\n\n\n$full_name\n\nPark Superintendent\n$full_park_name\n$add1\n$city, North Carolina, $zip";
		PDF_show_boxed ($pdf,$text,53,140,400,140,"left","");
	
		
	// Add Footer
	$y=75;
	if(!isset($park_email)){$park_email="";}
	if(!isset($park_phone)){$park_phone="";}
		pdf_show_xy ($pdf,"Email:  ".$park_email,53,$y);
		pdf_show_xy ($pdf,"Phone: ".$park_phone,53,$y-12);
		if(@$park_fax)
			{
			pdf_show_xy ($pdf,"Fax:     ".$park_fax,53,$y-24);
			}
		
	
	// Color doubles the file size. over a no image
	//$image=pdf_load_image($pdf,'jpeg','dprcolor1.jpg','');
	
	// Gray adds about 20% to file size  66kb becomes 82kb
	if($park=="LAWA")
		{	$image=pdf_load_image($pdf,'png','/opt/library/prd/WebServer/Documents/state_lakes/signature/Toby_Hall_sig.png','');
		PDF_fit_image($pdf,$image,45,238, "scale 2");
		pdf_close_image($pdf,$image);
		}
	if($park=="BATR" OR $park=="WHLA")
		{	$image=pdf_load_image($pdf,'png','/opt/library/prd/WebServer/Documents/state_lakes/signature/Woodruff6825.png','');
		PDF_fit_image($pdf,$image,50,228, "scale .5");
		pdf_close_image($pdf,$image);
		
	if($park=="BATR" OR $park=="WHLA")
		{
		$text="Please return this letter with payment.\nPlease note your structure number on check\nor money order.";
		}
		else
		{
		$text="Please keep a copy for your records and\nreturn the duplicate with payment.";
		}	
		PDF_show_boxed ($pdf,$text,310,70,400,70,"left","");
		}
	$image=pdf_load_image($pdf,'png','/opt/library/prd/WebServer/Documents/state_lakes/2013_dprbw.png','');
	PDF_fit_image($pdf,$image,340,150, "scale .20");
	pdf_close_image($pdf,$image);
			
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