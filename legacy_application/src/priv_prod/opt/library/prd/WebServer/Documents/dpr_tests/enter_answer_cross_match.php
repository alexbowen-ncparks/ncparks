<?php
// answer is entered into take_test.php
// option_array_question_7; in take_test.php

if($question_order==7 and $test_id==1)
	{
	$option_array=$option_array_question_7;	
	}
if($question_order==12 and $test_id==1)
	{$option_array=$option_array_question_12;}
	
if($question_order==4 and $test_id==3)
	{$option_array=$option_array_question_3_4;}
	
echo "<tr valign='top'>";
echo "<td>$fld</td>";
if($fld=="question")
	{
	$value=str_replace("procedure", "<font color='green'>Procedure</font>", $value);
	$value=str_replace("appropriate list", "<font color='blue'>appropriate list</font>", $value);
	$value=str_replace("term", "<font color='green'>Term</font>", $value);
	$value=str_replace("definition", "<font color='blue'>Definition</font>", $value);
	
	$value="<b><font color='brown'>$value</font></b>";
	echo "<td colspan='2'>Question $question_order: $value</td>";

	$get_array=array($ARRAY[$question_order]['a'], $ARRAY[$question_order]['b'], $ARRAY[$question_order]['c'], $ARRAY[$question_order]['d']);

	if($test_id==3)
		{
		$get_array=array($ARRAY[$question_order]['a'], $ARRAY[$question_order]['b'], $ARRAY[$question_order]['c']);
		}

	shuffle($get_array);
	foreach($get_array as $k1=>$v1)
		{
		$exp=explode("*",$v1);
		$exp1=explode("|",$exp[0]);
		$new_array[]=$exp[1];
		}
// 	echo "<pre>"; print_r($new_array); echo "</pre>"; // exit;
	}
	else
	{
// 	echo "42<pre>"; print_r($option_array); echo "</pre>"; // exit;
	$answer_array=array("a","b","c","d");
	if($test_id==3)
		{
		$answer_array=array("a","b","c");
		}
	if(in_array($fld, $answer_array))
		{
		$exp_list=explode("|", $value);
		$first=$exp_list[0];
		$exp=explode("*",$exp_list[1]);
		$second=$exp[1]; 
// 		echo "$first $second<pre>"; print_r($exp_list); echo "</pre>"; // exit;
		
		if($test_id==1)
			{
			include("cross_match_test_1.php");
			}
		if($test_id==3)
			{
			include("cross_match_test_3.php");
			}

		}
		
	}
echo "</tr>";

?>