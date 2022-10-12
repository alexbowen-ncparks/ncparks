<?php
ini_set('display_errors',1);
session_start();
if($_SESSION['dpr_system']['level']<1)
	{echo "You must first login to the Division Personnel/Park Info <a href='https://10.35.152.9/divper/'>database</a>.<br /><br />Select the Land Acreage option under the \"Contact Info\" pull-down.";}
	{echo "You must first login to the Division Personnel/Park Info <a href='https://10.35.152.9/divper/'>database</a>.<br /><br />Select the Land Acreage option under the \"Contact Info\" pull-down.";}

include("../../include/get_parkcodes_dist.php");
// echo "<pre>"; print_r($parkCode); echo "</pre>"; // exit;
include("../../include/iConnect.inc"); // database connection parameters

include("menu_dpr_system.php");
mysqli_select_db($connection,"dpr_system");

// echo "<pre>"; print_r($_REQUEST); echo "</pre>"; // exit;
if($_POST)
{
// echo "<pre>"; print_r($_POST); echo "</pre>";  //exit;
$string="";
	foreach($_POST as $k=>$v){
		if($k!="submit")
			{$string.="$k='$v', ";}
// 			{@$string.="$k='".mysqli_real_escape_string($connection,$v)."', ";}
		}
			$string=trim($string,", ");
		if($_POST['submit']=="Add"){
				$query="INSERT dpr_acres SET $string"; //echo "$query";exit;
				$result = mysqli_query($connection,$query) or die ("Couldn't execute query. $query");}
			else{
			$query="REPLACE dpr_acres SET $string"; //echo "$query";exit;
			$result = mysqli_query($connection,$query) or die ("Couldn't execute query. $query");}
			
	}


// ********** Get Field Types *********

$sql="SHOW COLUMNS FROM  dpr_acres";
 $result = @mysqli_QUERY($connection,$sql);
while($row=mysqli_fetch_assoc($result)){
$allFields[]=$row['Field'];
}

// ******** Enter your SELECT statement here **********

if(@$class)
	{$where="and class='$class'";}
	else
	{$where="";}
if(!empty($parkcode)){$where="and parkcode='$parkcode'";}

$order_by="order by `class`,parkcode";
if(!empty($edit))
	{$where="and id='$edit'";}
$sql = "SELECT  * 
From dpr_acres
where 1 $where
$order_by";
// echo "$sql";
$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql");
while($row=mysqli_fetch_assoc($result))
	{$ARRAY[]=$row;}

$fieldNames=array_values(array_keys($ARRAY[0]));
$num=count($ARRAY);

echo "<html><table border='1' cellpadding='2'>";

$sql = "SELECT  distinct class 
From dpr_acres
where 1
order by class";
$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql");
while($row=mysqli_fetch_assoc($result)){$classMenu[]=$row['class'];}

$sql = "SELECT distinct parkcode 
From dpr_acres
where 1
order by parkcode";
$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql");
while($row=mysqli_fetch_assoc($result)){$parkMenu[]=$row['parkcode'];}

// $parkMenu=$parkCodes;

echo "<tr>";

echo "<form><td align='center' colspan='3'><select name=\"class\" onchange=\"this.form.submit()\"><option selected>Select Class...</option>";
foreach($classMenu as $k=>$v){
	if($class==$v){$s="selected";}else{$s="";}
	$s="";
		echo "<option value='$v' $s>$v</option>";
       }
   echo "</select></td></form>";

echo "<form><td align='center' colspan='2'><select name=\"parkcode\" onchange=\"this.form.submit()\"><option selected>Select Park...</option>";
foreach($parkMenu as $k=>$v){
	if($class==$v){$s="selected";}else{$s="";}
		echo "<option value='$v' $s>$v</option>";
       }
   echo "</select></td></form>";
   
echo "<td colspan='2' align='center'><font color='red'>$num records</font></td>";

echo "<td align='center'><a href='land_acres_report.php'><font color='green'>Summary Report</font></a></td><td align='center'><a href='http://149.168.1.197/system_plan/'><font color='brown'>SYS_PLAN </font></a></td></tr>";

echo "<tr>";
foreach($fieldNames as $k=>$v)
	{
	$v=str_replace("_"," ",$v);
	$header_array[]=$v;
	echo "<th>$v</th>";
	}
echo "</tr>";

echo "<form method='POST'><tr>";
	$noAdd=array("id");
foreach($fieldNames as $k=>$v){
	if(in_array("$v",$noAdd)){echo "<td>&nbsp;</td>";}else{
		echo "<td><input type='text' name='$v' value='' size='14'></td>";}
		}
echo "<td><input type='submit' name='submit' value='Add'></td></tr></form>";

$editFlds=$fieldNames;
$excludeFields=array("id","emid");
$j=0;
// echo "<pre>"; print_r($ARRAY); echo "</pre>";  exit;
echo "<form method='POST'>";

foreach($ARRAY as $index=>$array){// each row

// $fx = font color  and  $tr = row shading
$f1="";$f2=""; 
$j++;
if(fmod($j,2)!=0){$tr="tr bgcolor='aliceblue'";}else{$tr="tr";}

if($j!=1 and fmod($index,30)==0)
	{
	echo "<tr>";
	foreach($header_array as $k=>$v)
		{
		echo "<th>$v</th>";
		}
	echo "</tr>";
	}
$update="";
$grand_total=0;
echo "<$tr>";
foreach($array as $fld=>$value)
	{
	
	$var=$value;
	 		
	IF($fld=="acres_fee"){@$total[$fld]+=$value;}
	IF($fld=="easement"){@$total[$fld]+=$value;}
	
	IF($fld=="acres_land"){@$total[$fld]+=$value=$array['acres_fee']+$array['easement'];}
	
	IF($fld=="acres_water"){@$total[$fld]+=$value;}
	IF($fld=="length_miles"){@$total[$fld]+=$value;}
	
	if($fld=="id")
		{
		$passID=$value;
		$var="<a href='land_acres.php?edit=$value&submit=Submit'>$value</a>";
		}
	
	if($fld=="acres_land")
		{
		$var=number_format($value,0);
		}	
	if(@$edit==$array['id'])
		{
		if(!in_array($fld,$excludeFields))
			{
			$var="<input type='text' name='$fld' value='$value' size='10'>";
			$update="<td>
			<input type='submit' name='submit' value='Update'>
			</td>";
			}
			else
			{$var="<input type='text' name='$fld' value='$value' size='10' READONLY>";}
		}
		
		echo "<td align='right'>$var</td>";
	}
	
echo "$update</tr>";
$update="";
}
echo "</form>";
// echo "<pre>"; print_r($fieldNames); echo "</pre>"; // exit;
echo "<tr>";
foreach($fieldNames as $index=>$fld)
	{
	$f="";
	if($index==2){$f=$num." units";}

	 if(!empty($total[$fld]))
	 	{
	 	$f=number_format($total[$fld],3);
	 	if($fld=="acres_land")
	 		{$f=number_format($total[$fld],0);}
	 	if($fld !="length_miles"){$grand_total+=$total[$fld];}
	 			 		 	
	 	}
	echo "<th>$f</th>";
	}
// 	@$g=number_format($grand_total,3);
// echo "<th>$g</th></tr>";

echo "</tr></table></body></html>";
?>