<?php
// echo "<pre>"; print_r($_REQUEST); echo "</pre>"; // exit;
$database="dpr_tests"; 
$dbName="dpr_tests";
include("_base_top.php");


ini_set('display_errors',1);
date_default_timezone_set('America/New_York');
include("../../include/iConnect.inc"); // include iConnect.inc with includes no_inject.php
mysqli_select_db($connection,$dbName);

$sql="SELECT distinct t2.test_id, t1.test_name
FROM test_list as t1
left join completed_tests as t2 on t2.test_id=t1.id
left join scores as t3 on t3.test_id=t1.id
where t3.scored_yes=''
order by t2.test_id
";
$result = @mysqli_query($connection,$sql) or die("$sql Error 1#". mysqli_errno($connection) . ": " . mysqli_error($connection));
if(mysqli_num_rows($result)<1)
	{
	echo "All tests have been scored.";
	echo "<br /><br />To view scored tests click <a href='completed_tests.php'>here</a>.";
	exit;
	}
while($row=mysqli_fetch_assoc($result))
		{$list_of_tests[]=$row;}
// echo "<pre>"; print_r($list_of_tests); echo "</pre>"; // exit;

	$skip=array();
echo "<table cellpadding='10'><tr><td>Tests not scored.</td></tr>";
	foreach($list_of_tests AS $index=>$array)
		{
		if(empty($list_of_tests[$index]['test_id'])){continue;}
		if($index==0)
			{
			echo "<tr>";
			foreach($list_of_tests[0] AS $fld=>$value)
				{
				if(in_array($fld,$skip)){continue;}
				echo "<th>$fld</th>";
				}
			echo "</tr>";
			}
		echo "<tr>";
		foreach($array as $fld=>$value)
			{
			if(in_array($fld,$skip)){continue;}
			if($fld=="test_name")
				{
				$test_id=$array['test_id'];
// 				$test_date=$array['test_date'];
				$value="<a href='view_tests.php?id=$test_id&action=score'>$value</a>";
				}
			echo "<td>$value</td>";
			}
		echo "</tr>";
		}
	echo "</table>";
if(empty($action) and empty($test_date))
	{
// 	echo "hello";
	exit;
	}
$sql="SELECT distinct t1.test_id, t2.test_name, t1.tempID, t1.test_date, t3.full_name
FROM scores as t1
left join test_list as t2 on t1.test_id=t2.id
left join completed_tests as t3 on t3.tempID=t1.tempID
where t1.test_id='$id' and t1.scored_yes !='yes'
order by t1.test_id";

// $sql="SELECT distinct t2.test_id, t1.test_name, t2.test_date, t2.full_name, t2.tempID
// FROM scores as t3
// left join completed_tests as t2 on t2.test_id=t3.test_id
// left join test_list as t1 on t3.test_id=t1.id
// where t3.test_id='$id' and t3.scored_yes !='yes'
// order by t1.id
// ";
// echo "$sql";
$result = @mysqli_query($connection,$sql) or die("$sql Error 1#". mysqli_errno($connection) . ": " . mysqli_error($connection));
while($row=mysqli_fetch_assoc($result))
		{$list[]=$row;}
// echo "<pre>"; print_r($list); echo "</pre>"; // exit;
if(is_array($list))
	{
	$skip=array();
	$c=count($list);
	echo "<table cellpadding='10'><tr><th>Test Takers</th></tr>";
	foreach($list AS $index=>$array)
		{
		if(empty($list[$index]['tempID'])){continue;}
		if($index==0)
			{
			echo "<tr>";
			foreach($list[0] AS $fld=>$value)
				{
				if(in_array($fld,$skip)){continue;}
				echo "<th>$fld</th>";
				}
			echo "</tr>";
			}
		echo "<tr>";
		foreach($array as $fld=>$value)
			{
			if(in_array($fld,$skip)){continue;}
			if($fld=="test_name")
				{
				$test_id=$array['test_id'];
				$test_date=$array['test_date'];
				$tempID=$array['tempID'];
				$tempID=$array['tempID'];
				$value="<a href='view_tests.php?id=$test_id&tempID=$tempID&test_date=$test_date'>$value</a>";
				}
			echo "<td>$value</td>";
			}
		echo "</tr>";
		}
	echo "</table>";
	if(!empty($action))
		{exit;}
	
	}

$question_type_array=array("multiple_choice","true_false","fill_in","cross_match","double_multiple_choice");
$rename_array=array("qid"=>"","question_order"=>"Question Order","question"=>"Question","a"=>"A","b"=>"B","c"=>"C","d"=>"D","answer"=>"Answer","comment"=>"Comment","question_type"=>"Question Type");

if(!empty($_POST['submit_score']))
	{
	foreach($_POST['score'] as $question_order=>$val)
		{
		$sql="REPLACE scores set tempID='$tempID', test_id='$test_id', question_order='$question_order', score='$val', test_date='$test_date', scored_yes='yes'";
		
		$result = @mysqli_query($connection,$sql) or die("$sql Error 1#". mysqli_errno($connection) . ": " . mysqli_error($connection));
		}
	echo "Scores for $tempID for test #$test_id on $test_date have been entered."; // exit;
	}
	
	
if(empty($test_id) or empty($test_date) or empty($tempID))
	{
	$sql = "SELECT distinct t2.test_name, t1.test_id, t1.test_date, t1.tempID, t1.full_name
	FROM completed_tests as t1 
	left join test_list as t2 on t1.test_id=t2.id
	where 1 and t1.tempID='$tempID' and t1.test_id='$test_id'"; 
	if(!empty($id))
		{
		$sql = "SELECT distinct t2.test_name, t1.test_id, t1.test_date, t1.tempID, t1.full_name
		FROM completed_tests as t1 
		left join test_list as t2 on t1.test_id=t2.id
		where t1.test_id='$id'"; 
		}
	$result = @mysqli_query($connection,$sql) or die("$sql Error 1#". mysqli_errno($connection) . ": " . mysqli_error($connection));
	while($row=mysqli_fetch_assoc($result))
		{
		$ARRAY[]=$row;
		}
// echo "89 <pre>"; print_r($ARRAY); echo "</pre>";  exit;

if(empty($ARRAY)){echo "No tests taken yet."; exit;}

$skip=array("tempID","test_id");
$sql="SELECT * from questions where test_id='$id'";
$result = @mysqli_query($connection,$sql);
$num_questions=mysqli_num_rows($result);


echo "<form action='view_tests.php' method='POST'>
<table border='1' cellpadding='10'>";
	foreach($ARRAY AS $index=>$array)
		{
		if($index==0)
			{
			echo "<tr><td></td>";
			foreach($ARRAY[0] AS $fld=>$value)
				{
				if(in_array($fld,$skip)){continue;}
				echo "<th>$fld</th>";
				}
			echo "</tr>";
			}
		echo "<tr><td>".($index+1)."</td>";
		foreach($array as $fld=>$value)
			{
			if(in_array($fld,$skip)){continue;}
			$tempID=$array['tempID'];
			$test_id=$array['test_id'];
			$test_date=$array['test_date'];
			if($fld=="full_name")
				{
				$value="Score test for <a href='view_tests.php?tempID=$tempID&test_id=$test_id&test_date=$test_date&num_questions=$num_questions'> $value</a>";
				}
			echo "<td>$value</td>";
			}
		$sql="SELECT sum(t4.score) as score, t2.points
		FROM completed_tests as t1 
		left join test_list as t2 on t1.test_id=t2.id 
		left join scores as t4 on t1.question_order=t4.question_order and t4.tempID=t1.tempID and t4.test_id='$test_id'
		where t4.tempID='$tempID' and t2.id='$test_id' and t4.test_date='$test_date' and t1.question_order>0 order by t1.question_order";
// 		echo "$sql<br />";
	$result = @mysqli_query($connection,$sql) or die("$sql Error 1#". mysqli_errno($connection) . ": " . mysqli_error($connection));
	$row=mysqli_fetch_assoc($result);
	$score=$row['score'];
	$points=$row['points'];
	if($points>0){
			echo "<td> $score of $points Points = ".($percent=number_format(($score/$points),2)*100)."%</td>";}

		echo "</tr>";
		}
	echo "</table>";
	exit;
	}
// echo "<pre>"; print_r($_REQUEST); echo "</pre>";  exit;

$sql="SELECT * FROM scores where tempID='$tempID' and test_id='$test_id' and test_date='$test_date'";
$result = @mysqli_query($connection,$sql);
if(mysqli_num_rows($result)<1)  // if first time scoring add tracking records to scores
	{
	for($i=1;$i<=$num_questions;$i++)
		{
		$sql="INSERT INTO scores set tempID='$tempID', test_id='$test_id', test_date='$test_date', question_order='$i'";
		$result = @mysqli_query($connection,$sql);
		}	
	}

// echo "<pre>"; print_r($_REQUEST); echo "</pre>"; // exit;
$id=$_REQUEST['id'];
$test_date=$_REQUEST['test_date'];
$tempID=$_REQUEST['tempID'];
$sql = "SELECT t1.id, t4.tempID, t1.full_name, t4.test_date, t4.question_order, t1.answer as answer_given , t2.test_name, t3.answer as correct_answer, substring_index(t3.question,'(',-1) as points, t4.score

FROM completed_tests as t1 

left join test_list as t2 on t1.test_id=t2.id 

left join questions as t3 on t1.question_order=t3.question_order and t1.test_id=t3.test_id

left join scores as t4 on t1.test_id=t4.test_id and t1.question_order=t4.question_order and t4.tempID=t1.tempID 

where t1.test_date='$test_date' and t1.test_id='$id' and t1.tempID='$tempID' and t1.question_order>0 
order by t1.question_order";

$result = @mysqli_query($connection,$sql) or die("$sql Error 1#". mysqli_errno($connection) . ": " . mysqli_error($connection));
// echo "$sql";
while($row=mysqli_fetch_assoc($result))
	{
	$ARRAY[$row['question_order']]=$row;
	}
$c=count($ARRAY);  
$skip=array("id","tempID","test_name","full_name","test_date");
$c=count($ARRAY);
$tot_points=0;
$tot_score=0;
$test_name=$ARRAY[1]['test_name'];
$test_date=$ARRAY[1]['test_date'];
$full_name=$ARRAY[1]['full_name'];
echo "<form action='view_tests.php' method='POST'>";
echo "<table border='1'>
<tr bgcolor='#d4d4aa'><th colspan='8'>$test_name has $c questions.</th></tr>
<tr bgcolor='#e5e5cc'><th colspan='8'>$full_name took the test on $test_date.</th>
<tr bgcolor='#ffb366'><th colspan='8'>It is important to complete the scoring for this person before leaving the page.</th>
</tr>";
foreach($ARRAY AS $index=>$array)
	{
	if($index==1)
		{
		echo "<tr>";
		foreach($ARRAY[1] AS $fld=>$value)
			{
			if(in_array($fld,$skip)){continue;}
			$var_fld=str_replace("_", " ",$fld);
			echo "<th>$var_fld</th>";
			}
		echo "</tr>";
		}
	echo "<tr>";
	foreach($array as $fld=>$value)
		{
		if(in_array($fld,$skip)){continue;}
		$td="";
		if($fld=="question_order")
			{
			if(empty($array['score']))
					{
					$td=" bgcolor='red'";
					}
			}
		if($fld=="points")
			{
			$value=substr($value,0,1);
			$tot_points+=$value;
			}
		if($fld=="score")
			{
			if(empty($value))
				{
				$val="0";
				if(strtoupper($array['answer_given'])==strtoupper($array['correct_answer']))
					{
					$val=substr($array['points'],0,1);
					$tot_score+=$val;
					}
			$td=" bgcolor='red'";	
			if($val==substr($array['points'],0,1))
					{
					$td=" bgcolor='green'";
					}
				$value="<input type='text' name='score[$array[question_order]]' value=\"$val\" size='3'>";
				}
				else
				{
				$tot_score+=$value;

				$value="<input type='text' name='score[$array[question_order]]' value=\"$value\" size='3'>";
				}
			}
		echo "<td$td>$value</td>";
		}
	echo "</tr>";
	}
$percent=number_format(($tot_score/$tot_points),2)*100;
echo "<tr><td colspan='4' align='right'>$tot_points</td><td >$tot_score</td><td>$percent%</td></tr>";

echo "<tr><td colspan='6' align='center'>
<input type='hidden' name='tempID' value=\"$tempID\">
<input type='hidden' name='id' value=\"$test_id\">
<input type='hidden' name='test_id' value=\"$test_id\">
<input type='hidden' name='test_date' value=\"$test_date\">
<input type='submit' name='submit_score' value=\"Submit Scores\">
</td></th>";
echo "</table></form>";
if($level>2)
	{
	echo "<form method='post' action='delete_test.php' onclick=\"javascript:return confirm('Are you sure you want to delete this test?')\"><table><tr><td>
	<input type='hidden' name='tempID' value=\"$tempID\">
	<input type='hidden' name='id' value=\"$test_id\">
	<input type='hidden' name='test_id' value=\"$test_id\">
	<input type='hidden' name='test_date' value=\"$test_date\">
	<input type='submit' name='submit_form' value=\"Delete This Test\">
	</td></tr></table></form>";
	}
?>