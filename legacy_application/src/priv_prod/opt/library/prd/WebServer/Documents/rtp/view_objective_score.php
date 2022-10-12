<?php
ini_set('display_errors',1);
$var="scores";
include("page_scores_header.php");
date_default_timezone_set('America/New_York');
$database="rtp"; 
$dbName="rtp";
$tempID=$_SESSION['rtp']['tempID'];

 //echo "<pre>"; print_r($_POST); echo "</pre>";  exit;

include("../../include/iConnect.inc");
	
mysqli_select_db($connection,$dbName);

$message="";
if(!empty($_GET['message']))
	{
	extract($_GET);
	$message="<h2><font color='red'>$message</font></h2>";
	}

if($level>0)
	{
$edit_array=array("trail_work_type","state_trail","dot_category","land_status", "gov_body_approval", "public_communication", "past_perform_score");
$edit_array_subjective=array("mountain","piedmont","coastal","comments");
	}
	else
	{$edit_array=array(); $edit_array_subjective=array();}
include("scoring_arrays.php");

$sql="SELECT *
from rtp_objective_scores as t1
WHERE 1"; //ECHO "$sql"; //exit;
$result = mysqli_query($connection,$sql) or die("$sql Error 1#". mysqli_errno($connection) . ": " . mysqli_error($connection));
while($row=mysqli_fetch_assoc($result))
	{
	$ARRAY_base_scores[$row['table_value']]=$row['table_score'];
	}
 // echo "<pre>"; print_r($ARRAY_base_scores); echo "</pre>";  exit;


unset($ARRAY_project_score);
if($set_cycle=="fa")
	{
	$sql="SELECT t1.project_file_name, t1.trail_work_type, t1.state_trail, t1.dot_category, t2.land_status, t3.gov_body_approval, t3.public_communication, t7.past_perform_score, group_concat(distinct t6.why_change separator '*') as why_change, group_concat(distinct t6.table_field separator '*') as table_field
	from project_info as t1
	left join project_location as t2 on t1.project_file_name=t2.project_file_name
	left join project_description as t3 on t1.project_file_name=t3.project_file_name
	left join account_info as t4 on t1.project_file_name=t4.project_file_name
	left join track_objective_score_updates as t6 on t1.project_file_name=t6.project_file_name and t6.why_change !=''
	left join applicant_past_performance as t7 on t1.project_file_name=t7.project_file_name
	 WHERE t1.project_file_name='$project_file_name'
	group by t1.project_file_name
	"; 
	}
if($set_cycle=="pa")
	{
	$sql="SELECT t1.project_file_name, t1.trail_work_type, t1.state_trail, t1.dot_category, t2.land_status, t3.gov_body_approval, t3.public_communication, t7.past_perform_score, group_concat(distinct t6.why_change separator '*') as why_change, group_concat(distinct t6.table_field separator '*') as table_field
	from project_info_pa as t1
	left join project_location_pa as t2 on t1.project_file_name=t2.project_file_name
	left join project_description_pa as t3 on t1.project_file_name=t3.project_file_name
	left join account_info_pa as t4 on t1.project_file_name=t4.project_file_name
	left join track_objective_score_updates_pa as t6 on t1.project_file_name=t6.project_file_name and t6.why_change !=''
	left join applicant_past_performance as t7 on t1.project_file_name=t7.project_file_name
	 WHERE t1.project_file_name='$project_file_name'
	group by t1.project_file_name
	"; 
	}
	
//ECHO "$sql"; //exit;
$result = mysqli_query($connection,$sql) or die("$sql Error 1#". mysqli_errno($connection) . ": " . mysqli_error($connection));

while($row=mysqli_fetch_assoc($result))
	{
	$ARRAY_project_score[]=$row;
	$exp1=explode("*",$row['table_field']);
	$exp2=explode("*",$row['why_change']);
	foreach($exp1 as $k=>$v)
		{
		$ARRAY_change[$project_file_name][$v]=$exp2[$k];
		}
	}
// echo "<pre>"; print_r($ARRAY_change); echo "</pre>";  //exit;

//  echo "<pre>"; print_r($ARRAY_base_scores); echo "</pre>";  //exit;

$sql="SELECT field_title, field_text
from field_name_text_1 as t1
WHERE 1 and table_name='project_info'
UNION
SELECT field_title, field_text
from field_name_text_1 as t1
WHERE 1 and table_name='project_location'
UNION
SELECT field_title, field_text
from field_name_text_1 as t1
WHERE 1 and table_name='project_description'
"; //ECHO "$sql"; //exit;
$result = mysqli_query($connection,$sql) or die("$sql Error 1#". mysqli_errno($connection) . ": " . mysqli_error($connection));
while($row=mysqli_fetch_assoc($result))
	{
	$rename_array[$row['field_title']]=$row['field_text'];
	}
$rename_array['past_perform_score']="Past Performance Score";
$skip=array("why_change","table_field");

$c=count($ARRAY_project_score);
echo "<table border='1'><tr><td colspan='2'>$message</td></tr>";
foreach($ARRAY_project_score AS $index=>$array)
	{
	$score=0;	
	$i=0;
	foreach($array as $fld=>$value)
		{
		if(in_array($fld,$skip)){continue;}
		$temp_score=$ARRAY_base_scores[$value]; 
		$score+=$temp_score;
	
		//	fmod($i,2)==0?$tr_color="#ffe680":$tr_color="#ecffb3";
		$tr_color='white';
			$new_name=$rename_array[$fld];
		echo "<tr bgcolor='$tr_color'><td>$new_name</td><td><strong>$value</strong></td><th>$temp_score</th></tr>";
	
		if(in_array($fld,$edit_array))  
			{
			$var_tempID=$tempID."_".time();
			$why_change=$ARRAY_change[$array['project_file_name']][$fld];
			
			echo "<tr bgcolor='$tr_color'><td colspan='3' >
			<form method='POST' name='change_score' action='change_rts_objective_score.php'>
			Change Score: <select id='$fld' name='$fld'>";
			$i++;
			$temp_array=${$fld."_array"};  // defined in scoring_arrays.php
			
			if(!empty($temp_array))
				{
				foreach($temp_array as $k=>$v)
					{
					$table_score=$ARRAY_base_scores[$v];
					if($v==$value)
						{
						$old_value=$value;
						$old_index=$k;
						$s="selected";
						}else
						{$s="";}
					echo "<option value=\"$v\" $s>$v - $table_score</option>\n";
					}
				}
				$wc=nl2br($why_change);
			echo "</select><br />$wc<br />
			<strong><font color='#cc0066'>Justify Score Change - </font> required if you change the score.</strong><br /><textarea name='why_change_add' cols='60' rows='1'></textarea></td></tr>";
			
			if($_SESSION['rtp']['set_year']=="2017" or $level>3)
				{
			echo "<tr><td colspan='3' align='right'>
			<input type='text' name='editor' value=\"$var_tempID\" readonly>
			<input type='hidden' name='old_index' value=\"$old_index\">
			<input type='hidden' name='old_value' value=\"$old_value\">
			<input type='hidden' name='table_field' value=\"$fld\">
			<input type='hidden' name='project_file_name' value=\"$project_file_name\">
			<input type='submit' name='submit_form' value=\"Update\" style=\"background-color:#ff9933;\" onClick=\"checkChange();\">
			</form>
			</td></tr>";
				
				}
			}
		}
	echo "<tr><th align='right' colspan='3'>$score</th></tr>";

	}
echo "</table>";
?>
