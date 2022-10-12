<?php
    $image = imagecreate(400,300);
    $gold = imagecolorallocate($image, 255, 240, 00);
	$white = imagecolorallocate($image, 255, 255, 255);
	imagefilledrectangle($image, 10, 10, 390, 290, $white);
	imagepng($image);
?>	