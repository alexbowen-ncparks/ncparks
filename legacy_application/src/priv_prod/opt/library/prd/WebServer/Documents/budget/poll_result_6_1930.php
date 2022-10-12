<?php


//get content of textfile
$filename = "poll_result_6.txt";
$content = file($filename);

//put content in array
$array = explode("||", $content[0]);
$spring = $array[0];
$summer = $array[1];
$fall = $array[2];
$winter = $array[3];




//insert votes to txt file
//$insertvote = $yes."||".$no;
$insertvote = $spring."||".$summer."||".$fall."||".$winter;
$fp = fopen($filename,"w");
fputs($fp,$insertvote);
fclose($fp);
?>

<table class='poll' align='center'>
<!--<tr><th colspan="2">Poll Result</th></tr>-->
<tr>
<!--<td>Spring:</td>-->
<td>
<img src="spring.jpg"
width='<?php echo(300*round($spring/($spring+$summer+$fall+$winter),2)); ?>'
height='40'>
<?php echo(100*round($spring/($spring+$summer+$fall+$winter),2)); echo "%";   ?>
</td>
</tr>

<tr>
<!--<td>Summer:</td>-->
<td>
<img src="summer.jpg"
width='<?php echo(300*round($summer/($spring+$summer+$fall+$winter),2)); ?>'
height='40'>
<?php echo(100*round($summer/($spring+$summer+$fall+$winter),2)); echo "%";   ?>
</td>
</tr> 

<tr>
<!--<td>Fall:</td>-->
<td>
<img src="fall.jpg"
width='<?php echo(300*round($fall/($spring+$summer+$fall+$winter),2)); ?>'
height='40'>
<?php echo(100*round($fall/($spring+$summer+$fall+$winter),2)); echo "%";  ?>
</td>
</tr>
<!--<td>Winter:</td>-->
<td>
<img src="winter.jpg"
width='<?php echo(300*round($winter/($spring+$summer+$fall+$winter),2)); ?>'
height='40'>
<?php echo(100*round($winter/($spring+$summer+$fall+$winter),2)); ?>%
</td>
</tr>



</table>
