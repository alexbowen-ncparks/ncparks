<?php
// ****************** Add Question Form ***************
// echo "7 add<pre>"; print_r($_POST); echo "</pre>"; // exit;
if(!empty($submit_form))
	{
	if($submit_form=="Add")
		{
		$skip=array("submit_form", "qid","page");
		$upper=array("answer");
// 		echo "21 s=$submit_form<pre>"; print_r($_POST); echo "</pre>";  exit;
		
		if($_POST['question_type']!="cross_match" and $_POST['question_type']!="checkbox" and $_POST['question_type']!="double_multiple_choice")
			{
			FOREACH($_POST as $fld=>$value)
				{
				if(in_array($fld,$skip)){continue;}
				if(in_array($fld,$upper))
					{
					$value=strtoupper($value);
					}
				$value=str_replace("\R\N", "<br />", $value);
				$temp[]="`".$fld."`='".$value."'";
				}
			}
		if($_POST['question_type']=="cross_match")
			{
			unset($temp);
			$match_array=array("a","b","c","d");
// 			echo "<pre>"; print_r($_POST); echo "</pre>";  //exit;
			
			FOREACH($_POST as $fld=>$value)
				{
				if(in_array($fld,$skip)){continue;}
				if(in_array($fld,$upper))
					{
					$value=strtoupper($value);
					}
				if(is_array($value))
					{
					$var="|".$fld."*";
					$value=implode($var,$value);
					$temp[]="`".$fld."`='".$value."'";
					}
					else
					{
					$temp[]="`".$fld."`='".$value."'";
					}
				}
			}
			
			
		if($_POST['question_type']=="checkbox")
			{
			unset($temp);
			$match_array=array("a","b","c","d");
// 			echo "<pre>"; print_r($_POST); echo "</pre>";  //exit;
			
			FOREACH($_POST as $fld=>$value)
				{
				if(in_array($fld,$skip)){continue;}
				if(in_array($fld,$upper))
					{
					$value=strtoupper($value);
					}
				if(is_array($value))
					{
					$var="|".$fld."*";
					$value=implode($var,$value);
					$temp[]="`".$fld."`='".$value."'";
					}
					else
					{
					$temp[]="`".$fld."`='".$value."'";
					}
				}
			}
			
		if($_POST['question_type']=="double_multiple_choice")
			{
			unset($temp);
			
			}
		$clause=implode(", ",$temp);

		$sql="INSERT INTO questions set $clause "; 
// 			echo "$sql"; exit;
		$result = mysqli_query($connection,$sql) or die("$sql Error 1#". mysqli_errno($connection) . ": " . mysqli_error($connection));
		$test_number=$test_id;
		$list_questions="yes";
		$submit_form="";
		include("edit_question.php");
		exit;
		}
		
		
		
	$sql = "SELECT t1.* , t2.test_name
	FROM questions as t1 
	left join test_list as t2 on t1.test_id=t2.id
	where t1.test_id='$id'
	order by t1.qid desc"; 
	$result = @mysqli_query($connection,$sql) or die("$sql Error 1#". mysqli_errno($connection) . ": " . mysqli_error($connection));
	while($row=mysqli_fetch_assoc($result))
		{
		$test_questions[]=$row;
		}
	if(!empty($test_questions))
		{
		$c=count($test_questions);
		}
	if(empty($test_questions))
		{
		$sql="INSERT INTO questions set test_id='$id', question_order=1"; 
		$result = @mysqli_query($connection,$sql) or die("$sql Error 1#". mysqli_errno($connection) . ": " . mysqli_error($connection));
		$sql = "SELECT t1.* , t2.test_name
		FROM questions as t1 
		left join test_list as t2 on t1.test_id=t2.id
		where t1.test_id='$id'
		order by t1.qid desc"; 
		$result = @mysqli_query($connection,$sql) or die("$sql Error 1#". mysqli_errno($connection) . ": " . mysqli_error($connection));
		while($row=mysqli_fetch_assoc($result))
			{
			$test_questions[]=$row;
			}
		$sql = "DELETE
		FROM questions
		where test_id='$id' and question_order='1'"; 
		$result = @mysqli_query($connection,$sql) or die("$sql Error 1#". mysqli_errno($connection) . ": " . mysqli_error($connection));
		}
		
// 	echo "<pre>"; print_r($test_questions); echo "</pre>"; // exit;
	$test_name=$test_questions[0]['test_name'];
	$skip=array("test_id", "test_name","page","qid");
	
	if(empty($c))
		{
		$c=0;
		}

// 	echo "27 add<pre>"; print_r($_REQUEST); echo "</pre>"; // exit;

	echo "<table><tr><td colspan='2'><h3>
	<font color='#8cd9b3'>New Question #".($c+1)." for $test_name</font></h3>
	</td></tr>";
	if(empty($test_questions[$c+1]['question_type']))
		{
		if(empty($question_type))
			{
			echo "<form method='POST' action='test.php'><table>
			<tr><td>
			Question Type: <select name='question_type' onchange=\"this.form.submit()\">
			<option value=\"\" selected></option>\n";
			foreach($question_type_array as $k=>$v) // defined in test.php
				{
				echo "<option value='$v'>$v</option>";
				}

			echo "</select></td><td>
			<input type='hidden' name='page' value=\"add_question\">
			<input type='hidden' name='id' value=\"$test_number\">
			<input type='hidden' name='submit_form' value=\"add_question\">
			</td></tr>
			</table></form>";
			exit;
			}
		}
// 	echo "<pre>"; print_r($_POST);  print_r($question_type_array); echo "</pre>"; // exit;
	$single_answer=array("true_false","multiple_choice","fill_in","");
// 	echo "<pre>"; print_r($test_questions); echo "</pre>";  exit;
	echo "<form method='POST' action='test.php'><table>";
	foreach($test_questions[0] AS $fld=>$val)
		{
		if(in_array($fld,$skip)){continue;}
		echo "<tr><td>$rename_array[$fld]</td>";
							
		$cols=100; $rows=2;
		if($fld=="question_order"){$cols=2; $rows=1;}
		$value="";
		if($fld=="question_order"){$value=$c+1;}

		if($fld!="question_type")
			{
			if($question_type=="cross_match" or $question_type=="checkbox")
				{
// 				include("cross_match.php");
				if($question_type=="cross_match"){include("cross_match.php");}
				if($question_type=="checkbox"){include("checkbox.php");}
				}
				else
				{
				echo "<td><textarea name='$fld' cols='$cols' rows='$rows'>$value</textarea></td>";
				}
			}
			else
			{
			include("question_type.php");
			}

		echo "</tr>";
		}
	if(!empty($id)){$test_number=$id;}
	echo "<tr><td colspan='2' align='center'>
	<input type='hidden' name='test_id' value=\"$test_number\">
	<input type='hidden' name='page' value=\"add_question\">
	<input type='submit' name='submit_form' value=\"Add\">
	</td></tr>";
	echo "</table></form>";
	}
	
echo "</html>";
?>
