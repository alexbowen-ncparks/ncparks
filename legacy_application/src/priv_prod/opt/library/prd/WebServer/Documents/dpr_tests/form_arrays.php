<?php

$search_array=${"search_".$select_table."_dropdown"};
// echo "s=$search_array";
foreach($search_array as $index=>$fld)
	{
	$var_array=array();
	$sql = "SELECT distinct $fld from $select_table order by $fld"; 
	if($select_table=="gateways" and $fld=="vlan")
		{
		$sql = "SELECT distinct 
		if(left(`vlan`,4)='vlan', concat($fld, '-', `location`), $fld ) as $fld 
		from $select_table order by $fld"; 
		}

	$result = @mysqli_query($connection,$sql) or die("$sql");
	while($row=mysqli_fetch_assoc($result))
		{
		$var_array[]=$row[$fld];
		}
	${"ARRAY_".$fld}=$var_array;
	}
// if($select_table=="subnets"){
// echo "<pre>"; print_r($search_array); echo "</pre>"; // exit;
// echo "<pre>"; print_r($ARRAY_location); echo "</pre>"; // exit;
// }
	

?>