<?php
$database="divper";
include("../../include/auth.inc"); // used to authenticate users
include("../../include/iConnect.inc"); // database connection parameters

//echo "<pre>";print_r($_SESSION);echo "</pre>";
//print_r($_REQUEST);//exit;
$logemid=$_SESSION['logemid'];
$positionTitle=$_SESSION['position'];
$divperLevel=$_SESSION['divper']['level'];

include("menu.php");


mysqli_select_db($connection,"budget"); // database
$sql = "SELECT parkCode as program_code  FROM `center`
WHERE actcenteryn='y' and fund='1280'
order by program_code"; 
$result = mysqli_query($connection,$sql) or die ("Couldn't execute query2. $sql");
while ($row=mysqli_fetch_array($result))
	{
	$program_array[]=strtoupper($row['program_code']);
	}
if(!in_array("DERI",$program_array)){$program_array[]="DERI";}
if(!in_array("REMO",$program_array)){$program_array[]="REMO";}
// REMO hard-coded since budget.center row for REMO did not have 1280 in the fund field - teh_20220801
if(!in_array("BOCR",$program_array)){$program_array[]="BOCR";}
// REMO hard-coded since budget.center row for REMO has 1680 in the fund field - teh_20220801
if(!in_array("NCMA",$program_array)){$program_array[]="NCMA";}
sort($program_array);
// echo "<pre>"; print_r($program_array); echo "</pre>"; // exit;

mysqli_select_db($connection,$database); // database
$sql = "SELECT distinct code from dpr_sections_dist order by ORDER_BY"; 
$result = mysqli_query($connection,$sql) or die ("Couldn't execute query2. $sql");
while ($row=mysqli_fetch_array($result))
	{
	$arrayCode[]=$row['code'];
	}
extract($_REQUEST);

	if(@$_REQUEST['loc']!="")
		{
			$test=$_REQUEST['loc'];
			$where="and t1.code='$test'";
			$orderBy=", t1.order_by";
		}

	if(@$_REQUEST['beacon_num']!="")
		{
			$bn=$_REQUEST['beacon_num'];
			$where="and t1.beacon_num='$bn'";
			$orderBy=", t1.order_by";
		}
		
if(@$bn)
	{
	$test="blank";
	$sql = "SELECT t2.beacon_num, t2.o_chart, t2.posTitle as official_title,  t2.working_title, t1.order_by, t2.code, t2.program_code, t1.name, t2.toggle
	From position as t2
	LEFT JOIN dpr_sections_dist as t1 on t1.code=t2.code
	where t2.beacon_num='$bn'
	"; 
	$result = mysqli_query($connection,$sql) or die ("Couldn't execute query2. $sql");
	}

else
	{
	if(!isset($where)){$where="";}
	if(!isset($orderBy)){$orderBy="";}
	$sql = "SELECT t2.beacon_num, t2.o_chart, t2.posTitle as official_title,  t2.working_title, t1.order_by, t2.code, t2.program_code, t1.name, t2.toggle
	From position as t2
	LEFT JOIN dpr_sections_dist as t1 on t1.code=t2.code
	where t2.beacon_num !='' $where
	order by t2.o_chart $orderBy"; 
	$result = mysqli_query($connection,$sql) or die ("Couldn't execute query2. $sql");
	$num=mysqli_num_rows($result);
	}
// echo "$sql";

$header="<tr><th>Beacon Number</th><th>Official Title</th><th>Working Title</th><th>Position Order</th><th>O-Chart Code</th><th>O-Chart Name</th><th>Program Code</th><th>Section Head</th></tr>";

echo "<table border='1' cellpadding='3'>";

if(!isset($num)){$num="";}
echo "<form><tr><td>$num</td><td>
 <select name='loc' onChange=\"MM_jumpMenu('parent',this,0)\">
          <option selected=''></option>";
          foreach($arrayCode as $k=>$v)
			  {
			  if($v==@$test){$s="selected";}else{$s="value";}
			  echo "<option $s='contactInfo1_edit.php?loc=$v'>$v</option>";
			  }
        echo "</select></td><td colspan='3'>beacon_num <input type='text' name='beacon_num' value=''><input type='submit' name='submit' value='Find'></td></tr></form>";

echo " $header";

if(@$test){echo "<form action='contactInfo1_edit_update.php' method='POST'>";}

else{echo "<font color='brown'>Please select a \"Section\" from the pull-down menu.</font>";exit;}


while ($row=mysqli_fetch_array($result))
	{
	extract($row);
	
	
	echo "<td><a href='contactInfo1_edit.php?bn=$beacon_num'>$beacon_num</a></td>";
	
	
	echo "<td>$official_title</td>";
	if($test)
		{
		if($working_title){$val=$working_title;}else{$val=$official_title;}
		
		echo "<td><input type='text' name='working_title[$beacon_num]' value='$val' size='30'></td>
		<td><input type='text' name='o_chart[$beacon_num]' value='$o_chart' size='8'></td>";
		
		echo "<td><select name=\"code[$beacon_num]\">";
		echo "<option></option>";
		foreach($arrayCode as $k=>$v)
			{
			if($code==$v){$s="selected";}else{$s="value";}
					echo "<option $s='$v'>$v\n";
			}
		   echo "</select></td>";

	echo "<td>$name</td>";
		
		echo "<td><select name=\"program_code[$beacon_num]\">";
		echo "<option></option>";
		foreach($program_array as $k=>$v)
			{
			if($program_code==$v){$s="selected";}else{$s="value";}
					echo "<option $s='$v'>$v\n";
			}
		   echo "</select></td>";

		   if($toggle=="x"){$ck="checked";}else{$ck="";}
		   echo "<td align='center'><input type='checkbox' name='toggle[$beacon_num]' value='x'$ck></td>";
		}
	
	else{
	if($working_title){$val=$working_title;}else{$val=$official_title;}
	echo "<td>$val</td>
	<td>$o_chart</td>";
	
	echo "<td>$name</td><td>$code</td><td align='center'>$toggle</td><td align='center'>$varCol</td><td align='center'>$varRow</td>";
	}
	
	echo "</tr>";
	}// end while
echo "<tr><td colspan='5' align='center'>
<input type='hidden' name='section' value='$test'>
<input type='submit' name='submit' value='Update'>
</td></tr></form>";
echo "</body></html>";
?>