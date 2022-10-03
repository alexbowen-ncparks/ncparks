<?php
$database="photos";
include("../../include/auth.inc");// database connection parameters
include("../../include/iConnect.inc");// database connection parameters
mysqli_select_db($connection, $database)
   or die ("Couldn't select database $database");
	
ini_set('display_errors',1);

// echo "<pre>"; print_r($_SESSION); echo "</pre>"; // exit;

if(empty($rep))
	{
	$title="DCR Archive";
	include("_base_top.php");
	}
	else
	{session_start();}

$c="";
if(!empty($_POST) or !empty($_GET))
	{
	// echo "<pre>"; print_r($_POST); echo "</pre>";  //exit;
// 	echo "<pre>"; print_r($_SESSION); echo "</pre>";  //exit;
	$sql="SELECT * FROM dcr_archive_notes"; 
	$result = mysqli_query($connection,$sql) or die ("Couldn't execute query 1. $sql");
	while($row=mysqli_fetch_assoc($result))
		{
		$ARRAY_notes[]=$row;
		}
	//echo "<pre>"; print_r($ARRAY_notes); echo "</pre>"; // exit;
	
	$skip=array("submit");
	$equal=array("id");
	$clause="where 1 and (";
	foreach($_POST AS $k=>$v)
		{
		if(!empty($v) and !in_array($k,$skip))
			{
			if(in_array($k,$equal))
				{$clause.="t1.".$k." = '".$v."' AND ";}
				else
				{
				if($v=="North Carolina, United States")
					{
					$clause.="t1.".$k." = '".$v."' AND ";
					}
					else
					{
					$clause.="t1.".$k." LIKE '%".$v."%' AND ";
					}
				}
			
			}
		}
	$clause=rtrim($clause," AND ").")";
	
	if(!empty($_SESSION['photos']['clause']))
		{
		$clause=$_SESSION['photos']['clause']; //exit;
		}
	
	$order_by="order by t1.id";
	$limit="";
	IF(!empty($_GET['find']))
		{
		$clause="where 1";
		$find=$_GET['find'];
		if($find<100)
			{
			$limit=" limit 50";
			}
			else
			{
			$start=$find-50;
			$limit=" limit $start, $find";
			}
		$order_by="order by t1. id desc";
		}
	
	if($clause=="where 1")
		{	
		$sql="SELECT  count(t1.id) as num
		FROM dcr_archive as t1
		left join dcr_thumbnails as t2 on t1.id=t2.archive_id
		left join dcr_archive_images as t3 on t1.id=t3.archive_id
		where 1";		
		$result = mysqli_query($connection,$sql) or die ("Couldn't execute query 1. $sql ".mysqli_error($connection));
		$row=mysqli_fetch_assoc($result);
		$num_records=$row['num'];
// 		echo "n=$num_records";
		$ceiling=ceil($num_records/50);
// 		echo "c=$ceiling";
		}
		
	$sql="SELECT  t1.*, t2.link as thumb, t3.link, t4.firstpurchasedate as park_birthday
	FROM dcr_archive as t1
	left join dcr_thumbnails as t2 on t1.id=t2.archive_id
	left join dcr_archive_images as t3 on t1.id=t3.archive_id
	left join dpr_system.park_birthday as t4 on t4.park_code=left(t1.object_file_name,4) and establish_date_leg !='' and firstpurchasedate !=''
	$clause
	$order_by
	$limit";
// 	echo "$sql"; exit;
// 	echo "<pre>"; print_r($_SESSION); echo "</pre>"; // exit;
	$result = mysqli_query($connection,$sql) or die ("Couldn't execute query 1. $sql ".mysqli_error($connection));
	while($row=mysqli_fetch_assoc($result))
		{
		$ARRAY[]=$row;
		}
	if(empty($ARRAY))
		{include("archive_menu.php");echo "No entries."; exit;}
	$_SESSION['photos']['clause']=$clause;
//	echo "<pre>"; print_r($ARRAY); echo "</pre>";  exit;
	$c=count($ARRAY);
	}
	
if(!empty($rep))
	{
	date_default_timezone_set('America/New_York');
	$date=date('Y-m-d');
	header('Content-Type: application/vnd.ms-excel');
	header("Content-Disposition: attachment; filename=DPR_export_".$date.".xls");
	}
if(empty($rep))
	{
	include("archive_menu.php");
	}

echo "<table border='1'>";
if(!empty($ARRAY))
	{
	foreach($ARRAY AS $index=>$array)
		{
		if($index==0)
			{
			echo "<tr>";
			if(!empty($rep))
				{
				foreach($ARRAY[0] AS $fld=>$value)
					{
					if($fld=="id")
						{continue;}
					if($fld=="link")
						{continue;}
					$var_0=$ARRAY_notes[0][$fld];
					$var_1=$ARRAY_notes[1][$fld];
					$var=$var_0."***".$var_1;
					if($fld=="id")
						{
						echo "<th><a onclick=\"toggleDisplay('$fld');\" href=\"javascript:void('')\">$fld</a>
			<div id=\"$fld\" style=\"display: none\">$var</div></th>";
						}
						else
						{echo "<th>$fld</th>";}
					}
				}
				else
				{
				foreach($ARRAY[0] AS $fld=>$value)
					{
					if($fld=="link")
						{continue;}
					$rep_fld=$fld;
					if($fld=="title_"){$rep_fld="title";}
					echo "<th>$rep_fld</th>";			
					}
				}
			echo "</tr>";
			}
		echo "<tr>";
		foreach($array as $fld=>$value)
			{
			if($fld=="id")
				{
				if(empty($rep))
					{
					$value="<a href='archive_update.php?id=$value' target='_blank'>[&nbsp;$value&nbsp;]</a>";

					$var_link=$array['link'];
					$exp=explode("/",$var_link);
					$get_th="ztn.".array_pop($exp);
					$thumb=implode("/",$exp)."/".$get_th;
					if(file_exists($thumb))
						{
						$value.="<a href='$var_link' target='_blank'><img src=$thumb></a>";
						}
					if($level<3)
						{
						$value="<a href='$var_link' target='_blank'><img src=$thumb></a>";
						}
					}
					else
					{continue;}
				}
				else
				{
				if(empty($rep))
					{
					if($fld=="link")
						{continue;}
					if($fld=="title_" or $fld=="index_terms")
						{
						$temp=$fld.$index;
						$temp1=substr($value,0,30);
						$value="<a onclick=\"toggleDisplay('$temp');\" href=\"javascript:void('')\">$temp1</a>
			<div id=\"$temp\" style=\"display: none\">$value</div>";
						}
						else
						{$value=substr($value,0,30);}
					}
					
				}
			echo "<td valign='top'>$value</td>";
			}
		echo "</tr>";
		}
	}

if(!empty($ceiling))
	{
echo "<tr><td colspan='7' align='center'>";
for($i=1;$i<=$ceiling;$i++)
	{
	$j=$i*50;
	if($i==$ceiling)
		{$j=$num_records+1;}
	echo "<a href=archive.php?find=$j>$i</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
	}
	echo "</td></tr>";
	}
echo "</table>";
mysqli_close($connection);
exit;
?>