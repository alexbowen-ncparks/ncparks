<?php
if($menu=='sspd1'){$shade_sspd1="class='cartRow'";}
if($menu=='sspd2'){$shade_sspd2="class='cartRow'";}
if($menu=='sspd3'){$shade_sspd3="class='cartRow'";}
if($menu=='sspd4'){$shade_sspd4="class='cartRow'";}
if($menu=='sspd5'){$shade_sspd5="class='cartRow'";}
if($menu=='sspd6'){$shade_sspd6="class='cartRow'";}
if($menu=='sspd7'){$shade_sspd7="class='cartRow'";}

echo "<table align='center'>";	
echo "<tr>";
//echo "<th><img height='75' width='125' src='icon_photos/pimo.jpg' alt='picture of pilot mountain'></img><br />ASSPD Conference</th>";
echo "<th><a href='sspd1.php?menu=sspd1&type=$type'><font $shade_sspd1>Transportation<br />Logistics</font></a></th>";
echo "<th><a href='sspd1.php?menu=sspd2&type=$type'><font $shade_sspd2>Check-in<br />Registration<br />SWAG</font></a></th>";
echo "<th><a href='sspd1.php?menu=sspd3&type=$type'><font $shade_sspd3>Spouse<br />Events</font></a></th>";
echo "<th><a href='sspd1.php?menu=sspd4&type=$type'><font $shade_sspd4>Hospitality<br />Receptions</font></a></th>";
echo "<th><a href='sspd1.php?menu=sspd5&type=$type'><font $shade_sspd5>Advance Team<br />Golf</font></a></th>";
echo "<th><a href='sspd1.php?menu=sspd6&type=$type'><font $shade_sspd6>Admin<br />IT</font></a></th>";
echo "<th><a href='sspd1.php?menu=sspd7&type=$type'><font $shade_sspd7>Education</font></a></th>";

echo "</tr>";	
echo "</table>";
?>