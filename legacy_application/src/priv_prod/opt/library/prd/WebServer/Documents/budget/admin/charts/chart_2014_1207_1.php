<?php
//http://www.qualitycodes.com/tutorial.php?articleid=20&title=How-to-create-bar-graph-in-PHP-with-dynamic-scaling
	# ------- The graph values in the form of associative array
session_start();
$today=date("Ymd", time() );
if($today_date == ''){$today_date=$today;}
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
$query5="SELECT tempid as 'player', user_level,location, count(id) as 'hits'
FROM `report_user_activity_today` 
WHERE 1 AND user_browser != 'Trend Micro Web Protection Add-On 1.2.1029'
and time2='$today_date'
GROUP BY tempid
ORDER BY `tempid` ASC";

$result5 = mysqli_query($connection, $query5) or die ("Couldn't execute query 5. $query5");
$values=array();
while ($row5=mysqli_fetch_array($result5))
	{
	$values[$row5['player']]=$row5['hits'];
	}	
	
		
	
 
	$img_width=450;
	$img_height=300; 
	$margins=20;

 
	# ---- Find the size of graph by substracting the size of borders
	$graph_width=$img_width - $margins * 2; //$graph_width=410
	$graph_height=$img_height - $margins * 2; //$graph_height=300-40-=260
	$img=imagecreate($img_width,$img_height);

 
	$bar_width=20;
	$total_bars=count($values); //$total_bars=7
	$gap= ($graph_width- $total_bars * $bar_width ) / ($total_bars +1); 
	//(410-7*20)/8
	//(270)/8 = 33.75	

 
	# -------  Define Colors ----------------
	$bar_color=imagecolorallocate($img,0,64,128); // blue variant
    $background_color=imagecolorallocate($img,240,240,255); // white variant
	//$background_color=imagecolorallocate($img,59,120,97); // white variant
	$border_color=imagecolorallocate($img,200,200,200); // grey variant
	//$line_color=imagecolorallocate($img,220,220,220); // grey variant
	//$line_color=imagecolorallocate($img,59,120,97); // seagreen
 
	# ------ Create the border around the graph ------

    //imagefilledrectangle($img,1,1,$img_width-1,$img_height-1,$border_color);
    imagefilledrectangle($img,1,1,449,299,$border_color);
	//$img,1,1,449,299,grey variant
	//imagefilledrectangle($img,$margins,$margins,$img_width-1-$margins,$img_height-1-$margins,$background_color);
	imagefilledrectangle($img,20,20,429,279,$background_color);
	
	
	//$img,20,20,429,279,white variant

 
	# ------- Max value is required to adjust the scale	-------
	$max_value=max($values); //$max_value=100
	$ratio= $graph_height/$max_value; // 260/100=2.60

 
	# ----------- Draw the bars here ------
	for($i=0;$i< $total_bars; $i++){ 
		# ------ Extract key and value pair from the current pointer position
		list($key,$value)=each($values); 
		$x1= $margins + $gap + $i * ($gap+$bar_width) ;
		//20+33.75+((0)*(33.75+20))=53.75
		$x2= $x1 + $bar_width; 
		//53.75+20=73.75
		$y1=$margins +$graph_height- intval($value * $ratio) ;
		//20+260-intval(11*.2.60)=251.40
		$y2=$img_height-$margins;
		//300-20=280
		imagestring($img,0,$x1+3,$y1-10,$value,$bar_color);
		imagestring($img,0,$x1+3,$img_height-15,$key,$bar_color);		
		imagefilledrectangle($img,$x1,$y1,$x2,$y2,$bar_color);
	}
	header("Content-type:image/png");
	imagepng($img);

?>

