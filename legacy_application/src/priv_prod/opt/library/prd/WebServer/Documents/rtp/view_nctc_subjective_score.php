<?php
ini_set('display_errors',1);

include("page_scores_header.php");
date_default_timezone_set('America/New_York');
$database="rtp"; 
$dbName="rtp";

 //echo "<pre>"; print_r($_POST); echo "</pre>";  exit;
//  echo "<pre>"; print_r($_SESSION); echo "</pre>";  //exit;

include("../../include/iConnect.inc");
	
mysqli_select_db($connection,$dbName);

$edit_array=array("trail_work_type","state_trail","dot_category","land_status", "gov_body_approval", "public_communication");
$edit_array_subjective=array("com_member_0","com_member_1","com_member_2", "com_member_3", "com_member_4", "com_member_5", "com_member_6");

$subjective_score_array=array(""=>"","Disqualified"=>"0","Low Score"=>"1","Medium Score"=>"2","High Score"=>"3");

$sql="SELECT *
	from nctc_members as t1
	 WHERE t1.year='$set_year'";
	
$result = mysqli_query($connection,$sql) or die("$sql Error 1#". mysqli_errno($connection) . ": " . mysqli_error($connection));
while($row=mysqli_fetch_assoc($result))
	{
	$nctc_member_name[$row['member']]=$row['first_name']." ".$row['last_name'];
	$nctc_members[$row['member']]=$row['first_name']." ".$row['last_name'];
	$nctc_represents[$row['member']]=$row['represents'];  // not presently used
	}
// echo "$set_year<pre>"; print_r($nctc_members); echo "</pre>$sql"; // exit;

unset($ARRAY_project_score_subjective);
if($set_cycle=="fa")
	{
	$sql="SELECT t1.project_file_name, t2.com_member_0, t2.com_member_1, t2.com_member_2, t2.com_member_3, t2.com_member_4, t2.com_member_5, t2.com_member_6, group_concat(t2.individual_comments separator '**') as individual_comments, t2.group_comments, t2.member_name, t3.member as track_member_number
	from project_info as t1
	left join nctc_track_subjective_scores as t2 on t1.project_file_name=t2.project_file_name
	left join nctc_members as t3 on t2.member_name=concat(t3.first_name,' ',t3.last_name)
	 WHERE t1.project_file_name='$project_file_name'
	 group by  t2.member_name";
	 }
if($set_cycle=="pa")
	{
	$sql="SELECT t1.project_file_name, t2.com_member_0, t2.com_member_1, t2.com_member_2, t2.com_member_3, t2.com_member_4, t2.com_member_5, t2.com_member_6, group_concat(t2.individual_comments separator '**') as individual_comments, t2.group_comments, t2.member_name, t3.member as track_member_number, t2.track_id
	from project_info_pa as t1
	left join nctc_track_subjective_scores_pa as t2 on t1.project_file_name=t2.project_file_name
	left join nctc_members as t3 on t2.member_name=concat(t3.first_name,' ',t3.last_name)
	 WHERE t1.project_file_name='$project_file_name'
	 group by  t2.member_name";
	 }
//  ECHO "$sql"; //exit;
$result = mysqli_query($connection,$sql) or die("$sql Error 1#". mysqli_errno($connection) . ": " . mysqli_error($connection));
while($row=mysqli_fetch_assoc($result))
	{
//	$ARRAY_project_score_subjective[$row['track_member_number']]=$row;
	$ARRAY_project_score_subjective[]=$row;
	$ARRAY_project_score_subjective_member[$row['track_member_number']]=$row;
	$ARRAY_nctc_individual_comments_subjective[$row['member_name']]=$row['individual_comments'];
	}
//echo "<pre>"; print_r($ARRAY_project_score_subjective); echo "</pre>";  //exit;
 //echo "<pre>"; print_r($ARRAY_nctc_individual_comments_subjective); echo "</pre>";  //exit;

$skip=array("individual_comments","group_comments");
$shown_array=array();
$com_member_num=$_SESSION['rtp']['member'];
$score=array();

if(empty($nctc_members))
	{
	echo "<br />Data for that year has not yet been entered.";
	exit;
	}
//echo "<pre>"; print_r($ARRAY_project_score_subjective_member); echo "</pre>"; // exit;
//echo "<pre>"; print_r($ARRAY_project_score_subjective); echo "</pre>"; // exit;
echo "<table border='1'>";
foreach($nctc_members as $com_member_num=>$com_member_name)
	{
	if($level<1 and $com_member_name!=$_SESSION['rtp']['username']){continue;}
	$var_score=$ARRAY_project_score_subjective_member[$com_member_num][$com_member_num];
//	echo "v=$var_score <pre>"; print_r($subjective_score_array); echo "</pre>"; // exit;
	echo "
		<form method='POST' action='change_nctc_subjective_score.php'>
		<tr bgcolor='$tr_color'>
		<td><strong>$com_member_name</strong></td>
		<td align='right'>
		
		
		Select Your Score: <select name='$com_member_num'>";
		foreach($subjective_score_array as $k=>$v)
			{
			$table_score=$v;
			if($v==$var_score)
				{
				$s="selected";
				if(!empty($v))
					{$score[]=$v;}
				
				}else
				{$s="";}
			echo "<option value=\"$v\" $s>$v - $k</option>\n";
			}
		echo "</select></td></tr>";
		
		if($level<1)
			{
		echo "<tr><td colspan='2'><strong><font color='#cc0066'>Individual Comments (optional):</font></strong></td></tr>";
		echo "<tr><td colspan='2'><textarea name='individual_comments_add' cols='70' rows='1'></textarea></td></tr>";
			}
		echo "<tr><td colspan='2'>";
		if(!empty($ARRAY_nctc_individual_comments_subjective[$com_member_name]))
			{
			$ic=$ARRAY_nctc_individual_comments_subjective[$com_member_name];
			$temp=explode("**",$ic);
			$temp_array=array();
			foreach($temp as $k1=>$v1)
				{
				if(empty($v1)){continue;}
				$temp_array[]=$v1;
				}
			$var_ic=implode("<br />",$temp_array);
			echo "$var_ic<br />";
			}
		if($set_year=="2017" AND $_SESSION['rtp']['username']==$com_member_name AND $set_cycle=="fa")
			{
			// echo "</td><td>
// 			<input type='hidden' name='table_field' value=\"$com_member_num\">
// 			<input type='hidden' name='member_name' value=\"$com_member_name\">
// 			<input type='hidden' name='project_file_name' value=\"$project_file_name\">
// 			<input type='submit' name='submit_form' value=\"Update\" style=\"background-color:#ff9933;\">
// 			</form></td></tr>";
	}
	
}
if($level>0)
	{
	$c=count($score);
	$sum=array_sum($score);
	@$tot_score=number_format($sum/$c,1);
	echo "<tr><td colspan='2' align='right'>$sum / $c = $tot_score</td></tr>";
	}
echo "</table>";
?>