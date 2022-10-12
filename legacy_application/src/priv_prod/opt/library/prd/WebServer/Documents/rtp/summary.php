<?php
ini_set('display_errors',1);
$var="summary";
include("page_list_summary.php");

$database="rtp"; 
$dbName="rtp";
//echo "<pre>"; print_r($_SESSION); echo "</pre>"; // exit;

//include("../../include/iConnect.inc");
	
//mysqli_select_db($connection,$dbName);

// echo "s=$set_year <pre>"; print_r($_POST); echo "</pre>"; // exit;

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
	$sql="SELECT distinct t1.project_file_name, t2.project_name, t4.rts_cnty1, t1.brief_narrative
	from project_description as t1
	left join applicant_info as t2 on t1.project_file_name=t2.project_file_name
	left join project_location as t3 on t1.project_file_name=t3.project_file_name
	left join city_county as t4 on lower(substring_index(t3.project_county,',',1))=lower(t4.county_one)
	left join project_info as t5 on t1.project_file_name=t5.project_file_name
	WHERE 1 $where
	order by t1.project_file_name"; //ECHO "31 $sql"; //exit;
	}
if($set_cycle=="pa")
	{
	$sql="SELECT distinct t1.project_file_name, t2.project_name, t4.rts_cnty1, t1.brief_narrative, t6.invited_to_apply
	from project_description_pa as t1
	left join applicant_info_pa as t2 on t1.project_file_name=t2.project_file_name
	left join project_location_pa as t3 on t1.project_file_name=t3.project_file_name
	left join city_county as t4 on lower(substring_index(t3.project_county,',',1))=lower(t4.county_one)
	left join project_info_pa as t5 on t1.project_file_name=t5.project_file_name
	left join `rts_track_subjective_scores_pa` as t6 on t1.project_file_name=t6.project_file_name
	WHERE 1 $where
	order by t1.project_file_name"; //ECHO "41 $sql"; //exit;
	}
//	ECHO "$sql"; //exit;
$result = mysqli_query($connection,$sql) or die("$sql Error 1#". mysqli_errno($connection) . ": " . mysqli_error($connection));
while($row=mysqli_fetch_assoc($result))
	{
	$ARRAY[]=$row;
	}
mysqli_num_rows($result)<1?$ARRAY=array():$ARRAY;
//echo "<pre>"; print_r($ARRAY); echo "</pre>";  exit;

if($set_cycle=="fa")
	{
	$sql="SELECT t1.project_file_name, t1 . deliv_fund_type, t1.deliv_class_type , SUM( deliv_value ) AS sub_total 
	FROM project_budget AS t1 
	WHERE 1 GROUP BY `project_file_name`, deliv_fund_type, deliv_class_type WITH rollup"; 
	}//ECHO "$sql"; //exit;
if($set_cycle=="pa")
	{
	$sql="SELECT t1.project_file_name, t1 . deliv_fund_type, t1.deliv_class_type , SUM( deliv_value ) AS sub_total 
	FROM project_budget_pa AS t1 
	WHERE 1 GROUP BY `project_file_name`, deliv_fund_type, deliv_class_type WITH rollup"; 
	}//ECHO "$sql"; //exit;
$result = mysqli_query($connection,$sql) or die("$sql Error 1#". mysqli_errno($connection) . ": " . mysqli_error($connection));
	while($row=mysqli_fetch_assoc($result))
		{
		$ARRAY_sub[$row['project_file_name']][]=$row;
		}
//  echo "<pre>"; print_r($ARRAY_sub); echo "</pre>"; // exit;
$skip=array();
$c=count($ARRAY);
echo "<style>
.summary {
	font: 0.8em Tahoma, sans-serif;
}
</style>";
$rename_array=array("project_file_name"=>"Project File Name","project_name"=>"Project Name","rts_cnty1"=>"Region","brief_narrative"=>"Project Description","invited_to_apply"=>"Invited to Apply");
echo "<div class='summary'><table border='1'><tr><th>$c</th></tr>";
foreach($ARRAY AS $index=>$array)
	{
	if($index==0)
		{
		echo "<tr>";
		foreach($ARRAY[0] AS $fld=>$value)
			{
			if(in_array($fld,$skip)){continue;}
			$new_name=$rename_array[$fld];
			if($fld=="brief_narrative"){$fld="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$fld&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
			$new_name="Project Description";
			}
			echo "<th>$new_name</th>";
			}
	if($level>0 or $set_cycle=="fa")
		{echo "<th>Project Budget</th>";}
		
		echo "</tr>";
		}
	echo "<tr>";
	$score=0;
	foreach($array as $fld=>$value)
		{
		if(in_array($fld,$skip)){continue;}
		
		if($fld=="project_file_name")
			{$value="<a href='page_list_view.php?project_file_name=$value'>$value</a>";}
		if($fld=="brief_narrative")
			{$value="<a onclick=\"toggleDisplay('$index');\" href=\"javascript:void('')\">Show/Hide &plusmn;</a>
			<div id=\"$index\" style=\"display: block\">$value</div>";}
		echo "<td>$value</td>";
		}
	$div_id=$fld.$index;
	if($level>0 or $set_cycle=="fa")
		{
		echo "<td align='right'>
		<a onclick=\"toggleDisplay('$div_id');\" href=\"javascript:void('')\">Show/Hide &plusmn;</a>
		<div id=\"$div_id\" style=\"display: block\">";
		echo "<table border='1'>";
	//  	echo "<pre>"; print_r($ARRAY_sub[$array['project_file_name']]); echo "</pre>"; // exit;
		foreach($ARRAY_sub[$array['project_file_name']] as $index_1=>$array_1)
			{
			echo "<tr>";
		foreach($array_1 as $fld_1=>$value_1)
			{
			$value_1=str_replace(" ","&nbsp;",$value_1);
			if($fld_1=="project_file_name"){continue;}
			if($fld_1=="sub_total")
				{
				echo "<td align='right'>";
				$value_1=number_format($value_1,2);
				if(empty($array_1['deliv_class_type']))
					{
					echo "<strong>$".$value_1."</strong></td>";
					}
					else
					{echo "$value_1</td>";}		
				}
				else
				{
				echo "<td colspan='2'>$value_1</td>";
				}
	
			}
			echo "</tr>";
		
			}
		echo "</table></div>
		</td>";
		}
	echo "</tr>";
	}
echo "</table></div>";
?>