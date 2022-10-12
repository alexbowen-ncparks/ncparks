<?php
$fld=$donation_type."_donation_amount";
$sql = "SELECT sum($fld) as amount,count(park_code) as number, park_code,  left(date_donation_received,4)
FROM  `donor_donation` as t1
where park_code is not null
and t1.donation_type='$donation_type'
group by park_code, left(date_donation_received,4)
order by park_code";  echo "$sql<br /><br />"; exit;
	
$result = mysqli_query($connection,$sql) or die ("Couldn't execute query 1. $sql ".mysqli_error($connection));
while($row=mysqli_fetch_assoc($result))
	{
	$ARRAY_dt[]=$row['park_code'];
	}
$count_donor_type=array_count_values($ARRAY_dt);

//	echo "<pre>"; print_r($count_donor_type); echo "</pre>";  exit;
$sql = "SELECT sum( $fld ) as amount, count(*) as number, park_code
FROM  `donor_donation` as t1
where t1.donation_type='$donation_type'
GROUP BY park_code";  //echo "$sql"; exit;
	
$result = mysqli_query($connection,$sql) or die ("Couldn't execute query 1. $sql");
while($row=mysqli_fetch_assoc($result))
	{
	$ARRAY[]=$row;
	@$period_total+=$row['amount'];
	// Get max value for graph X axis
	if($row['amount']>@$maxD)
		{
		$maxD=$row['amount'];
		}
	}
//echo "<pre>"; print_r($ARRAY); echo "</pre>"; // exit;
//echo "$maxD"; exit;

if($maxD>0 and $maxD<10){$maxX=10;$bandIncrement=1;}
if($maxD>9 and $maxD<100){$maxX=ceil($maxD/10)*10;$bandIncrement=10;}
if($maxD>99 and $maxD<1000){$maxX=ceil($maxD/100)*100;$bandIncrement=100;}
if($maxD>999 and $maxD<10000){$maxX=ceil($maxD/1000)*1000;$bandIncrement=1000;}
if($maxD>9999 and $maxD<100000){$maxX=ceil($maxD/10000)*10000;$bandIncrement=10000;}
if($maxD>99999 and $maxD<1000000){$maxX=ceil($maxD/100000)*100000;$bandIncrement=100000;}

//echo "m=$maxX<br />";

// Make the graph
// fonts set in section_work_orders.php

//echo "<pre>"; print_r($ARRAY); echo "</pre>"; // exit;

$year=date("Y");
$pt=number_format($period_total,0);
$Sname="$".$pt." in $donation_type donations by Park - NC State Parks - thru ".$year;

PDF_setfont($pdf, $timesBoldItalic, 12.0);
pdf_set_value ($pdf, "textrendering", 0);
$width = (pdf_stringwidth ($pdf,$Sname, $timesBoldItalic, 12)/2);
pdf_show_xy ($pdf, $Sname, (PAGE_WIDTH/2)-$width, PAGE_HEIGHT-25);


pdf_setlinewidth($pdf, 0.5);// chart axis
$x1=75;$y1=350; 
$frameHeight=480; // vert. axis $y2line - $y? should equal $frameHeight
$gap=1;
$barW=7;
$gapBar=$gap+$barW;
$increment=(2*$gapBar);
	$mDownC=268;


	pdf_setfont ($pdf, $helvetica, 7);
// Start x-axis
$m1=95;

// Increment x-axis
$m1_gap=35;
//echo "<pre>"; print_r($ARRAY); echo "</pre>";  exit;

/// Create x-legend
		pdf_rotate($pdf, 90); /* rotate coordinates */

		$sect_x=55;
		$sect_y=-85;

//echo "<pre>"; print_r($ARRAY); echo "</pre>";  exit;
foreach($ARRAY as $index=>$array)
	{
	$text=$ARRAY[$index]['park_code'];  //echo "t=$text"; exit;  ******************************
	$exp=explode("/",$text);
	$len=strlen($exp[0]);
	
		pdf_show_xy ($pdf, $text,$sect_x, $sect_y);
		//	$sect_x-=12;
			$sect_y-=20;
		$m1+=$m1_gap;
		
		$x_legend[$text]=$m1;
	}
    pdf_rotate($pdf, -90); /* rotate coordinates */;
    
    
pdf_setcolor ($pdf, 'both', 'rgb', 0, 0, 0, 0); 


	pdf_setfont ($pdf, $helvetica, 6);		
// Vertical legend Description
PDF_set_value ( $pdf, "leading", 7 );
$text="D O L L A R S

C O N T R I B U T E D";

$xBox=48;$yBox=-105;
$width=5;$height=500;$just="center";$feature="blind";
$leftOver=pdf_show_boxed($pdf,$text,$xBox,$yBox,$width,$height,$just,$feature);
if(!isset($mode)){$mode="";}
if($leftOver==0){pdf_show_boxed($pdf,$text,$xBox,$yBox,$width,$height,$just,$mode);}


	$x2line=598; // ************* end point for axis and dashes

// Make base horiz. axis for Coastal Plain
$yc=349.5-$mDownC;
pdf_moveto($pdf, $x1-.249, $yc);
$y2line=$yc;
$x2line=755;
pdf_lineto($pdf, $x2line, $y2line); pdf_stroke($pdf);
$leg="0";
pdf_setfont ($pdf, $helvetica, 5);
pdf_show_xy ($pdf, $leg,$x1-4.5, $yc-2);


// Make dashes lines for Coastal Plain   $x2line=595;
pdf_setdash($pdf,.5,.5);
$n=$maxX/$bandIncrement;$band=$frameHeight/$n;

for($inc=1;$inc<=$n;$inc++)
	{
	@$bandLevel+=$band;
	// echo "max=$maxX n=$n  b=$band bl=$bandLevel<br>";exit;
	$ytc=$yc+$bandLevel; pdf_moveto($pdf, $x1-.249, $ytc);
	$y2line=$ytc;
	pdf_lineto($pdf, $x2line, $y2line); pdf_stroke($pdf);
	$leg+=$bandIncrement;
	$wxl=pdf_stringwidth($pdf,$leg, $helveticaBold, 5);
	pdf_show_xy ($pdf, $leg,$x1-$wxl-2, $ytc-2);
	}

		pdf_setcolor ($pdf, 'both', 'rgb', 0, 0, 0, 0); 
pdf_setdash($pdf,0,0);
		pdf_setfont ($pdf, $timesItalic, 8);
		pdf_set_value ($pdf, "textrendering", 0);
		if(!@$numC){$numC=0;}
		$Ptext="n=$numC";
	//	pdf_show_xy ($pdf, $Ptext,$x1+540, $ytc-10);
	//	pdf_show_xy ($pdf, 'Coastal Plain',$x1+550, $ytc-18);




// Make vertical axis for Coastal Plain
pdf_moveto($pdf, $x1, $yc);
$x2line=$x1;$y2line=(2*$frameHeight)-398;//$y2line=600.25;
pdf_lineto($pdf, $x2line, $y2line); pdf_stroke($pdf);

// chart columns
pdf_setlinewidth($pdf, 0.25);

//PDF_rect ($pdf, float $x, float $y, float $width, float $height )

$xx=$x1;$xy=$y1-268-.25;

		PDF_setrgbcolor_fill($pdf,0,0,1);  // Blue bars

pdf_setfont ($pdf, $timesItalic, 12);
@$rotate_y-=66;

$xx=79;
foreach($ARRAY as $index=>$row)
	{
	$a=$row['amount'];
	$dt=$row['park_code'];
	if($a<10){$numA=" ".$a;}else{$numA=$a;}
	if($maxX>100 and $a<2){$a=2;}
	$a=($frameHeight * $a / $maxX);
//	echo "a=$a"; exit;
//	$xx=$x_legend[$row['park_code']]-60;  // position vert bar
//	$xx=$xx+$barW+$gap;
	$column_value="$".number_format($numA,0);
	$dt_num=@$ARRAY_dt[$dt];
//	$column_value.=" - ".@$count_donor_type[$dt]." parks";

		pdf_rotate($pdf, 90); /* rotate coordinates */
		$rotate_y-=20;
		pdf_show_xy ($pdf, $column_value,$a+85, $rotate_y);  // amount of money
		pdf_rotate($pdf, -90); /* rotate coordinates */
				
		// drill down link
		if(@isset($linkDB1[$jk]))
			{
			$db1=@$jk."_b";
			}
		if(!isset($park)){$park="";}
		
		$park_code=str_replace(" ","_",$row['park_code']);
		$link="/donation/donation_find.php?park=$park_code&donation_type=$donation_type&submit_label=Find&source=graph";
		$link="/donation/donation_find.php?park=$park_code&donation_type=$donation_type&submit_label=Find&source=graph";
			$starting_xpos = $xx;
			$starting_ypos = $a+83;
			if($row['amount']>0)
				{
				pdf_add_weblink($pdf, $starting_xpos, $starting_ypos-5, $starting_xpos + 8, $starting_ypos + 1, $link);
				}
		
	pdf_rect($pdf,$xx,$xy,$barW,$a);
	$xx+=20;
	pdf_fill($pdf);
	}
	
pdf_setcolor ($pdf, 'both', 'rgb', 0, 0, 0, 0); 

?>