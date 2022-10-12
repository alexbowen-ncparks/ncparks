<?php
// echo "<pre>"; print_r($_SESSION); echo "</pre>"; // exit;
$sql="SELECT * from test_list"; 
$result = mysqli_query($connection,$sql) or die("$sql Error 1#". mysqli_errno($connection) . ": " . mysqli_error($connection));
while($row=mysqli_fetch_assoc($result))
	{
	$ARRAY[]=$row;
	}
// echo "<pre>"; print_r($ARRAY); echo "</pre>"; // exit;

$took_test=array();
if(!empty($_SESSION['dpr_tests']['tempID']))
	{
	$tempID=$_SESSION['dpr_tests']['tempID'];
	$sql="SELECT distinct test_id from completed_tests where tempID='$tempID'"; 
	$result = mysqli_query($connection,$sql) or die("$sql Error 1#". mysqli_errno($connection) . ": " . mysqli_error($connection));
	while($row=mysqli_fetch_assoc($result))
		{
		$took_test[]=$row['test_id'];
		}
// 	echo "<pre>"; print_r($took_test); echo "</pre>"; // exit;
	}
$skip=array("pid","test_quote","status");
$c=count($ARRAY);
echo "<table cellpadding='20'><tr><td colspan='6'>Number of Tests: $c</td></tr>";
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
			if(in_array($id, $took_test)){echo "<td>$value - Completed</td>";continue;}
			if($level<6)
				{
				if($id<2)
					{
					// just show test name - no link
					}
					else
					{
					$value="<a href='test.php?take=1&page=test&test_id=$id'>$value</a>";
					}
				}
				else
				{
				$value="<a href='test.php?page=test&test_id=$id'>$value</a>";
				}
			}
		echo "<td>$value</td>";
		}
	echo "</tr>";
	}
echo "</table>";
?>