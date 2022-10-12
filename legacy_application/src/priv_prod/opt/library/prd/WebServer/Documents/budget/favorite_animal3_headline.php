<?php
$vote = $_REQUEST['vote'];

//get content of textfile
$filename = "favorite_animal4.txt";
$content = file($filename);

//put content in array
$array = explode("||", $content[0]);
$option1 = $array[0];
$option2 = $array[1];
$option3 = $array[2];
$option4 = $array[3];

if ($vote == 1) {
  $option1 = $option1 + 1;
}
if ($vote == 2) {
  $option2 = $option2 + 1;
}

if ($vote == 3) {
  $option3 = $option3 + 1;
}

if ($vote == 4) {
  $option4 = $option4 + 1;
}


//insert votes to txt file
//$insertvote = $yes."||".$no;
$insertvote = $option1."||".$option2."||".$option3."||".$option4;
$fp = fopen($filename,"w");
fputs($fp,$insertvote);
fclose($fp);
?>
<?php 

$total_votes=$option1+$option2+$option3+$option4;
echo "<table><tr><th>Total Votes: $total_votes</font></th></tr></table>";
echo "<table align='center'><tr><th><a href='favorite_animal1.php' target='_blank'>VOTE</a></th></tr></table><br />";
?>
<table class='poll'>
<!--<tr><th colspan="2">Poll Result</th></tr>-->
<tr>
<!--<td>option1:</td>-->
<td>
<img src="favorite_animal_option1.jpeg"
width='100'
height='100'>
<?php echo(100*round($option1/($option1+$option2+$option3+$option4),2)); echo "%";   ?>
</td>

<!--<td>option2:</td>-->
<td>
<img src="favorite_animal_option2.jpeg"
width='100'
height='100'>


<?php echo(100*round($option2/($option1+$option2+$option3+$option4),2)); echo "%";   ?>
</td>

<!--<td>option3:</td>-->
<td>
<img src="favorite_animal_option3.jpeg"
width='100'
height='100'>
<?php echo(100*round($option3/($option1+$option2+$option3+$option4),2)); echo "%";  ?>
</td>

<!--<td>option4:</td>-->
<td>
<img src="favorite_animal_option4.jpg"
width='100'
height='100'>
<?php echo(100*round($option4/($option1+$option2+$option3+$option4),2)); echo "%"; ?>
</td>
</tr>



</table>
<?php 

//$total_votes=$option1+$option2+$option3+$option4;
//echo "<tr><td>Total Votess: $total_votes</td></tr>";

?>