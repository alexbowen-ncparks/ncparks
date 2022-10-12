 <?php
    $image = imagecreate(400,300);
    $gold = imagecolorallocate($image, 255, 240, 00);
    $white = imagecolorallocate($image, 255, 255, 255);
    $colour = $white;

    for ($i = 400, $j = 300; $i > 0; $i -= 4, $j -= 3) {
        if ($colour == $white) {
            $colour = $gold;
        } else {
            $colour = $white;
        }

        imagefilledrectangle($image, 400 - $i, 300 - $j, $i, $j, $colour);
    }

    imagepng($image);
    imagedestroy($image);
?> 