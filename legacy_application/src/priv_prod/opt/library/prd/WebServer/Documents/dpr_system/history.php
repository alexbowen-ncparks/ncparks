<?php
//extract($_REQUEST);
$sql = "SELECT `Park History`
FROM dpr_system.`gov_2015` 
where park_code='$park_code'
";
//echo "$sql"; //exit;

$result = mysqli_query($connection,$sql) or die ("Couldn't execute query 1. $sql ".mysqli_error($connection));
while ($row=mysqli_fetch_assoc($result))
	{
	@$park_history[$park_code]=$row['Park History'];
	}
	
?>