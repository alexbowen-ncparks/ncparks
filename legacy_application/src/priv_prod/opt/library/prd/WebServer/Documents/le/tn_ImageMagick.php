<?php

$file="uploads/images/2012/imagesHARO3202.JPG";


$image = new Imagick($file); 
$image->thumbnailImage(150, 0); 
//echo $image;
$image->writeImage("uploads/images/2012/ztn.imagesHARO3202.JPG");
$image->destroy();
?>


