<?php


   $chars = array();
   for($i=48;$i<=48;$i++) {
      $chars[] = chr($i); // adds the characters 0-9 to the $chars array (48-57 are the positions of 0-9 in the ASCII table
   }
   for($i=65;$i<=65;$i++) {
      $chars[] = chr($i); // adds the characters 0-9 to the $chars array (65-90 are the positions of A-Z in the ASCII table
   }

   // $chars now holds all values 0-9 and A-Z

   $possible_values = array();
   foreach($chars as $k=>$first_char) {
      foreach($chars as $l=>$second_char) {
       $possible_values[] = $first_char . $second_char;  
      }
   }
   
echo "<pre>";print_r($possible_values);echo "</pre>";



?>