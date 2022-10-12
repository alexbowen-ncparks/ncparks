<?php
// echo "2 edit <pre>"; print_r($_REQUEST); echo "</pre>"; // exit;
// $rename_array=array("qid"=>"","question_order"=>"Question Order","question"=>"Question","a"=>"A","b"=>"B","c"=>"C","d"=>"D","answer"=>"Answer","comment"=>"Comment","question_type"=>"Question Type");

if(empty($test_number))
	{
	$sql="SELECT * from test_list"; 
	$result = mysqli_query($connection,$sql) or die("$sql Error 1#". mysqli_errno($connection) . ": " . mysqli_error($connection));
	while($row=mysqli_fetch_assoc($result))
		{
		$ARRAY[]=$row;
		}
	$skip=array("pid","id","test_quote","status");
	$c=count($ARRAY);
	echo "<table><tr><td colspan='1'>Number of Tests: $c</td><td><b>Select Test to Add/Edit Question(s)</b></td></tr>";
	foreach($ARRAY AS $index=>$array)
		{
		if($index==0)
			{
			echo "<tr>";
			foreach($ARRAY[0] AS $fld=>$value)
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
				$id=$array['id'];
				$value="<a href='test.php?page=edit_question&test_number=$id&list_questions=yes&id=$id'>$value</a>";
				}
			echo "<td>$value</td>";
			}
		echo "</tr>";
		}
	echo "</table>";
	}
	else
	{
	if(!empty($test_number))
		{
		$sql = "SELECT t1.* , t2.test_name
		FROM questions as t1 
		left join test_list as t2 on t1.test_id=t2.id
		where t2.id='$test_number'
		order by question_order desc"; 

		$result = @mysqli_query($connection,$sql) or die("$sql Error 1#". mysqli_errno($connection) . ": " . mysqli_error($connection));
		while($row=mysqli_fetch_assoc($result))
			{
			$edit_question[]=$row;
			}
// 	echo "58 edit_question<pre>"; print_r($edit_question[0]); echo "</pre>"; // exit;
		if(empty($edit_question))
			{
			$edit_question[0]['test_id']=$test_number;
			$sql = "SELECT t2.test_name
			FROM test_list as t2
			where t2.id='$test_number'
			"; 
			$result = @mysqli_query($connection,$sql) or die("$sql Error 1#". mysqli_errno($connection) . ": " . mysqli_error($connection));
			$row=mysqli_fetch_assoc($result);
			$edit_question[0]['test_name']=$row['test_name'];
			}
		$test_id=$edit_question[0]['test_id'];
		
// Top row
		echo "<form method='POST' action='test.php'>
		<table><tr><td colspan='2'><h3>Question for <font color='#8cd9b3'>". $edit_question[0]['test_name']."</font></h3></td>
		<td>
		<input type='hidden' name='page' value=\"edit_question\">
		<input type='hidden' name='test_number' value=\"$test_id\">
		<input type='hidden' name='list_questions' value=\"yes\">
		<input type='hidden' name='id' value=\"$test_id\">
		<input type='submit' name='submit_form' value=\"Add Question\">
		<a href='test.php?page=edit_question&test_number=$test_id&list_questions=yes&id=1'>Show Questions</a>
		</td></tr>";
		if(!empty($message)){echo "<tr><td><h3>$message</h3></td></tr>";}
		echo "</table></form>";
		
		$skip_fld=array("qid","test_id","test_name");
			if(!empty($qid))
			{
			if(!empty($submit_form))
				{
				if($submit_form=="Update")
					{
					include("update_question.php");
					}
				}
				

			$var_array=array("question_order");
			foreach($edit_question as $index=>$array)
				{
				if($array['qid']==$qid)
					{
					if($array['question_type']=="cross_match")
						{
						include("update_cross_match.php");
						}
						else
						{
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
					}
						}

				}
			exit;
			}
		if(!empty($submit_form))
			{
			if($submit_form=="Add Question")
				{
				include("add_question.php");
				}
			}
		if(!empty($list_questions))
			{
			if(empty($qid))
				{
				foreach($edit_question as $index=>$array)
					{
					echo "<table border='1'>";
					$line="";
					foreach($array as $fld=>$value)
						{
						if(in_array($fld, $skip_fld)){continue;}
						$var_fld=$rename_array[$fld];
						
						if($fld==strtolower($array['answer']))
							{$var_fld="<font color='magenta'>$rename_array[$fld]</font>";}
						$line.="<tr><td>$var_fld</td><td>$value</td></tr>";
						if($fld=="question_order")
							{	
							$line="<tr><td>$var_fld</td><td>
							$value <a href='test.php?qid=$array[qid]&page=edit_question&test_number=$array[test_id]'>Edit</a> Question
							</td></tr>";
							}
						}
					echo "$line";
					}
				echo "</table>";
				}
				

			}
		}
	}
?>