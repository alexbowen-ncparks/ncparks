<?php
ini_set('display_errors',1);
session_start();
if($_SESSION['dpr_system']['level']<1)
	{echo "You must first login to the Division Personnel/Park Info <a href='/divper/'>database</a>.<br /><br />Select the Land Acreage option under the \"Contact Info\" pull-down.";}
	{echo "You must first login to the Division Personnel/Park Info <a href='/divper/'>database</a>.<br /><br />Select the Land Acreage option under the \"Contact Info\" pull-down.";}

include("../../include/get_parkcodes_dist.php");
// echo "<pre>"; print_r($parkCode); echo "</pre>"; // exit;
// echo "<pre>"; print_r($parkCodeName); echo "</pre>"; // exit;

include("../../include/iConnect.inc"); // database connection parameters

include("menu_dpr_system.php");
mysqli_select_db($connection,"dpr_system");

// echo "<pre>"; print_r($_REQUEST); echo "</pre>"; // exit;
if($_POST)
	{
// 	echo "<pre>"; print_r($_POST); echo "</pre>";  exit;
	$skip=array("acres_land");
	$string="";
	foreach($_POST as $k=>$v)
		{
		if(in_array($k,$skip)){continue;}
		if($k!="submit")
			{$string.="$k='$v', ";}
		}
		$string=trim($string,", ");
		if($_POST['submit']=="Add")
			{
			$query="INSERT dpr_acres SET $string"; //echo "$query";exit;
			$result = mysqli_query($connection,$query) or die ("Couldn't execute query. $query");
			}
			else
			{
			$query="REPLACE dpr_acres SET $string"; //echo "$query";exit;
			$result = mysqli_query($connection,$query) or die ("Couldn't execute query. $query");
			}
		
	}


// ********** Get Field Types *********

// $sql="SHOW COLUMNS FROM  dpr_acres";
//  $result = @mysqli_QUERY($connection,$sql);
// while($row=mysqli_fetch_assoc($result)){
// $allFields[]=$row['Field'];
// }

// ******** Enter your SELECT statement here **********

if(@$class)
	{$where="and class='$class'";}
	else
	{$where="";}
if(!empty($parkcode)){$where="and parkcode='$parkcode'";}

$t1_flds="`id`, `highlight_unit`,`parkcode`, `class`, `class_type`, `acres_fee`, `easement`, `acres_fee`+`easement` as 'acres_land', `acres_water`, `length_miles`, `note_1`, `note_2`";
$order_by="order by t2.sort_order ,parkcode";
if(!empty($edit))
	{$where="and id='$edit'";}
$sql = "SELECT  $t1_flds 
From dpr_acres
LEFT JOIN dpr_acres_class_sort as t2 on t2.unit_class=dpr_acres.class
where 1 $where
$order_by";
// echo "$sql";
$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql");
while($row=mysqli_fetch_assoc($result))
	{
	$ARRAY[]=$row;
	if($row['class']=="STATE RIVER")
		{
		$ARRAY_SR[$row['parkcode']]=$row;
		}
	}
// echo "<pre>"; print_r($ARRAY_SR); echo "</pre>"; // exit;
$fieldNames=array_values(array_keys($ARRAY[0]));
$num=count($ARRAY);

echo "<html><table border='1' cellpadding='2'>";

$sql = "SELECT  distinct class 
From dpr_acres
LEFT JOIN dpr_acres_class_sort as t2 on t2.unit_class=dpr_acres.class
where 1
";
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

echo "<td align='center'><a href='land_acres_report.php'><font color='green'>Summary Report</font></a></td><td align='center'><a href='http://149.168.1.197/system_plan/'><font color='brown'>SYS_PLAN </font></a></td>";

echo "<td colspan='3'>Green parkcode indicates recent change.</td>";

echo "</tr>";

echo "<tr bgcolor='#c2c2a3'>";
foreach($fieldNames as $k=>$v)
	{
	if($v=="highlight_unit" and empty($edit)){continue;}
	$v=str_replace("_"," ",$v);
	$header_array[]=$v;
	echo "<th>$v</th>";
	}
echo "</tr>";

$noAdd=array("id","highlight_unit");

if(empty($edit))
	{
	echo "<form method='POST'><tr bgcolor='#ffe0cc'>";

	foreach($fieldNames as $k=>$v)
		{
		if($v=="highlight_unit" and empty($edit)){continue;}
		if(in_array("$v",$noAdd))
			{echo "<td>&nbsp;</td>";}
			else
			{echo "<td><input type='text' name='$v' value='' size='12'></td>";}
		}
	echo "<td><input type='submit' name='submit' value='Add'></td></tr></form>";
	}

$editFlds=$fieldNames;
$excludeFields=array("id","emid");
$skip=array("highlight_unit");
$j=0;
// echo "<pre>"; print_r($ARRAY); echo "</pre>";  //exit;
// echo "<pre>"; print_r($header_array); echo "</pre>"; // exit;
echo "<form method='POST'>";

foreach($ARRAY as $index=>$array)
	{
	$j++;
	if(fmod($j,2)!=0){$tr="tr bgcolor='aliceblue'";}else{$tr="tr";}

	if($j!=1 and fmod($index,30)==0)
		{
		echo "<tr bgcolor='#c2c2a3'>";
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
		if(in_array($fld, $skip) and empty($edit)){continue;}
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
				if($fld=="note_1" or $fld=="note_2")
					{
					$var="<textarea name='$fld' cols='22' rows='2'>$value</textarea>";
					}
				if($fld=="highlight_unit")
					{
					if($value=="x"){$ck="checked";}else{$ck="";}
					$var="<input type='checkbox' name='$fld' value='x' $ck>";
					}
				$update="<td>
				<input type='submit' name='submit' value='Update'>
				</td>";
				}
				else
				{
				$var="<input type='text' name='$fld' value='$value' size='10' READONLY>";
				}
			}
		
		if($fld=="parkcode" and empty($edit))
			{$var=$var." ".$parkCodeName[$var];}
		
		if($fld=="parkcode" and $array['highlight_unit']=="x")
			{$var="<font color='green'>$var</font>";}
			
		echo "<td align='right'>$var</td>";
		}

	echo "$update</tr>";
	$update="";
	}
echo "</form>";
// echo "<pre>"; print_r($fieldNames); echo "</pre>"; // exit;
// echo "222<pre>"; print_r($total); echo "</pre>"; // exit;
echo "<tr>";
foreach($fieldNames as $index=>$fld)
	{
	
	if($fld=="highlight_unit"){continue;}
	$f="";
	if($index==2)
		{
		$f=$num." units";
		if(!empty($ARRAY_SR))
			{
			$f=($num-2)." units";
			}
		}
	
	if($index==2 and @$class=="STATE RIVER")
		{
// 		$f=count($ARRAY_SR)-2." units";
		}

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