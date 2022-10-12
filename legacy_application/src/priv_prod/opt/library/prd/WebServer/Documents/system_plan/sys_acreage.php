<?php
ini_set('display_errors',1);
if(empty($_SESSION))
	{
	session_start();
	$level=$_SESSION['system_plan']['level'];
	}
	
if($_SESSION['system_plan']['level']<1)
	{echo "You must first login to the Division Personnel/Park Info <a href='https://10.35.152.9/divper/'>database</a>.<br /><br />Select the Land Acreage option under the \"Contact Info\" pull-down.";}
	{echo "You must first login to the Division Personnel/Park Info <a href='https://10.35.152.9/divper/'>database</a>.<br /><br />Select the Land Acreage option under the \"Contact Info\" pull-down.";}

$database="dpr_system";
include("../../include/iConnect.inc"); // database connection parameters

mysqli_select_db($connection,$database);
include("menu.php");

extract($_REQUEST);
if($_POST){//echo "<pre>"; print_r($_POST); echo "</pre>";  //exit;
$string="";
	foreach($_POST as $k=>$v)
		{
// 		if($k!="submit"){@$string.="$k='".mysqli_real_escape_string($v)."', ";}
		if($k!="submit"){$string.="$k='$v', ";}
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

$sql = "SELECT  * 
From dpr_acres
where 1 $where
order by `class`,parkcode";
$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql");
while($row=mysqli_fetch_assoc($result)){$ARRAY[]=$row;}

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


echo "<tr>";

echo "<form><td align='center' colspan='3'><select name=\"class\" onChange=\"MM_jumpMenu('parent',this,0)\"><option selected>Select Class...</option>";
foreach($classMenu as $k=>$v){
	if($class==$v){$s="selected";}else{$s="value";}
		echo "<option value='land_acres.php?class=$v'>$v</option>";
       }
   echo "</select></td></form>";

echo "<form><td align='center' colspan='2'><select name=\"class\" onChange=\"MM_jumpMenu('parent',this,0)\"><option selected>Select Park...</option>";
foreach($parkMenu as $k=>$v){
	if($class==$v){$s="selected";}else{$s="value";}
		echo "<option $s='land_acres.php?parkcode=$v'>$v</option>";
       }
   echo "</select></td></form>";
   
echo "<td colspan='2' align='center'><font color='red'>$num records</font></td>";

echo "<td align='center'><a href='land_acres_report.php'><font color='green'>Summary Report</font></a></td><td align='center'><a href='http://149.168.1.197/system_plan/'><font color='brown'>SYS_PLAN </font></a></td></tr>";

echo "<tr>";
foreach($fieldNames as $k=>$v){$v=str_replace("_"," ",$v);echo "<th>$v</th>";}
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

echo "<form method='POST'>";

foreach($ARRAY as $k=>$v){// each row

// $fx = font color  and  $tr = row shading
$f1="";$f2=""; @$j++;
if(fmod($j,2)!=0){$tr=" bgcolor='aliceblue'";}else{$tr="";}

$update="";

echo "<tr>";
	foreach($v as $k1=>$v1){// field name=$k1  value=$v1
	
	$var=$v1;
	IF($k1=="acres_land"){@$total[$k1]+=$v1;}
	IF($k1=="acres_water"){@$total[$k1]+=$v1;}
	IF($k1=="length_miles"){@$total[$k1]+=$v1;}
	IF($k1=="easement"){@$total[$k1]+=$v1;}
	
	if($k1=="id")
		{
		$passID=$v1;
		$var="<a href='land_acres.php?edit=$v1&submit=Submit'>$v1</a>";
		}
		
		if(@$edit==$v['id'])
			{
			if(!in_array($k1,$excludeFields))
				{
				$var="<input type='text' name='$k1' value='$v1' size='10'>";
				$update="<td>
				<input type='submit' name='submit' value='Update'>
				</td>";
				}
				else
				{$var="<input type='text' name='$k1' value='$v1' size='10' READONLY>";}
			}
		echo "<td align='right'>$var</td>";}
	
echo "$update</tr>";
$update="";
}
echo "</form>";

echo "<tr>";
foreach($fieldNames as $k=>$v)
	{
	$f="";
	if($k==2){$f=$num." units";}

	 if(!empty($total[$v]))
	 	{
	 	$f=number_format($total[$v],3);
	 	if($v!="length_miles"){@$grand_total+=$total[$v];}	 	
	 	}
	echo "<th>$f</th>";
	}
	@$g=number_format($grand_total,3);
echo "<th>$g</th></tr>";

echo "</table></body></html>";
?>