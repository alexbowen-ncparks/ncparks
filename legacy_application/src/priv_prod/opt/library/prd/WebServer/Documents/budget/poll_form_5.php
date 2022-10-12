<?php
//echo "hello world";
//echo "<pre>";print_r($_REQUEST);"</pre>"; //exit;
extract($_REQUEST);
//echo "pre_vote=$pre_vote<br />";
?>
<html>
<head>
<script>
function getVote(int) {
  if (window.XMLHttpRequest) {
    // code for IE7+, Firefox, Chrome, Opera, Safari
    xmlhttp=new XMLHttpRequest();
  } else {  // code for IE6, IE5
    xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
  xmlhttp.onreadystatechange=function() {
    if (xmlhttp.readyState==4 && xmlhttp.status==200) {
      document.getElementById("poll").innerHTML=xmlhttp.responseText;
    }
  }
  xmlhttp.open("GET","poll_result_5a.php?vote="+int,true);
  xmlhttp.send();
}
</script>

<style>
table.poll td
{ height: 40px;
vertical-align : middle;
vertical-align: text-middle;
}


</style>

</head>

<body>

<table class='poll'>
<tr><th>Poll: What is your favorite season of the year?</th></tr>
</table>
<table class='poll'>
<tr><td align='center'>My<br />Vote</td><td align='center'>All<br />Votes</td></tr>
<tr>
<td>
<form>
<table class='poll'>
<tr><td><input type="radio" name="vote" value="0" onclick="getVote(this.value)">spring</td></tr>
<tr><td><input type="radio" name="vote" value="1" onclick="getVote(this.value)">summer</td></tr>
<tr><td><input type="radio" name="vote" value="2" onclick="getVote(this.value)">fall</td></tr>
<tr><td><input type="radio" name="vote" value="3" onclick="getVote(this.value)">winter</td></tr>
</table>
</form>
</td>



<?php

//if($pre_vote=='y')
//{
echo "<td>";
echo "<div id='poll'>";
include("poll_result_5.php");
echo "</div>";
echo "</td>";
echo "</tr>";
echo "</table>";
//}
/*
{
echo "<div id='poll'>";

echo "</div>";
}
*/
?>

</body>
</html>