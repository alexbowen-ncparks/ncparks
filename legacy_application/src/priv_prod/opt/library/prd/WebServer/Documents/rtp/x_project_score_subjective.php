<?php
unset($ARRAY_project_score_subjective);
$sql="SELECT t1.project_file_name, t2.mountain, t2.piedmont, t2.coastal, t2.individual_comments, t2.group_comments
from project_info as t1
left join rts_track_subjective_scores as t2 on t1.project_file_name=t2.project_file_name
 WHERE t1.project_file_name='$project_file_name'"; //ECHO "$sql"; //exit;
$result = mysqli_query($connection,$sql) or die("$sql Error 1#". mysqli_errno($connection) . ": " . mysqli_error($connection));
while($row=mysqli_fetch_assoc($result))
	{
	$ARRAY_project_score_subjective[]=$row;
	}
// echo "<pre>"; print_r($ARRAY_project_score_subjective); echo "</pre>";  exit;

$skip=array("individual_comments","group_comments");

echo "<table border='1'>";
foreach($ARRAY_project_score_subjective AS $index=>$array)
	{
	$score=0;	
	$i=0;
	foreach($array as $fld=>$value)
		{
		if(in_array($fld,$skip)){continue;}
		if(is_numeric($value))
			{
			$temp_score=$value;
			$score+=$temp_score;
			}
		
	
			fmod($i,2)==0?$tr_color="#ffe6b3":$tr_color="aliceblue";
		echo "<tr bgcolor='$tr_color'><td><h4>$fld</h4></td><th>$value</th></tr>";
	
	if(in_array($fld,$edit_array_subjective))  // set in scores.php
			{
			$var_tempID="Test User_".time();
			$individual_comments=$array['individual_comments'];
			$group_comments=$array['group_comments'];

			echo "<tr bgcolor='$tr_color'><td align='right'>
			<form method='POST' action='change_rts_subjective_score.php'>
			
			Change Score: <select name='$fld'>";
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
			echo "</select>
			<input type='text' name='editor' value=\"$var_tempID\" readonly>
			<input type='hidden' name='table_field' value=\"$fld\">
			<input type='hidden' name='project_file_name' value=\"$project_file_name\">
			<input type='submit' name='submit_form' value=\"Update\" style=\"background-color:#ff9933;\">
			</form>
			</td></tr>";
			}
		}

	}
	$avg=number_format($score/3,2);
	echo "<tr><td><form method='POST' action='change_rts_subjective_score.php'><strong><font color='#cc0066'>Individual Comments (optional):</font></strong> <textarea name='individual_comments' cols='60' rows='4'>$individual_comments</textarea></td></tr>";

	echo "<tr><td><strong><font color='#cc0066'>Group Comments (indicate reason for any change of score by the Group):</font></strong> <textarea name='group_comments' cols='60' rows='4'>$group_comments</textarea></td></tr>";

echo "<tr><td><input type='hidden' name='project_file_name' value=\"$project_file_name\">
			<input type='submit' name='submit_form' value=\"Update\" style=\"background-color:#66ff99;\">
</form></td><th align='right' >$avg</th></tr>";
echo "</table>";
?>
