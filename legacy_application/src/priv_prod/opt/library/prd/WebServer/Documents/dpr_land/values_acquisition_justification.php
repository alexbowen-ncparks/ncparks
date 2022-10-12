<?php

$sql="SELECT t1.*
from acquisition_justification as t1
 WHERE 1"; //ECHO "$sql"; //exit;
$result = mysqli_query($connection,$sql) or die("$sql Error 1#". mysqli_errno($connection) . ": " . mysqli_error($connection));
while($row=mysqli_fetch_assoc($result))
	{
$acquisition_justification_array[$row['acquisition_justification_id']]=$row['acquisition_justification'];
	}
// echo "acquisition_justification_array <pre>"; print_r($acquisition_justification_array); echo "</pre>"; // exit;

$readonly_array[]="acquisition_justification_id";
?>