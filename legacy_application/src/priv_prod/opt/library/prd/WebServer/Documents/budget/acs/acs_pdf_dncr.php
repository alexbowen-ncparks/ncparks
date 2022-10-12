<?php
// ini_set('display_errors,',1);

$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection,$database); // database 

//echo "<pre>"; print_r($_REQUEST); echo "</pre>"; // exit;
if(isset($vendor_number))
	{
	$vendor_number=trim($vendor_number);
	$select="SELECT * From cid_vendor_invoice_payments ";
	$where="where cid_vendor_invoice_payments.vendor_number='$vendor_number' AND due_date='$due_date'";
	}
else
	{

	if($prepared_by=="Barbara Adams"||$prepared_by=="Pamela Laurence"){
	$pb="(prepared_by='Barbara Adams' OR prepared_by='Pamela Laurence')";}
	else
	{$pb="prepared_by='$prepared_by'";}

	$vendor_name=urldecode($vendor_name);
	$vendor_name=addslashes($vendor_name);  // necessary since vendor_name was sent urlencoded and not escaped in no_inject.php
	$select="SELECT cid_vendor_invoice_payments.*,coa.park_acct_desc
	From cid_vendor_invoice_payments ";
	$where="where vendor_name='$vendor_name' AND due_date='$due_date' AND $pb";
	}
$JOIN="LEFT JOIN coa on cid_vendor_invoice_payments.ncas_account = coa.ncasnum";

$limit="";
if(empty($_SESSSION)){session_start();}
// echo "33<pre>"; print_r($_SESSION); echo "</pre>";  exit;
if($_SESSION['logname']=="Howard6319")
	{
// 	$limit="limit 174";
	}
$sql = "$select
$JOIN
$where
order by ncas_invoice_number
$limit
";
// group by id, ncas_invoice_number
// echo "$sql"; exit;

$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql");

while($row=mysqli_fetch_assoc($result))
	{
	$ARRAY[$row['ncas_invoice_number']][]=$row;
	$cvip_id_array[$row['id']]=$row['ncas_invoice_number'];
	$cvip_invoice_array[$row['ncas_invoice_number']][]=$row['id'];
	$inv_ncas_invoice_number_array[$row['ncas_invoice_number']]=$row['ncas_invoice_number'];
	}

// echo "<pre>"; print_r($ARRAY); echo "</pre>";  exit;

$count=count($inv_ncas_invoice_number_array);
// echo "$count $sql <pre>"; print_r($inv_ncas_invoice_number_array); print_r($cvip_id_array); echo "</pre>";  exit;

if($count>1)
	{
	
// 	echo "m<pre>"; print_r($cvip_id_array); print_r($inv_ncas_invoice_number_array); echo "</pre>";  exit;

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
	
	// Initialize some variables
	$ncas_freightAmt="";
	$grossAmt="";
	$testText6a="";
	$testText4="";
	$comPrevious="";

	// Set the constants and variables.
// 	define ("PAGE_WIDTH", 792); // 11 inches landscape
// 	define ("PAGE_HEIGHT",612); // 8.5 inches
	define ("PAGE_WIDTH",612); // 11 inches landscape
	define ("PAGE_HEIGHT",792); // 8.5 inches
	$pdf = PDF_new(); include("/opt/library/prd/WebServer/include/pdf_key_23.php");

	/*  open new PDF file; insert a file name to create the PDF on disk */
	if (PDF_begin_document($pdf, "", "") == 0) {
		die("Error: " . PDF_get_errmsg($pdf));
	}

	PDF_set_info($pdf, "Creator", "DPR");
	PDF_set_info($pdf, "Author", "Tom Howard");
	PDF_set_info($pdf, "Title", "DNCR Invoice");
	
	include("acs_pdf_dncr_m.php");
	
	PDF_end_document($pdf, "");
// exit;
	$buf = PDF_get_buffer($pdf);
	$len = strlen($buf);

	header("Content-type: application/pdf");
	header("Content-Length: $len");
	header("Content-Disposition: inline; filename=acs.pdf");
	print $buf;

	PDF_delete($pdf);

	}
	else
	{
	include("acs_pdf_dncr1.php");
	}

?>