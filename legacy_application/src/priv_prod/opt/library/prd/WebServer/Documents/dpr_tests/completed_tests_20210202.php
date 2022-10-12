<?php
// echo "<pre>"; print_r($_REQUEST); echo "</pre>"; // exit;
$database="dpr_tests"; 
$dbName="dpr_tests";
include("_base_top.php");


ini_set('display_errors',1);
date_default_timezone_set('America/New_York');
include("../../include/iConnect.inc"); // include iConnect.inc with includes no_inject.php
mysqli_select_db($connection,$dbName);
if(empty($test_id) and empty($tempID))
	{
	$sql="SELECT distinct t2.test_id, t1.test_name
	FROM test_list as t1
	left join completed_tests as t2 on t2.test_id=t1.id
	left join scores as t3 on t3.test_id=t1.id
	where t3.scored_yes='yes'
	order by t2.test_id
	";
	$result = @mysqli_query($connection,$sql) or die("$sql Error 1#". mysqli_errno($connection) . ": " . mysqli_error($connection));
	if(mysqli_num_rows($result)<1)
		{
		echo "All tests have been scored.";
		echo "<br /><br />To view completed tests click <a href='completed_tests.php'>here</a>.";
		exit;
		}
	while($row=mysqli_fetch_assoc($result))
			{$ARRAY[]=$row;}
	$skip=array();
	$c=count($ARRAY);
	echo "<table><tr><td>$c</td></tr>";
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
			if($fld=="test_id"){$value="<a href='completed_tests.php?$fld=$value'>View test</a>";}
			echo "<td>$value</td>";
			}
		echo "</tr>";
		}
	echo "</table>";
	exit;
	}
if(!empty($test_id) and empty($view))
	{
	$sql="SELECT t2.full_name, t2.test_date, t1.test_name, t3.test_id, t2.tempID
	FROM test_list as t1
	left join completed_tests as t2 on t2.test_id=t1.id
	left join scores as t3 on t3.test_id=t1.id and t3.tempID=t2.tempID
	where t3.scored_yes='yes' and t2.test_id='$test_id'
	group by t2.tempID
	";
	$result = @mysqli_query($connection,$sql) or die("$sql Error 1#". mysqli_errno($connection) . ": " . mysqli_error($connection));
	if(mysqli_num_rows($result)<1)
		{
		echo "All tests have been scored.";
		echo "<br /><br />To view completed tests click <a href='completed_tests.php'>here</a>.";
		exit;
		}
	while($row=mysqli_fetch_assoc($result))
			{$ARRAY[]=$row;}
			
	$skip=array("test_name","tempID");
	$c=count($ARRAY);
	echo "<table><tr><td colspan='5'>$c completed tests for ".$ARRAY[0]['test_name']."</td></tr>";
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
			$test_date=$array['test_date'];
			$tempID=$array['tempID'];
			$link="view=1&test_date=$test_date&tempID=$tempID&$fld=$value";
			if($fld=="test_id"){$value="<a href='completed_tests.php?$link'>View test</a>";}
			echo "<td>$value</td>";
			}
		echo "</tr>";
		}
	echo "</table>";	
	}

if(!empty($view))
	{
// 	echo "<pre>"; print_r($_REQUEST); echo "</pre>"; // exit;
// 	echo "Being developed."; exit;
// 	$sql="SELECT t2.full_name, t2.test_date, t1.test_name, t3.*, t2.tempID
// 	FROM test_list as t1
// 	left join completed_tests as t2 on t2.test_id=t1.id
// 	left join scores as t3 on t3.test_id=t1.id and t3.tempID=t2.tempID
// 	where t3.scored_yes='yes' and t2.test_id='$test_id' and t2.test_date='$test_date' and t2.tempID='$tempID'
// 	order by t3.question_order
// 	";
	$sql="SELECT t1.*, t2.full_name, t3.test_name, t4.question, t2.answer as answer_given, t4.answer
	FROM scores as t1
	left join completed_tests as t2 on t2.test_id=t1.test_id and t2.tempID=t1.tempID and t2.test_id=t1.test_id and t2.question_order=t1.question_order
	left join test_list as t3 on t2.test_id=t3.id 
	left join questions as t4 on t4.test_id=t3.id and t4.question_order=t1.question_order
	where t1.scored_yes='yes' and t2.test_id='$test_id' and t2.test_date='$test_date' and t1.tempID='$tempID'
	group by t1.question_order
	order by t1.question_order
	";
// 	echo "$sql";
	$result = @mysqli_query($connection,$sql) or die("$sql Error 1#". mysqli_errno($connection) . ": " . mysqli_error($connection));
	while($row=mysqli_fetch_assoc($result))
			{$ARRAY[]=$row;}
	$skip=array("sid","test_id","scored_yes","full_name","test_date","test_name","tempID");
	$c=count($ARRAY);
	echo "<table border='1' cellpadding='3'><tr><td colspan='10'>".$ARRAY[0]['full_name']." <strong>".$ARRAY[0]['test_name']."</strong> $test_date</td></tr>";
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
		echo "<tr style='vertical-align:top'>";
		foreach($array as $fld=>$value)
			{
			if(in_array($fld,$skip)){continue;}
			echo "<td>$value</td>";
			}
		echo "</tr>";
		}
	echo "</table>";

	}

?>