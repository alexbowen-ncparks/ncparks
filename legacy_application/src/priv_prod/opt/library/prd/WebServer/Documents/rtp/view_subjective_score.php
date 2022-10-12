<?php
ini_set('display_errors',1);

include("page_scores_header.php");
date_default_timezone_set('America/New_York');
$database="rtp"; 
$dbName="rtp";
$tempID=$_SESSION['rtp']['username'];
$username=$_SESSION['rtp']['username'];

 //echo "<pre>"; print_r($_POST); echo "</pre>";  exit;
//  echo "<pre>"; print_r($_SESSION); echo "</pre>";  //exit;
 
include("../../include/iConnect.inc");
	
mysqli_select_db($connection,$dbName);

$edit_array=array("trail_work_type","state_trail","dot_category","land_status", "gov_body_approval", "public_communication");
$edit_array_subjective=array("mountain","piedmont","coastal", "state_trails_planner", "trails_program_manager", "trails_grants_manager", "comments");

$subjective_score_array=array(""=>"","0 Disqualified"=>"0","Low Score"=>"1","Medium Score"=>"2","High Score"=>"3");

unset($ARRAY_project_score_subjective);
if($set_cycle=="fa")
	{
	$sql="SELECT t1.project_file_name, t2.mountain, t2.piedmont, t2.coastal, t2.state_trails_planner, t2.trails_program_manager, t2.trails_grants_manager, t2.individual_comments, t2.group_comments, t2.comments_to_nctc
	from project_info as t1
	left join rts_track_subjective_scores as t2 on t1.project_file_name=t2.project_file_name
	 WHERE t1.project_file_name='$project_file_name'";
	 }
if($set_cycle=="pa")
	{
	$sql="SELECT t1.project_file_name, t2.mountain, t2.piedmont, t2.coastal, t2.state_trails_planner, t2.trails_program_manager, t2.trails_grants_manager, t2.individual_comments, t2.group_comments, t2.comments_to_nctc
	from project_info_pa as t1
	left join rts_track_subjective_scores_pa as t2 on t1.project_file_name=t2.project_file_name
	 WHERE t1.project_file_name='$project_file_name'";
	 }
  //ECHO "$sql"; //exit;
$result = mysqli_query($connection,$sql) or die("$sql Error 1#". mysqli_errno($connection) . ": " . mysqli_error($connection));
while($row=mysqli_fetch_assoc($result))
	{
	$ARRAY_project_score_subjective[]=$row;
	}
 //echo "<pre>"; print_r($ARRAY_project_score_subjective); echo "</pre>";  //exit;

$rtp_cash="";
if($set_cycle=="fa" and strtolower($username)=="brodie1234")
	{
	$sql="SELECT sum(t1.deliv_value) as 'CASH-RTP'
	from project_budget as t1
	 WHERE t1.project_file_name='$project_file_name' and deliv_fund_type='Cash-RTP'
	 group by t1.project_file_name";
	 }
$result = mysqli_query($connection,$sql);  //echo "$sql";
$row=mysqli_fetch_assoc($result);
$rtp_cash="$".number_format($row['CASH-RTP'],2);

$skip=array("individual_comments","group_comments","comments_to_nctc");

if($level<1)
	{
	$nctc_skip=array("mountain","piedmont","coastal","state_trails_planner","trails_program_manager","trails_grants_manager");
	$skip=array_merge($skip, $nctc_skip);
	}
echo "<table border='1'>";
$j=0;
foreach($ARRAY_project_score_subjective AS $index=>$array)
	{
	$score=0;	
	$i=0;
	foreach($array as $fld=>$value)
		{
		if(is_numeric($value))
			{
			if($value>-1){$j++;}
			$temp_score=$value;
			$score+=$temp_score;
			}
		if(in_array($fld,$skip)){continue;}
		
	
			fmod($i,2)==0?$tr_color="#ffe6b3":$tr_color="aliceblue";
		echo "<tr bgcolor='$tr_color'><td><h4>$fld</h4></td><th>$value</th></tr>";
	
	if(in_array($fld,$edit_array_subjective))  // set in scores.php
			{
			$var_tempID=$tempID."_".time();
			$individual_comments=nl2br($array['individual_comments']);
			$group_comments=nl2br($array['group_comments']);
			$comments_to_nctc=nl2br($array['comments_to_nctc']);

			echo "<tr bgcolor='$tr_color'><td align='right'>";
			
			if($_SESSION['rtp']['set_year']=="2017" or $level>3)
				{
				if($fld==$_SESSION['rtp']['score_access'] or $level>3)
					{		
				echo "<form method='POST' action='change_rts_subjective_score.php'>
		
				Change Score: <select name='$fld'>";
				$i++;
				$temp_array=${$fld."_array"};
				foreach($subjective_score_array as $k=>$v)
					{
	// 				$table_score=$v;
					if($v==$value)
						{
						$s="selected";
						}else
						{$s="";}
					echo "<option value=\"$v\" $s>$v - $k</option>\n";
					}
				echo "</select>
				<input type='text' name='editor' value=\"$var_tempID\" readonly>
				<input type='hidden' name='table_field' value=\"$fld\">
				<input type='hidden' name='project_file_name' value=\"$project_file_name\">
				<input type='submit' name='submit_form' value=\"Update\" style=\"background-color:#ff9933;\">
				</form>";
				if($rtp_cash!="$0.00"){
				echo "</td><th>Cash-RTP<br />$rtp_cash</th></tr>";}
					}
				}
			}
		}

	}
	@$avg=number_format($score/$j++,2);

	if($level>0)
		{
	echo "<tr><td><form method='POST' action='change_rts_subjective_score.php'><strong><font color='#cc0066'>Individual Comments (optional):</font></strong><br />
	<div>$individual_comments</div>
	<textarea name='individual_comments_add' cols='70' rows='2'></textarea>
	</td></tr>";

	echo "<tr><td><strong><font color='#cc0066'>Group Comments (indicate reason for any change of score by the Group):</font></strong><br />
	<div>$group_comments</div>
	<textarea name='group_comments_add' cols='70' rows='4'></textarea></td></tr>";
		
		}

	echo "<tr><td><strong><font color='green'>Comments to NCTC:</font></strong><br />
	<div>$comments_to_nctc</div><textarea name='comments_to_nctc_add' cols='70' rows='4'></textarea></td></tr>";
if($level>0)
	{
	echo "<tr><td><input type='hidden' name='project_file_name' value=\"$project_file_name\">
	<input type='submit' name='submit_form' value=\"Update\" style=\"background-color:#66ff99;\">
	</form></td>";
	}
echo "<th align='right' colspan='2'>$avg</th></tr></table>";

?>
