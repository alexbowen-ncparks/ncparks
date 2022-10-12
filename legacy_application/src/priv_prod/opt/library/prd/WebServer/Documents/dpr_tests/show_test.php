<?php
// 	echo "$level";
$rename_array=array("qid"=>"","question_order"=>"Question Order","question"=>"Question","a"=>"A","b"=>"B","c"=>"C","d"=>"D","answer"=>"Answer","comment"=>"Comment");

if(!empty($test_id))
	{
// 	echo "<pre>"; print_r($_SESSION); echo "</pre>";  exit;
	$tempID=$_SESSION[$dbName]['tempID'];
	$_SESSION[$dbName]['test_id']=$test_id;
	
	$sql = "SELECT t1.* , t2.test_name
	FROM questions as t1 
	left join test_list as t2 on t1.test_id=t2.id
	where t2.id='$test_id'"; 
	$result = @mysqli_query($connection,$sql) or die("$sql Error 1#". mysqli_errno($connection) . ": " . mysqli_error($connection));
	while($row=mysqli_fetch_assoc($result))
		{
		$ARRAY[]=$row;
		}
		
	$sql = "SELECT * from completed_tests
	where test_id='$test_id' and tempID='$tempID'"; 
	$result = @mysqli_query($connection,$sql) or die("$sql Error 1#". mysqli_errno($connection) . ": " . mysqli_error($connection));
	if(mysqli_num_rows($result)>0)
		{
		echo "You have already submitted answers for this test: ".$ARRAY[0]['test_name'];
		echo "<br /><br />Contact Thomas Crate if you need to re-take the test.";
		exit;
		}
		else
		{
		$_SESSION[$dbName]['test_name']=$ARRAY[0]['test_name'];
		}
	
	$skip=array("qid","test_id","test_quote","test_name");

$c=count($ARRAY);
$_SESSION[$dbName]['num_questions']=$c;
if($level>4)
	{
	$take_test="<th><a href='test.php?page=test&test_id=$test_id&take=1'>Take Test</a></th>";
	}
	else
	{
// 	$take_test="<th><a href='test.php?page=test&test=$test&take=1'>Take Test</a></th>";
	}
	
$show_array=array("question_order","question","a","b","c","d","");
echo "<table><tr><th colspan='8'>".$ARRAY[0]['test_name']." has $c questions.</th>$take_test</tr>";
foreach($ARRAY AS $index=>$array)
	{
	if($index==0)
		{
		echo "<tr>";
		foreach($ARRAY[0] AS $fld=>$value)
			{
			if($level<6 and !in_array($fld,$show_array)){continue;}
			$var_fld=$fld;
			if($fld=="question_order"){$var_fld="";}
			echo "<th>$var_fld</th>";
			}
		echo "</tr>";
		}
	echo "<tr valign='top'>";
	foreach($array as $fld=>$value)
		{
		if($level<5 and !in_array($fld,$show_array)){continue;}
		if($level>4 and $fld=="question_order")
			{
			$qid=$array['qid'];
			$value="<a href='test.php?qid=$qid&page=edit_question&test_number=$test_id'>$value</a>";
			}
			
		if($level<5)
			{
			$exp=explode("|",$value);
			$value=$exp[0];
			if(!empty($exp[1]))
				{
				if(strpos($exp[1], "*Direct")>0){$exp[1]="*Direct/Indirect";}
				if(strpos($exp[1], "*Indirect")>0){$exp[1]="*Direct/Indirect";}
				$value.="<br />".$exp[1];
				}
			}
		echo "<td>$value</td>";
		}
	echo "</tr>";
	}
	
}
	
	
	
	
?>