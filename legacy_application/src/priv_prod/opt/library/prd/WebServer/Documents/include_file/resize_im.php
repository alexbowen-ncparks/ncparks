<?php
$image = new Imagick("test4.jpg");
$image->thumbnailImage(200, 0);
header("Content-type: image/jpeg");
echo $image;
?>