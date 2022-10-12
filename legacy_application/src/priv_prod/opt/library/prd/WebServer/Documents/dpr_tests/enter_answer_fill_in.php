<?php
// answer is entered into take_test.php
echo "<tr valign='top'>";
// echo "<td>$fld</td>";
if($fld=="question")
	{
	$value=nl2br($value);
	$value="<b><font color='brown'>$value</font></b>";
	echo "<td>Question $question_order: $value</td>";
	}
	else
	{
	$answer_array=array("a");
	$var_answer="";
	if(!empty($answer)) // obtained from take_test ~line 157
		{$var_answer=$answer;}
	if(in_array($fld, $answer_array))
		{
		// For all fill ins we use the a field to capture the answer and then send that value to completed tests using the answer field
		$value="<font color='green'>Enter Answer:</font> <textarea name='answer' cols='117' rows='2'>$var_answer</textarea>";
echo "<td>$value</td>";
		}
	}

echo "</tr>";
?>