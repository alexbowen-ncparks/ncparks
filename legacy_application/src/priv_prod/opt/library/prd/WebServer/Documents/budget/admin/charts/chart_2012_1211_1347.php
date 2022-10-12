 <?php
  
           header("Content-type: image/jpeg");
         
        // read the post data
        $data = array('3400','2570','245','473','1000','3456','780');
        $sum = array_sum($data);
        
        $height = 255;
        $width = 320;
        
        $im = imagecreate($width,$height); // width , height px

        $white = imagecolorallocate($im,255,255,255); 
        $black = imagecolorallocate($im,0,0,0);   
        $red = imagecolorallocate($im,255,0,0);   


        imageline($im, 10, 5, 10, 230, $black);
        imageline($im, 10, 230, 300, 230, $black);
    

        $x = 15;   
        $y = 230;   
        $x_width = 20;  
        $y_ht = 0; 
       
        for ($i=0;$i<7;$i++){
        
          $y_ht = ($data[$i]/$sum)* $height;    
          
              imagerectangle($im,$x,$y,$x+$x_width,($y-$y_ht),$red);
              imagestring( $im,2,$x-1,$y+10,$data[$i],$black);
              
          $x += ($x_width+20);  
         
        }
        
        imagejpeg($im);

?> 