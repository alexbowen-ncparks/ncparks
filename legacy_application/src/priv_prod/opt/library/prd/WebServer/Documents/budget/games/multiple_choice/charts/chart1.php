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
include("../connect.php");// database connection parameters
$database="mamajone_games";
$db="mamajone_games";
//echo "hello world";exit;
	
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

$query5a="select players.player,sum(points)*10 as 'score' from scores left join players on scores.pid=players.pid left join games on scores.gid=games.gid where 1 group by scores.pid
order by score desc";



$result5a = mysqli_query($connection, $query5a) or die ("Couldn't execute query 5a. $query5a");

$values=array();
while ($row5a=mysqli_fetch_array($result5a))
	{
	$values[$row5a['player']]=$row5a['score'];
	}	
	
		
	
 
	$img_width=225;
	$img_height=150; 
	$margins=20;

 //Notes based on: $img_width=225; $img_height=150; $margins=20;
 
 
	# ---- Find the size of graph by substracting the size of borders
	$graph_width=$img_width - $margins * 2; //$graph_width=185 ((225-(20*2))
	$graph_height=$img_height - $margins * 2; //$graph_height=150-(20*2)=110
	$img=imagecreate($img_width,$img_height);

 
	$bar_width=20;
	$total_bars=count($values); //$total_bars=3
	$gap= ($graph_width- $total_bars * $bar_width ) / ($total_bars +1); 
	//numerator=((185-(3*20))=185-60=125
	//denominator=(3+1)=4
	//$gap=125/4=31.25
	//2 margins *20px each=40px //4 gaps *31.25px each=125px //3 bars * 20 px each=60px
	//total image width=40px (2 margins) + 125px (4 gaps) + 60px (3 bars) = 225px
	

 
	# -------  Define Colors ----------------
	$bar_color=imagecolorallocate($img,255,0,0); // blue variant
    $background_color=imagecolorallocate($img,240,240,255); // white variant
	//$background_color=imagecolorallocate($img,59,120,97); // white variant
	$border_color=imagecolorallocate($img,200,200,200); // grey variant
	//$line_color=imagecolorallocate($img,220,220,220); // grey variant
	//$line_color=imagecolorallocate($img,59,120,97); // seagreen
 
	# ------ Create the border around the graph ------

    imagefilledrectangle($img,0,0,$img_width,$img_height,$border_color);
	//$img=image resource
	//0,0 equal first x,y coordinates (0,0)
	//$img_width,$img_height= second x,y coordinates (225,150)
	//$border_color=grey 
	//final parameters (image resource,0,0,225,150,grey)
	//$img,1,1,448,298,grey variant
	//Tony imagefilledrectangle creates a GREY rectangle which occupies the entire Image resource
	
	imagefilledrectangle($img,$margins,$margins,$img_width-$margins,$img_height-$margins,$background_color);
	//$img=image resource
	//$margins,$margins equal first x,y coordinates (20,20)
	//$img_width-$margins,$img_height-$margins= second x,y coordinates (205,130)
	//$background_color=white
	//final parameters (image resource,20,20,205,130,white)
	//Tony imagefilledrectangle ABOVE creates a 2nd smaller WHITE rectangle which overwrites the inside of the original GREY rectangle

 
	# ------- Max value is required to adjust the scale	-------
	$max_value=max($values); //$max_value=390
	$ratio= $graph_height/$max_value; // 110/390=.282

 
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
 //NOTE: XY Coordinates begin in Top Left Corner. This means X Coordinate of 54.25 
 // signifies 54.25 pixels to the RIGHT of the Top left Corner
 // Y Coordinate of 10 signifies 10 pixels down from the Top
 //So X,Y coordinates 54.25 , 10  signifies 54.25 to the right and 10 down from Top Left Corner
 
	# ----------- Draw the bars here ------
	for($i=0;$i< $total_bars; $i++){ 
		# ------ Extract key and value pair from the current pointer position
		list($key,$value)=each($values); //tony,390
		
		if($key=="tony"){$bar_color=imagecolorallocate($img,255,0,0);}
		if($key=="tom"){$bar_color=imagecolorallocate($img,0,255,0);}
		if($key=="leanne"){$bar_color=imagecolorallocate($img,0,0,255);}
		
		
		$x1= $margins + $gap + $i * ($gap+$bar_width) ;
		//1st bar 20 + 31.25 + ((0)*(31.25+20)) = 51.25
		//2nd bar 20 + 31.25 + ((1)*(31.25+20)) = 102.50
		$x2= $x1 + $bar_width; 
		// 1st bar 51.25 + 20 = 71.25
		// 2nd bar 102.50 + 20 = 122.50
		$y1=$margins +$graph_height- intval($value * $ratio) ; //intval=(390*.282)=110 (100*.282)=28
		// 1st bar 20 + 110 - 110 = 20 
		// 2nd bar 20 + 110 - 28 = 82
		$y2=$img_height-$margins;
		// 1st bar 150 - 20 = 130
		// 2nd bar 150 - 20 =130
		
$value=number_format($value,0); 		
imagestring($img,2,$x1+3,$y1-15,$value,$bar_color); //Text at Top of Bars
		//1st Bar top text (img resource, 0 font, x=54.25(right), y=10(down), 390 textcolor=blue)
		//2nd Bar top text (img resource, 0 font, x=105.50 (right), y=72(down), 100 textcolor=blue)
		
 imagestring($img,2,$x1+3,$img_height-15,$key,$bar_color); //Text at Bottom of Bars	
		//1st Bar bottom text (img resource, 0 font, x=54.25 (right), y=135(down),tony, blue)
		//2nd Bar bottom text (img resource, 0 font, x=105.50 (right), y=135(down), tom, blue)		
		
imagefilledrectangle($img,$x1,$y1,$x2,$y2,$bar_color); //rectangle
	}
		//1st Bar (img resource, x1=51.25, y1=20, x2=71.25, y2=130, blue)
		//2nd Bar (img resource, x1=102.50, y1=82, x2=122.50, y2=130, blue)
	header("Content-type:image/png");
	imagepng($img);

?>

