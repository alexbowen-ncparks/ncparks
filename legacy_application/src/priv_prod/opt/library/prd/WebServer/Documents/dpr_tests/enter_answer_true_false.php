<?php
// answer is entered into take_test.php
echo "<tr valign='top'>";
// echo "<td>$fld</td>";
if($fld=="question")
	{
	$value="<b><font color='brown'>$value</font></b>";
	echo "<td>Question $question_order: $value</td>";
	}
	else
	{
	$answer_array=array("a");
	$val=$answer_submitted['a'];
	
	if($val=="T"){$ckd="checked";}else{$ckd="";}
	if($val=="F"){$cki="checked";}else{$cki="";}
	if(in_array($fld, $answer_array))
		{
		// For all T or F we use the a field to capture the answer and then send that value to completed tests using the answer field
		$value="<font color='green'>Enter Answer:</font>
		<input type='radio' name='answer' value=\"T\" $ckd>True
		<input type='radio' name='answer' value=\"F\" $cki>False";
echo "<td>$value</td>";
		}
	}

echo "</tr>";
?>