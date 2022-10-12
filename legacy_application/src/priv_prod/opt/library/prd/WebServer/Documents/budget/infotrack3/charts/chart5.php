<?php
//http://www.qualitycodes.com/tutorial.php?articleid=20&title=How-to-create-bar-graph-in-PHP-with-dynamic-scaling
	# ------- The graph values in the form of associative array
session_start();
/*
$active_file=$_SERVER['SCRIPT_NAME'];
$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempID=$_SESSION['budget']['tempID'];
$beacnum=$_SESSION['budget']['beacon_num'];
$user_activity_location=$_SESSION['budget']['select'];
$user_activity_center=$_SESSION['budget']['centerSess'];
*/
extract($_REQUEST);	

$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
include("../../../../include/activity.php");// database connection parameters
//include("../budget/~f_year.php");
include("../../../budget/~f_year.php");
	
/*	
	
	$values=array(
		"Jan" => 110,
		"Feb" => 130,
		"Mar" => 215,
		"Apr" => 81,
		"May" => 310,
		"Jun" => 110,
		"Jul" => 190,
		"Aug" => 175,
		"Sep" => 390,
		"Oct" => 286,
		"Nov" => 150,
		"Dec" => 196
	);
*/
$query5="SELECT center.parkcode as 'parkcode',round((sum(exp_rev.debit-exp_rev.credit))/12,0) as 'amount'
FROM exp_rev
left join center on exp_rev.center=center.center
where 1
and f_year='1415'
and center.fund='1280'
and center.dist='east'
and actcenteryn='y'
and (acct='532814')
group by exp_rev.center
order by amount desc

";

$result5 = mysqli_query($connection, $query5) or die ("Couldn't execute query 5. $query5");
$values=array();
while ($row5=mysqli_fetch_array($result5))
	{
	$values[$row5['parkcode']]=$row5['amount'];
	}	
	
		
	
 
	$img_width=850;
	$img_height=600; 
	$margins=90;

 
	# ---- Find the size of graph by substracting the size of borders
	$graph_width=$img_width - $margins * 2; //$graph_width=410
	$graph_height=$img_height - $margins * 2; //$graph_height=300-40-=260
	$img=imagecreate($img_width,$img_height);

 
	$bar_width=20;
	$total_bars=count($values); //$total_bars=1
	$gap= ($graph_height- $total_bars * $bar_width ) / ($total_bars +1); 
	//(260-1*20)/(2)
	//gap=120

 
	# -------  Define Colors ----------------
	$bar_color=imagecolorallocate($img,0,64,128); // blue variant
	$bar_color2=imagecolorallocate($img,255,0,0); // blue variant
    $background_color=imagecolorallocate($img,240,240,255); // white variant
	//$background_color=imagecolorallocate($img,59,120,97); // white variant
	$border_color=imagecolorallocate($img,200,200,200); // grey variant
	//$line_color=imagecolorallocate($img,220,220,220); // grey variant
	$line_color=imagecolorallocate($img,59,120,97); // seagreen
 
	# ------ Create the border around the graph ------

    imagefilledrectangle($img,1,1,$img_width-1,$img_height-1,$border_color);
	//$img,1,1,448,298,grey variant
	imagefilledrectangle($img,$margins,$margins,$img_width-1-$margins,$img_height-1-$margins,$background_color);
	//imagefilledrectangle($img,20,20,$img_width-1-40,$img_height-1-40,$background_color);
	
	
	//$img,20,20,429,279,white variant

 
	# ------- Max value is required to adjust the scale	-------
	$max_value=max($values); //$max_value=110
	$ratio= $graph_width/$max_value; // 410/110=3.7273

 
	# -------- Create scale and draw horizontal lines  --------
/*	
	$horizontal_lines=20;
	$horizontal_gap=$graph_height/$horizontal_lines; // 260/20=13

	for($i=1;$i<=$horizontal_lines;$i++){
		$y=$img_height - $margins - $horizontal_gap * $i ;
		// 300-20-13*1=280-13*1=267
		imageline($img,$margins,$y,$img_width-$margins,$y,$line_color);
		// $img,20,267,430,267,seagreen
		$v=intval($horizontal_gap * $i /$ratio);
		// $v=intval(13*1/.67)=19
		// $v=intval (13*2/.67)=39
		imagestring($img,0,5,$y-5,$v,$bar_color);
		//image,font,x-upper left,y-upper left,string,color

	}
 
 */
 
 imagestring($img,5,400,50,'Total Expenditures',$bar_color);
	# ----------- Draw the bars here ------
	for($i=0;$i< $total_bars; $i++){ 
		# ------ Extract key and value pair from the current pointer position
		list($key,$value)=each($values); 
		$x1= $margins ;
		//20
		$x2=$margins + intval($value * $ratio) ;
		//20+(110*3.7273)=430
		$y1= $margins + $gap + $i * ($gap+$bar_width) ;
		//20+120+(0*(120+20))=140
		$y2= $y1 + $bar_width; 
		//140+20=160
		imagestring($img,5,$x2+3,$y1+5,$value,$bar_color2);
		imagestring($img,5,3,$y1+5,$key,$bar_color);		
		imagefilledrectangle($img,$x1,$y1,$x2,$y2,$bar_color);
	}
	header("Content-type:image/png");

	imagepng($img);

?>

