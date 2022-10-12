<?php

$func = "imagecreatefromjpeg";
		
		$imgOrig = @$func($filename);
		$imgFinal = @$func($filename);
if($imgFinal == NULL){echo "no go"; exit;}
applyShadow($imgFinal,$imgOrig,$filename);

	function applyShadow($imgFinal,$imgOrig,$filename)
	{
	$bgcolour = 'FFFFFF';
	$shadowPath="shadows/";
		// attempt to load the drop shadow array
		if ($shadows['l']  == NULL) $shadows['l']  = @ImageCreateFromPNG($shadowPath . "ds_left.png");
		if ($shadows['r']  == NULL) $shadows['r']  = @ImageCreateFromPNG($shadowPath . "ds_right.png");
		if ($shadows['t']  == NULL) $shadows['t']  = @ImageCreateFromPNG($shadowPath . "ds_top.png");
		if ($shadows['b']  == NULL) $shadows['b']  = @ImageCreateFromPNG($shadowPath . "ds_bottom.png");
		if ($shadows['tl'] == NULL) $shadows['tl'] = @ImageCreateFromPNG($shadowPath . "ds_tlcorner.png");
		if ($shadows['tr'] == NULL) $shadows['tr'] = @ImageCreateFromPNG($shadowPath . "ds_trcorner.png");
		if ($shadows['bl'] == NULL) $shadows['bl'] = @ImageCreateFromPNG($shadowPath . "ds_blcorner.png");
		if ($shadows['br'] == NULL) $shadows['br'] = @ImageCreateFromPNG($shadowPath . "ds_brcorner.png");

//print_r($shadows); exit;
		// create go-between image
		$ox = @ImageSX($imgFinal);
		$oy = @ImageSY($imgFinal);
		$nx = @ImageSX($shadows['l']) + @ImageSX($shadows['r']) + @ImageSX($imgFinal);
		$ny = @ImageSY($shadows['t']) + @ImageSY($shadows['b']) + @ImageSY($imgFinal);

//echo "ox=$ox, oy=$oy, nx=$nx, ny=$ny"; exit;


		$imgShadow = @ImageCreateTrueColor($nx, $ny);

// if($imgShadow!=NULL){echo "it exists"; exit;}

		// pre-process the image
		$background = _htmlHexToBinArray($bgcolour);
		@ImageAlphaBlending($imgShadow, TRUE);
		@ImageFill($imgShadow, 0, 0, @ImageColorAllocate($imgShadow, $background[0], $background[1], $background[2]));

		// apply the shadow

		// top left corner
		@ImageCopyResampled($imgShadow, $shadows['tl'],
						0, 0, 0, 0,
						@ImageSX($shadows['tl']), @ImageSY($shadows['tl']), @ImageSX($shadows['tl']), @ImageSY($shadows['tl']));
		// top shadow
		@ImageCopyResampled($imgShadow, $shadows['t'],
						@ImageSX($shadows['l']), 0, 0, 0,
						$ox, @ImageSY($shadows['t']), @ImageSX($shadows['t']), @ImageSY($shadows['t']));
		// top right corner
		@ImageCopyResampled($imgShadow, $shadows['tr'],
						($nx - @ImageSX($shadows['r'])), 0, 0, 0,
						@ImageSX($shadows['tr']), @ImageSY($shadows['tr']), @ImageSX($shadows['tr']), @ImageSY($shadows['tr']));
		// left shadow
		@ImageCopyResampled($imgShadow, $shadows['l'],
						0, @ImageSY($shadows['t']),	0, 0,
						@ImageSX($shadows['l']), $oy, @ImageSX($shadows['l']), @ImageSY($shadows['l']));
		// right shadow
		@ImageCopyResampled($imgShadow, $shadows['r'],
						($nx - @ImageSX($shadows['r'])), @ImageSY($shadows['tl']), 0, 0,
						@ImageSX($shadows['r']), $oy, @ImageSX($shadows['r']), @ImageSY($shadows['r']));
		// bottom left corner
		@ImageCopyResampled($imgShadow, $shadows['bl'],
						0, ($ny - @ImageSY($shadows['b'])), 0, 0,
						@ImageSX($shadows['bl']), @ImageSY($shadows['bl']), @ImageSX($shadows['bl']), @ImageSY($shadows['bl']));
		// bottom shadow
		@ImageCopyResampled($imgShadow, $shadows['b'],
						@ImageSX($shadows['l']), ($ny - @ImageSY($shadows['b'])), 0, 0,
						$ox, @ImageSY($shadows['b']), @ImageSX($shadows['b']), @ImageSY($shadows['b']));
		// bottom right corner
		@ImageCopyResampled($imgShadow, $shadows['br'],
						($nx - @ImageSX($shadows['r'])), ($ny - @ImageSY($shadows['b'])), 0, 0,
						@ImageSX($shadows['br']), @ImageSY($shadows['br']), @ImageSX($shadows['br']), @ImageSY($shadows['br']));

		// apply the picture
		@ImageCopyResampled($imgShadow, $imgFinal,
						@ImageSX($shadows['l']), @ImageSY($shadows['t']), 0, 0,
						$ox, $oy, @ImageSX($imgFinal), @ImageSY($imgFinal));
				

imagejpeg($imgShadow, $filename); 		
	}

	
	//
	// Internal functions
	//


	//
	// convert HTML hex value into integer array
	//
	function _htmlHexToBinArray($hex)
	{
		$hex = @preg_replace('/^#/', '', $hex);
		for ($i=0; $i<3; $i++)
		{
			$foo = substr($hex, 2*$i, 2); 
			$rgb[$i] = 16 * hexdec(substr($foo, 0, 1)) + hexdec(substr($foo, 1, 1)); 
		}
		return $rgb;
	}

?>