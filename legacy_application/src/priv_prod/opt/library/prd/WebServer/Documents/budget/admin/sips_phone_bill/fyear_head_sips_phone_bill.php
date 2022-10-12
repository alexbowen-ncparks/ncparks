<?php
extract($_REQUEST);

/*
if($fyear==''){$fyear='1819';}
$report_type='reports';


if($fyear=='1819'){$fyear_1819_check="<img height='25' width='25' src='/budget/infotrack/icon_photos/green_checkmark1.png' alt='picture of green check mark'></img>";}

if($fyear=='1718'){$fyear_1718_check="<img height='25' width='25' src='/budget/infotrack/icon_photos/green_checkmark1.png' alt='picture of green check mark'></img>";}

if($fyear=='1617'){$fyear_1617_check="<img height='25' width='25' src='/budget/infotrack/icon_photos/green_checkmark1.png' alt='picture of green check mark'></img>";}

if($fyear=='1516'){$fyear_1516_check="<img height='25' width='25' src='/budget/infotrack/icon_photos/green_checkmark1.png' alt='picture of green check mark'></img>";}

if($fyear=='1415'){$fyear_1415_check="<img height='25' width='25' src='/budget/infotrack/icon_photos/green_checkmark1.png' alt='picture of green check mark'></img>";}


echo "<table border='5' cellspacing='5' align='center'>";
echo "<tr>";


echo "<td><font color='brown'>Report Year</brown></td>";


echo "<td align='left'><a href='step_group.php?report_type=$report_type&fyear=1819'><font  $shade_1819>1819 $fyear_1819_check</font></a></td>";
echo "<td align='left'><a href='step_group.php?report_type=$report_type&fyear=1718'><font  $shade_1718>1718 $fyear_1718_check</font></a></td>";
echo "<td align='left'><a href='step_group.php?report_type=$report_type&fyear=1617'><font  $shade_1617>1617 $fyear_1617_check</font></a></td>";
echo "<td align='left'><a href='step_group.php?report_type=$report_type&fyear=1516'><font  $shade_1516>1516 $fyear_1516_check</font></a></td>";
echo "<td align='left'><a href='step_group.php?report_type=$report_type&fyear=1415'><font  $shade_1415>1415 $fyear_1415_check</font></a></td>";


echo "</tr>";

echo "</table>";
*/

//echo "<br />Hello Line 39<br />";
//Replace static Fiscal year Menu Bar with "dynamically produced menu".  This will automatically change in the NEW Fiscal year when MoneyCounts Administrator changes the "active_year" in TABLE=fiscal_year (bass 5/20/20)
$query5b="select cy,py1,py2,py3,py4,py5 from fiscal_year where active_year_sips='y' ";
//echo "<br />query5b=$query5b<br />";

$result5b = mysqli_query($connection, $query5b) or die ("Couldn't execute query 5b.  $query5b");
$num5b=mysqli_num_rows($result5b);




echo "<table border='5' cellspacing='5' align='center'>";
while ($row5b=mysqli_fetch_array($result5b)){
echo "<tr>";

$checkmark_image="<img height='25' width='25' src='/budget/infotrack/icon_photos/green_checkmark1.png' alt='picture of green check mark'></img>";

extract($row5b);
if($fyear==''){$fyear=$cy;}
//echo "<br />fyear=$fyear<br />";
//echo "<br />cy=$cy<br />";

if($cy==$fyear){$cy_td="<td><a href='step_group.php?report_type=$report_type&fyear=$cy'><font class=cartRow>$cy $checkmark_image</font></a></td>";}
if($cy!=$fyear){$cy_td="<td><a href='step_group.php?report_type=$report_type&fyear=$cy'>$cy</font></a></td>";}

if($py1==$fyear){$py1_td="<td><a href='step_group.php?report_type=$report_type&fyear=$py1'><font class=cartRow>$py1 $checkmark_image</font></a></td>";}
if($py1!=$fyear){$py1_td="<td><a href='step_group.php?report_type=$report_type&fyear=$py1'>$py1</font></a></td>";}

if($py2==$fyear){$py2_td="<td><a href='step_group.php?report_type=$report_type&fyear=$py2'><font class=cartRow>$py2 $checkmark_image</font></a></td>";}
if($py2!=$fyear){$py2_td="<td><a href='step_group.php?report_type=$report_type&fyear=$py2'>$py2</font></a></td>";}

if($py3==$fyear){$py3_td="<td><a href='step_group.php?report_type=$report_type&fyear=$py3'><font class=cartRow>$py3 $checkmark_image</font></a></td>";}
if($py3!=$fyear){$py3_td="<td><a href='step_group.php?report_type=$report_type&fyear=$py3'>$py3</font></a></td>";}

if($py4==$fyear){$py4_td="<td><a href='step_group.php?report_type=$report_type&fyear=$py4'><font class=cartRow>$py4 $checkmark_image</font></a></td>";}
if($py4!=$fyear){$py4_td="<td><a href='step_group.php?report_type=$report_type&fyear=$py4'>$py4</font></a></td>";}

if($py5==$fyear){$py5_td="<td><a href='step_group.php?report_type=$report_type&fyear=$py5'><font class=cartRow>$py5 $checkmark_image</font></a></td>";}
if($py5!=$fyear){$py5_td="<td><a href='step_group.php?report_type=$report_type&fyear=$py5'>$py5</font></a></td>";}





echo "$cy_td";
echo "$py1_td";
echo "$py2_td";
echo "$py3_td";
echo "$py4_td";
echo "$py5_td";



echo "</tr>";

}
echo "</table>";




?>







