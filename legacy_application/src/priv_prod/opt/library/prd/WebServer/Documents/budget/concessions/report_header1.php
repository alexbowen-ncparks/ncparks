<?php

echo "<table border='1' align='center'>";


if($accounts=="all"){$shade_accounts_all="cartRow";}
if($accounts=="receipt"){$shade_accounts_receipt="class=cartRow";}
if($accounts=="disburse"){$shade_accounts_disburse="class=cartRow";}
if($accounts=="gmp"){$shade_accounts_gmp="class=cartRow";}


if($section=='all'){$shade_section_all="cartRow";}
	else{$shade_section_all="";}
if($section=='administration'){$shade_section_administration="class=cartRow";}
	else{$shade_section_administration="";}
if($section=='design_development'){$shade_section_design_development="class=cartRow";}
	else{$shade_section_design_development="";}
if($section=='natural_resources'){$shade_section_natural_resources="class=cartRow";}
	else{$shade_section_natural_resources="";}
if($section=='operations'){$shade_section_operations="class=cartRow";}
	else{$shade_section_operations="";}
if($section=='trails'){$shade_section_trails="class=cartRow";}
	else{$shade_section_trails="";}

/*
if($section=='section'){$shade_location_section="class=cartRow2";}
if($location=='district'){$shade_location_district="class=cartRow2";}
if($location=='center'){$shade_location_center="class=cartRow2";}
*/

if($history=='1yr'){$shade_history_1yr="class=cartRow";}
	else{$shade_history_1yr="";}
if($history=='3yr'){$shade_history_3yr="cartRow";}
	else{$shade_history_3yr="";}
if($history=='5yr'){$shade_history_5yr="class=cartRow";}
	else{$shade_history_5yr="";}
if($history=='10yr'){$shade_history_10yr="class=cartRow";}
	else{$shade_history_10yr="";}


if($period=='fyear'){$shade_period_fyear="cartRow";}
	else{$shade_period_fyear="";}
if($period=='cyear'){$shade_period_cyear="class=cartRow";}
	else{$shade_period_cyear="";}
if($period=='range'){$shade_period_range="class=cartRow";}
	else{$shade_period_range="";}




//echo "shade_location_all=$shade_location_all";

//header_row
echo "<tr><th><font color='brown' >section</font></th><th><font color='brown' >accounts</font></th><th><font color='brown' >history</font></th><th><font color='brown' >period</font></th></tr>";
//echo "<br />";

//row1
echo "<tr>";
echo "<td><a href='reports_all_centers_summary_by_division.php?section=all&amp;report=$report&amp;accounts=$accounts&amp;history=$history&amp;period=$period&amp;range_year_start=$range_year_start&amp;range_year_start2=$range_year_start2&amp;range_month_start=$range_month_start&amp;range_day_start=$range_day_start&amp;range_year_end=$range_year_end&amp;range_year_end2=$range_year_end2&amp;range_month_end=$range_month_end&amp;range_day_end=$range_day_end'><font  class='$shade_section_all'>ALL</font></a></td>";

if(!isset($district)){$district="";}
echo "<td><a href='reports_all_centers_summary_by_division.php?accounts=all&amp;report=$report&amp;section=$section&amp;district=$district&amp;history=$history&amp;period=$period&amp;range_year_start=$range_year_start&amp;range_year_start2=$range_year_start2&amp;range_month_start=$range_month_start&amp;range_day_start=$range_day_start&amp;range_year_end=$range_year_end&amp;range_year_end2=$range_year_end2&amp;range_month_end=$range_month_end&amp;range_day_end=$range_day_end'><font  class='$shade_accounts_all'>ALL</font></a></td>";
echo "<td><a href='reports_all_centers_summary_by_division.php?&amp;history=10yr&amp;report=$report&amp;accounts=$accounts&amp;section=$section&amp;district=$district&amp;period=$period'><font  $shade_history_10yr>10yr</font></a></td>";
echo "<td><a href='reports_all_centers_summary_by_division.php?&amp;period=fyear&amp;report=$report&amp;accounts=$accounts&amp;section=$section&amp;district=$district&amp;history=$history'><font class='$shade_period_fyear'>fyear</font></a></td>";
echo "</tr>";
	 
//row2	  
echo "<tr>";
echo "<td><a href='reports_all_centers_summary_by_division.php?section=administration&amp;report=$report&amp;accounts=$accounts&amp;district=$district&amp;history=$history&amp;period=$period&amp;range_year_start=$range_year_start&amp;range_year_start2=$range_year_start2&amp;range_month_start=$range_month_start&amp;range_day_start=$range_day_start&amp;range_year_end=$range_year_end&amp;range_year_end2=$range_year_end2&amp;range_month_end=$range_month_end&amp;range_day_end=$range_day_end'><font  $shade_section_administration>Administration</font></a></td>";
echo "<td><a href='reports_all_centers_summary_by_division.php?accounts=receipt&amp;report=$report&amp;section=$section&amp;district=$district&amp;history=$history&amp;period=$period&amp;range_year_start=$range_year_start&amp;range_year_start2=$range_year_start2&amp;range_month_start=$range_month_start&amp;range_day_start=$range_day_start&amp;range_year_end=$range_year_end&amp;range_year_end2=$range_year_end2&amp;range_month_end=$range_month_end&amp;range_day_end=$range_day_end'><font  $shade_accounts_receipt>Receipt</font></a></td>";

echo "<td><a href='reports_all_centers_summary_by_division.php?history=5yr&amp;report=$report&amp;accounts=$accounts&amp;section=$section&amp;district=$district&amp;period=$period'><font  $shade_history_5yr>5yr</font></a></td>";

//echo "<td><a href='home.php'><font  $shade_history_5yr>5yr</font></a></td>";



echo "<td><a href='reports_all_centers_summary_by_division.php?period=cyear&amp;history=$history&amp;report=$report&amp;accounts=$accounts&amp;section=$section&amp;district=$district'><font  $shade_period_cyear>cyear</font></a></td>";
/*
if($period=='range'){
echo "<td colspan='3'><font color='red'>Range Data</font></td>";
}
*/
echo "</tr>";
    
	  
//row3	  

echo "<tr>";
echo "<td><a href='reports_all_centers_summary_by_division.php?section=design_development&amp;district=$district&amp;report=$report&amp;accounts=$accounts&amp;history=$history&amp;period=$period&amp;range_year_start=$range_year_start&amp;range_year_start2=$range_year_start2&amp;range_month_start=$range_month_start&amp;range_day_start=$range_day_start&amp;range_year_end=$range_year_end&amp;range_year_end2=$range_year_end2&amp;range_month_end=$range_month_end&amp;range_day_end=$range_day_end'><font  $shade_section_design_development>Design_Develop</font></a></td>";
echo "<td><a href='reports_all_centers_summary_by_division.php?accounts=disburse&amp;report=$report&amp;section=$section&amp;district=$district&amp;history=$history&amp;period=$period&amp;range_year_start=$range_year_start&amp;range_year_start2=$range_year_start2&amp;range_month_start=$range_month_start&amp;range_day_start=$range_day_start&amp;range_year_end=$range_year_end&amp;range_year_end2=$range_year_end2&amp;range_month_end=$range_month_end&amp;range_day_end=$range_day_end'><font  $shade_accounts_disburse>Disburse</font></a></td>";
echo "<td><a href='reports_all_centers_summary_by_division.php?history=3yr&amp;report=$report&amp;accounts=$accounts&amp;section=$section&amp;district=$district&amp;period=$period'><font class='$shade_history_3yr'>3yr</font></a></td>";
echo "<td><a href='reports_all_centers_summary_by_division.php?period=range&amp;report=$report&amp;accounts=$accounts&amp;section=$section&amp;district=$district'><font  $shade_period_range>range</font></a></td>";
if($period=='range'){
echo "<form method=post autocomplete='off' action=reports_all_centers_summary_by_division.php>";
echo "<td><font color='brown'>Month</font></td><td><font color='brown'>Day</font></td><td><font color='brown'>Year1</font></td><td>>>>></td><td><font color='brown'>Year2</font></td>";}

/*
if($period=='range'){
echo "<td></td><td>Month</td><td>Day</td><td>Year</td></tr>";
echo "<form method=post autocomplete='off' action=reports_all_centers_summary_by_division.php>";
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
echo "<td><a href='reports_all_centers_summary_by_division.php?section=natural_resources&amp;district=$district&amp;report=$report&amp;accounts=$accounts&amp;history=$history&amp;period=$period&amp;range_year_start=$range_year_start&amp;range_year_start2=$range_year_start2&amp;range_month_start=$range_month_start&amp;range_day_start=$range_day_start&amp;range_year_end=$range_year_end&amp;range_year_end2=$range_year_end2&amp;range_month_end=$range_month_end&amp;range_day_end=$range_day_end'><font  $shade_section_natural_resources>Natural_Resources</font></a></td>";
echo "<td><a href='reports_all_centers_summary_by_division.php?accounts=gmp&amp;report=$report&amp;section=$section&amp;district=$district&amp;history=$history&amp;period=$period&amp;range_year_start=$range_year_start&amp;range_year_start2=$range_year_start2&amp;range_month_start=$range_month_start&amp;range_day_start=$range_day_start&amp;range_year_end=$range_year_end&amp;range_year_end2=$range_year_end2&amp;range_month_end=$range_month_end&amp;range_day_end=$range_day_end'><font $shade_accounts_gmp>GMP</font></a></td>";
echo "<td><a href='reports_all_centers_summary_by_division.php?history=1yr&amp;report=$report&amp;accounts=$accounts&amp;section=$section&amp;district=$district&amp;period=$period'><font  $shade_history_1yr>1yr</font></a></td>";
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
echo "<option value='2009'"; if($range_year_start=='2009'){echo "selected";}echo ">2009</option>";
echo "<option value='2010'"; if($range_year_start=='2010'){echo "selected";}echo ">2010</option>";
echo "<option value='2011'"; if($range_year_start=='2011'){echo "selected";}echo ">2011</option>";
echo "<option value='2012'"; if($range_year_start=='2012'){echo "selected";}echo ">2012</option>";
echo "<option value='2013'"; if($range_year_start=='2013'){echo "selected";}echo ">2013</option>";
echo "<option value='2014'"; if($range_year_start=='2014'){echo "selected";}echo ">2014</option>";
echo "<option value='2015'"; if($range_year_start=='2015'){echo "selected";}echo ">2015</option>";
echo "<option value='2016'"; if($range_year_start=='2016'){echo "selected";}echo ">2016</option>";
echo "<option value='2017'"; if($range_year_start=='2017'){echo "selected";}echo ">2017</option>";
echo "<option value='2018'"; if($range_year_start=='2018'){echo "selected";}echo ">2018</option>";
echo "<option value='2019'"; if($range_year_start=='2019'){echo "selected";}echo ">2019</option>";
echo "<option value='2020'"; if($range_year_start=='2020'){echo "selected";}echo ">2020</option>";
echo "<option value='2021'"; if($range_year_start=='2021'){echo "selected";}echo ">2021</option>";
echo "<option value='2022'"; if($range_year_start=='2022'){echo "selected";}echo ">2022</option>";

echo "</select></td>";
echo "<td>>>>></td>";

echo "<td><select name='range_year_start2'><option></option>";

//echo "<option value='2008'"; if($range_year_start=='2008'){echo "selected";}echo ">2008</option>";
echo "<option value='2009'"; if($range_year_start2=='2009'){echo "selected";}echo ">2009</option>";
echo "<option value='2010'"; if($range_year_start2=='2010'){echo "selected";}echo ">2010</option>";
echo "<option value='2011'"; if($range_year_start2=='2011'){echo "selected";}echo ">2011</option>";
echo "<option value='2012'"; if($range_year_start2=='2012'){echo "selected";}echo ">2012</option>";
echo "<option value='2013'"; if($range_year_start2=='2013'){echo "selected";}echo ">2013</option>";
echo "<option value='2014'"; if($range_year_start2=='2014'){echo "selected";}echo ">2014</option>";
echo "<option value='2015'"; if($range_year_start2=='2015'){echo "selected";}echo ">2015</option>";
echo "<option value='2016'"; if($range_year_start2=='2016'){echo "selected";}echo ">2016</option>";
echo "<option value='2017'"; if($range_year_start2=='2017'){echo "selected";}echo ">2017</option>";
echo "<option value='2018'"; if($range_year_start2=='2018'){echo "selected";}echo ">2018</option>";
echo "<option value='2019'"; if($range_year_start2=='2019'){echo "selected";}echo ">2019</option>";
echo "<option value='2020'"; if($range_year_start2=='2020'){echo "selected";}echo ">2020</option>";
echo "<option value='2021'"; if($range_year_start2=='2021'){echo "selected";}echo ">2021</option>";
echo "<option value='2022'"; if($range_year_start2=='2022'){echo "selected";}echo ">2022</option>";

echo "</select></td>";






}
//echo "</form>";
echo "</tr>";

//row5	  

echo "<tr>";
echo "<td><a href='reports_all_centers_summary_by_division.php?section=trails&amp;district=$district&amp;report=$report&amp;accounts=$accounts&amp;history=$history&amp;period=$period&amp;range_year_start=$range_year_start&amp;range_year_start2=$range_year_start2&amp;range_month_start=$range_month_start&amp;range_day_start=$range_day_start&amp;range_year_end=$range_year_end&amp;range_year_end2=$range_year_end2&amp;range_month_end=$range_month_end&amp;range_day_end=$range_day_end'><font  $shade_section_trails>Trails</font></a></td>";
if($period=='range'){
echo "<td></td><td></td>";
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
echo "<option value='2009'"; if($range_year_end=='2009'){echo "selected";}echo ">2009</option>";
echo "<option value='2010'"; if($range_year_end=='2010'){echo "selected";}echo ">2010</option>";
echo "<option value='2011'"; if($range_year_end=='2011'){echo "selected";}echo ">2011</option>";
echo "<option value='2012'"; if($range_year_end=='2012'){echo "selected";}echo ">2012</option>";
echo "<option value='2013'"; if($range_year_end=='2013'){echo "selected";}echo ">2013</option>";
echo "<option value='2014'"; if($range_year_end=='2014'){echo "selected";}echo ">2014</option>";
echo "<option value='2015'"; if($range_year_end=='2015'){echo "selected";}echo ">2015</option>";
echo "<option value='2016'"; if($range_year_end=='2016'){echo "selected";}echo ">2016</option>";
echo "<option value='2017'"; if($range_year_end=='2017'){echo "selected";}echo ">2017</option>";
echo "<option value='2018'"; if($range_year_end=='2018'){echo "selected";}echo ">2018</option>";
echo "<option value='2019'"; if($range_year_end=='2019'){echo "selected";}echo ">2019</option>";
echo "<option value='2020'"; if($range_year_end=='2020'){echo "selected";}echo ">2020</option>";
echo "<option value='2021'"; if($range_year_end=='2021'){echo "selected";}echo ">2021</option>";
echo "<option value='2022'"; if($range_year_end=='2022'){echo "selected";}echo ">2022</option>";

// 2022-08-11: CCOOPER adding 2023 FYR
echo "<option value='2023'"; if($range_year_end=='2023'){echo "selected";}echo ">2023</option>";
// 2022-08-11: End CCOOPER

echo "</select></td>";
echo "<td>>>>></td>";

echo "<td><select name='range_year_end2'><option></option>";

//echo "<option value='2008'"; if($range_year_start=='2008'){echo "selected";}echo ">2008</option>";
echo "<option value='2009'"; if($range_year_end2=='2009'){echo "selected";}echo ">2009</option>";
echo "<option value='2010'"; if($range_year_end2=='2010'){echo "selected";}echo ">2010</option>";
echo "<option value='2011'"; if($range_year_end2=='2011'){echo "selected";}echo ">2011</option>";
echo "<option value='2012'"; if($range_year_end2=='2012'){echo "selected";}echo ">2012</option>";
echo "<option value='2013'"; if($range_year_end2=='2013'){echo "selected";}echo ">2013</option>";
echo "<option value='2014'"; if($range_year_end2=='2014'){echo "selected";}echo ">2014</option>";
echo "<option value='2015'"; if($range_year_end2=='2015'){echo "selected";}echo ">2015</option>";
echo "<option value='2016'"; if($range_year_end2=='2016'){echo "selected";}echo ">2016</option>";
echo "<option value='2017'"; if($range_year_end2=='2017'){echo "selected";}echo ">2017</option>";
echo "<option value='2018'"; if($range_year_end2=='2018'){echo "selected";}echo ">2018</option>";
echo "<option value='2019'"; if($range_year_end2=='2019'){echo "selected";}echo ">2019</option>";
echo "<option value='2020'"; if($range_year_end2=='2020'){echo "selected";}echo ">2020</option>";
echo "<option value='2021'"; if($range_year_end2=='2021'){echo "selected";}echo ">2021</option>";
echo "<option value='2022'"; if($range_year_end2=='2022'){echo "selected";}echo ">2022</option>";

// 2022-08-11: CCOOPER adding 2023 FYR
echo "<option value='2023'"; if($range_year_end2=='2023'){echo "selected";}echo ">2023</option>";
// 2022-08-11: End CCOOPER

echo "</select></td>";












echo "<input type='hidden' name='period' value='range'>";	
echo "<input type='hidden' name='report' value='$report'>";	
echo "<input type='hidden' name='accounts' value='$accounts'>";	
echo "<input type='hidden' name='section' value='$section'>";	
echo "<input type='hidden' name='district' value='$district'>";	
echo "<input type='hidden' name='district' value='$district'>";	
echo "<input type='hidden' name='district' value='$district'>";	
echo "<input type='hidden' name='district' value='$district'>";	
echo "<td><input type=submit name=submit2 value=Go></td>";

}
echo "</tr>";









//echo "<td></td>";

//echo "</tr>";
//row6	  

echo "<tr>";

echo "<td><a href='reports_all_centers_summary_by_division.php?section=operations&amp;district=$district&amp;report=$report&amp;accounts=$accounts&amp;history=$history&amp;period=$period&amp;range_year_start=$range_year_start&amp;range_year_start2=$range_year_start2&amp;range_month_start=$range_month_start&amp;range_day_start=$range_day_start&amp;range_year_end=$range_year_end&amp;range_year_end2=$range_year_end2&amp;range_month_end=$range_month_end&amp;range_day_end=$range_day_end'><font  $shade_section_operations>Operations</font></a></td>";

if($period=='range')
{echo "<td></td><td></td><td><font color='brown'>Monthly</td><td></td>";
}

echo "</tr>";
if($section=='operations'){

if($district==''){$district="all";}

if($district=='all'){$shade_district_all="class=cartRow";}
if($district=='east'){$shade_district_east="class=cartRow";}
if($district=='north'){$shade_district_north="class=cartRow";}
if($district=='south'){$shade_district_south="class=cartRow";}
if($district=='west'){$shade_district_west="class=cartRow";}
if($district=='stwd'){$shade_district_stwd="class=cartRow";}


echo "<tr>";
echo "<th><font color='brown' >Districts</font></th>";
echo "<td><a href='reports_all_centers_summary_by_division.php?district=all&amp;report=$report&amp;section=$section&amp;accounts=$accounts&amp;history=$history&amp;period=$period&amp;range_year_start=$range_year_start&amp;range_year_start2=$range_year_start2&amp;range_month_start=$range_month_start&amp;range_day_start=$range_day_start&amp;range_year_end=$range_year_end&amp;range_year_end2=$range_year_end2&amp;range_month_end=$range_month_end&amp;range_day_end=$range_day_end'><font  $shade_district_all>ALL</font></a></td>";
echo "<td><a href='reports_all_centers_summary_by_division.php?district=east&amp;report=$report&amp;section=$section&amp;accounts=$accounts&amp;history=$history&amp;period=$period&amp;range_year_start=$range_year_start&amp;range_year_start2=$range_year_start2&amp;range_month_start=$range_month_start&amp;range_day_start=$range_day_start&amp;range_year_end=$range_year_end&amp;range_year_end2=$range_year_end2&amp;range_month_end=$range_month_end&amp;range_day_end=$range_day_end'><font  $shade_district_east>East</font></a></td>";
echo "<td><a href='reports_all_centers_summary_by_division.php?district=north&amp;report=$report&amp;section=$section&amp;accounts=$accounts&amp;history=$history&amp;period=$period&amp;range_year_start=$range_year_start&amp;range_year_start2=$range_year_start2&amp;range_month_start=$range_month_start&amp;range_day_start=$range_day_start&amp;range_year_end=$range_year_end&amp;range_year_end2=$range_year_end2&amp;range_month_end=$range_month_end&amp;range_day_end=$range_day_end'><font  $shade_district_north>North</font></a></td>";
echo "<td><a href='reports_all_centers_summary_by_division.php?district=south&amp;report=$report&amp;section=$section&amp;accounts=$accounts&amp;history=$history&amp;period=$period&amp;range_year_start=$range_year_start&amp;range_year_start2=$range_year_start2&amp;range_month_start=$range_month_start&amp;range_day_start=$range_day_start&amp;range_year_end=$range_year_end&amp;range_year_end2=$range_year_end2&amp;range_month_end=$range_month_end&amp;range_day_end=$range_day_end'><font  $shade_district_south>South</font></a></td>";
echo "<td><a href='reports_all_centers_summary_by_division.php?district=west&amp;report=$report&amp;section=$section&amp;accounts=$accounts&amp;history=$history&amp;period=$period&amp;range_year_start=$range_year_start&amp;range_year_start2=$range_year_start2&amp;range_month_start=$range_month_start&amp;range_day_start=$range_day_start&amp;range_year_end=$range_year_end&amp;range_year_end2=$range_year_end2&amp;range_month_end=$range_month_end&amp;range_day_end=$range_day_end'><font  $shade_district_west>West</font></a></td>";
echo "<td><a href='reports_all_centers_summary_by_division.php?district=stwd&amp;report=$report&amp;section=$section&amp;accounts=$accounts&amp;history=$history&amp;period=$period&amp;range_year_start=$range_year_start&amp;range_year_start2=$range_year_start2&amp;range_month_start=$range_month_start&amp;range_day_start=$range_day_start&amp;range_year_end=$range_year_end&amp;range_year_end2=$range_year_end2&amp;range_month_end=$range_month_end&amp;range_day_end=$range_day_end'><font  $shade_district_stwd>Stwd</font></a></td>";
echo "</tr>";

}
	echo "</table>";  
	  
	
	echo "<br />";  
/*  	  
echo "<table>";
echo "<tr>";


	echo "
	  
      <td><a href='reports_all_centers_summary_by_division.php?scope=receipt&amp;fyearhist=$fyearhist'><font  $shade_receipt>Receipt</font></a></td>
      <td><a href='reports_all_centers_summary_by_division.php?scope=disburse&amp;fyearhist=$fyearhist'><font  $shade_disburse>Disburse</font></a></td>
      <td><a href='reports_all_centers_summary_by_division.php?scope=gmp&amp;fyearhist=$fyearhist'><font  $shade_gmp>GMP</font></a></td>
      	  
</tr></table><br />";
echo "</table>";
//$class2="class=cartRow2";

echo "<table border='1'>";


echo "<tr>";
echo "<td><font color=brown class=cartRow>Fiscal Year history:</font></td>
      <td><a href='reports_all_centers_summary_by_division.php?fyearhist=10yr&amp;scope=$scope'><font  $shade_10yr>10yr</font></a></td>
      <td><a href='reports_all_centers_summary_by_division.php?fyearhist=5yr&amp;scope=$scope'><font  $shade_5yr>5yr</font></a></td>
      <td><a href='reports_all_centers_summary_by_division.php?fyearhist=3yr&amp;scope=$scope'><font  $shade_3yr>3yr</font></a></td>
      <td><a href='reports_all_centers_summary_by_division.php?fyearhist=1yr&amp;scope=$scope'><font  $shade_1yr>1yr</font></a></td>
     
      
      	  
</tr></table><br />";

*/

?>

