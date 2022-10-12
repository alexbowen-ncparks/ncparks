<?php
ini_set('display_errors',1);
IF(!empty($superintendent))
	{
	$pass_beacon_num=$superintendent;
	$sql = "SELECT t1.superintendent, t4.Fname, t4.Lname, t1.park_code
	From supervisor_chart as t1
	left join position as t2 on t2.beacon_num=t1.superintendent
	left join emplist as t3 on t2.beacon_num=t3.beacon_num
	left join empinfo as t4 on t3.emid=t4.emid
	where 1 and t1.superintendent='$superintendent'";  //echo "$sql<br />";
	$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql ".mysqli_error($connection));
	while($row=mysqli_fetch_assoc($result))
		{
		extract($row);
	echo "<form method='POST' action=supervisor_levels.php>
	<input type='hidden' name='park_code' value=\"$park_code\">
	<input type='submit' name='submit' value=\"Return to Summary Page\"></form>";
		echo "Select the \"Level\" of each person who are directly <font color='red'>Supervised by $Fname $Lname</font> at $park_code.";
		
		}
	}
IF(!empty($primary_sup))
	{
	$pass_beacon_num=$primary_sup; // this gets the name
	$sql = "SELECT t1.primary_sup, t4.Fname, t4.Lname, t1.park_code
	From supervisor_chart as t1
	left join position as t2 on t2.beacon_num=t1.primary_sup
	left join emplist as t3 on t2.beacon_num=t3.beacon_num
	left join empinfo as t4 on t3.emid=t4.emid
	where 1 and t1.primary_sup='$primary_sup'";
	$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql ".mysqli_error($connection));
	while($row=mysqli_fetch_assoc($result))
		{
		extract($row);
	echo "<form method='POST' action=supervisor_levels.php>
	<input type='hidden' name='park_code' value=\"$park_code\">
	<input type='submit' name='submit' value=\"Return to Summary Page\"></form>";
		echo "Select the \"Level\" of each person who are directly <font color='red'>Supervised by $Fname $Lname</font> $primary_sup at $park_code.";
		}
	}
IF(!empty($secondary_sup))
	{
	$pass_beacon_num=$secondary_sup; // this gets the name
	$sql = "SELECT t1.secondary_sup, t4.Fname, t4.Lname, t1.park_code
	From supervisor_chart as t1
	left join position as t2 on t2.beacon_num=t1.secondary_sup
	left join emplist as t3 on t2.beacon_num=t3.beacon_num
	left join empinfo as t4 on t3.emid=t4.emid
	where 1 and t1.secondary_sup='$secondary_sup'";
	$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql ".mysqli_error($connection));
	while($row=mysqli_fetch_assoc($result))
		{
		extract($row);
	echo "<form method='POST' action=supervisor_levels.php>
	<input type='hidden' name='park_code' value=\"$park_code\">
	<input type='submit' name='submit' value=\"Return to Summary Page\"></form>";
		echo "Select the \"Level\" of each person who are directly <font color='red'>Supervised by $Fname $Lname</font> $secondary_sup at $park_code.";
		}
	}
	
$var_null="";
if(!empty($superintendent))
	{$var_null="and t4.key_field='$superintendent'";}
if(!empty($primary_sup))
	{
	$var_null="and t4.key_field='$primary_sup'";
	}
if(!empty($secondary_sup))
	{$var_null="and t4.key_field='$secondary_sup'";}

$sql="SELECT t1.posTitle, t1.park, t1.beacon_num, t3.Fname, t3.Lname, t4.*
	From position as t1
	left join emplist as t2 on t2.beacon_num=t1.beacon_num
	left join empinfo as t3 on t2.emid=t3.emid
	left join supervised_list as t4 on t1.beacon_num=concat(t4.superintendent,t4.primary_sup,t4.secondary_sup,t4.non_sup)
	where 1 and t1.park='$park_code' $var_null
	order by t3.Lname, t3.Fname";

	$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql ".mysqli_error($connection));
	if(mysqli_num_rows($result)<1)
		{
		$sql="SELECT t1.posTitle, t1.park, t1.beacon_num, t3.Fname, t3.Lname, t4.*
	From position as t1
	left join emplist as t2 on t2.beacon_num=t1.beacon_num
	left join empinfo as t3 on t2.emid=t3.emid
	left join supervised_list as t4 on t1.beacon_num=concat(t4.superintendent,t4.primary_sup,t4.secondary_sup,t4.non_sup)
	where 1 and t1.park='$park_code' 
	order by t3.Lname, t3.Fname";
	$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql ".mysqli_error($connection));
		}
//		  echo "<br />$sql<br />";
	while($row=mysqli_fetch_assoc($result))
		{
		if($row['beacon_num']==$pass_beacon_num){continue;}
		if($row['posTitle']=="Park Superintendent"){continue;}
		$ARRAY[]=$row;
		}
		
if(!empty($action)){echo "<pre>"; print_r($ARRAY); echo "</pre>";  exit;}
//	

if(empty($ARRAY)){echo "<br /><br />You must first assign employees to their appropriate supervisory level."; exit;}

$level_array=array("superintendent","primary_sup","secondary_sup","non_sup");
$skip=array("key_field","park_code");

if(!empty($superintendent))
	{
	$skip_level_array=array("primary_sup","secondary_sup","non_sup");
	$level_array=array("superintendent");
	}
if(!empty($primary_sup))
	{
	$skip_level_array=array("superintendent","secondary_sup","non_sup");
	$level_array=array("primary_sup");
	}
if(!empty($secondary_sup))
	{
	$skip_level_array=array("superintendent","primary_sup","non_sup");
	$level_array=array("secondary_sup");
	}
echo "<form method='POST' action='supervised_levels.php'><table>";
foreach($ARRAY AS $index=>$array)
	{
	if($index==0)
		{
		echo "<tr>";
		foreach($ARRAY[0] AS $fld=>$value)
			{
			if(in_array($fld,$skip_level_array)){continue;}
			if(in_array($fld,$skip)){continue;}
			echo "<th>$fld</th>";
			}
		echo "<th>Supervised by</th>";
		echo "</tr>";
		}
	echo "<tr>";
	foreach($array as $fld=>$value)
		{
		if(in_array($fld,$skip_level_array)){continue;}
			if(in_array($fld,$skip)){continue;}
		echo "<td>$value</td>";
		}
	echo "<td>";
	foreach($level_array as $k=>$v)
		{
		$beacon_num=$array['beacon_num'];
		if($beacon_num==$array[$v] and $array['key_field']==$pass_beacon_num)
			{$ck="checked";}else{$ck="";}
		$fld_name=$v."[".$beacon_num."]";
		echo "<input type='radio' name='$fld_name' value=\"".$array['beacon_num']."\" $ck>".$v." \n";
		}
	echo "</td>";
	echo "</tr>";
	}
if(!empty($park_code))
	{
	if(!isset($supervisor)){$supervisor="";}
	echo "<tr><td colspan='6' align='center'>
	<input type='hidden' name='park_code' value=\"$park_code\">
	<input type='hidden' name='key_field' value=\"$pass_beacon_num\">
	<input type='submit' name='submit' value=\"Submit\">
	</td>
	<td>
	<input type='submit' name='submit' value=\"Reset\"></td>
	</tr>";
	}

echo "</table></form>";
exit;
?>