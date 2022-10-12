<?php
//echo "hello world";
//echo "<pre>";print_r($_REQUEST);"</pre>"; //exit;
extract($_REQUEST);
//echo "pre_vote=$pre_vote<br />";
?>

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
  xmlhttp.open("GET","favorite_service3.php?vote="+int,true);
  xmlhttp.send();
}
</script>


<style>
table.poll td
{ height: 40px;
vertical-align : middle;
vertical-align: text-middle;

}
/*
table.poll 
{ 
margin: auto;
}
*/



</style>




<table class='poll'>
<!--
<tr><th>Poll: What is your favorite season of the year?</th></tr>
-->

<tr><th>Poll: Military Service</th></tr>
<tr><td>Click each "branch of service" that you and your family members<br /> have served. Thanks! NOTE: Click multiple times for a "branch of service" if applicable. <br />Example: If 2 family members served in Army. Click Army twice</td></tr>
<tr><td>Includes Active & Reserves (all branches) & Army/Air National Guard</td></tr>
<tr>
<td>
<table align="center">
<tr>
<td>
<th><img src="us_air_force_public_domain.png" height="50" width="50"></th>
<th><img src="us_army_public_domain.png" height="50" width="50"></th>
<th><img src="us_coast_guard_public_domain.png" height="50" width="50"></th>
<th><img src="us_marine_corps_public_domain.png" height="50" width="50"></th>
<th><img src="us_navy_public_domain.png" height="50" width="50"></th>
</td>
</tr>
</table>
</td>
</tr>
</table>
<br />
<table class='poll'>
<!--<tr><td align='center'>Vote</td><td align='center'>Results</td></tr>-->
<tr>
<td>
<?php echo "<table><tr><td><font color='brown'>Choice:</td></tr></table>"; ?>

<form>
<table class='poll'>
<tr><td><input type="radio" name="vote" value="1" onclick="getVote(this.value)">United States Air Force</td></tr>
<tr><td><input type="radio" name="vote" value="2" onclick="getVote(this.value)">United States Army</td></tr>
<tr><td><input type="radio" name="vote" value="3" onclick="getVote(this.value)">United States Coast Guard</td></tr>
<tr><td><input type="radio" name="vote" value="4" onclick="getVote(this.value)">United States Marine Corps</td></tr>
<tr><td><input type="radio" name="vote" value="5" onclick="getVote(this.value)">United States Navy</td></tr>
</table>
</form>
</td>



<?php

//if($pre_vote=='y')
//{
echo "<td>";
echo "<div id='poll'>";
include("favorite_service3.php");
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

