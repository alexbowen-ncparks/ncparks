<?php 
extract($_REQUEST);
//print_r($_REQUEST);   // EXIT;

ini_set('display_errors,',1);
date_default_timezone_set('America/New_York');
$database="ware";
$db="ware";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database 

$sql="SELECT t1.email as park_email
From dpr_system.dprunit as t1
where parkcode='$park_code'";
//echo "$sql"; exit;
$result = mysqli_query($connection, $sql) or die ("Couldn't execute query. $sql ".mysqli_error($connection));
$row=mysqli_fetch_assoc($result);
	$park_email=$row['park_email'];
	
$sql="SELECT t1.Fname, t1.Lname
From divper.empinfo as t1
left join divper.emplist as t2 on t2.emid=t1.emid
left join divper.position as t3 on t3.beacon_num=t2.beacon_num
where t3.park='$park_code' and t3.posTitle like '%Park Superintendent%'";
//echo "$sql"; exit;
$result = mysqli_query($connection, $sql) or die ("Couldn't execute query. $sql ".mysqli_error($connection));
if(mysqli_num_rows($result)<1)
	{
	$var_pasu_name[]="PASU position vacant at this time.";
	}
	else
	{
	while($row=mysqli_fetch_assoc($result))
		{
		$var_pasu_name[]=$row['Fname']." ".$row['Lname'];
		}
	}
$pasu_name=implode(",",$var_pasu_name);


$sql="SELECT t2.sort_order,t1.*, t2.product_title, t1.quantity, t2.current_cost, format(t1.quantity*t1.price,2) as cost
From park_order as t1
left join base_inventory as t2 on t1.product_number=t2.product_number
where t1.park_code='$park_code' AND t1.ordered='x' AND t1.processed_date='$processed_date'
order by sort_order

";
$pass_sql=$sql;
//  echo "$sql"; exit;
$result = mysqli_query($connection, $sql) or die ("Couldn't execute query. $sql ".mysqli_error($connection));
$num=mysqli_num_rows($result);

while($row=mysqli_fetch_assoc($result))
	{
	$ARRAY[]=$row;
	$item_array[]=$row['id'];
	}
$fieldNames=array_values(array_keys($ARRAY[0]));
// echo "<pre>"; print_r($ARRAY); print_r($item_array); echo "</pre>";  exit;

// Get date order submitted by park
$center=$ARRAY[0]['center'];
$sql="SELECT max(ordered_date) as park_ordered_on
From park_order 
where center='$center' AND processed_date='$processed_date' and ordered='x'";
// echo "$sql<br /><br />"; ///exit;
$result = mysqli_query($connection, $sql) or die ("Couldn't execute query. $sql ".mysqli_error($connection));
$row=mysqli_fetch_assoc($result);
extract($row);

// Get invoice number
$center=$ARRAY[0]['center'];
$sql="SELECT *
From invoices 
where center='$center' AND processed_date='$processed_date'";
//   echo "75 $sql<br /><br />"; exit;
$result = mysqli_query($connection, $sql) or die ("Couldn't execute query. $sql ".mysqli_error($connection));
$num=mysqli_num_rows($result); 
//	$totPageNum=ceil($num/16);
if($num<1)
	{
	if(!empty($ARRAY[0]['comments']))
		{$form_comments=$ARRAY[0]['comments'];}else{$form_comments="";}
	if(empty($_POST['invoice_comments']))
		{
		include("../_base_top.php");
		echo "<form method='POST' action='invoice_pdf.php'>"; 
		echo "This comment will appear on the invoice. (required)<br />"; 
		echo "<textarea name='invoice_comments' cols='50' rows='3'>$form_comments</textarea>"; 
		echo "<input type='hidden' name='park_code' value='$park_code'>";
		echo "<input type='hidden' name='center' value='$center'>";
		echo "<input type='hidden' name='processed_date' value='$processed_date'>";
		$tempID=$_SESSION['ware']['tempID'];
		echo "<input type='hidden' name='entered_by' value='$tempID'>";
		echo "<input type='submit' name='submit' value='Submit'></form>"; 
		
		exit;
		}
	$sql="SELECT invoice_number
	From invoices 
	where 1 
	order by invoice_number desc limit 1"; 
//  echo "102 $sql<br /><br />"; //exit;
	$result = mysqli_query($connection, $sql) or die ("Couldn't execute query. $sql ".mysqli_error($connection));
	$num_id=mysqli_num_rows($result);
	if($num_id<1)
		{
		$pass_invoice_number=date("y")."_1001";
		}
		else
		{
		$row=mysqli_fetch_assoc($result);  //echo "1<pre>"; print_r($row); echo "</pre>"; // exit;
		$inv_num=substr($processed_date,2,2);
		$exp=explode("_",$row['invoice_number']);
		if(date("y")==$inv_num)
			{
			$var_num=$exp[1]+1;
			$pass_invoice_number=$inv_num."_".$var_num;
			}
			else
			{
			$var_num=1001;
			$pass_invoice_number=$inv_num."_".$var_num;
			}
		}
 		$insert_comments=$invoice_comments;
	$invoice_date=date("Y-m-d");
	$sql="INSERT ignore INTO  invoices 
			set park_code='$park_code', center='$center', processed_date='$processed_date', invoice_date='$invoice_date', invoice_number='$pass_invoice_number', invoice_comments='$insert_comments', entered_by='$entered_by'";
//   	echo " 129 $sql<br /><br />"; exit;
			$result = mysqli_query($connection, $sql) or die ("Couldn't execute query. $sql ".mysqli_error($connection));
	$sql="SELECT *
			From invoices 
			where invoice_number='$pass_invoice_number'";
// 	echo "$sql"; exit;
			$result = mysqli_query($connection, $sql) or die ("Couldn't execute query. $sql ".mysqli_error($connection));
			while($row=mysqli_fetch_assoc($result))
				{
				$ARRAY_invoices[]=$row;
				}
			$fieldNames=array_values(array_keys($ARRAY_invoices[0]));
	foreach($item_array as $k=>$v)
		{
		$sql="UPDATE park_order as t1 set t1.invoice_number='$pass_invoice_number' where t1.park_code='$park_code' AND t1.ordered='x' AND t1.processed_date='$processed_date'";
		$result = mysqli_query($connection, $sql) or die ("Couldn't execute query. $sql ".mysqli_error($connection));
		}
//exit;
	}
	else
	{
	echo "The system already has an invoice for $center on the $processed_date date.<br /><br />Click your browser's back button.";
	$sql="SELECT * FROM invoices as t1 where t1.center='$center' AND t1.processed_date='$processed_date'";
	$result = mysqli_query($connection, $sql) or die ("Couldn't execute query. $sql ".mysqli_error($connection));
	while($row=mysqli_fetch_assoc($result))
		{
		$ARRAY_1[]=$row;
		}
		$skip=array();
		$c=count($ARRAY_1);
		echo "<table><tr><td>$c</td></tr>";
		foreach($ARRAY_1 AS $index=>$array)
			{
			if($index==0)
				{
				echo "<tr>";
				foreach($ARRAY_1[0] AS $fld=>$value)
					{
					if(in_array($fld,$skip)){continue;}
					echo "<th>$fld</th>";
					}
				echo "</tr>";
				}
			echo "<tr>";
			foreach($array as $fld=>$value)
				{
				if(in_array($fld,$skip)){continue;}
				echo "<td>$value</td>";
				}
			echo "</tr>";
			}
		echo "</table>";
	exit;
	}

define ("PAGE_WIDTH", 612); // 8.5 inches
define ("PAGE_HEIGHT",792); // 11 inches

// Create the PDF.	
$pdf = pdf_new(); include("/opt/library/prd/WebServer/include/pdf_key_23.php");
pdf_open_file ($pdf, "");

// Set the different PDF values.
pdf_set_info ($pdf, "Author", "Tom Howard");
pdf_set_info ($pdf, "Title", "NC State Lakes Database");
pdf_set_info ($pdf, "Creator", "See Author");

// Create the pages.

//PDF_load_font ( resource $pdfdoc , string $fontname , string $encoding , string $optlist )
		$arial = PDF_load_font ($pdf, "Helvetica", "winansi","");
		

$array_x=array("sort_order"=>"-6","processed_date"=>"24","invoice_number"=>"89","center"=>"128", "account"=>"175", "sold_by_unit"=>"215", "price"=>"248", "cost"=>"285", "product_number"=>"320", "quantity"=>"355", "product_title"=>"390");
$title_array=array("sort_order"=>"sort","processed_date"=>"          date","invoice_number"=>"invoice","center"=>"center","product_number"=>"WARE#", "sold_by_unit"=>"unit", "quantity"=>"quantity", "price"=>"price","cost"=>"cost","account"=>"account","product_title"=>"product_title");
$i=0;
$var_page=0;
$num_items=count($ARRAY);
if($num_items>29)  // see line 375   $ARRAY starts at 0 but $max_lines "starts" at 1
	{
	$max_lines=31;
	if(fmod($num_items,$max_lines)==0){$max_lines=32;}
	}
	else
	{$max_lines=30;}

$totPageNum=ceil(count($ARRAY)/$max_lines);
//$size_10_array=array("quantity","product_number");
$size_10_array=array("quantity");

// echo "214<pre>"; print_r($ARRAY); echo "</pre>";  exit;
foreach($ARRAY as $index=>$array)
	{
	@$invoice_total+=str_replace(",","",$array['cost']);
	@$quantity_total+=$array['quantity'];
	}

foreach($ARRAY as $index=>$array)
	{
// 	if($index>=61){continue;}   // used for troubleshooting
	extract($array);

	if($i==0)
		{
		pdf_begin_page ($pdf, PAGE_WIDTH, PAGE_HEIGHT);
		pdf_setfont ($pdf, $arial, 10);
		if($var_page>0)
			{$y=750;}
			else
			{$y=685;}
		
		$text="Invoice Line Item Detail";
		pdf_show_xy ($pdf,$text,225,$y);
		// column headers
		$y=$y-14;
		pdf_setfont ($pdf, $arial, 8);
		foreach($array_x as $var_fld=>$x)
			{
			$text=$title_array[$var_fld];
			$x+=25;
			pdf_show_xy ($pdf,$text,$x,$y);
			}
		
		pdf_setfont ($pdf, $arial, 10);
		if($var_page==0)
			{
			pdf_setfont ($pdf, $arial, 14);
			$y=760;
			$text="DPR WAREHOUSE INVOICE";
			pdf_show_xy ($pdf,$text,210,$y);

			$y-=16;
			pdf_setfont ($pdf, $arial, 8);
			$rcc=substr($center,-4);
			$text="RCC:     $rcc";
			pdf_show_xy ($pdf,$text,25,$y);
			$qt=number_format($invoice_total,2);
			$text="Invoice Total:     $$qt";
			pdf_show_xy ($pdf,$text,255,$y);
			$text="Number of Products:  ".count($ARRAY);
			pdf_show_xy ($pdf,$text,255,$y-16);
			$text="Quantity of Items:  $quantity_total";
			pdf_show_xy ($pdf,$text,255,$y-26);
			// line 126
			$text="Invoice Date:        $invoice_date";
			pdf_show_xy ($pdf,$text,425,$y);

			$y-=12;
			$text="Park:     $park_code";
			pdf_show_xy ($pdf,$text,25,$y);
			$inv_num=substr($invoice_date,2,2);
			$var=$inv_num."_";
			if(empty($pass_invoice_number))
				{
				echo "This probably was an attempt to create a duplicate of an existing Invoice. If you think this is not the case, contact Tom Howard. Indicate an error at line 237 of invoice_pdf.php<br /><br />Click your browser's back button."; exit;
				$invoice_number=$var.(1000+$inv_id);
				$text="Invoice Number:   ".$invoice_number;
				}
				else
				{
				$invoice_number=$pass_invoice_number;
				$text="Invoice Number:   ".$pass_invoice_number;
				}
	
			pdf_show_xy ($pdf,$text,425,$y);
			
		$var_comments=$form_comments;
		if(empty($var_comments) and !empty($invoice_comments))
			{
			$var_comments=$invoice_comments;
			}
 		$insert_comments=$var_comments;
			
		$tempID=$_SESSION['ware']['tempID'];
		$link="invoices/20".substr($invoice_number,0,2)."/".$park_code."-".$invoice_number.".pdf";
		// 
	// 	$sql="SELECT * FROM  invoices WHERE invoice_number='$invoice_number'";
// 	//echo "$sql"; //exit;
// 		$result = mysqli_query($connection, $sql) or die ("Couldn't execute query. $sql ".mysqli_error($connection));
// 		if(mysqli_num_rows($result)>0)
// 			{
			$sql="UPDATE  invoices 
			set link='$link' where invoice_number='$invoice_number'";
			// }
// 			else
// 			{
// 			$sql="INSERT ignore INTO  invoices 
// 			set park_code='$park_code', center='$center', processed_date='$processed_date', invoice_number='$invoice_number', invoice_comments='$insert_comments', entered_by='$entered_by', link='$link'";
// //			}
		$result = mysqli_query($connection, $sql) or die ("Couldn't execute query. $sql ".mysqli_error($connection));
// 		echo "$sql"; exit;
// 				 echo "t=$text i=$invoice_number p=$pass_invoice_number"; exit;
			
			$y-=12;
			$text="Supt:     $pasu_name";
			pdf_show_xy ($pdf,$text,25,$y);
			$y-=12;
			$text="Comments: ".stripslashes($var_comments);
			pdf_show_xy ($pdf,$text,25,$y-2);
			
			$text="Page 1 of ".$totPageNum;
			pdf_setfont ($pdf, $arial, 8);
			pdf_show_xy ($pdf,$text,555,20);
			}
		
			$text="Invoice printed on ".date("Y-m-d H:i:s");
			pdf_setfont ($pdf, $arial, 8);
			pdf_show_xy ($pdf,$text,25,20);


		$var_page++;
		if($var_page>1)
			{$y=$y-2;}
			else
			{$y=$y-36;}
		}
	
	pdf_setfont ($pdf, $arial, 10);
// ****************** produce the item details *************************
// echo "<pre>"; print_r($array_x); echo "</pre>";  exit;
	$y=$y-20;
		
	$text="";
	$j=$index+1;
	foreach($array_x as $var_fld=>$x)
		{
		$text=${$var_fld};
		if($var_fld=="processed_date"){$text=$j."   ".$text;}
		if($var_fld=="quantity"){$x+=10;}
		$x+=25;
			$move_x=40;
		if($j<10 and $var_fld=="processed_date")
			{
			$x+=5;
			}
		if($j<10)
			{$move_x=45;}
		
		if(in_array($var_fld, $size_10_array))
			{pdf_setfont ($pdf, $arial, 10);}else{pdf_setfont ($pdf, $arial, 8);}
		pdf_show_xy ($pdf,$text,$x,$y);
		
		// draw line
		PDF_setlinewidth ( $pdf, 0.3 );
		pdf_moveto($pdf, $move_x, $y-3);
		pdf_lineto($pdf, 575, $y-3);
		pdf_stroke($pdf);
		}
	
	// Finish the page
	if(($i+1)==$max_lines)
		{
		$i=0;
		pdf_end_page ($pdf);
		}
		else
		{
		$i++;
		}
	}// end $ARRAY

$text="Invoice printed on ".date("Y-m-d H:i:s");
pdf_setfont ($pdf, $arial, 8);
pdf_show_xy ($pdf,$text,25,20);

$text="Page ".$var_page." of ".$totPageNum;
pdf_setfont ($pdf, $arial, 8);
pdf_show_xy ($pdf,$text,555,20);

pdf_end_page ($pdf);

// Close the PDF
pdf_close ($pdf);

// echo "I'm working on this function at the moment. Tom"; exit;

$buffer = pdf_get_buffer ($pdf);

// And a path where the file will be created
$folder = '/opt/library/prd/WebServer/Documents/ware/invoices/'.date("Y");
$dir="invoices/".date("Y");

if (!file_exists($folder)) {mkdir ($folder, 0777);}

if(empty($invoice_number)){$invoice_number=$pass_invoice_number;}

$file_name=$park_code."-".$invoice_number.".pdf";
$path=$folder."/".$file_name;
$link=$dir."/".$file_name;

// Then just save it like this
file_put_contents( $path, $buffer );

/*
// Send the PDF to the browser.
//$buffer = pdf_get_buffer ($pdf);
header ("Content-type: application/pdf");
header ("Content-Length: " . strlen($buffer));
header ('Content-Disposition: inline; filename='.$file_name);
echo $buffer;
*/

// Free the resources
pdf_delete ($pdf);
mysqli_close($connection);

include("../_base_top.php");
echo "Invoice successfully created.<br /><br />Click here to view/print invoice: <a href='$link'>$file_name</a>";
echo "<br /><br />Send an email to park notifying them their order has been processed.<br /><br />";
$email=$park_email;
$subject="Subject=Warehouse Order $invoice_number for $park_code";
$body="Body=The warehouse has processed the order submitted on $park_ordered_on. You can download the invoice at this link: https://10.35.152.9/ware/$link.";
$body="Body=The warehouse has processed the order submitted on $park_ordered_on. You can download the invoice at this link: https://10.35.152.9/ware/$link.";
echo "Email $park_code: <a href='mailto:$email?$subject&$body'>$email</a>";
?>