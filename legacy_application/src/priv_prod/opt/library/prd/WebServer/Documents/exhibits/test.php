<?php
ini_set('display_errors', 1);
$db="mns";
include("../../include/connect_mysqli.inc"); // database connection parameters

$sql="SELECT * FROM location";
$result = mysqli_query($connection_i, $sql);
while($row=mysqli_fetch_assoc($result))
				{$check_array[]=$row['exhibit_area'];}
echo "test<pre>"; print_r($check_array); echo "</pre>"; // exit;

mysqli_free_result($result);
mysqli_close($connection_i);
?>