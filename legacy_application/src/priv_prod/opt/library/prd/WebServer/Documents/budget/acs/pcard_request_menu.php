<?php

if($report_type==''){$report_type='form' ;}
//$fyear='1516';
if($report_type=='form'){$shade_form="class=cartRow";}
if($report_type=='report'){$shade_report="class=cartRow";}


echo "<br />";
//echo "<table border='5' cellspacing='5'>";
echo "<table align='center'>";
echo "<tr>";
echo "<br />";

if($park==''){$park=$concession_location;}
if($center==''){$center=$concession_center;}



echo "<td><a href='pcard_request1.php?report_type=form'><font  $shade_form>FORM</font></a></td>";
echo "<td><a href='pcard_request1.php?report_type=report'><font  $shade_report>REPORT</font></a></td>";




echo "</tr>";

echo "</table>";
echo "<br />";






?>







