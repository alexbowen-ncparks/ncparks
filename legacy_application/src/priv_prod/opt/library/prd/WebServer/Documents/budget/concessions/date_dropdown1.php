<?php

session_start();

if(!$_SESSION["budget"]["tempID"]){echo "access denied";exit;}
echo "<pre>";print_r($_SESSION); echo "</pre>";//exit;

$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempid=$_SESSION['budget']['tempID'];
extract($_REQUEST);
echo "<pre>";print_r($_REQUEST);echo "</pre>";//exit;
//echo "<pre>";print_r($_SERVER);echo "</pre>"; //exit;


if(!isset($range_year_start)){$range_year_start="";}
if(!isset($range_month_start)){$range_month_start="";}
if(!isset($range_day_start)){$range_day_start="";}
$range_start=$range_year_start.$range_month_start.$range_day_start;

if(!isset($range_year_end)){$range_year_end="";}
if(!isset($range_month_end)){$range_month_end="";}
if(!isset($range_day_end)){$range_day_end="";}
$range_end=$range_year_end.$range_month_end.$range_day_end;


echo "range_year_start=$range_year_start";echo "<br />";
echo "range_month_start=$range_month_start";echo "<br />";
echo "range_day_start=$range_day_start";echo "<br />";
echo "range_year_end=$range_year_end";echo "<br />";
echo "range_month_end=$range_month_end";echo "<br />";
echo "range_day_end=$range_day_end";echo "<br />";

echo "range_start=$range_start";
echo "<br />";
echo "range_end=$range_end";
echo "<br /><br />";


$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
echo "<table border='1'>";

echo "<form method=post autocomplete='off' action=date_dropdown1.php>";
//LINE1
echo "<tr>";
echo "<td></td><td><font color='brown'>Month1</font></td><td><font color='brown'>Day1</font></td><td><font color='brown'>Year1</font></td><td>>>>></td><td><font color='brown'>Month2</font></td><td><font color='brown'>Day2</font></td><td><font color='brown'>Year2</font></td>";
echo "</tr>";
//LINE2	  
echo "<tr>";
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

echo "</select></td>";
echo "<td>>>>></td>";

echo "<td></td><td></td><td></td>";







//echo "</form>";
echo "</tr>";

//row5	  
//LINE3
echo "<tr>";
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

echo "</select></td>";
echo "<td>>>>></td>";



echo "<td></td><td></td><td></td>";









echo "<input type='hidden' name='period' value='range'>";	
echo "<input type='hidden' name='report' value='$report'>";	
echo "<input type='hidden' name='accounts' value='$accounts'>";	
echo "<input type='hidden' name='section' value='$section'>";	
echo "<input type='hidden' name='district' value='$district'>";	
echo "<input type='hidden' name='district' value='$district'>";	
echo "<input type='hidden' name='district' value='$district'>";	
echo "<input type='hidden' name='district' value='$district'>";	

echo "<td><input type=submit name=submit2 value=Go></td>";


echo "</tr>";



	echo "</table>";  
	  
	
	

?>