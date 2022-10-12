<?php

$image = new Imagick();
$image->readImageBlob(file_get_contents('play1.svg'));
$image->setImageFormat("png24");
$image->resizeImage(1024, 768, imagick::FILTER_LANCZOS, 1); 
$image->writeImage('image.png')


?>