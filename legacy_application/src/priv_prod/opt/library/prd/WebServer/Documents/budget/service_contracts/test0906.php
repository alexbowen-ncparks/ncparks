<?php

$chars = array();
   for($i=1;$i<=100;$i++) {
      $chars[] = rand(65,90); // adds the characters 0-9 to the $chars array (48-57 are the positions of 0-9 in the ASCII table
   }
  
$letters=array();
foreach($chars as $k=>$v) {
 $letters[]=chr($v);    
   }

  
echo "<pre>";print_r($letters);echo "</pre>";



?>