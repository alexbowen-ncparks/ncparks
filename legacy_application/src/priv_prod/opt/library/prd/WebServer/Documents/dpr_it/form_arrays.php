<?php

$search_array=${"search_".$select_table."_dropdown"};
// $add_to_dropdown=array("WAHO_I");
$add_to_dropdown=array();

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
	if($select_table=="subnets" and $fld=="location")
		{
		$sql = "SELECT distinct 
		concat(location,' * ', site_name) as $fld 
		from $select_table order by $fld"; 
		}
	$result = @mysqli_query($connection,$sql) or die("$sql");
	
// 	echo "$sql<br />";
	
	while($row=mysqli_fetch_assoc($result))
		{
		$var_array[]=$row[$fld];
		}
	foreach($add_to_dropdown as $k=>$v)
		{
		if(!in_array($v,$var_array)){$var_array[]=$v;}
		}
		
	${"ARRAY_".$fld}=$var_array;
	}
// if($select_table=="subnets"){
// echo "<pre>"; print_r($search_array); echo "</pre>"; // exit;
// echo "$select_table <pre>"; print_r($ARRAY_location); echo "</pre>"; // exit;
// }
	

?>