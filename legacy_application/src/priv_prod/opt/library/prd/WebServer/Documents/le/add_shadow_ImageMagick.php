<?php 
/* Read the image into the object */ 
$filename="uploads/images/2012/imagesARCH2799.jpg";
$im = new Imagick($filename); 
$im->setImageFormat("png"); 
  
/* Make the image a little smaller, maintain aspect ratio */ 
$im->thumbnailImage( 200, null ); 
  
/* Clone the current object */ 
$shadow = $im->clone(); 
  
/* Set image background color to black 
        (this is the color of the shadow) */ 
$shadow->setImageBackgroundColor( new ImagickPixel( 'black' ) ); 
  
/* Create the shadow */ 
$shadow->shadowImage( 80, 3, 5, 5 ); 
  
/* Imagick::shadowImage only creates the shadow. 
        That is why the original image is composited over it */ 
$shadow->compositeImage( $im, Imagick::COMPOSITE_OVER, 0, 0 ); 
  
/* Display the image */ 
header( "Content-Type: image/png" ); 
echo $shadow;

?>