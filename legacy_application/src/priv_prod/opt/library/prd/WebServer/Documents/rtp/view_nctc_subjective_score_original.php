<?php
ini_set('display_errors',1);

include("page_scores_header.php");
date_default_timezone_set('America/New_York');
$database="rtp"; 
$dbName="rtp";

 //echo "<pre>"; print_r($_POST); echo "</pre>";  exit;
 echo "<pre>"; print_r($_SESSION); echo "</pre>";  //exit;

include("../../include/iConnect.inc");
	
mysqli_select_db($connection,$dbName);

$edit_array=array("trail_work_type","state_trail","dot_category","land_status", "gov_body_approval", "public_communication");
$edit_array_subjective=array("com_member_0","com_member_1","com_member_2", "com_member_3", "com_member_4", "com_member_5", "com_member_6");

$subjective_score_array=array(""=>"","0 Disqualified"=>"0","Low Score"=>"1","Medium Score"=>"2","High Score"=>"3");

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
//echo "<pre>"; print_r($nctc_members); echo "</pre>"; // exit;

unset($ARRAY_project_score_subjective);
if($set_cycle=="fa")
	{
	$sql="SELECT t1.project_file_name, t2.com_member_0, t2.com_member_1, t2.com_member_2, t2.com_member_3, t2.com_member_4, t2.com_member_5, t2.com_member_6, group_concat(t2.individual_comments separator '\n') as individual_comments, t2.group_comments, t2.member_name
	from project_info as t1
	left join nctc_track_subjective_scores as t2 on t1.project_file_name=t2.project_file_name
	 WHERE t1.project_file_name='$project_file_name'
	 group by  t2.member_name";
	 }
if($set_cycle=="pa")
	{
	$sql="SELECT t1.project_file_name, t2.com_member_0, t2.com_member_1, t2.com_member_2, t2.com_member_3, t2.com_member_4, t2.com_member_5, t2.com_member_6, t2.individual_comments, t2.group_comments, t2.member_name
	from project_info_pa as t1
	left join nctc_track_subjective_scores_pa as t2 on t1.project_file_name=t2.project_file_name
	 WHERE t1.project_file_name='$project_file_name'";
	 }
  ECHO "$sql"; //exit;
$result = mysqli_query($connection,$sql) or die("$sql Error 1#". mysqli_errno($connection) . ": " . mysqli_error($connection));
while($row=mysqli_fetch_assoc($result))
	{
	$ARRAY_project_score_subjective[]=$row;
	$ARRAY_nctc_individual_comments_subjective[$row['member_name']]=$row['individual_comments'];
	}
echo "<pre>"; print_r($ARRAY_project_score_subjective); echo "</pre>";  //exit;

$skip=array("individual_comments","group_comments");
$shown_array=array();
echo "<table border='1'>";
foreach($ARRAY_project_score_subjective AS $index=>$array)
	{
	$score=0;	
	$i=0;
	$member_number="";
	foreach($array as $fld=>$value)
		{
		if(in_array($member_name,$shown_array) and $level<1){exit;}

		if(in_array($fld,$skip)){continue;}
		if(is_numeric($value))
			{
			$temp_score=$value;
			$score+=$temp_score;
			}
			
			fmod($i,2)==0?$tr_color="#ffe6b3":$tr_color="aliceblue";
			//echo "$nctc_members[$fld]";
			
			
			$member_name=$nctc_members[$fld];
			if(!empty($member_name))
				{
				$track_member=$fld;
				$member_number=substr($fld,-1) + 1;
				}
				
		echo "<tr bgcolor='$tr_color'><td><h4>$member_number $member_name</h4></td><th>$value</th></tr>";
	if(in_array($fld,$edit_array_subjective))  // set in scores.php
			{
			$j++;
			
			$var_tempID=$_SESSION['rtp']['username']."_".time();
			$individual_comments=$ARRAY_nctc_individual_comments_subjective[$member_name];
			$group_comments=$array['group_comments'];

			echo "
			<form method='POST' action='change_nctc_subjective_score.php'>
			<tr bgcolor='$tr_color'><td align='right'>
			
			
			<strong>Select Your Score:</strong> <select name='$fld'>";
			$i++;
			$temp_array=${$fld."_array"};
			foreach($subjective_score_array as $k=>$v)
				{
				$table_score=$v;
				if($v==$value)
					{
					$s="selected";
					}else
					{$s="";}
				echo "<option value=\"$v\" $s>$v - $k</option>\n";
				}
			echo "</select></td></tr>";
			
			echo "<tr><td><strong><font color='#cc0066'>Individual Comments (optional):</font></strong></td></tr>";
			echo "<tr><td><textarea name='individual_comments_add' cols='70' rows='2'></textarea></td></tr>";
			echo "<tr><td>";
			if(!empty($individual_comments))
				{
				$ic=nl2br($individual_comments);
				echo "$ic<br />";
				}
			if($_SESSION['rtp']['set_year']=="2017" AND $_SESSION['rtp']['username']==$member_name)
				{
				echo "</td><td><input type='hidden' name='editor' value=\"$var_tempID\" readonly>
				<input type='hidden' name='table_field' value=\"$fld\">
				<input type='hidden' name='member_name' value=\"$member_name\">
				<input type='hidden' name='track_member' value=\"$track_member\">
				<input type='hidden' name='project_file_name' value=\"$project_file_name\">
				<input type='submit' name='submit_form' value=\"Update\" style=\"background-color:#ff9933;\">
				</form>";
				}
			echo "</td></tr>";
		//	if(in_array($array['member_name'],$shown_array)){break;}
	$shown_array[]=$array['member_name'];
			}
		}

	}
	$avg=number_format($score/3,2);
	echo "<tr><td><form method='POST' action='change_nctc_subjective_score.php'><strong><font color='#cc0066'>Group Comments (indicate reason for any change of score by the Group):</font></strong><br /><textarea name='group_comments' cols='70' rows='4'>$group_comments</textarea></td></tr>";
	
if($_SESSION['rtp']['set_year']=="2017" or $level>3)
				{
echo "<tr><td>
<input type='hidden' name='project_file_name' value=\"$project_file_name\">
<input type='hidden' name='track_member' value=\"$track_member\">
<input type='hidden' name='member_name' value=\"$member_name\">
<input type='submit' name='submit_form' value=\"Update\" style=\"background-color:#66ff99;\">
</form></td><th align='right' >$avg</th></tr>";
}
echo "</table>";
echo "<pre>"; print_r($shown_array); echo "</pre>"; // exit;
?>
