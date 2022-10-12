<?php

// This array of values is just here for the example.

    $values = array("23","32","35","57","12",
                    "3","36","54","32","15");

// Get the total number of columns we are going to plot

    $columns  = count($values);
// $columns=10

// Get the height and width of the final image

    $width = 600;
    $height = 300;

// Set the amount of space between each column

    $padding = 5;

// Get the width of 1 column

    $column_width = $width / $columns ;
// $column_width=300/10=30

// Generate the image variables

    $im        = imagecreate($width,$height);
    $red      = imagecolorallocate ($im,255,0,0);
    $green = imagecolorallocate ($im,0,255,0);
    $blue = imagecolorallocate ($im,0,0,255);
    $white     = imagecolorallocate ($im,255,255,255);
    
// Fill in the background of the image
//The imagefilledrectangle() function takes six parameters in total, which are, in order:
// 1)image resource 2)point 1x 3)point 1y 4)point 2x 5)point 2y  6)Color

    imagefilledrectangle($im,0,0,$width,$height,$green);
  
    $maxv = 0;

// Calculate the maximum value we are going to plot

    for($i=0;$i<$columns;$i++)$maxv = max($values[$i],$maxv);

// Now plot each column
        
    for($i=0;$i<$columns;$i++)
    {
        $column_height = ($height / 100) * (( $values[$i] / $maxv) *100);
		
		//first time thru= $column_height=(150/100)*((23/57)*100)=60.53
		//second time thru= $column_heigh=(150/100)*((32/57)*100)=84.21

        $x1 = $i*$column_width;
		//$x1=0*30=0
		//$x1=1*30=30
		
        $y1 = $height-$column_height;
		// $y1=150-60.53=89.47
		// $y1=150-84.21=65.79
		
        $x2 = (($i+1)*$column_width)-$padding;
		// $x2=((0+1)*30)-5=25
		// $x2=((1+1)*30)-5=55
		
        $y2 = $height;
		//$y2=150
		//$y2=150

        imagefilledrectangle($im,$x1,$y1,$x2,$y2,$blue);
		// ($im,0,89.47,25,150)
		// ($im,30,65.79,55,150)

// This part is just for 3D effect

       // imageline($im,$x1,$y1,$x1,$y2,$gray_lite);
       // imageline($im,$x1,$y2,$x2,$y2,$gray_lite);
      //  imageline($im,$x2,$y1,$x2,$y2,$gray_dark);

    }

// Send the PNG header information. Replace for JPEG or GIF or whatever

    header ("Content-type: image/png");
    imagepng($im);
?>