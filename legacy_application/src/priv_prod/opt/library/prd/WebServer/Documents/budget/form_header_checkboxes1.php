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
    <font $shade_ci>CI</font><input type='checkbox' name='cat_ci'  value='X' $ck_ci>
	<font $shade_de>DE</font><input type='checkbox' name='cat_de' value='X' $ck_de> 
	<font $shade_en>EN</font><input type='checkbox' name='cat_en' value='X' $ck_en> 
	<font $shade_er>ER</font><input type='checkbox' name='cat_er' value='X' $ck_er>
	<font $shade_la>LA</font><input type='checkbox' name='cat_la' value='X' $ck_la>
	<font $shade_mi>MI</font><input type='checkbox' name='cat_mi' value='X' $ck_mi> 
	<font $shade_mm>MM</font><input type='checkbox' name='cat_mm' value='X' $ck_mm> 
	<font $shade_na>NA</font><input type='checkbox' name='cat_na' value='X' $ck_na> 
	<font $shade_nr>NR</font><input type='checkbox' name='cat_nr' value='X' $ck_nr> 
	<font $shade_tm>TM</font><input type='checkbox' name='cat_tm' value='X' $ck_tm>	
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
    <font $shade_status_ca>&nbsp&nbsp&nbsp   CA</font><input type='checkbox' name='status_ca'  value='X' $ck_status_ca>
    <font $shade_status_fi>FI</font><input type='checkbox' name='status_fi'  value='X' $ck_status_fi>
    <font $shade_status_ip>IP</font><input type='checkbox' name='status_ip'  value='X' $ck_status_ip>
    <font $shade_status_na>NA</font><input type='checkbox' name='status_na'  value='X' $ck_status_na>
    <font $shade_status_ns>NS</font><input type='checkbox' name='status_ns'  value='X' $ck_status_ns>
    <font $shade_status_oh>OH</font><input type='checkbox' name='status_oh'  value='X' $ck_status_oh>
    <font $shade_status_tr>TR</font><input type='checkbox' name='status_tr'  value='X' $ck_status_tr>
    		
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
    
      		
	</td>";	
	
echo "<td>Park<br /><input type='text' size='3' name='parkS' value='$parkS'></td>";
echo "<td>";
echo "<select name='managerS'>";
echo "<option value=''></option>";
if($managerS=='dwayne_parker'){echo "<option value='dwayne_parker' selected>dwayne_parker</option>";} else {echo "<option value='dwayne_parker'>dwayne_parker</option>";}
if($managerS=='jody_reavis'){echo "<option value='jody_reavis' selected>jody_reavis</option>";} else {echo "<option value='jody_reavis'>jody_reavis</option>";}
if($managerS=='john_johnson'){echo "<option value='john_johnson' selected>john_johnson</option>";} else {echo "<option value='john_johnson'>john_johnson</option>";}
if($managerS=='patrick_noel'){echo "<option value='patrick_noel' selected>patrick_noel</option>";} else {echo "<option value='patrick_noel'>patrick_noel</option>";}
if($managerS=='pete_mitchell'){echo "<option value='pete_mitchell' selected>pete_mitchell</option>";} else {echo "<option value='pete_mitchell'>pete_mitchell</option>";}
if($managerS=='randy_ayers'){echo "<option value='randy_ayers' selected>randy_ayers</option>";} else {echo "<option value='randy_ayers'>randy_ayers</option>";}

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
echo "<tr><td>Year Order <input type='checkbox' name='year_order'  value='X' $ck_year_order></td></tr>"; 
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