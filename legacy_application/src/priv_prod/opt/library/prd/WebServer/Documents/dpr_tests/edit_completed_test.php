<?php
// echo "<pre>"; print_r($_SESSION); echo "</pre>"; // exit;
$tempID=$_SESSION[$dbName]['tempID'];

$answer_array=array("a","b","c","d","e");
$true_false_array=array("T","F");

$option_array_question_7=array("a" => "Survivable without a fire shelter.","b" => "Keep at least 100 gallons of water in reserve.","c" => "Fireline will not lie in or adjacent to a chute or chimney.","d" => "Assess defensible space, i.e., surrounding wildland vegetation.");
$option_array_question_12=array("a" => "Direct/Indirect","b" => "Direct/Indirect","c" => "Direct/Indirect","d" => "Direct/Indirect");

// $test_date="2020-09-11";
$test_date=date("Y-m-d");
if(empty($tempID))
	{extract($_REQUEST);}
	
$sql = "SELECT t1.question_order, t3.question, t3.a, t3.b, t3.c, t3.d, t3.e, t2.test_name, t1.full_name, t1.test_date, t3.question_type, t1.answer
FROM completed_tests as t1 
left join test_list as t2 on t1.test_id=t2.id
left join questions as t3 on t1.question_order=t3.question_order
where t1.tempID='$tempID' and t2.id='$test_id' and test_date='$test_date' and t1.question_order>0
order by t1.question_order"; 
// echo "$sql";
$result = @mysqli_query($connection,$sql) or die("19 $sql Error 1#". mysqli_errno($connection) . ": " . mysqli_error($connection));
while($row=mysqli_fetch_assoc($result))
	{
	$ARRAY[$row['question_order']]=$row;
	}
// echo "<pre>"; print_r($ARRAY); echo "</pre>"; // exit;	
	$answer_array=array("a","b","c","d","e");
	
$test_name=$ARRAY[1]['test_name'];
$full_name=$ARRAY[1]['full_name'];
$test_date=$ARRAY[1]['test_date'];
$skip=array("id","tempID","test_name","test_id","full_name","test_date","question_type");
$c=count($ARRAY);
echo "<table border='1'><tr><th colspan='7'><font color='browm'>$c Questions for $test_name ==>
$full_name $test_date</font></th></tr>
";

echo "<tr><td colspan='4'><font color='blue'>Review your answers and make any change by clicking Edit.</font></td><th colspan='3'>When done, click <a href='test_complete.php?tempID=$tempID&test_id=$test_id&test_date=$test_date'>Completed</a> to save the test.</th>
</tr>";
foreach($ARRAY AS $index=>$array)
	{
	if($index==1)
		{
		echo "<tr>";
		foreach($ARRAY[1] AS $fld=>$value)
			{
			if(in_array($fld,$skip)){continue;}
			$var_fld=str_replace("_"," ",$fld);
			if($fld=="answer"){$var_fld="Your Answer";}
			echo "<th>$var_fld</th>";
			}
		echo "</tr>";
		}
	echo "<tr valign='top'>";
	foreach($array as $fld=>$value)
		{
		if(in_array($fld,$skip)){continue;}
		if($fld=="e" and empty($value)){$fld="";}
		if($fld=="question_order")
			{
			$value="<a href='test.php?page=test&com=1&take=1&pass_tempID=$tempID&test_id=$test_id&$fld=$value'>Edit $value</a>";
			}
		if($fld=="question")
			{
			$value="<font color='brown'>$value</font>";
			}
		if($fld=="answer")
			{
			$value="<font color='#009933'>".strtoupper($value)."</font>";
			}

		if($array['question_type']=="multiple_choice" and in_array($fld, $answer_array))
			{
			$f=""; $f1="";
			if($array['answer']==$fld){$f="<font color='#006699'>";$f1="</font>";}
			$value="$f".strtoupper($fld).". ".$value."$f1";
			}
		if($array['question_type']=="checkbox")
			{
			$checkbox_answers=explode(",", $ARRAY[$index]['answer']);
			if(in_array($fld, $answer_array))
				{
// 			echo "<pre>"; print_r($checkbox_answers); echo "</pre>"; // exit;
				$f=""; $f1="";
				if(in_array($fld, $checkbox_answers)){$f="<font color='#006699'>";$f1="</font>";}
				$value="$f".strtoupper($fld).". ".$value."$f1";
				}
			}
		
		if($fld=="a" and $array['question_type']=="true_false")
			{
			if($array['answer']=="T")
				{$value="<font color='#006699'>T</font> or F";}
				else
				{
				{$value="T or <font color='#006699'>F</font>";}
				}
			}
		if($array['question_type']=="cross_match")
			{
			if($index==7)
				{
				if($fld=="a")
					{
					$expA=explode("|",$array['a']);
					$expB=explode("|",$array['b']);
					$expC=explode("|",$array['c']);
					$expD=explode("|",$array['d']);
				
					$value="List:<br />A. ".$expA[0];
					$value.="<br /><br /><br />B. ".$expB[0];
					$value.="<br /><br /><br /><br /><br />C. ".$expC[0];
					$value.="<br /><br /><br /><br /><br />D. ".$expD[0];
					}
				if($fld=="b")
					{
					$value="Procedure:<br />";
					foreach($option_array_question_7 as $k=>$v)
						{
						$value.="__".$v."<br /><br />";
						}
					}
				if($fld=="c" or $fld=="d")
					{
					$value="";
					}
				}
			if($index==12)
				{
				if(in_array($fld, $answer_array))
					{
					$exp=explode("|",$array[$fld]);
					$value=$exp[0]."<br /><br />Direct or Indirect";
					}
				}
			}
		echo "<td>$value</td>";
		}
	echo "</tr>";
	}
echo "</table>";

?>