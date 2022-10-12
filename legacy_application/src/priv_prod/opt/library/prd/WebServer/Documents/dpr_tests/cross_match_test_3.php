<?php
// echo "2<pre>"; print_r($new_array); echo "</pre>"; // exit;
if($question_order==4 and $test_id==3)
	{
	$val="";
	if(!empty($answer))
		{
		$val=$answer_submitted[$fld];
		}
	$send_answer="<input type='text' name='send_answer[$fld]' value=\"$val\" size='2'>";
	$shim="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
	$value="<b><font color='blue'>$shim".strtoupper($fld).".&nbsp;$first</font></b>";
	$value.="</td><td>$send_answer <font color='green'>$second</font>";
	echo "<td>$value</td>";
	}
	
// if($question_order==12 and $test_id==3)
// 	{
// 	$val="";
// 	if(!empty($answer))
// 		{
// 		$val=$answer_submitted[$fld];
// 		}
// 	if($val=="Direct"){$ckd="checked";}else{$ckd="";}
// 	if($val=="Indirect"){$cki="checked";}else{$cki="";}
// 	$send_answer="<input type='radio' name='send_answer[$fld]' value=\"Direct\" $ckd>Direct";
// 	$send_answer.="<input type='radio' name='send_answer[$fld]' value=\"Indirect\" $cki>Indirect";
// 	$shim="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
// 	$value="<b><font color='blue'>$shim".strtoupper($fld).". $first</font></b>";
// 	$value.="</td><td><font color='green'>$send_answer</font>";
// 	echo "<td>$value</td>";
// 	}
?>