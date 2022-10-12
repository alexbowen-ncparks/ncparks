<?php
include("menu.php");

extract($_REQUEST);
if(empty($park_code)){exit;}

// echo "<pre>"; print_r($_REQUEST); echo "</pre>"; //exit;


$database="fire";
include("../../include/iConnect.inc");
include("../../include/get_parkcodes_dist.php");

mysqli_select_db($connection,'fire');	

if(!empty($submit_form))
	{
	if($submit_form=="Delete")
		{
		$sql="DELETE FROM contract_park WHERE id='$id'";
		$result = mysqli_query($connection,$sql) or die ("Couldn't execute select query. $sql ".mysqli_error($connection));
		unset($id);
		}
	}

//if($row['Field']=="park_code"){continue;}
// needed to preven $park_code being blank for records with no documents

include("get_form_flds.php");

$sql="SELECT $t1_flds, group_concat(t2.file_name) as file_name, group_concat(t2.file_link) as file_link
from contract_park as t1
LEFT JOIN contract_uploads as t2 on t1.id=t2.contract_id
where t1.park_code='$park_code'
group by t1.id
order by start_date desc
";
$result = mysqli_query($connection,$sql) or die ("Couldn't execute select query. $sql ".mysqli_error($connection));
while($row=mysqli_fetch_assoc($result))
	{
	$ARRAY[]=$row;
	}
// echo "$sql<pre>"; print_r($ARRAY); echo "</pre>";  //exit;

if(empty($ARRAY) and empty($id))
	{
	echo "There is presently no Project entered for $park_code. Would you like to create one?"; 
	echo "<br /><br /><a href='/fire/contracts_form.php?park_code=$park_code'>Yes</a> &nbsp;&nbsp;&nbsp;&nbsp;<a href='/fire/menu.php'>No</a>";
	echo "<br /><br /><a href='/fire/contracts_form.php?park_code=$park_code'>Yes</a> &nbsp;&nbsp;&nbsp;&nbsp;<a href='/fire/menu.php'>No</a>";
	exit;
	}

$hide_fld=array("burnable_comment","annual_burn_goal_comment");
$skip=array("id","doc_id","contract_id","file_link");

$check_id=$ARRAY[0]['id'];
$c=count($ARRAY);
if(!empty($check_id) and empty($id))
	{
	echo "<hr />
	<div align='center'>";
	$verb=($c>1?"are":"is");
	echo "<table border='1'><tr><td colspan='8' style='background-color:#c6ecd9'><b>There $verb $c Tracked Projects for $park_code.</b> Select the one you would like to update/view.</td><td colspan='2' style='background-color: #f2e6ff; text-align: center'><a href='contracts_form.php?park_code=$park_code'>Add</a> a new Project Record</td></tr>";
	foreach($ARRAY AS $index=>$array)
		{
		if($index==0)
			{
			echo "<tr>";
			foreach($ARRAY[0] AS $fld=>$value)
				{
				if($level<4 and in_array($fld, $hide_fld)){continue;}
				if(in_array($fld, $skip)){continue;}
				echo "<th>$fld</th>";
				}
			echo "</tr>";
			}
		echo "<tr>";
		foreach($array as $fld=>$value)
			{
			if($level<4 and in_array($fld, $hide_fld)){continue;}
			if(in_array($fld, $skip)){continue;}
			if($fld=="contractee")
				{
				echo "<td align='center'><font color='#000099'>$value</font></td>";
				continue;
				}
			if($fld=="title")
				{
				$var_id=$array['id'];
				echo "<td align='center'><font color='#cc4400'>$value</font><form method='POST' action='contracts_form.php'>
				<input type='hidden' name='park_code' value=\"$park_code\">
				<input type='hidden' name='id' value=\"$var_id\">
				<input type='submit' name='submit_form' value=\"Update\">
				</form></td>";
				continue;
				}
			
			if($fld=="file_name" and !empty($value))
				{
				$group_file_link=explode(",", $array['file_link']);
				$group_file_name=explode(",", $array['file_name']);
				$value="";
				foreach($group_file_link as $k=>$v)
					{
					$name=$group_file_name[$k];
					$value.="<a href='$v' target='_blank'>$name</a><br /><br />";
					}
				}
			echo "<td>$value</td>";
			}
		echo "</tr>";
		}
	echo "</table>";

	echo "</div>";
	exit;
	}


?>