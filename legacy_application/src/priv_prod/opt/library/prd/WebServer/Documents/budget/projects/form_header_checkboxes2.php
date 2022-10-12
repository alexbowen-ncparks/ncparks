<?php
echo "<html>";
extract($_REQUEST);



echo "<table border='1'>";
 echo "<form action='project_reports_matrix2.php'>";
 //$cat_ci=X;
 //$cat_ci='';
 //if($history=='10yr'){include("center_ten_yr_history.php");}
 
 /*
if($administration=="X"){$ck_administration="checked" ;$shade_administration="class=cartRow";}else {$ck_administration="";$shade_administration='';}	  	 
if($design_development=="X"){$ck_design_development="checked" ;$shade_design_development="class=cartRow";}else {$ck_design_development="";$shade_design_development='';}	  	 
if($natural_resources=="X"){$ck_natural_resources="checked" ;$shade_natural_resources="class=cartRow";}else {$ck_natural_resources="";$natural_resources='';}	  	 
if($operations=="X"){$ck_operations="checked" ;$shade_operations="class=cartRow";}else {$ck_operations="";$shade_operations='';}	  	 
	  	 


//if($cat_ci=="X"){$shade_de="class=cartRow";}

	
echo "<tr><td><font color='brown' class='cartRow'>Section</font> 
    <font $shade_administration>Administration</font><input type='checkbox' name='administration'  value='X' $ck_administration>
    <font $shade_design_development>Design_Development</font><input type='checkbox' name='design_development'  value='X' $ck_design_development>
    <font $shade_natural_resources>Natural_Resources</font><input type='checkbox' name='natural_resources'  value='X' $ck_natural_resources>
    <font $shade_operations>Operations</font><input type='checkbox' name='operations'  value='X' $ck_operations>
	
	</td>
	</tr>";
	
*/
	echo "</table>";
	echo "<br />";
	
$query5="select * from fiscal_year where report_year='$f_year' ";
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
	
echo "</tr>";
echo "<tr><td>Fiscal Year Range>>>&nbsp;&nbsp;   Start: <input type='text' size='3' name='fiscal_year_start' value='$fiscal_year_start'>  End: <input type='text' size='3' name='fiscal_year_end' value='$fiscal_year_end'></td></tr></table>";
	
	
	
	
echo "<table border='1'>";	

/*
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
	
	
	*/
echo "<tr>";
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