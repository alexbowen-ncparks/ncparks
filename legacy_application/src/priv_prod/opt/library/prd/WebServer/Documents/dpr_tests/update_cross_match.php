<?php
echo "2 update_cross_match<pre>"; print_r($edit_question[0]); echo "</pre>"; // exit;
		
echo "<form method='post' action='test.php'>";
echo "<table border='1'>";
$line="";
foreach($array as $fld=>$value)
	{
	if(in_array($fld, $skip_fld)){continue;}
	$var_fld=$rename_array[$fld];
	if($fld=="question_type")
		{
	$line.="<tr><td>$var_fld</td>
	<td><select name='$fld'><option value=\"\" selected=''></option>\n";
	foreach($question_type_array as $k=>$v)
		{
		if($value==$v){$s="selected";}else{$s="";}
		$line.="<option value='$v' $s>$v</option>\n";
		}
	$line.="</select></td></tr>";
	continue;
		}
	if($fld==strtolower($array['answer']))
		{
		$var_fld="<font color='magenta'>$rename_array[$fld]</font>";
		}

	if(!in_array($fld,$var_array))
		{
		$line.="<tr><td>$var_fld</td>
		<td><textarea name='$fld' cols='55' rows='3'>$value</textarea></td>
		</tr>";
		}
		else
		{

	$line.="<tr><td>$var_fld</td><td><input type='text' name='$fld' value=\"$value\" size=3'></td></tr>";
		}

	}
echo "$line";
echo "<tr><td colspan='2' align='center'>
<input type='hidden' name='test_number' value=\"$test_id\">
<input type='hidden' name='qid' value=\"$array[qid]\">
<input type='hidden' name='page' value=\"edit_question\">
<input type='submit' name='submit_form' value=\"Update\">
</td></tr>";
echo "</table></form>";



?>