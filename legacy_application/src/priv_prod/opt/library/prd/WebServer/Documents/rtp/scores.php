<?php
ini_set('display_errors',1);
$var="scores";
include("page_list_scores.php");
date_default_timezone_set('America/New_York');
$database="rtp"; 
$dbName="rtp";

// echo "<pre>"; print_r($_POST); echo "</pre>"; // exit;
//  echo "s=$set_year <pre>"; print_r($_SESSION); echo "</pre>"; // exit;

//include("../../include/iConnect.inc");
	
//mysqli_select_db($connection,$dbName);


include("scoring_arrays.php");

$sql="SELECT *
from rtp_objective_scores as t1
WHERE 1"; //ECHO "$sql"; //exit;
$result = mysqli_query($connection,$sql) or die("$sql Error 1#". mysqli_errno($connection) . ": " . mysqli_error($connection));
while($row=mysqli_fetch_assoc($result))
	{
	$ARRAY_base_scores[$row['table_value']]=$row['table_score'];
	}
// echo "<pre>"; print_r($ARRAY_base_scores); echo "</pre>"; // exit;

if($_SESSION['rtp']['set_cycle']=="pa")
	{$TABLE="rts_track_subjective_scores_pa";}
if($_SESSION['rtp']['set_cycle']=="fa")
	{$TABLE="rts_track_subjective_scores";}
	
$var_year=$set_year."_";

$sql="SELECT * from $TABLE where 1 and project_file_name like '$var_year%'";
//ECHO "$sql"; //exit;
$result = mysqli_query($connection,$sql) or die("$sql Error 1#". mysqli_errno($connection) . ": " . mysqli_error($connection));
$value_flds=array("mountain"=>"M", "piedmont"=>"P", "coastal"=>"C", "state_trails_planner"=>"ST", "trails_program_manager"=>"TP", "trails_grants_manager"=>"TG");

while($row=mysqli_fetch_assoc($result))
	{
	extract($row);
	foreach($value_flds as $k=>$v)
		{
		$val=${$k};  //echo "$val";
		if($val>-1)
			{
			$rts_array[$row['project_file_name']][$value_flds[$k]]=$val;
			}
		}
	}


if($_SESSION['rtp']['set_cycle']=="pa")
	{$TABLE="nctc_track_subjective_scores_pa";}
if($_SESSION['rtp']['set_cycle']=="fa")
	{$TABLE="nctc_track_subjective_scores";}
	
$sql="SELECT * from nctc_members where 1 and year = '".$set_year."'";
$result = mysqli_query($connection,$sql) or die("$sql Error 1#". mysqli_errno($connection) . ": " . mysqli_error($connection));
while($row=mysqli_fetch_assoc($result))
	{
	extract($row);
	$value_nctc_flds[$member]=$first_name." ".$last_name;
	}
//echo "67 $set_year<pre>"; print_r($value_nctc_flds); echo "</pre>$sql";  exit;
// 
// $value_flds=array("mountain"=>"M", "piedmont"=>"P", "coastal"=>"C", "state_trails_planner"=>"ST", "trails_program_manager"=>"TP", "trails_grants_manager"=>"TG");
$sql="SELECT * from $TABLE where 1 and project_file_name like '$var_year%'";
// echo "$sql";
$result = mysqli_query($connection,$sql) or die("$sql Error 1#". mysqli_errno($connection) . ": " . mysqli_error($connection));

while($row=mysqli_fetch_assoc($result))
	{
	extract($row);
//	echo "<pre>"; print_r($row); echo "</pre>"; // exit;
	foreach($value_nctc_flds as $k=>$v)
		{
		$val=${$k};  //echo "$val";
		if($val>-1)
			{
			$nctc_array[$row['project_file_name']][$value_nctc_flds[$k]]=$val;
			}
		}
	}

// echo "nctc_array <pre>"; print_r($nctc_array); echo "</pre>"; // exit;
	
$where=" and left(t2.project_file_name,4)='$set_year' ";

if(!empty($_POST['project_file_name']))
	{
	extract($_POST);
	$where.=" and t1.project_file_name like '%$project_file_name%'";
	}
if(!empty($_POST['project_name']))
	{
	extract($_POST);
	$where.=" and t2.project_name like '%$project_name%'";
	}
if(!empty($_POST['region']))
	{
	extract($_POST);
	$where.=" and t4.rts_cnty1='$region'";
	}

if(!empty($_POST['use']))
	{
	extract($_POST);
	$where.=" and t5.".$use."='yes'";
	}

if($set_cycle=="fa")
	{
	$sql="SELECT distinct t1.project_file_name, t2.project_name, t5.trail_work_type, t5.state_trail, t5.dot_category, t3.land_status, t1.gov_body_approval, t1.public_communication, t4.rts_cnty1, t6.past_perform_score
	from project_description as t1
	left join project_info as t5 on t1.project_file_name=t5.project_file_name
	left join applicant_info as t2 on t1.project_file_name=t2.project_file_name
	left join project_location as t3 on t1.project_file_name=t3.project_file_name
	left join city_county as t4 on lower(substring_index(t3.project_county,',',1))=lower(t4.county_one)
	left join applicant_past_performance as t6 on t1.project_file_name=t6.project_file_name
	WHERE 1 $where
	order by t1.project_file_name
	";
	} //ECHO "$sql"; //exit;
if($set_cycle=="pa")
	{
	$sql="SELECT distinct t1.project_file_name, t2.project_name, t5.trail_work_type, t5.state_trail, t5.dot_category, t3.land_status, t1.gov_body_approval, t1.public_communication, t4.rts_cnty1, t6.past_perform_score
	from project_description_pa as t1
	left join project_info_pa as t5 on t1.project_file_name=t5.project_file_name
	left join applicant_info_pa as t2 on t1.project_file_name=t2.project_file_name
	left join project_location_pa as t3 on t1.project_file_name=t3.project_file_name
	left join city_county as t4 on lower(substring_index(t3.project_county,',',1))=lower(t4.county_one)
	left join applicant_past_performance as t6 on t1.project_file_name=t6.project_file_name
	WHERE 1 $where
	order by t1.project_file_name
	";
	} 
//ECHO "$sql"; //exit;
$result = mysqli_query($connection,$sql) or die("$sql Error 1#". mysqli_errno($connection) . ": " . mysqli_error($connection));
while($row=mysqli_fetch_assoc($result))
	{
	$ARRAY[]=$row;
	}
mysqli_num_rows($result)<1?$ARRAY=array():$ARRAY;
//echo "<pre>"; print_r($ARRAY); echo "</pre>";  exit;
//echo "<pre>"; print_r($_SESSION); echo "</pre>"; // exit;
$skip=array();
$dont_show=array("trail_work_type","state_trail","dot_category","land_status","gov_body_approval", "public_communication", "past_perform_score");
$edit_array=array("trail_work_type","state_trail","dot_category","land_status", "gov_body_approval", "public_communication");
$edit_array_subjective=array("mountain","piedmont","coastal","comments");

$c=count($ARRAY);
$rename_array=array("project_file_name"=>"Project File Name","project_name"=>"Project Name","rts_cnty1"=>"Region");
echo "<table border='1'><tr><td align='center'>$c</td></tr>";
foreach($ARRAY AS $index=>$array)
	{
	$show_name="";
	if($index==0)
		{
		echo "<tr>";
		foreach($ARRAY[0] AS $fld=>$value)
			{
			if(in_array($fld,$skip)){continue;}
		if(in_array($fld,$dont_show)){continue;}
		
			$new_name=$rename_array[$fld];
			echo "<th>$new_name</th>";
			}
		if($level>0 or ($set_cycle=="fa" and $set_year=="2016"))
			{echo "<th>Objective Score</th>";}
		
		echo "<th>RTS Subjective Score</th>";
		echo "<th>NCTC Subjective Score</th>";
		echo "</tr>";
		}
	echo "<tr>";
	$score=0;
	foreach($array as $fld=>$value)
		{
		if(in_array($fld,$skip)){continue;}
		$temp_score=$ARRAY_base_scores[$value];
		$score+=$temp_score;
		if(in_array($fld,$dont_show)){continue;}
		if($fld=="project_file_name")
			{
			$pfn=$value;
			$value="<a href='page_scores.php?project_file_name=$value'>$value</a>";
			}
		
		echo "<td>$value $temp_score</td>";
		}
	
	if($level>0 or ($set_cycle=="fa" and $set_year=="2016"))
		{echo "<td align='right'>$score</td>";}
	
	
//	$show_score=$ARRAY_project_score_rts_subjective[$array['project_file_name']];

$rts_subjective="";
$var_rts_subjective="";
$avg="";
$sub="";
$c=count($rts_array[$pfn]);
if($c>0)
	{
	$j=0;
	foreach($rts_array[$pfn] as $k=>$v)
		{
		if($v>"-1"){$j++;}
		$rts_subjective.="(".$k."".$v.") ";
		$sub=$sub+$v;
		}
	$avg=($sub/$j);
	$var_rts_subjective="avg=<strong>".number_format($avg,2)."</strong><br />";
	}
	if($level>0){$var_rts_subjective.=$rts_subjective;}
	echo "<td align='right' valign='top'><font size='-1'>$var_rts_subjective</font></td>";

$nctc_subjective="";
$var_nctc_subjective="";
$avg="";
$sub="";
$c=count($nctc_array[$pfn]);   //echo "$pfn c=$c";
// echo "<pre>"; print_r($nctc_array); echo "</pre>"; // exit;
	$mem_name=$_SESSION['rtp']['username'];
if($c>0)
	{
	$j=0;
	foreach($nctc_array[$pfn] as $k=>$v)
		{
		if($v>"-1"){$j++;}
		
		$nctc_subjective.="(".$k."".$v.") ";
		$sub=$sub+$v;
		if($k==$mem_name){$show_name=$k; $track_project_score[$pfn][$k]=$v;}
		}
	$avg=($sub/$j);
	$var_mem_score[$k]=$v;
	$var_nctc_subjective="avg=<strong>".number_format($avg,2)."</strong><br />";
	}	
	
	$vsn=$track_project_score[$pfn][$mem_name];
	if($level>0)
		{
		$var_nctc_subjective.=$nctc_subjective;
		$vsn=$var_nctc_subjective;
		}
		else
		{
		if($set_year=="2016")
			{
			$vsn=$var_nctc_subjective;
			}
		}
	echo "<td align='right' valign='top'>$vsn</td>";
	
	echo "</tr>";
	}
echo "</table>";
?>