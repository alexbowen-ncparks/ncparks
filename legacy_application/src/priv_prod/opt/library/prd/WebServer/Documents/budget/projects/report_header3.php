<?php

echo "<table border='1'>";


//if($accounts=="all"){$shade_accounts_all="class=cartRow";}
//if($accounts=="receipt"){$shade_accounts_receipt="class=cartRow";}
//if($accounts=="disburse"){$shade_accounts_disburse="class=cartRow";}
//if($accounts=="gmp"){$shade_accounts_gmp="class=cartRow";}


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
if($period=='other'){$shade_period_other="class=cartRow";}




//echo "shade_location_all=$shade_location_all";

//header_row
echo "<tr><th><font color=brown >section</font></th><th><font color=brown >history</font></th></tr>";

//echo "<br />";

//row1
echo "<tr>";
echo "<td><a href='project_reports_matrix.php?section=all&report=$report&accounts=$accounts&history=$history&period=$period'><font  $shade_section_all>ALL</font></a></td>";
//echo "<td><a href='reports_all_centers_summary_by_division.php?accounts=all&report=$report&section=$section&district=$district&history=$history&period=$period'><font  $shade_accounts_all>ALL</font></a></td>";
echo "<td><a href='reports_all_centers_summary_by_division.php?&history=10yr&report=$report&accounts=$accounts&section=$section&period=$period'><font  $shade_history_10yr>10yr</font></a></td>";
//echo "<td><a href='reports_all_centers_summary_by_division.php?&period=fyear&report=$report&accounts=$accounts&section=$section&history=$history'><font  $shade_period_fyear>fyear</font></a></td>";
echo "</tr>";
	 
//row2	  
echo "<tr>";
echo "<td><a href='reports_all_centers_summary_by_division.php?section=administration&report=$report&accounts=$accounts&district=$district&history=$history&period=$period'><font  $shade_section_administration>Administration</font></a></td>";
echo "</tr>";
//echo "<td><a href='reports_all_centers_summary_by_division.php?accounts=receipt&report=$report&section=$section&district=$district&history=$history&period=$period'><font  $shade_accounts_receipt>Receipt</font></a></td>";
echo "<td><a href='reports_all_centers_summary_by_division.php?history=5yr&report=$report&accounts=$accounts&section=$section&district=$district&period=$period'><font  $shade_history_5yr>5yr</font></a></td>";
//echo "<td><a href='reports_all_centers_summary_by_division.php?period=cyear&history=$history&report=$report&accounts=$accounts&section=$section&district=$district'><font  $shade_period_cyear>cyear</font></a></td>";
//echo "</tr>";
    
	  
//row3	  

echo "<tr>";
echo "<td><a href='reports_all_centers_summary_by_division.php?section=design_development&report=$report&accounts=$accounts&history=$history&period=$period'><font  $shade_section_design_development>Design_Develop</font></a></td>";
//echo "<td><a href='reports_all_centers_summary_by_division.php?accounts=disburse&report=$report&section=$section&district=$district&history=$history&period=$period'><font  $shade_accounts_disburse>Disburse</font></a></td>";
echo "<td><a href='reports_all_centers_summary_by_division.php?history=3yr&report=$report&accounts=$accounts&section=$section&period=$period'><font  $shade_history_3yr>3yr</font></a></td>";
echo "</tr>";
	  
//row4	  

echo "<tr>";
echo "<td><a href='reports_all_centers_summary_by_division.php?section=natural_resources&report=$report&accounts=$accounts&history=$history&period=$period'><font  $shade_section_natural_resources>Natural_Resources</font></a></td>";
//echo "<td><a href='reports_all_centers_summary_by_division.php?accounts=gmp&report=$report&section=$section&district=$district&history=$history&period=$period'><font  $shade_accounts_gmp>GMP</font></a></td>";
echo "<td><a href='reports_all_centers_summary_by_division.php?history=1yr&report=$report&accounts=$accounts&section=$section&period=$period'><font  $shade_history_1yr>1yr</font></a></td>";
echo "</tr>";

//row5	  

//echo "<tr>";
//echo "<td><a href='reports_all_centers_summary_by_division.php?section=trails&report=$report&accounts=$accounts&history=$history&period=$period'><font  $shade_section_trails>Trails</font></a></td>";
//echo "</tr>";
//row6	  

echo "<tr>";

echo "<td><a href='reports_all_centers_summary_by_division.php?section=operations&report=$report&accounts=$accounts&history=$history&period=$period'><font  $shade_section_operations>Operations</font></a></td></tr>";
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
echo "<td><a href='reports_all_centers_summary_by_division.php?district=all&report=$report&section=$section&accounts=$accounts&history=$history&period=$period'><font  $shade_district_all>ALL</font></a></td>";
echo "<td><a href='reports_all_centers_summary_by_division.php?district=east&report=$report&section=$section&accounts=$accounts&history=$history&period=$period'><font  $shade_district_east>East</font></a></td>";
echo "<td><a href='reports_all_centers_summary_by_division.php?district=north&report=$report&section=$section&accounts=$accounts&history=$history&period=$period'><font  $shade_district_north>North</font></a></td>";
echo "<td><a href='reports_all_centers_summary_by_division.php?district=south&report=$report&section=$section&accounts=$accounts&history=$history&period=$period'><font  $shade_district_south>South</font></a></td>";
echo "<td><a href='reports_all_centers_summary_by_division.php?district=west&report=$report&section=$section&accounts=$accounts&history=$history&period=$period'><font  $shade_district_west>West</font></a></td>";
echo "<td><a href='reports_all_centers_summary_by_division.php?district=stwd&report=$report&section=$section&accounts=$accounts&history=$history&period=$period'><font  $shade_district_stwd>Stwd</font></a></td>";
echo "</tr>";

}
	echo "</table>";  
	  
	
	echo "<br />";  
/*  	  
echo "<table>";
echo "<tr>";


	echo "
	  
      <td><a href='reports_all_centers_summary_by_division.php?scope=receipt&fyearhist=$fyearhist'><font  $shade_receipt>Receipt</font></a></td>
      <td><a href='reports_all_centers_summary_by_division.php?scope=disburse&fyearhist=$fyearhist'><font  $shade_disburse>Disburse</font></a></td>
      <td><a href='reports_all_centers_summary_by_division.php?scope=gmp&fyearhist=$fyearhist'><font  $shade_gmp>GMP</font></a></td>
      	  
</tr></table><br />";
echo "</table>";
//$class2="class=cartRow2";

echo "<table border='1'>";


echo "<tr>";
echo "<td><font color=brown class=cartRow>Fiscal Year history:</font></td>
      <td><a href='reports_all_centers_summary_by_division.php?fyearhist=10yr&scope=$scope'><font  $shade_10yr>10yr</font></a></td>
      <td><a href='reports_all_centers_summary_by_division.php?fyearhist=5yr&scope=$scope'><font  $shade_5yr>5yr</font></a></td>
      <td><a href='reports_all_centers_summary_by_division.php?fyearhist=3yr&scope=$scope'><font  $shade_3yr>3yr</font></a></td>
      <td><a href='reports_all_centers_summary_by_division.php?fyearhist=1yr&scope=$scope'><font  $shade_1yr>1yr</font></a></td>
     
      
      	  
</tr></table><br />";

*/

?>

