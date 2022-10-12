<?php
//echo "test<pre>"; print_r($_POST); echo "</pre>"; // exit;

$clause="";
$skip_find=array("submit","proj_type","how_done");
$not_like=array("proj_type");  //"gis_id",
foreach($_POST as $fld=>$value)
	{
	if(in_array($fld,$skip_find)){continue;}
	if(empty($value)){continue;}
	$value=mysqli_real_escape_string($connection,$value);
	@$pass_park_code=$_POST['park_code'];
	if(in_array($fld,$not_like))
		{$clause.=$fld."='$value' and ";}
		else
		{
		if($fld=="park_code" and !empty($value))
			{$clause.=" (`park_code` like '%$value%' OR `park_code`='ALL') and ";}
			else
			{
			if($fld=="id")
				{$clause.=$fld." = '$value' and ";}
				else
				{$clause.=$fld." like '%$value%' and ";}
			}
		
		}	
	}
$clause=rtrim($clause," and ");
if(!empty($_POST['proj_type'][0]))
	{
	$clause.=" and (";
	foreach($_POST['proj_type'] as $k=>$v)
		{
		$clause.=" proj_type like '%$v%' or ";
		}
	$clause=rtrim($clause," or ").")";
	}

if(!empty($_POST['how_done'][0]))
	{
	foreach($_POST['how_done'] as $tk=>$tv)
		{
		if(!empty($tv)){$temp=1;}
		}
	}
if(!empty($temp))
	{
	$clause.="(";
	foreach($_POST['how_done'] as $k=>$v)
		{
		if(!empty($v))
			{
			$v=$how_done_array[$k];
			$clause.=" how_done like '%$v%' or ";
			}
		}
	$clause=rtrim($clause," or ").")";
	}
	
if(empty($clause))
	{
	echo "No search criterion was entered."; exit;
	}
	
if($level<2)
	{
	$pc=$_SESSION['dpr_proj']['select'];
	$multi_park=str_replace(" ","",$_SESSION['dpr_proj']['accessPark']);
	if(empty($pass_park_code) and !empty($multi_park))
		{
		$exp=explode(",",$multi_park);
		$temp=" and (";
		foreach($exp as $k=>$v)
			{
			$temp.="park_code like '%$v%' OR ";
			}
		$clause.=rtrim($temp," OR ").")";
		}
	if(empty($pass_park_code) and empty($multi_park))
		{
		$clause.=" and park_code='$pc'";
		}
	}	
$sql="SELECT * from project where 1 and $clause";  //echo "$sql";
$result = mysqli_query($connection, $sql) or die ("Couldn't execute select query. $sql ".mysqli_error($connection));

if(mysqli_num_rows($result)<1)
	{
	echo "Nothing found using: $clause"; exit;
	}
	
if(mysqli_num_rows($result)==1)
	{
	$row=mysqli_fetch_assoc($result);
	extract($row);
	}
	
if(mysqli_num_rows($result)>1)
	{
	while($row=mysqli_fetch_assoc($result))
		{
		$ARRAY[]=$row;
		}
		
		$c=count($ARRAY);
		$span=count($ARRAY[0]);
		$limit_array=array("edits","description","justification");
		echo "<table border='1'><tr><td colspan='$span'>$c projects</td></tr>";
		foreach($ARRAY AS $index=>$array)
			{
			if($index==0)
				{
				echo "<tr>";
				foreach($ARRAY[0] AS $fld=>$value)
					{
					echo "<th>$fld</th>";
					}
				echo "</tr>";
				}
			echo "<tr valign='top'>";
			foreach($array as $fld=>$value)
				{
				if($fld=="id")
					{
					$value="<form method='POST' action='project.php' onclick=\"this.form.submit()\">
					<input type='hidden' name='id' value='$value'>
					<input type='submit' name='submit' value='Find'>
					</form>";
					}
					
				if(in_array($fld,$limit_array))
					{
					if(strlen($value)>100)
						{$value=substr($value,0,100)."...";}		
					}
				echo "<td>$value</td>";
				}
			echo "</tr>";
			}
		echo "</table>";
			echo "</body></html>";
			exit;
	}
?>