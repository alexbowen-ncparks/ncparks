<?php

//First of all declare an array of values for the graph. Declare these values in the form of associative array (i.e key and value pairs). Keys will be shown at the bottom as the graph legend and the values will be used to draw bars. 
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

//Now define the size of image, i have used an image of size 600x400 for this tutorial. 
$img_width=600;
$img_height=400; 

//The graph we are going to create has a border around it, i have declared a variable $margins to create that border around the four sides. 
$margins=20;


//Now find the size of graph by subtracting the size of borders. 

$graph_width=$img_width - $margins * 2; //$graph_width=560 >>>(600-20*2)
$graph_height=$img_height - $margins * 2; //$graph_height=360  >>> (400-20*2)

// Create an image of the size defined above 

$img=imagecreate($img_width,$img_height);

//Define the width of bar. Gap between the bars will depend upon the width and number of bars and the gaps will be one more than the total number of bars as there is gap on the right and left of the graph. You can see in our example, we have 12 bars but 13 gaps, thats why you see ($total_bars+1) in the denominator. 

$bar_width=20;
 $total_bars=count($values);
 //$total_bars=12
 $gap= ($graph_width- $total_bars * $bar_width ) / ($total_bars +1); 
 //$gap=(560-12*20)/(12+1)= (560-240)/13= 320/13= 24.6154

//Define colors to be used in the graph 

$bar_color=imagecolorallocate($img,0,64,128);
$background_color=imagecolorallocate($img,240,240,255); //$background_color=Primary (Blue)
// $background_color=imagecolorallocate($img,143,188,143); 
 $border_color=imagecolorallocate($img,200,200,200);  //$border_color=grey variant
 $line_color=imagecolorallocate($img,220,220,220);

//Create a border around the graph by filling in rectangle 

imagefilledrectangle($img,1,1,$img_width-2,$img_height-2,$border_color);
// $img=overall size of image
//point 1 x coordinate=1
//point 1 y coordinate=1
//point 2 x coordinate=598  ($img_width-2=600-2=598;)
//point 2 y coordinate=398  ($img_height-2=400-2=398;)
//color=$border_color=grey variant

// imagefilledrectangle($img,$margins,$margins,$img_width-1-$margins,$img_height-1-$margins,$background_color); 
 
 //imagefilledrectangle($img,20,20,$img_width-1-$margins,$img_height-1-$margins,$background_color);
 
 
 // $img=overall size of image
 // point 1 x coordinate=20
 // point 1 y coordinate=20
 // point 2 x coordinate=(600-1-20)=579
 // point 2 y coordinate=(400-1-20)=379
 //color=$background_color=Primary Blue
 
 
 header("Content-type:image/png");
	imagepng($img);


?>



