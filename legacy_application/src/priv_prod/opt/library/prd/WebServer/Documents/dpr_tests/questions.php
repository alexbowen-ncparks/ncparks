<?php

// echo "<pre>"; print_r($_POST); echo "</pre>"; exit;
ini_set('display_errors',1);
date_default_timezone_set('America/New_York');
// echo "<pre>"; print_r($_POST); echo "</pre>"; // exit;
if(empty($connection))
	{
	$database="dpr_tests"; 
	$dbName="dpr_tests";
include("../../include/auth.inc"); // include iConnect.inc with includes no_inject.php
	include("_base_top.php");

	include("../../include/iConnect.inc"); // include iConnect.inc with includes no_inject.php
	mysqli_select_db($connection,$dbName);
	}
	$fld_rename=array("test_id"=>"Test number","question_order"=>"Question Order","question_order"=>"Question Number","question"=>"Question","a"=>"A","b"=>"B","c"=>"C","d"=>"D","answer"=>"Answer","comment"=>"Comment");
	
	$sql="SELECT t1.*, t2.test_name 
	FROM questions as t1
	left join test_list as t2 on t1.test_id=t2.id
	WHERE test_id='$id'
	order by t1.question_order"; 
// 	echo "$sql"; 
// 	exit;
	$result = mysqli_query($connection,$sql) or die("$sql");
	while($row=mysqli_fetch_assoc($result))
		{
		$ARRAY_edit[]=$row;
		}
	$edit_array=array("question","a","b","c","d","comment");
	$c=count($ARRAY_edit);
	
// 	echo "<pre>"; print_r($ARRAY_edit); echo "</pre>"; // exit;
	
	$skip=array("test_id","qid","test_name");
$c=count($ARRAY_edit);
echo "<table cellpadding='5'><tr><td colspan='12'><h3>The $c questions for ".$ARRAY_edit[0]['test_name']."</h3></td></tr>";
foreach($ARRAY_edit AS $index=>$array)
	{
	if($index==0)
		{
		echo "<tr>";
		foreach($ARRAY_edit[0] AS $fld=>$value)
			{
			if(in_array($fld,$skip)){continue;}
			echo "<th>$fld_rename[$fld]</th>";
			}
		echo "</tr>";
		}
	echo "<tr valign='top'>";
	foreach($array as $fld=>$value)
		{
		if(in_array($fld,$skip)){continue;}
		if($fld=="question_order")
			{
			$qid=$array['qid'];
			$test_id=$array['test_id'];
			$value="<a href='add_question.php?select_question=$test_id&qid=$qid'>[$value]</a>";
			}
		echo "<td>$value</td>";
		}
	echo "</tr>";
	}
echo "</table>";
	// ****************** Add Question Form ***************

$sql = "SELECT t1.* , t2.test_name
FROM questions as t1 
left join test_list as t2 on t1.test_id=t2.id
where t1.test_id='$id'"; 
$result = @mysqli_query($connection,$sql) or die("$sql Error 1#". mysqli_errno($connection) . ": " . mysqli_error($connection));
while($row=mysqli_fetch_assoc($result))
	{
	$test_questions[]=$row;
	}
$test_name=$test_questions[0]['test_name'];
$skip=array("test_id", "test_name","qid");

$c=count($test_questions);

// echo "<pre>"; print_r($_REQUEST); echo "</pre>"; // exit;
echo "<form method='POST' action='add_question.php'>";
echo "<table><tr><td colspan='2'><h3>
<font color='#8cd9b3'>New Question #".($c+1)." for $test_name</font></h3>
</td></tr>";

echo "<table>";
foreach($test_questions[0] AS $fld=>$val)
	{
	if(in_array($fld,$skip)){continue;}
	echo "<tr><td>$fld_rename[$fld]</td>";
	$cols=100; $rows=2;
	if($fld=="question_order" or $fld=="answer"){$cols=2; $rows=1;}
	$value="";
	if($fld=="question_order"){$value=$c+1;}
	echo "<td><textarea name='$fld' cols='$cols' rows='$rows'>$value</textarea></td>";

	echo "</tr>";
	}
echo "<tr><td colspan='2' align='center'>
<input type='hidden' name='test_id' value=\"$id\">
<input type='submit' name='submit_form' value=\"Add\">
</td></tr>";
echo "</table></form>";
echo "</table>";




// 	echo "<form name='q	uestions' action='questions.php' method='POST'><table><tr><td colspan='3'>Edit Question</td></tr>";
// 	foreach($ARRAY_edit[0] AS $fld=>$value)
// 		{
// 		echo "<tr>";
// 			if(in_array($fld,$skip_edit)){continue;}
// 			echo "<td valign='top'>$fld_rename[$fld]</td>";
// 			if(in_array($fld,$edit_array))
// 				{
// 				$value="<textarea name='$fld' cols='100' rows='3'>$value</textarea>";
// 				if($fld=="question")
// 					{
// 					$value="<b>".$ARRAY_edit[0]['question']."</b><br />".$value;
// 					}
// 				if(strtoupper($fld)==$ARRAY_edit[0]['answer'])
// 					{
// 					$value="<font color='green'>".$ARRAY_edit[0]['answer']." is the correct answer</font><br />".$value;
// 					}
// 				}
// 				
// 			if($fld=="answer"){$value="<input type='text' name='$fld' value=\"$value\" size='3'>";}
// 			
// 		echo "<td>$value</td>";
// 		echo "</tr>";
// 		}
// 		echo "<tr><td colspan='3' align='center'>
// 		<input type='hidden' name='test_id' value=\"$id\">
// 		<input type='submit' name='submit_edit' value=\"Update\">
// 		</td></tr>";
// 	echo "</table></form>";

?>