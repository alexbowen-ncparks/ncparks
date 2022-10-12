<?php
$vote = $_REQUEST['vote'];

//get content of textfile
$filename = "poll_result_5.txt";
$content = file($filename);

//put content in array
$array = explode("||", $content[0]);
$spring = $array[0];
$summer = $array[1];
$fall = $array[2];
$winter = $array[3];


if ($vote == 0) {
  $spring = $spring + 1;
}
if ($vote == 1) {
  $summer = $summer + 1;
}

if ($vote == 2) {
  $fall = $fall + 1;
}

if ($vote == 3) {
  $winter = $winter + 1;
}




//insert votes to txt file
//$insertvote = $yes."||".$no;
$insertvote = $spring."||".$summer."||".$fall."||".$winter;
$fp = fopen($filename,"w");
fputs($fp,$insertvote);
fclose($fp);
?>


<table align='center'>
<tr><th colspan="2">Poll Result</th></tr>
<tr>
<td>Spring:</td>
<td>
<img src="poll_2.jpg"
width='<?php echo(100*round($spring/($spring+$summer+$fall+$winter),2)); ?>'
height='20'>
<?php echo(100*round($spring/($spring+$summer+$fall+$winter),2)); ?>%
</td>
</tr>
<tr>
<td>Summer:</td>
<td>
<img src="poll_2.jpg"
width='<?php echo(100*round($summer/($spring+$summer+$fall+$winter),2)); ?>'
height='20'>
<?php echo(100*round($summer/($spring+$summer+$fall+$winter),2)); ?>%
</td>
</tr>

<tr>
<td>Fall:</td>
<td>
<img src="poll_2.jpg"
width='<?php echo(100*round($fall/($spring+$summer+$fall+$winter),2)); ?>'
height='20'>
<?php echo(100*round($fall/($spring+$summer+$fall+$winter),2)); ?>%
</td>
</tr>
<tr>
<td>Winter:</td>
<td>
<img src="poll_2.jpg"
width='<?php echo(100*round($winter/($spring+$summer+$fall+$winter),2)); ?>'
height='20'>
<?php echo(100*round($winter/($spring+$summer+$fall+$winter),2)); ?>%
</td>
</tr>



















</table>