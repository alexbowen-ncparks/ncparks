<?php
// answer is entered into take_test.php
// echo "3<pre>"; print_r($ARRAY); echo "</pre>"; // exit;

$answer_array=array("a","b","c","d","e");
$checkbox_answers=explode(",", $answer);

if($ARRAY[$question_order][$fld]!="")
	{
	echo "<tr valign='top'>";
	echo "<td>$fld</td>";
	if($fld=="question")
		{
		$value="<b><font color='brown'>$value</font></b>";
		echo "<td>Question $question_order: $value</td>";
		}
	else
		{
		if(in_array($fld, $answer_array))
			{
			if(in_array($fld,$checkbox_answers)){$ck="checked";}else{$ck="";}
			$var_answer="<input type='checkbox' name='answer[]' value=\"$fld\" $ck>";
			$shim="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
			$value="<b><font color='blue'>$shim$var_answer$shim".strtoupper($fld).". $value</font></b>";
		echo "<td>$value</td>";
			}
		}
	echo "</tr>";
	}
?>