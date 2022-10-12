<?php
echo "hello world";
extract($_REQUEST);
echo "<pre>";print_r($_REQUEST);"</pre>"; exit;
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
  xmlhttp.open("GET","poll_vote_5.php?vote="+int,true);
  xmlhttp.send();
}
</script>
</head>

<body>
<table align='center'>
<tr><th>Poll: What is your favorite season of the year?</th></tr>
<form>
<tr><td><input type="radio" name="vote" value="0" onclick="getVote(this.value)">spring</td></tr>
<tr><td><input type="radio" name="vote" value="1" onclick="getVote(this.value)">summer</td></tr>
<tr><td><input type="radio" name="vote" value="2" onclick="getVote(this.value)">fall</td></tr>
<tr><td><input type="radio" name="vote" value="3" onclick="getVote(this.value)">winter</td></tr>
</form>
</table>

<?php

if($pre_vote=='y'){include("poll_vote_5.php");

?>

<div id="poll">

</div>

</body>
</html>