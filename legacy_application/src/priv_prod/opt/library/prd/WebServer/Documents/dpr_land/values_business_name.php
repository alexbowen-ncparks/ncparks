<?php

$sql="SELECT t1.*
from business_name as t1
 WHERE 1"; //ECHO "$sql"; //exit;
$result = mysqli_query($connection,$sql) or die("$sql Error 1#". mysqli_errno($connection) . ": " . mysqli_error($connection));
while($row=mysqli_fetch_assoc($result))
	{
$business_name_array[$row['business_name_id']]=$row['business_name'];
	}

?>