<?php
// echo "2 add_question.php<pre>"; print_r($_POST); echo "</pre>"; //exit;
ini_set('display_errors',1);
date_default_timezone_set('America/New_York');
// echo "<pre>"; print_r($_POST); echo "</pre>"; // exit;
if(empty($connection))
	{
	$database="dpr_tests"; 
	$dbName="dpr_tests";

	include("../../include/iConnect.inc"); // include iConnect.inc with includes no_inject.php
	mysqli_select_db($connection,$dbName);
	}
	
if(!empty($submit_form))
	{

	$skip=array("submit_form", "qid");
	$upper=array("answer");
	echo "21 s=$submit_form<pre>"; print_r($_POST); echo "</pre>";  //exit;
	FOREACH($_POST as $fld=>$value)
		{
		if(in_array($fld,$skip)){continue;}
		
		if(in_array($fld,$upper))
			{
			$value=strtoupper($value);
			}
				
		$temp[]="`".$fld."`='".$value."'";
	
		}
	$clause=implode(", ",$temp);

	$sql="INSERT INTO questions set $clause "; 
// 	echo "$sql"; exit;
	$result = mysqli_query($connection,$sql) or die("$sql Error 1#". mysqli_errno($connection) . ": " . mysqli_error($connection));
	if($result)
		{
		$location=$_POST['location'];
		header("Location: questions.php?test_id=$test_id");
		exit;
		}
	}

// ****************** Edit Question ***************

$rename_array=array("qid"=>"","question_order"=>"Question Order","question"=>"Question","a"=>"A","b"=>"B","c"=>"C","d"=>"D","answer"=>"Answer","comment"=>"Comment");
$text_array=array("test_quote","overview");

if(!empty($select_question))
	{
	include("_base_top.php");
$sql = "SELECT t1.* , t2.test_name
FROM questions as t1 
left join test_list as t2 on t1.test_id=t2.id
where t1.qid='$qid'"; 
echo "58 $sql"; //exit;
$result = @mysqli_query($connection,$sql) or die("$sql Error 1#". mysqli_errno($connection) . ": " . mysqli_error($connection));
while($row=mysqli_fetch_assoc($result))
	{
	$edit_question[]=$row;
	}
	
$skip=array("qid","test_id", "test_name");

$non_text_array=array("question_order","answer");
$c=count($edit_question);

// echo "<pre>"; print_r($edit_question); echo "</pre>"; // exit;
$test_id=$edit_question[0]['test_id'];
echo "<form method='POST' action='questions.php'>
<table><tr><td colspan='2'><h3><font color='#8cd9b3'>Question for ". $edit_question[0]['test_name']."</font></h3></td>
<td>
<input type='hidden' name='id' value=\"$test_id\">
<input type='hidden' name='select_table' value=\"test_list\">
<input type='submit' name='submit_form' value=\"Questions\">
</td></tr>";
if(!empty($message)){echo "<tr><td><h3>$message</h3></td></tr>";}
echo "</table></form>";

echo "<form method='POST' action='add_question.php'><table>";
foreach($edit_question AS $index=>$array)
	{

	foreach($array as $fld=>$value)
		{
		if(in_array($fld,$skip)){continue;}
	echo "<tr><td>";
	$var=$rename_array[$fld];	
	if($fld==strtolower($array['answer']))
		{$var="<font color='magenta'>$rename_array[$fld]</font>";}
	echo "$var</td>";
		if(in_array($fld,$skip)){continue;}
		$td="";
		if(!in_array($fld,$non_text_array))
			{
			$value="<textarea name='$fld' cols='100' rows='3'>$value</textarea>";
			}
			else
			{
			$value="<input type='text' name='$fld' value=\"$value\" size='3'>";
			}
		
		echo "<td>$value</td>";
	echo "</tr>";
		}
	}
echo "<tr><td>
<input type='hidden' name='test_id' value=\"$test_id\">
<input type='hidden' name='qid' value=\"$qid\">
<input type='submit' name='submit_form' value=\"Update\">
</td></tr>";
echo "</table></form>";
exit;
	}

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

echo "<pre>"; print_r($_REQUEST); echo "</pre>"; // exit;
echo "<form method='POST' action='add_question.php'>";
echo "<table><tr><td colspan='2'><h3>
<font color='#8cd9b3'>New Question #".($c+1)." for $test_name</font></h3>
</td></tr>";

echo "<table>";
foreach($test_questions[0] AS $fld=>$val)
	{
	if(in_array($fld,$skip)){continue;}
	echo "<tr><td>$rename_array[$fld]</td>";
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
echo "</table></form></html>";
?>
