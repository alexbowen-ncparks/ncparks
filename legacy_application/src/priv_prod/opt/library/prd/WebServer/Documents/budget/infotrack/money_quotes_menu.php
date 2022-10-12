<?php

echo "<br />";

if($round==''){$round='2';}

if($menu==1){$shade_menu1="class=cartRow";$calmonth='april';$month_number='04';$calyear='2017';}
if($menu==2){$shade_menu2="class=cartRow";$calmonth='may';$month_number='05';$calyear='2017';}
if($menu==3){$shade_menu3="class=cartRow";$calmonth='march';$month_number='03';$calyear='2018';}





echo "<table align='center' border='1'>";	
echo "<tr>";
echo "<th>Polls</th>";
echo "<th><a href='money_quotes_scores.php?menu=1'><font $shade_menu1>April<br />2017</font></a></th>";
echo "<th><a href='money_quotes_scores.php?menu=2'><font $shade_menu2>May<br />2017</font></a></th>";
echo "<th><a href='money_quotes_scores.php?menu=3'><font $shade_menu3>March<br />2018</font></a></th>";

echo "</tr>";	
echo "</table>";

echo "<br /><br />";
if($menu==1)
{
echo "<table align='center' cellspacing='8'><tr><th><i>$calmonth  $calyear Polls </i></th></tr></table>";
}

if($menu==2)
{
echo "<table align='center' cellspacing='8'><tr><th><i>$calmonth  $calyear Polls </i></th></tr></table>";
}

if($menu==3)
{
if($round==1){$shade_round1="class=cartRow";}	
if($round==2){$shade_round2="class=cartRow";}	
if($round==3){$shade_round3="class=cartRow";}	
	
	
echo "<table align='center' cellspacing='8'><tr><th><i>$calmonth  $calyear Polls </i></th></tr></table>";
echo "<table align='center' cellspacing='8'><tr>";
//echo "<th><a href='money_quotes_scores.php?menu=3&round=1'><font $shade_round1>Sweet16</font></a></th>";
//echo "<th><a href='money_quotes_scores.php?menu=3&round=2'><font $shade_round2>Final4</font></a></th>";
echo "<th><a href='money_quotes_scores.php?menu=3&round=3'><font $shade_round3>Championship Round</font></a></th>";

echo "</tr></table>";
//exit;
}







echo "<br />";


?>