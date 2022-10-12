<?php
$sql="SHOW columns from $pass_table";
$result = mysqli_query($connection, $sql) or die ("Couldn't execute select query. $sql ".mysql_error($connection));
while($row=mysqli_fetch_assoc($result))
	{
	$fld_array[]=$row['Field'];
	}
//echo "<pre>"; print_r($fld_array); echo "</pre>"; // exit;
?>