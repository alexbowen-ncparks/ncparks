<?php


echo "<br />";


$query1="select report_date
         from report_budget_history_dates
		 where 1";		 

$result1 = mysqli_query($connection, $query1) or die ("Couldn't execute query 1.  $query1");
$row1=mysqli_fetch_array($result1);
extract($row1);




$query5b="select cy,py1,py2,py3,py4,py5,py6,py7,py8,py9,py10 from fiscal_year where active_year='y' ";
//echo "<br />query5b=$query5b<br />";

$result5b = mysqli_query($connection,$query5b) or die ("Couldn't execute query 5b.  $query5b");
$num5b=mysqli_num_rows($result5b);

echo "<table border='5' cellspacing='5' align='center'>";
while ($row5b=mysqli_fetch_array($result5b)){
echo "<tr>";

$checkmark_image="<img height='25' width='25' src='/budget/infotrack/icon_photos/green_checkmark1.png' alt='picture of green check mark'></img>";

extract($row5b);

if($cy==$fyearS){$cy_td="<td><a href='pfr_drilldown.php?fyearS=$cy&parkcodeS=$parkcodeS&report_type=pfr&budget_groupS=pfr_expenses'><font class=cartRow>$cy $checkmark_image</font></a><br />(**thru $report_date**)<br />$fiscal_year_perc_complete2</td>";}
if($cy!=$fyearS){$cy_td="<td><a href='pfr_drilldown.php?fyearS=$cy&parkcodeS=$parkcodeS&report_type=pfr&budget_groupS=pfr_expenses'>$cy</a><br />(**thru $report_date**)<br />$fiscal_year_perc_complete2</td>";}


if($py1==$fyearS){$py1_td="<td><a href='pfr_drilldown.php?fyearS=$py1&parkcodeS=$parkcodeS&report_type=pfr&budget_groupS=pfr_expenses'><font class=cartRow>$py1 $checkmark_image</font></a></td>";}
if($py1!=$fyearS){$py1_td="<td><a href='pfr_drilldown.php?fyearS=$py1&parkcodeS=$parkcodeS&report_type=pfr&budget_groupS=pfr_expenses'>$py1</a></td>";}

if($py2==$fyearS){$py2_td="<td><a href='pfr_drilldown.php?fyearS=$py2&parkcodeS=$parkcodeS&report_type=pfr&budget_groupS=pfr_expenses'><font class=cartRow>$py2 $checkmark_image</font></a></td>";}
if($py2!=$fyearS){$py2_td="<td><a href='pfr_drilldown.php?fyearS=$py2&parkcodeS=$parkcodeS&report_type=pfr&budget_groupS=pfr_expenses'>$py2</a></td>";}

if($py3==$fyearS){$py3_td="<td><a href='pfr_drilldown.php?fyearS=$py3&parkcodeS=$parkcodeS&report_type=pfr&budget_groupS=pfr_expenses'><font class=cartRow>$py3 $checkmark_image</font></a></td>";}
if($py3!=$fyearS){$py3_td="<td><a href='pfr_drilldown.php?fyearS=$py3&parkcodeS=$parkcodeS&report_type=pfr&budget_groupS=pfr_expenses'>$py3</a></td>";}

if($py4==$fyearS){$py4_td="<td><a href='pfr_drilldown.php?fyearS=$py4&parkcodeS=$parkcodeS&report_type=pfr&budget_groupS=pfr_expenses'><font class=cartRow>$py4 $checkmark_image</font></a></td>";}
if($py4!=$fyearS){$py4_td="<td><a href='pfr_drilldown.php?fyearS=$py4&parkcodeS=$parkcodeS&report_type=pfr&budget_groupS=pfr_expenses'>$py4</a></td>";}

if($py5==$fyearS){$py5_td="<td><a href='pfr_drilldown.php?fyearS=$py5&parkcodeS=$parkcodeS&report_type=pfr&budget_groupS=pfr_expenses'><font class=cartRow>$py5 $checkmark_image</font></a></td>";}
if($py5!=$fyearS){$py5_td="<td><a href='pfr_drilldown.php?fyearS=$py5&parkcodeS=$parkcodeS&report_type=pfr&budget_groupS=pfr_expenses'>$py5</a></td>";}

if($py6==$fyearS){$py6_td="<td><a href='pfr_drilldown.php?fyearS=$py6&parkcodeS=$parkcodeS&report_type=pfr&budget_groupS=pfr_expenses'><font class=cartRow>$py6 $checkmark_image</font></a></td>";}
if($py6!=$fyearS){$py6_td="<td><a href='pfr_drilldown.php?fyearS=$py6&parkcodeS=$parkcodeS&report_type=pfr&budget_groupS=pfr_expenses'>$py6</a></td>";}

if($py7==$fyearS){$py7_td="<td><a href='pfr_drilldown.php?fyearS=$py7&parkcodeS=$parkcodeS&report_type=pfr&budget_groupS=pfr_expenses'><font class=cartRow>$py7 $checkmark_image</font></a></td>";}
if($py7!=$fyearS){$py7_td="<td><a href='pfr_drilldown.php?fyearS=$py7&parkcodeS=$parkcodeS&report_type=pfr&budget_groupS=pfr_expenses'>$py7</a></td>";}

if($py8==$fyearS){$py8_td="<td><a href='pfr_drilldown.php?fyearS=$py8&parkcodeS=$parkcodeS&report_type=pfr&budget_groupS=pfr_expenses'><font class=cartRow>$py8 $checkmark_image</font></a></td>";}
if($py8!=$fyearS){$py8_td="<td><a href='pfr_drilldown.php?fyearS=$py8&parkcodeS=$parkcodeS&report_type=pfr&budget_groupS=pfr_expenses'>$py8</a></td>";}

if($py9==$fyearS){$py9_td="<td><a href='pfr_drilldown.php?fyearS=$py9&parkcodeS=$parkcodeS&report_type=pfr&budget_groupS=pfr_expenses'><font class=cartRow>$py9 $checkmark_image</font></a></td>";}
if($py9!=$fyearS){$py9_td="<td><a href='pfr_drilldown.php?fyearS=$py9&parkcodeS=$parkcodeS&report_type=pfr&budget_groupS=pfr_expenses'>$py9</a></td>";}

if($py10==$fyearS){$py10_td="<td><a href='pfr_drilldown.php?fyearS=$py10&parkcodeS=$parkcodeS&report_type=pfr&budget_groupS=pfr_expenses'><font class=cartRow>$py10 $checkmark_image</font></a></td>";}
if($py10!=$fyearS){$py10_td="<td><a href='pfr_drilldown.php?fyearS=$py10&parkcodeS=$parkcodeS&report_type=pfr&budget_groupS=pfr_expenses'>$py10</a></td>";}


echo "$cy_td";
echo "$py1_td";
echo "$py2_td";
echo "$py3_td";
echo "$py4_td";
echo "$py5_td";
echo "$py6_td";
echo "$py7_td";
echo "$py8_td";
echo "$py9_td";
echo "$py10_td";


echo "</tr>";

}
echo "</table>";






?>