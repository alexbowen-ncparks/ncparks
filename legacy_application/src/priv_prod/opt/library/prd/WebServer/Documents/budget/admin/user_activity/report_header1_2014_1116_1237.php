<?php



if($user_level=="1")
	{$shade_user_level_1="class=cartRow";}else{$shade_user_level_1="";}
if($user_level=="2")
	{$shade_user_level_2="class=cartRow";}else{$shade_user_level_2="";}
if($user_level=="3")
	{$shade_user_level_3="class=cartRow";}else{$shade_user_level_3="";}
if($user_level=="4")
	{$shade_user_level_4="class=cartRow";}else{$shade_user_level_4="";}
if($user_level=="5")
	{$shade_user_level_5="class=cartRow";}else{$shade_user_level_5="";}
if($user_level=="all")
	{$shade_user_level_all="class=cartRow";}else{$shade_user_level_all="";}



if($section=='all'){$shade_section_all="class=cartRow";}
if($section=='administration'){$shade_section_administration="class=cartRow";}
if($section=='design_development'){$shade_section_design_development="class=cartRow";}
if($section=='natural_resources'){$shade_section_natural_resources="class=cartRow";}
if($section=='operations'){$shade_section_operations="class=cartRow";}
if($section=='trails'){$shade_section_trails="class=cartRow";}




/*
if($section=='section'){$shade_location_section="class=cartRow2";}
if($location=='district'){$shade_location_district="class=cartRow2";}
if($location=='center'){$shade_location_center="class=cartRow2";}
*/

if($history=='1yr'){$shade_history_1yr="class=cartRow";}
if($history=='3yr'){$shade_history_3yr="class=cartRow";}
if($history=='5yr'){$shade_history_5yr="class=cartRow";}
if($history=='10yr'){$shade_history_10yr="class=cartRow";}


if($period=='fyear'){$shade_period_fyear="class=cartRow";}
if($period=='cyear'){$shade_period_cyear="class=cartRow";}
if($period=='range'){$shade_period_range="class=cartRow";}
if($period=='today'){$shade_period_today="class=cartRow";}




//echo "shade_location_all=$shade_location_all";

//header_row
/*
echo "<tr><th><font color=brown >section</font></th><th><font color=brown >Userlevel</font></th><th><font color=brown >period</font></th></tr>";
echo "<br />";
*/
echo "<table border='1'>";
echo "<tr><th><font color=brown >period</font></th></tr>";
echo "<br />";



//row1
if(!isset($period)){$period="";}
if(!isset($range_year_start)){$range_year_start="";}
if(!isset($range_month_start)){$range_month_start="";}
if(!isset($range_day_start)){$range_day_start="";}
if(!isset($range_year_end)){$range_year_end="";}
if(!isset($range_month_end)){$range_month_end="";}
if(!isset($range_day_end)){$range_day_end="";}

//echo "<tr>";
/*
echo "<td><a href='user_activity_matrix.php?section=all&report=$report&user_level=$user_level&history=$history&period=$period&range_year_start=$range_year_start&range_month_start=$range_month_start&range_day_start=$range_day_start&range_year_end=$range_year_end&range_month_end=$range_month_end&range_day_end=$range_day_end'><font  $shade_section_all>ALL</font></a></td>";

echo "<td><a href='user_activity_matrix.php?user_level=all&report=$report&section=$section&district=$district&history=$history&period=$period&range_year_start=$range_year_start&range_month_start=$range_month_start&range_day_start=$range_day_start&range_year_end=$range_year_end&range_month_end=$range_month_end&range_day_end=$range_day_end'><font  $shade_user_level_all>ALL</font></a></td>";
*/

/*
echo "<td><a href='user_activity_matrix.php?&period=fyear&report=$report&user_level=$user_level&section=$section&history=$history'><font  $shade_period_fyear>fyear</font></a></td>";
echo "</tr>";
*/
	 
//row2	  
//echo "<tr>";
/*
echo "<td><a href='user_activity_matrix.php?section=administration&report=$report&user_level=$user_level&district=$district&history=$history&period=$period&range_year_start=$range_year_start&range_month_start=$range_month_start&range_day_start=$range_day_start&range_year_end=$range_year_end&range_month_end=$range_month_end&range_day_end=$range_day_end'><font  $shade_section_administration>Administration</font></a></td>";

echo "<td><a href='user_activity_matrix.php?user_level=5&report=$report&section=$section&district=$district&history=$history&period=$period&range_year_start=$range_year_start&range_month_start=$range_month_start&range_day_start=$range_day_start&range_year_end=$range_year_end&range_month_end=$range_month_end&range_day_end=$range_day_end'><font  $shade_user_level_5>5</font></a></td>";
*/
/*
echo "<td><a href='user_activity_matrix.php?period=today&history=$history&report=$report&user_level=$user_level&section=$section&district=$district'><font  $shade_period_today>today</font></a></td>";
*/

/*
if($period=='range'){
echo "<td colspan='3'><font color='red'>Range Data</font></td>";
}
*/
//echo "</tr>";
    
	  
//row3	  

echo "<tr>";
/*
echo "<td><a href='user_activity_matrix.php?section=design_development&report=$report&user_level=$user_level&history=$history&period=$period&range_year_start=$range_year_start&range_month_start=$range_month_start&range_day_start=$range_day_start&range_year_end=$range_year_end&range_month_end=$range_month_end&range_day_end=$range_day_end'><font  $shade_section_design_development>Design_Develop</font></a></td>";

echo "<td><a href='user_activity_matrix.php?user_level=4&report=$report&section=$section&district=$district&history=$history&period=$period&range_year_start=$range_year_start&range_month_start=$range_month_start&range_day_start=$range_day_start&range_year_end=$range_year_end&range_month_end=$range_month_end&range_day_end=$range_day_end'><font  $shade_user_level_4>4</font></a></td>";
*/

echo "<td><a href='user_activity_matrix.php?period=range&report=$report&user_level=$user_level&section=$section'><font  $shade_period_range>range</font></a></td>";
if($period=='range'){
echo "<form method=post autocomplete='off' action=user_activity_matrix.php>";
echo "<td><font color='brown'>Month</font></td><td><font color='brown'>Day</font></td><td><font color='brown'>Year</font></td>";}

/*
if($period=='range'){
echo "<td></td><td>Month</td><td>Day</td><td>Year</td></tr>";
echo "<form method=post autocomplete='off' action=user_activity_matrix.php>";
echo "<tr>";

echo "<td>Start</td>";

echo "<td><select name='range_month_start'><option></option>";

echo "<option value='01'"; if($range_month_start=='01'){echo "selected";}echo ">Jan</option>";
echo "<option value='02'"; if($range_month_start=='02'){echo "selected";}echo ">Feb</option>";
echo "<option value='03'"; if($range_month_start=='03'){echo "selected";}echo ">Mar</option>";
echo "<option value='04'"; if($range_month_start=='04'){echo "selected";}echo ">Apr</option>";
echo "<option value='05'"; if($range_month_start=='05'){echo "selected";}echo ">May</option>";
echo "<option value='06'"; if($range_month_start=='06'){echo "selected";}echo ">Jun</option>";
echo "<option value='07'"; if($range_month_start=='07'){echo "selected";}echo ">Jul</option>";
echo "<option value='08'"; if($range_month_start=='08'){echo "selected";}echo ">Aug</option>";
echo "<option value='09'"; if($range_month_start=='09'){echo "selected";}echo ">Sep</option>";
echo "<option value='10'"; if($range_month_start=='10'){echo "selected";}echo ">Oct</option>";
echo "<option value='11'"; if($range_month_start=='11'){echo "selected";}echo ">Nov</option>";
echo "<option value='12'"; if($range_month_start=='12'){echo "selected";}echo ">Dec</option>";

echo "</select></td>";

echo "<td><select name='range_day_start'><option></option>";

echo "<option value='01'"; if($range_day_start=='01'){echo "selected";}echo ">01</option>";
echo "<option value='02'"; if($range_day_start=='02'){echo "selected";}echo ">02</option>";
echo "<option value='03'"; if($range_day_start=='03'){echo "selected";}echo ">03</option>";
echo "<option value='04'"; if($range_day_start=='04'){echo "selected";}echo ">04</option>";
echo "<option value='05'"; if($range_day_start=='05'){echo "selected";}echo ">05</option>";
echo "<option value='06'"; if($range_day_start=='06'){echo "selected";}echo ">06</option>";
echo "<option value='07'"; if($range_day_start=='07'){echo "selected";}echo ">07</option>";
echo "<option value='08'"; if($range_day_start=='08'){echo "selected";}echo ">08</option>";
echo "<option value='09'"; if($range_day_start=='09'){echo "selected";}echo ">09</option>";
echo "<option value='10'"; if($range_day_start=='10'){echo "selected";}echo ">10</option>";
echo "<option value='11'"; if($range_day_start=='11'){echo "selected";}echo ">11</option>";
echo "<option value='12'"; if($range_day_start=='12'){echo "selected";}echo ">12</option>";
echo "<option value='13'"; if($range_day_start=='13'){echo "selected";}echo ">13</option>";
echo "<option value='14'"; if($range_day_start=='14'){echo "selected";}echo ">14</option>";
echo "<option value='15'"; if($range_day_start=='15'){echo "selected";}echo ">15</option>";
echo "<option value='16'"; if($range_day_start=='16'){echo "selected";}echo ">16</option>";
echo "<option value='17'"; if($range_day_start=='17'){echo "selected";}echo ">17</option>";
echo "<option value='18'"; if($range_day_start=='18'){echo "selected";}echo ">18</option>";
echo "<option value='19'"; if($range_day_start=='19'){echo "selected";}echo ">19</option>";
echo "<option value='20'"; if($range_day_start=='20'){echo "selected";}echo ">20</option>";
echo "<option value='21'"; if($range_day_start=='21'){echo "selected";}echo ">21</option>";
echo "<option value='22'"; if($range_day_start=='22'){echo "selected";}echo ">22</option>";
echo "<option value='23'"; if($range_day_start=='23'){echo "selected";}echo ">23</option>";
echo "<option value='24'"; if($range_day_start=='24'){echo "selected";}echo ">24</option>";
echo "<option value='25'"; if($range_day_start=='25'){echo "selected";}echo ">25</option>";
echo "<option value='26'"; if($range_day_start=='26'){echo "selected";}echo ">26</option>";
echo "<option value='27'"; if($range_day_start=='27'){echo "selected";}echo ">27</option>";
echo "<option value='28'"; if($range_day_start=='28'){echo "selected";}echo ">28</option>";
echo "<option value='29'"; if($range_day_start=='29'){echo "selected";}echo ">29</option>";
echo "<option value='30'"; if($range_day_start=='30'){echo "selected";}echo ">30</option>";
echo "<option value='31'"; if($range_day_start=='31'){echo "selected";}echo ">31</option>";

echo "</select></td>";

echo "<td><select name='range_year_start'><option></option>";

echo "<option value='2011'"; if($range_year_start=='2011'){echo "selected";}echo ">2011</option>";
echo "<option value='2010'"; if($range_year_start=='2010'){echo "selected";}echo ">2010</option>";

echo "</select></td>";

echo "</tr>";


echo "<tr>";

echo "<td>End</td>";

echo "<td><select name='range_month_end'><option></option>";

echo "<option value='01'"; if($range_month_end=='01'){echo "selected";}echo ">Jan</option>";
echo "<option value='02'"; if($range_month_end=='02'){echo "selected";}echo ">Feb</option>";
echo "<option value='03'"; if($range_month_end=='03'){echo "selected";}echo ">Mar</option>";
echo "<option value='04'"; if($range_month_end=='04'){echo "selected";}echo ">Apr</option>";
echo "<option value='05'"; if($range_month_end=='05'){echo "selected";}echo ">May</option>";
echo "<option value='06'"; if($range_month_end=='06'){echo "selected";}echo ">Jun</option>";
echo "<option value='07'"; if($range_month_end=='07'){echo "selected";}echo ">Jul</option>";
echo "<option value='08'"; if($range_month_end=='08'){echo "selected";}echo ">Aug</option>";
echo "<option value='09'"; if($range_month_end=='09'){echo "selected";}echo ">Sep</option>";
echo "<option value='10'"; if($range_month_end=='10'){echo "selected";}echo ">Oct</option>";
echo "<option value='11'"; if($range_month_end=='11'){echo "selected";}echo ">Nov</option>";
echo "<option value='12'"; if($range_month_end=='12'){echo "selected";}echo ">Dec</option>";

echo "</select></td>";

echo "<td><select name='range_day_end'><option></option>";

echo "<option value='01'"; if($range_day_end=='01'){echo "selected";}echo ">01</option>";
echo "<option value='02'"; if($range_day_end=='02'){echo "selected";}echo ">02</option>";
echo "<option value='03'"; if($range_day_end=='03'){echo "selected";}echo ">03</option>";
echo "<option value='04'"; if($range_day_end=='04'){echo "selected";}echo ">04</option>";
echo "<option value='05'"; if($range_day_end=='05'){echo "selected";}echo ">05</option>";
echo "<option value='06'"; if($range_day_end=='06'){echo "selected";}echo ">06</option>";
echo "<option value='07'"; if($range_day_end=='07'){echo "selected";}echo ">07</option>";
echo "<option value='08'"; if($range_day_end=='08'){echo "selected";}echo ">08</option>";
echo "<option value='09'"; if($range_day_end=='09'){echo "selected";}echo ">09</option>";
echo "<option value='10'"; if($range_day_end=='10'){echo "selected";}echo ">10</option>";
echo "<option value='11'"; if($range_day_end=='11'){echo "selected";}echo ">11</option>";
echo "<option value='12'"; if($range_day_end=='12'){echo "selected";}echo ">12</option>";
echo "<option value='13'"; if($range_day_end=='13'){echo "selected";}echo ">13</option>";
echo "<option value='14'"; if($range_day_end=='14'){echo "selected";}echo ">14</option>";
echo "<option value='15'"; if($range_day_end=='15'){echo "selected";}echo ">15</option>";
echo "<option value='16'"; if($range_day_end=='16'){echo "selected";}echo ">16</option>";
echo "<option value='17'"; if($range_day_end=='17'){echo "selected";}echo ">17</option>";
echo "<option value='18'"; if($range_day_end=='18'){echo "selected";}echo ">18</option>";
echo "<option value='19'"; if($range_day_end=='19'){echo "selected";}echo ">19</option>";
echo "<option value='20'"; if($range_day_end=='20'){echo "selected";}echo ">20</option>";
echo "<option value='21'"; if($range_day_end=='21'){echo "selected";}echo ">21</option>";
echo "<option value='22'"; if($range_day_end=='22'){echo "selected";}echo ">22</option>";
echo "<option value='23'"; if($range_day_end=='23'){echo "selected";}echo ">23</option>";
echo "<option value='24'"; if($range_day_end=='24'){echo "selected";}echo ">24</option>";
echo "<option value='25'"; if($range_day_end=='25'){echo "selected";}echo ">25</option>";
echo "<option value='26'"; if($range_day_end=='26'){echo "selected";}echo ">26</option>";
echo "<option value='27'"; if($range_day_end=='27'){echo "selected";}echo ">27</option>";
echo "<option value='28'"; if($range_day_end=='28'){echo "selected";}echo ">28</option>";
echo "<option value='29'"; if($range_day_end=='29'){echo "selected";}echo ">29</option>";
echo "<option value='30'"; if($range_day_end=='30'){echo "selected";}echo ">30</option>";
echo "<option value='31'"; if($range_day_end=='31'){echo "selected";}echo ">31</option>";

echo "</select></td>";

echo "<td><select name='range_year_end'><option></option>";

echo "<option value='2011'"; if($range_year_end=='2011'){echo "selected";}echo ">2011</option>";
echo "<option value='2010'"; if($range_year_end=='2010'){echo "selected";}echo ">2010</option>";

echo "</select></td>";

echo "<td><input type=submit name=submit2 value=Go></td>";

echo "</tr>";


echo "</form></table>";
}
*/
echo "</tr>";
	  
//row4	  

echo "<tr>";
/*
echo "<td><a href='user_activity_matrix.php?section=natural_resources&report=$report&accounts=$accounts&history=$history&period=$period&range_year_start=$range_year_start&range_month_start=$range_month_start&range_day_start=$range_day_start&range_year_end=$range_year_end&range_month_end=$range_month_end&range_day_end=$range_day_end'><font  $shade_section_natural_resources>Natural_Resources</font></a></td>";

echo "<td><a href='user_activity_matrix.php?level=3&report=$report&section=$section&district=$district&history=$history&period=$period&range_year_start=$range_year_start&range_month_start=$range_month_start&range_day_start=$range_day_start&range_year_end=$range_year_end&range_month_end=$range_month_end&range_day_end=$range_day_end'><font $shade_user_level_3>3</font></a></td>";
*/

if($period=='range'){
//echo "<td></td><td></td>";
echo "<td><font color='brown'>Start</font></td>";

echo "<td><select name='range_month_start'><option></option>";

echo "<option value='01'"; if($range_month_start=='01'){echo "selected";}echo ">Jan</option>";
echo "<option value='02'"; if($range_month_start=='02'){echo "selected";}echo ">Feb</option>";
echo "<option value='03'"; if($range_month_start=='03'){echo "selected";}echo ">Mar</option>";
echo "<option value='04'"; if($range_month_start=='04'){echo "selected";}echo ">Apr</option>";
echo "<option value='05'"; if($range_month_start=='05'){echo "selected";}echo ">May</option>";
echo "<option value='06'"; if($range_month_start=='06'){echo "selected";}echo ">Jun</option>";
echo "<option value='07'"; if($range_month_start=='07'){echo "selected";}echo ">Jul</option>";
echo "<option value='08'"; if($range_month_start=='08'){echo "selected";}echo ">Aug</option>";
echo "<option value='09'"; if($range_month_start=='09'){echo "selected";}echo ">Sep</option>";
echo "<option value='10'"; if($range_month_start=='10'){echo "selected";}echo ">Oct</option>";
echo "<option value='11'"; if($range_month_start=='11'){echo "selected";}echo ">Nov</option>";
echo "<option value='12'"; if($range_month_start=='12'){echo "selected";}echo ">Dec</option>";

echo "</select></td>";
echo "<td><select name='range_day_start'><option></option>";

echo "<option value='01'"; if($range_day_start=='01'){echo "selected";}echo ">01</option>";
echo "<option value='02'"; if($range_day_start=='02'){echo "selected";}echo ">02</option>";
echo "<option value='03'"; if($range_day_start=='03'){echo "selected";}echo ">03</option>";
echo "<option value='04'"; if($range_day_start=='04'){echo "selected";}echo ">04</option>";
echo "<option value='05'"; if($range_day_start=='05'){echo "selected";}echo ">05</option>";
echo "<option value='06'"; if($range_day_start=='06'){echo "selected";}echo ">06</option>";
echo "<option value='07'"; if($range_day_start=='07'){echo "selected";}echo ">07</option>";
echo "<option value='08'"; if($range_day_start=='08'){echo "selected";}echo ">08</option>";
echo "<option value='09'"; if($range_day_start=='09'){echo "selected";}echo ">09</option>";
echo "<option value='10'"; if($range_day_start=='10'){echo "selected";}echo ">10</option>";
echo "<option value='11'"; if($range_day_start=='11'){echo "selected";}echo ">11</option>";
echo "<option value='12'"; if($range_day_start=='12'){echo "selected";}echo ">12</option>";
echo "<option value='13'"; if($range_day_start=='13'){echo "selected";}echo ">13</option>";
echo "<option value='14'"; if($range_day_start=='14'){echo "selected";}echo ">14</option>";
echo "<option value='15'"; if($range_day_start=='15'){echo "selected";}echo ">15</option>";
echo "<option value='16'"; if($range_day_start=='16'){echo "selected";}echo ">16</option>";
echo "<option value='17'"; if($range_day_start=='17'){echo "selected";}echo ">17</option>";
echo "<option value='18'"; if($range_day_start=='18'){echo "selected";}echo ">18</option>";
echo "<option value='19'"; if($range_day_start=='19'){echo "selected";}echo ">19</option>";
echo "<option value='20'"; if($range_day_start=='20'){echo "selected";}echo ">20</option>";
echo "<option value='21'"; if($range_day_start=='21'){echo "selected";}echo ">21</option>";
echo "<option value='22'"; if($range_day_start=='22'){echo "selected";}echo ">22</option>";
echo "<option value='23'"; if($range_day_start=='23'){echo "selected";}echo ">23</option>";
echo "<option value='24'"; if($range_day_start=='24'){echo "selected";}echo ">24</option>";
echo "<option value='25'"; if($range_day_start=='25'){echo "selected";}echo ">25</option>";
echo "<option value='26'"; if($range_day_start=='26'){echo "selected";}echo ">26</option>";
echo "<option value='27'"; if($range_day_start=='27'){echo "selected";}echo ">27</option>";
echo "<option value='28'"; if($range_day_start=='28'){echo "selected";}echo ">28</option>";
echo "<option value='29'"; if($range_day_start=='29'){echo "selected";}echo ">29</option>";
echo "<option value='30'"; if($range_day_start=='30'){echo "selected";}echo ">30</option>";
echo "<option value='31'"; if($range_day_start=='31'){echo "selected";}echo ">31</option>";

echo "</select></td>";

echo "<td><select name='range_year_start'><option></option>";

//echo "<option value='2008'"; if($range_year_start=='2008'){echo "selected";}echo ">2008</option>";
//echo "<option value='2009'"; if($range_year_start=='2009'){echo "selected";}echo ">2009</option>";
echo "<option value='2010'"; if($range_year_start=='2010'){echo "selected";}echo ">2010</option>";
echo "<option value='2011'"; if($range_year_start=='2011'){echo "selected";}echo ">2011</option>";
echo "<option value='2012'"; if($range_year_start=='2012'){echo "selected";}echo ">2012</option>";
echo "<option value='2013'"; if($range_year_start=='2013'){echo "selected";}echo ">2013</option>";
echo "<option value='2014'"; if($range_year_start=='2014'){echo "selected";}echo ">2014</option>";

echo "</select></td>";
}
//echo "</form>";
echo "</tr>";

//row5	  

echo "<tr>";
/*
echo "<td><a href='user_activity_matrix.php?section=trails&report=$report&accounts=$accounts&history=$history&period=$period&range_year_start=$range_year_start&range_month_start=$range_month_start&range_day_start=$range_day_start&range_year_end=$range_year_end&range_month_end=$range_month_end&range_day_end=$range_day_end'><font  $shade_section_trails>Trails</font></a></td>";

echo "<td><a href='user_activity_matrix.php?level=2&report=$report&section=$section&district=$district&history=$history&period=$period&range_year_start=$range_year_start&range_month_start=$range_month_start&range_day_start=$range_day_start&range_year_end=$range_year_end&range_month_end=$range_month_end&range_day_end=$range_day_end'><font $shade_user_level_2>2</font></a></td>";
*/

if($period=='range'){
//echo "<td></td><td></td>";
echo "<td><font color='brown'>End</font></td>";

echo "<td><select name='range_month_end'><option></option>";

echo "<option value='01'"; if($range_month_end=='01'){echo "selected";}echo ">Jan</option>";
echo "<option value='02'"; if($range_month_end=='02'){echo "selected";}echo ">Feb</option>";
echo "<option value='03'"; if($range_month_end=='03'){echo "selected";}echo ">Mar</option>";
echo "<option value='04'"; if($range_month_end=='04'){echo "selected";}echo ">Apr</option>";
echo "<option value='05'"; if($range_month_end=='05'){echo "selected";}echo ">May</option>";
echo "<option value='06'"; if($range_month_end=='06'){echo "selected";}echo ">Jun</option>";
echo "<option value='07'"; if($range_month_end=='07'){echo "selected";}echo ">Jul</option>";
echo "<option value='08'"; if($range_month_end=='08'){echo "selected";}echo ">Aug</option>";
echo "<option value='09'"; if($range_month_end=='09'){echo "selected";}echo ">Sep</option>";
echo "<option value='10'"; if($range_month_end=='10'){echo "selected";}echo ">Oct</option>";
echo "<option value='11'"; if($range_month_end=='11'){echo "selected";}echo ">Nov</option>";
echo "<option value='12'"; if($range_month_end=='12'){echo "selected";}echo ">Dec</option>";

echo "</select></td>";

echo "<td><select name='range_day_end'><option></option>";

echo "<option value='01'"; if($range_day_end=='01'){echo "selected";}echo ">01</option>";
echo "<option value='02'"; if($range_day_end=='02'){echo "selected";}echo ">02</option>";
echo "<option value='03'"; if($range_day_end=='03'){echo "selected";}echo ">03</option>";
echo "<option value='04'"; if($range_day_end=='04'){echo "selected";}echo ">04</option>";
echo "<option value='05'"; if($range_day_end=='05'){echo "selected";}echo ">05</option>";
echo "<option value='06'"; if($range_day_end=='06'){echo "selected";}echo ">06</option>";
echo "<option value='07'"; if($range_day_end=='07'){echo "selected";}echo ">07</option>";
echo "<option value='08'"; if($range_day_end=='08'){echo "selected";}echo ">08</option>";
echo "<option value='09'"; if($range_day_end=='09'){echo "selected";}echo ">09</option>";
echo "<option value='10'"; if($range_day_end=='10'){echo "selected";}echo ">10</option>";
echo "<option value='11'"; if($range_day_end=='11'){echo "selected";}echo ">11</option>";
echo "<option value='12'"; if($range_day_end=='12'){echo "selected";}echo ">12</option>";
echo "<option value='13'"; if($range_day_end=='13'){echo "selected";}echo ">13</option>";
echo "<option value='14'"; if($range_day_end=='14'){echo "selected";}echo ">14</option>";
echo "<option value='15'"; if($range_day_end=='15'){echo "selected";}echo ">15</option>";
echo "<option value='16'"; if($range_day_end=='16'){echo "selected";}echo ">16</option>";
echo "<option value='17'"; if($range_day_end=='17'){echo "selected";}echo ">17</option>";
echo "<option value='18'"; if($range_day_end=='18'){echo "selected";}echo ">18</option>";
echo "<option value='19'"; if($range_day_end=='19'){echo "selected";}echo ">19</option>";
echo "<option value='20'"; if($range_day_end=='20'){echo "selected";}echo ">20</option>";
echo "<option value='21'"; if($range_day_end=='21'){echo "selected";}echo ">21</option>";
echo "<option value='22'"; if($range_day_end=='22'){echo "selected";}echo ">22</option>";
echo "<option value='23'"; if($range_day_end=='23'){echo "selected";}echo ">23</option>";
echo "<option value='24'"; if($range_day_end=='24'){echo "selected";}echo ">24</option>";
echo "<option value='25'"; if($range_day_end=='25'){echo "selected";}echo ">25</option>";
echo "<option value='26'"; if($range_day_end=='26'){echo "selected";}echo ">26</option>";
echo "<option value='27'"; if($range_day_end=='27'){echo "selected";}echo ">27</option>";
echo "<option value='28'"; if($range_day_end=='28'){echo "selected";}echo ">28</option>";
echo "<option value='29'"; if($range_day_end=='29'){echo "selected";}echo ">29</option>";
echo "<option value='30'"; if($range_day_end=='30'){echo "selected";}echo ">30</option>";
echo "<option value='31'"; if($range_day_end=='31'){echo "selected";}echo ">31</option>";

echo "</select></td>";

echo "<td><select name='range_year_end'><option></option>";

//echo "<option value='2008'"; if($range_year_start=='2008'){echo "selected";}echo ">2008</option>";
//echo "<option value='2009'"; if($range_year_start=='2009'){echo "selected";}echo ">2009</option>";
echo "<option value='2010'"; if($range_year_end=='2010'){echo "selected";}echo ">2010</option>";
echo "<option value='2011'"; if($range_year_end=='2011'){echo "selected";}echo ">2011</option>";
echo "<option value='2012'"; if($range_year_end=='2012'){echo "selected";}echo ">2012</option>";
echo "<option value='2013'"; if($range_year_end=='2013'){echo "selected";}echo ">2013</option>";
echo "<option value='2014'"; if($range_year_end=='2014'){echo "selected";}echo ">2014</option>";

echo "</select></td>";
if(!isset($district)){$district="";}
echo "<input type='hidden' name='period' value='range'>";	
echo "<input type='hidden' name='report' value='$report'>";	
echo "<input type='hidden' name='user_level' value='$user_level'>";	
echo "<input type='hidden' name='section' value='$section'>";	
echo "<input type='hidden' name='district' value='$district'>";
echo "<td><input type='submit' name='submit2' value='Go'></td>";

}

echo "</tr>";

//echo "<td></td>";

//echo "</tr>";
//row6	  

//echo "<tr>";

/*
echo "<td><a href='user_activity_matrix.php?section=operations&report=$report&user_level=$user_level&history=$history&period=$period&range_year_start=$range_year_start&range_month_start=$range_month_start&range_day_start=$range_day_start&range_year_end=$range_year_end&range_month_end=$range_month_end&range_day_end=$range_day_end'><font  $shade_section_operations>Operations</font></a></td>
      <td><a href='user_activity_matrix.php?user_level=1&report=$report&section=$section&district=$district&history=$history&period=$period&range_year_start=$range_year_start&range_month_start=$range_month_start&range_day_start=$range_day_start&range_year_end=$range_year_end&range_month_end=$range_month_end&range_day_end=$range_day_end'><font $shade_user_level_1>1</font></a></td>
</tr>";
*/
/*
if($section=='operations'){

if($district==''){$district="all";}

if($district=='all'){$shade_district_all="class=cartRow";}
if($district=='east'){$shade_district_east="class=cartRow";}
if($district=='north'){$shade_district_north="class=cartRow";}
if($district=='south'){$shade_district_south="class=cartRow";}
if($district=='west'){$shade_district_west="class=cartRow";}
if($district=='stwd'){$shade_district_stwd="class=cartRow";}


echo "<tr>";
echo "<th><font color=brown >Districts</font></th>";
echo "<td><a href='user_activity_matrix.php?district=all&report=$report&section=$section&user_level=$user_level&history=$history&period=$period&range_year_start=$range_year_start&range_month_start=$range_month_start&range_day_start=$range_day_start&range_year_end=$range_year_end&range_month_end=$range_month_end&range_day_end=$range_day_end'><font  $shade_district_all>ALL</font></a></td>";
echo "<td><a href='user_activity_matrix.php?district=east&report=$report&section=$section&user_level=$user_level&history=$history&period=$period&range_year_start=$range_year_start&range_month_start=$range_month_start&range_day_start=$range_day_start&range_year_end=$range_year_end&range_month_end=$range_month_end&range_day_end=$range_day_end'><font  $shade_district_east>East</font></a></td>";
echo "<td><a href='user_activity_matrix.php?district=north&report=$report&section=$section&user_level=$user_level&history=$history&period=$period&range_year_start=$range_year_start&range_month_start=$range_month_start&range_day_start=$range_day_start&range_year_end=$range_year_end&range_month_end=$range_month_end&range_day_end=$range_day_end'><font  $shade_district_north>North</font></a></td>";
echo "<td><a href='user_activity_matrix.php?district=south&report=$report&section=$section&user_level=$user_level&history=$history&period=$period&range_year_start=$range_year_start&range_month_start=$range_month_start&range_day_start=$range_day_start&range_year_end=$range_year_end&range_month_end=$range_month_end&range_day_end=$range_day_end'><font  $shade_district_south>South</font></a></td>";
echo "<td><a href='user_activity_matrix.php?district=west&report=$report&section=$section&user_level=$user_level&history=$history&period=$period&&range_year_start=$range_year_start&range_month_start=$range_month_start&range_day_start=$range_day_start&range_year_end=$range_year_end&range_month_end=$range_month_end&range_day_end=$range_day_end'><font  $shade_district_west>West</font></a></td>";
echo "<td><a href='user_activity_matrix.php?district=stwd&report=$report&section=$section&user_level=$user_level&history=$history&period=$period&range_year_start=$range_year_start&range_month_start=$range_month_start&range_day_start=$range_day_start&range_year_end=$range_year_end&range_month_end=$range_month_end&range_day_end=$range_day_end'><font  $shade_district_stwd>Stwd</font></a></td>";
echo "</tr>";

}
*/
    echo "</form>";
	echo "</table>";  
	  
	
	echo "<br />";  
/*  	  
echo "<table>";
echo "<tr>";


	echo "
	  
      <td><a href='user_activity_matrix.php?scope=receipt&fyearhist=$fyearhist'><font  $shade_receipt>Receipt</font></a></td>
      <td><a href='user_activity_matrix.php?scope=disburse&fyearhist=$fyearhist'><font  $shade_disburse>Disburse</font></a></td>
      <td><a href='user_activity_matrix.php?scope=gmp&fyearhist=$fyearhist'><font  $shade_gmp>GMP</font></a></td>
      	  
</tr></table><br />";
echo "</table>";
//$class2="class=cartRow2";

echo "<table border='1'>";


echo "<tr>";
echo "<td><font color=brown class=cartRow>Fiscal Year history:</font></td>
      <td><a href='user_activity_matrix.php?fyearhist=10yr&scope=$scope'><font  $shade_10yr>10yr</font></a></td>
      <td><a href='user_activity_matrix.php?fyearhist=5yr&scope=$scope'><font  $shade_5yr>5yr</font></a></td>
      <td><a href='user_activity_matrix.php?fyearhist=3yr&scope=$scope'><font  $shade_3yr>3yr</font></a></td>
      <td><a href='user_activity_matrix.php?fyearhist=1yr&scope=$scope'><font  $shade_1yr>1yr</font></a></td>
     
      
      	  
</tr></table><br />";

*/

?>

