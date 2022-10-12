<?php
ini_set('display_errors',1);
$database="system_plan";
include("../../include/iConnect.inc"); // database connection parameters
//echo "c1=$connection";//exit;

$sql="select * from fac_inventory_2015 where id=1";
$result = @MYSQLI_QUERY($connection,$sql);	
	while($row=mysqli_fetch_assoc($result))
		{
		$ARRAY_1=$row;
		}
array_shift($ARRAY_1);
array_shift($ARRAY_1);
// echo "<pre>"; print_r($ARRAY_1); echo "</pre>"; // exit;

foreach($ARRAY_1 as $k=>$v)
	{
	$v=ucwords(strtolower($v));
	$sql="ALTER TABLE `fac_inventory_2015` CHANGE `$k` `$v` TEXT CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL";
// 	echo "$sql"; exit;
$result = @MYSQLI_QUERY($connection,$sql);	
}
// ALTER TABLE `fac_inventory_2015` CHANGE `b` `Visitor Center` TEXT CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL
?>