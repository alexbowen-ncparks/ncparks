<?php
 
// Convert Words (text) to Speech (MP3)
// ------------------------------------
 
// Google Translate API cannot handle strings > 100 characters
//$words="hello world";
//echo "words=$words<br />";
   $words = substr($_GET['words'], 0, 100);
echo "words=$words<br />";
// Replace the non-alphanumeric characters
// The spaces in the sentence are replaced with the Plus symbol
   $words = urlencode($_GET['words']);
 echo "words=$words<br />";
// Name of the MP3 file generated using the MD5 hash
   $file  = md5($words);
  
// Save the MP3 file in this folder with the .mp3 extension
   $file = "audio/" . $file . ".mp3";
 
echo "file=$file";exit;
 
// If the MP3 file exists, do not create a new request

  
?>

// Embed the MP3 file using the AUDIO tag of HTML5
<audio controls="controls" autoplay="autoplay">
  <source src="sounds/hello.mp3" type="audio/mp3" />
</audio>




