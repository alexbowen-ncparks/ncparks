<?php
// echo "update_position_fiscal_year.php<pre>"; print_r($_REQUEST); echo "</pre>Contact Tom";  exit;
session_start();
$level=$_SESSION['hr']['level'];
$fiscal_year=$_SESSION['hr']['fiscal_year'];

if($level<1){echo "You do not have access to this database. <a href='http://auth.dpr.ncparks.gov/hr/'>login</a>";exit;}

//echo "<pre>"; print_r($_POST); echo "</pre>";  exit;
//echo "<pre>"; print_r($_REQUEST); echo "</pre>";  exit;

$database="hr";
include("../../../include/iConnect.inc"); // database connection parameters
mysqli_select_db($connection,$database);

if($submit=="Update"){
// echo "<pre>"; print_r($_POST); echo "</pre>";  exit;
$skip=array("submit","beacon_posnum");
$lower_case=array("district","div_app");
$clause2=array("osbm_log_num","park_comments","comments");
		foreach($_POST AS $fld=>$val){
		if(in_array($fld,$skip)){continue;}
		
		$val=html_entity_decode(htmlspecialchars_decode($val));
		// if(in_array($fld,$clause2)){
// 				$val=addslashes($val);
// 				}

			if($fld=="osbm_title"){
				$position_title=$_POST['osbm_title'];
				}
			if($fld=="avg_rate_new"){
				$pay_rate=$_POST['avg_rate_new'];
				}
				
			if($fld=="budget_dollars_a"){
		//		$val=$_POST['budget_hrs_a']*$_POST['avg_rate'];
				}
			if($fld=="budget_dollars_b"){
		//		$val=$_POST['budget_hrs_b']*$_POST['avg_rate'];
				}
			
			if(in_array($fld,$lower_case)){
				$val=strtolower($val);
				}
				
			$clause.=$fld."='".$val."',";
			}
			
			$clause=rtrim($clause,",");
			$sql = "Update seasonal_payroll_fiscal_year set $clause
			WHERE  beacon_posnum='$beacon_posnum' and fiscal_year='$fiscal_year'"; //echo "$sql"; exit;
			$result = mysqli_query($connection,$sql) or die ("Couldn't execute query.");
			
			$sql = "Update employ_position set position_title='$position_title', pay_rate='$pay_rate'
			WHERE  beacon_num='$beacon_posnum' "; //echo "<br /><br />$sql"; exit;
			$result = mysqli_query($connection,$sql) or die ("Couldn't execute query.");
		
		}

if($submit=="Add"){
//echo "<pre>"; print_r($_POST); echo "</pre>";  //exit;
$skip=array("submit");
		foreach($_POST AS $fld=>$val){
		if(in_array($fld,$skip)){continue;}
			$val=html_entity_decode(htmlspecialchars_decode($val));
			$clause.=$fld."='".$val."',";
			}
			
			$clause=rtrim($clause,",");
			$sql = "REPLACE seasonal_payroll_fiscal_year set $clause"; 
	//		echo "$sql"; exit;
			$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql");
			
		}

$sql = "SELECT distinct ucase(osbm_title) as osbm_title
FROM seasonal_payroll_justification
WHERE  1 order by osbm_title"; //echo "$sql"; //exit;
$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql");
while($row=mysqli_fetch_assoc($result)){
	$title_array[]=$row['osbm_title'];
	}
	
/*
Used when we had to get permission from osbm in order to hire

$seasonal_payroll_flds="t1.fiscal_year,t1.osbm_title,t1.beacon_posnum,t1.budget_hrs_a,  t1.avg_rate_new, t1.ncas_account,t1.center,t1.center_code,t1.district,t1.div_app,t1.park_comments,t1.comments";
$sql = "SELECT $seasonal_payroll_flds,t2.datebegin, t2.osbm_log_num
FROM seasonal_payroll_fiscal_year as t1
LEFT JOIN seasonal_payroll_osmb_justify as t2 on t1.beacon_posnum=t2.beacon_posnum
WHERE  t1.beacon_posnum='$beacon_posnum' and fiscal_year='$fiscal_year'"; 
*/

$seasonal_payroll_flds="t1.osbm_title,t1.beacon_posnum,t1.budget_hrs_a,  t1.avg_rate_new, t1.ncas_account,t1.center,t1.center_code,t1.district,t1.div_app,t1.park_comments,t1.comments";

$sql = "SELECT $seasonal_payroll_flds
FROM seasonal_payroll_fiscal_year as t1
WHERE  t1.beacon_posnum='$beacon_posnum' "; 
// echo "$sql"; //exit;
$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql");
while($row=mysqli_fetch_assoc($result)){
	$osmb_justify[]=$row;
	}
//echo "<pre>"; print_r($osmb_justify); echo "</pre>"; // exit;

$edit=array("center","center_code","district","osbm_log_num","comments","ncas_account","avg_rate", "avg_rate_new", "div_app","osbm_title","budget_hrs");
$skip=array("datebegin","osbm_log_num");
echo "<form method='POST'><table border='1' cellpadding='3'>";

	foreach($osmb_justify[0] as $k=>$v){
	
		if(in_array($k,$skip)){continue;}
		
	//	if($k=="avg_rate"){$avg_rate=$v;}
		if($k=="datebegin"){$datebegin=$v;}
		$val=$v;
			if(in_array($k,$edit)){$v="<input type='text' name='$k' value='$v'>";}
			
			if($k=="osbm_title"){
				$v="<select name='$k'>";
				foreach($title_array as $k1=>$v1){
					if(strtoupper($val)==$v1){$s="selected";}else{$s="value";}
					$v.="<option $s='$v1'>$v1</option>";
					}
				
				$v.="</select>";
				}
						
			if($k=="comments")
				{
				$v="<textarea name='$k' cols='55' rows='8'>$val</textarea>";
				}
			
			if($k=="park_comments")
				{
				$v="<textarea name='$k' cols='55' rows='8'>$val</textarea>";
				}
			
			echo "<tr><th>$k</th><td>$v</td></tr>";
			}
		echo "<tr>
		<td colspan='2' align='center'>
		<input type='hidden' name='fiscal_year' value='$fiscal_year'>
		<input type='hidden' name='beacon_posnum' value='$beacon_posnum'>
		<input type='submit' name='submit' value='Update'></td>
		</tr>";
		
		echo "<tr><td colspan='2' align='center'>If you change the center, center_code, or district, MAKE sure all three are in agreement after the change.</td></tr></table></form>";

?>