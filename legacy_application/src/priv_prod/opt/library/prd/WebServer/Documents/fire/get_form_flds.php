<?php
	
$sql="SHOW COLUMNS FROM contract_park";
$result = mysqli_query($connection,$sql) or die ("Couldn't execute select query. $sql ".mysqli_error($connection));
while($row=mysqli_fetch_assoc($result))
	{
	$t1_array[]="t1.`".$row['Field']."`";
	$f1_array[]=$row['Field'];
	}
// echo "<pre>"; print_r($t1_array); echo "</pre>";  //exit;
$sql="SHOW COLUMNS FROM contract_uploads";
$result = mysqli_query($connection,$sql) or die ("Couldn't execute select query. $sql ".mysqli_error($connection));
while($row=mysqli_fetch_assoc($result))
	{
	if($row['Field']=="park_code"){continue;} // needed to prevent a blank park_code when no documents exist for that park
	$t2_array[]="t2.`".$row['Field']."`";
	}
// echo "<pre>"; print_r($t2_array); echo "</pre>";  //exit;

$t1_flds=implode(",",$t1_array);
$t2_flds=implode(",",$t2_array);

?>