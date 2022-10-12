<?php
$db="dpr_tests";
// echo "<pre>"; print_r($_SESSION); echo "</pre>";  //exit;
// echo "<pre>"; print_r($_REQUEST); echo "</pre>";  //exit;
if(!empty($_SESSION[$db]['test_id']))
	{
	$test=$_SESSION[$db]['test_id'];
	}
	else
	{
	$_SESSION[$db]['test_id']=$test_id;
	}
$tempID=$_SESSION[$db]['tempID'];
// echo "<pre>"; print_r($_SESSION); echo "</pre>"; // exit;
if(!empty($submit_answer))
	{
// echo "<pre>"; print_r($_POST); echo "</pre>"; exit;
	if(!empty($send_answer)){$answer=implode(",",$send_answer);}
	if(empty($answer))
		{
		echo "<font color='red'>You failed to indicate an answer.</font><br />";
// 		exit;
		}
		else
		{
		$test_date=date('Y-m-d');
		$full_name=$_SESSION[$db]['full_name'];
		if(!empty($pass_tempID))
			{
			$sql = "SELECT full_name from completed_tests where
			tempID='$pass_tempID' and test_id='$test_id' and question_order='$question_order'"; 
// 			echo "$sql"; //exit;
			$result = @mysqli_query($connection,$sql);
			$row=mysqli_fetch_assoc($result);
			$full_name=$row['full_name'];
			$tempID=$pass_tempID;
			}
		if(is_array($answer))
			{
			$answer=implode(",",$answer);
			}
		$sql = "REPLACE completed_tests set 
		tempID='$tempID', full_name='$full_name', test_date='$test_date', test_id='$test_id', answer='$answer', question_order='$question_order'"; 
// 	echo "$sql<br />"; //exit;
		$result = @mysqli_query($connection,$sql);
		$test=mysqli_error($connection);
	if(strpos($test,"Duplicate entry")>-1)
			{
			echo "You are trying to take the test for a second time.";
			echo "<br /><br />If you need to re-take the test, contact Thomas Crate.";
			unset($_SESSION['dpr_tests']);
			unset($_SESSION['logname']);
			exit;
			}
		$_SESSION[$db]['question_order']=($question_order);
		$next=$_SESSION[$db]['question_order']+1;
		if($next>$_SESSION[$db]['num_questions'])
			{
			$_SESSION[$db]['completed']="yes";
			echo "You have answered the ".($next-1)." questions for the ".$_SESSION[$db]['test_name']." test.<br />";
			echo "You can <a href='test.php?com=1&test_id=$test_id&page=test'>review your answers</a> and make any changes.<br />";
			exit;
			}
		if(empty($_SESSION[$db]['completed']))
			{
			echo "Go to the <a href='test.php?page=test&question_order=$next&test_id=$test_id&take=taking''>Next Question: $next.</a>";
			}
			else
			{
			echo "You can <a href='/dpr_tests/test.php?com=1&test_id=$test_id&page=test'>review your answers</a> and make any changes.";
			echo "You can <a href='/dpr_tests/test.php?com=1&test_id=$test_id&page=test'>review your answers</a> and make any changes.";
			}
			exit;
		}
	}
if(!empty($submit_form))
	{
	if($submit_form=="Begin")
		{
		$test_date=date('Y-m-d');
		$_SESSION[$db]['test_id']=$test_id;
		$_SESSION[$db]['test_date']=$test_date;
		$_SESSION[$db]['question_order']=0;
		$full_name=$_SESSION[$db]['full_name'];
		
		$_SESSION[$db]['test_taker_tempID']=$tempID;
		$question_order=1; // set this up so answer to question 1 is ready
		$sql = "INSERT INTO completed_tests set question_order='$question_order',
		tempID='$tempID', full_name='$full_name', test_date='$test_date', test_id='$test_id'"; 

		$result = @mysqli_query($connection,$sql);
		$test_result=mysqli_error($connection);
	if(strpos($test_result,"Duplicate entry")>-1)
		{
		echo "You are trying to take the test for a second time.";
		echo "<br /><br />If you need to re-take the test, contact Thomas Crate.";
		unset($_SESSION['dpr_tests']);
		unset($_SESSION['logname']);
// 		echo "<pre>"; print_r($_SESSION); echo "</pre>"; // exit;
		exit;
		}
		if(!empty($test_result)){echo "$test";}
		
		}
	}
$rename_array=array("qid"=>"","question_order"=>"Question Order","question"=>"Question","a"=>"A","b"=>"B","c"=>"C","d"=>"D","answer"=>"Answer","comment"=>"Comment");

if(!empty($test_id))
	{
	$sql = "SELECT t1.* , t2.test_name, t2.points
		FROM questions as t1 
		left join test_list as t2 on t1.test_id=t2.id
		where t2.id='$test_id'"; 

		$result = @mysqli_query($connection,$sql) or die("$sql Error 1#". mysqli_errno($connection) . ": " . mysqli_error($connection));
		while($row=mysqli_fetch_assoc($result))
			{
			$ARRAY[$row['question_order']]=$row;
			}
	$_SESSION[$db]['test_name']=$ARRAY[1]['test_name'];
// echo "<pre>"; print_r($ARRAY); echo "</pre>"; // exit;

	$sql = "SELECT max(t1.question_order) as max
		FROM completed_tests as t1 
		where t1.test_id='$test_id'"; 
// 		echo "$sql";
		$result = @mysqli_query($connection,$sql) or die("$sql Error 1#". mysqli_errno($connection) . ": " . mysqli_error($connection));
		while($row=mysqli_fetch_assoc($result))
			{
			$max_question=$row['max'];
			}
		
	$skip=array("qid","test_id","test_quote","test_name");
	
if(empty($question_order))
	{$question_order=1;}
// echo "118 $question_order YYYYYYYYYYYY"; //exit;

$c=count($ARRAY);
$_SESSION[$db]['num_questions']=$c;

if($level>4)
	{
	$take_test="<th><a href='test.php?page=test&test_id=$test_id'>Take Test</a></th>";
	}
	else
	{$take_test="";}
	
if(empty($_SESSION[$db]['test_date']))
	{
	$points=$ARRAY[1]['points'];
	echo "<table>";
	
	echo "<tr><th>Final Examination for ".$ARRAY[1]['test_name']."</br>
$c Questions -- $points Points Total</br></br>
Students may utilize any references made available during course presentation to answer the questions.</th></tr>";
	echo "<tr><td>Once started you will need to <b>complete the entire test</b> or it will <font color='red'>not be accepted</font>. You cannot come back to it once you leave it. If you are not positive you have the time to complete the test, please do not start. It is estimated to take around 30 minutes to complete.</td></tr> ";
	echo "<tr><th>
	<form method='POST' action='test.php'>
	<input type='hidden' name='take' value=\"1\">
	<input type='hidden' name='test_id' value=\"$test_id\">
	<input type='hidden' name='page' value=\"test\">
	<input type='submit' name='submit_form' value=\"Begin\">
	</form>
	</th></tr>";
	echo "</table>";
	exit;
	}
// echo "$question_order YYYYYYYYYYYY"; //exit;
if(empty($_SESSION[$db]['question_order']))
	{
	$_SESSION[$db]['question_order']=1;
	$question_order=1;
	}
	else
	{
	if(!empty($pass_tempID))
		{
		$sql = "SELECT answer
		FROM completed_tests
		where test_id='$test_id' and question_order='$question_order' and tempID='$pass_tempID'"; 
		$result = @mysqli_query($connection,$sql) or die("$sql Error 1#". mysqli_errno($connection) . ": " . mysqli_error($connection));
// 		echo "$sql";
		$row=mysqli_fetch_assoc($result);
		$answer=$row['answer'];
		}
	$_SESSION[$db]['view_question']=($question_order);
	}
// echo "<br />Line 170 take_test";  
// echo "<br />Line 161 take_test<pre>"; print_r($ARRAY[$question_order]); echo "</pre>";  

// echo "<pre>"; print_r($_SESSION); print_r($ARRAY); echo "</pre>"; // exit;

$option_array_question_7=array("a" => "Survivable without a fire shelter.","b" => "Keep at least 100 gallons of water in reserve.","c" => "Fireline will not lie in or adjacent to a chute or chimney.","d" => "Assess defensible space, i.e., surrounding wildland vegetation.");
$option_array_question_12=array("a" => "Direct/Indirect","b" => "Direct/Indirect","c" => "Direct/Indirect","d" => "Direct/Indirect");


$option_array_question_3_4=array("a" => "Spotting","b" => "Smoldering","c" => "Running");


$skip_fld=array("qid","test_id","question_order","answer","comment","question_type","test_name");

echo "<form action='test.php' method='POST'>";
echo "<table border='1'><tr><th colspan='8'>".$ARRAY[1]['test_name']." has $c questions. </th>$take_test</tr>";

// echo "<pre>"; print_r($ARRAY); echo "</pre>"; // exit;
$question_order=$ARRAY[$question_order]['question_order'];
if(empty($answer)){$answer="";}
if($ARRAY[$question_order]['question_type']=="true_false")
	{
	$answer_submitted['a']=$answer;
// 	echo "<pre>"; print_r($answer_submitted); echo "</pre>"; // exit;
	}
	
if($question_order==7 and $test_id==1)
	{
	$answer_array=array("a","b","c","d");
	$exp_answer=explode(",", $answer);
	foreach($exp_answer as $k_a=>$v_a)
		{
		$xx=array_shift($answer_array);
		$answer_submitted[$xx]=$v_a;
		}
// 	echo "<pre>"; print_r($answer_submitted); echo "</pre>"; // exit;
	}
if($question_order==12 and $test_id==1)
	{
	$answer_array=array("a","b","c","d");
	$exp_answer=explode(",", $answer);
	foreach($exp_answer as $k_a=>$v_a)
		{
		$xx=array_shift($answer_array);
		$answer_submitted[$xx]=$v_a;
		}
// 	echo "<pre>"; print_r($answer_submitted); echo "</pre>"; // exit;
	}

if($question_order==4 and $test_id==3)
	{
	$answer_array=array("a","b","c");
	$exp_answer=explode(",", $answer);
	foreach($exp_answer as $k_a=>$v_a)
		{
		$xx=array_shift($answer_array);
		$answer_submitted[$xx]=$v_a;
		}
// 	echo "246<pre>"; print_r($answer_submitted); echo "</pre>"; // exit;
	}	
foreach($ARRAY[$question_order] AS $fld=>$value)
	{
	if(in_array($fld, $skip_fld)){continue;}
	if($ARRAY[$question_order]['question_type']=="multiple_choice")
		{
		include("enter_answer_multiple_choice.php");
		}
	if($ARRAY[$question_order]['question_type']=="fill_in")
		{
		include("enter_answer_fill_in.php");
		}
	if($ARRAY[$question_order]['question_type']=="true_false")
		{
		include("enter_answer_true_false.php");
		}
	if($ARRAY[$question_order]['question_type']=="cross_match")
		{
		include("enter_answer_cross_match.php");
		}
	if($ARRAY[$question_order]['question_type']=="checkbox")
		{
		include("enter_answer_checkbox.php");
		}
	}
if(empty($pass_tempID)){$pass_tempID="";}
echo "<tr><td colspan='4' align='center'>
<input type='hidden' name='take' value=\"taking\">
<input type='hidden' name='page' value=\"test\">
<input type='hidden' name='pass_tempID' value=\"$pass_tempID\">
<input type='hidden' name='tempID' value=\"$tempID\">
<input type='hidden' name='question_order' value=\"$question_order\">
<input type='hidden' name='test_id' value=\"$test_id\">
<input type='submit' name='submit_answer' value=\"Submit Answer\">
</td></th>";
echo "</table></form>";
}
	

?>