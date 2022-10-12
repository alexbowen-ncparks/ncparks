<?php
echo "<html>";
extract($_REQUEST);



echo "<table border='1'>";
 echo "<form action='project_reports_matrix2.php'>";
 //$cat_ci=X;
 //$cat_ci='';
 //if($history=='10yr'){include("center_ten_yr_history.php");}
if($cat_ci=="X"){$ck_ci="checked" ;$shade_ci="class=cartRow";}else {$ck_ci="";$shade_ci='';}	  	 
if($cat_de=="X"){$ck_de="checked" ;$shade_de="class=cartRow";}else {$ck_de="";$shade_de='';}	  	 
if($cat_en=="X"){$ck_en="checked" ;$shade_en="class=cartRow";}else {$ck_en="";$shade_en='';}	  	 
if($cat_er=="X"){$ck_er="checked" ;$shade_er="class=cartRow";}else {$ck_er="";$shade_er='';}	  	 
if($cat_la=="X"){$ck_la="checked" ;$shade_la="class=cartRow";}else {$ck_la="";$shade_la='';}	  	 
if($cat_mi=="X"){$ck_mi="checked" ;$shade_mi="class=cartRow";}else {$ck_mi="";$shade_mi='';}	  	 
if($cat_mm=="X"){$ck_mm="checked" ;$shade_mm="class=cartRow";}else {$ck_mm="";$shade_mm='';}	  	 
if($cat_na=="X"){$ck_na="checked" ;$shade_na="class=cartRow";}else {$ck_na="";$shade_na='';}	  	 
if($cat_nr=="X"){$ck_nr="checked" ;$shade_nr="class=cartRow";}else {$ck_nr="";$shade_nr='';}	  	 
if($cat_tm=="X"){$ck_tm="checked" ;$shade_tm="class=cartRow";}else {$ck_tm="";$shade_tm='';}	  	 


//if($cat_ci=="X"){$shade_de="class=cartRow";}

	
echo "<tr><td><font color='brown' class='cartRow'>Category</font> 
    <font $shade_ci><span title='capital improvements'>CI</span></font><input type='checkbox' name='cat_ci'  value='X' $ck_ci>
	<font $shade_de><span title='demolitions'>DE</span></font><input type='checkbox' name='cat_de' value='X' $ck_de> 
	<font $shade_en><span title='exhibits new'>EN</span></font><input type='checkbox' name='cat_en' value='X' $ck_en> 
	<font $shade_er><span title='exhibits repair'>ER</span></font><input type='checkbox' name='cat_er' value='X' $ck_er>
	<font $shade_la><span title='land purchases'>LA</span></font><input type='checkbox' name='cat_la' value='X' $ck_la>
	<font $shade_mi><span title='miscellaneous'>MI</span></font><input type='checkbox' name='cat_mi' value='X' $ck_mi> 
	<font $shade_mm><span title='major maintenance'>MM</span></font><input type='checkbox' name='cat_mm' value='X' $ck_mm> 
	<font $shade_na><span title='not applicable'>NA</span></font><input type='checkbox' name='cat_na' value='X' $ck_na> 
	<font $shade_nr><span title='natural resources'>NR</span></font><input type='checkbox' name='cat_nr' value='X' $ck_nr> 
	<font $shade_tm><span title='trail maintenance'>TM</span></font><input type='checkbox' name='cat_tm' value='X' $ck_tm>	
	</td>
	</tr>";
	echo "</table>";
	echo "<br />";
echo "<table border='1'>";	
if($status_ca=="X"){$ck_status_ca="checked" ;$shade_status_ca="class=cartRow";}else {$ck_status_ca="";$shade_status_ca='';}	  	 
if($status_fi=="X"){$ck_status_fi="checked" ;$shade_status_fi="class=cartRow";}else {$ck_status_fi="";$shade_status_fi='';}	  	 
if($status_ip=="X"){$ck_status_ip="checked" ;$shade_status_ip="class=cartRow";}else {$ck_status_ip="";$shade_status_ip='';}	  	 
if($status_na=="X"){$ck_status_na="checked" ;$shade_status_na="class=cartRow";}else {$ck_status_na="";$shade_status_na='';}	  	 
if($status_ns=="X"){$ck_status_ns="checked" ;$shade_status_ns="class=cartRow";}else {$ck_status_ns="";$shade_status_ns='';}	  	 
if($status_oh=="X"){$ck_status_oh="checked" ;$shade_status_oh="class=cartRow";}else {$ck_status_oh="";$shade_status_oh='';}	  	 
if($status_tr=="X"){$ck_status_tr="checked" ;$shade_status_tr="class=cartRow";}else {$ck_status_tr="";$shade_status_tr='';}	  	 

echo "<tr><td><font color='brown' class='cartRow'>Status</font> 
    <font $shade_status_ca>&nbsp&nbsp&nbsp  <span title='cancelled'> CA</span></font><input type='checkbox' name='status_ca'  value='X' $ck_status_ca>
    <font $shade_status_fi><span title='finished'>FI</span></font><input type='checkbox' name='status_fi'  value='X' $ck_status_fi>
    <font $shade_status_ip><span title='in-process'>IP</span></font><input type='checkbox' name='status_ip'  value='X' $ck_status_ip>
    <font $shade_status_na><span title='not applicable'>NA</span></font><input type='checkbox' name='status_na'  value='X' $ck_status_na>
    <font $shade_status_ns><span title='not started'>NS</span></font><input type='checkbox' name='status_ns'  value='X' $ck_status_ns>
    <font $shade_status_oh><span title='on-hold'>OH</span></font><input type='checkbox' name='status_oh'  value='X' $ck_status_oh>
    <font $shade_status_tr><span title='transferred'>TR</span></font><input type='checkbox' name='status_tr'  value='X' $ck_status_tr>
    		
	</td>";
echo "</tr></table>";


$query5="select * from fiscal_year where report_year='$f_year' ";
echo "<br />Line 65: query5=$query5<br />";
$result5 = mysqli_query($connection, $query5) or die ("Couldn't execute query 5.  $query5");
$row5=mysqli_fetch_array($result5);
extract($row5);

	
echo "<table border='1'>";	
if($fyear_cy=="X"){$ck_fyear_cy="checked" ;$shade_fyear_cy="class=cartRow";}else {$ck_fyear_cy="";$shade_fyear_cy='';}	  	 
if($fyear_py1=="X"){$ck_fyear_py1="checked" ;$shade_fyear_py1="class=cartRow";}else {$ck_fyear_py1="";$shade_fyear_py1='';}	  	 
if($fyear_py2=="X"){$ck_fyear_py2="checked" ;$shade_fyear_py2="class=cartRow";}else {$ck_fyear_py2="";$shade_fyear_py2='';}	  	 
if($fyear_py3=="X"){$ck_fyear_py3="checked" ;$shade_fyear_py3="class=cartRow";}else {$ck_fyear_py3="";$shade_fyear_py3='';}	  	 
if($fyear_py4=="X"){$ck_fyear_py4="checked" ;$shade_fyear_py4="class=cartRow";}else {$ck_fyear_py4="";$shade_fyear_py4='';}	  	 
if($fyear_py5=="X"){$ck_fyear_py5="checked" ;$shade_fyear_py5="class=cartRow";}else {$ck_fyear_py5="";$shade_fyear_py5='';}	  	 
if($fyear_py6=="X"){$ck_fyear_py6="checked" ;$shade_fyear_py6="class=cartRow";}else {$ck_fyear_py6="";$shade_fyear_py6='';}	  	 
if($fyear_py7=="X"){$ck_fyear_py7="checked" ;$shade_fyear_py7="class=cartRow";}else {$ck_fyear_py7="";$shade_fyear_py7='';}	  	 
if($fyear_py8=="X"){$ck_fyear_py8="checked" ;$shade_fyear_py8="class=cartRow";}else {$ck_fyear_py8="";$shade_fyear_py8='';}	  	 
if($fyear_py9=="X"){$ck_fyear_py9="checked" ;$shade_fyear_py9="class=cartRow";}else {$ck_fyear_py9="";$shade_fyear_py9='';}	  	 
if($fyear_py10=="X"){$ck_fyear_py10="checked" ;$shade_fyear_py10="class=cartRow";}else {$ck_fyear_py10="";$shade_fyear_py10='';}	  	 
if($fyear_py11=="X"){$ck_fyear_py11="checked" ;$shade_fyear_py11="class=cartRow";}else {$ck_fyear_py11="";$shade_fyear_py11='';}	  	 
if($fyear_py12=="X"){$ck_fyear_py12="checked" ;$shade_fyear_py12="class=cartRow";}else {$ck_fyear_py12="";$shade_fyear_py12='';}	  	 
if($fyear_py13=="X"){$ck_fyear_py13="checked" ;$shade_fyear_py13="class=cartRow";}else {$ck_fyear_py13="";$shade_fyear_py13='';}	  	 
if($fyear_py14=="X"){$ck_fyear_py14="checked" ;$shade_fyear_py14="class=cartRow";}else {$ck_fyear_py14="";$shade_fyear_py14='';}	  	 
if($fyear_py15=="X"){$ck_fyear_py15="checked" ;$shade_fyear_py15="class=cartRow";}else {$ck_fyear_py15="";$shade_fyear_py15='';}	  	 
if($fyear_py16=="X"){$ck_fyear_py16="checked" ;$shade_fyear_py16="class=cartRow";}else {$ck_fyear_py16="";$shade_fyear_py16='';}	  	 
if($fyear_py17=="X"){$ck_fyear_py17="checked" ;$shade_fyear_py17="class=cartRow";}else {$ck_fyear_py17="";$shade_fyear_py17='';}	  	 
  	 



echo "<tr><td><font color='brown' class='cartRow'>Fund Year</font> 
    <font $shade_fyear_cy>&nbsp&nbsp&nbsp   $cy</font><input type='checkbox' name='fyear_cy'  value='X' $ck_fyear_cy>
    <font $shade_fyear_py1>&nbsp&nbsp&nbsp  $py1</font><input type='checkbox' name='fyear_py1'  value='X' $ck_fyear_py1>
    <font $shade_fyear_py2>&nbsp&nbsp&nbsp  $py2</font><input type='checkbox' name='fyear_py2'  value='X' $ck_fyear_py2>
    <font $shade_fyear_py3>&nbsp&nbsp&nbsp  $py3</font><input type='checkbox' name='fyear_py3'  value='X' $ck_fyear_py3>
    <font $shade_fyear_py4>&nbsp&nbsp&nbsp  $py4</font><input type='checkbox' name='fyear_py4'  value='X' $ck_fyear_py4>
    <font $shade_fyear_py5>&nbsp&nbsp&nbsp  $py5</font><input type='checkbox' name='fyear_py5'  value='X' $ck_fyear_py5>
    <font $shade_fyear_py6>&nbsp&nbsp&nbsp  $py6</font><input type='checkbox' name='fyear_py6'  value='X' $ck_fyear_py6>
    <font $shade_fyear_py7>&nbsp&nbsp&nbsp  $py7</font><input type='checkbox' name='fyear_py7'  value='X' $ck_fyear_py7>
    <font $shade_fyear_py8>&nbsp&nbsp&nbsp  $py8</font><input type='checkbox' name='fyear_py8'  value='X' $ck_fyear_py8>
    <font $shade_fyear_py9>&nbsp&nbsp&nbsp  $py9</font><input type='checkbox' name='fyear_py9'  value='X' $ck_fyear_py9>
    <font $shade_fyear_py10>&nbsp&nbsp&nbsp $py10</font><input type='checkbox' name='fyear_py10'  value='X' $ck_fyear_py10>
    <font $shade_fyear_py11>&nbsp&nbsp&nbsp $py11</font><input type='checkbox' name='fyear_py11'  value='X' $ck_fyear_py11>
    <font $shade_fyear_py12>&nbsp&nbsp&nbsp $py12</font><input type='checkbox' name='fyear_py12'  value='X' $ck_fyear_py12>
    <font $shade_fyear_py13>&nbsp&nbsp&nbsp $py13</font><input type='checkbox' name='fyear_py13'  value='X' $ck_fyear_py13>
    <font $shade_fyear_py14>&nbsp&nbsp&nbsp $py14</font><input type='checkbox' name='fyear_py14'  value='X' $ck_fyear_py14>
    <font $shade_fyear_py15>&nbsp&nbsp&nbsp $py15</font><input type='checkbox' name='fyear_py15'  value='X' $ck_fyear_py15>
    <font $shade_fyear_py16>&nbsp&nbsp&nbsp $py16</font><input type='checkbox' name='fyear_py16'  value='X' $ck_fyear_py16>
    <font $shade_fyear_py17>&nbsp&nbsp&nbsp $py17</font><input type='checkbox' name='fyear_py17'  value='X' $ck_fyear_py17>
   
    
      		
	</td>";	
	
echo "<td>Park<br /><input type='text' size='3' name='parkS' value='$parkS'></td>";
if($beacnum != '60033166' and $beacnum != '65027689')
{
echo "<td>";
echo "Manager";
echo "<br />";
echo "<select name='managerS'>";
echo "<option value=''></option>";
if($managerS=='amy_sawyer'){echo "<option value='amy_sawyer' selected>amy_sawyer</option>";} else {echo "<option value='amy_sawyer'>amy_sawyer</option>";}
if($managerS=='craig_autry'){echo "<option value='craig_autry' selected>craig_autry</option>";} else {echo "<option value='craig_autry'>craig_autry</option>";}
if($managerS=='daron_blount'){echo "<option value='daron_blount' selected>daron_blount</option>";} else {echo "<option value='daron_blount'>daron_blount</option>";}
if($managerS=='dwayne_parker'){echo "<option value='dwayne_parker' selected>dwayne_parker</option>";} else {echo "<option value='dwayne_parker'>dwayne_parker</option>";}
if($managerS=='jody_reavis'){echo "<option value='jody_reavis' selected>jody_reavis</option>";} else {echo "<option value='jody_reavis'>jody_reavis</option>";}
if($managerS=='john_johnson'){echo "<option value='john_johnson' selected>john_johnson</option>";} else {echo "<option value='john_johnson'>john_johnson</option>";}
//if($managerS=='justin_williamson'){echo "<option value='justin_williamson' selected>justin_williamson</option>";} else {echo "<option value='justin_williamson'>justin_williamson</option>";}
if($managerS=='mark_lyons'){echo "<option value='mark_lyons' selected>mark_lyons</option>";} else {echo "<option value='mark_lyons'>mark_lyons</option>";}
if($managerS=='neal_pate'){echo "<option value='neal_pate' selected>neal_pate</option>";} else {echo "<option value='neal_pate'>neal_pate</option>";}
if($managerS=='patrick_noel'){echo "<option value='patrick_noel' selected>patrick_noel</option>";} else {echo "<option value='patrick_noel'>patrick_noel</option>";}
//if($managerS=='pete_mitchell'){echo "<option value='pete_mitchell' selected>pete_mitchell</option>";} else {echo "<option value='pete_mitchell'>pete_mitchell</option>";}
if($managerS=='randy_ayers'){echo "<option value='randy_ayers' selected>randy_ayers</option>";} else {echo "<option value='randy_ayers'>randy_ayers</option>";}
if($managerS=='shane_felts'){echo "<option value='shane_felts' selected>shane_felts</option>";} else {echo "<option value='shane_felts'>shane_felts</option>";}
if($managerS=='vinnie_shea'){echo "<option value='vinnie_shea' selected>vinnie_shea</option>";} else {echo "<option value='vinnie_shea'>vinnie_shea</option>";}
echo "</td>";
}

echo "<td>Project Name<br /><input type='text' size='40' name='project_nameS' value='$project_nameS'></td>";

/*
echo "<option value='patrick_noel'>patrick_noel</option>";
echo "<option value='pete_mitchell'>pete_mitchell</option>";
echo "<option value='randy_ayers'>randy_ayers</option>";
*/
echo "</select>";
echo "</td>";

if($park_order=="X"){$ck_park_order="checked" ;}else {$ck_park_order='';}
if($year_order=="X"){$ck_year_order="checked" ;}else {$ck_year_order='';}



echo "<td><font color='brown' class='cartRow'>";
echo "<table>";
//echo "<tr><td>Order:</td></tr></font></td></tr>"; 
//echo "<tr><td>Park <input type='checkbox' name='park_order'  value='X' $ck_park_order></td></tr>"; 
echo "<tr>";
echo "<td>Year Order <input type='checkbox' name='year_order'  value='X' $ck_year_order></td>";
echo "<td>Calyear<br />Spent<br /><input type='text' size='3' name='calyearS' value='$calyearS'></td>";
echo "</tr>"; 
echo "</table>";
echo "<td>";

echo "<input type='hidden' name='report' value='$report'>";
echo "<input type='submit' name='submit' value='Find'>";


echo "</form></td>";




 echo "<form action='project_reports_matrix2.php'>";
 /*
echo "<input type='hidden' name='cat_ci'  value=''>";
echo "<input type='hidden' name='cat_de'  value=''>";
echo "<input type='hidden' name='cat_en'  value=''>";
echo "<input type='hidden' name='cat_er'  value=''>";
echo "<input type='hidden' name='cat_la'  value=''>";
echo "<input type='hidden' name='cat_mi'  value=''>";
echo "<input type='hidden' name='cat_mm'  value=''>";
echo "<input type='hidden' name='cat_tm'  value=''>";
*/
echo "<input type='hidden' name='report' value='$report'>";
echo "<td><input type='submit' name='submit2' value='reset'></td>";
echo "</form>";
echo "</tr>";
echo "</table";


	
echo "</html>";
?>