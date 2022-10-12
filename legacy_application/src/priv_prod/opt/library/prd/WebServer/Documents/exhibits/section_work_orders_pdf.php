<?php
/*
$sql = "SELECT COUNT( t1.work_order_id ) as number, t2.section, t1.emp_id
FROM  `work_order` as t1
LEFT JOIN personnel as t2 on t1.emp_id=t2.emp_id
GROUP BY t2.section";  //echo "$sql"; exit;
*/

$sql = "SELECT COUNT( t1.work_order_id ) as number, t1.section, t1.emp_id
FROM  `work_order` as t1
GROUP BY t1.section";  //echo "$sql"; exit;
	
$result = mysqli_query($connection_i,$sql) or die ("Couldn't execute query 1. $sql");
while($row=mysqli_fetch_assoc($result))
	{
	$ARRAY[$row['section']]=$row;

	@$period_total+=$row['number'];
	// Get max value for graph X axis
	if($row['number']>@$maxD)
		{
		$maxD=$row['number'];
		}
	$i++;
	}

if(!array_key_exists("Forestry Museum",$ARRAY))
	{
	$ARRAY['Forestry Museum']['number']=0;
	$ARRAY['Forestry Museum']['section']="Forestry Museum";
	$ARRAY['Forestry Museum']['emp_id']="";
	$i++;
	}
if(!array_key_exists("IT Services",$ARRAY))
	{
	$ARRAY['IT Services']['number']=0;
	$ARRAY['IT Services']['section']="IT Services";
	$ARRAY['IT Services']['emp_id']="";
	}
	ksort($ARRAY);
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
$Sname=$period_total." Work Orders by Section - NC Museum of Natural Sciences - ".$year;

PDF_setfont($pdf, $timesBoldItalic, 12.0);
pdf_set_value ($pdf, "textrendering", 0);
$width = (pdf_stringwidth ($pdf,$Sname, $timesBoldItalic, 12)/2);
pdf_show_xy ($pdf, $Sname, (PAGE_WIDTH/2)-$width, PAGE_HEIGHT-25);


pdf_setlinewidth($pdf, 0.5);// chart axis
$x1=75;$y1=350; 
$frameHeight=480; // vert. axis $y2line - $y? should equal $frameHeight
$gap=1;
$barW=30;
$gapBar=$gap+$barW;
$increment=(1*$gapBar);
	$mDownC=268;


	pdf_setfont ($pdf, $helvetica, 10);
// Make days
$text=$ARRAY[0]['section'];
	if($text=="")
		{
		$m1=33;
		}
		else
		{$m1=108;}

//echo "<pre>"; print_r($ARRAY); echo "</pre>";  exit;

// Create x-legend
$section_array=array("Administration"=>"60","Education"=>"140","Educational Living Collections"=>"200","Exhibits"=>"270","External Affairs"=>"333","Forestry Museum"=>"400", "Friends"=>"465", "IT Services"=>"530", "Nature Research Center"=>"595","Prairie Ridge"=>"665","Research and Collections"=>"720");
foreach($ARRAY as $k=>$array)
	{
	$text=$ARRAY[$k]['section'];
//	if($text==""){
//		$unk=$ARRAY[0]['emp_id'];$test=1;}
		
	$exp=explode(" ",$text);
	$y=75;
	foreach($exp as $k=>$v)
		{
		$sect_x=$section_array[$text];
		pdf_show_xy ($pdf, $v,$sect_x, $y-=11);
		}
		$m1+=65;
		$x_legend[$text]=$m1;
	}
//echo "<pre>"; print_r($x_legend); echo "</pre>";  exit;

if(!empty($test)){pdf_show_xy ($pdf, $unk,$sect_x+70, 65);}
	
pdf_setcolor ($pdf, 'both', 'rgb', 0, 0, 0, 0); 


	pdf_setfont ($pdf, $helvetica, 6);		
// Vertical legend Description
PDF_set_value ( $pdf, "leading", 7 );
$text="N u m b e r

o f

W o r k

O r d e r s";
$xBox=48;$yBox=-105;
$width=6;$height=500;$just="center";$feature="blind";
$leftOver=pdf_show_boxed($pdf,$text,$xBox,$yBox,$width,$height,$just,$feature);
if(!isset($mode)){$mode="";}
if($leftOver==0){pdf_show_boxed($pdf,$text,$xBox,$yBox,$width,$height,$just,$mode);}


	$x2line=598; // ************* end point for axis and dashes

// Make base horiz. axis for Coastal Plain
$yc=349.5-$mDownC;
pdf_moveto($pdf, $x1-.249, $yc);
$y2line=$yc;
$x2line=760;
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

$xx=$x1-13;$xy=$y1-268-.25;

		PDF_setrgbcolor_fill($pdf,0,0,1);  // Blue bars

pdf_setfont ($pdf, $timesItalic, 12);
foreach($ARRAY as $index=>$row)
	{
	$a=$row['number'];
	$s=$row['section'];
	if(empty($row['section']))
		{
		$null=1; $null_num=$a; continue;
		}
	if($a<10){$numA=" ".$a;}else{$numA=$a;}
	if($maxX>100 and $a<2){$a=2;}
	$a=($frameHeight * $a / $maxX);
//	echo "a=$a"; exit;
	$xx=$x_legend[$row['section']]-50;
	$xx=$xx+$barW;
		pdf_show_xy ($pdf, number_format($numA,0),$xx+15, $a+85);
				
		// drill down link
		if(@isset($linkDB1[$jk]))
			{
			$db1=@$jk."_b";
			}
		if(!isset($park)){$park="";}
		
		$sect=str_replace(" ","_",$row['section']);
		$link="http://nature123.net/work_order/r_wo_section.php?year=$year&section=$sect&submit=Enter";
			$starting_xpos = $xx+5;
			$starting_ypos = $a+83;
	if($a>0)
		{
		pdf_add_weblink($pdf, $starting_xpos, $starting_ypos, $starting_xpos + 24, $starting_ypos + 12, $link);}
	
			
	pdf_rect($pdf,$xx,$xy,$barW,$a);pdf_fill($pdf);
	}
	
// submitted by employee not in personnel table
	$xx=$xx+$barW+$gap+40;
	if(!empty($null))
	{
	pdf_rect($pdf,$xx,$xy,$barW,$a);pdf_fill($pdf);
	pdf_show_xy ($pdf, number_format($null_num,0),$xx+15, $a+85);
	}
	
pdf_setcolor ($pdf, 'both', 'rgb', 0, 0, 0, 0); 

?>