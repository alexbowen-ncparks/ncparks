<script>
function checkChange()
	{
	var x=document.forms['change_score']['old_index'].value;
	var y=document.forms['change_score']['why_change'].value;
	var dd1 = document.getElementById('trail_work_type').selectedIndex; 
	
	if(x != dd1)
 		{
 		if(y)
 			{}
 			else
 			{confirm('You need to indicate a reason for the change.');}
		}
	}
</script>

<?php
unset($ARRAY_project_score);
$sql="SELECT t1.project_file_name, t1.trail_work_type, t1.state_trail, t1.dot_category, t2.land_status, t3.gov_body_approval, t3.public_communication, group_concat(distinct t6.why_change separator '*') as why_change, group_concat(distinct t6.table_field separator '*') as table_field
from project_info as t1
left join project_location as t2 on t1.project_file_name=t2.project_file_name
left join project_description as t3 on t1.project_file_name=t3.project_file_name
left join account_info as t4 on t1.project_file_name=t4.project_file_name
left join track_objective_score_updates as t6 on t1.project_file_name=t6.project_file_name and t6.why_change !=''
 WHERE t1.project_file_name='$project_file_name'
group by t1.project_file_name
"; //ECHO "$sql"; //exit;
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
//  echo "<pre>"; print_r($ARRAY_change); echo "</pre>";  //exit;

//  echo "<pre>"; print_r($ARRAY_base_scores); echo "</pre>";  //exit;
$skip=array("why_change","table_field");
$c=count($ARRAY_project_score);
echo "<table border='1'>";
foreach($ARRAY_project_score AS $index=>$array)
	{
	$score=0;	
	$i=0;
	foreach($array as $fld=>$value)
		{
		if(in_array($fld,$skip)){continue;}
		$temp_score=$ARRAY_base_scores[$value]; // $ARRAY_base_scores set in scores.php
		$score+=$temp_score;
	
			fmod($i,2)==0?$tr_color="#ffe680":$tr_color="#ecffb3";
		echo "<tr bgcolor='$tr_color'><td>$fld</td><td><strong>$value</strong></td><td>$temp_score</td></tr>";
	
		if(in_array($fld,$edit_array))  // set in scores.php
			{
			$var_tempID="Test User_".time();
			$why_change=$ARRAY_change[$array['project_file_name']][$fld];
			
			echo "<tr bgcolor='$tr_color'><td colspan='3' >
			<form method='POST' name='change_score' action='change_rts_objective_score.php'>
			<strong><font color='#cc0066'>Justify Score Change - </font> required if you change the score.</strong> <textarea name='why_change' cols='60' rows='1'>$why_change</textarea><br />
			Change Score: <select id='$fld' name='$fld'>";
			$i++;
			$temp_array=${$fld."_array"};
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
			echo "</select><br />
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
	echo "<tr><th align='right' colspan='3'>$score</th></tr>";

	}
echo "</table>";
?>
