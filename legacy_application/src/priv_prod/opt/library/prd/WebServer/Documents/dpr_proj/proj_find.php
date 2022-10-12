<?php
//echo "test<pre>"; print_r($_POST); echo "</pre>"; // exit;

$database="dpr_system";
mysqli_select_db($connection, $database);
$sql="SELECT  park_code, region, admin_by  
FROM `parkcode_names_region` 
where admin_by !=''
order by admin_by"; 
// echo "$sql";
$result = @mysqli_query($connection, $sql) or die("$sql Error ". mysqli_error($connection));
while($row=mysqli_fetch_assoc($result))
	{
	$ARRAY_parks[$row['admin_by']][$row['park_code']]=$row['region'];
	}
//  echo "<pre>"; print_r($ARRAY_parks); echo "</pre>"; // exit;

$clause="";
$skip_find=array("submit","proj_type","how_done");
$not_like=array("proj_type");  //"gis_id",
$equal_array=array("id","proj_status","proj_approval");
foreach($_POST as $fld=>$value)
	{
	if(in_array($fld,$skip_find)){continue;}
	if(empty($value)){continue;}
// 	$value=mysqli_real_escape_string($connection,$value);
	@$pass_park_code=$_POST['park_code'];
	if(in_array($fld,$not_like))
		{$clause.=$fld."='$value' and ";}
		else
		{
		if($fld=="park_code" and !empty($value))
			{$clause.=" (`park_code` like '%$value%' OR `park_code`='ALL') and ";}
			else
			{
// 			if($fld=="id")
			if(in_array($fld, $equal_array))
				{
				if($fld=="proj_status" and $value=="Incomplete")
					{
					$clause.="($fld='Incomplete' or $fld='') and ";
					continue;
					}
				if($fld=="proj_status" and $value=="Any Status")
					{
					if($level<3)
						{
						$clause.="$fld!='Void' and ";
						continue;
						}
						else
						{
// 						$clause.="$fld!='' and ";
						$clause.="";
						continue;
						}
					}
				$clause.=$fld." = '$value' and ";
				}
				else
				{
				$clause.=$fld." like '%$value%' and ";
				}
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
// 	echo "p=$pass_park_code c1=$clause";
	$pc=$_SESSION['dpr_proj']['select'];
// 	$multi_park=str_replace(" ","",$_SESSION['dpr_proj']['accessPark']);
	@$exp=$ARRAY_parks[$pc];
	$exp[$pc]="";
// 	echo "<pre>"; print_r($ARRAY_parks); echo "</pre>"; // exit;
//  	echo "$pc <pre>"; print_r($exp); echo "</pre>"; // exit;
	if(empty($pass_park_code) and !empty($exp))
		{
// 		$exp=explode(",",$multi_park);
		$temp=" and (";
		foreach($exp as $k=>$v)
			{
			$temp.="park_code like '%$k%' OR ";
			}
		$clause.=rtrim($temp," OR ").")";
		}
	if(empty($pass_park_code) and empty($exp))  // $multi_park
		{
		$clause.=" and park_code='$pc'";
		}
// 	echo "<br />c2=$clause";
	}

$database="dpr_proj";
mysqli_select_db($connection, $database);	
$sql="SELECT * from project where 1 and $clause";
// echo "$sql";
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
		$limit_array=array("edits","description","justification","proj_comments","ensu_comments","chom_comments","pasu_comments","disu_comments","chop_comments","plnr_comments","dedi_comments","dire_comments");
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