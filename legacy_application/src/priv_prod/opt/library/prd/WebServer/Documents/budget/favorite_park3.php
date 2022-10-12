<?php
$vote = $_REQUEST['vote'];

//get content of textfile
$filename = "favorite_park4.txt";
$content = file($filename);

//put content in array
$array = explode("||", $content[0]);
$option1 = $array[0];
$option2 = $array[1];
$option3 = $array[2];
$option4 = $array[3];
$option5 = $array[4];


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

if ($vote == 5) {
  $option5 = $option5 + 1;
}











//insert votes to txt file
//$insertvote = $yes."||".$no;
//$insertvote = $option1."||".$option2."||".$option3."||".$option4;
$insertvote = $option1."||".$option2."||".$option3."||".$option4."||".$option5."||".$option6;
$fp = fopen($filename,"w");
fputs($fp,$insertvote);
fclose($fp);
?>
<?php 

$total_votes=$option1+$option2+$option3+$option4+$option5+$option6;
echo "<table><tr><th>Total Votes: $total_votes</font></th></tr></table><br />";

?>
<table class='poll'>
<!--<tr><th colspan="2">Poll Result</th></tr>-->
<tr>
<!--<td>option1:</td>-->
<td>
<img src="favorite_sitcom_option1.png"
width='<?php echo(300*round($option1/($option1+$option2+$option3+$option4+$option5+$option6),2)); ?>'
height='35'>
<?php echo(100*round($option1/($option1+$option2+$option3+$option4+$option5+$option6),2)); echo "%";   ?>
</td>
</tr>

<tr>
<!--<td>option2:</td>-->
<td>
<img src="favorite_sitcom_option2.png"
width='<?php echo(300*round($option2/($option1+$option2+$option3+$option4+$option5+$option6),2)); ?>'
height='35'>
<?php echo(100*round($option2/($option1+$option2+$option3+$option4+$option5+$option6),2)); echo "%";   ?>
</td>
</tr> 

<tr>
<!--<td>option3:</td>-->
<td>
<img src="favorite_sitcom_option3.png"
width='<?php echo(300*round($option3/($option1+$option2+$option3+$option4+$option5+$option6),2)); ?>'
height='35'>
<?php echo(100*round($option3/($option1+$option2+$option3+$option4+$option5+$option6),2)); echo "%";  ?>
</td>
</tr>
<!--<td>option4:</td>-->
<tr>
<td>
<img src="favorite_sitcom_option4.png"
width='<?php echo(300*round($option4/($option1+$option2+$option3+$option4+$option5+$option6),2)); ?>'
height='35'>
<?php echo(100*round($option4/($option1+$option2+$option3+$option4+$option5+$option6),2)); echo "%"; ?>
</td>
</tr>

<tr>
<td>
<img src="favorite_sitcom_option5.png"
width='<?php echo(300*round($option5/($option1+$option2+$option3+$option4+$option5+$option6),2)); ?>'
height='35'>
<?php echo(100*round($option5/($option1+$option2+$option3+$option4+$option5+$option6),2)); echo "%"; ?>
</td>
</tr>









</table>
<?php 

//$total_votes=$option1+$option2+$option3+$option4;
//echo "<tr><td>Total Votess: $total_votes</td></tr>";

?>