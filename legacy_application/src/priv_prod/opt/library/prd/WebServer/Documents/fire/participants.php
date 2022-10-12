<?php
include("menu.php");
//echo "<pre>"; print_r($_REQUEST); echo "</pre>"; //EXIT;

include("../../include/iConnect.inc");
include("../../include/get_parkcodes_reg.php");
mysqli_select_db($connection,'fire');

if(!empty($_POST['member']))
	{
	mysqli_select_db($connection,'fire');
	extract($_POST);
	$pass_crew_number=$crew;
		$sql="DELETE FROM participants where park_code='$park_code' and history_id='$history_id'";
		$result=mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql ".mysqli_error($connection));
		
	if(!empty($burn_boss_nondpr))
		{$burn_boss=$burn_boss_nondpr;}
	foreach($_POST['member'] as $k=>$v)
		{
		if(empty($v)){continue;}
		$exp=explode("*",$v);
		
		$burn_boss=addslashes($burn_boss);
		$dpr_name="";
		$non_dpr_name="";
		$dpr_emid="";
		if(count($exp)>1)
			{
			$dpr_emid=array_pop($exp);
			$dpr_name=addslashes($exp[0]);
			}
			else
			{
			$non_dpr_name=addslashes($v);
			}
		@$bb_trainee=$burn_boss_trainee[$k];
		$sql="INSERT into participants set park_code='$park_code', unit_id='$unit_id', history_id='$history_id', burn_boss='$burn_boss', dpr_emid='$dpr_emid', dpr_name='$dpr_name', non_dpr_name='$non_dpr_name', burn_boss_trainee='$bb_trainee'";
		$result=mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql ".mysqli_error($connection));
	//	echo "$sql<br />";
		}
	}
mysqli_select_db($connection,'divper');
$sql="SELECT concat(t1.Lname,', ',t1.Fname,' ',t1.Mname,'-',t2.currPark,'*',t1.emid) as name
from empinfo as t1
LEFT JOIN emplist as t2 on t1.emid=t2.emid
where t2.currPark !=''
order by t1.Lname, t1.Fname";
$result=mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql ".mysqli_error($connection));
$source_name="";
while($row=mysqli_fetch_assoc($result))
	{
	$source_name.="\"".$row['name']."\",";
	}
$source_name=rtrim($source_name,",");

mysqli_select_db($connection,'fire');
$sql="SELECT t1.date_, t1.acres_burned, t2.unit_name, t3.burn_boss, t3.burn_boss_trainee, t3.dpr_emid, t3.dpr_name, t3.non_dpr_name
from burn_history as t1
LEFT JOIN units as t2 on t1.unit_id=t2.unit_id
LEFT JOIN participants as t3 on t1.history_id=t3.history_id
where t1.history_id='$history_id'
order by t3.burn_boss_trainee desc, t3.non_dpr_name, t3.dpr_name
";
$result=mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql ".mysqli_error($connection));
while($row=mysqli_fetch_assoc($result))
	{
	$ARRAY[]=$row;
	}
//echo "<pre>"; print_r($ARRAY); echo "</pre>"; // exit;
extract($ARRAY[0]);

echo "<form action='participants.php' method='POST'><table border='1'><tr><th colspan='5'><font color='gray'>Burn Participants</font></th>";

if(!empty($ARRAY))
	{
	ECHO "<th><a href='burn_history.php?park_code=$park_code&unit_id=$unit_id&history_id=$history_id'>Return to Burn History</a></th>";
	}
echo "</tr>";
extract($_REQUEST);

if(!isset($burn_boss))
	{$burn_boss="";}

if(!empty($burn_boss))
	{
	$exp=explode("*",$burn_boss);
	if(count($exp)<2)
			{
			$burn_boss_nondpr=$burn_boss;
			$burn_boss="";
			}
	}
if(!isset($burn_boss_nondpr))
	{$burn_boss_nondpr="";}
	else
	{
	if(!empty($burn_boss_nondpr))
		{$burn_boss="";}
	
	}
if(!isset($crew) and empty($ARRAY))
	{}
	ELSE
	{
	if(count($ARRAY)>1)
		{
		$crew=count($ARRAY);
		}
	if(!isset($crew)){$crew="";}
	if(!empty($pass_crew_number)){$crew=$pass_crew_number;}
	}

echo "<tr><td><h3><font color='brown'>Burn Boss for $park_code, unit: $unit_name, acres burned: $acres_burned, date: $date_</font></h3><br />DPR employee: <input type='text' id=\"name\" name='burn_boss' value=\"$burn_boss\" size='44'></td>";
echo "<td> </td>";
echo "<td><font color='brown'>If Burn Boss was NOT a DPR employee, enter their Last name, First name - Agency:</font><br />
<input type='text' name='burn_boss_nondpr' value=\"$burn_boss_nondpr\" size='44'><br />e.g., Smith, John - Nature Conservancy</td>";
echo "</tr>";

echo "<tr><td>Number of crew members: 
<input type='text' name='crew' value=\"$crew\"' size='3'></td><td></td><td><font color='brown'>If a crew member was NOT a DPR employee, enter their Last name, First name - Agency/Volunteer</font></td></tr>";

echo "	<script>
		$(function()
			{
			$( \"#name\" ).autocomplete({
			source: [ $source_name]
				});
			});
		</script>
";

if(isset($crew))
	{
	for($i=1; $i<=$crew; $i++)
		{
		$j=$i-1;
		$fld_id="crew_name".$i;
	
		if($ARRAY[$i-1]['burn_boss_trainee']=="x"){$ck="checked";}else{$ck="";}
		$bb2="<input type='checkbox' name='burn_boss_trainee[$j]' value='x' $ck>";
		
		if(!empty($ARRAY[$i-1]['dpr_emid']))
			{
			$value=$ARRAY[$i-1]['dpr_name']."*".$ARRAY[$i-1]['dpr_emid'];
			}
			else
			{
			@$value=$ARRAY[$i-1]['non_dpr_name'];
			}
			
		echo "<tr><td colspan='3'>Member $i: <input type='text' id=\"$fld_id\" name='member[]' value=\"$value\" size='34'> - Burn Boss Trainee $bb2";
		
echo "	<script>
		$(function()
			{
			$( \"#$fld_id\" ).autocomplete({
			source: [ $source_name]
				});
			});
		</script>
";
echo "</td></tr>";
		}
	}

echo "<tr><td colspan='3' align='center'>
<input type='hidden' name='park_code' value=\"$park_code\"'>
<input type='hidden' name='unit_id' value=\"$unit_id\"'>
<input type='hidden' name='history_id' value=\"$history_id\"'>
<input type='submit' name='submit' value=\"Submit\"'>
</td></tr>";
echo "</table></form>";
echo "</div></html>";
?>