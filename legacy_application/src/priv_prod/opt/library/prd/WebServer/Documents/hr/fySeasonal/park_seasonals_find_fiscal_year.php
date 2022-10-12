<?php

session_start();
$level=$_SESSION['hr']['level'];
$new_request_date=$_SESSION['hr']['new_request_date'];
$fiscal_year=$_SESSION['hr']['fiscal_year'];
if($level<1){echo "You do not have access to this database. <a href='http://www.dpr.ncparks.gov/hr/'>login</a>";exit;}

// echo "<pre>"; print_r($_POST); echo "</pre>";  //exit;

$database="hr";
include("../../../include/iConnect.inc"); // database connection parameters
mysqli_select_db($connection,$database);

if($rep==""){include("menu_fiscal_year.php");}

$sql = "SELECT distinct upper(center_code) as center_code FROM seasonal_payroll_fiscal_year 
WHERE  1 and fiscal_year='$fiscal_year'
ORDER  BY center_code"; //echo "$sql";
$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql");
while($row=mysqli_fetch_assoc($result)){
		if($level==2){
		if(!in_array($row['center_code'],$distList)){continue;}
		}
	$center_code_array[]=$row['center_code'];
	}
	
$sql = "SELECT t1.osbm_title, t2.position_desc as hr_position_title
FROM hr.seasonal_payroll_justification as t1
left join divper.B0149 as t2 on t1.beacon_num=t2.position
WHERE  1
ORDER  BY t1.osbm_title"; //echo "$sql";
$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql ");
while($row=mysqli_fetch_assoc($result)){
		if($level==2){
		if(!in_array($row['center_code'],$distList)){continue;}
		}
	$osbm_title_array[]=$row['osbm_title'];
	if($row['hr_position_title']==""){$row['hr_position_title']="unknown";}
	$hr_position_title_array[$row['osbm_title']]=$row['hr_position_title'];
	}
// echo "<pre>"; print_r($hr_position_title_array); echo "</pre>"; // exit;

if($rep==""){
	echo "<form action='park_seasonals_find_fiscal_year.php' method='POST'><table cellpadding='5'><tr>";

		echo "<td>Center Code: <select name=\"center_code\"><option selected></option>";
		foreach($center_code_array as $k=>$v){
// 		if($center_code==$v){$s="selected";}else{$s="value";}
		echo "<option value='$v'>$v</option>";
 	      }

		echo "<td>OSBM Title: <select name=\"osbm_title\"><option selected></option>";
		foreach($osbm_title_array as $k=>$v){
// 		if($osbm_title==$v){$s="selected";}else{$s="";}
		echo "<option value='$v'>$v</option>";
 	      }
		echo "<td>HR Title: <select name=\"osbm_title\">
		<option selected></option>";
		foreach($hr_position_title_array as $k=>$v){
// 		if($osbm_title==$k){$s="selected";}else{$s="";}
		echo "<option value='$k'>$v</option>";
 	      }


	echo "<td>BEACON Position Number: <input type='text' name='beacon_posnum' value='$beacon_posnum' size='8'></td>";
		
	echo "<td><input type='submit' name='submit' value='Find'></form></td>";

	echo "<form action='park_seasonals_find_fiscal_year.php'><td><input type='submit' name='reset' value='Reset'></td></form>";
	echo "</tr></table>";

}


if($submit==""){exit;}

$clause="WHERE 1";
	if(!$_POST){
		if($center_code){$clause.=" and center_code='$center_code'";}
		if($beacon_posnum){$clause.=" and beacon_posnum='$beacon_posnum'";}
		
		}
	
	if($_POST['center_code']){$cc=$_POST['center_code'];}
	
foreach($_POST as $k=>$v){
	if($k=="submit" || $v==""){continue;}
	$clause.=" and ".$k."='".$v."'";
	}
//	$clause=rtrim($clause," and");
	
// $sql = "SELECT *
// FROM seasonal_payroll_fiscal_year as t1
// $clause
// ORDER  BY div_app desc, center,osbm_title"; 
// echo "$sql"; //exit;
$sql = "SELECT t1.*, t2.position_desc as hr_position_title
FROM hr.seasonal_payroll_fiscal_year as t1
left join divper.B0149 as t2 on t1.beacon_posnum=t2.position
 $clause
ORDER  BY t1.osbm_title"; 
// echo "$sql";
$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql");
$num0=mysqli_num_rows($result);
	if($num0<1){echo "none found using $clause"; exit;}
while($row=mysqli_fetch_assoc($result)){$date_array[]=$row;}
//echo "<pre>"; print_r($result_array); echo "</pre>"; exit;

if(!$date_array){
		$date_array[0]=array("id"=>"","osbm_title"=>"$osbm_title","budget_hrs"=>"","budget_weeks"=>"","avg_rate"=>"","budget_dollars"=>"","center"=>"","ncas_account"=>"","start_date"=>"","center_code"=>"","park_approve"=>"","div_app"=>"","beacon_posnum"=>"","district"=>"","comments"=>"","park_comments"=>"");
		}
//echo "<pre>"; print_r($date_array); echo "</pre>"; // exit;
if($date_array){

echo "<table border='1' cellpadding='3'>";
// Header
$hr_title=$hr_position_title_array[$_POST['osbm_title']];
if($rep==""){echo "<tr><td colspan='19' align='center'>$num0 found using $clause &nbsp;&nbsp;&nbsp;HR position title: $hr_title.</td></tr>";
		echo "<tr>";}
		
		

if($rep=="excel"){header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment; filename=seasonal_positions.xls');
echo "<tr>";}

// Header
//$skip=array("div_app");
foreach($date_array[0] as $fld=>$val){
		if(in_array($fld,$skip)){continue;}
		$fld=str_replace("_"," ",$fld);
		echo "<th>$fld</th>";}
		echo "</tr>";

	if($rep==""){echo "<form method='POST' name='frm_0' action='park_seasonals_positions_fiscal_year.php'>";}

// Body
//$skip=array("div_app");
foreach($date_array as $number=>$fields){
			$size=10;
				$id=$date_array[$number]['id'];
				$beacon_number=$date_array[$number]['beacon_posnum'];
		echo "<tr>";
		foreach($fields as $fld_name=>$value){
//			if(in_array($fld_name,$skip)){continue;}
			$td="";
					
			if($fld_name=="id"){
				if($rep==""){
			$value="<a href='park_seasonals_add_fiscal_year.php?id=$id&del=y' onClick='return confirmLink()'>$value</a>";}else{$value=$value;}
					}
										
			if($fld_name=="beacon_posnum"){
				if($rep==""){
			$value="<a href='update_position_fiscal_year.php?beacon_posnum=$value' target='_blank'>$value</a>";}else{$value=$value;}
					}
					
			if($fld_name=="budget_hrs"){
				$size=5;
				$budget_hrs=$value;
				$totHours+=$value;
				$wks=$date_array[$number]['budget_weeks'];
				if($wks>0){$numWks++;}
				$totWeeks+=$wks;
			
				if($rep==""){
			$value="<input type='text'  name='budget_hrs[$beacon_number]' value='$value' size=$size>";}else{$value=$budget_hrs;}
					}
								
			if($fld_name=="budget_dollars"){
				$value=($date_array[$number]['budget_weeks']*$date_array[$number]['budget_hrs']*$date_array[$number]['avg_rate']);
				$totAmount+=$value;
					}
					
			if($fld_name=="comments"){
				$comments=$value;
				if($rep==""){
			$value="<textarea name='comments[$beacon_number]' cols='30' rows='5'>$comments</textarea>";}else{$value=$comments;}
					}
					
				echo "<td$td>$value</td>";
				}
		echo "</tr>";
		}
		$totAmount=number_format($totAmount,2);
		$avg_weeks=$totWeeks/$numWks;
	echo "<tr>
	<td colspan='3' align='right'>$totHours hours/week</td>
	<td align='right'>$avg_weeks weeks</td>
	<td colspan='2' align='right'>$$totAmount</td>
	</tr>";

if($level>3)
	{
	if(!isset($datebegin)){$datebegin="";}
	echo "<tr>
	<td colspan='5' align='right'>	
	<input type='hidden' name='center_code' value='$center_code'>
	<input type='hidden' name='datebegin' value='$datebegin'>
	<input type='submit' name='submit' value='Update'></td>
	<td colspan='12'></td>
	</tr></table></form>";
	}
}// end if date_array


?>