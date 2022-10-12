<?php

// $search_array=$search_computers_dropdown;
$search_array=${"search_".$select_table."_dropdown"};


foreach($search_array as $index=>$fld)
	{
	$var_array=array();
	$sql = "SELECT distinct $fld from $select_table order by $fld"; 
	$result = @mysqli_query($connection,$sql) or die(" $sql".mysqli_error($connection));
	while($row=mysqli_fetch_assoc($result))
		{
		$var_array[]=$row[$fld];
		}
	${"ARRAY_".$fld}=$var_array;
	}

?>