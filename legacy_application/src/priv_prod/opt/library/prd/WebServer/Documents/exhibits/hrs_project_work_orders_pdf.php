<?php
$sql = "SELECT sum(t2.time) as hours, t1.work_order_number
FROM `work_order` as t1
left join work_order_workers as t2 on t1.work_order_number=t2.work_order_number
where date_completed!=''
group by t2.work_order_number
order by hours desc";  //echo "$sql"; exit;
	
$result = mysqli_query($connection_i,$sql) or die ("Couldn't execute query 1. $sql");
$check_hours="";
while($row=mysqli_fetch_assoc($result))
	{
	$ARRAY[]=$row['hours'];
	@$period_total+=$row['hours'];
	// Get max value for graph X axis
	if($row['hours']>@$maxD)
		{
		$maxD=$row['hours'];
		}
	}
$spread=array_count_values($ARRAY);
arsort($spread);
//echo "<pre>"; print_r($ARRAY); print_r($spread);echo "</pre>";  exit;
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
$var_c=count($ARRAY);
$Sname=$period_total." Hours Recorded for $var_c Completed Work Orders - NC Museum of Natural Sciences - ".$year;

PDF_setfont($pdf, $timesBoldItalic, 12.0);
pdf_set_value ($pdf, "textrendering", 0);
$width = (pdf_stringwidth ($pdf,$Sname, $timesBoldItalic, 12)/2);
pdf_show_xy ($pdf, $Sname, (PAGE_WIDTH/2)-$width, PAGE_HEIGHT-25);


pdf_setlinewidth($pdf, 0.5);// chart axis
$x1=75;$y1=350; 
$frameHeight=480; // vert. axis $y2line - $y? should equal $frameHeight
$gap=19;
$barW=10;
$gapBar=$gap+$barW;
$increment=(6*$gapBar);
	$mDownC=268;


	pdf_setfont ($pdf, $helvetica, 8);

//echo "<pre>"; print_r($ARRAY); echo "</pre>";  exit;

// Create x-legend
$section_array=array("Administration"=>"90","Education"=>"195","Educational Living Collections"=>"280","Exhibits"=>"380","External Affairs"=>"450","Friends"=>"563","Nature Research Center"=>"630");

$m1=45;
$y2-=88;
    pdf_rotate($pdf, 90); /* rotate coordinates clockwise*/
for($i=1;$i<=count($ARRAY);$i++)
	{
	$text=$ARRAY[$i-1]['work_order_number'];
//	$text=substr($text,-4,4);
	pdf_show_xy ($pdf, $text,$m1, $y2);
	$y2-=19;
	}
pdf_setcolor ($pdf, 'both', 'rgb', 0, 0, 0, 0); 

    pdf_rotate($pdf, -90); /* rotate coordinates back*/;


	pdf_setfont ($pdf, $helvetica, 6);		
// Vertical legend Description
PDF_set_value ( $pdf, "leading", 7 );
$text="N u m b e r

o f

H o u r s";

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

$xx=$x1-13;$xy=$y1-268-.25;

		PDF_setrgbcolor_fill($pdf,0,0,1);  // Blue bars

pdf_setfont ($pdf, $timesItalic, 10);
foreach($spread as $number=>$hours)
	{
	$a=$hours;
	if($a<10){$numA=" ".$a;}else{$numA=$a;}
	if($maxX>100 and $a<2){$a=2;}
	$a=($frameHeight * $a / $maxX);
//	echo "a=$a"; exit;
//	$xx=$x_legend[$row['section']]-110;
	$xx=$xx+$barW+$gap;
		pdf_show_xy ($pdf, number_format($numA,1),$xx, $a+85);
		pdf_show_xy ($pdf, "(".$number.")",$xx, $a+95);

$link="http://nature123.net/work_order/r_hours_work_order.php?work_order_number=$wo&submit=Enter";
			$starting_xpos = $xx+1;
			$starting_ypos = $a+83;
			pdf_add_weblink($pdf, $starting_xpos, $starting_ypos, $starting_xpos + 22, $starting_ypos + 10, $link);
			
	pdf_rect($pdf,$xx,$xy,$barW,$a);pdf_fill($pdf);
	}
	
pdf_setcolor ($pdf, 'both', 'rgb', 0, 0, 0, 0); 

?>