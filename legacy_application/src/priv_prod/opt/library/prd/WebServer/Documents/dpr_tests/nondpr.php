<?php
if(!empty($update))
	{
// 	echo "<pre>"; print_r($_REQUEST); echo "</pre>";  exit;
	$sql1 = "SELECT *
	From nondpr_list
	WHERE test_id='$test_id'";
	$result = @mysqli_query($connection,$sql1) or die("Error #". $sql1);
	while($row=mysqli_fetch_assoc($result))
		{
		$ARRAY_nondpr[]=$row;
		}
// echo "<pre>"; print_r($ARRAY_nondpr); echo "</pre>";  exit;
	mysqli_select_db($connection,"divper");

	foreach($ARRAY_nondpr as $index=>$array)
		{
		extract($array);
		$sql = "UPDATE divper.nondpr
		set dpr_tests='$allow', inspect='$allow'
		WHERE Fname='$Fname' and Lname='$Lname'";
		// 	echo "$sql"; exit;
		$result = @mysqli_query($connection,$sql) or die("Error #". $sql);
		}
	echo "Status for $test_id was set to $allow.";
	exit;
	}
if(empty($test_id))
	{
	echo "<form action='test.php?page=nondpr'>
	<input type='text' name='test_id' value=\"\">
	Enter Test ID: 1, 2, 3, etc. Do this for each test for the person.
	<input type='hidden' name='page' value=\"nondpr\">
	<input type='submit' name='submit_form' value=\"Submit\">
	</form>";
	exit;
	}
$sql1 = "SELECT *
	From nondpr_list
	WHERE test_id='$test_id'
	order by Lname";
	$result = @mysqli_query($connection,$sql1) or die("Error #". $sql1);
	while($row=mysqli_fetch_assoc($result))
		{
		$ARRAY_nondpr[]=$row;
		}
	if(!empty($ARRAY_nondpr))
		{
	$skip=array();
	$c=count($ARRAY_nondpr);
	echo "<table><tr><td>$c</td></tr>";
		foreach($ARRAY_nondpr AS $index=>$array)
			{
			if($index==0)
				{
				echo "<tr>";
				foreach($ARRAY_nondpr[0] AS $fld=>$value)
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
				echo "<td>$value</td>";
				}
			echo "</tr>";
			}
		echo "</table>";
		}
		
echo "<form action='test.php?page=nondpr'>
<input type='hidden' name='page' value=\"nondpr\">
<input type='hidden' name='test_id' value=\"$test_id\">
<input type='hidden' name='show_list' value=\"x\">
<input type='submit' name='submit_form' value=\"Show nonDPR List\">
</form>";	


echo "<form action='test.php?page=nondpr'>
<input type='text' name='test_id' value=\"$test_id\">
Test ID<br />
<input type='radio' name='allow' value=\"1\"> Allow
<input type='radio' name='allow' value=\"0\"> Don't Allow

<input type='hidden' name='page' value=\"nondpr\">
<input type='hidden' name='test_id' value=\"$test_id\">
<input type='submit' name='update' value=\"Test Status\">
</form>";
	
if(!empty($show_list))
	{
	$sql1 = "SELECT *
	From nondpr_list
	WHERE test_id='$test_id'";
	$result = @mysqli_query($connection,$sql1) or die("Error #". $sql1);
	while($row=mysqli_fetch_assoc($result))
		{
		$ARRAY_nondpr[]=$row;
		}
		$skip=array();
	$c=count($ARRAY_nondpr);
	echo "<table><tr><td>$c</td></tr>";
	foreach($ARRAY_nondpr AS $index=>$array)
		{
		if($index==0)
			{
			echo "<tr>";
			foreach($ARRAY_nondpr[0] AS $fld=>$value)
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
			echo "<td>$value</td>";
			}
		echo "</tr>";
		}
		echo "</table>";
	}
if(empty($Lname))
	{
	echo "<form action='test.php?page=nondpr'>
	<input type='text' name='Fname' value=\"\">
	Fname<br />
	<input type='text' name='Lname' value=\"\">
	Lname
	<input type='hidden' name='page' value=\"nondpr\">
	<input type='hidden' name='test_id' value=\"$test_id\">
	<input type='submit' name='submit_form' value=\"Add\">
	</form>";
	
	exit;
	}
	else
	{
	$sql = "INSERT INTO nondpr_list
	set Fname='$Fname', Lname='$Lname', test_id='$test_id'";
// 	echo "$sql"; exit;
	$result = @mysqli_query($connection,$sql) or die("Error #". $sql);
	
	echo "<form action='test.php?page=nondpr'>
	<input type='text' name='Fname' value=\"\">
	Fname<br />
	<input type='text' name='Lname' value=\"\">
	Lname
	<input type='hidden' name='page' value=\"nondpr\">
	<input type='hidden' name='test_id' value=\"$test_id\">
	<input type='submit' name='submit_form' value=\"Add\">
	</form>";
	
	
	exit;
	}
	
?>