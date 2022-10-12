<?php
 if($_POST){
	//get the text 
   $text = substr($_POST['textbox'], 0, 100);
   $text2 = substr($_POST['textbox2'], 0, 100);
echo "text=$text<br />";
echo "text2=$text2<br />";
   //we are passing as a query string so encode it, space will become +
   $text = urlencode($text);
echo "text=$text<br />";
echo "text2=$text2<br />";
   //give a file name and path to store the file
   $file  = $text2;
   $file = "sounds/" . $file . ".mp3";
echo "file=$file<br />";//exit;
   //now get the content from the Google API using file_get_contents
   $mp3 = file_get_contents("http://translate.google.com/translate_tts?tl=en&q=$text");

   //save the mp3 file to the path
   file_put_contents($file, $mp3);
}
?>
<html>
<body> 
<h2>Text to Speech PHP Script</h2>

<form action="" method="post">
	Enter your text: <input name="textbox" value="hello world"></input>
	Enter your Filename: <input name="textbox2"></input>
	<input type="submit" value="Submit">
</form>

<?php  if($_POST){?>

<!-- play the audio file using a player. Here I'm used a HTML5 player. You can use any player insted-->
<audio controls="controls" autoplay="autoplay">
  <source src="<?php echo $file; ?>" type="audio/mp3" />
</audio>

<?php }?>
<br />
<a href="http://blog.theonlytutorials.com/php-script-text-speech-google-api/">Find the tutorial here - Blog.Theonlytutorials.com</a>
</body>
</html>
