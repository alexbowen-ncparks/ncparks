<?php

$Array= array(0,80,23,1100,190,245,50,80,111,240,55);
$Array_normal = array(0,80,23,1100,190,245,50,80,111,240,55);

$count = count($Array);
$arraySum = array_sum($Array);

$imgWidth=250;
$imgHeight=250;

    for ($i=0; $i<=$count; $i++)
    {
        $Array[$i] = $Array[$i] / $arraySum * $imgHeight;        
    }

header("Content-type: image/png");

$image=imagecreate($imgWidth, $imgHeight);
$colorWhite=imagecolorallocate($image, 255, 255, 255);
$colorGrey=imagecolorallocate($image, 192, 192, 192);
$colorBlue=imagecolorallocate($image, 0, 0, 255);
$colorBlack=imagecolorallocate($image, 0, 0, 0);

    imagerectangle($image,0,1,$imgWidth-2,$imgHeight-2,$colorBlue);  

    for ($i=1; $i<$count+1; $i++)
    {
        imageline($image, $i*25, 0, $i*25, $imgWidth, $colorGrey);
        imageline($image, 0, $i*25, $imgHeight, $i*25, $colorGrey);
    }

    for ($i=0; $i<$count; $i++)
    {
        imageline($image, $i*25, ($imgWidth - $Array[$i]), ($i+1)*25, ($imgHeight - $Array[$i+1]), $colorBlue);
        imagestring($image, 4, $i*25 - 20,($imgWidth - $Array[$i] - 25), "($Array_normal[$i])" ,$colorBlack);
    }
    
imagepng($image);

?> 