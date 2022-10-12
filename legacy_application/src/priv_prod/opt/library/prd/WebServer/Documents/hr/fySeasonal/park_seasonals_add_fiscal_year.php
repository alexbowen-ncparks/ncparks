<?php

session_start();
$level=$_SESSION['hr']['level'];
$fiscal_year=$_SESSION['hr']['fiscal_year'];
$new_request_date=$_SESSION['hr']['new_request_date'];

if($level<1){echo "You do not have access to this database. <a href='/hr/'>login</a>";exit;}

//echo "<pre>"; print_r($_SESSION); echo "</pre>";  exit;

$database="hr";
include("../../../include/iConnect.inc"); // database connection parameters
mysqli_select_db($connection,$database);

// ****** Add ********
if($_POST['beacon_posnum']!=""){

if($_POST['center_code']==""){echo "You must include a center_code. Click your browser's back button.";exit;}


mysqli_select_db($connection,"budget");

	$sql="SELECT center,dist as district FROM center WHERE parkCode='$_POST[center_code]' and fund='1280'"; //echo "$sql";exit;
	$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql ");
	$row=mysqli_fetch_assoc($result);
	extract($row);

mysqli_select_db($connection,$database);	
foreach($_POST as $k=>$v){
	if($k=="submit"){continue;}
		if($k=="center" || $k=="district"){$v=${$k};}
	$v=addslashes($v);
		$clause.=$k."='".$v."',";
		
		}
		$clause=rtrim($clause,",");
	$sql="INSERT INTO seasonal_payroll_fiscal_year set $clause";
//	echo "$sql";exit;
	$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql ");
	
		header("Location: /hr/fySeasonal/park_seasonals_find_fiscal_year.php?beacon_posnum=$beacon_posnum&submit=Find");
		exit;
}		
		
if($rep==""){include("menu_fiscal_year.php");}


// ******* Delete
if($id!=""){
	$sql="DELETE FROM seasonal_payroll_fiscal_year WHERE id=$id";
//	echo "$sql";exit;
	$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql ");
	
		header("Location: /hr/fySeasonal/park_seasonals_find_fiscal_year.php?file=Find Position");
		exit;
	}

// ********* Form *******
if($submit=="Find")
	{
	$sql = "SELECT *
	FROM seasonal_payroll_fiscal_year as t1
	where beacon_posnum='$beacon_posnum' and fiscal_year='$fiscal_year'"; //echo "$sql"; //exit;
	$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql");
	$position_array=mysqli_fetch_assoc($result); extract($position_array);
	}

$sql = "SELECT distinct osbm_title
FROM seasonal_payroll_fiscal_year as t1
where fiscal_year='$fiscal_year'
ORDER  BY osbm_title"; //echo "$sql"; //exit;
$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql");
while($row=mysqli_fetch_assoc($result)){$title_array[]=$row['osbm_title'];}


mysqli_select_db($connection,"budget");

$sql = "SELECT distinct UPPER(parkCode) as center_code
FROM center as t1
ORDER  BY center_code"; //echo "$sql"; //exit;
$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql");
while($row=mysqli_fetch_assoc($result)){$center_array[]=$row['center_code'];}
		$column_array=array("id"=>"","beacon_posnum"=>"","osbm_title"=>"","center_code"=>"","center"=>"","district"=>"","ncas_account"=>"","budget_hrs"=>"","budget_weeks"=>"","avg_rate"=>"","budget_dollars"=>"","start_date"=>"","park_approve"=>"","div_app"=>"","comments"=>"","park_comments"=>"");


if($column_array){

echo "<div align='center'><table border='1' cellpadding='3'>";

$null=array("id","budget_dollars");

echo "<form method='POST' action='park_seasonals_add_fiscal_year.php'><tr>";
foreach($column_array as $fld=>$val){
	$value=""; $size=8;
		if(in_array($fld,$null)){continue;}
		if(${$fld}!=""){$value=${$fld};}
		
		if($fld=="osbm_title"){
			echo "<tr><td>$fld</td><td><select name=\"osbm_title\"><option selected></option>";$s="value";
				foreach($title_array as $k=>$v){
					if($value==$v){$s="selected";}else{$s="value";}
					echo "<option $s='$v'>$v</option>";
 	     				 }
			continue;}
			
		if($fld=="center_code"){
			echo "<tr><td>$fld</td><td><select name=\"center_code\"><option selected></option>";$s="value";
				foreach($center_array as $k=>$v){
					if($value==$v){$s="selected";}else{$s="value";}
					echo "<option $s='$v'>$v</option>";
 	     				 }
			continue;}
			
		if($fld=="comments"){$size="64";}
		if($fld=="div_app"){$value="y";}
		if($fld=="avg_rate"||$fld=="budget_hrs"){$size="5";}
		if($fld=="ncas_account"){$value="531311";}
		if($fld=="center" || $fld=="district"){
			echo "<tr><td>$fld</td><td><input type='text' name='$fld' value='$value' size='$size'> Will auto-fill based on center_code</td></tr>";
			continue;}

		
		
		echo "<tr><td>$fld</td><td><input type='text' name='$fld' value='$value' size='$size'></td></tr>";
			}
		echo "<tr><td colspan='2' align='center'><input type='submit' name='submit' value='Add'</td>";
		echo "</tr></form></table></div></html>";
}		

?>