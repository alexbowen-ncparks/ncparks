<?php

//if($compliance_month==''){$compliance_month='july';}
if($compliance_month=='july'){$shade_july="class=cartRow";}
if($compliance_month=='august'){$shade_august="class=cartRow";}
if($compliance_month=='september'){$shade_september="class=cartRow";}
if($compliance_month=='october'){$shade_october="class=cartRow";}
if($compliance_month=='november'){$shade_november="class=cartRow";}
if($compliance_month=='december'){$shade_december="class=cartRow";}
if($compliance_month=='january'){$shade_january="class=cartRow";}
if($compliance_month=='february'){$shade_february="class=cartRow";}
if($compliance_month=='march'){$shade_march="class=cartRow";}
if($compliance_month=='april'){$shade_april="class=cartRow";}
if($compliance_month=='may'){$shade_may="class=cartRow";}
if($compliance_month=='june'){$shade_june="class=cartRow";}

//echo "fyear=$fyear<br /><br />";



echo "<table align='center'>";
echo "<tr>";
//echo "<br />";

//if($park==''){$park=$concession_location;}
//if($center==''){$center=$concession_center;}



echo "<td><font class='cartRow'>CHOOSE MONTH>>>></font></td>";
echo "<td><a href='step_group.php?report_type=form&compliance_fyear=$compliance_fyear&compliance_month=july' target='_blank'><font  $shade_july>Jul</font></a></td>";
echo "<td><a href='step_group.php?report_type=form&compliance_fyear=$compliance_fyear&compliance_month=august' target='_blank'><font  $shade_august>Aug</font></a></td>";
echo "<td><a href='step_group.php?report_type=form&compliance_fyear=$compliance_fyear&compliance_month=september' target='_blank'><font  $shade_september>Sep</font></a></td>";
echo "<td><a href='step_group.php?report_type=form&compliance_fyear=$compliance_fyear&compliance_month=october' target='_blank'><font  $shade_october>Oct</font></a></td>";
echo "<td><a href='step_group.php?report_type=form&compliance_fyear=$compliance_fyear&compliance_month=november' target='_blank'><font  $shade_november>Nov</font></a></td>";
echo "<td><a href='step_group.php?report_type=form&compliance_fyear=$compliance_fyear&compliance_month=december' target='_blank'><font  $shade_december>Dec</font></a></td>";
echo "<td><a href='step_group.php?report_type=form&compliance_fyear=$compliance_fyear&compliance_month=january' target='_blank'><font  $shade_january>Jan</font></a></td>";
echo "<td><a href='step_group.php?report_type=form&compliance_fyear=$compliance_fyear&compliance_month=february' target='_blank'><font  $shade_february>Feb</font></a></td>";
echo "<td><a href='step_group.php?report_type=form&compliance_fyear=$compliance_fyear&compliance_month=march' target='_blank'><font  $shade_march>Mar</font></a></td>";
echo "<td><a href='step_group.php?report_type=form&compliance_fyear=$compliance_fyear&compliance_month=april' target='_blank'><font  $shade_april>Apr</font></a></td>";
echo "<td><a href='step_group.php?report_type=form&compliance_fyear=$compliance_fyear&compliance_month=may' target='_blank'><font  $shade_may>May</font></a></td>";
echo "<td><a href='step_group.php?report_type=form&compliance_fyear=$compliance_fyear&compliance_month=june' target='_blank'><font  $shade_june>Jun</font></a></td>";




echo "</tr>";

echo "</table>";
echo "<br />";


?>